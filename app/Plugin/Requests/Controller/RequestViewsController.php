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
class RequestViewsController extends AppController
{
    public $name = 'RequestViews';
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'RequestView.r',
        );
        parent::beforeFilter();
    }
    function admin_index()
    {
        $this->pageTitle = requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('Views');
        $this->RequestView->recursive = 0;
        $conditions = array();
        $this->_redirectGET2Named(array(
            'q',
        ));
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['RequestView.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['RequestView.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['RequestView.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - in this month');
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['RequestView']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->params['named']['request']) || !empty($this->request->params['named']['request_id'])) {
            $requestConditions = !empty($this->request->params['named']['request']) ? array(
                'Request.slug' => $this->request->params['named']['request']
            ) : array(
                'Request.id' => $this->request->params['named']['request_id']
            );
            $request = $this->{$this->modelClass}->Request->find('first', array(
                'conditions' => $requestConditions,
                'fields' => array(
                    'Request.id',
                    'Request.name'
                ) ,
                'recursive' => -1
            ));
            if (empty($request)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Request.id'] = $this->request->data[$this->modelClass]['request_id'] = $request['Request']['id'];
            $this->pageTitle.= ' - ' . $request['Request']['name'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Request',
                'User',
                'Ip' => array(
                    'City' => array(
                        'fields' => array(
                            'City.name',
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name',
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.name',
                            'Country.iso_alpha2',
                        )
                    ) ,
                    'fields' => array(
                        'Ip.ip',
                        'Ip.latitude',
                        'Ip.longitude',
                    )
                ) ,
            ) ,
            'order' => array(
                'RequestView.id' => 'desc'
            ) ,
            'recursive' => 2,
        );
        if (isset($this->request->data['RequestView']['q'])) {
            $this->paginate['search'] = $this->request->data['RequestView']['q'];
        }
        $moreActions = $this->RequestView->moreActions;
        $this->set('page_title', $this->pageTitle);
        $this->set(compact('moreActions'));
        $this->set('requestViews', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Request View');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $requestView = $this->RequestView->find('first', array(
            'conditions' => array(
                'RequestView.id = ' => $id
            ) ,
            'fields' => array(
                'RequestView.id',
                'RequestView.created',
                'RequestView.modified',
                'RequestView.request_id',
                'RequestView.user_id',
                'RequestView.ip_id',
                'Request.id',
                'Request.created',
                'Request.modified',
                'Request.user_id',
                'Request.name',
                'Request.amount',
                'Request.slug',
                'Request.job_count',
                'Request.is_approved',
                'User.id',
                'User.created',
                'User.modified',
                'User.role_id',
                'User.username',
                'User.email',
                'User.password',
                'User.referred_by_user_id',
                'User.fb_user_id',
                'User.user_openid_count',
                'User.user_login_count',
                'User.user_view_count',
                'User.job_count',
                'User.active_job_count',
                'User.job_favorite_count',
                'User.job_feedback_count',
                'User.positive_feedback_count',
                'User.cookie_hash',
                'User.cookie_time_modified',
                'User.is_openid_register',
                'User.is_gmail_register',
                'User.is_yahoo_register',
                'User.is_agree_terms_conditions',
                'User.is_active',
                'User.is_email_confirmed',
                'User.signup_ip',
                'User.last_login_ip',
                'User.last_logged_in_time',
                'User.available_balance_amount',
                'User.available_purchase_amount',
                'User.blocked_amount',
                'User.status_message',
                'User.cleared_amount',
                'User.cleared_blocked_amount',
                'User.twitter_access_token',
                'User.twitter_access_key',
                'User.twitter_user_id',
                'User.user_referred_count',
                'User.last_sent_inactive_mail',
                'User.sent_inactive_mail_count',
                'User.referred_by_user_count',
                'User.sales_cleared_count',
                'User.sales_cleared_amount',
                'User.sales_pipeline_count',
                'User.sales_pipeline_amount',
                'User.sales_lost_count',
                'User.sales_lost_amount',
            ) ,
            'recursive' => 0,
        ));
        if (empty($requestView)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $requestView['RequestView']['id'];
        $this->set('requestView', $requestView);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Request View');
        if (!empty($this->request->data)) {
            $this->RequestView->create();
            if ($this->RequestView->save($this->request->data)) {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('View has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('View could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $requests = $this->RequestView->Request->find('list');
        $users = $this->RequestView->User->find('list');
        $this->set(compact('requests', 'users'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Request View');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->RequestView->save($this->request->data)) {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('View has been updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('View could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->RequestView->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['RequestView']['id'];
        $requests = $this->RequestView->Request->find('list');
        $users = $this->RequestView->User->find('list');
        $this->set(compact('requests', 'users'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RequestView->delete($id)) {
            $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('View deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>