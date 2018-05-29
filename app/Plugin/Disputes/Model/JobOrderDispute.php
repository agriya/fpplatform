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
class JobOrderDispute extends AppModel
{
    public $name = 'JobOrderDispute';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
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
            'counterCache' => true
        ) ,
        'JobOrder' => array(
            'className' => 'Jobs.JobOrder',
            'foreignKey' => 'job_order_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'JobUserType' => array(
            'className' => 'Jobs.JobUserType',
            'foreignKey' => 'job_user_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'FavourJobUserType' => array(
            'className' => 'Jobs.JobUserType',
            'foreignKey' => 'favour_user_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
    );
    public $hasMany = array(
        'Message' => array(
            'className' => 'Jobs.Message',
            'foreignKey' => 'job_order_dispute_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->isFilterOptions = array(
            ConstDisputeStatus::Open => __l('Open') ,
            ConstDisputeStatus::UnderDiscussion => __l('UnderDiscussion') ,
            ConstDisputeStatus::WaitingForAdministratorDecision => __l('WaitingForAdministratorDecision') ,
            ConstDisputeStatus::Closed => __l('Closed') ,
        );
        $this->validate = array(
            'dispute_type_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'reason' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
        );
    }
    function _resolveByPaySeller($dispute)
    {
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'JobFeedback');
        $this->JobFeedback = new JobFeedback();
        $seller_user_id = $dispute['Job']['user_id'];
        $this->JobOrder->User->updateAll(array(
            'User.blocked_amount' => 'User.blocked_amount - ' . ($dispute['JobOrder']['amount']-$dispute['JobOrder']['commission_amount']) ,
            'User.available_balance_amount' => 'User.available_balance_amount + ' . ($dispute['JobOrder']['amount']-$dispute['JobOrder']['commission_amount'])
        ) , array(
            'User.id' => $seller_user_id
        ));
        // Change order status & completed_on datetime //
        $JobOrder['JobOrder']['id'] = $dispute['JobOrder']['id'];
        $JobOrder['JobOrder']['job_order_status_id'] = ConstJobOrderStatus::CompletedAndClosedByAdmin;
        $JobOrder['JobOrder']['completed_date'] = date('Y-m-d H:i:s');
        $this->JobOrder->save($JobOrder);
        // auto review update job feedback table [rating we used]
        $this->JobFeedback->create();
        //$jobFeedback['JobFeedback']['ip'] = $this->RequestHandler->getClientIP();
        $jobFeedback['JobFeedback']['job_id'] = $dispute['JobOrder']['job_id'];
        $jobFeedback['JobFeedback']['user_id'] = $dispute['JobOrder']['user_id'];
        $jobFeedback['JobFeedback']['feedback'] = 'Auto Review';
        $jobFeedback['JobFeedback']['is_satisfied'] = 1;
        $jobFeedback['JobFeedback']['is_auto_review'] = 1;
        $this->JobFeedback->save($jobFeedback, false);
        // Update Transactions //
        $transaction['Transaction']['user_id'] = $seller_user_id;
        $transaction['Transaction']['foreign_id'] = $dispute['JobOrder']['id'];
        $transaction['Transaction']['class'] = 'JobOrder';
        $transaction['Transaction']['amount'] = ($dispute['JobOrder']['amount']-$dispute['JobOrder']['commission_amount']);
        $transaction['Transaction']['description'] = 'Job - Amount paid for job to user';
        $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::PaidAmountToUser;
        $this->Transaction->save($transaction);
    }
    function _resolveByRefund($dispute)
    {
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
        if (!empty($dispute['JobOrder']['payment_gateway_id']) && $dispute['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) {
            $refund = $this->Payment->_refundProcessOrder($dispute['JobOrder']['id']);
        }
        if (empty($refund['error'])) {
            $update_seller_balance = $dispute['Job']['User']['blocked_amount']-($dispute['JobOrder']['amount']-$dispute['JobOrder']['commission_amount']); // seller blocked amount - actual job amount
            $update_buyer_balance = $dispute['JobOrder']['User']['available_wallet_amount']+$dispute['JobOrder']['amount']; // Buyer blocked amount + actual job amount
            // Change order status
            $JobOrder['JobOrder']['id'] = $dispute['JobOrder']['id'];
            $JobOrder['JobOrder']['job_order_status_id'] = ConstJobOrderStatus::CancelledByAdmin;
            $this->JobOrder->save($JobOrder);
            // Update amount to seller ->  reduce 5$ from seller //
            $this->JobOrder->User->updateAll(array(
                'User.blocked_amount' => "'" . $update_seller_balance . "'"
            ) , array(
                'User.id' => $dispute['Job']['user_id']
            ));
            if (!empty($dispute['JobOrder']['payment_gateway_id']) && $dispute['JobOrder']['payment_gateway_id'] != ConstPaymentGateways::SudoPay) { // Paypal adaptive reverse process shouldn't reduce from wallet
                // Update amount to Buyer -> add 5$ to buyer balance//
                $this->JobOrder->User->updateAll(array(
                    'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
                ) , array(
                    'User.id' => $dispute['JobOrder']['user_id']
                ));
            }
            // Update Transactions //
            $transaction['Transaction']['user_id'] = $dispute['JobOrder']['user_id'];
            $transaction['Transaction']['foreign_id'] = $dispute['JobOrder']['id'];
            $transaction['Transaction']['class'] = 'JobOrder';
            $transaction['Transaction']['amount'] = $dispute['JobOrder']['amount'];
            $transaction['Transaction']['description'] = "Job $stat_mess - Amount Refunded";
            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::CancelledByAdminRefundToBuyer;
            $this->JobOrder->User->Transaction->log_data($transaction);
            // Updating transaction again for seller //
            $transaction['Transaction']['id'] = '';
            $transaction['Transaction']['user_id'] = $dispute['Job']['user_id'];
            $transaction['Transaction']['foreign_id'] = $dispute['JobOrder']['id'];
            $transaction['Transaction']['class'] = 'JobOrder';
            $transaction['Transaction']['amount'] = ($dispute['JobOrder']['amount']-$dispute['JobOrder']['commission_amount']);
            $transaction['Transaction']['description'] = 'Updating payment status for seller';
            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::CancelledByAdminDeductFromSeller;
            $this->JobOrder->User->Transaction->save($transaction);
        }
    }
    function _resolveByReview($dispute)
    {
        $feedback = $this->Job->JobFeedback->_getFeedback($dispute['JobOrder']['id']);
        $update_feedback_message = __l("Based on Dispute ID#") . $dispute['JobOrderDispute']['id'] . ' ' . __l("Feedback has been changed by site administrator") . '. ';
        $update_feedback_message.= "<p>" . __l("Original Feedback:") . ' ' . $feedback['JobFeedback']['feedback'] . "</p>";
        $jobFeedback['JobFeedback']['id'] = $feedback['JobFeedback']['id'];
        $jobFeedback['JobFeedback']['feedback'] = $update_feedback_message;
        $jobFeedback['JobFeedback']['is_satisfied'] = 1;
        $this->Job->JobFeedback->save($jobFeedback, false);
    }
    function _closeDispute($close_type, $dispute)
    {
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        // SENDING CLOSE DISPUTE MAIL //
        $template = $this->EmailTemplate->selectTemplate("Dispute Resolved Notification");
        $emailFindReplace = array(
            '##ORDER_ID##' => $dispute['JobOrderDispute']['job_order_id'],
            '##DISPUTE_ID##' => $dispute['JobOrderDispute']['id'],
            '##DISPUTER##' => $dispute['User']['username'],
            '##DISPUTER_USER_TYPE##' => ucfirst($dispute['JobUserType']['name']) ,
            '##REASON##' => $dispute['JobOrderDispute']['reason'],
        );
        if (!empty($close_type['close_type_8'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Seller") . ' (' . $dispute['Job']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('8');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = ConstJobUserType::Seller;
        } elseif (!empty($close_type['close_type_4'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Seller") . ' (' . $dispute['Job']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('4');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = ConstJobUserType::Seller;
        } elseif (!empty($close_type['close_type_1'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Buyer") . ' (' . $dispute['JobOrder']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('1');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = ConstJobUserType::Buyer;
        } elseif (!empty($close_type['close_type_7'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Buyer") . ' (' . $dispute['JobOrder']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('7');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = ConstJobUserType::Buyer;
        } elseif (!empty($close_type['close_type_6'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Seller") . ' (' . $dispute['Job']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('6');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = ConstJobUserType::Seller;
        } elseif (!empty($close_type['close_type_9'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Seller") . ' (' . $dispute['Job']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('9');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = ConstJobUserType::Seller;
        } elseif (!empty($close_type['close_type_2'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Seller") . ' (' . $dispute['Job']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('2');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = ConstJobUserType::Seller;
        } elseif (!empty($close_type['close_type_3'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Buyer") . ' (' . $dispute['JobOrder']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('3');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = ConstJobUserType::Buyer;
        } elseif (!empty($close_type['close_type_5'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Buyer") . ' (' . $dispute['JobOrder']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('5');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = ConstJobUserType::Buyer;
        }
        if (Configure::read('messages.is_send_internal_message')) {
            $users = array(
                $dispute['Job']['User']['id'] => $dispute['Job']['User']['username'],
                $dispute['JobOrder']['User']['id'] => $dispute['JobOrder']['User']['username']
            );
            $k = 0;
            foreach($users as $key => $value) {
                $username = $value;
                $user = $key;
                $emailFindReplace['##USERNAME##'] = $username;
                $message = strtr($template['email_text_content'], $emailFindReplace);
                $subject = strtr($template['subject'], $emailFindReplace);
                $disp_stat = ($k == 0) ? ConstJobOrderStatus::DisputeClosed : ConstJobOrderStatus::DisputeClosedTemp;
                $is_auto = 1;
                $message_id = $this->Message->sendNotifications($user, $subject, $message, $dispute['JobOrderDispute']['job_order_id'], '0', $dispute['JobOrderDispute']['job_id'], $disp_stat, $dispute['JobOrderDispute']['id'], $is_auto);
                if (Configure::read('messages.is_send_email_on_new_message')) {
                    $sender_emails = array(
                        $dispute['Job']['User']['email'],
                        $dispute['User']['email']
                    );
					$sender_ids = array(
                        $dispute['Job']['User']['id'],
                        $dispute['User']['id']
                    );
                    $content['subject'] = $subject;
                    $content['message'] = $subject;
                    if ($this->_checkUserNotifications($sender_ids[$k], ConstJobOrderStatus::DisputeOpened, 0)) {
                        $this->_sendAlertOnNewMessage($sender_emails[$k], $content, $message_id, 'Order Alert Mail');
                    }
                    $k++;
                }
            }
        }
        // END OF SENDING MAIL //
        // UN-HOLDING ORDER PROCESS //
        $this->JobOrder->updateAll(array(
            'JobOrder.is_under_dispute' => 0
        ) , array(
            'JobOrder.id' => $dispute['JobOrderDispute']['job_order_id']
        ));
        // END OF HOLD //
        // UPDATING DISPUTE STATUS ORDER PROCESS //
        $this->updateAll(array(
            'JobOrderDispute.dispute_status_id' => ConstDisputeStatus::Closed,
            'JobOrderDispute.resolved_date' => "'" . date('Y-m-d H:i:s') . "'",
            'JobOrderDispute.favour_user_type_id' => $favour_user_type_id,
            'JobOrderDispute.dispute_closed_type_id' => $reason_for_closing['DisputeClosedType']['id'],
        ) , array(
            'JobOrderDispute.id' => $dispute['JobOrderDispute']['id']
        ));
        // END OF STATUS UPDATE //

    }
}
?>