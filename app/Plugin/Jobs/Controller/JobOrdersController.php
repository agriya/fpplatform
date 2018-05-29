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
class JobOrdersController extends AppController
{
    public $name = 'JobOrders';
    public $components = array(
        'Email'
    );
    public $uses = array(
        'Jobs.JobOrder',
        'User',
        'Attachment',
        'EmailTemplate',
        'Jobs.Message',
    );
    public $helpers = array(
        'Gateway'
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'JobOrder.latitude',
            'JobOrder.longitude',
            'JobOrder.zoom_level',
            'Attachment',
            'JobOrder.redeliver',
            'JobOrder.redeliver_cancel',
            'JobOrder.mutual_cancel',
            'JobOrder.redeliver_comments',
            'JobOrder.accept_mutual_cancel',
            'JobOrder.reject_mutual_cancel',
            'JobOrder.accept_redeliver',
            'JobOrder.reject_redeliver',
            'JobOrder.information_from_buyer',
            'is_iframe_submit',
            'Sudopay'
        );
        parent::beforeFilter();
    }
    function add()
    {
        $this->pageTitle = __l('Order');
        if (!empty($this->request->data)) {
            $this->JobOrder->create();
            $this->request->data['JobOrder']['job_order_status_id'] = ConstJobOrderStatus::PaymentPending;
            $this->request->data['JobOrder']['user_id'] = $this->Auth->user('id');
            $job = $this->JobOrder->Job->find('first', array(
                'conditions' => array(
                    'Job.id' => $this->request->data['JobOrder']['job_id']
                ) ,
                'recursive' => -1
            ));
			$this->request->data['JobOrder']['owner_user_id'] = $job['Job']['user_id'];
			$this->request->data['JobOrder']['amount'] = $job['Job']['amount'];
			$this->request->data['JobOrder']['commission_amount'] = $job['Job']['commission_amount'];
            if (empty($job)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                '_trackEvent' => array(
                    'category' => 'JobOrder',
                    'action' => 'Order',
                    'label' => 'Step 1',
                    'value' => '',
                ) ,
                '_setCustomVar' => array(
                    'jd' => $this->request->data['JobOrder']['job_id'],
                    'ud' => $this->Auth->user('id') ,
                    'rud' => $this->Auth->user('referred_by_user_id') ,
                )
            ));
            //attachement validation
            if (!empty($job) && !empty($job['Job']['is_instruction_requires_attachment']) && empty($this->request->data['JobOrder']['id'])) {
                if (!empty($this->request->data['Attachment']['filename']['name'])) {
                    $this->JobOrder->Attachment->Behaviors->attach('ImageUpload', Configure::read('job.file'));
                    $this->request->data['Attachment']['filename']['type'] = get_mime($this->request->data['Attachment']['filename']['tmp_name']);
                }
                if (!empty($this->request->data['Attachment']['filename']['name'])) {
                    $this->request->data['Attachment']['class'] = 'JobOrder';
                    $this->JobOrder->Attachment->set($this->request->data['Attachment']);
                }
                $this->JobOrder->set($this->request->data);
                $ini_upload_error = 1;
                if ($this->request->data['Attachment']['filename']['error'] == 1) {
                    $ini_upload_error = 0;
                }
                if ($ini_upload_error == 0 || empty($this->request->data['Attachment']['filename']['name'])) {
                    $this->JobOrder->validationErrors['Attachment']['filename'] = __l('Required');
                    //		$this->layout = 'ajax';
                    $this->Session->setFlash(__l('Attachment not added.') , 'default', null, 'error');
                }
            }
            if ($this->JobOrder->save($this->request->data)) {
                $order_id = $this->JobOrder->getLastInsertId();
                if (!empty($this->request->data['JobOrder']['id'])) {
                    $order_id = $this->request->data['JobOrder']['id'];
                }
                Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'JobOrder',
                        'action' => 'Order',
                        'label' => 'Step 2',
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'jd' => $this->request->data['JobOrder']['job_id'],
                        'jfd' => $order_id,
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                $order = $this->JobOrder->find('first', array(
                    'conditions' => array(
                        'JobOrder.id' => $this->request->data['JobOrder']['id']
                    ) ,
                    'contain' => array(
                        'Attachment',
                    ) ,
                    'recursive' => 1
                ));
                // Saving attachment, if present //
                if (!empty($this->request->data['Attachment']['filename']['name'])) {
                    if (!empty($order['Attachment'][0]['id'])) {
                        $this->request->data['Attachment']['id'] = $order['Attachment'][0]['id'];
                    } else {
                        $this->Attachment->create();
                    }
                    $this->request->data['Attachment']['foreign_id'] = $order_id;
                    $this->JobOrder->Attachment->save($this->request->data['Attachment']);
                }
                $this->redirect(array(
                    'controller' => 'payments',
                    'action' => 'order',
                    $this->request->data['JobOrder']['job_id'],
                    'order_id' => $order_id,
                    //'is_ajax' => 1

                ));
            }
            if (!empty($this->JobOrder->validationErrors)) {
                $this->Session->setFlash(__l('Enter all required informations') , 'default', null, 'error');
            }
            if (!$this->RequestHandler->isAjax() && empty($this->request->params['form']['is_iframe_submit'])) {
                $this->redirect(array(
                    'controller' => 'job_orders',
                    'action' => 'add',
                    'job' => $this->request->data['JobOrder']['job_id'],
                ));
            } else {
                //$this->request->data = array();
                $this->layout = 'ajax';
                //$this->setAction('add','job' => $this->request->data['JobOrder']['job_id']);

            }
        }
        if (!empty($this->request->params['named']['order_id']) || !empty($this->request->data['JobOrder']['id'])) {
            $order = $this->JobOrder->find('first', array(
                'conditions' => array(
                    'JobOrder.id' => !empty($this->request->data['JobOrder']['id']) ? $this->request->data['JobOrder']['id'] : $this->request->params['named']['order_id']
                ) ,
                'contain' => array(
                    'Attachment'
                ) ,
                'recursive' => 1
            ));
            if (empty($order['JobOrder']['address'])) {
                $userProfile = $this->JobOrder->User->UserProfile->find('first', array(
                    'conditions' => array(
                        'UserProfile.user_id' => $this->Auth->user('id')
                    ) ,
                    'recursive' => -1
                ));
            }
        } else {
            if (empty($this->request->data)) {
                $userProfile = $this->JobOrder->User->UserProfile->find('first', array(
                    'conditions' => array(
                        'UserProfile.user_id' => $this->Auth->user('id')
                    ) ,
                    'recursive' => -1
                ));
            }
        }
        if (!empty($order['Attachment'])) {
            $userProfile['Attachment'] = $order['Attachment'];
        }
        if (empty($this->request->data)) {
            $this->request->data['JobOrder']['address'] = !empty($order['JobOrder']['address']) ? $order['JobOrder']['address'] : $userProfile['UserProfile']['contact_address'];
            $this->request->data['JobOrder']['mobile'] = !empty($order['JobOrder']['mobile']) ? $order['JobOrder']['mobile'] : $userProfile['UserProfile']['mobile_phone'];
            $this->request->data['JobOrder']['latitude'] = !empty($order['JobOrder']['latitude']) ? $order['JobOrder']['latitude'] : ($userProfile['UserProfile']['latitude'] ? $userProfile['UserProfile']['latitude'] : '0');
            $this->request->data['JobOrder']['longitude'] = !empty($order['JobOrder']['longitude']) ? $order['JobOrder']['longitude'] : ($userProfile['UserProfile']['longitude'] ? $userProfile['UserProfile']['longitude'] : '0');
            $this->request->data['JobOrder']['zoom_level'] = !empty($order['JobOrder']['zoom_level']) ? $order['JobOrder']['zoom_level'] : ($userProfile['UserProfile']['zoom_level'] ? $userProfile['UserProfile']['zoom_level'] : '10');
            $this->request->data['JobOrder']['information_from_buyer'] = !empty($order['JobOrder']['information_from_buyer']) ? $order['JobOrder']['information_from_buyer'] : '';
            $this->set('userProfile', $userProfile);
        }
        if (!empty($this->request->params['named']['job']) || !empty($this->request->data['JobOrder']['job_id'])) {
            $itemDetail = $this->JobOrder->Job->find('first', array(
                'conditions' => array(
                    'Job.id' => !empty($this->request->params['named']['job']) ? $this->request->params['named']['job'] : $this->request->data['JobOrder']['job_id']
                ) ,
                'contain' => array(
                    'Attachment',
                    'User',
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
                'recursive' => 1
            ));
            if (empty($itemDetail)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->set('itemDetail', $itemDetail);
        }
    }
    /*
    This 'index' method is used in
    - Displaying Buyer balance
    - Shopping page for buyers
    - Seller Gain page
    - Seller Revenue or sales balance page
    */
    function index()
    {
        if (!empty($this->request->params['named']['type'])) { // Type
            $conditions = array();
            $conditions['JobOrder.job_order_status_id !='] = 0;
            $order['JobOrder.id'] = 'desc';
            $filter_count = $this->JobOrder->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            if ($this->request->params['named']['type'] == 'myorders' || $this->request->params['named']['type'] == 'history') { // Buyer
                $all_count = ($filter_count['User']['buyer_payment_pending_count']+$filter_count['User']['buyer_waiting_for_acceptance_count']+$filter_count['User']['buyer_in_progress_count']+$filter_count['User']['buyer_in_progress_overtime_count']+$filter_count['User']['buyer_review_count']+$filter_count['User']['buyer_completed_count']+$filter_count['User']['buyer_cancelled_count']+$filter_count['User']['buyer_rejected_count']+$filter_count['User']['buyer_cancelled_late_order_count']+$filter_count['User']['buyer_expired_count']+$filter_count['User']['buyer_mutual_cancelled_count']+$filter_count['User']['buyer_redeliver_count']);
                $this->set('all_count', $all_count);
                if ($this->request->params['named']['type'] == 'myorders') {
                    $status = array(
                        __l('Active') . ' (' . ($filter_count['User']['buyer_in_progress_count']+$filter_count['User']['buyer_in_progress_overtime_count']+$filter_count['User']['buyer_review_count']) . ')' => 'active',
                        __l('Payment Pending') . ' (' . $filter_count['User']['buyer_payment_pending_count'] . ')' => 'payment_pending',
                        __l('Pending Seller Accept') . ' (' . $filter_count['User']['buyer_waiting_for_acceptance_count'] . ')' => 'waiting_for_acceptance',
                        __l('In Progress') . ' (' . $filter_count['User']['buyer_in_progress_count'] . ')' => 'in_progress',
                        __l('In Progress Overtime') . ' (' . $filter_count['User']['buyer_in_progress_overtime_count'] . ')' => 'in_progress_overtime',
                        __l('Waiting For Your Review') . ' (' . $filter_count['User']['buyer_review_count'] . ')' => 'waiting_for_review',
                        __l('Completed') . ' (' . $filter_count['User']['buyer_completed_count'] . ')' => 'completed',
                        __l('Cancelled') . ' (' . $filter_count['User']['buyer_cancelled_count'] . ')' => 'cancelled',
                        __l('Seller Rejected') . ' (' . $filter_count['User']['buyer_rejected_count'] . ')' => 'rejected',
                        __l('Cancelled Late Orders') . ' (' . $filter_count['User']['buyer_cancelled_late_order_count'] . ')' => 'cancelled_late_orders',
                        __l('Expired') . ' ' . jobAlternateName(ConstJobAlternateName::Plural) . ' (' . $filter_count['User']['buyer_expired_count'] . ')' => 'expired',
						__l('Mutual Cancelled') . ' (' . $filter_count['User']['buyer_mutual_cancelled_count'] . ')' => 'mutual_canceled',
                        __l('Rework') . ' ' . jobAlternateName(ConstJobAlternateName::Plural) . ' (' . $filter_count['User']['buyer_redeliver_count'] . ')' => 'rework',
                    );
                    $this->set('moreActions', $status);
                    $this->set('filter_count', $filter_count);
                    if (!empty($this->request->params['named']['status'])) {
                        $order_status = array(
                            'waiting_for_acceptance' => 1,
                            'in_progress' => 2,
                            'waiting_for_review' => 3,
                            'completed' => 4,
                            'cancelled' => 5,
                            'Rejected' => 6,
                            'PaymentCleared' => 7,
                            'Expired' => 8,
                            'InProgressOvertime' => 9,
                            'CancelledDueToOvertime' => 10,
							'mutual_canceled'=> 15
                        );
                        if ($this->request->params['named']['status'] == 'active') {
                            $status = array(
                                ConstJobOrderStatus::InProgress,
                                ConstJobOrderStatus::WaitingforReview,
                                ConstJobOrderStatus::InProgressOvertime
                            );
                        } else if ($this->request->params['named']['status'] == 'completed') {
                            $status = array(
                                ConstJobOrderStatus::Completed,
                                ConstJobOrderStatus::PaymentCleared,
                                ConstJobOrderStatus::CompletedAndClosedByAdmin
                            );
                        } else if ($this->request->params['named']['status'] == 'rejected') {
                            $status = array(
                                ConstJobOrderStatus::Rejected,
                            );
                        } else if ($this->request->params['named']['status'] == 'cancelled') {
                            $status = array(
                                ConstJobOrderStatus::Cancelled,
                                ConstJobOrderStatus::CancelledByAdmin,
                            );
                        } else if ($this->request->params['named']['status'] == 'cancelled_late_orders') {
                            $status = array(
                                ConstJobOrderStatus::CancelledDueToOvertime,
                            );
                        } else if ($this->request->params['named']['status'] == 'expired') {
                            $status = array(
                                ConstJobOrderStatus::Expired,
                            );
                        } else if ($this->request->params['named']['status'] == 'in_progress') {
                            $status = array(
                                ConstJobOrderStatus::InProgress,
                            );
                        } else if ($this->request->params['named']['status'] == 'in_progress_overtime') {
                            $status = array(
                                ConstJobOrderStatus::InProgressOvertime,
                            );
                        } else if ($this->request->params['named']['status'] == 'payment_pending') {
                            $status = array(
                                ConstJobOrderStatus::PaymentPending,
                            );
                        } else if ($this->request->params['named']['status'] == 'rework') {
                            $status = array(
                                ConstJobOrderStatus::Redeliver,
                            );
                        }  else if ($this->request->params['named']['status'] == 'mutual_canceled') {
                            $status = array(
                                ConstJobOrderStatus::MutualCancelled,
                            );
                        } else {
                            $status = strtr($this->request->params['named']['status'], $order_status);
                        }
                        $conditions['JobOrder.job_order_status_id'] = $status;
                    }
                } else {
                    $status = array(
                        __l('All') => 'all',
                        __l('Active') => 'active',
                        __l('Pending') => 'pending',
                        __l('Transferred') => 'transferred',
                        __l('Reversed') => 'reversed',
                    );
                    $this->set('moreActions', $status);
                    if (!empty($this->request->params['named']['status'])) {
                        $status = $this->request->params['named']['status'];
                        if ($status == 'reversed') {
                            $conditions['JobOrder.job_order_status_id'] = array(
                                ConstJobOrderStatus::Rejected,
                                ConstJobOrderStatus::Cancelled,
                                ConstJobOrderStatus::Expired,
                                ConstJobOrderStatus::CancelledByAdmin,
                                ConstJobOrderStatus::CancelledDueToOvertime,
								ConstJobOrderStatus::MutualCancelled,
                            );
                        } else if ($status == 'transferred') {
                            $conditions['JobOrder.job_order_status_id'] = array(
                                ConstJobOrderStatus::InProgress,
                                ConstJobOrderStatus::InProgressOvertime,
                                ConstJobOrderStatus::WaitingforReview,
                                ConstJobOrderStatus::Completed,
                                ConstJobOrderStatus::PaymentCleared,
                                ConstJobOrderStatus::CompletedAndClosedByAdmin,
                            );
                        } else if ($status == 'pending') {
                            $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::WaitingforAcceptance;
                        } else if ($status == 'active') {
                            $conditions['JobOrder.job_order_status_id'] = array(
                                ConstJobOrderStatus::InProgress,
                                ConstJobOrderStatus::InProgressOvertime,
                                ConstJobOrderStatus::WaitingforReview,
                            );
                        }
                    }
                }
                if ($this->request->params['named']['type'] == 'history') {
                    $this->pageTitle = __l('Order History');
                } else {
                    $this->pageTitle = __l('Shopping');
                }
                $conditions['JobOrder.user_id'] = $this->Auth->user('id');
            }
            if ($this->request->params['named']['type'] == 'myworks' || $this->request->params['named']['type'] == 'gain') { // Seller
                $all_count = ($filter_count['User']['seller_waiting_for_acceptance']+$filter_count['User']['seller_in_progress_count']+$filter_count['User']['seller_in_progress_overtime_count']+$filter_count['User']['seller_review_count']+$filter_count['User']['seller_completed_count']+$filter_count['User']['seller_rejected_count']+$filter_count['User']['seller_cancelled_count']+$filter_count['User']['seller_expired_count']+$filter_count['User']['seller_mutual_cancelled_count']+$filter_count['User']['seller_redeliver_count']);
                $this->set('all_count', $all_count);
                if ($this->request->params['named']['type'] == 'myworks') {
                    $status = array(
                        __l('Active') . ' (' . ($filter_count['User']['seller_waiting_for_acceptance']+$filter_count['User']['seller_in_progress_count']+$filter_count['User']['seller_in_progress_overtime_count']) . ')' => 'active',
                        __l('Waiting for you to accept') . ' (' . $filter_count['User']['seller_waiting_for_acceptance'] . ')' => 'waiting_for_acceptance',
                        __l('In Progress') . ' (' . $filter_count['User']['seller_in_progress_count'] . ')' => 'in_progress',
                        __l('In Progress Overtime') . ' (' . $filter_count['User']['seller_in_progress_overtime_count'] . ')' => 'in_progress_overtime',
                        __l('In buyer review') . ' (' . $filter_count['User']['seller_review_count'] . ')' => 'waiting_for_Review',
                        __l('Completed') . ' (' . $filter_count['User']['seller_completed_count'] . ')' => 'completed',
                        __l('Rejected') . ' (' . $filter_count['User']['seller_rejected_count'] . ')' => 'rejected',
                        __l('Cancelled') . ' (' . $filter_count['User']['seller_cancelled_count'] . ')' => 'cancelled',
                        __l('Expired') . ' ' . jobAlternateName(ConstJobAlternateName::Plural) . ' (' . $filter_count['User']['seller_expired_count'] . ')' => 'expired',
						__l('Mutual Cancelled') . ' (' . $filter_count['User']['seller_mutual_cancelled_count'] . ')' => 'mutual_canceled',
                        __l('Rework') . ' ' . jobAlternateName(ConstJobAlternateName::Plural) . ' (' . $filter_count['User']['seller_redeliver_count'] . ')' => 'rework',
                    );
                    $this->set('moreActions', $status);
                    $this->set('filter_count', $filter_count);
                    if (!empty($this->request->params['named']['status'])) {
                        $order_status = array(
                            'waiting_for_acceptance' => 1,
                            'in_progress' => 2,
                            'waiting_for_Review' => 3,
                            'completed' => 4,
                            'Cancelled' => 5,
                            'Rejected' => 6,
                            'PaymentCleared' => 7,
							'mutual_canceled' => 15
                        );
                        if ($this->request->params['named']['status'] == 'active') {
                            $status = array(
                                ConstJobOrderStatus::InProgress,
                                ConstJobOrderStatus::InProgressOvertime,
                                ConstJobOrderStatus::WaitingforReview
                            );
                        } else if ($this->request->params['named']['status'] == 'completed') {
                            $status = array(
                                ConstJobOrderStatus::Completed,
                                ConstJobOrderStatus::PaymentCleared,
                                ConstJobOrderStatus::CompletedAndClosedByAdmin,
                            );
                        } else if ($this->request->params['named']['status'] == 'rejected') {
                            $status = array(
                                ConstJobOrderStatus::Rejected,
                            );
                        } else if ($this->request->params['named']['status'] == 'cancelled') {
                            $status = array(
                                ConstJobOrderStatus::Cancelled,
                                ConstJobOrderStatus::CancelledByAdmin,
                                ConstJobOrderStatus::CancelledDueToOvertime,
                            );
                        } else if ($this->request->params['named']['status'] == 'expired') {
                            $status = array(
                                ConstJobOrderStatus::Expired,
                            );
                        } else if ($this->request->params['named']['status'] == 'in_progress') {
                            $status = array(
                                ConstJobOrderStatus::InProgress,
                            );
                        } else if ($this->request->params['named']['status'] == 'in_progress_overtime') {
                            $status = array(
                                ConstJobOrderStatus::InProgressOvertime
                            );
                        } else if ($this->request->params['named']['status'] == 'rework') {
                            $status = array(
                                ConstJobOrderStatus::Redeliver
                            );
                        } else if ($this->request->params['named']['status'] == 'mutual_canceled') {
                            $status = array(
                                ConstJobOrderStatus::MutualCancelled	
                            );
                        } else {
                            $status = strtr($this->request->params['named']['status'], $order_status);
                        }
                        $conditions['JobOrder.job_order_status_id'] = $status;
                    }
                    if (!empty($this->request->params['named']['slug'])) {
                        $conditions['Job.slug'] = $this->request->params['named']['slug'];
                    }
                } else {
                    $status = array(
                        __l('All') => 'all',
                        __l('Active') => 'active',
                        __l('Cleared') => 'cleared',
                        __l('On Hold') => 'onhold',
                        __l('Reversed') => 'reversed',
                        __l('Pending') => 'pending',
                        __l('Paid') => 'paid',
                    );
                    $this->set('moreActions', $status);
                    if (!empty($this->request->params['named']['status'])) {
                        $status = $this->request->params['named']['status'];
                        if ($status == 'reversed') {
                            $conditions['JobOrder.job_order_status_id'] = array(
                                ConstJobOrderStatus::Rejected,
                                ConstJobOrderStatus::Cancelled,
                                ConstJobOrderStatus::Expired,
                                ConstJobOrderStatus::CancelledDueToOvertime,
                                ConstJobOrderStatus::CancelledByAdmin,
								ConstJobOrderStatus::MutualCancelled,
                            );
                        } else if ($status == 'cleared') {
                            $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::PaymentCleared;
                        } else if ($status == 'paid') {
                            $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::WaitingforReview;
                        } else if ($status == 'onhold') {
                            $conditions['JobOrder.job_order_status_id'] = array(
                                ConstJobOrderStatus::InProgress,
                                ConstJobOrderStatus::InProgressOvertime
                            );
                        } else if ($status == 'pending') {
                            $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::WaitingforAcceptance;
                        } else if ($status == 'active') {
                            $conditions['JobOrder.job_order_status_id'] = array(
                                ConstJobOrderStatus::InProgress,
                                ConstJobOrderStatus::WaitingforReview,
                                ConstJobOrderStatus::InProgressOvertime,
                            );
                        }
                    }
                } //CompletedAndClosedByAdmin
                $conditions['Not']['JobOrder.job_order_status_id'] = array(
                    0,
                    ConstJobOrderStatus::PaymentPending
                );
                if ($this->request->params['named']['type'] == 'gain') {
                    $this->pageTitle = __l('My Revenues');
                } else {
                    $this->pageTitle = __l('My Todo List');
                }
                $conditions['Job.user_id'] = $this->Auth->user('id');
            }
        } else {
            $conditions['Job.user_id'] = $this->Auth->user('id');
        }
		$this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'JobOrder.id',
                'JobOrder.created',
                'JobOrder.user_id',
                'JobOrder.job_id',
                'JobOrder.job_order_status_id',
                'JobOrder.amount',
                'JobOrder.commission_amount',
                'JobOrder.completed_date',
                'JobOrder.address',
                'JobOrder.mobile',
                'JobOrder.information_from_buyer',
                'JobOrder.last_redeliver_accept_date',
                'JobOrder.is_seller_request_for_cancel',
                'JobOrder.is_buyer_request_for_cancel',
                'JobOrder.is_under_dispute'
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.blocked_amount',
                        'User.available_balance_amount',
                        'User.available_purchase_amount',
                        'User.cleared_amount',
                    )
                ) ,
                'JobOrderStatus' => array(
                    'fields' => array(
                        'JobOrderStatus.id',
                        'JobOrderStatus.name',
                        'JobOrderStatus.job_order_count',
                        'JobOrderStatus.slug',
                    )
                ) ,
                'Attachment',
                'Message',
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.created',
                        'Job.title',
                        'Job.slug',
                        'Job.job_category_id',
                        'Job.user_id',
                        'Job.description',
                        'Job.no_of_days',
                        'Job.job_service_location_id',
                        'Job.job_type_id',
                    ) ,
                    'JobType',
                    'Attachment' => array(
                        'fields' => array(
                            'Attachment.id',
                            'Attachment.filename',
                            'Attachment.dir',
                            'Attachment.width',
                            'Attachment.height'
                        ) ,
                        'limit' => 1,
                        'order' => array(
                            'Attachment.id' => 'asc'
                        )
                    ) ,
                ) ,
            ) ,
            'order' => $order,
            'recursive' => 3,
        );
        $this->set('jobOrders', $this->paginate());
        if (!empty($this->request->params['named']['type'])) { // Type
            $pendingAmount = $this->JobOrder->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            if ($this->request->params['named']['type'] == 'history' || $this->request->params['named']['type'] == 'gain') { // Buyer n seller
                $balance_amount['blocked_amount'] = $pendingAmount['User']['blocked_amount'];
                $balance_amount['available_balance_amount'] = $pendingAmount['User']['available_balance_amount'];
                $balance_amount['available_purchase_amount'] = $pendingAmount['User']['available_purchase_amount'];
                $balance_amount['cleared_amount'] = $pendingAmount['User']['sales_cleared_amount'];
                $balance_amount['total_amount'] = $pendingAmount['User']['blocked_amount']+$pendingAmount['User']['available_balance_amount'];
                $this->set('balance_amount', $balance_amount);
                $this->render('balance');
            } else if ($this->request->params['named']['type'] == 'myorders') {
                $balance_amount['available_balance_amount'] = $pendingAmount['User']['available_balance_amount'];
                $this->set('balance_amount', $balance_amount);
                $this->render('my_orders');
            }
        }
    }
    function download($attachment_id = null)
    {
        //checking Authontication
        if (empty($attachment_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $file = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.id =' => $attachment_id,
                'Attachment.class =' => 'JobOrder',
            ) ,
            'recursive' => -1
        ));
        $filename = substr($file['Attachment']['filename'], 0, strrpos($file['Attachment']['filename'], '.'));
        $file_extension = substr($file['Attachment']['filename'], strrpos($file['Attachment']['filename'], '.') +1, strlen($file['Attachment']['filename']));
        $file_path = str_replace('\\', '/', 'media' . DS . $file['Attachment']['dir'] . DS . $file['Attachment']['filename']);
        // Code to download
        Configure::write('debug', 0);
        $this->viewClass = 'Media';
        $this->autoLayout = false;
        $this->set('name', trim($filename));
        $this->set('download', true);
        $this->set('extension', trim($file_extension));
        $this->set('mimeType', array(
            $file_extension => get_mime($file_path)
        ));
        $this->set('path', $file_path);
    }
    // Displays detail description about the order purchased by the buyer in shopping menu //
    function track_order($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $jobOrder = $this->JobOrder->find('first', array(
            'conditions' => array(
                'JobOrder.id' => $id,
                'JobOrder.user_id' => $this->Auth->user('id')
            ) ,
            'contain' => array(
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.title',
                        'Job.user_id',
                        'Job.no_of_days',
                        'Job.slug',
                        'Job.amount',
                        'Job.address',
                        'Job.mobile',
                        'Job.job_type_id',
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
                    )
                ) ,
                'JobOrderStatus',
            ) ,
            'recursive' => 2,
        ));
        $relatedMessages = $this->JobOrder->Message->find('all', array(
            'conditions' => array(
                'Message.job_order_id =' => $id,
                'Message.is_review =' => 1,
                'Message.is_sender =' => 0
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.id',
                        'MessageContent.created',
                        'MessageContent.subject',
                        'MessageContent.message',
                    ) ,
                    'Attachment'
                ) ,
                'Job' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                        )
                    ) ,
                    'fields' => array(
                        'Job.id',
                        'Job.created',
                        'Job.user_id',
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        if (empty($jobOrder)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Status of your order No') . '#' . $jobOrder['JobOrder']['id'];
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'print') {
            $this->pageTitle = __l('Order') . '# ' . $jobOrder['JobOrder']['id'];
            $this->layout = 'print';
        }
        $this->set(compact('jobOrder', 'relatedMessages'));
    }
    /*
    Imp method where all Order process takes place
    Order stages in this method
    - Accept
    - Reject/Cancel
    - Review
    - Complete
    - Internal mail n external notification to buyer n seller
    */
    function update_order()
    {
        $this->autoRender = false;
        $success = '0';
        $this->loadModel('Payment');
        if (!empty($this->request->params['named']['order'])) {
            $processed_order = $this->JobOrder->processOrder($this->request->params['named']['job_order_id'], $this->request->params['named']['order']);
            if ($this->request->params['named']['order'] == 'complete') {
                $days_after_amount_withdraw = Configure::read('job.days_after_amount_withdraw');
                if (empty($days_after_amount_withdraw)) {
                    $conditions = array(
                        'JobOrder.id' => $this->request->params['named']['job_order_id']
                    );
                    App::import('Core', 'ComponentCollection');
                    $collection = new ComponentCollection();
                    App::import('Component', 'cron');
                    $this->Cron = new CronComponent($collection);
                    $this->Cron->update_job_orders($conditions);
                }
            }
            if (!empty($processed_order['redirect']) && !$processed_order['error']) {
                if (!empty($processed_order['flash_message'])) {
                    $this->Session->setFlash(__l($processed_order['flash_message']) , 'default', null, 'success');
                }
                if ($this->RequestHandler->isAjax() && ($processed_order['ajax_repsonse'] == 'failed' || $this->request->params['named']['view_type'] == 'activities')) {
                    $ajax_url = Router::url(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'order_id' => $processed_order['order_id'],
                        'type' => $processed_order['redirect'],
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
                if ($this->RequestHandler->isAjax() && $processed_order['ajax_repsonse'] != 'failed') {
                    echo $processed_order['ajax_repsonse'];
                    exit;
                }
                if (!$this->RequestHandler->isAjax() && !empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'activities') {
                    if (empty($processed_order['flash_message'])) {
                        $this->Session->setFlash(__l('Order status changed') , 'default', null, 'success');
                    }
                    $this->redirect(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'order_id' => $processed_order['order_id'],
                        'type' => $processed_order['redirect'],
                    ));
                }
                $this->redirect(array(
                    'action' => 'index',
                    'type' => $processed_order['redirect'],
                    'status' => $processed_order['status']
                ));
            } else {
                if (!empty($processed_order['flash_message'])) {
                    $this->Session->setFlash(__l($processed_order['flash_message']) , 'default', null, 'error');
                }
                $this->redirect(array(
                    'action' => 'index',
                    'type' => $processed_order['redirect']
                ));
            }
        } else {
            $this->redirect(array(
                'controller' => 'jobs',
                'action' => 'index',
            ));
        }
    }
    function verify_work()
    {
        $this->pageTitle = __l('Verify work');
        if (!empty($this->request->data)) {
            $this->JobOrder->set($this->request->data);
            if ($this->JobOrder->validates()) {
                if ($this->RequestHandler->isAjax()) {
                    $ajax_url = Router::url(array(
                        'controller' => 'job_orders',
                        'action' => 'update_order',
                        'order' => 'review',
                        'job_order_id' => $this->request->data['JobOrder']['id']
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                } else {
                    $this->redirect(array(
                        'controller' => 'job_orders',
                        'action' => 'update_order',
                        'order' => 'review',
                        'job_order_id' => $this->request->data['JobOrder']['id']
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Invalid verification code.') , 'default', null, 'error');
            }
        } else {
            $this->request->data['JobOrder']['id'] = $this->request->params['named']['job_order_id'];
        }
    }
    function manage()
    {
        $conditions = array();
        if (!empty($this->request->data)) {
            $is_sucess = false;
            $conditions['JobOrder.id'] = $this->request->data['JobOrder']['id'];
            $order = $this->JobOrder->find('first', array(
                'conditions' => $conditions,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                        ) ,
                    ) ,
                    'OwnerUser' => array(
                        'fields' => array(
                            'OwnerUser.id',
                            'OwnerUser.username',
                            'OwnerUser.email',
                        ) ,
                    ) ,
                    'Job' => array(
                        'fields' => array(
                            'Job.id',
                            'Job.title',
                            'Job.slug',
                        ) ,
                        'JobType'
                    ) ,
                ) ,
                'recursive' => 2
            ));
            // Redeliver the work
            if (isset($this->request->data['JobOrder']['report_id']) && $this->request->data['JobOrder']['report_id'] == 0) {
                // INFO: Redeliver Request //
                if ($order['JobOrder']['user_id'] == $this->Auth->user('id') && $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview && isset($this->request->data['JobOrder']['redeliver']) && !($order['JobOrder']['is_redeliver_request'])) {
                    $this->JobOrder->updateAll(array(
                        'JobOrder.is_redeliver_request' => 1, // request redeliver set
                        'JobOrder.redeliver_count' => $order['JobOrder']['redeliver_count']+1
                    ) , array(
                        'JobOrder.id' => $this->request->data['JobOrder']['id']
                    ));
                    $to = $order['OwnerUser']['id'];
                    $to_buyer = $order['User']['id'];
                    $sender_email = $order['OwnerUser']['email'];
                    $buyer_email = $order['User']['email'];
                    $template = $this->EmailTemplate->selectTemplate('Redeliver notification mail');
                    $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'];
                    $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
                    $emailFindReplace = array(
                        '##USERNAME##' => $order['OwnerUser']['username'],
                        '##OTHER_USER##' => $order['User']['username'],
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##JOB_NAME##' => "<a href=" . Router::url(array(
                            'controller' => 'jobs',
                            'action' => 'view',
                            $order['Job']['slug'],
                        ) , true) . ">" . $order['Job']['title'] . "</a>",
                        '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                        '##ORDERNO##' => $order['JobOrder']['id'],
                        '##MESSAGE##' => !empty($this->request->data['JobOrder']['message']) ? $this->request->data['JobOrder']['message'] : '',
                    );
                    $message = strtr($template['email_text_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    $order_id = $order['JobOrder']['id'];
                    $job_id = $order['JobOrder']['job_id'];
                    if (Configure::read('messages.is_send_internal_message')) {
                        $is_auto = 1;
                        $message_id = $this->JobOrder->User->Message->sendNotifications($to, $subject, $message, $order_id, $is_review = 0, $job_id, ConstJobOrderStatus::RedeliverRequest, '0', $is_auto);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = __l('Your order has been requested for rework');
                            $content['message'] = __l('Your order has been requested for rework');
                            if (!empty($sender_email)) {
                                if ($this->JobOrder->_checkUserNotifications($to, ConstJobOrderStatus::RedeliverRequest, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                    $this->Session->setFlash(__l('Order Request improvement has been placed.') , 'default', null, 'success');
                    $is_sucess = true;
                } // INFO: Redeliver Request Cancel (below)//
                elseif ($order['JobOrder']['user_id'] == $this->Auth->user('id') && $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview && isset($this->request->data['JobOrder']['redeliver_cancel']) && ($order['JobOrder']['is_redeliver_request'])) {
                    $this->JobOrder->updateAll(array(
                        'JobOrder.is_redeliver_request' => 0, // reset redeliver request because request has been accepted

                    ) , array(
                        'JobOrder.id' => $this->request->data['JobOrder']['id']
                    ));
                    $to = $order['OwnerUser']['id'];
                    $to_buyer = $order['User']['id'];
                    $sender_email = $order['OwnerUser']['email'];
                    $buyer_email = $order['User']['email'];
                    $template = $this->EmailTemplate->selectTemplate('Redeliver cancel notification');
                    $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'];
                    $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
                    $emailFindReplace = array(
                        '##USERNAME##' => $order['OwnerUser']['username'],
                        '##OTHER_USER##' => $order['User']['username'],
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##JOB_NAME##' => "<a href=" . Router::url(array(
                            'controller' => 'jobs',
                            'action' => 'view',
                            $order['Job']['slug'],
                        ) , true) . ">" . $order['Job']['title'] . "</a>",
                        '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                        '##ORDERNO##' => $order['JobOrder']['id'],
                        '##MESSAGE##' => !empty($this->request->data['JobOrder']['message']) ? $this->request->data['JobOrder']['message'] : '',
                    );
                    $message = strtr($template['email_text_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    $order_id = $order['JobOrder']['id'];
                    $job_id = $order['JobOrder']['job_id'];
                    $is_auto = 1;
                    if (Configure::read('messages.is_send_internal_message')) {
                        $message_id = $this->JobOrder->User->Message->sendNotifications($to, $subject, $message, $order_id, $is_review = 0, $job_id, ConstJobOrderStatus::RedeliverRequestCancel, '0', $is_auto);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = __l('Rework request has been cancelled by the buyer.');
                            $content['message'] = __l('Rework request has been cancelled by the buyer.');
                            if (!empty($sender_email)) {
                                if ($this->JobOrder->_checkUserNotifications($to, ConstJobOrderStatus::RedeliverRequest, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                    $this->Session->setFlash(__l('Request improvement cancelled.') , 'default', null, 'success');
                    $is_sucess = true;
                } // INFO: Redeliver Request Accept (below)//
                elseif ($order['JobOrder']['owner_user_id'] == $this->Auth->user('id') && $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview && isset($this->request->data['JobOrder']['accept_redeliver']) && ($order['JobOrder']['is_redeliver_request'])) {
                    $order_data['JobOrder']['id'] = $this->request->data['JobOrder']['id'];
                    $order_data['JobOrder']['job_order_status_id'] = ConstJobOrderStatus::Redeliver;
                    $order_data['JobOrder']['is_redeliver_request'] = 0; // reset redeliver request because request has been accepted
                    $order_data['JobOrder']['redeliver_accept_count'] = $order['JobOrder']['redeliver_accept_count']+1;
                    $order_data['JobOrder']['last_redeliver_accept_date'] = date('Y-m-d H:i:s');
                    $this->JobOrder->save($order_data);
                    $to_buyer = $order['OwnerUser']['id'];
                    $to = $order['User']['id'];
                    $buyer_email = $order['OwnerUser']['email'];
                    $sender_email = $order['User']['email'];
                    $template = $this->EmailTemplate->selectTemplate('Redeliver accept notification');
                    $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'];
                    $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
                    $emailFindReplace = array(
                        '##USERNAME##' => $order['User']['username'],
                        '##OTHER_USER##' => $order['OwnerUser']['username'],
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##JOB_NAME##' => "<a href=" . Router::url(array(
                            'controller' => 'jobs',
                            'action' => 'view',
                            $order['Job']['slug'],
                        ) , true) . ">" . $order['Job']['title'] . "</a>",
                        '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                        '##ORDERNO##' => $order['JobOrder']['id'],
                        '##MESSAGE##' => !empty($this->request->data['JobOrder']['message']) ? $this->request->data['JobOrder']['message'] : '',
                    );
                    $message = strtr($template['email_text_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    $order_id = $order['JobOrder']['id'];
                    $job_id = $order['JobOrder']['job_id'];
                    $is_auto = 1;
                    if (Configure::read('messages.is_send_internal_message')) {
                        $message_id = $this->JobOrder->User->Message->sendNotifications($to, $subject, $message, $order_id, $is_review = 0, $job_id, ConstJobOrderStatus::RedeliverRequest, '0', $is_auto);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = __l('Request improvement has been accepted.');
                            $content['message'] = __l('Request improvement has been accepted.');
                            if (!empty($sender_email)) {
                                if ($this->JobOrder->_checkUserNotifications($to, ConstJobOrderStatus::RedeliverRequest, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                    $this->Session->setFlash(__l('Rework for this order has been accepted. You need to redeliver your work.') , 'default', null, 'success');
                    $is_sucess = true;
                } // INFO: Redeliver Request Reject (below)//
                elseif ($order['JobOrder']['owner_user_id'] == $this->Auth->user('id') && $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview && isset($this->request->data['JobOrder']['reject_redeliver']) && ($order['JobOrder']['is_redeliver_request'])) {
                    $this->JobOrder->updateAll(array(
                        'JobOrder.is_redeliver_request' => 0, // reset redeliver request because request has been accepted

                    ) , array(
                        'JobOrder.id' => $this->request->data['JobOrder']['id']
                    ));
                    $to_buyer = $order['OwnerUser']['id'];
                    $to = $order['User']['id'];
                    $buyer_email = $order['OwnerUser']['email'];
                    $sender_email = $order['User']['email'];
                    $template = $this->EmailTemplate->selectTemplate('Redeliver reject notification');
                    $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'];
                    $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
                    $emailFindReplace = array(
                        '##USERNAME##' => $order['User']['username'],
                        '##OTHER_USER##' => $order['OwnerUser']['username'],
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##JOB_NAME##' => "<a href=" . Router::url(array(
                            'controller' => 'jobs',
                            'action' => 'view',
                            $order['Job']['slug'],
                        ) , true) . ">" . $order['Job']['title'] . "</a>",
                        '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                        '##ORDERNO##' => $order['JobOrder']['id'],
                        '##MESSAGE##' => !empty($this->request->data['JobOrder']['message']) ? $this->request->data['JobOrder']['message'] : '',
                    );
                    $message = strtr($template['email_text_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    $order_id = $order['JobOrder']['id'];
                    $job_id = $order['JobOrder']['job_id'];
                    $is_auto = 1;
                    if (Configure::read('messages.is_send_internal_message')) {
                        $message_id = $this->JobOrder->User->Message->sendNotifications($to, $subject, $message, $order_id, $is_review = 0, $job_id, ConstJobOrderStatus::RedeliverRejected, '0', $is_auto);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = __l('Rejected request improvement');
                            $content['message'] = __l('Rejected request improvement');
                            if (!empty($sender_email)) {
                                if ($this->JobOrder->_checkUserNotifications($to, ConstJobOrderStatus::RedeliverRequest, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                    $this->Session->setFlash(__l('request improvement rejected.') , 'default', null, 'success');
                    $is_sucess = true;
                }
            }
            //INFO:  Mutual Cancel Requested //
            if ((isset($this->request->data['JobOrder']['mutual_cancel']) || isset($this->request->data['JobOrder']['accept_mutual_cancel'])) && isset($this->request->data['JobOrder']['report_id']) && $this->request->data['JobOrder']['report_id'] == 1) {
                $order_data['JobOrder']['id'] = $this->request->data['JobOrder']['id'];
                $order_data['JobOrder']['job_order_status_id'] = $order['JobOrder']['job_order_status_id'];
				$order_data['JobOrder']['accepted_date'] = $order['JobOrder']['accepted_date'];
                $refund = false;
                if ($order['JobOrder']['user_id'] == $this->Auth->user('id') && ($order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgress || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Redeliver || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview)) {
                    $order_data['JobOrder']['is_buyer_request_for_cancel'] = 1;
                    if ($order['JobOrder']['is_seller_request_for_cancel']) {
                        $refund = true;
                    } else {
                        $order_data['JobOrder']['cancel_initiator_user_id'] = $this->Auth->user('id');
                    }
                } elseif ($order['JobOrder']['owner_user_id'] == $this->Auth->user('id') && ($order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgress || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Redeliver || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview)) {
                    $order_data['JobOrder']['is_seller_request_for_cancel'] = 1;
                    if ($order['JobOrder']['is_buyer_request_for_cancel']) {
                        $refund = true;
                    } else {
                        $order_data['JobOrder']['cancel_initiator_user_id'] = $this->Auth->user('id');
                    }
                }
                if ($this->JobOrder->save($order_data)) {
                    $is_sucess = true;
                    if ($refund) {
                        $this->JobOrder->updateAll(array(
                            'JobOrder.mutual_cancel_accept' => $order['JobOrder']['mutual_cancel_accept']+1, // reset redeliver request because request has been accepted

                        ) , array(
                            'JobOrder.id' => $this->request->data['JobOrder']['id']
                        ));
                        $this->JobOrder->processOrder($order['JobOrder']['id'], 'mutual_cancel', $this->request->data['JobOrder']['message']);
                        $this->Session->setFlash(__l('Order has been cancelled and refunded.') , 'default', null, 'success');
                    } else {
                        $this->JobOrder->updateAll(array(
                            'JobOrder.mutual_cancel_request' => $order['JobOrder']['mutual_cancel_request']+1, // reset redeliver request because request has been accepted

                        ) , array(
                            'JobOrder.id' => $this->request->data['JobOrder']['id']
                        ));
                        // Updating mutual cancel requested date //
                        $this->JobOrder->updateAll(array(
                            'JobOrder.mutual_cancellation_requested_date' => "'" . date('Y-m-d H:i:s') . "'"
                        ) , array(
                            'JobOrder.id' => $this->request->data['JobOrder']['id']
                        ));
                        // Sending mail to sender //
                        $template = $this->EmailTemplate->selectTemplate("Mutual Cancel Request Notification");
                        $emailFindReplace = array(
                            '##JOB_NAME##' => "<a href=" . Router::url(array(
                                'controller' => 'jobs',
                                'action' => 'view',
                                $order['Job']['slug'],
                                'admin' => false,
                            ) , true) . ">" . $order['Job']['title'] . "</a>",
                            '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                            '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
                            '##ORDERNO##' => $order['JobOrder']['id'],
                            '##MESSAGE##' => !empty($this->request->data['JobOrder']['message']) ? $this->request->data['JobOrder']['message'] : '',
                        );
                        $to = $sender_email = '';
                        if ($order['OwnerUser']['id'] == $this->Auth->user('id')) {
                            $emailFindReplace['##USERNAME##'] = $order['User']['username'];
                            $emailFindReplace['##OTHER_USER##'] = $order['OwnerUser']['username'];
                            $to = $order['User']['id'];
                            $sender_email = $order['User']['email'];
                        } elseif ($order['User']['id'] == $this->Auth->user('id')) {
                            $emailFindReplace['##OTHER_USER##'] = $order['User']['username'];
                            $emailFindReplace['##USERNAME##'] = $order['OwnerUser']['username'];
                            $to = $order['OwnerUser']['id'];
                            $sender_email = $order['OwnerUser']['email'];
                        }
                        $message = strtr($template['email_text_content'], $emailFindReplace);
                        $subject = strtr($template['subject'], $emailFindReplace);
                        $is_auto = 1;
                        if (Configure::read('messages.is_send_internal_message')) {
                            $message_id = $this->Message->sendNotifications($to, $subject, $message, $order['JobOrder']['id'], '0', $order['JobOrder']['job_id'], ConstJobOrderStatus::MutualCancelRequest, '0', $is_auto);
                            if (Configure::read('messages.is_send_email_on_new_message')) {
                                $content['subject'] = $subject;
                                $content['message'] = $subject;
                                if (!empty($sender_email)) {
                                    if ($this->JobOrder->_checkUserNotifications($to, ConstJobOrderStatus::MutualCancelRequest, 0)) {
                                        $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                    }
                                }
                            }
                        }
                        // End of send mail //
                        $this->Session->setFlash(__l('Mutual Cancel requested') , 'default', null, 'success');
                    }
                }
            } //INFO:  Mutual Cancel Rejected //
            if ((isset($this->request->data['JobOrder']['reject_mutual_cancel'])) && isset($this->request->data['JobOrder']['report_id']) && $this->request->data['JobOrder']['report_id'] == 1) {
                $order_data['JobOrder']['id'] = $order['JobOrder']['id'];
                $order_data['JobOrder']['cancel_initiator_user_id'] = 0;
                $order_data['JobOrder']['is_seller_request_for_cancel'] = 0;
                $order_data['JobOrder']['is_buyer_request_for_cancel'] = 0;
                if ($this->JobOrder->save($order_data)) {
                    // Sending mail to sender //
                    $template = $this->EmailTemplate->selectTemplate("Mutual Cancel Reject Notification");
                    $emailFindReplace = array(
                        '##JOB_NAME##' => "<a href=" . Router::url(array(
                            'controller' => 'jobs',
                            'action' => 'view',
                            $order['Job']['slug'],
                            'admin' => false,
                        ) , true) . ">" . $order['Job']['title'] . "</a>",
                        '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                        '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
                        '##ORDERNO##' => $order['JobOrder']['id'],
                        '##MESSAGE##' => !empty($this->request->data['JobOrder']['message']) ? $this->request->data['JobOrder']['message'] : '',
                    );
                    if ($order['JobOrder']['is_buyer_request_for_cancel'] == 1) {
                        $emailFindReplace['##USERNAME##'] = $order['User']['username'];
                        $emailFindReplace['##OTHER_USER##'] = $order['OwnerUser']['username'];
                        $to = $order['User']['id'];
                        $sender_email = $order['User']['email'];
                    } elseif ($order['JobOrder']['is_seller_request_for_cancel'] == 1) {
                        $emailFindReplace['##OTHER_USER##'] = $order['User']['username'];
                        $emailFindReplace['##USERNAME##'] = $order['OwnerUser']['username'];
                        $to = $order['OwnerUser']['id'];
                        $sender_email = $order['OwnerUser']['email'];
                    }
                    $message = strtr($template['email_text_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    $is_auto = 1;
                    if (Configure::read('messages.is_send_internal_message')) {
                        $message_id = $this->Message->sendNotifications($to, $subject, $message, $order['JobOrder']['id'], '0', $order['JobOrder']['id'], ConstJobOrderStatus::MutualCancelRejected, '0', $is_auto);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = $subject;
                            $content['message'] = $subject;
                            if (!empty($sender_email)) {
                                if ($this->JobOrder->_checkUserNotifications($to, ConstJobOrderStatus::MutualCancelRequest, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                    // End of send mail //
                    $this->Session->setFlash(__l('Mutual Cancel Rejected') , 'default', null, 'success');
                }
            }
            //if($is_sucess){
            if ($order['JobOrder']['user_id'] == $this->Auth->user('id')) {
                if (empty($this->request->params['isAjax'])) {
                    $this->redirect(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'type' => 'myorders',
                        'order_id' => $this->request->data['JobOrder']['id']
                    ));
                } else {
                    $ajax_url = Router::url(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'type' => 'myorders',
                        'order_id' => $this->request->data['JobOrder']['id']
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            }
            if ($order['JobOrder']['owner_user_id'] == $this->Auth->user('id')) {
                if (empty($this->request->params['isAjax'])) {
                    $this->redirect(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'type' => 'myworks',
                        'order_id' => $this->request->data['JobOrder']['id']
                    ));
                } else {
                    $ajax_url = Router::url(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'type' => 'myworks',
                        'order_id' => $this->request->data['JobOrder']['id']
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            }
            //}

        } else {
            $conditions['JobOrder.id'] = $this->request->params['named']['job_order_id'];
            $this->request->data['JobOrder']['id'] = $this->request->params['named']['job_order_id'];
        }
        $order = $this->JobOrder->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                    )
                ) ,
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.title',
                        'Job.slug',
                        'Job.user_id',
                        'Job.amount',
                        'Job.job_type_id',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                        )
                    ) ,
                ) ,
                'JobOrderStatus'
            ) ,
            'recursive' => 2
        ));
        if (empty($order)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $reports = array(
            0 => 'Redeliver',
            1 => 'Mutual Cancel',
            2 => 'Dispute'
        );
        $this->request->data['JobOrder']['report_id'] = 0;
        if ($order['Job']['job_type_id'] == ConstJobType::Offline) { // Unsetting redeliver if job type is offline
            unset($reports[0]);
        }
        $this->set('reports', $reports);
        $this->set('order', $order);
    }
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'filter_id',
            'user_id',
            'job_id',
            'q'
        ));
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Orders');
        $conditions = array();
        $conditions['JobOrder.job_order_status_id !='] = 0;
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['JobOrder']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['user_id'])) {
            $conditions['JobOrder.user_id'] = $this->request->params['named']['user_id'];
        }
        if (isset($this->request->params['named']['owner_user_id'])) {
            $conditions['JobOrder.owner_user_id'] = $this->request->params['named']['owner_user_id'];
        }
        if (isset($this->request->params['named']['job_id'])) {
            $conditions['JobOrder.job_id'] = $this->request->params['named']['job_id'];
        }
        if (!empty($this->request->params['named']['type'])) {
            if ($this->request->params['named']['type'] == 'cleared') {
                $conditions['JobOrder.job_order_status_id'] = array(
                    ConstJobOrderStatus::PaymentCleared
                );
            }
            if ($this->request->params['named']['type'] == 'lost') {
                $conditions['JobOrder.job_order_status_id'] = array(
                    ConstJobOrderStatus::Cancelled,
                    ConstJobOrderStatus::Rejected,
                    ConstJobOrderStatus::Expired,
                    ConstJobOrderStatus::CancelledDueToOvertime,
                    ConstJobOrderStatus::CancelledByAdmin
                );
            }
            if ($this->request->params['named']['type'] == 'pipeline') {
                $conditions['JobOrder.job_order_status_id'] = array(
                    ConstJobOrderStatus::WaitingforAcceptance,
                    ConstJobOrderStatus::InProgress,
                    ConstJobOrderStatus::WaitingforReview,
                    ConstJobOrderStatus::Completed,
                    ConstJobOrderStatus::InProgressOvertime,
                    ConstJobOrderStatus::CompletedAndClosedByAdmin
                );
            }
            if ($this->request->params['named']['type'] == 'buyer_completed') {
                $conditions['JobOrder.job_order_status_id'] = array(
                    ConstJobOrderStatus::Completed,
                    ConstJobOrderStatus::PaymentCleared,
                    ConstJobOrderStatus::CompletedAndClosedByAdmin
                );
            }
            if ($this->request->params['named']['type'] == 'buyer_cancelled') {
                $conditions['JobOrder.job_order_status_id'] = array(
                    ConstJobOrderStatus::Cancelled,
                    ConstJobOrderStatus::CancelledByAdmin,
                );
            }
            if ($this->request->params['named']['type'] == 'seller_completed') {
                $conditions['JobOrder.job_order_status_id'] = array(
                    ConstJobOrderStatus::Completed,
                    ConstJobOrderStatus::PaymentCleared,
                    ConstJobOrderStatus::CompletedAndClosedByAdmin
                );
            }
            if ($this->request->params['named']['type'] == 'seller_cancelled') {
                $conditions['JobOrder.job_order_status_id'] = array(
                    ConstJobOrderStatus::Cancelled,
                    ConstJobOrderStatus::CancelledByAdmin,
                    ConstJobOrderStatus::CancelledDueToOvertime
                );
            }
            if ($this->request->params['named']['type'] == 'order_completed') {
                $conditions['JobOrder.job_order_status_id'] = array(
                    ConstJobOrderStatus::Completed,
                    ConstJobOrderStatus::PaymentCleared,
                    ConstJobOrderStatus::CompletedAndClosedByAdmin,
                );
            }
            if ($this->request->params['named']['type'] == 'order_cancelled') {
                $conditions['JobOrder.job_order_status_id'] = array(
                    ConstJobOrderStatus::Cancelled,
                    ConstJobOrderStatus::CancelledByAdmin,
                    ConstJobOrderStatus::CancelledDueToOvertime,
                );
            }
        }
        if (!empty($this->request->data['JobOrder']['filter_id'])) {
            switch ($this->request->data['JobOrder']['filter_id']) {
                case ConstJobOrderStatus::PaymentPending:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::PaymentPending;
                    $this->pageTitle.= __l(' - Payment Pending ');
                    break;

                case ConstJobOrderStatus::WaitingforAcceptance:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::WaitingforAcceptance;
                    $this->pageTitle.= __l(' - Waiting for acceptance ');
                    break;

                case ConstJobOrderStatus::InProgress:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::InProgress;
                    $this->pageTitle.= __l(' - In progress ');
                    break;

                case ConstJobOrderStatus::WaitingforReview:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::WaitingforReview;
                    $this->pageTitle.= __l(' - Waiting for review');
                    break;

                case ConstJobOrderStatus::Completed:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::Completed;
                    $this->pageTitle.= __l(' - Completed');
                    break;

                case ConstJobOrderStatus::Cancelled:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::Cancelled;
                    $this->pageTitle.= __l(' - Cancelled ');
                    break;

                case ConstJobOrderStatus::Rejected:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::Rejected;
                    $this->pageTitle.= __l(' - Rejected');
                    break;

                case ConstJobOrderStatus::PaymentCleared:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::PaymentCleared;
                    $this->pageTitle.= __l(' - Payment cleared');
                    break;

                case ConstJobOrderStatus::InProgress:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::InProgress;
                    $this->pageTitle.= __l(' - In Progress');
                    break;

                case ConstJobOrderStatus::WaitingforReview:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::WaitingforReview;
                    $this->pageTitle.= __l(' - Waiting for Review');
                    break;

                case ConstJobOrderStatus::Completed:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::Completed;
                    $this->pageTitle.= __l(' - Completed');
                    break;

                case ConstJobOrderStatus::Expired:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::Expired;
                    $this->pageTitle.= __l(' - Expired');
                    break;

                case ConstJobOrderStatus::InProgressOvertime:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::InProgressOvertime;
                    $this->pageTitle.= __l(' - In Progress Overtime');
                    break;

                case ConstJobOrderStatus::CancelledDueToOvertime:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::CancelledDueToOvertime;
                    $this->pageTitle.= __l(' - Cancelled Due To Overtime');
                    break;

                case ConstJobOrderStatus::CancelledByAdmin:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::CancelledByAdmin;
                    $this->pageTitle.= __l(' - Cancelled By Admin');
                    break;

                case ConstJobOrderStatus::CompletedAndClosedByAdmin:
                    $conditions['JobOrder.job_order_status_id'] = ConstJobOrderStatus::CompletedAndClosedByAdmin;
                    $this->pageTitle.= __l(' - Completed And Closed By Admin');
                    break;
            }
            $this->request->params['named']['filter_id'] = $this->request->data['JobOrder']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['JobOrder.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' -  today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['JobOrder.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' -  in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['JobOrder.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' -  in this month');
        }
        if (isset($this->request->params['named']['user_id'])) {
            $this->request->data['JobOrder']['user_id'] = $this->request->params['named']['user_id'];
            $user = $this->JobOrder->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['user_id']
                ) ,
                'recursive' => -1
            ));
            if (!empty($user)) {
                $this->pageTitle.= sprintf(__l(' - Search - User - %s') , $user['User']['username']);
            }
            $conditions['JobOrder.user_id'] = $this->request->params['named']['user_id'];
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions['OR'][] = array(
                'User.username LIKE ' => '%' . $this->request->params['named']['q'] . '%'
            );
            $this->pageTitle.= sprintf(__l(' - Search - %s - %s') , jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) , $this->request->params['named']['q']);
            $this->request->data['JobOrder']['q'] = $this->request->params['named']['q'];
        }
        if (!empty($this->request->params['named']['job'])) {
            $job = $this->JobOrder->Job->find('first', array(
                'conditions' => array(
                    'Job.slug' => $this->request->params['named']['job']
                ) ,
                'recursive' => -1
            ));
            if (!empty($job)) {
                $this->pageTitle.= sprintf(__l(' - Search - %s') , $job['Job']['title']);
            }
            $conditions['Job.id'] = $job['Job']['id'];
        }
        if (isset($this->request->params['named']['job_id'])) {
            $this->request->data['JobOrder']['job_id'] = $this->request->params['named']['job_id'];
            $job = $this->JobOrder->Job->find('first', array(
                'conditions' => array(
                    'Job.id' => $this->request->params['named']['job_id']
                ) ,
                'recursive' => -1
            ));
            if (!empty($job)) {
                $this->pageTitle.= sprintf(__l(' - Search - %s') , $job['Job']['title']);
            }
            $conditions['Job.id'] = $this->request->params['named']['job_id'];
        }
        $this->set('page_title', $this->pageTitle);
        $this->JobOrder->recursive = 2;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'JobOrder.id',
                'JobOrder.created',
                'JobOrder.modified',
                'JobOrder.user_id',
                'JobOrder.job_id',
                'JobOrder.job_order_status_id',
                'JobOrder.amount',
                'JobOrder.commission_amount',
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username'
                    )
                ) ,
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.title',
                        'Job.slug'
                    )
                ) ,
                'JobOrderStatus' => array(
                    'fields' => array(
                        'JobOrderStatus.id',
                        'JobOrderStatus.name'
                    )
                )
            ) ,
            'order' => array(
                'JobOrder.id' => 'desc'
            ) ,
            'recursive' => 2
        );
        if (isset($this->request->data['JobOrder']['q'])) {
            $this->paginate['search'] = $this->request->data['JobOrder']['q'];
            $search_result = $this->paginate();
            if (empty($search_result)) {
                $this->set('search_result', '1');
            }
        }
        /*$conditions['Not']['JobOrder.job_order_status_id'] = array(
        ConstJobOrderStatus::Rejected,
        ConstJobOrderStatus::Cancelled,
        ConstJobOrderStatus::Expired,
        ConstJobOrderStatus::CancelledByAdmin,
        ConstJobOrderStatus::CompletedAndClosedByAdmin,
        );*/
        if (empty($this->request->data['JobOrder']['filter_id'])) {
            /*$conditions['Not']['JobOrder.job_order_status_id'] = array(
            //ConstJobOrderStatus::Rejected,
            //ConstJobOrderStatus::Cancelled,
            //ConstJobOrderStatus::Expired,
            //ConstJobOrderStatus::CancelledByAdmin,
            ConstJobOrderStatus::Completed,
            ConstJobOrderStatus::CompletedAndClosedByAdmin,
            );*/
            if (!empty($this->request->params['named']['type'])) {
                if ($this->request->params['named']['type'] == 'cleared') {
                    $conditions['JobOrder.job_order_status_id'] = array(
                        ConstJobOrderStatus::PaymentCleared
                    );
                }
                if ($this->request->params['named']['type'] == 'lost') {
                    $conditions['JobOrder.job_order_status_id'] = array(
                        ConstJobOrderStatus::Cancelled,
                        ConstJobOrderStatus::Rejected,
                        ConstJobOrderStatus::Expired,
                        ConstJobOrderStatus::CancelledDueToOvertime,
                        ConstJobOrderStatus::CancelledByAdmin
                    );
                }
                if ($this->request->params['named']['type'] == 'pipeline') {
                    $conditions['JobOrder.job_order_status_id'] = array(
                        ConstJobOrderStatus::WaitingforAcceptance,
                        ConstJobOrderStatus::InProgress,
                        ConstJobOrderStatus::WaitingforReview,
                        ConstJobOrderStatus::Completed,
                        ConstJobOrderStatus::InProgressOvertime,
                        ConstJobOrderStatus::CompletedAndClosedByAdmin
                    );
                }
            }
        }
        $RevenueRecieved = $this->JobOrder->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'SUM(JobOrder.amount) as total_amount'
            ) ,
            'recursive' => 0
        ));
        $RevenueCommission = $this->JobOrder->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'SUM(JobOrder.commission_amount) as commission_amount'
            ) ,
            'recursive' => 0
        ));
        $PaidAmount = $RevenueRecieved['0']['total_amount']-$RevenueCommission['0']['commission_amount'];
        $totalAmount['total_amount'] = $RevenueRecieved['0']['total_amount'];
        $totalAmount['commission_amount'] = $RevenueCommission['0']['commission_amount'];
        $totalAmount['paid_amount'] = $PaidAmount;
        $filters = $this->JobOrder->isFilterOptions;
        $moreActions = $this->JobOrder->moreActions;
        $this->set(compact('moreActions', 'filters', 'totalAmount'));
        $this->set('jobOrders', $this->paginate());
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $check_order = $this->JobOrder->find('first', array(
            'conditions' => array(
                'JobOrder.id' => $id,
                'JobOrder.job_order_status_id' => array(
                    ConstJobOrderStatus::WaitingforAcceptance,
                    ConstJobOrderStatus::InProgress,
                    ConstJobOrderStatus::WaitingforReview,
                    ConstJobOrderStatus::Completed,
                    ConstJobOrderStatus::InProgressOvertime,
                )
            ) ,
            'recursive' => -1
        ));
        if (empty($check_order)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->JobOrder->processOrder($id, 'admin_cancel')) {
            $this->Session->setFlash(__l('Order has been cancelled and refunded.') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    // Used to Run cron functions from admin function //
    function admin_update_status()
    {
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'cron');
        $this->Cron = new CronComponent($collection);
        $this->Cron->run_crons();
        $this->Session->setFlash(__l('You have successfully triggered the cron jobs.') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'nodes',
            'action' => 'tools'
        ));
    }
    function admin_update()
    {
        if (!empty($this->request->data[$this->modelClass])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $selectedIds = array();
            foreach($this->request->data[$this->modelClass] as $primary_key_id => $is_checked) {
                if ($is_checked['id']) {
                    $selectedIds[] = $primary_key_id;
                }
            }
            if ($actionid && !empty($selectedIds)) {
                if ($actionid == ConstMoreAction::Delete) {
                    $this->JobOrder->deleteAll(array(
                        'JobOrder.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked Order has been deleted') , 'default', null, 'success');
                } else {
                    switch ($actionid) {
                        case ConstMoreAction::WaitingforAcceptance:
                            $status_id = ConstJobOrderStatus::WaitingforAcceptance;
                            break;

                        case ConstMoreAction::InProgress:
                            $status_id = ConstJobOrderStatus::InProgress;
                            break;

                        case ConstMoreAction::WaitingforReview:
                            $status_id = ConstJobOrderStatus::WaitingforReview;
                            break;

                        case ConstMoreAction::Completed:
                            $status_id = ConstJobOrderStatus::Completed;
                            break;

                        case ConstMoreAction::Cancelled:
                            $status_id = ConstJobOrderStatus::Cancelled;
                            break;

                        case ConstMoreAction::Rejected:
                            $status_id = ConstJobOrderStatus::Rejected;
                            break;

                        case ConstMoreAction::PaymentCleared:
                            $status_id = ConstJobOrderStatus::PaymentCleared;
                            break;
                    }
                    $this->JobOrder->updateAll(array(
                        'JobOrder.job_order_status_id' => $status_id
                    ) , array(
                        'JobOrder.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Order Status has been changed') , 'default', null, 'success');
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
}
?>