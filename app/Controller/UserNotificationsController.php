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
class UserNotificationsController extends AppController
{
    public $name = 'UserNotifications';
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit User Notification');
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['UserNotification']['user_id'] = $this->Auth->user('id');
            }
            $user_notifications = $this->UserNotification->find('first', array(
                'conditions' => array(
                    'UserNotification.user_id' => $this->request->data['UserNotification']['user_id']
                ) ,
                'recursive' => -1
            ));
            if (!empty($user_notifications)) {
                $this->request->data['UserNotification']['id'] = $user_notifications['UserNotification']['id'];
            }
            $this->request->data['UserNotification']['user_id'] = $this->Auth->user('id');
            if ($this->UserNotification->save($this->request->data)) {
                $this->Session->setFlash(__l('User Notification has been updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('User Notification has been updated') , 'default', null, 'error');
            }
        } else {
            $user_id = "";
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $user_id = $this->Auth->user('id');
            }
            $this->request->data = $this->UserNotification->find('first', array(
                'conditions' => array(
                    'UserNotification.user_id' => $user_id
                ) ,
                'recursive' => -1
            ));
            if (empty($this->request->data['UserNotification'])) {
                $this->request->data['UserNotification']['user_id'] = $this->Auth->user('id');
                $this->request->data['UserNotification']['is_new_order_buyer_notification'] = '1';
                $this->request->data['UserNotification']['is_new_order_seller_notification'] = '1';
                $this->request->data['UserNotification']['is_accept_order_seller_notification'] = '1';
                $this->request->data['UserNotification']['is_accept_order_buyer_notification'] = '1';
                $this->request->data['UserNotification']['is_reject_order_seller_notification'] = '1';
                $this->request->data['UserNotification']['is_reject_order_buyer_notification'] = '1';
                $this->request->data['UserNotification']['is_cancel_order_seller_notification'] = '1';
                $this->request->data['UserNotification']['is_cancel_order_buyer_notification'] = '1';
                $this->request->data['UserNotification']['is_review_order_seller_notification'] = '1';
                $this->request->data['UserNotification']['is_review_order_buyer_notification'] = '1';
                $this->request->data['UserNotification']['is_complete_order_seller_notification'] = '1';
                $this->request->data['UserNotification']['is_complete_order_buyer_notification'] = '1';
                $this->request->data['UserNotification']['is_expire_order_seller_notification'] = '1';
                $this->request->data['UserNotification']['is_expire_order_buyer_notification'] = '1';
                $this->request->data['UserNotification']['is_admin_cancel_order_seller_notification'] = '1';
                $this->request->data['UserNotification']['is_complete_later_order_buyer_notification'] = '1';
                $this->request->data['UserNotification']['is_complete_later_order_seller_notification'] = '1';
                $this->request->data['UserNotification']['is_admin_cancel_buyer_notification'] = '1';
                $this->request->data['UserNotification']['is_cleared_notification'] = '1';
                $this->request->data['UserNotification']['is_contact_notification'] = '1';
                $this->request->data['UserNotification']['is_in_progress_overtime_notification'] = '1';
                $this->request->data['UserNotification']['is_receive_redeliver_notification'] = '1';
                $this->request->data['UserNotification']['is_receive_redeliver_notification'] = '1';
                $this->request->data['UserNotification']['is_recieve_dispute_notification'] = '1';
                $this->UserNotification->save($this->request->data['UserNotification']);
            }
        }
    }
    function admin_index()
    {
        $this->pageTitle = __l('User Notifications');
        $this->UserNotification->recursive = 0;
        $this->set('userNotifications', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('User Notification');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userNotification = $this->UserNotification->find('first', array(
            'conditions' => array(
                'UserNotification.id = ' => $id
            ) ,
            'fields' => array(
                'UserNotification.id',
                'UserNotification.created',
                'UserNotification.modified',
                'UserNotification.user_id',
                'UserNotification.is_new_order_buyer_notification',
                'UserNotification.is_new_order_seller_notification',
                'UserNotification.is_accept_order_seller_notification',
                'UserNotification.is_accept_order_buyer_notification',
                'UserNotification.is_reject_order_seller_notification',
                'UserNotification.is_reject_order_buyer_notification',
                'UserNotification.is_cancel_order_seller_notification',
                'UserNotification.is_cancel_order_buyer_notification',
                'UserNotification.is_review_order_seller_notification',
                'UserNotification.is_review_order_buyer_notification',
                'UserNotification.is_complete_order_seller_notification',
                'UserNotification.is_complete_order_buyer_notification',
                'UserNotification.is_expire_order_seller_notification',
                'UserNotification.is_expire_order_buyer_notification',
                'UserNotification.is_admin_cancel_order_seller_notification',
                'UserNotification.is_admin_cancel_buyer_notification',
                'UserNotification.is_cleared_notification',
                'UserNotification.is_contact_notification',
                'UserNotification.is_in_progress_overtime_notification',
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
                'User.cookie_hash',
                'User.cookie_time_modified',
                'User.is_openid_register',
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
            ) ,
            'recursive' => 0,
        ));
        if (empty($userNotification)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $userNotification['UserNotification']['id'];
        $this->set('userNotification', $userNotification);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add User Notification');
        if (!empty($this->request->data)) {
            $this->UserNotification->create();
            if ($this->UserNotification->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" User Notification has been added') , $this->request->data['UserNotification']['id']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" User Notification could not be added. Please, try again.') , $this->request->data['UserNotification']['id']) , 'default', null, 'error');
            }
        }
        $users = $this->UserNotification->User->find('list');
        $this->set(compact('users'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit User Notification');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserNotification->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" User Notification has been updated') , $this->request->data['UserNotification']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" User Notification could not be updated. Please, try again.') , $this->request->data['UserNotification']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserNotification->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['UserNotification']['id'];
        $users = $this->UserNotification->User->find('list');
        $this->set(compact('users'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserNotification->delete($id)) {
            $this->Session->setFlash(__l('User Notification deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>