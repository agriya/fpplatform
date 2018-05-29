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
class AffiliateRequestsController extends AppController
{
    public $name = 'AffiliateRequests';
    public $components = array(
        'Email'
    );
    function beforeFilter()
    {
        if (!isPluginEnabled('Affiliates') && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        parent::beforeFilter();
    }
    function index()
    {
        $this->pageTitle = __l('Affiliate Requests');
        $this->AffiliateRequest->recursive = 0;
        $this->set('affiliateRequests', $this->paginate());
    }
    function add()
    {
        $status = 'add';
        if ($this->Auth->user('is_affiliate_user')) {
            $this->redirect(array(
                'controller' => 'affiliates',
                'action' => 'index'
            ));
        }
        $this->pageTitle = __l('Request Affiliate');
        if (!empty($this->request->data)) {
            if (empty($this->request->data['AffiliateRequest']['user_id'])) $this->request->data['AffiliateRequest']['user_id'] = $this->Auth->user('id');
            if ($this->AffiliateRequest->save($this->request->data)) {
                if (Configure::read('affiliate.is_admin_mail_after_affiliate_request')) {
                    $this->_sendAffiliateRequestMail($this->Auth->user('id'));
                }
                if (empty($this->request->params['isAjax'])) {
                    $this->redirect(array(
                        'controller' => 'affiliates',
                        'action' => 'index'
                    ));
                } else {
                    $ajax_url = Router::url(array(
                        'controller' => 'affiliates',
                        'action' => 'index'
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            } else {
                $this->Session->setFlash(__l('Affiliate request could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $user = $this->AffiliateRequest->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.is_affiliate_user'
            ) ,
            'contain' => array(
                'AffiliateRequest'
            ) ,
            'recursive' => 1
        ));
        $pending_request = $reject_request = 0;
        if (!$user['User']['is_affiliate_user']) {
            if (!empty($user['AffiliateRequest'])) {
                $pending_request = $this->AffiliateRequest->find('count', array(
                    'conditions' => array(
                        'AffiliateRequest.user_id' => $this->Auth->user('id') ,
                        'AffiliateRequest.is_approved' => 0
                    )
                ));
                $reject_request = $this->AffiliateRequest->find('count', array(
                    'conditions' => array(
                        'AffiliateRequest.user_id' => $this->Auth->user('id') ,
                        'AffiliateRequest.is_approved' => 2
                    ) ,
                ));
            }
            if (($pending_request == 0) && ($reject_request != 0)) {
                $status = 'rejected';
            } else if ($pending_request != 0) {
                $status = 'pending';
            } else {
                $status = 'add';
            }
        } else {
            $status = 'add';
        }
        if (!empty($this->request->data)) {
            $status = 'add';
        }
        $siteCategories = $this->AffiliateRequest->SiteCategory->find('list');
        $this->set(compact('siteCategories'));
        $this->set('status', $status);
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Affiliate Requests');
        $conditions = array();
        $this->set('waiting_for_approval', $this->AffiliateRequest->find('count', array(
            'conditions' => array(
                'AffiliateRequest.is_approved = ' => ConstAffiliateRequests::Pending,
            ) ,
            'recursive' => -1
        )));
        $this->set('approved', $this->AffiliateRequest->find('count', array(
            'conditions' => array(
                'AffiliateRequest.is_approved = ' => ConstAffiliateRequests::Accepted,
            ) ,
            'recursive' => -1
        )));
        $this->set('rejected', $this->AffiliateRequest->find('count', array(
            'conditions' => array(
                'AffiliateRequest.is_approved = ' => ConstAffiliateRequests::Rejected,
            ) ,
            'recursive' => -1
        )));
        $this->set('all', $this->AffiliateRequest->find('count', array(
            'recursive' => -1
        )));
        if (isset($this->request->params['named']['main_filter_id'])) {
            if ($this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Pending) {
                $conditions['AffiliateRequest.is_approved'] = ConstAffiliateRequests::Pending;
                $this->pageTitle.= ' - ' . __l('Waiting for Approval');
            } elseif ($this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Accepted) {
                $conditions['AffiliateRequest.is_approved'] = ConstAffiliateRequests::Accepted;
                $this->pageTitle.= ' - ' . __l('Approved');
            } elseif ($this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Rejected) {
                $conditions['AffiliateRequest.is_approved'] = ConstAffiliateRequests::Rejected;
                $this->pageTitle.= ' - ' . __l('Disapproved');
            }
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['AffiliateRequest']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (isset($this->request->params['named']['is_approved'])) {
            $conditions['AffiliateRequest.is_approved'] = $this->request->params['named']['is_approved'];
        }
        if (isset($this->request->data['AffiliateRequest']['q'])) {
            $conditions['OR']['AffiliateRequest.site_name LIKE '] = '%' . $this->request->data['AffiliateRequest']['q'] . '%';
            $conditions['OR']['AffiliateRequest.site_description LIKE '] = '%' . $this->request->data['AffiliateRequest']['q'] . '%';
            $conditions['OR']['AffiliateRequest.site_url LIKE '] = '%' . $this->request->data['AffiliateRequest']['q'] . '%';
            $conditions['OR']['User.username LIKE '] = '%' . $this->request->data['AffiliateRequest']['q'] . '%';
            $conditions['OR']['SiteCategory.name LIKE '] = '%' . $this->request->data['AffiliateRequest']['q'] . '%';
        }
        $this->AffiliateRequest->recursive = 2;
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'AffiliateRequest.id' => 'desc'
            )
        );
        $moreActions = $this->AffiliateRequest->moreActions;
        $this->set('moreActions', $moreActions);
        $this->set('affiliateRequests', $this->paginate());
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Affiliate Request');
        if (!empty($this->request->data)) {
            $this->AffiliateRequest->create();
            if ($this->AffiliateRequest->save($this->request->data)) {
                $id = $this->AffiliateRequest->getLastInsertId();
                $ids = array(
                    $id => $id
                );
                $status = empty($this->request->data['AffiliateRequest']['is_approved']) ? ConstAffiliateRequests::Pending : $this->request->data['AffiliateRequest']['is_approved'];
                $this->__updateAffiliateUser($ids, $status);
                $this->Session->setFlash(__l('Affiliate request has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Affiliate request could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $users = $this->AffiliateRequest->User->find('list');
        $siteCategories = $this->AffiliateRequest->SiteCategory->find('list');
        $this->set(compact('users', 'siteCategories'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Affiliate Request');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            $this->AffiliateRequest->set($this->request->data);
            if ($this->AffiliateRequest->save($this->request->data)) {
                $id = $this->request->data['AffiliateRequest']['id'];
                $ids = array(
                    $id => $id
                );
                $this->__updateAffiliateUser($ids, $this->request->data['AffiliateRequest']['is_approved']);
                $this->Session->setFlash(__l('Affiliate Request has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Affiliate Request could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->AffiliateRequest->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $users = $this->AffiliateRequest->User->find('list');
        $siteCategories = $this->AffiliateRequest->SiteCategory->find('list');
        $this->set(compact('users', 'siteCategories'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->AffiliateRequest->delete($id)) {
            $this->Session->setFlash(__l('Affiliate Request deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function admin_update()
    {
        if (!empty($this->request->data[$this->modelClass])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $ids = array();
            foreach($this->request->data[$this->modelClass] as $id => $is_checked) {
                if ($is_checked['id']) {
                    $ids[] = $id;
                }
            }
            if ($actionid && !empty($ids)) {
                switch ($actionid) {
                    case ConstMoreAction::Disapproved:
                        foreach($ids as $id) {
                            $this->{$this->modelClass}->updateAll(array(
                                $this->modelClass . '.is_approved' => ConstAffiliateRequests::Rejected
                            ) , array(
                                $this->modelClass . '.id' => $id
                            ));
                        }
                        $this->__updateAffiliateUser($ids, 0);
                        $this->Session->setFlash(__l('Checked requests has been disapproved') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Approved:
                        $this->__updateAffiliateUser($ids, 1);
                        foreach($ids as $id) {
                            $this->{$this->modelClass}->updateAll(array(
                                $this->modelClass . '.is_approved' => ConstAffiliateRequests::Accepted
                            ) , array(
                                $this->modelClass . '.id' => $id
                            ));
                        }
                        $this->Session->setFlash(__l('Checked requests has been approved') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Delete:
                        $this->__updateAffiliateUser($ids, 0);
                        foreach($ids as $id) {
                            $this->{$this->modelClass}->deleteAll(array(
                                $this->modelClass . '.id' => $id
                            ));
                        }
                        $this->Session->setFlash(__l('Checked requests has been deleted') , 'default', null, 'success');
                        break;
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    function __updateAffiliateUser($ids, $status)
    {
        if ($status == 2) {
            $status = 0;
        }
        foreach($ids as $id) {
            $affiliateRequest = $this->AffiliateRequest->find('first', array(
                'conditions' => array(
                    'AffiliateRequest.id' => $id
                ) ,
                'recursive' => -1
            ));
            $this->AffiliateRequest->User->updateAll(array(
                'User.is_affiliate_user' => $status
            ) , array(
                'User.id' => $affiliateRequest['AffiliateRequest']['user_id']
            ));
        }
    }
    function _sendAffiliateRequestMail($user_id)
    {
        $user = $this->AffiliateRequest->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_LINK##' => Router::url('/', true) ,
        );
		$from = ($email['from'] == '##FROM_EMAIL##') ? $user['User']['email'] : $email['from'];
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
		$email_template = $this->EmailTemplate->selectTemplate('Affiliate Request');
		$this->Affiliate->_sendEmail($email_template, $emailFindReplace, Configure::read('site.from_email'),$from );
		 return true;
    }
}
?>
