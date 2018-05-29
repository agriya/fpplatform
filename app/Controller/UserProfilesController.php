<?php
/**
 * FP Platform
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    FPPlatform
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class UserProfilesController extends AppController
{
    public $name = 'UserProfiles';
    public $uses = array(
        'UserProfile',
        'Attachment',
        'EmailTemplate'
    );
    public $components = array(
        'Email'
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'UserAvatar.filename',
            'UserProfile.latitude',
            'UserProfile.longitude',
            'UserProfile.zoom_level',
			'User.user_avatar_source_id'
        );
        parent::beforeFilter();
    }
    function edit($user_id = null)
    {
        $this->pageTitle = __l('Edit Profile');
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id',
                            'UserProfile.full_name',
                            'UserProfile.mobile_phone',
                            'UserProfile.contact_address'
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                $this->request->data['UserProfile']['id'] = $user['UserProfile']['id'];
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }
            $this->request->data['UserProfile']['user_id'] = $this->request->data['User']['id'];
            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }
            $this->UserProfile->set($this->request->data);
            $this->UserProfile->User->set($this->request->data);
            $ini_upload_error = 1;
            if ($this->request->data['UserAvatar']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            if ($this->UserProfile->User->validates() &$this->UserProfile->validates() &$this->UserProfile->User->UserAvatar->validates() && $ini_upload_error) {
                if ($this->UserProfile->save($this->request->data)) {
                    $this->UserProfile->User->save($this->request->data['User']);
                    if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                        $this->Attachment->save($this->request->data['UserAvatar']);
                    }
                    $this->Session->setFlash(__l('User Profile has been updated') , 'default', null, 'success');
                    if ($this->Auth->user('role_id') == ConstUserTypes::Admin and $this->Auth->user('id') != $this->request->data['User']['id'] and Configure::read('user.is_mail_to_user_for_profile_edit')) {
                        // Send mail to user to activate the account and send account details
                        $emailFindReplace = array(
                            '##USERNAME##' => $user['User']['username'],
                            '##SITE_NAME##' => Configure::read('site.name') ,
                        );
						App::import('Model', 'EmailTemplate');
						$this->EmailTemplate = new EmailTemplate();
						$email_template = $this->EmailTemplate->selectTemplate('Admin User Edit');
						$this->UserProfile->User->_sendEmail($email_template, $emailFindReplace, $this->User->formatToAddress($user));
                    }
                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                        '_trackEvent' => array(
                            'category' => 'UserProfile',
                            'action' => 'Updated',
                            'label' => $this->Auth->user('username') ,
                            'value' => '',
                        ) ,
                        '_setCustomVar' => array(
                            'ud' => $this->Auth->user('id') ,
                            'rud' => $this->Auth->user('referred_by_user_id') ,
                        )
                    ));
                }
            } else {
                if ($this->request->data['UserAvatar']['filename']['error'] == 1) {
                    $this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                }
                $this->Session->setFlash(__l('User Profile could not be updated. Please, try again.') , 'default', null, 'error');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id',
                            'UserProfile.full_name',
                            'UserProfile.mobile_phone',
                            'UserProfile.contact_address'
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 1
            ));            
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['UserAvatar'] = $user['UserAvatar'];
            }
        } else {
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
            $this->request->data = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                ) ,                
                'contain' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.full_name',
                            'UserProfile.mobile_phone',
                            'UserProfile.contact_address',
                            'UserProfile.about_me',
                            'UserProfile.latitude',
                            'UserProfile.longitude',
                            'UserProfile.zoom_level',
                        )
                    ) ,
                ) ,
                'recursive' => 2
            ));
            if (isPluginEnabled('SecurityQuestions')) {
                $this->loadModel('SecurityQuestions.SecurityQuestion');
                $securityQuestions = $this->SecurityQuestion->find('list', array(
                    'conditions' => array(
                        'SecurityQuestion.is_active' => 1
                    )
                ));
                $this->set(compact('securityQuestions'));
            }
        }
    }
    public function profile_image($user_id = null)
    {
        $this->pageTitle = sprintf(__l('%s Image') , __l('Profile'));
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || !empty($this->request->data['s3_file_url']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }
            $this->UserProfile->User->set($this->request->data);
            $ini_upload_error = 1;
            if ($this->request->data['UserAvatar']['filename']['error'] == 1 && empty($this->request->data['s3_file_url'])) {
                $ini_upload_error = 0;
            }
            if ($this->UserProfile->User->validates() && $this->UserProfile->User->UserAvatar->validates() && $ini_upload_error) {
                $this->UserProfile->User->save($this->request->data['User']);
                if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                    $this->Attachment->create();
                    $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                    $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                    $this->Attachment->save($this->request->data['UserAvatar']);
                }
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Profile Image')) , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'user_profiles',
                    'action' => 'profile_image',
                    $this->request->data['User']['id']
                ));
            } else {
                if ($this->request->data['UserAvatar']['filename']['error'] == 1) {
                    $this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                }
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Profile Image')) , 'default', null, 'error');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['UserAvatar'] = $user['UserAvatar'];
            }
        } else {
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $user_id = $this->Auth->user('id');
            } else {
                $user_id = $user_id ? $user_id : $this->Auth->user('id');
            }
            $this->request->data = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                ) ,
                'contain' => array(
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
        }
        $this->pageTitle.= ' - ' . $this->request->data['User']['username'];
    }
    function admin_edit($id = null)
    {
        if (is_null($id) && empty($this->request->data)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->setAction('edit', $id);
    }
}
?>