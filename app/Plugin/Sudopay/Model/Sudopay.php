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
class Sudopay extends AppModel
{
    public $useTable = false;
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'buyer_email' => array(
                'rule2' => array(
                    'rule' => 'email',
                    'message' => __l('Must be a valid email')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'buyer_address' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'buyer_city' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'buyer_state' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'buyer_country' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'buyer_zip_code' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Zip code should be Numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'buyer_phone' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Phone should be Numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'credit_card_number' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'credit_card_expire' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'credit_card_name_on_card' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'credit_card_code' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
        );
    }
    public function _saveIPNLog()
    {
        App::import('Model', 'Sudopay.SudopayIpnLog');
        $this->SudopayIpnLog = new SudopayIpnLog();
        $sudopay_post_vars_in_str = $this->_parse_array_query($_POST);
        if (!empty($sudopay_post_vars_in_str)) {
            $sudopayIpnLog['post_variable'] = $sudopay_post_vars_in_str;
            $sudopayIpnLog['ip_id'] = $this->toSaveIp();
            $this->SudopayIpnLog->create();
            $this->SudopayIpnLog->save($sudopayIpnLog);
        }
    }
    public function _parse_array_query($array, $convention = '%s')
    {
        if (count($array) == 0) {
            return '';
        } else {
            $query = '';
            foreach($array as $key => $value) {
                if (is_array($value)) {
                    $new_convention = sprintf($convention, $key) . '[%s]';
                    $query.= $this->_parse_array_query($value, $new_convention);
                } else {
                    $key = urlencode($key);
                    $value = urlencode($value);
                    $query.= sprintf($convention, $key) . "=$value&";
                }
            }
            return $query;
        }
    }
    public function _savePaidLog($foreign_id, $paymentDetails, $class = '', $receiver_count = 2)
    {
        App::import('Model', 'Sudopay.SudopayTransactionLog');
        $this->SudopayTransactionLog = new SudopayTransactionLog();
        $sudopayTransactionLog['foreign_id'] = $foreign_id;
        $sudopayTransactionLog['class'] = $class;
        $sudopayTransactionLog['payment_id'] = !empty($paymentDetails['id']) ? $paymentDetails['id'] : '';
        $sudopayTransactionLog['amount'] = !empty($paymentDetails['amount']) ? $paymentDetails['amount'] : '';
        $sudopayTransactionLog['sudopay_pay_key'] = !empty($paymentDetails['paykey']) ? $paymentDetails['paykey'] : '';
        $sudopayTransactionLog['merchant_id'] = !empty($paymentDetails['merchant_id']) ? $paymentDetails['merchant_id'] : '';
        $sudopayTransactionLog['gateway_id'] = !empty($paymentDetails['gateway_id']) ? $paymentDetails['gateway_id'] : '';
        $sudopayTransactionLog['gateway_name'] = !empty($paymentDetails['gateway_name']) ? $paymentDetails['gateway_name'] : '';
        $sudopayTransactionLog['status'] = !empty($paymentDetails['status']) ? $paymentDetails['status'] : '';
        $sudopayTransactionLog['payment_type'] = !empty($paymentDetails['payment_type']) ? $paymentDetails['payment_type'] : '';
        $sudopayTransactionLog['buyer_email'] = !empty($paymentDetails['buyer_email']) ? $paymentDetails['buyer_email'] : '';
        $sudopayTransactionLog['buyer_address'] = !empty($paymentDetails['buyer_address']) ? $paymentDetails['buyer_address'] : '';
        $this->SudopayTransactionLog->create();
        $this->SudopayTransactionLog->save($sudopayTransactionLog);
    }
    public function processPayment($foreign_id, $transaction_type, $sudopay_data)
    {
        $s = $this->getSudoPayObject();
        $return['error'] = 0;
        $post_data = $this->getSudoPayPostData($foreign_id, $transaction_type, $sudopay_data);
        $callAction = $post_data['callAction'];
        $obj = $post_data['obj'];
        unset($post_data['callAction']);
        unset($post_data['obj']);
        $response = $s->
        {
            $callAction}($post_data);
            if (empty($response['error']['code'])) {
                $_data = array();
                $data['id'] = $foreign_id;
                if (!empty($response['status']) && $response['status'] == 'Pending' && $transaction_type == ConstPaymentType::JobOrder) {
                    $data['job_order_status_id'] = ConstJobOrderStatus::PaymentPending;
                }
                if (!empty($response['payment_id'])) {
                    $data['sudopay_payment_id'] = $response['payment_id'];
                    $data['sudopay_pay_key'] = $response['paykey'];
                }
                $obj->save($data, false);
                if (!empty($response['status']) && $response['status'] == 'Pending') {
                    $return['pending'] = 1;
                } elseif (!empty($response['status']) && $response['status'] == 'Captured') {
                    $return['success'] = 1;
                } elseif (!empty($response['confirmation'])) {
                    if ($transaction_type == ConstPaymentType::JobOrder) {
                        App::uses('Jobs.JobOrder', 'Model');
                        $obj = new JobOrder();
                    } elseif ($transaction_type == ConstPaymentType::Wallet) {
                        App::import('Model', 'Wallet.UserAddWalletAmount');
                        $obj = new UserAddWalletAmount();
                    }
                    $data['id'] = $foreign_id;
                    $data['sudopay_revised_amount'] = $response['revised_amount'];
                    $data['sudopay_token'] = $response['confirmation']['token'];
                    $obj->save($data, false);
                    $redirect = Router::url(array(
                        'controller' => 'sudopays',
                        'action' => 'confirmation',
                        $foreign_id,
                        $transaction_type,
                        'admin' => false
                    ) , true);
                    header('location: ' . $redirect);
                    exit;
                } elseif (!empty($response['gateway_callback_url'])) {
                    header('location: ' . $response['gateway_callback_url']);
                    exit;
                }
            } elseif (!empty($response['gateway_callback_url'])) {
                header('location: ' . $response['gateway_callback_url']);
                exit;
            } else {
                $return['error'] = 1;
                $return['error_message'] = $response['error']['message'];
                $return['status'] = $response['status'];
            }
            return $return;
        }
        public function getSudoPayPostData($foreign_id, $transaction_type, $sudopay_data = array())
        {
            $post_data = array();
            if ($transaction_type == ConstPaymentType::JobOrder) {
                App::import('Model', 'Jobs.JobOrder');
                $obj = new JobOrder();
                $jobOrder = $obj->find('first', array(
                    'contain' => array(
                        'Job',
                        'User',
                    ) ,
                    'conditions' => array(
                        'JobOrder.id' => $foreign_id
                    ) ,
                    'recursive' => 0
                ));
                $receiver_data = $obj->getReceiverdata($foreign_id, $transaction_type);
                $post_data['marketplace_receiver_amount'] = $receiver_data['amount']['0']-$receiver_data['amount']['1'];
                $post_data['marketplace_fixed_merchant_amount'] = $receiver_data['amount']['1'];
                $post_data['item_name'] = $jobOrder['Job']['title'];
                $post_data['item_description'] = __l('Fund Amount');
                $user_id = $jobOrder['Job']['user_id'];
            } elseif ($transaction_type == ConstPaymentType::Wallet) {
                App::import('Model', 'Wallets.UserAddWalletAmount');
                $obj = new UserAddWalletAmount();
                $user = $obj->find('first', array(
                    'conditions' => array(
                        'UserAddWalletAmount.id' => $foreign_id,
                    ) ,
                    'contain' => array(
                        'User',
                    ) ,
                    'recursive' => 0
                ));
                $receiver_data = $obj->getReceiverdata($foreign_id, $transaction_type);
                $post_data['item_name'] = __l('Add to Wallet');
                $post_data['item_description'] = sprintf(__l('%s added amount to wallet') , $user['User']['username']);
                $post_data['fees_payer'] = $receiver_data['fees_payer'];
                $user_id = $user['User']['id'];
            }
            App::import('Model', 'Sudopay.SudopayPaymentGateway');
            $this->SudopayPaymentGateway = new SudopayPaymentGateway();
            $sudopayPaymentGateway = $this->SudopayPaymentGateway->find('first', array(
                'conditions' => array(
                    'SudopayPaymentGateway.sudopay_gateway_id' => $receiver_data['sudopay_gateway_id']
                ) ,
                'recursive' => -1
            ));
            $s = $this->getSudoPayObject();
            $gateway_response = $s->callGateways();
            $form_fields_tpls = $gateway_response['_form_fields_tpls'];
            $sudopayGatewayDetails = unserialize($sudopayPaymentGateway['SudopayPaymentGateway']['sudopay_gateway_details']);
            $extends_tpl = $sudopayGatewayDetails['_form_fields']['_extends_tpl'];
            if (!empty($sudopayGatewayDetails['_form_fields']['_extends_tpl'])) {
                foreach($sudopayGatewayDetails['_form_fields']['_extends_tpl'] as $k => $value) {
                    foreach($gateway_response['_form_fields_tpls'][$value]['_fields'] as $key => $field) {
                        $form_field_arr[] = $key;
                    }
                }
            }
            if (!empty($sudopay_data) && !empty($receiver_data['sudopay_gateway_id'])) {
                foreach($sudopay_data as $k => $v) {
                    if (in_array($k, $form_field_arr)) {
                        $post_data[$k] = $v;
                    }
                }
            }
            $post_data['amount'] = $receiver_data['amount']['0'];
			$post_data['buyer_ip'] = $_SERVER['REMOTE_ADDR'];
            $post_data['gateway_id'] = $receiver_data['sudopay_gateway_id'];
            $post_data['currency_code'] = Configure::read('site.currency_code');
            $post_data['notify_url'] = Cache::read('site_url_for_shell', 'long') . 'sudopays/process_ipn/' . $foreign_id . '/' . $transaction_type;
            $post_data['cancel_url'] = Cache::read('site_url_for_shell', 'long') . 'sudopays/cancel_payment/' . $foreign_id . '/' . $transaction_type;
            $post_data['success_url'] = Cache::read('site_url_for_shell', 'long') . 'sudopays/success_payment/' . $foreign_id . '/' . $transaction_type;
            App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
            $this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
            $sudopayPaymentGatewaysUser = $this->SudopayPaymentGatewaysUser->find('list', array(
                'conditions' => array(
                    'SudopayPaymentGatewaysUser.user_id' => $user_id,
                    'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id' => $receiver_data['sudopay_gateway_id'],
                ) ,
                'fields' => array(
                    'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id',
                ) ,
                'recursive' => -1,
            ));
            if ($transaction_type == ConstPaymentType::JobOrder && $sudopayPaymentGateway['SudopayPaymentGateway']['is_marketplace_supported'] && !empty($sudopayPaymentGatewaysUser)) {
                $post_data['marketplace_receiver_id'] = $receiver_data['sudopay_receiver_account_id'];
                $callAction = 'callAuth';
                if (!empty($post_data['marketplace_fixed_merchant_amount'])) {
                    $callAction = 'callMarketplaceAuth';
                }
            } else {
                $callAction = 'callCapture';
            }
            $post_data['obj'] = $obj;
            $post_data['callAction'] = $callAction;
            return $post_data;
        }
        public function getSudoPayObject()
        {
            $gateway_settings_options = $this->GetSudoPayGatewaySettings();
            App::import('Vendor', 'Sudopay.sudopay');
            $this->s = new SudoPay_API(array(
                'api_key' => $gateway_settings_options['sudopay_api_key'],
                'merchant_id' => $gateway_settings_options['sudopay_merchant_id'],
                'website_id' => $gateway_settings_options['sudopay_website_id'],
                'secret_string' => $gateway_settings_options['sudopay_secret_string'],
                'is_test' => $gateway_settings_options['is_test_mode'],
                'cache_path' => CACHE . DS
            ));
            return $this->s;
        }
        public function GetSudoPayGatewaySettings()
        {
            App::import('Model', 'PaymentGateway');
            $this->PaymentGateway = new PaymentGateway();
            $paymentGateway = $this->PaymentGateway->find('first', array(
                'conditions' => array(
                    'PaymentGateway.id' => ConstPaymentGateways::SudoPay
                ) ,
                'contain' => array(
                    'PaymentGatewaySetting' => array(
                        'fields' => array(
                            'PaymentGatewaySetting.name',
                            'PaymentGatewaySetting.test_mode_value',
                            'PaymentGatewaySetting.live_mode_value',
                        ) ,
                    ) ,
                ) ,
                'recursive' => 1
            ));
            $gateway_settings_options['is_test_mode'] = (!empty($paymentGateway['PaymentGateway']['is_test_mode'])) ? 1 : 0;
            if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                    if ($paymentGateway['PaymentGateway']['is_test_mode']) {
                        $gateway_settings_options[$paymentGatewaySetting['name']] = $paymentGatewaySetting['test_mode_value'];
                    } else {
                        $gateway_settings_options[$paymentGatewaySetting['name']] = $paymentGatewaySetting['live_mode_value'];
                    }
                }
            }
            return $gateway_settings_options;
        }
        public function getGatewayGroups($tmp_gateways)
        {
            $gateways = array();
            if (!empty($tmp_gateways['gateways'])) {
                foreach($tmp_gateways['gateways'] as $group_gateway) {
                    if (!empty($group_gateway['gateways'])) {
                        unset($group_gateway['gateways']);
                        $gateways[] = $group_gateway;
                    }
                }
            }
            return $gateways;
        }
        public function isHavingPendingGatewayConnect($foreign_id)
        {
            App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
            $this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
            App::import('Model', 'Sudopay.SudopayPaymentGateway');
            $this->SudopayPaymentGateway = new SudopayPaymentGateway();
            $sudopaypaymentgateways_count = $this->SudopayPaymentGateway->find('count', array(
                'conditions' => array(
                    'SudopayPaymentGateway.is_marketplace_supported' => 1,
                ) ,
                'recursive' => -1,
            ));
            $connected_gateways = $this->SudopayPaymentGatewaysUser->find('list', array(
                'conditions' => array(
                    'SudopayPaymentGatewaysUser.user_id' => $foreign_id,
                ) ,
                'fields' => array(
                    'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id',
                ) ,
                'recursive' => -1,
            ));
            $connected_gateways_count = count($connected_gateways);
            if (($sudopaypaymentgateways_count == $connected_gateways_count)) {
                return 0;
            }
            return 1;
        }
        public function GetUserConnectedGateways($foreign_id)
        {
            App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
            $this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
            $connected_gateways = $this->SudopayPaymentGatewaysUser->find('list', array(
                'conditions' => array(
                    'SudopayPaymentGatewaysUser.user_id' => $foreign_id,
                ) ,
                'fields' => array(
                    'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id',
                ) ,
                'recursive' => -1,
            ));
            return $connected_gateways;
        }
        public function getGateways($tmp_gateways)
        {
            $gateways = array();
            if (!empty($tmp_gateways['gateways'])) {
                foreach($tmp_gateways['gateways'] as $group_gateway) {
                    if (!empty($group_gateway['gateways'])) {
                        foreach($group_gateway['gateways'] as $gateway) {
                            $gateway['group_id'] = $group_gateway['id'];
                            $gateways[] = $gateway;
                        }
                    }
                }
            }
            return $gateways;
        }
    }
?>