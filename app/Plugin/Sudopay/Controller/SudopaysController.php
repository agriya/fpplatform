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
class SudopaysController extends AppController
{
    public function beforeFilter()
    {
        if (in_array($this->request->action, array(
            'success_payment',
            'cancel_payment',
            'process_payment',
            'process_ipn',
            'update_account',
        ))) {
            $this->Security->validatePost = false;
        }
        parent::beforeFilter();
    }
    public function admin_user_accounts()
    {
        $this->setAction('user_accounts');
    }
    public function user_accounts()
    {
        $s = $this->Sudopay->getSudoPayObject();
        $this->loadModel('Sudopay.SudopayPaymentGateway');
        $supported_gateways = $this->SudopayPaymentGateway->find('all', array(
            'conditions' => array(
                'SudopayPaymentGateway.is_marketplace_supported' => 1
            ) ,
            'recursive' => -1,
        ));
        $connected_gateways = array();
        App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
        $this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
        $connected_gateways = $this->SudopayPaymentGatewaysUser->find('list', array(
            'conditions' => array(
                'SudopayPaymentGatewaysUser.user_id' => $this->Auth->user('id') ,
            ) ,
            'fields' => array(
                'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id',
            ) ,
            'recursive' => -1,
        ));
        $this->set('user', $this->request->params['named']['user']);
        $this->set('connected_gateways', $connected_gateways);
        $this->set('supported_gateways', $supported_gateways);
        $this->set('request', $this->request->params['named']['request']);
    }
    public function payout_connections()
    {
		$this->pageTitle = __l('Payment Options / Payout Methods');
        $s = $this->Sudopay->getSudoPayObject();
        $this->loadModel('Sudopay.SudopayPaymentGateway');
        $supported_gateways = $this->SudopayPaymentGateway->find('all', array(
            'conditions' => array(
                'SudopayPaymentGateway.is_marketplace_supported' => 1
            ) ,
            'recursive' => -1,
        ));
        $connected_gateways = array();
        App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
        $this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
        $connected_gateways = $this->SudopayPaymentGatewaysUser->find('list', array(
            'conditions' => array(
                'SudopayPaymentGatewaysUser.user_id' => $this->Auth->user('id') ,
            ) ,
            'fields' => array(
                'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id',
            ) ,
            'recursive' => -1,
        ));
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id') ,
            ) ,
            'recursive' => -1,
        ));
        $this->set('user', $user);
        $this->set('connected_gateways', $connected_gateways);
        $this->set('supported_gateways', $supported_gateways);
    }
    public function add_account($gateway_id, $user_id, $request = '', $from = '')
    {
        App::import('Model', 'Sudopay.SudopayPaymentGateway');
        $this->SudopayPaymentGateway = new SudopayPaymentGateway();
        $SudopayPaymentGateway = $this->SudopayPaymentGateway->find('first', array(
            'conditions' => array(
                'SudopayPaymentGateway.sudopay_gateway_id' => $gateway_id,
            ) ,
            'recursive' => -1
        ));
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
            ) ,
            'recursive' => -1
        ));
        if (!empty($from)) {
            $return_url = Router::url(array(
                'controller' => 'sudopays',
                'action' => 'payout_connections'
            ) , true);
        } else {
            if (empty($request)) {
                $return_url = Router::url(array(
                    'controller' => 'jobs',
                    'action' => 'add'
                ) , true);
            } else {
                $return_url = Router::url(array(
                    'controller' => 'jobs',
                    'action' => 'add',
                    'request_id' => $request
                ) , true);
            }
        }
        $post = array(
            'gateway_id' => $gateway_id,
            'notify_url' => Cache::read('site_url_for_shell', 'long') . 'sudopays/update_account/' . $gateway_id . '/' . $user['User']['id'],
            'return_url' => $return_url
        );
        if (!empty($user['User']['sudopay_receiver_account_id'])) {
            $post['receiver'] = $user['User']['sudopay_receiver_account_id'];
        }
        $post['name'] = $user['User']['username'];
        $post['email'] = $user['User']['email'];
        $s = $this->Sudopay->getSudoPayObject();
        $create_account = $s->callCreateReceiverAccount($post);
        if (!empty($create_account['error']['message'])) {
            $this->Session->setFlash($create_account['error']['message'], 'default', null, 'error');
            if (empty($from)) {
                if (empty($request)) {
                    $this->redirect(array(
                        'controller' => 'jobs',
                        'action' => 'add',
                        'error' => '1'
                    ));
                } else {
                    $this->redirect(array(
                        'controller' => 'jobs',
                        'action' => 'add',
                        'request_id' => $request,
                        'error' => '1'
                    ));
                }
            } else {
                $this->redirect(array(
                    'controller' => 'sudopays',
                    'action' => 'payout_connections',
                    'error' => '1'
                ));
            }
        }
        header('location: ' . $create_account['gateways']['gateway_callback_url']);
        exit;
    }
    public function delete_account($gateway_id, $user_id, $request, $from)
    {
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        App::import('Model', 'Jobs.JobOrder');
        $this->JobOrder = new JobOrder();
        $job = $this->Job->find('first', array(
            'conditions' => array(
                'Job.user_id' => $user_id,
                'Job.is_active' => 1,
            ) ,
            'recursive' => -1
        ));
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
            ) ,
            'recursive' => -1
        ));
        $connected_gateways = $this->Sudopay->GetUserConnectedGateways($user_id);
        // Need to revise this
        $conditions = array();
        $conditions['JobOrder.owner_user_id'] = $user_id;
        $conditions['JobOrder.sudopay_gateway_id'] = $gateway_id;
        $conditions['Not']['JobOrder.job_order_status_id'] = array(
            ConstJobOrderStatus::Cancelled,
            ConstJobOrderStatus::Rejected,
            ConstJobOrderStatus::Expired,
            ConstJobOrderStatus::CancelledDueToOvertime,
            ConstJobOrderStatus::CancelledByAdmin,
            ConstJobOrderStatus::MutualCancelled,
            ConstJobOrderStatus::PaymentCleared,
        );
        $joborder = $this->JobOrder->find('first', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        if (empty($joborder)) { // check for joborder which are in penidng payment status which uses this payment gateway
            App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
            $this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
            $SudopayPaymentGatewaysUser = $this->SudopayPaymentGatewaysUser->find('first', array(
                'conditions' => array(
                    'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id' => $gateway_id,
                    'SudopayPaymentGatewaysUser.user_id' => $user_id,
                ) ,
                'recursive' => -1
            ));
            if (empty($job) || (!empty($job) && (count($connected_gateways) > 1)) || isPluginEnabled('Wallets')) { // Check for active job
                // From Account delete from sudopay
                $receiver_id = $user['User']['sudopay_receiver_account_id'];
                $s = $this->Sudopay->getSudoPayObject();
                $response = $s->callDisconnectGateway($gateway_id, $receiver_id);
                if (empty($response['error']['code'])) {
                    if ($this->SudopayPaymentGatewaysUser->delete($SudopayPaymentGatewaysUser['SudopayPaymentGatewaysUser']['id'])) {
                        $this->Session->setFlash(__l('You have successfully disconnected') , 'default', null, 'success');
                    }
                } else {
                    $this->Session->setFlash($response['error']['message'], 'default', null, 'error');
                    if (empty($from)) {
                        if (empty($request)) {
                            $this->redirect(array(
                                'controller' => 'jobs',
                                'action' => 'add',
                                'error' => '1'
                            ));
                        } else {
                            $this->redirect(array(
                                'controller' => 'jobs',
                                'action' => 'add',
                                'request_id' => $request,
                                'error' => '1'
                            ));
                        }
                    } else {
                        $this->redirect(array(
                            'controller' => 'sudopays',
                            'action' => 'payout_connections',
                            'error' => '1'
                        ));
                    }
                }
            } else {
                $this->Session->setFlash(sprintf(__l('Sorry you have active %s in your %s listing. So you can\'t disconnect this payment gateway.'), jobAlternateName(ConstJobAlternateName::Singular), jobAlternateName(ConstJobAlternateName::Singular)), 'default', null, 'error');
            }
        } else {
            $this->Session->setFlash(sprintf(__l('Sorry you have some %s orders which using this payment gateway. So you can\'t disconnect this payment gateway.'), jobAlternateName(ConstJobAlternateName::Singular)) , 'default', null, 'error');
        }
        if (empty($from)) {
            $this->redirect(array(
                'controller' => 'jobs',
                'action' => 'add',
            ));
        } else {
            $this->redirect(array(
                'controller' => 'sudopays',
                'action' => 'payout_connections',
            ));
        }
        $this->autoRender = false;
    }
    public function update_account($gateway_id, $user_id)
    {
        if (empty($gateway_id) || empty($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $s = $this->Sudopay->getSudoPayObject();
        if ($s->isValidIPNPost($_POST) && empty($_POST['error_code'])) {
            $this->loadModel('User');
            $data = array();
            $data['id'] = $user_id;
            $data['sudopay_receiver_account_id'] = $_POST['id'];
            $this->User->save($data);
            App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
            $this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
            $sudopayUser = $this->SudopayPaymentGatewaysUser->find('first', array(
                'conditions' => array(
                    'SudopayPaymentGatewaysUser.user_id' => $user_id,
                    'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id' => $_POST['gateway_id'],
                ) ,
                'recursive' => -1
            ));
            if (empty($sudopayUser)) {
                $data = array();
                $data['user_id'] = $user_id;
                $data['sudopay_payment_gateway_id'] = $_POST['gateway_id'];
                $this->SudopayPaymentGatewaysUser->create();
                $this->SudopayPaymentGatewaysUser->save($data);
            }
            $this->Session->setFlash(__l('You have successfully connected') , 'default', null, 'success');
        }
        $this->autoRender = false;
    }
    public function process_payment($foreign_id, $transaction_type)
    {
        $return = $this->Sudopay->processPayment($foreign_id, $transaction_type);
        if (!empty($return)) {
            return $return;
        }
        $this->autoRender = false;
    }
    /* public function process_ipn_test($foreign_id, $transaction_type)
    {
    $jsonArray = '{"id":"19763","action":"Marketplace-Auth","merchant_id":"7158","website_id":"17887","amount":"10.00","marketplace_receiver_id":"17166","marketplace_receiver_amount":"9.0","marketplace_fees_payer":"RECEIVER","marketplace_fixed_merchant_amount":"1.0","marketplace_variable_merchant_amount":"","currency_code":"USD","status":"Authorized","error_code":"0","error_message":"","paykey":"366dfeb2-f07a-4423-9be4-46a1428bef66","payment_date":"2013-11-18T17:33:24+05:30","buyer_email":"productdemo.user+user2@gmail.com","buyer_address":"Kodambakam","buyer_city":"Chennai","buyer_state":"tamilnadu","buyer_country":"IN","buyer_phone":"986574124","buyer_zip_code":"600031","gateway_id":"1","gateway_name":"PayPal Adaptive","gateway_responses":"","signature":"23a54698eb3aae801442835aafff09f0"}';
    $postarray = (array) json_decode($jsonArray);
    $this->_processPayment($foreign_id, $transaction_type, $postarray);
    }*/
    public function process_ipn($foreign_id, $transaction_type)
    {
        $this->Sudopay->_saveIPNLog();
        $s = $this->Sudopay->getSudoPayObject();
        if ($s->isValidIPNPost($_POST)) {
            $this->_processPayment($foreign_id, $transaction_type, $_POST);
        }
        $this->autoRender = false;
    }
    private function _processPayment($foreign_id, $transaction_type, $post)
    {
        $redirect = '';
        $s = $this->Sudopay->getSudoPayObject();
        switch ($transaction_type) {
            case ConstPaymentType::JobOrder:
                App::import('Model', 'Jobs.Job');
                App::import('Model', 'Payment');
                $this->Job = new Job();
                $this->Payment = new Payment();
                $_data = array();
                $_data['id'] = $foreign_id;
                $_data['sudopay_payment_id'] = $post['id'];
                $_data['sudopay_pay_key'] = $post['paykey'];
                $this->Job->JobOrder->save($_data);
                $jobOrder = $this->Job->JobOrder->find('first', array(
                    'conditions' => array(
                        'JobOrder.id' => $foreign_id
                    ) ,
                    'contain' => array(
                        'Job',
                    ) ,
                    'recursive' => 2
                ));
                $this->Payment->processOrderPayment($jobOrder['JobOrder']['id'], $post);
                $this->Sudopay->_savePaidLog($foreign_id, $post, 'JobOrder', 1);
                $this->Session->setFlash(sprintf(__l('You have successfully %s') , Configure::read('job.alt_name_for_' . $jobOrder['Job']['slug'] . '_singular_caps')) , 'default', null, 'success');
                if (isPluginEnabled('SocialMarketing')) {
                    $redirect = Router::url(array(
                        'controller' => 'social_marketings',
                        'action' => 'publish',
                        $foreign_id,
                        'type' => 'facebook',
                        'publish_action' => 'fund',
                    ) , true);
                } else {
                    $redirect = Router::url(array(
                        'controller' => 'jobs',
                        'action' => 'view',
                        $jobOrder['Job']['slug']
                    ) , true);
                }
                break;

            case ConstPaymentType::Wallet:
                if (isPluginEnabled('Wallets')) {
                    $this->loadModel('Wallets.Wallet');
                    $this->loadModel('User');
                    $_data = array();
                    $_data['UserAddWalletAmount']['id'] = $foreign_id;
                    $_data['UserAddWalletAmount']['sudopay_payment_id'] = $post['id'];
                    $_data['UserAddWalletAmount']['sudopay_pay_key'] = $post['paykey'];
                    $this->User->UserAddWalletAmount->save($_data);
                    $userAddWalletAmount = $this->User->UserAddWalletAmount->find('first', array(
                        'conditions' => array(
                            'UserAddWalletAmount.id' => $foreign_id
                        ) ,
                        'contain' => array(
                            'User'
                        ) ,
                        'recursive' => 1,
                    ));
                    if (empty($userAddWalletAmount)) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                    if (!empty($post['status']) && $post['status'] == 'Captured') {
                        if ($this->Wallet->processAddtoWallet($foreign_id, ConstPaymentGateways::SudoPay)) {
                            $this->Session->setFlash(__l('Amount added to wallet') , 'default', null, 'success');
                            $this->Sudopay->_savePaidLog($foreign_id, $post, 'UserAddWalletAmount', 1);
                        } else {
                            $this->Session->setFlash(__l('Amount could not be added to wallet') , 'default', null, 'error');
                        }
                    } else {
                        $this->Session->setFlash(__l('Amount could not be added to wallet') , 'default', null, 'error');
                    }
                }
                $redirect = Router::url(array(
                    'controller' => 'users',
                    'action' => 'dashboard',
                    'admin' => false,
                ) , true);
                break;
        }
        return $redirect;
    }
    public function success_payment($foreign_id, $transaction_type)
    {
        $this->Session->setFlash(__l('Payment successfully completed') , 'default', null, 'success');
        $redirect = $this->_getRedirectUrl($foreign_id, $transaction_type);
        $this->redirect($redirect);
    }
    public function cancel_payment($foreign_id, $transaction_type)
    {
        $this->Session->setFlash(__l('Payment Failed. Please, try again') , 'default', null, 'error');
        $redirect = $this->_getRedirectUrl($foreign_id, $transaction_type);
        $this->redirect($redirect);
    }
    private function _getRedirectUrl($foreign_id, $transaction_type)
    {
        switch ($transaction_type) {
            case ConstPaymentType::JobOrder:
                App::import('Model', 'Jobs.Job');
                $this->Job = new Job();
                $jobOrder = $this->Job->JobOrder->find('first', array(
                    'conditions' => array(
                        'JobOrder.id' => $foreign_id
                    ) ,
                    'contain' => array(
                        'Job'
                    ) ,
                    'recursive' => 0
                ));
                $redirect = Router::url(array(
                    'controller' => 'jobs',
                    'action' => 'view',
                    $jobOrder['Job']['slug']
                ) , true);
                break;

            case ConstPaymentType::Wallet:
                $redirect = Router::url(array(
                    'controller' => 'wallets',
                    'action' => 'add_to_wallet'
                ) , true);
                break;

            default:
                $redirect = Router::url('/');
                break;
        }
        return $redirect;
    }
    public function admin_sudopay_admin_info()
    {
        $this->loadModel('Sudopay.SudopayPaymentGateway');
        $this->loadModel('Sudopay.Sudopay');
        $response = $this->Sudopay->GetSudoPayGatewaySettings();
        $this->set('gateway_settings', $response);
        $supported_gateways = $this->SudopayPaymentGateway->find('all', array(
            'recursive' => -1,
        ));
        $used_gateway_actions = array(
            'Marketplace-Auth',
            'Marketplace-Auth-Capture',
            'Marketplace-Void',
            'Marketplace-Capture',
            'Capture'
        );
        $this->set(compact('supported_gateways', 'used_gateway_actions'));
    }
    public function confirmation($foreign_id, $transaction_type)
    {
        $this->pageTitle = __l('Payment Confirmation');
        $redirect = $this->_getRedirectUrl($foreign_id, $transaction_type);
        if ($transaction_type == ConstPaymentType::Wallet) {
            App::import('Model', 'Wallet.UserAddWalletAmount');
            $obj = new UserAddWalletAmount();
            $Data = $obj->find('first', array(
                'conditions' => array(
                    'UserAddWalletAmount.id' => $foreign_id,
                ) ,
                'contain' => array(
                    'User',
                ) ,
                'recursive' => 0
            ));
            $sudopay_token = $Data['UserAddWalletAmount']['sudopay_token'];
            $sudopay_revised_amount = $Data['UserAddWalletAmount']['sudopay_revised_amount'];
            $amount = $Data['UserAddWalletAmount']['amount'];
        }
        if (!empty($this->request->data) && !empty($this->request->data['Sudopay']['confirm'])) {
            $s = $this->Sudopay->GetSudoPayObject();
            $post_data = array();
            $post_data['confirmation_token'] = $sudopay_token;
            $response = $s->callCaptureConfirm($post_data);
            if (empty($response['error']['code'])) {
                if (!empty($response['status']) && $response['status'] == 'Pending') {
                    $return['pending'] = 1;
                } elseif (!empty($response['status']) && $response['status'] == 'Captured') {
                    $return['success'] = 1;
                } elseif (!empty($response['gateway_callback_url'])) {
                    header('location: ' . $response['gateway_callback_url']);
                    exit;
                }
            } else {
                $return['error'] = 1;
                $return['error_message'] = $response['error']['message'];
            }
            if (!empty($return['success'])) {
                if ($transaction_type == ConstPaymentType::Wallet) {
                    $obj->processAddtoWallet($foreign_id, ConstPaymentGateways::SudoPay);
                    $this->Session->setFlash(__l('Amount added to wallet') , 'default', null, 'success');
                }
            } elseif (!empty($return['error'])) {
                $return['error_message'].= '. ';
                $this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed.') , 'default', null, 'error');
            } elseif (!empty($return['pending'])) {
                $this->Session->setFlash(__l('Your payment is in pending.') , 'default', null, 'success');
            }
            $this->redirect($redirect);
        }
        $this->set(compact('amount', 'foreign_id', 'transaction_type', 'redirect', 'sudopay_revised_amount'));
    }
    public function admin_synchronize()
    {
        $s = $this->Sudopay->GetSudoPayObject();
        $currentPlan = $s->callPlan();
        if (!empty($currentPlan['error']['message'])) {
            if ($currentPlan['error']['message'] == 'MismatchOfPlanForAPI') {
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.live_mode_value' => ConstBrandType::VisibleBranding,
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::SudoPay,
                    'PaymentGatewaySetting.name' => 'is_payment_via_api'
                ));
            }
            $this->Session->setFlash($currentPlan['error']['message'], 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'payment_gateways',
                'action' => 'edit',
                ConstPaymentGateways::SudoPay,
                'admin' => true
            ));
        }
        if ($currentPlan['brand'] == 'Transparent Branding') {
            $plan = ConstBrandType::TransparentBranding;
        } elseif ($currentPlan['brand'] == 'Visible Branding') {
            $plan = ConstBrandType::VisibleBranding;
        } elseif ($currentPlan['brand'] == 'Any Branding') {
            $plan = ConstBrandType::AnyBranding;
        }
        $this->loadModel('PaymentGateway');
        $paymentGateway = $this->PaymentGateway->find('first', array(
            'fields' => array(
                'PaymentGateway.is_test_mode',
            ) ,
            'conditions' => array(
                'PaymentGateway.id' => ConstPaymentGateways::SudoPay
            ) ,
            'recursive' => -1
        ));
        if ($paymentGateway['PaymentGateway']['is_test_mode']) {
            $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                'PaymentGatewaySetting.test_mode_value' => $plan,
            ) , array(
                'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::SudoPay,
                'PaymentGatewaySetting.name' => 'is_payment_via_api'
            ));
            $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                'PaymentGatewaySetting.test_mode_value' => "'" . $currentPlan['name'] . "'",
            ) , array(
                'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::SudoPay,
                'PaymentGatewaySetting.name' => 'sudopay_subscription_plan'
            ));
        } else {
            $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                'PaymentGatewaySetting.live_mode_value' => $plan,
            ) , array(
                'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::SudoPay,
                'PaymentGatewaySetting.name' => 'is_payment_via_api'
            ));
            $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                'PaymentGatewaySetting.live_mode_value' => "'" . $currentPlan['name'] . "'",
            ) , array(
                'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::SudoPay,
                'PaymentGatewaySetting.name' => 'sudopay_subscription_plan'
            ));
        }
        $gateway_response = $s->callGateways();
        if (!empty($gateway_response['error']['message'])) {
            $this->Session->setFlash($gateway_response['error']['message'], 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'payment_gateways',
                'action' => 'edit',
                ConstPaymentGateways::SudoPay,
                'admin' => true
            ));
        }
        $this->loadModel('Sudopay.SudopayPaymentGateway');
        $this->loadModel('Sudopay.SudopayPaymentGroup');
        $this->SudopayPaymentGroup->deleteAll(array(
            '1 = 1'
        ));
        $this->SudopayPaymentGateway->deleteAll(array(
            '1 = 1'
        ));
        foreach($gateway_response['gateways'] as $gateway_group) {
            $group_data = array();
            $group_data['sudopay_group_id'] = $gateway_group['id'];
            $group_data['name'] = $gateway_group['name'];
            $group_data['thumb_url'] = $gateway_group['thumb_url'];
            $this->SudopayPaymentGroup->create();
            $this->SudopayPaymentGroup->save($group_data);
            $group_id = $this->SudopayPaymentGroup->id;
            foreach($gateway_group['gateways'] as $gateway) {
                $_data = array();
                $supported_actions = $gateway['supported_features'][0]['actions'];
                $_data['is_marketplace_supported'] = 0;
                if (in_array('Marketplace-Auth', $supported_actions)) {
                    $_data['is_marketplace_supported'] = 1;
                }
                $_data['sudopay_gateway_id'] = $gateway['id'];
                $_data['sudopay_gateway_details'] = serialize($gateway);
                $_data['name'] = $gateway['name'];
                $_data['sudopay_gateway_name'] = $gateway['display_name'];
                $_data['sudopay_payment_group_id'] = $group_id;
                $this->SudopayPaymentGateway->create();
                $this->SudopayPaymentGateway->save($_data);
            }
        }
        $this->Session->setFlash(sprintf(__l('%s have been synchronized') , __l('SudoPay Payment Gateways')) , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'payment_gateways',
            'action' => 'edit',
            ConstPaymentGateways::SudoPay,
            'admin' => true
        ));
    }
}
?>