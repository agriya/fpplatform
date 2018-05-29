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
class AffiliateCashWithdrawalsController extends AppController
{
    public $name = 'AffiliateCashWithdrawals';
    public $uses = array(
        'AffiliateCashWithdrawal',
    );
    function beforeFilter()
    {
        if (!isPluginEnabled('Affiliates') && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        parent::beforeFilter();
    }
    function index()
    {
        $this->pageTitle = __l('Affiliate Cash Withdrawal Request');
        $conditions = array();
        $conditions['AffiliateCashWithdrawal.user_id'] = $this->Auth->user('id');
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['AffiliateCashWithdrawal']['affiliate_cash_withdrawal_status_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['AffiliateCashWithdrawal']['affiliate_cash_withdrawal_status_id'])) {
            switch ($this->request->data['AffiliateCashWithdrawal']['affiliate_cash_withdrawal_status_id']) {
                case ConstAffiliateCashWithdrawalStatus::Pending:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Pending;
                    $this->pageTitle.= __l(' - Pending');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Approved:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Approved;
                    $this->pageTitle.= __l(' - Accepted');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Rejected:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Rejected;
                    $this->pageTitle.= __l(' - Rejected');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Failed:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Failed;
                    $this->pageTitle.= __l(' - Payment Failure');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Success:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Success;
                    $this->pageTitle.= __l(' - Paid');
                    break;
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Affiliate']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['AffiliateCashWithdrawal.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' -  today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['AffiliateCashWithdrawal.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' -  in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['AffiliateCashWithdrawal.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' -  in this month');
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username'
                    )
                ) ,
                'AffiliateCashWithdrawalStatus' => array(
                    'fields' => array(
                        'AffiliateCashWithdrawalStatus.name',
                        'AffiliateCashWithdrawalStatus.id'
                    )
                )
            ) ,
            'order' => array(
                'AffiliateCashWithdrawal.id' => 'desc'
            ) ,
            'recursive' => 0
        );
        $moneyTransferAccounts = $this->AffiliateCashWithdrawal->User->MoneyTransferAccount->find('count', array(
            'conditions' => array(
                'MoneyTransferAccount.user_id' => $this->Auth->User('id') ,
            ) ,
            'recursive' => 0
        ));
        $user = $this->AffiliateCashWithdrawal->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->User('id') ,
            ) ,
            'recursive' => -1
        ));
        $this->set('user', $user);
        $this->set('moneyTransferAccounts', $moneyTransferAccounts);
        $this->request->data['AffiliateCashWithdrawal']['user_id'] = $this->Auth->user('id');
        $this->set('userCashWithdrawals', $this->paginate());
    }
    function add()
    {
        $this->pageTitle = __l('Add Affiliate Cash Withdrawal');
        if (!empty($this->request->data)) {
            $affilate_transaction_fee_enabled = Configure::read('affiliate.site_commission_amount');
            if (!empty($affilate_transaction_fee_enabled)) {
                if (Configure::read('affiliate.site_commission_type') == 'percentage') {
                    $this->request->data['AffiliateCashWithdrawal']['commission_amount'] = ($this->request->data['AffiliateCashWithdrawal']['amount']*Configure::read('affiliate.site_commission_amount') /100);
                } else {
                    $this->request->data['AffiliateCashWithdrawal']['commission_amount'] = Configure::read('affiliate.site_commission_amount');
                }
            }
            $this->AffiliateCashWithdrawal->set($this->request->data);
            $this->AffiliateCashWithdrawal->_checkAmount($this->request->data['AffiliateCashWithdrawal']['amount']);
            if ($this->AffiliateCashWithdrawal->validates()) {
                $this->request->data['AffiliateCashWithdrawal']['affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Pending;
                $this->AffiliateCashWithdrawal->create();
                if ($this->AffiliateCashWithdrawal->save($this->request->data)) {
                    // Updating transaction during intital withdraw request by user.
                    $data['Transaction']['user_id'] = $this->request->data['AffiliateCashWithdrawal']['user_id'];
                    $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                    $data['Transaction']['class'] = 'SecondUser';
                    $data['Transaction']['amount'] = $this->request->data['AffiliateCashWithdrawal']['amount'];
                    $data['Transaction']['description'] = 'user cash withdrawal request from affliate commission';
                    $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AffliateUserWithdrawalRequest;
                    $this->AffiliateCashWithdrawal->User->Transaction->log_data($data);
                    $this->AffiliateCashWithdrawal->User->updateAll(array(
                        'User.commission_line_amount' => 'User.commission_line_amount -' . $this->request->data['AffiliateCashWithdrawal']['amount']
                    ) , array(
                        'User.id' => $this->request->data['AffiliateCashWithdrawal']['user_id']
                    )); //
                    $this->AffiliateCashWithdrawal->User->updateAll(array(
                        'User.commission_withdraw_request_amount' => 'User.commission_withdraw_request_amount + ' . $this->request->data['AffiliateCashWithdrawal']['amount']
                    ) , array(
                        'User.id' => $this->request->data['AffiliateCashWithdrawal']['user_id']
                    ));
                    $this->Session->setFlash('Affiliate cash withdrawal request has been added', 'default', null, 'success');
                    if ($this->RequestHandler->isAjax()) {
                        $this->autoRender = false;
                    } else {
                        $this->redirect(array(
                            'action' => 'index',
                        ));
                    }
                } else {
                    $this->Session->setFlash('Affiliate cash withdrawal request could not be added. Please, try again.', 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash('Affiliate cash withdrawal request could not be added. Please, try again.', 'default', null, 'error');
            }
        } else {
            $this->request->data['AffiliateCashWithdrawal']['user_id'] = $this->Auth->user('id');
        }
        $user = $this->AffiliateCashWithdrawal->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $this->set('user', $user);
    }
    function admin_index()
    {
        $title = '';
        $conditions = array();
        $this->_redirectGET2Named(array(
            'filter_id',
            'q'
        ));
        App::import('Model', 'Affiliates.AffiliateCashWithdrawal');
        $this->AffiliateCashWithdrawal = new AffiliateCashWithdrawal();
        $this->pageTitle = __l('Withdraw Requests');
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['AffiliateCashWithdrawal']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['AffiliateCashWithdrawal']['filter_id']) && $this->request->data['AffiliateCashWithdrawal']['filter_id'] != 'all') {
            $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = $this->request->data['AffiliateCashWithdrawal']['filter_id'];
            $status = $this->AffiliateCashWithdrawal->AffiliateCashWithdrawalStatus->find('first', array(
                'conditions' => array(
                    'AffiliateCashWithdrawalStatus.id' => $this->request->data['AffiliateCashWithdrawal']['filter_id'],
                ) ,
                'fields' => array(
                    'AffiliateCashWithdrawalStatus.name'
                ) ,
                'recursive' => -1
            ));
            $title = $status['AffiliateCashWithdrawalStatus']['name'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['AffiliateCashWithdrawal.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - Requested today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['AffiliateCashWithdrawal.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Requested in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['AffiliateCashWithdrawal.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Requested in this month');
        }
        if (!empty($this->request->data['AffiliateCashWithdrawal']['filter_id'])) {
            switch ($this->request->data['AffiliateCashWithdrawal']['filter_id']) {
                case ConstAffiliateCashWithdrawalStatus::Pending:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Pending;
                    $this->pageTitle.= __l(' - Pending');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Approved:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Approved;
                    $this->pageTitle.= __l(' - Accepted');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Rejected:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Rejected;
                    $this->pageTitle.= __l(' - Rejected');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Failed:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Failed;
                    $this->pageTitle.= __l(' - Payment Failure');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Success:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Success;
                    $this->pageTitle.= __l(' - Paid');
                    break;
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.username',
                    )
                ) ,
                'AffiliateCashWithdrawalStatus' => array(
                    'fields' => array(
                        'AffiliateCashWithdrawalStatus.name',
                        'AffiliateCashWithdrawalStatus.id',
                    )
                )
            ) ,
            'order' => array(
                'AffiliateCashWithdrawal.id' => 'desc'
            ) ,
            'recursive' => 2,
        );
        $AffiliateCashWithdrawalStatuses = $this->AffiliateCashWithdrawal->AffiliateCashWithdrawalStatus->find('all', array(
            'recursive' => -1
        ));
        $this->set('AffiliateCashWithdrawalStatuses', $AffiliateCashWithdrawalStatuses);
        $moreActions = $this->AffiliateCashWithdrawal->moreActions;
        if (!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending)) {
            unset($moreActions[ConstAffiliateCashWithdrawalStatus::Pending]);
        }
        $this->set('affiliateCashWithdrawals', $this->paginate());
        $this->set(compact('moreActions'));
        $this->set('approved', $this->AffiliateCashWithdrawal->find('count', array(
            'conditions' => array(
                'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Approved,
            ) ,
            'recursive' => -1
        )));
        $this->set('success', $this->AffiliateCashWithdrawal->find('count', array(
            'conditions' => array(
                'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Success,
            ) ,
            'recursive' => -1
        )));
        $this->set('failed', $this->AffiliateCashWithdrawal->find('count', array(
            'conditions' => array(
                'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Failed,
            ) ,
            'recursive' => -1
        )));
        $this->set('pending', $this->AffiliateCashWithdrawal->find('count', array(
            'conditions' => array(
                'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Pending,
            ) ,
            'recursive' => -1
        )));
        $this->set('rejected', $this->AffiliateCashWithdrawal->find('count', array(
            'conditions' => array(
                'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Rejected,
            ) ,
            'recursive' => -1
        )));
        $this->set('pageTitle', $this->pageTitle);
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->AffiliateCashWithdrawal->delete($id)) {
            $this->Session->setFlash(__l('Affiliate Cash Withdrawal deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function admin_update()
    {
        if (!empty($this->request->data['AffiliateCashWithdrawal'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $userCashWithdrawalIds = array();
            foreach($this->request->data['AffiliateCashWithdrawal'] as $userCashWithdrawal_id => $is_checked) {
                if ($is_checked['id']) {
                    $userCashWithdrawalIds[] = $userCashWithdrawal_id;
                }
            }
            if ($actionid && !empty($userCashWithdrawalIds)) {
                if ($actionid == ConstAffiliateCashWithdrawalStatus::Approved) {
                    $paymentGateways = $this->AffiliateCashWithdrawal->User->MoneyTransferAccount->PaymentGateway->find('list', array(
                        'conditions' => array(
                            'PaymentGateway.is_mass_pay_enabled' => 1
                        ) ,
                        'fields' => array(
                            'PaymentGateway.id',
                            'PaymentGateway.name',
                        ) ,
                        'recursive' => -1
                    ));
                    $conditions['AffiliateCashWithdrawal.id'] = $userCashWithdrawalIds;
                    $this->paginate = array(
                        'conditions' => $conditions,
                        'contain' => array(
                            'User' => array(
                                'UserAvatar',
                                'MoneyTransferAccount' => array(
                                    'fields' => array(
                                        'MoneyTransferAccount.id',
                                        'MoneyTransferAccount.payment_gateway_id',
                                        'MoneyTransferAccount.account',
                                        'MoneyTransferAccount.is_default',
                                    ) ,
                                    'PaymentGateway' => array(
                                        'conditions' => array(
                                            'PaymentGateway.is_mass_pay_enabled' => 1,
                                        ) ,
                                        'fields' => array(
                                            'PaymentGateway.display_name',
                                            'PaymentGateway.name'
                                        )
                                    )
                                )
                            ) ,
                            'AffiliateCashWithdrawalStatus' => array(
                                'fields' => array(
                                    'AffiliateCashWithdrawalStatus.name',
                                    'AffiliateCashWithdrawalStatus.id',
                                )
                            )
                        ) ,
                        'order' => array(
                            'AffiliateCashWithdrawal.id' => 'desc'
                        ) ,
                        'recursive' => 3,
                    );
                    $affiliateCashWithdrawals = $this->paginate();
                    foreach($affiliateCashWithdrawals as $key => $affiliateCashWithdrawal) {
                        $payment_gates = array();
                        $payment_gates[ConstPaymentGateways::ManualPay] = __l('Mark as paid/manual');
                        if (!empty($affiliateCashWithdrawal['User']['MoneyTransferAccount'])) {
                            foreach($affiliateCashWithdrawal['User']['MoneyTransferAccount'] as $gateway) {
                                $payment_gates[$gateway['payment_gateway_id']] = __l('Pay via ') . $gateway['PaymentGateway']['display_name'] . ' ' . __l('API') . ' (' . substr($gateway['account'], 0, 10) . '...)';
                                if ($gateway['is_default'] == 1) {
                                    $this->request->data['AffiliateCashWithdrawal'][$key]['gateways'] = $gateway['payment_gateway_id'];
                                }
                            }
                        }
                        foreach($payment_gates as $id => $name) {
                            if (ConstPaymentGateways::ManualPay != $id && empty($paymentGateways[$id])) {
                                unset($payment_gates[$id]);
                            }
                        }
                        $affiliateCashWithdrawals[$key]['paymentways'] = $payment_gates;
                    }
                    $this->pageTitle = __l('Withdraw Fund Requests - Approved');
                    $this->set('affiliateCashWithdrawals', $affiliateCashWithdrawals);
                    $this->render('admin_pay_to_user');
                } else if ($actionid == ConstAffiliateCashWithdrawalStatus::Pending) {
                    $this->AffiliateCashWithdrawal->updateAll(array(
                        'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Pending
                    ) , array(
                        'AffiliateCashWithdrawal.id' => $userCashWithdrawalIds
                    ));
                    $this->Session->setFlash(__l('Checked requests have been moved to pending status') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'affiliate_cash_withdrawals',
                        'action' => 'index'
                    ));
                } else if ($actionid == ConstAffiliateCashWithdrawalStatus::Rejected) {
                    // Need to Refund the Money to User
                    $canceled_withdraw_requests = $this->AffiliateCashWithdrawal->find('all', array(
                        'conditions' => array(
                            'AffiliateCashWithdrawal.id' => $userCashWithdrawalIds
                        ) ,
                        'recursive' => -1
                    ));
                    // Updating user balance
                    foreach($canceled_withdraw_requests as $canceled_withdraw_request) {
                        // Updating transactions
                        if (!empty($canceled_withdraw_request)) {
                            $this->AffiliateCashWithdrawal->User->Transaction->log_data($canceled_withdraw_request['AffiliateCashWithdrawal']['id'], 'Affiliates.AffiliateCashWithdrawal', ConstPaymentGateways::ManualPay, ConstTransactionTypes::AffiliateCashWithdrawalRequestRejected);
                        }
                        // Addding to user's Available Balance
                        $this->AffiliateCashWithdrawal->User->updateAll(array(
                            'User.commission_line_amount' => 'User.commission_line_amount +' . $canceled_withdraw_request['AffiliateCashWithdrawal']['amount']
                        ) , array(
                            'User.id' => $canceled_withdraw_request['AffiliateCashWithdrawal']['user_id']
                        ));
                        // Deducting user's Available Balance
                        $this->AffiliateCashWithdrawal->User->updateAll(array(
                            'User.commission_withdraw_request_amount' => 'User.commission_withdraw_request_amount -' . $canceled_withdraw_request['AffiliateCashWithdrawal']['amount']
                        ) , array(
                            'User.id' => $canceled_withdraw_request['AffiliateCashWithdrawal']['user_id']
                        ));
                        $this->AffiliateCashWithdrawal->updateAll(array(
                            'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Rejected
                        ) , array(
                            'AffiliateCashWithdrawal.id' => $canceled_withdraw_request['AffiliateCashWithdrawal']['id']
                        ));
                    }
                    //
                    $this->Session->setFlash(__l('Checked requests have been moved to rejected status, Amount sent back tot the users.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'affiliate_cash_withdrawals',
                        'action' => 'index',
                        'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending
                    ));
                }
            } else {
                $this->redirect(array(
                    'controller' => 'affiliate_cash_withdrawals',
                    'action' => 'index',
                    'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending
                ));
            }
        } else {
            $this->redirect(array(
                'controller' => 'affiliate_cash_withdrawals',
                'action' => 'index',
                'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending
            ));
        }
    }
    function process_masspay_ipn()
    {
        $ipn_data = $_POST;
        if (!empty($ipn_data)) {
            $processed_data['payer_id'] = $ipn_data['payer_id'];
            $processed_data['payment_date'] = $ipn_data['payment_date'];
            $processed_data['charset'] = $ipn_data['charset'];
            $processed_data['notify_version'] = $ipn_data['notify_version'];
            $processed_data['payer_status'] = $ipn_data['payer_status'];
            $processed_data['verify_sign'] = $ipn_data['verify_sign'];
            $processed_data['last_name'] = $ipn_data['last_name'];
            $processed_data['first_name'] = $ipn_data['first_name'];
            $processed_data['payer_email'] = $ipn_data['payer_email'];
            $processed_data['payer_business_name'] = $ipn_data['payer_business_name'];
            $payment_count = 0;
            for ($i = 1; !empty($ipn_data["receiver_email_$i"]); $i++) {
                $payment_count++;
            }
            for ($i = 1; $i <= $payment_count; $i++) {
                $user_defined = explode('-', $ipn_data["unique_id_$i"]);
                $unique_id = $user_defined[0];
                $withdrawal_type = 'user';
                if (count($user_defined) == 2) {
                    $unique_id = $user_defined[1];
                    $withdrawal_type = $user_defined[0];
                }
                $processed_data['UserCashWithdrawal'][$unique_id] = array(
                    'receiver_email' => $ipn_data["receiver_email_$i"],
                    'masspay_txn_id' => $ipn_data["masspay_txn_id_$i"],
                    'status' => $ipn_data["status_$i"],
                    'mc_currency' => $ipn_data["mc_currency_$i"],
                    'payment_gross' => $ipn_data["payment_gross_$i"],
                    'mc_gross' => $ipn_data["mc_gross_$i"],
                    'mc_fee' => $ipn_data["mc_fee_$i"],
                    'transaction_log' => $ipn_data["transaction_log_$i"],
                    'withdrawal_type' => $withdrawal_type
                );
            }
            if ($processed_data); {
                foreach($processed_data['UserCashWithdrawal'] as $userCashWithdrawal_id => $userCashWithdrawal_response) {
                    switch ($userCashWithdrawal_response['withdrawal_type']) {
                        case 'affiliate':
                            $this->loadModel('AffiliateCashWithdrawal');
                            $this->AffiliateCashWithdrawal->affiliate_masspay_ipn_process($userCashWithdrawal_id, $userCashWithdrawal_response);
                            break;
                    }
                }
            }
        }
        exit;
    }
}
?>