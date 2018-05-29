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
class Wallet extends AppModel
{
    public $useTable = false;
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'Chart',
        );
        $this->validate = array(
            'amount' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            )
        );
    }
    function _checkMinimumAmount()
    {
        $amount = $this->data['Wallet']['amount'];
        if (!empty($amount) && $amount < Configure::read('wallet.min_wallet_amount')) {
            return false;
        }
        return true;
    }
    function _checkamount($amount)
    {
        if (!empty($amount) && !is_numeric($amount)) {
            $this->validationErrors['amount'] = __l('Amount should be Numeric');
        }
        if (empty($amount)) {
            $this->validationErrors['amount'] = __l('Required');
        }
        if (!empty($amount) && $amount < Configure::read('wallet.min_wallet_amount')) {
            $this->validationErrors['amount'] = __l('Amount should be greater than minimum amount');
        }
        if (Configure::read('wallet.max_wallet_amount') && !empty($amount) && $amount > Configure::read('wallet.max_wallet_amount')) {
            $currency_code = Configure::read('site.currency_id');
            Configure::write('site.currency', $GLOBALS['currencies'][$currency_code]['Currency']['symbol']);
            $this->validationErrors['amount'] = sprintf(__l('Given amount should lies from  %s%s to %s%s') , Configure::read('site.currency') , Configure::read('wallet.min_wallet_amount') , Configure::read('site.currency') , Configure::read('wallet.max_wallet_amount'));
        }
        return false;
    }
    function _checkMAximumAmount()
    {
        $amount = $this->data['Wallet']['amount'];
        if (Configure::read('wallet.max_wallet_amount') && !empty($amount) && $amount > Configure::read('wallet.max_wallet_amount')) {
            return false;
        }
        return true;
    }
    function processOrderPayment($order_id)
    {
        //$this->_saveIPNLog();
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
            throw new NotFoundException(__l('Invalid request'));
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
        $this->_doOrderProcess($job_buyer_account, $jobInfo, $job_id, $jobOrder, $order_id);
    }
    function _doOrderProcess($job_buyer_account, $jobInfo, $job_id, $jobOrder, $order_id)
    {
        App::import('Model', 'Jobs.Message');
        $this->Message = new Message();
        $this->Job->JobOrder->updateAll(array(
            'JobOrder.job_order_status_id' => ConstJobOrderStatus::WaitingforAcceptance
        ) , array(
            'JobOrder.id' => $jobOrder['JobOrder']['id']
        ));
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
        //$this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'];
        //$this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
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
        $this->Message->MessageContent->Behaviors->detach('SuspiciousWordsDetector');
        if (Configure::read('messages.is_send_internal_message')) {
            $is_auto = 1;
            $message_id = $this->Message->sendNotifications($to, $subject, $message, $order_id, $is_review = 0, $job_id, ConstJobOrderStatus::WaitingforAcceptance, '0', $is_auto);
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
                $message_id_buyer = $this->Message->sendNotifications($to_buyer, $subject_for_buyer, $message_for_buyer, $order_id, $is_review = 0, $job_id, ConstJobOrderStatus::SenderNotification, '0', $is_auto);
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
        /*Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
        '_addTrans' => array(
        'order_id' => 'JobOrder-' . $order_id,
        'name' => $jobInfo['Job']['title'],
        'total' => $transaction['Transaction']['amount']
        ) ,
        '_addItem' => array(
        'order_id' => 'JobOrder-' . $order_id,
        'sku' => 'PF' . $jobOrder['JobOrder']['id'],
        'name' => $jobInfo['Job']['title'],
        'unit_price' => $transaction['Transaction']['amount']
        ) ,
        '_setCustomVar' => array(
        'pd' => $job_id,
        'pfd' => $jobOrder['JobOrder']['id'],
        'ud' => $jobInfo['Job']['user_id'],
        )
        ));
        Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
        '_addTrans' => array(
        'order_id' => 'SiteCommision-' . $order_id,
        'name' => $jobInfo['Job']['title'],
        'total' => $jobInfo['Job']['commission_amount']
        ) ,
        '_addItem' => array(
        'order_id' => 'SiteCommision-' . $order_id,
        'sku' => 'PF' . $jobOrder['JobOrder']['id'],
        'name' => $jobInfo['Job']['title'],
        'unit_price' => $jobInfo['Job']['commission_amount']
        ) ,
        '_setCustomVar' => array(
        'pd' => $job_id,
        'pfd' => $jobOrder['JobOrder']['id'],
        'ud' => $jobInfo['Job']['user_id'],
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
        'pd' => $job_id,
        'pfd' => $jobOrder['JobOrder']['id'],
        'ud' => $jobInfo['Job']['user_id'],
        )
        ));
        Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
        '_trackEvent' => array(
        'category' => 'JobOrder',
        'action' => 'Order',
        'label' => 'Step 3',
        'value' => '',
        ) ,
        '_setCustomVar' => array(
        'pd' => $job_id,
        'pfd' => $jobOrder['JobOrder']['id'],
        'ud' => $jobInfo['Job']['user_id'],
        )
        ));*/
        return true;
    }
    function processOrder($data)
    {
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        switch ($data['type']) {
            case 'job':
                $job = $this->Job->find('first', array(
                    'conditions' => array(
                        'Job.id' => $data['item_id']
                    ) ,
                    'contain' => array(
                        'User' => array(
                            'UserProfile' => array()
                        ) ,
                    ) ,
                    'recursive' => 2
                ));
                if (empty($job)) {
                    throw new NotFoundException(__l('Invalid request'));
                }
                if (!empty($data['order_id'])) {
                    $JobOrder['id'] = $data['order_id'];
                } else {
                    $this->Job->JobOrder->create();
                }
                $JobOrder['user_id'] = $_SESSION['Auth']['User']['id'];
                $JobOrder['job_id'] = $job['Job']['id'];
                $JobOrder['amount'] = $job['Job']['amount'];
                $JobOrder['commission_amount'] = $job['Job']['commission_amount']; // Modified
                $JobOrder['owner_user_id'] = $job['Job']['user_id']; // Modified
                $JobOrder['payment_gateway_id'] = $data['payment_gateway_id'];
                $JobOrder['job_order_status_id'] = ConstJobOrderStatus::WaitingforAcceptance;
                // Delayed or Simple Payment //
                $this->Job->JobOrder->save($JobOrder, false);
                $order_id = $this->Job->JobOrder->id;
                $itemDetail['amount'] = $job['Job']['amount'];
                $itemDetail['seller_amount'] = $job['Job']['amount']-$job['Job']['commission_amount'];
                $itemDetail['site_amount'] = $job['Job']['commission_amount'];
                break;
        }
        App::import('Model', 'User');
        $this->User = new User();
        $buyer_info = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $_SESSION['Auth']['User']['id']
            ) ,
            'fields' => array(
                'User.id',
                'User.available_balance_amount',
                'User.available_wallet_amount',
            ) ,
            'recursive' => -1
        ));
        // Updating buyer balance //
        $update_buyer_balance = $buyer_info['User']['available_wallet_amount']-$job['Job']['amount'];
        $this->User->updateAll(array(
            'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
        ) , array(
            'User.id' => $_SESSION['Auth']['User']['id']
        ));
        // Writing transactions //
        $update_transaction['Transaction']['user_id'] = $_SESSION['Auth']['User']['id'];
        $update_transaction['Transaction']['foreign_id'] = ConstUserIds::Admin;
        $update_transaction['Transaction']['class'] = 'JobOrder';
        $update_transaction['Transaction']['amount'] = $job['Job']['amount'];
        $update_transaction['Transaction']['payment_gateway_id'] = $data['payment_gateway_id'];
        $update_transaction['Transaction']['description'] = 'Payment Success';
        $update_transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::BuyJob;
        $transaction_id = $this->Job->JobOrder->User->Transaction->log_data($update_transaction);
        $return['order_id'] = $order_id;
        return $return;
    }
    public function processAddtoWallet($user_add_wallet_amount_id, $payment_gateway_id = null)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $userAddWalletAmount = $this->User->UserAddWalletAmount->find('first', array(
            'conditions' => array(
                'UserAddWalletAmount.id = ' => $user_add_wallet_amount_id,
            ) ,
            'contain' => array(
                'User'
            ) ,
            'recursive' => 0
        ));
        if (empty($userAddWalletAmount)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($userAddWalletAmount['UserAddWalletAmount']['is_success'] == 0) {
            $data['Transaction']['user_id'] = $userAddWalletAmount['UserAddWalletAmount']['user_id'];
            $data['Transaction']['project_id'] = 0;
            $data['Transaction']['foreign_id'] = $userAddWalletAmount['UserAddWalletAmount']['id'];
            $data['Transaction']['class'] = 'UserAddWalletAmount';
            $data['Transaction']['amount'] = $userAddWalletAmount['UserAddWalletAmount']['amount'];
            $data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
            $data['Transaction']['gateway_fees'] = 0;
            $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
            $commision_transaction_id = $this->User->Transaction->log_data($data);
            //$this->log('$data starts');
            //$this->log($data);
            //$this->log('$data ends');
            //$this->log('commision_transaction_id starts');
            //$this->log($commision_transaction_id);
            //$this->log('commision_transaction_id ends');
            //$this->User->Transaction->log_data($user_add_wallet_amount_id, 'UserAddWalletAmount', $payment_gateway_id, ConstTransactionTypes::AmountAddedToWallet);
            $_Data['UserAddWalletAmount']['id'] = $user_add_wallet_amount_id;
            $_Data['UserAddWalletAmount']['is_success'] = 1;
            $this->User->UserAddWalletAmount->save($_Data);
            $User['id'] = $userAddWalletAmount['UserAddWalletAmount']['user_id'];
            $User['available_wallet_amount'] = $userAddWalletAmount['User']['available_wallet_amount']+$userAddWalletAmount['UserAddWalletAmount']['amount'];
            //$User['total_amount_deposited'] = $userAddWalletAmount['User']['total_amount_deposited']+$userAddWalletAmount['UserAddWalletAmount']['amount'];
            $this->User->save($User);
            /*
            Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
            '_addTrans' => array(
            'order_id' => 'Wallet-' . $userAddWalletAmount['UserAddWalletAmount']['id'],
            'name' => 'Wallet',
            'total' => $userAddWalletAmount['UserAddWalletAmount']['amount']
            ) ,
            '_addItem' => array(
            'order_id' => 'Wallet-' . $userAddWalletAmount['UserAddWalletAmount']['id'],
            'sku' => 'W' . $userAddWalletAmount['UserAddWalletAmount']['id'],
            'name' => 'Wallet',
            'category' => $userAddWalletAmount['User']['username'],
            'unit_price' => $userAddWalletAmount['UserAddWalletAmount']['amount']
            ) ,
            '_setCustomVar' => array(
            'ud' => $_SESSION['Auth']['User']['id'],
            'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
            )
            ));*/
            return true;
        } elseif (!empty($userAddWalletAmount['UserAddWalletAmount']['is_success'])) {
            return true;
        }
        return false;
    }
}
?>