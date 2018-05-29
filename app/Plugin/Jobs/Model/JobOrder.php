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
class JobOrder extends AppModel
{
    public $name = 'JobOrder';
    public $actsAs = array(
        'Aggregatable',
        'Versionable' => array(
            'modified',
            'job_order_status_id',
            'amount',
            'commission_amount',
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'OwnerUser' => array(
            'className' => 'User',
            'foreignKey' => 'owner_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Job' => array(
            'className' => 'Jobs.Job',
            'foreignKey' => 'job_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'JobFeedback' => array(
            'className' => 'Jobs.JobFeedback',
            'foreignKey' => 'job_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'JobOrderStatus' => array(
            'className' => 'Jobs.JobOrderStatus',
            'foreignKey' => 'job_order_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
    );
    public $hasMany = array(
        'Message' => array(
            'className' => 'Jobs.Message',
            'foreignKey' => 'message_content_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'conditions' => array(
                'Attachment.class =' => 'JobOrder'
            ) ,
            'dependent' => true
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'amount' => array(
                'rule' => 'money',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'address' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'information_from_buyer' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'mobile' => array(
                'rule2' => array(
                    'rule' => Configure::read('site.mobile_validation') ,
                    'message' => __l('Invalid mobile number format')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'verification_code' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'verification_code' => array(
                'rule2' => array(
                    'rule' => array(
                        '_isValidVerificationCode',
                    ) ,
                    'message' => __l('Invalid verification code.')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            )
        );
        $this->isFilterOptions = array(
            ConstJobOrderStatus::PaymentPending => __l('Payment Pending') ,
            ConstJobOrderStatus::WaitingforAcceptance => __l('Waiting for acceptance') ,
            ConstJobOrderStatus::InProgress => __l('In progress') ,
            ConstJobOrderStatus::WaitingforReview => __l('Waiting for buyer review') ,
            ConstJobOrderStatus::Completed => __l('Completed') ,
            ConstJobOrderStatus::Cancelled => __l('Cancelled by buyer') ,
            ConstJobOrderStatus::Rejected => __l('Rejected') ,
            ConstJobOrderStatus::Expired => __l('Expired') ,
            ConstJobOrderStatus::InProgressOvertime => __l('In progress overtime') ,
            ConstJobOrderStatus::CancelledDueToOvertime => __l('Cancelled due to overtime') ,
            ConstJobOrderStatus::CancelledByAdmin => __l('Cancelled by admin') ,
            ConstJobOrderStatus::CompletedAndClosedByAdmin => __l('Completed and closed by admin') ,
        );
        $this->moreActions = array(
            ConstMoreAction::WaitingforAcceptance => __l('Waiting for acceptance') ,
            ConstMoreAction::InProgress => __l('In progress') ,
            ConstMoreAction::WaitingforReview => __l('Waiting for review') ,
            ConstMoreAction::Completed => __l('Completed') ,
            ConstMoreAction::Cancelled => __l('Cancelled') ,
            ConstMoreAction::Rejected => __l('Rejected') ,
            ConstMoreAction::PaymentCleared => __l('Payment Cleared') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function _isValidVerificationCode($field1 = array() , $field2 = null, $field3 = null)
    {
        $check_order = $this->find('first', array(
            'conditions' => array(
                'JobOrder.id' => $this->data['JobOrder']['id'],
                'JobOrder.verification_code' => $this->data['JobOrder']['verification_code'],
                'JobOrder.job_order_status_id' => array(
                    ConstJobOrderStatus::InProgress,
                    ConstJobOrderStatus::InProgressOvertime,
                    ConstJobOrderStatus::Redeliver,
                ) ,
                'Job.user_id' => $_SESSION['Auth']['User']['id']
            ) ,
            'contain' => array(
                'Job'
            ) ,
            'recursive' => 0
        ));
        if (!empty($check_order)) {
            return true;
        }
        return false;
    }
    function processOrder($order_id, $order_status, $message = null)
    {
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        App::import('Model', 'Jobs.JobOrder');
        $this->JobOrder = new JobOrder();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
        $jobInfo = $this->JobOrder->find('first', array(
            'conditions' => array(
                'JobOrder.id' => $order_id,
            ) ,
            'contain' => array(
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.title',
                        'Job.user_id',
                        'Job.slug',
                        'Job.job_type_id',
                        'Job.job_service_location_id',
                        'Job.address',
                        'Job.mobile',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                            'User.available_balance_amount',
                            'User.blocked_amount',
                            'User.cleared_amount',
                            'User.available_purchase_amount',
                            'User.available_wallet_amount',
                        )
                    )
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.available_balance_amount',
                        'User.blocked_amount',
                        'User.cleared_amount',
                        'User.available_purchase_amount',
                        'User.available_wallet_amount',
                        'User.referred_by_user_id'
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        $success = 0;
        $is_review = 0;
        $ajax_repsonse = 'failed';
        $buyer_user_id = $jobInfo['JobOrder']['user_id'];
        $buyer_username = $jobInfo['User']['username'];
        $buyer_email = $jobInfo['User']['email'];
        $seller_user_id = $jobInfo['Job']['user_id'];
        $seller_username = $jobInfo['Job']['User']['username'];
        $seller_email = $jobInfo['Job']['User']['email'];
        $job_id = $jobInfo['Job']['id'];
        $verification_code = $seller_contact = $buyer_contact = $print_link = $success_message = $status = '';
        Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
            '_addTrans' => array(
                'order_id' => 'Joborder-' . $order_id,
                'name' => $jobInfo['Job']['title'],
                'total' => $jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['admin_commission_amount']
            ) ,
            '_addItem' => array(
                'order_id' => 'JobOrdering-' . $order_id,
                'sku' => 'PF' . $order_id,
                'name' => $jobInfo['Job']['title'],
                'category' => '',
                'unit_price' => $jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['admin_commission_amount']
            ) ,
            '_setCustomVar' => array(
                'pd' => $jobInfo['Job']['id'],
                'pfd' => $order_id,
                'ud' => $jobInfo['User']['id'],
                'rud' => $jobInfo['User']['referred_by_user_id'],
            )
        ));
        Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
            '_addTrans' => array(
                'order_id' => 'SiteCommision-' . $order_id,
                'name' => $jobInfo['Job']['title'],
                'total' => $jobInfo['JobOrder']['admin_commission_amount']
            ) ,
            '_addItem' => array(
                'order_id' => 'SiteCommision-' . $order_id,
                'sku' => 'PF' . $order_id,
                'name' => $jobInfo['Job']['title'],
                'category' => '',
                'unit_price' => $jobInfo['JobOrder']['admin_commission_amount']
            ) ,
            '_setCustomVar' => array(
                'pd' => $jobInfo['Job']['id'],
                'pfd' => $order_id,
                'ud' => $jobInfo['User']['id'],
                'rud' => $jobInfo['User']['referred_by_user_id'],
            )
        ));
        Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
            '_trackEvent' => array(
                'category' => 'User',
                'action' => 'Order',
                'label' => $_SESSION['Auth']['User']['username'],
                'value' => '',
            ) ,
            '_setCustomVar' => array(
                'pd' => $jobInfo['Job']['id'],
                'pfd' => $order_id,
                'ud' => $jobInfo['User']['id'],
                'rud' => $jobInfo['User']['referred_by_user_id'],
            )
        ));
        Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
            '_trackEvent' => array(
                'category' => 'JobOrder',
                'action' => 'Order',
                'label' => '',
                'value' => '',
            ) ,
            '_setCustomVar' => array(
                'pd' => $jobInfo['Job']['id'],
                'pfd' => $order_id,
                'ud' => $jobInfo['User']['id'],
                'rud' => $jobInfo['User']['referred_by_user_id'],
            )
        ));
        switch ($order_status) {
            case 'accept':
                if ($seller_user_id != $_SESSION['Auth']['User']['id']) {
                    throw new NotFoundException(__l('Invalid request'));
                }
                if (!empty($jobInfo['JobOrder']) && ($jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforAcceptance)) {
                    // Generating verification code for offline jobs //
                    $verification_code = $this->_generateVerificationCode();
                    $JobOrder['JobOrder']['id'] = $order_id;
                    $JobOrder['JobOrder']['job_order_status_id'] = ConstJobOrderStatus::InProgress;
                    $JobOrder['JobOrder']['accepted_date'] = date('Y-m-d H:i:s');
                    $JobOrder['JobOrder']['verification_code'] = $verification_code;
                    if ($jobInfo['Job']['job_service_location_id'] == ConstServiceLocation::BuyerToSeller) {
                        $seller_contact = __l('Address:') . '<br>';
                        $seller_contact.= $jobInfo['Job']['address'] . '<br>';
                        $seller_contact.= __l('Mobile:') . '<br>';
                        $seller_contact.= $jobInfo['Job']['mobile'] . '<br>';
                    }
                    if ($jobInfo['Job']['job_service_location_id'] == ConstServiceLocation::SellerToBuyer) {
                        $buyer_contact = __l('Address:') . '<br>';
                        $buyer_contact.= $jobInfo['JobOrder']['address'] . '<br>';
                        $buyer_contact.= __l('Mobile:') . '<br>';
                        $buyer_contact.= $jobInfo['JobOrder']['mobile'] . '<br>';
                    }
                    $print_link = "<a href=" . Router::url(array(
                        'controller' => 'job_orders',
                        'action' => 'track_order',
                        $jobInfo['JobOrder']['id'],
                        'type' => 'print',
                        'admin' => false,
                    ) , true) . " target='_blank'>" . __l('Print') . "</a>";
                    $this->JobOrder->save($JobOrder, false);
                    $success = 1;
					if($jobInfo['Job']['job_type_id'] == ConstJobType::Online){
						$mail_template = 'Accepted order notification online';
					} else if($jobInfo['Job']['job_type_id'] == ConstJobType::Offline) {
						$mail_template = 'Accepted order notification offline';
					}
                    $mail_template_for_sender = 'Accept order seller notification';
                    $to = $buyer_user_id;
                    $message_sender_user_id = $seller_user_id;
                    $to_user = $buyer_username;
                    $sender_email = $buyer_email;
                    $message_sender_name = $seller_username;
                    $message_sender_email = $seller_email;
                    $ajax_repsonse = 'accepted';
                    $email_message = __l('Your order has been accepted.');
                    $email_message_for_sender = __l('You have accepted the order');
                    //$success_message = __l('Order has been Accepted');
                    $redirect = 'myworks';
                    $status = 'in_progress';
                } else {
                    $redirect = 'myworks';
                }
                break;

            case 'cancel':
				$refund['error'] = 0;
                if (!empty($jobInfo['JobOrder']) && ($jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforAcceptance || $jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime)) {
                    $update_seller_balance = $jobInfo['Job']['User']['blocked_amount']-($jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['commission_amount']); // seller blocked amount - actual job amount
                    $update_buyer_balance = $jobInfo['User']['available_wallet_amount']+$jobInfo['JobOrder']['amount']; // Buyer blocked amount + actual job amount
					if (!empty($_SESSION['Auth']['User']['id']) && $buyer_user_id  != $_SESSION['Auth']['User']['id']) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                    if (!empty($jobInfo['JobOrder']['payment_gateway_id']) && $jobInfo['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) {
                        App::import('Model', 'Payment');
                        $this->Payment = new Payment();
                        $refund = $this->Payment->_refundProcessOrder($jobInfo['JobOrder']['id']);
                    }
                    if (empty($refund['error'])) {
                        if ($jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime) {
                            $order_status = ConstJobOrderStatus::CancelledDueToOvertime;
                            $transaction_status = ConstTransactionTypes::BuyerCancelledDueToOvertime;
                        } else {
                            $order_status = ConstJobOrderStatus::Cancelled;
                            $transaction_status = ConstTransactionTypes::RefundForCancelledJobs;
                        }
                        $success_message = __l('Your order has been canceled');
                        $stat_mess = 'cancelled';
                        $ajax_repsonse = 'cancelled';
                        $redirect = 'myorders';
                        $to = $seller_user_id;
                        $message_sender_user_id = $buyer_user_id;
                        $to_user = $seller_username;
                        $message_sender_name = $buyer_username;
                        $message_sender_email = $buyer_email;
                        $transaction_user_id = $_SESSION['Auth']['User']['id'];
                        $sender_email = $seller_email;
                        $email_message = __l('Your order has been cancelled');
                        $email_message_for_sender = __l('You have cancelled your order');
                        $mail_template = 'Cancelled order notification';
                        $mail_template_for_sender = 'Cancelled order buyer notification';
                        $seller_transaction_status = ConstTransactionTypes::SellerDeductedForCancelledJob;
                        $success = 1;
                        // Change order status
                        $JobOrder['JobOrder']['id'] = $order_id;
                        $JobOrder['JobOrder']['job_order_status_id'] = $order_status;
                        $this->JobOrder->save($JobOrder);
                        // Update amount to seller ->  reduce 5$ from seller //
                        $this->JobOrder->User->updateAll(array(
                            'User.blocked_amount' => "'" . $update_seller_balance . "'"
                        ) , array(
                            'User.id' => $seller_user_id
                        ));
                        if (!empty($jobInfo['JobOrder']['payment_gateway_id']) && $jobInfo['JobOrder']['payment_gateway_id'] != ConstPaymentGateways::SudoPay) { // SudoPay adaptive reverse process shouldn't reduce from wallet
                            // Update amount to Buyer -> add 5$ to buyer balance//
                            $this->JobOrder->User->updateAll(array(
                                'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
                            ) , array(
                                'User.id' => $buyer_user_id
                            ));
                        }
                        // Update Transactions //
                        $transaction['Transaction']['user_id'] = $transaction_user_id;
                        $transaction['Transaction']['foreign_id'] = $order_id;
                        $transaction['Transaction']['class'] = 'JobOrder';
                        $transaction['Transaction']['amount'] = $jobInfo['JobOrder']['amount'];
                        $transaction['Transaction']['description'] = "Job $stat_mess - Amount Refunded";
                        $transaction['Transaction']['transaction_type_id'] = $transaction_status;
                        $this->JobOrder->User->Transaction->log_data($transaction);
                        // Updating transaction again for seller //
                        $transaction['Transaction']['id'] = '';
                        $transaction['Transaction']['user_id'] = $jobInfo['Job']['user_id'];
                        $transaction['Transaction']['foreign_id'] = $order_id;
                        $transaction['Transaction']['class'] = 'JobOrder';
                        $transaction['Transaction']['amount'] = ($jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['commission_amount']);
                        $transaction['Transaction']['description'] = 'Updating payment status for seller';
                        $transaction['Transaction']['transaction_type_id'] = $seller_transaction_status;
                        $this->JobOrder->User->Transaction->save($transaction);
                    } else {
                        if ($status == 'reject') { // Seller rejected, updating buyer
                            $redirect = 'myworks';
                        } else { // Buyer cancelled, updating seller
                            $redirect = 'myorders';
                        }
                    }
                } else {
                    if ($status == 'reject') { // Seller rejected, updating buyer
                        $redirect = 'myworks';
                    } else { // Buyer cancelled, updating seller
                        $redirect = 'myorders';
                    }
                }
                break;

            case 'reject':
				$refund['error']= 0;
                $update_seller_balance = $jobInfo['Job']['User']['blocked_amount']-($jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['commission_amount']); // seller blocked amount - actual job amount
                $update_buyer_balance = $jobInfo['User']['available_wallet_amount']+$jobInfo['JobOrder']['amount']; // Buyer blocked amount + actual job amount
                if (!empty($jobInfo['JobOrder']) && ($jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforAcceptance || $jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime)) {
                    if ($seller_user_id != $_SESSION['Auth']['User']['id']) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                    if (!empty($jobInfo['JobOrder']['payment_gateway_id']) && $jobInfo['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) {
                        App::import('Model', 'Payment');
                        $this->Payment = new Payment();
                        $refund = $this->Payment->_voidProcessOrder($jobInfo['JobOrder']['id']);
                    }
                    if (empty($refund['error'])) {
                        $order_status = ConstJobOrderStatus::Rejected;
                        $transaction_status = ConstTransactionTypes::RefundForRejectedJobs;
                        $success_message = __l('Your order has been rejected');
                        $stat_mess = 'rejected';
                        $ajax_repsonse = 'rejected';
                        $redirect = 'myworks';
                        $to = $buyer_user_id;
                        $message_sender_user_id = $seller_user_id;
                        $to_user = $buyer_username;
                        $sender_email = $buyer_email;
                        $message_sender_name = $seller_username;
                        $message_sender_email = $seller_email;
                        $transaction_user_id = $buyer_user_id;
                        $email_message = __l('Your order has been rejected');
                        $email_message_for_sender = __l('You have rejected your order');
                        $mail_template = 'Rejected order notification';
                        $mail_template_for_sender = 'Rejected order seller notification';
                        $seller_transaction_status = ConstTransactionTypes::SellerDeductedForRejectedJob;
                        $success = 1;
                        // Change order status
                        $JobOrder['JobOrder']['id'] = $order_id;
                        $JobOrder['JobOrder']['job_order_status_id'] = $order_status;
                        $this->JobOrder->save($JobOrder);
                        // Update amount to seller ->  reduce 5$ from seller //
                        $this->JobOrder->User->updateAll(array(
                            'User.blocked_amount' => "'" . $update_seller_balance . "'"
                        ) , array(
                            'User.id' => $seller_user_id
                        ));
                        if (!empty($jobInfo['JobOrder']['payment_gateway_id']) && $jobInfo['JobOrder']['payment_gateway_id'] != ConstPaymentGateways::SudoPay) { // SudoPay adaptive reverse process shouldn't reduce from wallet
                            // Update amount to Buyer -> add 5$ to buyer balance//
                            $this->JobOrder->User->updateAll(array(
                                'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
                            ) , array(
                                'User.id' => $buyer_user_id
                            ));
                        }
                        // Update Transactions //
                        $transaction['Transaction']['user_id'] = $transaction_user_id;
                        $transaction['Transaction']['foreign_id'] = $order_id;
                        $transaction['Transaction']['class'] = 'JobOrder';
                        $transaction['Transaction']['amount'] = $jobInfo['JobOrder']['amount'];
                        $transaction['Transaction']['description'] = "Job $stat_mess - Amount Refunded";
                        $transaction['Transaction']['transaction_type_id'] = $transaction_status;
                        $this->JobOrder->User->Transaction->log_data($transaction);
                        // Updating transaction again for seller //
                        $transaction['Transaction']['id'] = '';
                        $transaction['Transaction']['user_id'] = $jobInfo['Job']['user_id'];
                        $transaction['Transaction']['foreign_id'] = $order_id;
                        $transaction['Transaction']['class'] = 'JobOrder';
                        $transaction['Transaction']['amount'] = ($jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['commission_amount']);
                        $transaction['Transaction']['description'] = 'Updating payment status for seller';
                        $transaction['Transaction']['transaction_type_id'] = $seller_transaction_status;
                        $this->JobOrder->User->Transaction->save($transaction);
                    } else {
                        if ($status == 'reject') { // Seller rejected, updating buyer
                            $redirect = 'myworks';
                        } else { // Buyer cancelled, updating seller
                            $redirect = 'myorders';
                        }
                    }
                } else {
                    if ($status == 'reject') { // Seller rejected, updating buyer
                        $redirect = 'myworks';
                    } else { // Buyer cancelled, updating seller
                        $redirect = 'myorders';
                    }
                }
				$status = 'rejected';
                break;

            case 'admin_cancel':
                $redirect = '';
				$refund['error'] = 0;
                if (!empty($jobInfo['JobOrder']['payment_gateway_id']) && $jobInfo['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) {
                    App::import('Model', 'Payment');
                    $this->Payment = new Payment();
                    $refund = $this->Payment->_refundProcessOrder($jobInfo['JobOrder']['id']);
                }
                if (empty($refund['error'])) {
                    $update_seller_balance = $jobInfo['Job']['User']['blocked_amount']-($jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['commission_amount']); // seller blocked amount - actual job amount
                    $update_buyer_balance = $jobInfo['User']['available_wallet_amount']+$jobInfo['JobOrder']['amount']; // Buyer blocked amount + actual job amount
                    $order_status = ConstJobOrderStatus::CancelledByAdmin;
                    $transaction_status = ConstTransactionTypes::RefundForRejectedJobs;
                    $success_message = __l('Your order has been cancelled by admin');
                    $stat_mess = 'rejected';
                    $ajax_repsonse = 'rejected';
                    $redirect = 'myworks';
                    $to = $seller_user_id;
                    $message_sender_user_id = $buyer_user_id;
                    $to_user = $buyer_username;
                    $sender_email = $seller_email;
                    $message_sender_name = $seller_username;
                    $message_sender_email = $buyer_email;
                    $transaction_user_id = $buyer_user_id;
                    $email_message = __l('Your order has been cancelled by admin');
                    $email_message_for_sender = __l('Your order has been cancelled by admin');
                    $mail_template = 'Admin rejected order notification';
                    $mail_template_for_sender = 'Admin rejected order seller notification';
                    $seller_transaction_status = ConstTransactionTypes::SellerDeductedForRejectedJob;
                    $success = 1;
                    // Change order status
                    $JobOrder['JobOrder']['id'] = $order_id;
                    $JobOrder['JobOrder']['job_order_status_id'] = $order_status;
                    $this->JobOrder->save($JobOrder);
                    // Update amount to seller ->  reduce 5$ from seller //
                    $this->JobOrder->User->updateAll(array(
                        'User.blocked_amount' => "'" . $update_seller_balance . "'"
                    ) , array(
                        'User.id' => $seller_user_id
                    ));
                    if (!empty($jobInfo['JobOrder']['payment_gateway_id']) && $jobInfo['JobOrder']['payment_gateway_id'] != ConstPaymentGateways::SudoPay) { // SudoPay adaptive reverse process shouldn't reduce from wallet
                        // Update amount to Buyer -> add 5$ to buyer balance//
                        $this->JobOrder->User->updateAll(array(
                            'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
                        ) , array(
                            'User.id' => $buyer_user_id
                        ));
                    }
                    // Update Transactions //
                    $transaction['Transaction']['user_id'] = $transaction_user_id;
                    $transaction['Transaction']['foreign_id'] = $order_id;
                    $transaction['Transaction']['class'] = 'JobOrder';
                    $transaction['Transaction']['amount'] = $jobInfo['JobOrder']['amount'];
                    $transaction['Transaction']['description'] = "Job $stat_mess - Amount Refunded";
                    $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::CancelledByAdminRefundToBuyer;
                    $this->JobOrder->User->Transaction->log_data($transaction);
                    // Updating transaction again for seller //
                    $transaction['Transaction']['id'] = '';
                    $transaction['Transaction']['user_id'] = $jobInfo['Job']['user_id'];
                    $transaction['Transaction']['foreign_id'] = $order_id;
                    $transaction['Transaction']['class'] = 'JobOrder';
                    $transaction['Transaction']['amount'] = ($jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['commission_amount']);
                    $transaction['Transaction']['description'] = 'Updating payment status for seller';
                    $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::CancelledByAdminDeductFromSeller;
                    $this->JobOrder->User->Transaction->save($transaction);
                }
                break;

            case 'review':
                if (!empty($jobInfo['JobOrder']) && ($jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgress || $jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime || $jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Redeliver)) {
                    $JobOrder['JobOrder']['id'] = $order_id;
                    $JobOrder['JobOrder']['job_order_status_id'] = ConstJobOrderStatus::WaitingforReview;
                    $JobOrder['JobOrder']['delivered_date'] = date('Y-m-d H:i:s');
                    $this->JobOrder->save($JobOrder);
                    $success = 1;
                    $is_review = 1;
                    $to = $buyer_user_id;
                    $message_sender_user_id = $seller_user_id;
                    $to_user = $buyer_username;
                    $sender_email = $buyer_email;
                    $message_sender_name = $seller_username;
                    $message_sender_email = $seller_email;
                    $email_message = __l('Your order has been completed and waiting for your review');
                    $email_message_for_sender = __l('You have completed your work and waiting for your buyer review.');
                    $mail_template = 'Buyer review notification';
                    $mail_template_for_sender = 'Buyer review seller notification';
                    $redirect = 'myworks';
                    $success_message = __l('Your work has been delivered successfully!');
                    $status = 'waiting_for_Review';
                } else {
                    $redirect = 'myworks';
                }
                break;

            case 'complete':
                if (!empty($jobInfo['JobOrder']) && ($jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview)) {
                    $success = 1;
                    // Updated balance amount //
                    $update_seller_blocked_balance = $jobInfo['Job']['User']['blocked_amount']-($jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['commission_amount']); // Buyer blocked amount + actual job amount
                    $update_seller_available_balance = $jobInfo['Job']['User']['available_balance_amount']+($jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['commission_amount']); // Buyer blocked amount + actual job amount
                    $this->JobOrder->User->updateAll(array(
                        'User.blocked_amount' => "'" . $update_seller_blocked_balance . "'",
                        'User.available_balance_amount' => "'" . $update_seller_available_balance . "'"
                    ) , array(
                        'User.id' => $seller_user_id
                    ));
                    // Change order status & completed_on datetime //
                    $JobOrder['JobOrder']['id'] = $order_id;
                    $JobOrder['JobOrder']['job_order_status_id'] = ConstJobOrderStatus::Completed;
                    $JobOrder['JobOrder']['completed_date'] = date('Y-m-d H:i:s');
                    $this->JobOrder->save($JobOrder);
                    // Updating Revenue in jobs table
                    $getJobTotalRevenueAmount = $this->JobOrder->find('first', array(
                        'conditions' => array(
                            'JobOrder.job_id' => $jobInfo['JobOrder']['job_id'],
                            'JobOrder.job_order_status_id' => array(
                                ConstJobOrderStatus::Completed,
                                ConstJobOrderStatus::PaymentCleared,
                            ) ,
                        ) ,
                        'fields' => array(
                            'SUM(amount - commission_amount) as revenue'
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($getJobTotalRevenueAmount['0'])) {
                        $this->JobOrder->Job->UpdateAll(array(
                            'Job.revenue' => $getJobTotalRevenueAmount['0']['revenue']
                        ) , array(
                            'Job.id' => $jobInfo['JobOrder']['job_id']
                        ));
                    }
                    // Update Transactions //
                    $transaction['Transaction']['user_id'] = $seller_user_id;
                    $transaction['Transaction']['foreign_id'] = $jobInfo['JobOrder']['id'];
                    $transaction['Transaction']['class'] = 'JobOrder';
                    $transaction['Transaction']['amount'] = ($jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['commission_amount']);
                    $transaction['Transaction']['description'] = 'Job - Amount paid for Job to user';
                    $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::PaidAmountToUser;
                    $this->JobOrder->User->Transaction->log_data($transaction);
                    $to = $seller_user_id;
                    $message_sender_user_id = $buyer_user_id;
                    $to_user = $seller_username;
                    $sender_email = $seller_email;
                    $message_sender_name = $buyer_username;
                    $message_sender_email = $buyer_email;
                    $email_message = __l('Your order has been reviewed and completed.');
                    $email_message_for_sender = __l('Your review has been sent successfully and order has been completed.');
                    $mail_template = 'Completed order notification';
                    $mail_template_for_sender = 'Completed order buyer notification';
                    $redirect = 'myorders';
                    $success_message = __l('Your review has been added!');
                    $status = 'completed';
                } else {
                    $redirect = 'myorders';
                }
                break;

            case 'mutual_cancel':
			$refund['error'] = 0;
                if (!empty($jobInfo['JobOrder']) && ($jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgress || $jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime || $jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview || $jobInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Redeliver)) {
                    $update_seller_balance = $jobInfo['Job']['User']['blocked_amount']-($jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['commission_amount']); // seller blocked amount - actual job amount
                    $update_buyer_balance = $jobInfo['User']['available_wallet_amount']+$jobInfo['JobOrder']['amount']; // Buyer blocked amount + actual job amount
                    //$update_buyer_balance = $jobInfo['JobOrder']['amount']; // need to verify
                    if (!empty($jobInfo['JobOrder']['payment_gateway_id']) && $jobInfo['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) {
                        App::import('Model', 'Payment');
                        $this->Payment = new Payment();
                        $refund = $this->Payment->_refundProcessOrder($jobInfo['JobOrder']['id']);
                    }
                    if (empty($refund['error'])) {
                        $order_status = ConstJobOrderStatus::MutualCancelled;
                        $transaction_status = ConstTransactionTypes::RefundForCancelledJobs;
                        //$success_message = 'Your order has been cancelled';
                        $stat_mess = 'cancelled';
                        $ajax_repsonse = 'cancelled';
                        $redirect = 'myorders';
                        $to = $seller_user_id;
                        $message_sender_user_id = $buyer_user_id;
                        $to_user = $seller_username;
                        $message_sender_name = $buyer_username;
                        $message_sender_email = $buyer_email;
                        $transaction_user_id = $_SESSION['Auth']['User']['id'];
                        $sender_email = $seller_email;
                        $email_message = __l('Your order has been mutually cancelled');
                        $email_message_for_sender = __l('Your order has been mutually cancelled.');
                        $mail_template = 'Mutual Cancelled order notification';
                        $mail_template_for_sender = 'Mutual Cancelled order notification';
                        $seller_transaction_status = ConstTransactionTypes::SellerDeductedForCancelledJob;
                        $success = 1;
                        // Change order status
                        $JobOrder['JobOrder']['id'] = $order_id;
                        $JobOrder['JobOrder']['job_order_status_id'] = $order_status;
                        $this->JobOrder->save($JobOrder);
                        // Update amount to seller ->  reduce 5$ from seller //
                        $this->JobOrder->User->updateAll(array(
                            'User.blocked_amount' => "'" . $update_seller_balance . "'"
                        ) , array(
                            'User.id' => $seller_user_id
                        ));
                        if (!empty($jobInfo['JobOrder']['payment_gateway_id']) && $jobInfo['JobOrder']['payment_gateway_id'] != ConstPaymentGateways::SudoPay) { // SudoPay adaptive reverse process shouldn't reduce from wallet
                            // Update amount to Buyer -> add 5$ to buyer balance//
                            $this->JobOrder->User->updateAll(array(
                                'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
                            ) , array(
                                'User.id' => $buyer_user_id
                            ));
                        }
                        // Update Transactions //
                        $transaction['Transaction']['user_id'] = $transaction_user_id;
                        $transaction['Transaction']['foreign_id'] = $order_id;
                        $transaction['Transaction']['class'] = 'JobOrder';
                        $transaction['Transaction']['amount'] = $jobInfo['JobOrder']['amount'];
                        $transaction['Transaction']['description'] = "Job $stat_mess - Amount Refunded";
                        $transaction['Transaction']['transaction_type_id'] = $transaction_status;
                        $this->JobOrder->User->Transaction->log_data($transaction);
                        // Updating transaction again for seller //
                        $transaction['Transaction']['id'] = '';
                        $transaction['Transaction']['user_id'] = $jobInfo['Job']['user_id'];
                        $transaction['Transaction']['foreign_id'] = $order_id;
                        $transaction['Transaction']['class'] = 'JobOrder';
                        $transaction['Transaction']['amount'] = ($jobInfo['JobOrder']['amount']-$jobInfo['JobOrder']['commission_amount']);
                        $transaction['Transaction']['description'] = 'Updating payment status for seller';
                        $transaction['Transaction']['transaction_type_id'] = $seller_transaction_status;
                        $this->JobOrder->User->Transaction->save($transaction);
                    } else {
                        if ($status == 'reject') { // Seller rejected, updating buyer
                            $redirect = 'myworks';
							$status = 'rejected';
                        } else { // Buyer cancelled, updating seller
                            $redirect = 'myorders';
                        }
                    }
                } else {
                    if ($status == 'reject') { // Seller rejected, updating buyer
                        $redirect = 'myworks';
						$status = 'rejected';
                    } else { // Buyer cancelled, updating seller
                        $redirect = 'myorders';
                    }
                }
                break;
        }
        if ($success) {
            $template = $this->EmailTemplate->selectTemplate($mail_template);
            $emailFindReplace = array(
                '##USERNAME##' => $to_user,
                '##JOB_NAME##' => "<a href=" . Router::url(array(
                    'controller' => 'jobs',
                    'action' => 'view',
                    $jobInfo['Job']['slug'],
                    'admin' => false,
                ) , true) . ">" . $jobInfo['Job']['title'] . "</a>",
                '##BUYER_USERNAME##' => $buyer_username,
                '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
                '##ORDERNO##' => $order_id,
                '##REVIEW_URL##' => "<a href=" . Router::url(array(
                    'controller' => 'job_feedbacks',
                    'action' => 'add',
                    'job_order_id' => $order_id,
                ) , true) . ">" . Router::url(array(
                    'controller' => 'job_feedbacks',
                    'action' => 'add',
                    'job_order_id' => $order_id,
                    'admin' => false,
                ) , true) . "</a>",
                '##VERIFICATION_CODE##' => $verification_code,
                '##SELLER_CONTACT##' => $seller_contact,
                '##BUYER_CONTACT##' => $buyer_contact,
                '##PRINT##' => $print_link,
                '##AUTO_REVIEW_DAY##' => Configure::read('job.auto_review_complete') ,
                '##MESSAGE##' => $message,
            );
            $get_order_status = $this->JobOrder->find('first', array(
                'conditions' => array(
                    'JobOrder.id' => $order_id
                ) ,
                'recursive' => -1
            ));
            $message = strtr($template['email_text_content'], $emailFindReplace);
            if (Configure::read('messages.is_send_internal_message')) {
                $is_auto = 1;
                $message_id = $this->Message->sendNotifications($to, $template['subject'], $message, $order_id, $is_review, $job_id, $get_order_status['JobOrder']['job_order_status_id'], '0', $is_auto);
                if (Configure::read('messages.is_send_email_on_new_message')) {
                    $content['subject'] = $email_message;
                    $content['message'] = $email_message;
                    if (!empty($sender_email)) {
                        if ($this->_checkUserNotifications($to, $get_order_status['JobOrder']['job_order_status_id'], 0)) {
                            $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                        }
                    }
                }
                $emailFindReplace['##USERNAME##'] = $message_sender_name;
                if (!empty($mail_template_for_sender)) {
                    $template = $this->EmailTemplate->selectTemplate($mail_template_for_sender);
                    $message_for_buyer = strtr($template['email_text_content'], $emailFindReplace);
                    if (Configure::read('messages.send_notification_mail_for_sender')) {
                        $is_auto = 1;
                        $message_id_buyer = $this->Message->sendNotifications($message_sender_user_id, $template['subject'], $message_for_buyer, $order_id, $is_review = 0, $job_id, ConstJobOrderStatus::SenderNotification, '0', $is_auto);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = $email_message_for_sender;
                            $content['message'] = $email_message_for_sender;
                            if (!empty($message_sender_email)) {
                                if ($this->_checkUserNotifications($message_sender_user_id, $get_order_status['JobOrder']['job_order_status_id'], 1)) {
                                    $this->_sendAlertOnNewMessage($message_sender_email, $content, $message_id_buyer, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                }
            }
            $flash_message = $success_message;
        } else {
            $error = 1;
            $flash_message = __l("Order couldn't be processed at the moment. Try again");
        }
        $return['order_id'] = $order_id;
        $return['status'] = $status;
        $return['redirect'] = $redirect;
        $return['flash_message'] = $flash_message;
        $return['ajax_repsonse'] = $ajax_repsonse;
        $return['error'] = (!empty($error) ? $error : '0');
        return $return; //$_SESSION['Auth']['User']['id']

    }
    // After save to update sales and purchase related information after every status gets saved.
    function afterSave($created)
    {
        if (!empty($this->data['JobOrder']['job_order_status_id']) && $this->data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::PaymentPending) {
            return true;
        }
        // Updating job order counts and buyer and seller count//
        $this->update_job_order_status_count($this->data);
        // Updating sales and revenue details for jobs, buyer and seller //
        if (empty($this->data['JobOrder']['job_id'])) {
            $order = $this->find('first', array(
                'conditions' => array(
                    'JobOrder.id' => $this->data['JobOrder']['id'],
                ) ,
                'recursive' => -1
            ));
            $this->data['JobOrder']['job_id'] = $order['JobOrder']['job_id'];
            $this->data['JobOrder']['user_id'] = $order['JobOrder']['user_id'];
            $this->data['JobOrder']['amount'] = $order['JobOrder']['amount'];
            $this->data['JobOrder']['commission_amount'] = $order['JobOrder']['commission_amount'];
        }
        $order_status = !empty($this->data['JobOrder']['job_order_status_id']) ? $this->data['JobOrder']['job_order_status_id'] : '';
        $job_id = $this->data['JobOrder']['job_id'];
        $buyer_id = $this->data['JobOrder']['user_id'];
        $job = $this->Job->find('first', array(
            'conditions' => array(
                'Job.id' => $this->data['JobOrder']['job_id']
            ) ,
            'fields' => array(
                'Job.id',
                'Job.title',
                'Job.user_id'
            ) ,
            'recursive' => -1
        ));
        $seller_id = $job['Job']['user_id'];
        $amount = $this->data['JobOrder']['amount'];
        $commission_amount = $this->data['JobOrder']['commission_amount'];
        $buyer_conditions['JobOrder.user_id'] = $buyer_id;
        $seller_conditions['Job.user_id'] = $seller_id;
        $conditions = array(
            'lost' => array(
                'JobOrder.job_order_status_id' => array(
                    ConstJobOrderStatus::Cancelled,
                    ConstJobOrderStatus::Rejected,
                    ConstJobOrderStatus::CancelledDueToOvertime,
                    ConstJobOrderStatus::CancelledByAdmin,
                )
            ) ,
            'pipeline' => array(
                'JobOrder.job_order_status_id' => array(
                    ConstJobOrderStatus::WaitingforAcceptance,
                    ConstJobOrderStatus::InProgress,
                    ConstJobOrderStatus::InProgressOvertime,
                    ConstJobOrderStatus::WaitingforReview,
                    ConstJobOrderStatus::Completed,
                    ConstJobOrderStatus::CompletedAndClosedByAdmin,
                )
            ) ,
            'cleared' => array(
                'JobOrder.job_order_status_id' => array(
                    ConstJobOrderStatus::PaymentCleared
                )
            )
        );
        foreach($conditions as $key => $value) {
            $this->update_seller($seller_conditions, $key, $value, $seller_id);
            $this->update_job($key, $value, $job_id);
        }
        // Updating inprogress overtime count in jobs and user table//
        if (!empty($this->data['JobOrder']['id'])) {
            $this->update_time_taken($this->data['JobOrder']['id']); // save time take to complete the order
            $order = $this->find('first', array(
                'conditions' => array(
                    'JobOrder.id' => $this->data['JobOrder']['id'],
                    'JobOrder.job_order_status_id' => ConstJobOrderStatus::InProgressOvertime,
                ) ,
                'contain' => array(
                    'Job'
                ) ,
                'recursive' => 1
            ));
            $total_overtime_count = 0;
            $overtime_conditions = array();
            $overtime_conditions['JobOrder.job_id'] = $order['JobOrder']['job_id'];
            $overtime_conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::InProgressOvertime;
            $total_overtime_count = $this->job_count($overtime_conditions);
            if (!empty($order)) {
                $this->Job->updateAll(array(
                    'Job.in_progress_overtime_meet_count' => ($total_overtime_count+1)
                ) , array(
                    'Job.id' => $order['JobOrder']['job_id']
                ));
                $jobs = $this->Job->find('all', array(
                    'conditions' => array(
                        'Job.id' => $order['Job']['id']
                    ) ,
                    'fields' => array(
                        'SUM(in_progress_overtime_meet_count) as total_inprogress_count',
                    ) ,
                    'recursive' => -1
                ));
                $this->User->updateAll(array(
                    'User.in_progress_overtime_meet_count' => $jobs[0][0]['total_inprogress_count']
                ) , array(
                    'User.id' => $order['JobOrder']['job_id']
                ));
            }
        }
    }
    function update_time_taken($job_order_id)
    {
        $order = $this->find('first', array(
            'conditions' => array(
                'JobOrder.id' => $job_order_id,
                'JobOrder.job_order_status_id' => ConstJobOrderStatus::Completed,
            ) ,
            'recursive' => -1
        ));
        if (!empty($order)) {
            $this->updateAll(array(
                'JobOrder.time_taken' => strtotime($order['JobOrder']['completed_date']) -strtotime($order['JobOrder']['accepted_date'])
            ) , array(
                'JobOrder.id' => $order['JobOrder']['id']
            ));
            $avg_time_taken = $this->find('all', array(
                'conditions' => array(
                    'JobOrder.job_id' => $order['JobOrder']['job_id'],
                    'NOT' => array(
                        'JobOrder.job_order_status_id' => array(
                            ConstJobOrderStatus::WaitingforAcceptance,
                            ConstJobOrderStatus::Cancelled,
                            ConstJobOrderStatus::Rejected,
                            ConstJobOrderStatus::Expired,
                            ConstJobOrderStatus::CancelledDueToOvertime,
                            ConstJobOrderStatus::CancelledByAdmin,
                            ConstJobOrderStatus::PaymentPending,
                            ConstJobOrderStatus::MutualCancelled,
                        )
                    )
                ) ,
                'fields' => array(
                    'AVG(JobOrder.time_taken) as avg_time_taken'
                ) ,
                'recursive' => -1
            ));
            $this->Job->updateAll(array(
                'Job.average_time_taken' => $avg_time_taken[0][0]['avg_time_taken']
            ) , array(
                'Job.id' => $order['JobOrder']['job_id']
            ));
        }
    }
    function update_job_order_status_count($data)
    {
        $updation = array();
        $conditions = array();
        // Getting job details //
        if (!empty($data['JobOrder']['id'])) {
            $job = $this->get_job($data['JobOrder']['id']);
        }
        if (!empty($job)) {
            // Total Order Received //
            $conditions['JobOrder.job_id'] = $job['JobOrder']['job_id'];
            $conditions['Not']['JobOrder.job_order_status_id'] = array(
                0,
                ConstJobOrderStatus::PaymentPending
            );
            $job_total_orders = $this->job_count($conditions);
            if (isset($job_total_orders)) {
                $updation['Job.order_received_count'] = $job_total_orders;
            }
            // Total Order Accepted //
            $conditions['JobOrder.job_order_status_id'] = array(
                ConstJobOrderStatus::InProgress,
                ConstJobOrderStatus::InProgressOvertime,
                ConstJobOrderStatus::WaitingforReview,
                ConstJobOrderStatus::Completed,
                ConstJobOrderStatus::CompletedAndClosedByAdmin,
                ConstJobOrderStatus::PaymentCleared,
            );
            $job_accepted_orders = $this->job_count($conditions);
            if (isset($job_accepted_orders)) {
                $updation['Job.order_accepted_count'] = $job_accepted_orders;
            }
            // Total Success Order without Overtime //
            $conditions = array();
            $conditions['JobOrder.job_id'] = $job['JobOrder']['job_id'];
            $conditions['JobOrder.job_order_status_id'] = array(
                ConstJobOrderStatus::Completed,
                ConstJobOrderStatus::CompletedAndClosedByAdmin,
                ConstJobOrderStatus::PaymentCleared,
            );
            $conditions['JobOrder.is_meet_inprogress_overtime'] = 0;
            $job_success_without_overtime_orders = $this->job_count($conditions);
            if (isset($job_success_without_overtime_orders)) {
                $updation['Job.order_success_without_overtime_count'] = $job_success_without_overtime_orders;
            }
            // Total Success Order with Overtime //
            $conditions = array();
            $conditions['JobOrder.job_id'] = $job['JobOrder']['job_id'];
            $conditions['JobOrder.job_order_status_id'] = array(
                ConstJobOrderStatus::Completed,
                ConstJobOrderStatus::CompletedAndClosedByAdmin,
                ConstJobOrderStatus::PaymentCleared,
            );
            $conditions['JobOrder.is_meet_inprogress_overtime'] = 1;
            $order_success_with_overtime_count = $this->job_count($conditions);
            if (isset($order_success_with_overtime_count)) {
                $updation['Job.order_success_with_overtime_count'] = $order_success_with_overtime_count;
            }
            // Total failure Order //
            $conditions = array();
            $conditions['JobOrder.job_id'] = $job['JobOrder']['job_id'];
            $conditions['JobOrder.job_order_status_id'] = array(
                ConstJobOrderStatus::CancelledDueToOvertime,
                ConstJobOrderStatus::CancelledByAdmin,
            );
            $job_failure_orders = $this->job_count($conditions);
            if (isset($job_failure_orders)) {
                $updation['Job.order_failure_count'] = $job_failure_orders;
            }
            // Current Active Order //
            $conditions = array();
            $conditions['JobOrder.job_id'] = $job['JobOrder']['job_id'];
            $conditions['JobOrder.job_order_status_id'] = array(
                ConstJobOrderStatus::InProgress,
                ConstJobOrderStatus::InProgressOvertime,
                ConstJobOrderStatus::WaitingforReview,
            );
            $job_active_orders = $this->job_count($conditions);
            if (isset($job_active_orders)) {
                $updation['Job.order_active_count'] = $job_active_orders;
            }
            // Last Order Accept Date //
            if (!empty($data['JobOrder']['job_order_status_id']) && $data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgress) {
                // Updating Jobs //
                $this->Job->updateAll(array(
                    'Job.order_last_accepted_date' => "'" . $data['JobOrder']['accepted_date'] . "'"
                ) , array(
                    'Job.id' => $job['JobOrder']['job_id']
                ));
                // Updating Users //
                $this->User->updateAll(array(
                    'User.order_last_accepted_date' => "'" . $data['JobOrder']['accepted_date'] . "'"
                ) , array(
                    'User.id' => $job['Job']['user_id']
                ));
            }
            // Updating all fields //
            if (!empty($updation)) {
                $this->Job->updateAll($updation, array(
                    'Job.id' => $job['JobOrder']['job_id']
                ));
            }
            // Updating seller information in seller //
            $this->update_seller_order_status_count($job['Job']['user_id']);
            // Updating buyer information in seller //
            $this->update_buyer_order_status_count($job['JobOrder']['user_id']);
        }
    }
    function update_buyer_order_status_count($job_order_user_id)
    {
        $conditions = array();
        $buyer_updation = array();
        // Total Order //
        $conditions['JobOrder.user_id'] = $job_order_user_id;
        $conditions['Not']['JobOrder.job_order_status_id'] = array(
            0,
            ConstJobOrderStatus::PaymentPending
        );
        $buyer_order_purchase_count = $this->job_count($conditions);
        $buyer_updation['User.buyer_order_purchase_count'] = $buyer_order_purchase_count;
        // Total Success with meet Overtime //
        $conditions['JobOrder.job_order_status_id'] = array(
            ConstJobOrderStatus::Completed,
            ConstJobOrderStatus::CompletedAndClosedByAdmin,
            ConstJobOrderStatus::PaymentCleared,
        );
        $conditions['JobOrder.is_meet_inprogress_overtime'] = 0;
        $buyer_order_sucess_without_overtime_count = $this->job_count($conditions);
        $buyer_updation['User.buyer_order_sucess_without_overtime_count'] = $buyer_order_sucess_without_overtime_count;
        // Total Success without meet Overtime //
        $conditions = array();
        $conditions['JobOrder.user_id'] = $job_order_user_id;
        $conditions['JobOrder.job_order_status_id'] = array(
            ConstJobOrderStatus::Completed,
            ConstJobOrderStatus::CompletedAndClosedByAdmin,
            ConstJobOrderStatus::PaymentCleared,
        );
        $conditions['JobOrder.is_meet_inprogress_overtime'] = 1;
        $buyer_order_sucess_with_overtime_count = $this->job_count($conditions);
        $buyer_updation['User.buyer_order_sucess_with_overtime_count'] = $buyer_order_sucess_with_overtime_count;
        // Current Active Order //
        $conditions = array();
        $conditions['JobOrder.user_id'] = $job_order_user_id;
        $conditions['JobOrder.job_order_status_id'] = array(
            ConstJobOrderStatus::InProgress,
            ConstJobOrderStatus::InProgressOvertime,
            ConstJobOrderStatus::WaitingforReview,
        );
        $buyer_order_active_count = $this->job_count($conditions);
        $buyer_updation['User.buyer_order_active_count'] = $buyer_order_active_count;
        // Updating all fields //
        if (!empty($buyer_updation)) {
            $this->User->updateAll($buyer_updation, array(
                'User.id' => $job_order_user_id
            ));
        }
    }
    function update_seller_order_status_count($job_user_id)
    {
        $update_seller_order_status_count = $this->Job->find('all', array(
            'conditions' => array(
                'Job.user_id' => $job_user_id
            ) ,
            'fields' => array(
                'SUM(Job.order_received_count) as order_received_count',
                'SUM(Job.order_accepted_count) as order_accepted_count',
                'SUM(Job.order_success_without_overtime_count) as order_success_without_overtime_count',
                'SUM(Job.order_success_with_overtime_count) as order_success_with_overtime_count',
                'SUM(Job.order_failure_count) as order_failure_count',
                'SUM(Job.order_active_count) as order_active_count',
				'SUM(Job.job_feedback_count) as job_feedback_count',
				'SUM(Job.positive_feedback_count) as positive_feedback_count',
				
            ) ,
            'recursive' => -1
        ));
        if (!empty($update_seller_order_status_count)) {
            $this->User->updateAll(array(
                'User.order_received_count' => $update_seller_order_status_count[0][0]['order_received_count'],
                'User.order_accepted_count' => $update_seller_order_status_count[0][0]['order_accepted_count'],
                'User.order_success_without_overtime_count' => $update_seller_order_status_count[0][0]['order_success_without_overtime_count'],
                'User.order_success_with_overtime_count' => $update_seller_order_status_count[0][0]['order_success_with_overtime_count'],
                'User.order_failure_count' => $update_seller_order_status_count[0][0]['order_failure_count'],
                'User.order_active_count' => $update_seller_order_status_count[0][0]['order_active_count'],
				'User.job_feedback_count' => $update_seller_order_status_count[0][0]['job_feedback_count'],
				'User.positive_feedback_count' => $update_seller_order_status_count[0][0]['positive_feedback_count'],
            ) , array(
                'User.id' => $job_user_id
            ));
        }
    }
    // common function to get job details //
    function get_job($job_order_id)
    {
        $job = $this->find('first', array(
            'conditions' => array(
                'JobOrder.id' => $job_order_id
            ) ,
            'contain' => array(
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.user_id',
                    ) ,
                )
            ) ,
            'recursive' => 1
        ));
        return $job;
    }
    // common function to get job counts for various conditions passed //
    function job_count($conditions)
    {
        $job_order_count = $this->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        return $job_order_count;
    }
    function update_seller($seller_conditions, $key, $value, $seller_id)
    {
        $conditions = $value;
        if ($key == 'lost') {
            $update_amount = 'sales_lost_amount';
            $update_count = 'sales_lost_count';
        } elseif ($key == 'pipeline') {
            $update_amount = 'sales_pipeline_amount';
            $update_count = 'sales_pipeline_count';
        } elseif ($key == 'cleared') {
            $update_amount = 'sales_cleared_amount';
            $update_count = 'sales_cleared_count';
        }
        $update_users = array();
        $get_job = $this->Job->find('list', array(
            'conditions' => $seller_conditions,
            'fields' => array(
                'Job.id',
            ) ,
            'recursive' => -1
        ));
        $seller_conditions = array();
        $update_users = array();
        $seller_conditions['JobOrder.job_id'] = $get_job;
        $seller_condition = array_merge($conditions, $seller_conditions);
        $update_users = $this->find('all', array(
            'conditions' => $seller_condition,
            'fields' => array(
                'SUM(JobOrder.amount) as total_sale_amount',
                'SUM(JobOrder.commission_amount) as total_sale_commission_amount',
                'COUNT(JobOrder.id) as total_sales',
            ) ,
            'recursive' => -1
        ));
        $updated_amount = $update_users['0']['0']['total_sale_amount']-$update_users['0']['0']['total_sale_commission_amount'];
		$this->User->updateAll(array(
            "User.$update_amount" => !empty($updated_amount) ? $updated_amount : 0,
            "User.$update_count" => !empty($update_users['0']['0']['total_sales']) ? $update_users['0']['0']['total_sales'] : 0
        ) , array(
            'User.id' => $seller_id
        ));

    }
    function update_job($key, $value, $job_id)
    {
        $job_conditions['JobOrder.job_id'] = $job_id;
        if ($key == 'lost') {
            $update_amount = 'sales_lost_amount';
            $update_count = 'sales_lost_count';
        } elseif ($key == 'pipeline') {
            $update_amount = 'sales_pipeline_amount';
            $update_count = 'sales_pipeline_count';
        } elseif ($key == 'cleared') {
            $update_amount = 'sales_cleared_amount';
            $update_count = 'sales_cleared_count';
        }
        $job_condition = array_merge($value, $job_conditions);
        $update_job = $this->find('all', array(
            'conditions' => $job_condition,
            'fields' => array(
                'SUM(JobOrder.amount) as total_sales_amount',
                'COUNT(JobOrder.id) as total_sales',
            ) ,
            'recursive' => -1
        ));
        $this->Job->updateAll(array(
            "Job.$update_amount" => !empty($update_job['0']['0']['total_sales_amount']) ? $update_job['0']['0']['total_sales_amount'] : 0,
            "Job.$update_count" => !empty($update_job['0']['0']['total_sales']) ? $update_job['0']['0']['total_sales'] : 0
        ) , array(
            'Job.id' => $job_id
        ));
    }
    function _generateVerificationCode()
    {
        return chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . '-' . substr(mt_rand() , 0, 6);
    }
    public function getReceiverdata($foreign_id, $transaction_type, $payee_account = null)
    {
        $JobOrder = $this->find('first', array(
            'conditions' => array(
                'JobOrder.id' => $foreign_id
            ) ,
            'contain' => array(
                'User',
                'Job' => array(
                    'User',
                ) ,
            ) ,
            'recursive' => 3,
        ));
        if ($transaction_type == ConstPaymentType::JobOrder) {
            if (!empty($JobOrder['JobOrder']['commission_amount'])) {
                $return['amount'] = array(
                    $JobOrder['JobOrder']['amount'],
                    $JobOrder['JobOrder']['commission_amount'],
                );
            } else {
                $return['amount'] = array(
                    $JobOrder['JobOrder']['amount'],
                    '1'
                );
            }
            $return['buyer_email'] = $JobOrder['User']['email'];
            $return['sudopay_receiver_account_id'] = $JobOrder['Job']['User']['sudopay_receiver_account_id'];
            $return['sudopay_gateway_id'] = $JobOrder['JobOrder']['sudopay_gateway_id'];
        }
        return $return;
    }
}
?>