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
class JobFeedbacksController extends AppController
{
    public $name = 'JobFeedbacks';
    public $components = array(
        'Email',
    );
    public $uses = array(
        'Jobs.JobFeedback',
        'EmailTemplate'
    );
    function index($job_id = null)
    {
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Feedbacks');
        $this->JobFeedback->recursive = 0;
        $conditions = '';
        if (!empty($this->request->params['named']['type'])) {
            if ($this->request->params['named']['type'] == 'feedbacks') {
                $conditions['JobFeedback.job_id'] = $this->request->params['named']['job_id'];
                $conditions['JobFeedback.user_id !='] = ConstUserIds::Admin;
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'JobFeedback.id',
                'JobFeedback.created',
                'JobFeedback.user_id',
                'JobFeedback.feedback',
                'JobFeedback.is_satisfied',
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                )
            ) ,
        );
        $this->set('jobFeedbacks', $this->paginate());
    }
    function add()
    {
        $this->pageTitle = __l('Review');
        if (!empty($this->request->data)) {
            $this->JobFeedback->create();
            $this->request->data['JobFeedback']['ip_id'] = $this->JobFeedback->toSaveIP();
            if ($this->JobFeedback->save($this->request->data)) {
                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'User',
                        'action' => 'Feedback',
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
                        'category' => 'JobFeedback',
                        'action' => 'Feedback',
                        'label' => $this->request->data['JobFeedback']['job_id'],
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $this->request->data['JobFeedback']['job_id'],
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                if (Configure::read('messages.is_send_internal_message')) {
                    $is_auto = 1;
                    $message_id = $this->JobFeedback->Job->JobOrder->Message->sendNotifications($this->request->data['JobFeedback']['job_order_user_id'], $this->Auth->user('username') . ' has left a feedback on your work', $this->request->data['JobFeedback']['feedback'], $this->request->data['JobFeedback']['job_order_id'], $is_review = 0, $this->request->data['JobFeedback']['job_id'], ConstJobOrderStatus::WorkReviewed, '0', $is_auto);
                    if (Configure::read('messages.is_send_email_on_new_message')) {
                        $content['subject'] = $this->Auth->user('username') . ' has left a feedback on your work';
                        $content['message'] = $this->Auth->user('username') . ' has left a feedback on your work';
                        if (!empty($this->request->data['JobFeedback']['job_order_user_email'])) {
                            if ($this->JobFeedback->_checkUserNotifications($this->request->data['JobFeedback']['job_order_user_id'], ConstJobOrderStatus::Completed, 0)) { // (to_user_id, order_status,is_sender);
                                $this->_sendAlertOnNewMessage($this->request->data['JobFeedback']['job_order_user_email'], $content, $message_id, 'Order Alert Mail');
                            }
                        }
                    }
                }
                $this->redirect(array(
                'controller' => 'job_orders',
                'action' => 'update_order',
                'order' => 'complete',
                'job_order_id' => $this->request->data['JobFeedback']['job_order_id']
                )); 
            } else {
                $this->Session->setFlash(__l('Feedback could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        if (empty($this->request->params['named']['job_order_id'])) {
            if (empty($this->request->data['JobFeedback']['job_order_id'])) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        if (!empty($this->request->params['named']) || !empty($this->request->data['JobFeedback']['job_order_id'])) {
            $jobInfo = $this->JobFeedback->Job->JobOrder->Message->find('first', array(
                'conditions' => array(
                    'Message.job_order_id =' => !empty($this->request->data['JobFeedback']['job_order_id']) ? $this->request->data['JobFeedback']['job_order_id'] : $this->request->params['named']['job_order_id'],
                    'Message.is_review =' => 1
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
                    'JobOrder' => array(
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
                                'Job.job_type_id',
                            )
                        )
                    )
                ) ,
                'recursive' => 3,
            ));
            if (empty($jobInfo) || ($jobInfo['JobOrder']['user_id'] != $this->Auth->user('id'))) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if ($jobInfo['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::WaitingforReview && $jobInfo['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::Redeliver) {
                $this->Session->setFlash(__l('It seems that you already responded to this order before.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'job_orders',
                    'action' => 'index',
                    'type' => 'myworks'
                ));
            }
            $message['message'] = $jobInfo['MessageContent']['message'];
            $message['message_hash'] = $jobInfo['Message']['hash'];
            $message['job_id'] = $jobInfo['JobOrder']['job_id'];
            $message['job_order_id'] = $jobInfo['JobOrder']['id'];
            $message['job_order_status_id'] = $jobInfo['JobOrder']['job_order_status_id'];
            $message['job_user_id'] = $jobInfo['JobOrder']['Job']['User']['id'];
            $message['job_order_user_id'] = $jobInfo['JobOrder']['Job']['user_id'];
            $message['job_type_id'] = $jobInfo['JobOrder']['Job']['job_type_id'];
            $message['job_seller_username'] = $jobInfo['JobOrder']['Job']['User']['username'];
            $message['job_seller_email'] = $jobInfo['JobOrder']['Job']['User']['email'];
            $message['job_username'] = $jobInfo['JobOrder']['Job']['User']['username'];
            $message['attachment'] = $jobInfo['MessageContent']['Attachment'];
            $this->set('message', $message);
        }
        if (empty($this->request->data['JobFeedback'])) {
            $this->request->data['JobFeedback']['is_satisfied'] = '1';
        }
        if (!empty($this->request->data['JobFeedback']) && empty($this->request->params['named']['selected'])) {
            if (!empty($this->request->data['JobFeedback']['is_satisfied'])) {
                $this->request->params['named']['selected'] = 'yes';
            } else {
                $this->request->params['named']['selected'] = 'want_to_close';
            }
        }
        if ((!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'simple-feedback') || !empty($this->request->data['JobFeedback']['is_from_activities'])) {
            $this->render('simple-feedback');
        }
    }
    function admin_index()
    {
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Feedbacks');
        $this->_redirectGET2Named(array(
            'q',
        ));
        App::import('Model', 'Jobs.JobFeedback');
        $this->JobFeedback = new JobFeedback();
        $conditions = array();
        if (!empty($this->request->params['named']['job']) || !empty($this->request->params['named']['job_id'])) {
            $jobConditions = !empty($this->request->params['named']['job']) ? array(
                'Job.slug' => $this->request->params['named']['job']
            ) : array(
                'Job.id' => $this->request->params['named']['job_id']
            );
            $job = $this->{$this->modelClass}->Job->find('first', array(
                'conditions' => $jobConditions,
                'fields' => array(
                    'Job.id',
                    'Job.title'
                ) ,
                'recursive' => -1
            ));
            if (empty($job)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Job.id'] = $this->request->data[$this->modelClass]['job_id'] = $job['Job']['id'];
            $this->pageTitle.= ' - ' . $job['Job']['title'];
        }
        if (!empty($this->request->params['named']['username']) || !empty($this->request->params['named']['user_id'])) {
            $userConditions = !empty($this->request->params['named']['username']) ? array(
                'User.username' => $this->request->params['named']['username']
            ) : array(
                'User.id' => $this->request->params['named']['user_id']
            );
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => $userConditions,
                'fields' => array(
                    'User.id',
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['User.id'] = $this->request->data[$this->modelClass]['user_id'] = $user['User']['id'];
            $this->pageTitle.= ' - ' . $user['User']['username'];
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Job.title LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'JobFeedback.feedback LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['JobFeedback']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->set('page_title', $this->pageTitle);
        $this->JobFeedback->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'Job',
                'Ip' => array(
                    'City' => array(
                        'fields' => array(
                            'City.name',
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name',
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.name',
                            'Country.iso_alpha2',
                        )
                    ) ,
                    'fields' => array(
                        'Ip.ip',
                        'Ip.latitude',
                        'Ip.longitude',
                    )
                ) ,
            ) ,
            'order' => array(
                'JobFeedback.id' => 'desc'
            )
        );
        $moreActions = $this->JobFeedback->moreActions;
        $this->set(compact('moreActions'));
        $this->set('jobFeedbacks', $this->paginate());
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Feedback');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->JobFeedback->save($this->request->data)) {
                $this->Session->setFlash(__l('Feedback has been updated.') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Feedback could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->JobFeedback->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['JobFeedback']['id'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->JobFeedback->delete($id)) {
            $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Feedback deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>