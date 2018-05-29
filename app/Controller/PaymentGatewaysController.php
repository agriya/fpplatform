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
class PaymentGatewaysController extends AppController
{
    public $name = 'PaymentGateways';
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'PaymentGateway.makeActive',
            'PaymentGateway.makeInactive',
            'PaymentGateway.makeTest',
            'PaymentGateway.makeLive',
            'PaymentGateway.makeDelete',
        );
        parent::beforeFilter();
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Payment Gateways');
        $conditions = array();
		if (!isPluginEnabled('Sudopay')) {
			$conditions['PaymentGateway.id != '] = ConstPaymentGateways::SudoPay;
		}
        if (!isPluginEnabled('Wallets')) {
			$conditions['PaymentGateway.id != '] = ConstPaymentGateways::Wallet;
		}
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'order' => array(
                        'PaymentGatewaySetting.name' => 'asc'
                    )
                )
            ) ,
            'order' => array(
                'PaymentGateway.id' => 'desc'
            ) ,
            'recursive' => 2
        );
        $this->set('paymentGateways', $this->paginate());
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Payment Gateway');
        if (!empty($this->request->data)) {
            $this->PaymentGateway->create();
            if ($this->PaymentGateway->save($this->request->data)) {
                $this->Session->setFlash(__l('Payment Gateway has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Payment Gateway could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Payment Gateway'));
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($id == ConstPaymentGateways::SudoPay) {
            if (!isPluginEnabled('Sudopay')) {
                $this->Session->setFlash(__l('Please, Enable the Plugin.') , 'default', null, 'error');
                $this->redirect(array(
                    'action' => 'index'
                ));
            }
            $this->loadModel('Sudopay.Sudopay');
            $SudoPayGatewaySettings = $this->Sudopay->GetSudoPayGatewaySettings();
            $this->set(compact('SudoPayGatewaySettings', 'id'));
        }
        if (!empty($this->request->data)) {
            if ($this->PaymentGateway->save($this->request->data)) {
                if (!empty($this->request->data['PaymentGatewaySetting'])) {
                    foreach($this->request->data['PaymentGatewaySetting'] as $key => $value) {
                        $value['test_mode_value'] = !empty($value['test_mode_value']) ? trim($value['test_mode_value']) : '';
                        $value['live_mode_value'] = !empty($value['live_mode_value']) ? trim($value['live_mode_value']) : '';
                        $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                            'PaymentGatewaySetting.test_mode_value' => '\'' . $value['test_mode_value'] . '\'',
                            'PaymentGatewaySetting.live_mode_value' => '\'' . $value['live_mode_value'] . '\''
                        ) , array(
                            'PaymentGatewaySetting.id' => $key
                        ));
                    }
                }
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Payment Gateway')) , 'default', null, 'success');
                if ($this->request->data['PaymentGateway']['id'] == ConstPaymentGateways::SudoPay) {
                    $this->redirect(array(
                        'controller' => 'sudopays',
                        'action' => 'synchronize',
                        'admin' => true
                    ));
                }
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Payment Gateway')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PaymentGateway->read(null, $id);
            unset($this->request->data['PaymentGatewaySetting']);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $paymentGatewaySettings = $this->PaymentGateway->PaymentGatewaySetting->find('all', array(
            'conditions' => array(
                'PaymentGatewaySetting.payment_gateway_id' => $id
            ) ,
            'order' => array(
                'PaymentGatewaySetting.id' => 'asc'
            )
        ));
        if (!empty($this->request->data['PaymentGatewaySetting'])) {
            foreach($paymentGatewaySettings as $key => $paymentGatewaySetting) {
                $paymentGatewaySettings[$key]['PaymentGatewaySetting']['value'] = $this->request->data['PaymentGatewaySetting'][$paymentGatewaySetting['PaymentGatewaySetting']['id']]['value'];
            }
        }
        $this->set(compact('paymentGatewaySettings'));
        $this->pageTitle.= ' - ' . $this->request->data['PaymentGateway']['name'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PaymentGateway->delete($id)) {
            $this->Session->setFlash(__l('Payment Gateway deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function admin_move_to()
    {
        if (!empty($this->request->data['PaymentGateway']['Id'])) {
            foreach($this->request->data['PaymentGateway']['Id'] as $payment_gateway_id => $is_checked) {
                if ($is_checked['Check']) {
                    if (!empty($this->request->data['PaymentGateway']['makeActive'])) {
                        $payment_gateway['PaymentGateway']['id'] = $payment_gateway_id;
                        $payment_gateway['PaymentGateway']['is_active'] = 1;
                        $this->PaymentGateway->save($payment_gateway, false);
                        $this->Session->setFlash(__l('Checked payment gateways has been changed to active') , 'default', null, 'success');
                    }
                    if (!empty($this->request->data['PaymentGateway']['makeInactive'])) {
                        $payment_gateway['PaymentGateway']['id'] = $payment_gateway_id;
                        $payment_gateway['PaymentGateway']['is_active'] = 0;
                        $this->PaymentGateway->save($payment_gateway, false);
                        $this->Session->setFlash(__l('Checked payment gateways has been changed to inactive') , 'default', null, 'success');
                    }
                    if (!empty($this->request->data['PaymentGateway']['makeTest'])) {
                        $payment_gateway['PaymentGateway']['id'] = $payment_gateway_id;
                        $payment_gateway['PaymentGateway']['is_test_mode'] = 1;
                        $this->PaymentGateway->save($payment_gateway, false);
                        $this->Session->setFlash(__l('Checked payment gateways has been changed to test mode') , 'default', null, 'success');
                    }
                    if (!empty($this->request->data['PaymentGateway']['makeLive'])) {
                        $payment_gateway['PaymentGateway']['id'] = $payment_gateway_id;
                        $payment_gateway['PaymentGateway']['is_test_mode'] = 0;
                        $this->PaymentGateway->save($payment_gateway, false);
                        $this->Session->setFlash(__l('Checked payment gateways has been changed to live mode') , 'default', null, 'success');
                    }
                    if (!empty($this->request->data['PaymentGateway']['makeDelete'])) {
                        $this->PaymentGateway->delete($payment_gateway_id);
                        $this->Session->setFlash(__l('Checked payment gateways has been deleted') , 'default', null, 'success');
                    }
                }
            }
        }
        $this->redirect(array(
            'controller' => 'payment_gateways',
            'action' => 'index'
        ));
    }
    public function admin_update_status($id = null, $actionId = null)
    {
        if (is_null($id) || is_null($actionId)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $toggle = empty($this->request->params['named']['toggle']) ? 0 : 1;
        switch ($actionId) {
            case ConstPaymentGateways::Testmode:
                $newToggle = empty($toggle) ? 1 : 0;
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_test_mode' => $toggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
                break;

            case ConstPaymentGateways::Active:
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_active' => $toggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
				$PaymentGateway = $this->PaymentGateway->find('first', array(
                    'conditions' => array(
                        'PaymentGateway.id' => $id
                    ) ,
                    'recursive' => -1
                ));
                $this->Cms = new CmsPlugin();
                $this->Cms->setController($this);
			   $plugin = Inflector::camelize(strtolower($PaymentGateway['PaymentGateway']['name']));
			 
                if ($this->Cms->pluginIsActive($plugin) || $toggle == 0) {
                    $this->Cms->removePluginBootstrap($plugin);
                } else {
                    $this->Cms->addPluginBootstrap($plugin);
                }
			
                break;

            case ConstPaymentGateways::Masspay:
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_mass_pay_enabled' => $toggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
                break;

            case ConstPaymentGateways::Wallet:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_add_to_wallet'
                ));
                break;

            case ConstPaymentGateways::Project:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_job_order'
                ));
                break;
        }
        $this->set('id', $id);
        $this->set('actionId', $actionId);
        $this->set('toggle', $toggle);
    }
}
?>