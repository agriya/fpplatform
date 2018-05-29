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
class JobOrderDisputesController extends AppController
{
    public $name = 'JobOrderDisputes';
    public $components = array(
        'Email'
    );
    public $uses = array(
        'Disputes.JobOrderDispute',
        'EmailTemplate',
        'Jobs.Message',
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'JobOrderDispute.close_type_1',
            'JobOrderDispute.close_type_2',
            'JobOrderDispute.close_type_3',
            'JobOrderDispute.close_type_4',
            'JobOrderDispute.close_type_5',
            'JobOrderDispute.close_type_6',
            'JobOrderDispute.close_type_7',
            'JobOrderDispute.close_type_8',
            'JobOrderDispute.close_type_9',
        );
        parent::beforeFilter();
    }
    function add()
    {
        if (empty($this->request->data)) {
            //	$this->request->params['named']['order_id'] = '93';

        }
        $conditions = array();
        $conditions['JobOrder.id'] = !empty($this->request->params['named']['order_id']) ? $this->request->params['named']['order_id'] : $this->request->data['JobOrderDispute']['job_order_id'];
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
            $conditions['OR'] = array(
                'JobOrder.user_id' => $this->Auth->user('id') ,
                'JobOrder.owner_user_id' => $this->Auth->user('id') ,
            );
        }
        if (!empty($this->request->params['named']['order_id']) || !empty($this->request->data['JobOrderDispute']['job_order_id'])) {
            $order = $this->JobOrderDispute->JobOrder->find('first', array(
                'conditions' => $conditions,
                'contain' => array(
                    'Job' => array(
                        'fields' => array(
                            'Job.id',
                            'Job.slug',
                            'Job.user_id',
                            'Job.title',
                            'Job.job_type_id',
                        ) ,
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.email'
                            )
                        ) ,
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email'
                        )
                    ) ,
                    'JobFeedback' => array(
                        'fields' => array(
                            'JobFeedback.id',
                            'JobFeedback.is_satisfied',
                        ) ,
                    ) ,
                ) ,
                'recursive' => 2
            ));
        }
        if (empty($order)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Add Job Order Dispute');
        if (!empty($this->request->data)) {
            $this->JobOrderDispute->create();
            $this->request->data['JobOrderDispute']['dispute_status_id'] = ConstDisputeStatus::Open;
            $this->request->data['JobOrderDispute']['dispute_converstation_count'] = 1;
            //$this->request->data['JobOrderDispute']['last_replied_user_id'] = $this->Auth->user('id');
            //$this->request->data['JobOrderDispute']['last_replied_date'] = date('Y-m-d h:i:s');
            if ($this->JobOrderDispute->save($this->request->data)) {
                $job_order_dispute_id = $this->JobOrderDispute->getLastInsertId();
                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'User',
                        'action' => 'Disputed',
                        'label' => $this->Auth->user('username') ,
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'JobDispute',
                        'action' => 'Disputed',
                        'label' => $job_order_dispute_id,
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $this->request->data['JobOrderDispute']['job_id'],
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                $order_id = $this->request->data['JobOrderDispute']['job_order_id'];
                // SENDING MAIL AND UPDATING CONVERSTATION //
                $template = $this->EmailTemplate->selectTemplate("Dispute Open Notification");
                $emailFindReplace = array(
                    '##JOB_NAME##' => "<a href=" . Router::url(array(
                        'controller' => 'jobs',
                        'action' => 'view',
                        $order['Job']['slug'],
                        'admin' => false,
                    ) , true) . ">" . $order['Job']['title'] . "</a>",
                    '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                    '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
                    '##ORDERNO##' => $order_id,
                    '##MESSAGE##' => $this->request->data['JobOrderDispute']['reason'],
                    '##REPLY_DAYS##' => Configure::read('dispute.days_left_for_disputed_user_to_reply') . ' ' . __l('days')
                );
                if (!empty($this->request->data['JobOrderDispute']['job_user_type_id']) && $this->request->data['JobOrderDispute']['job_user_type_id'] == ConstJobUserType::Seller) {
                    $emailFindReplace['##USERNAME##'] = $order['User']['username'];
                    $emailFindReplace['##OTHER_USER##'] = $order['Job']['User']['username'];
                    $emailFindReplace['##USER_TYPE##'] = __l("Seller") . ' (' . $order['Job']['User']['username'] . ')';
                    $emailFindReplace['##REPLY_LINK##'] = "<a href=" . Router::url(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'type' => 'myorders',
                        'order_id' => $order_id,
                        'admin' => false,
                    ) , true) . ">" . __l("Activities") . "</a>";
                    $to = $order['User']['id'];
                    $sender_email = $order['User']['email'];
                    $type = 'myworks';
                } elseif (!empty($this->request->data['JobOrderDispute']['job_user_type_id']) && $this->request->data['JobOrderDispute']['job_user_type_id'] == ConstJobUserType::Buyer) {
                    $emailFindReplace['##OTHER_USER##'] = $order['User']['username'];
                    $emailFindReplace['##USERNAME##'] = $order['Job']['User']['username'];
                    $emailFindReplace['##USER_TYPE##'] = __l("Buyer") . ' (' . $order['User']['username'] . ')';
                    $emailFindReplace['##REPLY_LINK##'] = "<a href=" . Router::url(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'type' => 'myworks',
                        'order_id' => $order_id,
                        'admin' => false,
                    ) , true) . ">" . __l("Activities") . "</a>";
                    $to = $order['Job']['User']['id'];
                    $sender_email = $order['Job']['User']['email'];
                    $type = 'myorders';
                }
                $get_order_status = $this->JobOrderDispute->JobOrder->find('first', array(
                    'conditions' => array(
                        'JobOrder.id' => $order_id
                    ) ,
                    'recursive' => -1
                ));
                $message = strtr($template['email_text_content'], $emailFindReplace);
                $subject = strtr($template['subject'], $emailFindReplace);
                $is_auto = 1;
                if (Configure::read('messages.is_send_internal_message')) {
                    $message_id = $this->JobOrderDispute->Message->sendNotifications($to, $subject, $message, $order_id, '0', $order['Job']['id'], ConstJobOrderStatus::DisputeOpened, $job_order_dispute_id, $is_auto);
                    if (Configure::read('messages.is_send_email_on_new_message')) {
                        $content['subject'] = $subject;
                        $content['message'] = $subject;
                        if (!empty($sender_email)) {
                            if ($this->JobOrderDispute->_checkUserNotifications($to, ConstJobOrderStatus::DisputeOpened, 0)) {
                                $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                            }
                        }
                    }
                }
                // END OF SEND MAIL //
                // HOLDING ORDER PROCESS //
                $this->JobOrderDispute->JobOrder->updateAll(array(
                    'JobOrder.is_under_dispute' => 1
                ) , array(
                    'JobOrder.id' => $order_id
                ));
                // END OF HOLD //
                $this->Session->setFlash(__l('Dispute Opened') , 'default', null, 'success');
                if ($this->RequestHandler->isAjax()) {
                    $ajax_url = Router::url(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'order_id' => $order_id,
                        'type' => $type,
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                } else {
					$this->redirect(array(
						'controller' => 'messages',
						'action' => 'activities',
						'order_id' => $order_id,
						'type' => $type,
					));
				}
            } else {
                $this->Session->setFlash(__l('Enter all required information.') , 'default', null, 'error');
            }
        } else {
            $this->request->data['JobOrderDispute']['user_id'] = $this->Auth->user('id');
            $this->request->data['JobOrderDispute']['job_id'] = $order['JobOrder']['job_id'];
            $this->request->data['JobOrderDispute']['job_order_id'] = $order['JobOrder']['id'];
            $this->request->data['JobOrderDispute']['job_user_type_id'] = (($order['JobOrder']['owner_user_id'] == $this->Auth->user('id')) ? ConstJobUserType::Seller : ConstJobUserType::Buyer);
        }
        $disputeTypes = $this->JobOrderDispute->DisputeType->find('list', array(
            'conditions' => array(
                'DisputeType.job_user_type_id' => (($order['JobOrder']['owner_user_id'] == $this->Auth->user('id')) ? ConstJobUserType::Seller : ConstJobUserType::Buyer)
            )
        ));
        if ($order['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::Completed && $order['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::CompletedAndClosedByAdmin && $order['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::PaymentCleared) {
            unset($disputeTypes[3]); // unsetting feedback subject for dispute based on order status

        }
        if (!empty($order['JobFeedback']['is_satisfied'])) {
            unset($disputeTypes[3]); // unsetting feedback subject for dispute based on order status

        }
        if (empty($order['JobOrder']['redeliver_count'])) {
            unset($disputeTypes[2]); // unsetting redeliever subject for dispute based on redeliever count

        }
        if ($order['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::WaitingforReview || $order['Job']['job_type_id'] == ConstJobType::Offline) {
            unset($disputeTypes[1]); // unsetting unmatched item subject for dispute based on order status

        }
        $AlldisputeTypes = $this->JobOrderDispute->DisputeType->find('list', array(
            'conditions' => array(
                'DisputeType.job_user_type_id' => (($order['JobOrder']['owner_user_id'] == $this->Auth->user('id')) ? ConstJobUserType::Seller : ConstJobUserType::Buyer)
            )
        ));
        $this->set('disputeTypes', $disputeTypes);
        $this->set('AlldisputeTypes', $AlldisputeTypes);
        $this->set('is_under_dispute', $order['JobOrder']['is_under_dispute']);
    }
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'filter_id',
            'dispute_type_id',
            'q'
        ));
        App::import('Model', 'Disputes.JobOrderDispute');
        $this->JobOrderDispute = new JobOrderDispute();
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Order Disputes');
        $conditions = array();
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstDisputeStatus::Open) {
                $this->pageTitle.= __l(' - Open');
            }
            if ($this->request->params['named']['filter_id'] == ConstDisputeStatus::UnderDiscussion) {
                $this->pageTitle.= __l(' - Under Discussion');
            }
            if ($this->request->params['named']['filter_id'] == ConstDisputeStatus::WaitingForAdministratorDecision) {
                $this->pageTitle.= __l(' - Waiting For Administrator Decision');
            }
            if ($this->request->params['named']['filter_id'] == ConstDisputeStatus::Closed) {
                $this->pageTitle.= __l(' - Closed');
            }
            $conditions['JobOrderDispute.dispute_status_id'] = $this->request->params['named']['filter_id'];
            $this->request->data['JobOrderDispute']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['dispute_type_id']) && !empty($this->request->params['named']['dispute_type_id'])) {
            $this->request->data['JobOrderDispute']['dispute_type_id'] = $this->request->params['named']['dispute_type_id'];
            $conditions['JobOrderDispute.dispute_type_id'] = $this->request->params['named']['dispute_type_id'];
        }
        if (isset($this->request->params['named']['q']) && !empty($this->request->params['named']['q'])) {
            $this->pageTitle.= sprintf(__l(' - Search') . ' - %s', $this->request->params['named']['q']);
            $this->request->data['JobOrderDispute']['q'] = $this->request->params['named']['q'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['JobOrderDispute.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' -  today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['JobOrderDispute.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' -  in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['JobOrderDispute.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' -  in this month');
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Job' => array(
                    'fields' => array(
                        'Job.title',
                        'Job.slug'
                    )
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.username',
                    )
                ) ,
                'JobOrder' => array(
                    'fields' => array(
                        'JobOrder.id',
                    ) ,
                    'JobOrderStatus' => array(
                        'fields' => array(
                            'JobOrderStatus.name',
                        )
                    )
                ) ,
                'JobUserType' => array(
                    'fields' => array(
                        'JobUserType.name',
                    )
                ) ,
                'DisputeType' => array(
                    'fields' => array(
                        'DisputeType.name',
                    )
                ) ,
                'DisputeStatus' => array(
                    'fields' => array(
                        'DisputeStatus.name',
                    )
                ) ,
                'FavourJobUserType' => array(
                    'fields' => array(
                        'FavourJobUserType.name',
                    )
                )
            ) ,
            'recursive' => 1,
            'order' => array(
                'JobOrderDispute.id' => 'desc'
            )
        );
        if (isset($this->request->data['JobOrderDispute']['q']) && !empty($this->request->data['JobOrderDispute']['q'])) {
            $this->paginate['search'] = $this->request->data['JobOrderDispute']['q'];
        }
        $this->set('jobOrderDisputes', $this->paginate());
        $filters = $this->JobOrderDispute->DisputeStatus->find('list');
        $disputeTypes = $this->JobOrderDispute->DisputeType->find('list', array(
            'conditions' => array(
                'DisputeType.is_active = ' => 1
            )
        ));
        $status_count = array();
        $i = 0;
        $total_count = 0;
        foreach($filters as $id => $val) {
            $status_count[$i]['id'] = $id;
            $status_count[$i]['dispaly'] = $val;
            $status_count[$i]['count'] = $this->JobOrderDispute->find('count', array(
                'conditions' => array(
                    'JobOrderDispute.dispute_status_id = ' => $id,
                ) ,
                'recursive' => -1
            ));
            $total_count+= $status_count[$i]['count'];
            $i++;
        }
        $status_count[$i]['id'] = '';
        $status_count[$i]['dispaly'] = 'Total';
        $status_count[$i]['count'] = $total_count;
        $this->set(compact('filters', 'disputeTypes'));
        $this->set('status_count', $status_count);
    }
    function resolve()
    {
        if (empty($this->request->data)) {
            //	$this->request->params['named']['order_id'] = '93';

        }
        $conditions = array();
        $conditions['JobOrderDispute.job_order_id'] = !empty($this->request->params['named']['order_id']) ? $this->request->params['named']['order_id'] : $this->request->data['JobOrderDispute']['job_order_id'];
        $conditions['JobOrderDispute.dispute_status_id !='] = ConstDisputeStatus::Closed;
        if (!empty($this->request->params['named']['order_id']) || !empty($this->request->data['JobOrderDispute']['job_order_id'])) {
            $dispute = $this->JobOrderDispute->find('first', array(
                'conditions' => $conditions,
                'contain' => array(
                    'DisputeStatus',
                    'JobUserType',
                    'DisputeType',
                    'Job' => array(
                        'fields' => array(
                            'Job.id',
                            'Job.slug',
                            'Job.user_id',
                            'Job.title',
                        ) ,
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.email',
                                'User.blocked_amount',
                                'User.available_wallet_amount',
                            )
                        ) ,
                    ) ,
                    'JobOrder' => array(
                        'fields' => array(
                            'JobOrder.id',
                            'JobOrder.user_id',
                            'JobOrder.amount',
                            'JobOrder.job_id',
                            'JobOrder.commission_amount',
                            'JobOrder.payment_gateway_id',
                            'JobOrder.is_delayed_chained_payment',
                        ) ,
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.email',
                                'User.available_balance_amount',
                                'User.available_wallet_amount',
                            )
                        ) ,
                        'Job'
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email'
                        )
                    ) ,
                ) ,
                'recursive' => 2
            ));
        }
        if (empty($dispute)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['JobOrderDispute']['close_type_8']) || !empty($this->request->data['JobOrderDispute']['close_type_4'])) {
                $this->JobOrderDispute->_resolveByPaySeller($dispute);
            } elseif (!empty($this->request->data['JobOrderDispute']['close_type_1']) || !empty($this->request->data['JobOrderDispute']['close_type_7'])) {
                $this->JobOrderDispute->_resolveByRefund($dispute);
            } elseif (!empty($this->request->data['JobOrderDispute']['close_type_6']) || !empty($this->request->data['JobOrderDispute']['close_type_9'])) {
                $this->JobOrderDispute->_resolveByReview($dispute);
            }
            // Closing Dispute //
            $this->JobOrderDispute->_closeDispute($this->request->data['JobOrderDispute'], $dispute);
            // Redirecting //
            $this->Session->setFlash(__l('Dispute resolved successfully') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'messages',
                'action' => 'activities',
                'order_id' => $dispute['JobOrderDispute']['job_order_id'],
                'type' => 'admin_order_view',
                'admin' => true
            ));
        }
        $dispute_close_types = $this->JobOrderDispute->DisputeClosedType->find('all', array(
            'conditions' => array(
                'DisputeClosedType.dispute_type_id' => $dispute['JobOrderDispute']['dispute_type_id']
            ) ,
            'recursive' => -1
        ));
        $this->set('dispute_close_types', $dispute_close_types);
        $this->set('dispute', $dispute);
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->JobOrderDispute->delete($id)) {
            $this->Session->setFlash(__l('Job Order Dispute deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>