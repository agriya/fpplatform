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
class Payment extends AppModel
{
    var $useTable = false;
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
    function processOrder($data)
    {
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        switch ($data['Payment']['type']) {
            case 'job':
                $job = $this->Job->find('first', array(
                    'conditions' => array(
                        'Job.id' => $data['Payment']['item_id']
                    ) ,
                    'contain' => array(
                        'User' => array(
                            'UserProfile' => array()
                        ) ,
                    ) ,
                    'recursive' => 2
                ));
                if (empty($job)) {
                    $this->cakeError('error404');
                }
                if (!empty($data['Payment']['order_id'])) {
                    $JobOrder['id'] = $data['Payment']['order_id'];
                } else {
                    $this->Job->JobOrder->create();
                }
                $JobOrder['user_id'] = $_SESSION['Auth']['User']['id'];
                $JobOrder['job_id'] = $job['Job']['id'];
                $JobOrder['amount'] = $job['Job']['amount'];
                $JobOrder['commission_amount'] = $job['Job']['commission_amount']; // Modified
                $JobOrder['owner_user_id'] = $job['Job']['user_id']; // Modified
                $JobOrder['payment_gateway_id'] = $data['Payment']['payment_type_id'];
                $JobOrder['sudopay_gateway_id'] = $data['Payment']['sudopay_gateway_id'];
                // Delayed or Simple Payment //
                $JobOrder['is_delayed_chained_payment'] = 0;
                $this->Job->JobOrder->save($JobOrder, false);
                $order_id = $this->Job->JobOrder->id;
                $itemDetail['amount'] = $job['Job']['amount'];
                $itemDetail['seller_amount'] = $job['Job']['amount']-$job['Job']['commission_amount'];
                $itemDetail['site_amount'] = $job['Job']['commission_amount'];
                //$itemDetail['seller_paypal_account'] = $job['User']['UserProfile']['paypal_account'];
                break;
        }
        if (!empty($data['Payment']['payment_type_id']) && $data['Payment']['payment_type_id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) {
            App::import('Model', 'Sudopay.Sudopay');
            $this->Sudopay = new Sudopay();
            $sudopay_gateway_settings = $this->Sudopay->GetSudoPayGatewaySettings();
            $this->set('sudopay_gateway_settings', $sudopay_gateway_settings);
            $return['error'] = 0;
            if ($sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
                $sudopay_data = $this->Sudopay->getSudoPayPostData($order_id, ConstPaymentType::JobOrder);
                $sudopay_data['merchant_id'] = $sudopay_gateway_settings['sudopay_merchant_id'];
                $sudopay_data['website_id'] = $sudopay_gateway_settings['sudopay_website_id'];
                $sudopay_data['secret_string'] = $sudopay_gateway_settings['sudopay_secret_string'];
                $sudopay_data['action'] = 'capture';
                $this->set('sudopay_data', $sudopay_data);
            } else {
                $data['Sudopay'] = !empty($data['Sudopay']) ? $data['Sudopay'] : '';
                $return = $this->Sudopay->processPayment($order_id, ConstPaymentType::JobOrder, $data['Sudopay']);
            }
            if (!empty($return['pending'])) {
                $this->Session->setFlash(__l('Your payment is in pending.') , 'default', null, 'success');
                $return['error'] = 1;
            } elseif (!empty($return['error'])) {
                $return['error_message'].= '. ';
                $return['error'] = 1;
            } elseif (!empty($return['success'])) {
                $return['error'] = 0;
            }
        }
        $return['job_id'] = $job['Job']['id'];
        $return['order_id'] = $order_id;
        return $return;
    }
    function _executeProcessOrder($order_id)
    {
		$return = array();
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        $jobInfo = $this->Job->JobOrder->find('first', array(
            'conditions' => array(
                'JobOrder.id' => $order_id,
            ) ,
            'contain' => array(
                'Job' => array(
                    'User' => array(
                        'UserProfile',
                    )
                ) ,
            ) ,
            'recursive' => 3,
        ));
        if (empty($jobInfo)) {
            $this->cakeError('error404');
        }
		App::import('Model', 'Sudopay.Sudopay');
		$this->Sudopay = new Sudopay();
		$s = $this->Sudopay->getSudoPayObject();
		$post['payment_id'] = $jobInfo['JobOrder']['sudopay_payment_id'];
		$post['gateway_id'] = $jobInfo['JobOrder']['sudopay_gateway_id'];
		$post['paykey'] = $jobInfo['JobOrder']['sudopay_pay_key'];
		App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
		$this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
		$sudopayPaymentGatewaysUser = $this->SudopayPaymentGatewaysUser->find('list', array(
			'conditions' => array(
				'SudopayPaymentGatewaysUser.user_id' => $jobInfo['Job']['user_id'],
				'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id' => $jobInfo['JobOrder']['sudopay_gateway_id'],
			) ,
			'fields' => array(
				'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id',
			) ,
			'recursive' => -1,
		)); 
		App::import('Model', 'Sudopay.SudopayPaymentGateway');
		$this->SudopayPaymentGateway = new SudopayPaymentGateway();
		$sudopayPaymentGateway = $this->SudopayPaymentGateway->find('first', array(
			'conditions' => array(
				'SudopayPaymentGateway.sudopay_gateway_id' => $jobInfo['JobOrder']['sudopay_gateway_id']
			) ,
			'recursive' => -1
		));
		if (!empty($sudopayPaymentGateway['SudopayPaymentGateway']['is_marketplace_supported'])&& !empty($sudopayPaymentGatewaysUser)) {
			$response = $s->callMarketplaceAuthCapture($post);
			if (!empty($response->error->code)) {
                    $return['error'] = 1;
                    $return['error_message'] = $response->error->message;
            }
		} else{
			$this->Job->User->updateAll(array(
					'User.available_wallet_amount' => "'" . ($jobInfo['Job']['User']['available_wallet_amount'] + ($jobInfo['JobOrder']['amount'] - $jobInfo['JobOrder']['commission_amount'])) . "'",
				) , array(
					'User.id' => $jobInfo['Job']['user_id']
				));
			$return['error'] = 0;
     	}
		return $return;
    }
    function _refundProcessOrder($order_id)
    {
        $return = array();
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        $jobInfo = $this->Job->JobOrder->find('first', array(
            'conditions' => array(
                'JobOrder.id' => $order_id,
            ) ,
            'contain' => array(
				'User',
                'Job' => array(
                    'User' => array(
                        'UserProfile',
                    )
                ) ,
            ) ,
            'recursive' => 3,
        ));
        if (empty($jobInfo)) {
            $this->cakeError('error404');
        }
        if ($jobInfo['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
            /* sudopay marketplace refund */
			
		App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
		$this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
		App::import('Model', 'Sudopay.SudopayPaymentGateway');
		$this->SudopayPaymentGateway = new SudopayPaymentGateway();
		
		$sudopayPaymentGateway = $this->SudopayPaymentGateway->find('first', array(
			'conditions' => array(
				'SudopayPaymentGateway.sudopay_gateway_id' => $jobInfo['JobOrder']['sudopay_gateway_id']
			) ,
			'recursive' => -1
		));
		
		$sudopayPaymentGatewaysUser = $this->SudopayPaymentGatewaysUser->find('list', array(
			'conditions' => array(
				'SudopayPaymentGatewaysUser.user_id' => $jobInfo['Job']['user_id'],
				'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id' => $jobInfo['JobOrder']['sudopay_gateway_id'],
			) ,
			'fields' => array(
				'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id',
			) ,
			'recursive' => -1,
		)); 
		
		
			
            App::import('Model', 'Sudopay.Sudopay');
            $this->Sudopay = new Sudopay();
            if (!empty($sudopayPaymentGateway['SudopayPaymentGateway']['is_marketplace_supported']) && !empty($sudopayPaymentGatewaysUser)) {
			    $s = $this->Sudopay->getSudoPayObject();
                $post['payment_id'] = $jobInfo['JobOrder']['sudopay_payment_id'];
                $post['gateway_id'] = $jobInfo['JobOrder']['sudopay_gateway_id'];
                $post['paykey'] = $jobInfo['JobOrder']['sudopay_pay_key'];
                $response = $s->callMarketplaceRefund($post);
                if (!empty($response->error->code)) {
                    $return['error'] = 1;
                    $return['error_message'] = $response->error->message;
                }
            } else {
                $this->Job->User->updateAll(array(
                    'User.available_wallet_amount' => "'" . ($jobInfo['User']['available_wallet_amount']+$jobInfo['JobOrder']['amount']) . "'"
                ) , array(
                    'User.id' => $jobInfo['JobOrder']['user_id']
                ));
            }
        } elseif ($jobInfo['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
            $this->Job->User->updateAll(array(
                'User.blocked_amount' => "'" . ($jobInfo['User']['blocked_amount']-$jobInfo['JobOrder']['amount']) . "'",
                'User.available_wallet_amount' => "'" . ($jobInfo['User']['available_wallet_amount']+$jobInfo['JobOrder']['amount']) . "'",
            ) , array(
                'User.id' => $jobInfo['JobOrder']['user_id']
            ));
            $return['error'] = 0;
        }
        return $return;
    }
	function _voidProcessOrder($order_id)
    {
        $return = array();
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        $jobInfo = $this->Job->JobOrder->find('first', array(
            'conditions' => array(
                'JobOrder.id' => $order_id,
            ) ,
            'contain' => array(
				'User',
                'Job' => array(
                    'User' => array(
                        'UserProfile',
                    )
                ) ,
            ) ,
            'recursive' => 3,
        ));
        if (empty($jobInfo)) {
            $this->cakeError('error404');
        }
        if ($jobInfo['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
            /* sudopay marketplace refund */
			
		App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
		$this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
		App::import('Model', 'Sudopay.SudopayPaymentGateway');
		$this->SudopayPaymentGateway = new SudopayPaymentGateway();
		
		$sudopayPaymentGateway = $this->SudopayPaymentGateway->find('first', array(
			'conditions' => array(
				'SudopayPaymentGateway.sudopay_gateway_id' => $jobInfo['JobOrder']['sudopay_gateway_id']
			) ,
			'recursive' => -1
		));
		
		$sudopayPaymentGatewaysUser = $this->SudopayPaymentGatewaysUser->find('list', array(
			'conditions' => array(
				'SudopayPaymentGatewaysUser.user_id' => $jobInfo['Job']['user_id'],
				'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id' => $jobInfo['JobOrder']['sudopay_gateway_id'],
			) ,
			'fields' => array(
				'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id',
			) ,
			'recursive' => -1,
		)); 
		
            App::import('Model', 'Sudopay.Sudopay');
            $this->Sudopay = new Sudopay();
            if (!empty($sudopayPaymentGateway['SudopayPaymentGateway']['is_marketplace_supported']) && !empty($sudopayPaymentGatewaysUser)) {
			    $s = $this->Sudopay->getSudoPayObject();
                $post['payment_id'] = $jobInfo['JobOrder']['sudopay_payment_id'];
                $post['gateway_id'] = $jobInfo['JobOrder']['sudopay_gateway_id'];
                $post['paykey'] = $jobInfo['JobOrder']['sudopay_pay_key'];
                $response = $s->callMarketplaceVoid($post);
                if (!empty($response->error->code)) {
                    $return['error'] = 1;
                    $return['error_message'] = $response->error->message;
                }
            } else {
                $this->Job->User->updateAll(array(
                    'User.available_wallet_amount' => "'" . ($jobInfo['User']['available_wallet_amount']+$jobInfo['JobOrder']['amount']) . "'"
                ) , array(
                    'User.id' => $jobInfo['JobOrder']['user_id']
                ));
            }
        } elseif ($jobInfo['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
            $this->Job->User->updateAll(array(
                'User.blocked_amount' => "'" . ($jobInfo['User']['blocked_amount']-$jobInfo['JobOrder']['amount']) . "'",
                'User.available_wallet_amount' => "'" . ($jobInfo['User']['available_wallet_amount']+$jobInfo['JobOrder']['amount']) . "'",
            ) , array(
                'User.id' => $jobInfo['JobOrder']['user_id']
            ));
            $return['error'] = 0;
        }
        return $return;
    }
    function processOrderPayment($order_id, $paymentDetails)
    {
        // $this->_saveIPNLog();
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $jobOrder = $this->Job->JobOrder->find('first', array(
            'conditions' => array(
                'JobOrder.id' => $order_id
            ) ,
            'recursive' => -1
        ));
        if (empty($jobOrder)) {
            $this->cakeError('error404');
        }
        $job_id = $jobOrder['JobOrder']['job_id'];
        $jobInfo = $this->Job->find('first', array(
            'conditions' => array(
                'Job.id' => $job_id
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.blocked_amount',
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        $job_buyer_account = $this->Job->JobOrder->User->find('first', array(
            'conditions' => array(
                'User.id' => $jobOrder['JobOrder']['user_id']
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.email',
                'User.available_balance_amount',
                'User.available_purchase_amount',
                'User.blocked_amount'
            ) ,
            'recursive' => -1
        ));
            if (!empty($paymentDetails['status']) && in_array($paymentDetails['status'], array(
                'Authorized',
                'Captured'
            ))) {
                if (empty($paymentDetails['error_code']) && (empty($jobOrder['JobOrder']['job_order_status_id']) || $jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::PaymentPending)) {
                    //$this->_savePaidLog($order_id, $paymentDetails);
                    $data['Transaction']['user_id'] = $job_buyer_account['User']['id'];
                    $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                    $data['Transaction']['class'] = 'JobOrder';
                    $data['Transaction']['amount'] = $jobInfo['Job']['amount'];
                    $data['Transaction']['payment_gateway_id'] = $jobOrder['JobOrder']['payment_gateway_id'];
                    $data['Transaction']['description'] = 'Payment Success';
                    $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::BuyJob;
                    $transaction_id = $this->Job->JobOrder->User->Transaction->log_data($data);
                    $this->_doOrderProcess($job_buyer_account, $jobInfo, $job_id, $jobOrder, $order_id, $paymentDetails, $transaction_id);
                }
            } else if (!empty($paymentDetails['status']) && in_array($paymentDetails['status'], array(
				'Voided',
				'Refunded',
				'Canceled'
			))) {
				if ($jobOrder['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::CancelledByAdmin) {
					$this->Job->JobOrder->processOrder($jobOrder['JobOrder']['id'], 'cancel');
				}
			}
    }
    function _doOrderProcess($job_buyer_account, $jobInfo, $job_id, $jobOrder, $order_id, $paymentDetails, $transaction_id)
    {
        $JobOrder['job_order_status_id'] = ConstJobOrderStatus::WaitingforAcceptance;
        $JobOrder['id'] = $jobOrder['JobOrder']['id'];
        $this->Job->JobOrder->save($JobOrder, false);
        $update_seller_balance = $jobInfo['User']['blocked_amount']+($jobInfo['Job']['amount']-$jobInfo['Job']['commission_amount']); // Owner blocked amount + (actual job amount - commision amount)
        $this->Job->JobOrder->User->updateAll(array(
            'User.blocked_amount' => "'" . $update_seller_balance . "'"
        ) , array(
            'User.id' => $jobInfo['Job']['user_id']
        ));
        $getSellerrating = $this->getJobRating($jobInfo['Job']['job_feedback_count'], $jobInfo['Job']['positive_feedback_count']);
        // Notification Message //
        $to = $jobInfo['Job']['user_id'];
        $to_buyer = $job_buyer_account['User']['id'];
        $sender_email = $jobInfo['User']['email'];
        $buyer_email = $job_buyer_account['User']['email'];
        $template = $this->EmailTemplate->selectTemplate('New order notification');
        $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'];
        $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
        $emailFindReplace = array(
            '##USERNAME##' => $jobInfo['User']['username'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##JOB_NAME##' => "<a href=" . Router::url(array(
                'controller' => 'jobs',
                'action' => 'view',
                $jobInfo['Job']['slug'],
            ) , true) . ">" . $jobInfo['Job']['title'] . "</a>",
            '##BUYER_USERNAME##' => $job_buyer_account['User']['username'],
            '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
            '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
            '##ACCEPT_URL##' => "<a href=" . Router::url(array(
                'controller' => 'job_orders',
                'action' => 'update_order',
                'order' => 'accept',
                'job_order_id' => $order_id,
            ) , true) . ">" . __l('Accept your order') . "</a>",
            '##REJECT_URL##' => "<a href=" . Router::url(array(
                'controller' => 'job_orders',
                'action' => 'update_order',
                'order' => 'reject',
                'job_order_id' => $order_id,
            ) , true) . ">" . __l('Cancel your order') . "</a>",
            '##CANCEL_URL##' => "<a href=" . Router::url(array(
                'controller' => 'job_orders',
                'action' => 'update_order',
                'order' => 'cancel',
                'job_order_id' => $order_id,
            ) , true) . ">" . __l('Cancel your order') . "</a>",
            '##BALANCE_LINK##' => "<a href=" . Router::url(array(
                'controller' => 'job_orders',
                'action' => 'index',
                'type' => 'balance'
            ) , true) . ">" . Configure::read('site.name') . ' ' . __l('balance') . "</a>",
            '##ORDER_NO##' => $order_id,
            '##JOB_FULL_NAME##' => "<a href=" . Router::url(array(
                'controller' => 'jobs',
                'action' => 'view',
                $jobInfo['Job']['slug']
            ) , true) . ">" . $jobInfo['Job']['title'] . "</a>",
            '##JOB_DESCRIPTION##' => $jobInfo['Job']['description'],
            '##JOB_ORDER_COMPLETION_DATE##' => $jobInfo['Job']['no_of_days'],
            '##JOB_AUTO_EXPIRE_DATE##' => (Configure::read('job.auto_expire') *24) ,
            '##CONTACT_LINK##' => Router::url(array(
                'controller' => 'contacts',
                'action' => 'add',
                'admin' => false
            ) , true) ,
            '##CONTACT_LINK##' => "<a href=" . Router::url(array(
                'controller' => 'contacts',
                'action' => 'add',
            ) , true) . ">" . Router::url(array(
                'controller' => 'contacts',
                'action' => 'add',
            ) , true) . "</a>",
            '##SELLER_NAME##' => $jobInfo['User']['username'],
            '##SELLER_RATING##' => (!empty($getSellerrating) && is_numeric($getSellerrating)) ? $getSellerrating . '% ' . __l('Positive') : __l('Not Rated Yet') ,
            '##SELLER_CONTACT_LINK##' => "<a href=" . Router::url(array(
                'controller' => 'messages',
                'action' => 'compose',
                'type' => 'contact',
                'to' => $jobInfo['User']['username'],
            ) , true) . ">" . 'contact seller' . "</a>"
        );
        $message = strtr($template['email_text_content'], $emailFindReplace);
        $subject = strtr($template['subject'], $emailFindReplace);
        $this->Job->JobOrder->User->Message->MessageContent->Behaviors->detach('SuspiciousWordsDetector');
        if (Configure::read('messages.is_send_internal_message')) {
			$is_auto = 1;
            $message_id = $this->Job->JobOrder->User->Message->sendNotifications($to, $subject, $message, $order_id, $is_review = 0, $job_id, ConstJobOrderStatus::WaitingforAcceptance,'0',$is_auto);
            if (Configure::read('messages.is_send_email_on_new_message')) {
                $content['subject'] = __l('You have a new order');
                $content['message'] = __l('You have a new order');
                if (!empty($sender_email)) {
                    if ($this->_checkUserNotifications($to, ConstJobOrderStatus::WaitingforAcceptance, 0)) { // (to_user_id, order_status,is_sender);
						$this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                    }
                }
            }
            $template = $this->EmailTemplate->selectTemplate('New order buyer notification');
            $emailFindReplace['##USERNAME##'] = $job_buyer_account['User']['username'];
            $message_for_buyer = strtr($template['email_text_content'], $emailFindReplace);
            $subject_for_buyer = strtr($template['subject'], $emailFindReplace);
            if (Configure::read('messages.send_notification_mail_for_sender')) {
				$is_auto = 1;
                $message_id_buyer = $this->Job->JobOrder->User->Message->sendNotifications($to_buyer, $subject_for_buyer, $message_for_buyer, $order_id, $is_review = 0, $job_id, ConstJobOrderStatus::SenderNotification,'0',$is_auto);
                if (Configure::read('messages.is_send_email_on_new_message')) {
                    $content['subject'] = __l('Your order has been placed');
                    $content['message'] = __l('Your order has been placed');
                    if (!empty($buyer_email)) {
                        if ($this->_checkUserNotifications($to_buyer, ConstJobOrderStatus::WaitingforAcceptance, 1)) { // (to_user_id, order_status,is_sender);
                            $this->_sendAlertOnNewMessage($buyer_email, $content, $message_id_buyer, 'Order Alert Mail');
                        }
                    }
                }
            }
        }
        if (!empty($transaction_id)) {
            $transaction['Transaction']['id'] = $transaction_id;
            $transaction['Transaction']['foreign_id'] = $order_id;
            $transaction['Transaction']['class'] = 'JobOrder';
            $this->Job->JobOrder->User->Transaction->save($transaction);
        }
        // Updating transaction again for seller //
        $transaction['Transaction']['id'] = '';
        $transaction['Transaction']['user_id'] = $jobInfo['Job']['user_id'];
        $transaction['Transaction']['foreign_id'] = $order_id;
        $transaction['Transaction']['class'] = 'JobOrder';
        $transaction['Transaction']['amount'] = ($jobInfo['Job']['amount']-$jobInfo['Job']['commission_amount']);
        $transaction['Transaction']['description'] = 'Updating payment status for seller';
        $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::AmountTransferredForSeller;
        $this->Job->JobOrder->User->Transaction->save($transaction);
        return true;
    }
}
?>