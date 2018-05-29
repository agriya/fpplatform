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
class SocialMarketingsController extends AppController
{
    public $name = 'SocialMarketings';
    public $components = array(
        'RequestHandler'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'publish',
            'import_friends',
        ) ,
    );
    public function import_friends()
    {
        $this->pageTitle = __l('Find Friends');
        $this->loadModel('User');
        $config = array(
            'base_url' => Router::url('/', true) . 'socialauth/',
            'providers' => array(
                'Facebook' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('facebook.app_id') ,
                        'secret' => Configure::read('facebook.secrect_key')
                    ) ,
                    'scope' => 'email, user_about_me, user_birthday, user_hometown',
                ) ,
                'Twitter' => array(
                    'enabled' => true,
                    'keys' => array(
                        'key' => Configure::read('twitter.consumer_key') ,
                        'secret' => Configure::read('twitter.consumer_secret')
                    ) ,
                ) ,
                'Google' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('google.consumer_key') ,
                        'secret' => Configure::read('google.consumer_secret')
                    ) ,
                ) ,
                'GooglePlus' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('googleplus.consumer_key') ,
                        'secret' => Configure::read('googleplus.consumer_secret')
                    ) ,
                ) ,
                'Yahoo' => array(
                    'enabled' => true,
                    'keys' => array(
                        'key' => Configure::read('yahoo.consumer_key') ,
                        'secret' => Configure::read('yahoo.consumer_secret')
                    ) ,
                ) ,
                'Linkedin' => array(
                    'enabled' => true,
                    'keys' => array(
                        'key' => Configure::read('linkedin.consumer_key') ,
                        'secret' => Configure::read('linkedin.consumer_secret')
                    ) ,
                ) ,
            )
        );
        if ($this->request->params['named']['type'] == 'facebook') {
            $this->pageTitle.= ' - Facebook';
            $next_action = 'twitter';
        } elseif ($this->request->params['named']['type'] == 'twitter') {
            $this->pageTitle.= ' - Twitter';
            $next_action = 'gmail';
            $this->User->updateAll(array(
                'User.is_skipped_fb' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        } elseif ($this->request->params['named']['type'] == 'gmail') {
            $this->pageTitle.= ' - Gmail';
            $next_action = 'yahoo';
            $this->User->updateAll(array(
                'User.is_skipped_twitter' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        } elseif ($this->request->params['named']['type'] == 'yahoo') {
            $this->pageTitle.= ' - Yahoo!';
            $this->User->updateAll(array(
                'User.is_skipped_google' => 1,
                'User.is_skipped_yahoo' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        }
        if (!empty($this->request->params['named']['import'])) {
            $options = array();
            if ($this->request->params['named']['import'] == 'openid') {
                $options = array(
                    'openid_identifier' => 'https://openid.stackexchange.com/'
                );
            }
            try {
                require_once (APP . DS . WEBROOT_DIR . DS . 'socialauth/Hybrid/Auth.php');
                $hybridauth = new Hybrid_Auth($config);
                if (!empty($this->request->params['named']['redirecting'])) {
                    $adapter = $hybridauth->authenticate(ucfirst($this->request->params['named']['import']) , $options);
                    $loggedin_contact = $social_profile = $adapter->getUserProfile();
                    $is_correct_user = $this->User->_checkConnection($social_profile, $this->request->params['named']['import']);
                    if ($is_correct_user) {
                        $this->User->updateSocialContact($social_profile, $this->request->params['named']['import']);
                        $social_contacts = $adapter->getUserContacts();
                        $this->SocialMarketing->import_contacts($social_contacts, $this->request->params['named']['import']);
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        if (!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'social') {
                            $this->Session->setFlash(sprintf(__l('You have connected %s successfully!') , $this->request->params['named']['import']) , 'default', null, 'success');
                        } elseif (empty($this->request->params['named']['from'])) {
                            $this->Session->setFlash(sprintf(__l('Your %s contact has been imported successfully!.') , $this->request->params['named']['import']) , 'default', null, 'success');
                        }
                        echo '<script>window.close();</script>';
                        exit;
                    } else {
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        $this->Session->setFlash(__l('This social network account already connected by other user.') , 'default', null, 'error');
                        echo '<script>window.close();</script>';
                        exit;
                    }
                } else {
                    $reditect = Router::url(array(
                        'controller' => 'social_marketings',
                        'action' => 'import_friends',
                        'type' => $this->request->params['named']['type'],
                        'import' => $this->request->params['named']['import'],
                        'redirecting' => $this->request->params['named']['import'],
                        'from' => !empty($this->request->params['named']['from']) ? $this->request->params['named']['from'] : '',
                    ) , true);
                    $this->layout = 'redirection';
                    $this->set('redirect_url', $reditect);
                    $this->set('authorize_name', ucfirst($this->request->params['named']['import']));
                    $this->render('authorize');
                }
            }
            catch(Exception $e) {
                $error = "";
                switch ($e->getCode()) {
                case 6:
                    $error = __l("User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.");
                    $this->Session->delete('HA::CONFIG');
                    $this->Session->delete('HA::STORE');
                    break;

                case 7:
                    $this->Session->delete('HA::CONFIG');
                    $this->Session->delete('HA::STORE');
                    $error = __l("User not connected to the provider.");
                    break;

                default:
                    $error = __l("Authentication failed. The user has canceled the authentication or the provider refused the connection");
                    break;
                }
                $this->Session->setFlash($error, 'default', null, 'error');
                echo '<script>window.close();</script>';
                exit;
            }
        }
        $this->set(compact('next_action'));
    }
    public function publish($id = null)
    {
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        App::import('Model', 'Requests.Request');
        $this->Request = new Request();
        $plugin = (!empty($this->request->params['named']['publish_name'])) ? $this->request->params['named']['publish_name'] : '';
        if ($plugin == "Job") {
            $names = "jobs";
        } else {
            $names = "requests";
        }
        $name = $plugin;
        if (empty($id) && $this->request->params['named']['from'] == 'job') {
            $job = $this->Job->find('first', array(
                'conditions' => array(
                    'Job.user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'Job.id'
                ) ,
                'order' => array(
                    'id' => 'desc'
                )
            ));
            $id = $job['Job']['id'];
        }
        $this->loadModel('User');
        if (empty($id) || empty($this->request->params['named']['type']) || empty($this->request->params['named']['publish_action'])) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'dashboard',
            ));
        }
        if ($this->request->params['named']['publish_action'] == 'add') {
            $condition[$name . '.id'] = $id;
            if ($plugin == "Job") {
                $job = $this->$name->find('first', array(
                    'conditions' => $condition,
                    'contain' => array(
                        'Attachment',
                        'User',
                    ) ,
                    'recursive' => 1
                ));
                if (!empty($job) && ($job['Job']['is_active'] != 1)) {
                    $this->Session->setFlash(__l('Sorry you can\'t share your') . " " . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ". " . __l('because your') . " " . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . " " . __l('has been Suspend') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'jobs',
                        'action' => 'manage',
                    ));
                }
                $image_options = array(
                    'dimension' => 'big_thumb',
                    'class' => '',
                    'alt' => $job[$name]['title'],
                    'title' => $job[$name]['title'],
                    'type' => 'png',
                    'full_url' => true
                );
                if (!empty($job['Attachment'])) {
                    $job_image = getImageUrl($name, $job['Attachment'][0], $image_options);
                } else {
                    $job_image = getImageUrl($name, array() , $image_options);;
                }
                $job['Job']['information'] = $job[$name]['title'];
            } else {
                $job = $this->$name->find('first', array(
                    'conditions' => $condition,
                    'contain' => array(
                        'User',
                    ) ,
                    'recursive' => 0
                ));
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $job['User']['id']
                    ) ,
                    'contain' => array(
                        'UserAvatar',
                    ) ,
                    'recursive' => 0
                ));
                $job['Job']['information'] = $job[$name]['name'];
                $job[$name]['title'] = $job[$name]['name'];
                $image_options = array(
                    'dimension' => 'big_thumb',
                    'class' => '',
                    'alt' => $user['User']['username'],
                    'title' => $user['User']['username'],
                    'type' => 'png',
                    'full_url' => true
                );
                if (!empty($user['UserAvatar'])) {
                    $job_image = getImageUrl('UserAvatar', $user['UserAvatar'], $image_options);
                } else {
                    $job_image = getImageUrl('UserAvatar', array() , $image_options);;
                }
            }
        }
        $job_url = Router::url(array(
            'controller' => $names,
            'action' => 'view',
            $job[$name]['slug'],
        ) , true);
        if ($this->request->params['named']['type'] == 'facebook') {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'id' => $this->Auth->user('id')
                ) ,
                'recursive' => - 1
            ));
            $next_action = 'twitter';
            $feed_url = 'https://www.facebook.com/dialog/feed?fb_app_id=' . Configure::read('facebook.app_id') . '&display=iframe&access_token=' . $user['User']['facebook_access_token'] . '&show_error=true&link=' . $job_url . '&name=' . urlencode($job['Job']['information']) . '&caption=' . urlencode($job['Job']['information']) . '&redirect_uri=' . Router::url('/', true) . 'social_marketings/publish_success/share/' . $id . '/' . $this->request->params['named']['publish_action'];
            $next_action = 'twitter';
        } elseif ($this->request->params['named']['type'] == 'twitter') {
            $next_action = 'others';
        } elseif ($this->request->params['named']['type'] == 'others') {
            $next_action = 'promote';
        }
        $this->pageTitle = $job[$name]['title'] . ' - ' . __l('Share');
        $this->set(compact('job_image', 'job_url', 'job', 'next_action', 'id'));
        $this->set('plugin_name', $name);
    }
    public function publish_success($current_page, $id = null, $action = null)
    {
        $this->set(compact('current_page', 'id', 'action'));
        $this->layout = 'ajax';
    }
    public function myconnections($social_type = null)
    {
        $this->pageTitle = __l('Social');
        if (!empty($social_type)) {
            $this->loadModel('User');
            $__data = array();
            $_data['User']['id'] = $this->Auth->user('id');
            $_data['User']['is_' . $social_type . '_connected'] = 0;
            $_data['User']['user_avatar_source_id'] = 0;
            $this->User->save($_data);
            $this->Session->setFlash(sprintf(__l('You have disconnected from %s') , $social_type) , 'default', null, 'success');
        }
    }
    public function promote_retailmenot($id)
    {
        $this->loadModel('ProjectRewards.ProjectReward');
        $reward = $this->ProjectReward->find('first', array(
            'conditions' => array(
                'ProjectReward.id' => $id
            ) ,
            'recursive' => - 1
        ));
        $this->set('reward', $reward);
    }
}
?>