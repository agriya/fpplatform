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
class UserAddWalletAmountsController extends AppController
{
    public $name = 'UserAddWalletAmounts';
    function index()
    {
        $this->pageTitle = __l('User Add Wallet Amounts');
        $this->UserAddWalletAmount->recursive = 0;
        $this->set('userAddWalletAmounts', $this->paginate());
    }
    function view($id = null)
    {
        $this->pageTitle = __l('User Add Wallet Amount');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userAddWalletAmount = $this->UserAddWalletAmount->find('first', array(
            'conditions' => array(
                'UserAddWalletAmount.id = ' => $id
            ) ,
            'fields' => array(
                'UserAddWalletAmount.id',
                'UserAddWalletAmount.created',
                'UserAddWalletAmount.modified',
                'UserAddWalletAmount.user_id',
                'UserAddWalletAmount.amount',
                'UserAddWalletAmount.pay_key',
                'UserAddWalletAmount.payment_gateway_id',
                'UserAddWalletAmount.is_success',
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
                'User.request_count',
                'User.request_favorite_count',
                'User.in_progress_overtime_meet_count',
                'User.order_received_count',
                'User.order_accepted_count',
                'User.order_success_without_overtime_count',
                'User.order_success_with_overtime_count',
                'User.order_failure_count',
                'User.order_active_count',
                'User.order_last_accepted_date',
                'User.buyer_order_purchase_count',
                'User.buyer_order_sucess_without_overtime_count',
                'User.buyer_order_sucess_with_overtime_count',
                'User.buyer_order_active_count',
                'User.buyer_waiting_for_acceptance_count',
                'User.buyer_in_progress_count',
                'User.buyer_in_progress_overtime_count',
                'User.buyer_review_count',
                'User.buyer_completed_count',
                'User.buyer_cancelled_count',
                'User.buyer_rejected_count',
                'User.buyer_cancelled_late_order_count',
                'User.buyer_expired_count',
                'User.buyer_payment_pending_count',
                'User.seller_waiting_for_acceptance',
                'User.seller_in_progress_count',
                'User.seller_in_progress_overtime_count',
                'User.seller_review_count',
                'User.seller_completed_count',
                'User.seller_rejected_count',
                'User.seller_cancelled_count',
                'User.seller_expired_count',
                'User.mean_rating',
                'User.actual_rating',
                'PaymentGateway.id',
                'PaymentGateway.created',
                'PaymentGateway.modified',
                'PaymentGateway.name',
                'PaymentGateway.description',
                'PaymentGateway.gateway_fees',
                'PaymentGateway.transaction_count',
                'PaymentGateway.payment_gateway_setting_count',
                'PaymentGateway.is_test_mode',
                'PaymentGateway.is_active',
            ) ,
            'recursive' => 0,
        ));
        if (empty($userAddWalletAmount)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $userAddWalletAmount['UserAddWalletAmount']['id'];
        $this->set('userAddWalletAmount', $userAddWalletAmount);
    }
    function add()
    {
        $this->pageTitle = __l('Add User Add Wallet Amount');
        if (!empty($this->request->data)) {
            $this->UserAddWalletAmount->create();
            if ($this->UserAddWalletAmount->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" User Add Wallet Amount has been added') , $this->request->data['UserAddWalletAmount']['id']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" User Add Wallet Amount could not be added. Please, try again.') , $this->request->data['UserAddWalletAmount']['id']) , 'default', null, 'error');
            }
        }
        $users = $this->UserAddWalletAmount->User->find('list');
        $paymentGateways = $this->UserAddWalletAmount->PaymentGateway->find('list');
        $this->set(compact('users', 'paymentGateways'));
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit User Add Wallet Amount');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserAddWalletAmount->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" User Add Wallet Amount has been updated') , $this->request->data['UserAddWalletAmount']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" User Add Wallet Amount could not be updated. Please, try again.') , $this->request->data['UserAddWalletAmount']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserAddWalletAmount->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['UserAddWalletAmount']['id'];
        $users = $this->UserAddWalletAmount->User->find('list');
        $paymentGateways = $this->UserAddWalletAmount->PaymentGateway->find('list');
        $this->set(compact('users', 'paymentGateways'));
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserAddWalletAmount->delete($id)) {
            $this->Session->setFlash(__l('User Add Wallet Amount deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function admin_index()
    {
        $this->pageTitle = __l('User Add Wallet Amounts');
        $this->UserAddWalletAmount->recursive = 0;
        $this->set('userAddWalletAmounts', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('User Add Wallet Amount');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userAddWalletAmount = $this->UserAddWalletAmount->find('first', array(
            'conditions' => array(
                'UserAddWalletAmount.id = ' => $id
            ) ,
            'fields' => array(
                'UserAddWalletAmount.id',
                'UserAddWalletAmount.created',
                'UserAddWalletAmount.modified',
                'UserAddWalletAmount.user_id',
                'UserAddWalletAmount.amount',
                'UserAddWalletAmount.pay_key',
                'UserAddWalletAmount.payment_gateway_id',
                'UserAddWalletAmount.is_success',
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
                'User.request_count',
                'User.request_favorite_count',
                'User.in_progress_overtime_meet_count',
                'User.order_received_count',
                'User.order_accepted_count',
                'User.order_success_without_overtime_count',
                'User.order_success_with_overtime_count',
                'User.order_failure_count',
                'User.order_active_count',
                'User.order_last_accepted_date',
                'User.buyer_order_purchase_count',
                'User.buyer_order_sucess_without_overtime_count',
                'User.buyer_order_sucess_with_overtime_count',
                'User.buyer_order_active_count',
                'User.buyer_waiting_for_acceptance_count',
                'User.buyer_in_progress_count',
                'User.buyer_in_progress_overtime_count',
                'User.buyer_review_count',
                'User.buyer_completed_count',
                'User.buyer_cancelled_count',
                'User.buyer_rejected_count',
                'User.buyer_cancelled_late_order_count',
                'User.buyer_expired_count',
                'User.buyer_payment_pending_count',
                'User.seller_waiting_for_acceptance',
                'User.seller_in_progress_count',
                'User.seller_in_progress_overtime_count',
                'User.seller_review_count',
                'User.seller_completed_count',
                'User.seller_rejected_count',
                'User.seller_cancelled_count',
                'User.seller_expired_count',
                'User.mean_rating',
                'User.actual_rating',
                'PaymentGateway.id',
                'PaymentGateway.created',
                'PaymentGateway.modified',
                'PaymentGateway.name',
                'PaymentGateway.description',
                'PaymentGateway.gateway_fees',
                'PaymentGateway.transaction_count',
                'PaymentGateway.payment_gateway_setting_count',
                'PaymentGateway.is_test_mode',
                'PaymentGateway.is_active',
            ) ,
            'recursive' => 0,
        ));
        if (empty($userAddWalletAmount)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $userAddWalletAmount['UserAddWalletAmount']['id'];
        $this->set('userAddWalletAmount', $userAddWalletAmount);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add User Add Wallet Amount');
        if (!empty($this->request->data)) {
            $this->UserAddWalletAmount->create();
            if ($this->UserAddWalletAmount->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" User Add Wallet Amount has been added') , $this->request->data['UserAddWalletAmount']['id']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" User Add Wallet Amount could not be added. Please, try again.') , $this->request->data['UserAddWalletAmount']['id']) , 'default', null, 'error');
            }
        }
        $users = $this->UserAddWalletAmount->User->find('list');
        $paymentGateways = $this->UserAddWalletAmount->PaymentGateway->find('list');
        $this->set(compact('users', 'paymentGateways'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit User Add Wallet Amount');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserAddWalletAmount->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" User Add Wallet Amount has been updated') , $this->request->data['UserAddWalletAmount']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" User Add Wallet Amount could not be updated. Please, try again.') , $this->request->data['UserAddWalletAmount']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserAddWalletAmount->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['UserAddWalletAmount']['id'];
        $users = $this->UserAddWalletAmount->User->find('list');
        $paymentGateways = $this->UserAddWalletAmount->PaymentGateway->find('list');
        $this->set(compact('users', 'paymentGateways'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserAddWalletAmount->delete($id)) {
            $this->Session->setFlash(__l('User Add Wallet Amount deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>