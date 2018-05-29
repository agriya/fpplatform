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
class PaymentsController extends AppController
{
    public $name = 'Payments';
    public $uses = array(
        'Payment',
        'PaymentGateway'
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Payment.connect',
            'Payment.wallet',
            'Payment.normal',
            'Payment.payment_type',
            'Payment.payment_gateway_id',
            'User.payment_gateway_id',
            'User.wallet',
            'User.normal',
            'User.payment_id',
            'JobOrder',
            'Sudopay'
        );
        parent::beforeFilter();
    }
    public function get_gateways()
    {
        App::import('Model', 'User');
        $this->loadModel('User');
        $countries = $this->User->UserProfile->Country->find('list', array(
            'fields' => array(
                'Country.iso_alpha2',
                'Country.name'
            ) ,
            'order' => array(
                'Country.name' => 'ASC'
            ) ,
            'recursive' => -1,
        ));
        $user_profile = $this->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $this->Auth->user('id') ,
            ) ,
            'contain' => array(
                'User',
            ) ,
            'recursive' => 0,
        ));
        // If wallet plugin is disabled stage; we only display Seller's connected gateways
        $gateway_ids = $gatewaygroup_ids = array();
        if (!isPluginEnabled('Wallets')) {
            $this->loadModel('Sudopay.SudopayPaymentGatewaysUser');
            $this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
            $this->loadModel('Sudopay.SudopayPaymentGateway');
            $this->SudopayPaymentGateway = new SudopayPaymentGateway();
            $gateway_ids = "";
            $gatewaygroup_ids = "";
            $connected_gateways = $this->SudopayPaymentGatewaysUser->find('all', array(
                'conditions' => array(
                    'SudopayPaymentGatewaysUser.user_id' => $this->request->params['named']['foreign_id'],
                ) ,
                'contain' => array(
                    'SudopayPaymentGateway',
                ) ,
                'recursive' => 0,
            ));
            foreach($connected_gateways as $gateway_id) {
                $connected_gateways_group = $this->SudopayPaymentGateway->find('first', array(
                    'conditions' => array(
                        'SudopayPaymentGateway.sudopay_gateway_id' => $gateway_id['SudopayPaymentGatewaysUser']['sudopay_payment_gateway_id'],
                    ) ,
                    'contain' => array(
                        'SudopayPaymentGroup',
                    ) ,
                    'recursive' => 0
                ));
                $gateway_ids = $gateway_id['SudopayPaymentGatewaysUser']['sudopay_payment_gateway_id'] . "," . $gateway_ids;
                $gatewaygroup_ids = $connected_gateways_group['SudopayPaymentGroup']['sudopay_group_id'] . "," . $gatewaygroup_ids;
            }
            $gateway_ids = explode(",", $gateway_ids);
            $gatewaygroup_ids = explode(",", $gatewaygroup_ids);
        } // end of, if wallet disabled codes
        if (!empty($this->request->params['named']['type'])) {
            $type = $this->request->params['named']['type'];
            $gateway_types = $this->Payment->getGatewayTypes($type);
        } else {
            $gateway_types = $this->Payment->getGatewayTypes();
        }
        if (isPluginEnabled('Sudopay') && !empty($gateway_types[ConstPaymentGateways::SudoPay])) {
            $this->request->data[$this->request->params['named']['model']]['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
        } elseif (isPluginEnabled('Wallets') && !empty($gateway_types[ConstPaymentGateways::Wallet])) {
            $this->request->data[$this->request->params['named']['model']]['payment_gateway_id'] = ConstPaymentGateways::Wallet;
        }
        if (isPluginEnabled('Sudopay')) {
            $this->loadModel('Sudopay.Sudopay');
            $this->Sudopay = new Sudopay();
            $response = $this->Sudopay->GetSudoPayGatewaySettings();
            $this->set('response', $response);
        }
        $this->set('model', $this->request->params['named']['model']);
        $this->set('foreign_id', $this->request->params['named']['foreign_id']);
        $this->set('transaction_type', $this->request->params['named']['transaction_type']);
        $this->set(compact('countries', 'user_profile', 'gateway_types', 'gateway_ids', 'gatewaygroup_ids'));
    }
    function order($id = null, $type = 'job', $gateway = null)
    {
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        if (!empty($this->request->data)) {
            $id = $this->request->data['Payment']['item_id'];
            $is_error = 0;
            // Quickfix, when button name doesn't get POSTed coz of ajax post //
            if ($this->request->data['Payment']['payment_gateway_id'] != ConstPaymentGateways::Wallet && strpos($this->request->data['Payment']['payment_gateway_id'], 'sp_') >= 0) {
                $PaymentGateway['PaymentGateway']['id'] = ConstPaymentGateways::SudoPay;
                $this->request->data['Payment']['sudopay_gateway_id'] = str_replace('sp_', '', $this->request->data['Payment']['payment_gateway_id']);
                $this->request->data['Payment']['payment_type_id'] = ConstPaymentGateways::SudoPay;
                $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
            } elseif (!empty($this->request->data['Payment']['payment_gateway_id']) && $this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                $this->request->data['Payment']['payment_type_id'] = ConstPaymentGateways::Wallet;
            }
            // -- -- -- //
            /* if (!empty($this->request->data['Payment']['connect']) || !empty($this->request->data['Payment']['normal'])) { // For SudoPay
            $this->request->data['Payment']['payment_type_id'] = ConstPaymentGateways::SudoPay;

            } elseif (!empty($this->request->data['Payment']['wallet'])) { // For Wallet
            $this->request->data['Payment']['payment_type_id'] = ConstPaymentGateways::Wallet;


            }*/
            if (!empty($id) && !empty($type)) {
                Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'JobOrder',
                        'action' => 'Order',
                        'label' => 'Step 2',
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $id,
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
            }
            $job = $this->Job->find('first', array(
                'conditions' => array(
                    'Job.id' => $this->request->data['Payment']['item_id']
                ) ,
                'fields' => array(
                    'Job.amount',
                    'Job.id',
                    'Job.commission_amount',
                    'Job.user_id'
                ) ,
                'recursive' => -1
            ));
            if (!empty($this->request->data['Payment']['payment_type_id']) && $this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::Wallet) {
                $PaymentGateway = $this->PaymentGateway->find('first', array(
                    'conditions' => array(
                        'PaymentGateway.id' => ConstPaymentGateways::Wallet
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($PaymentGateway['PaymentGateway']['is_active'])) {
                    $user = $this->Job->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $this->Auth->user('id')
                        ) ,
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.available_balance_amount',
                            'User.available_wallet_amount',
                        ) ,
                        'recursive' => -1
                    ));
                    if (empty($user)) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                    if ($user['User']['available_wallet_amount'] < $job['Job']['amount']) {
                        $is_error = 1;
                        $error_message = sprintf('%s %s ', __l('Your wallet has insufficient money to order this') , Configure::read('job.job_alternate_name'));
                    }
                }
            }
            if (!empty($is_error)) {
                $this->Session->setFlash($error_message, 'default', null, 'error');
            } else {
                $is_visibleBranding = 0;
                if ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) {
                    $this->loadModel('Sudopay.Sudopay');
                    $this->Sudopay = new Sudopay();
                    $sudopay_gateway_settings = $this->Sudopay->GetSudoPayGatewaySettings();
                    $this->set('sudopay_gateway_settings', $sudopay_gateway_settings);
                    if ($sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
                        $is_visibleBranding = 1;
                        $this->Job->JobOrder->create();
                        $JobOrder['user_id'] = $this->Auth->user('id');
                        $JobOrder['job_id'] = $job['Job']['id'];
                        $JobOrder['amount'] = $job['Job']['amount'];
                        $JobOrder['commission_amount'] = $job['Job']['commission_amount']; // Modified
                        $JobOrder['owner_user_id'] = $job['Job']['user_id']; // Modified
                        $JobOrder['payment_gateway_id'] = $this->request->data['Payment']['payment_type_id'];
                        $JobOrder['sudopay_gateway_id'] = $this->request->data['Payment']['sudopay_gateway_id'];
                        $this->Job->JobOrder->save($JobOrder, false);
                        $order_id = $this->Job->JobOrder->id;
                        $sudopay_data = $this->Sudopay->getSudoPayPostData($order_id, ConstPaymentType::JobOrder);
                        $sudopay_data['merchant_id'] = $sudopay_gateway_settings['sudopay_merchant_id'];
                        $sudopay_data['website_id'] = $sudopay_gateway_settings['sudopay_website_id'];
                        $sudopay_data['secret_string'] = $sudopay_gateway_settings['sudopay_secret_string'];
                        $sudopay_data['action'] = 'capture';
                        $sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sudopay_btn.js' . '\'';
                        if (!empty($sudopay_gateway_settings['is_test_mode'])) {
                            $sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sandbox/sudopay_btn.js' . '\'';
                        }
                        $this->set('sudopay_data', $sudopay_data);
                    }
                }
                if (empty($is_visibleBranding)) {
                    $this->process_order($this->request->data);
                }
            }
        }
        if (!empty($this->request->params['named']['is_ajax'])) {
            $this->layout = 'ajax';
        }
        $this->pageTitle = __l('Order');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        switch ($type) {
            case 'job':
                $itemDetail = $this->Job->find('first', array(
                    'conditions' => array(
                        'Job.id' => $id
                    ) ,
                    'contain' => array(
                        'Attachment' => array(
                            'fields' => array(
                                'Attachment.id',
                                'Attachment.filename',
                                'Attachment.dir',
                                'Attachment.width',
                                'Attachment.height'
                            ) ,
                        ) ,
                        'User' => array(
                            'UserAvatar' => array(
                                'fields' => array(
                                    'UserAvatar.id',
                                    'UserAvatar.dir',
                                    'UserAvatar.filename',
                                    'UserAvatar.width',
                                    'UserAvatar.height'
                                )
                            )
                        ) ,
                        'JobType' => array(
                            'fields' => array(
                                'JobType.id',
                                'JobType.name',
                            ) ,
                        ) ,
                        'JobServiceLocation' => array(
                            'fields' => array(
                                'JobServiceLocation.id',
                                'JobServiceLocation.name',
                            ) ,
                        ) ,
                    ) ,
                    'recursive' => 2
                ));
                if ($itemDetail['User']['id'] == $this->Auth->user('id')) {
                    $this->Session->setFlash(sprintf(__l('You can\'t buy your own %s.') , jobAlternateName(ConstJobAlternateName::Singular)) , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'jobs',
                        'action' => 'view',
                        $itemDetail['Job']['slug']
                    ));
                }
                $this->pageTitle.= ' - ' . $itemDetail['Job']['title'];
                break;
        }
        if (empty($itemDetail)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user_info = $this->Job->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.available_balance_amount',
                'User.available_wallet_amount',
            ) ,
            'recursive' => -1
        ));
        $gateway_types = $this->Payment->getGatewayTypes();
        if ((!empty($gateway_types[ConstPaymentGateways::SudoPay]) && $gateway_types[ConstPaymentGateways::SudoPay]) && empty($this->request->data['Payment']['payment_gateway_id'])) {
            $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
        } elseif (isset($gateway_types[ConstPaymentGateways::Wallet]) && empty($this->request->data['Payment']['payment_gateway_id'])) {
            $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
        }
        $this->set('gateway_types', $gateway_types);
        $this->set('itemDetail', $itemDetail);
        $this->set('user_info', $user_info);
        $this->request->data['Payment']['type'] = $type;
        $this->request->data['Payment']['item_id'] = $id;
    }
    function process_order($data)
    {
        $this->autoRender = false;
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        if (empty($data)) {
            throw new NotFoundException(__l('Invalid request'));
        } else {
            if ($data['Payment']['payment_gateway_id'] == ConstPaymentGateways::Wallet && isPluginEnabled('Wallets')) {
                App::import('Model', 'Wallets.Wallet');
                $this->Wallet = new Wallet();
                $return = $this->Wallet->processOrder($data['Payment']);
            } elseif ($data['Payment']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) {
                $return = $this->Payment->processOrder($data);
            }
            if (empty($return['error'])) {
                if (($data['Payment']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) || ($data['Payment']['payment_gateway_id'] == ConstPaymentGateways::Wallet && isPluginEnabled('Wallets'))) {
                    if ($data['Payment']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                        $this->Wallet->processOrderPayment($return['order_id']);
                        $this->Session->setFlash(__l('Thank you! Your purchase was successful.') , 'default', null, 'success');
                    } else {
                        $this->Session->setFlash(__l('Thank you! Your purchase was successful.') , 'default', null, 'success');
                    }
                    $job = $this->Job->find('first', array(
                        'conditions' => array(
                            'Job.id' => $data['Payment']['item_id']
                        ) ,
                        'recursive' => -1
                    ));
                    $this->redirect(array(
                        'controller' => 'jobs',
                        'action' => 'view',
                        $job['Job']['slug']
                    ));
                }
            } else {
                if (!empty($return['status']) && $return['status'] == 'Pending') {
                    $this->Session->setFlash($return['error_message'] . __l(' Once payment is received, it will be processed.') , 'default', null, 'success');
                } else {
                    $this->Session->setFlash($return['error_message'] . __l('. Your payment could not be completed') , 'default', null, 'error');
                }
                if (empty($this->request->params['isAjax'])) {
                    $this->redirect(array(
                        'controller' => 'payments',
                        'action' => 'order',
                        $return['job_id']
                    ));
                } else {
                    $ajax_url = Router::url(array(
                        'controller' => 'payments',
                        'action' => 'order',
                        $return['job_id'],
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            }
        }
    }
}
?>