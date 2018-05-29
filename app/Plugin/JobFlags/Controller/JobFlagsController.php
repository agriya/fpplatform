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
class JobFlagsController extends AppController
{
    public $name = 'JobFlags';
    public $components = array(
        'RequestHandler'
    );
    function add($job_id = null)
    {
        if (!empty($this->request->data)) {
            $this->JobFlag->create();
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $this->request->data['JobFlag']['user_id'] = $this->Auth->user('id');
            }
            $this->request->data['JobFlag']['job_id'] = $this->request->data['Job']['id'];
            $this->request->data['JobFlag']['ip_id'] = $this->JobFlag->toSaveIP();
            if ($this->JobFlag->save($this->request->data)) {
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Flag has been added') , 'default', null, 'success');
                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'User',
                        'action' => 'Flagged',
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
                        'category' => 'JobFlag',
                        'action' => 'Flagged',
                        'label' => $this->request->data['Job']['id'],
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $this->request->data['Job']['id'],
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                $job = $this->JobFlag->Job->find('first', array(
                    'conditions' => array(
                        'Job.id' => $this->request->data['Job']['id'],
                    ) ,
                    'fields' => array(
                        'Job.slug',
                    ) ,
                    'recursive' => -1
                ));
                if ($this->RequestHandler->isAjax()) {
                    echo "success";
                    exit;
                } else {
                    $this->redirect(array(
                        'controller' => 'jobs',
                        'action' => 'view',
                        $job['Job']['slug'],
                        'admin' => false
                    ));
                }
            } else {
                $this->request->data = $this->JobFlag->Job->find('first', array(
                    'conditions' => array(
                        'Job.id' => $this->request->data['Job']['id'],
                    ) ,
                    'recursive' => 1
                ));
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Flag could not be added. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->JobFlag->Job->find('first', array(
                'conditions' => array(
                    'Job.id' => $job_id,
                ) ,
                'recursive' => 1
            ));
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $jobFlagCategories = $this->JobFlag->JobFlagCategory->find('list', array(
            'conditions' => array(
                'JobFlagCategory.is_active' => 1
            )
        ));
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $users = $this->JobFlag->User->find('list');
            $this->set(compact('users'));
        }
        $this->set(compact('jobFlagCategories'));
    }
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Flags');
        $conditions = array();
        if (!empty($this->request->params['named']['job_flag_category_id '])) {
            $jobFlagCategory = $this->{$this->modelClass}->JobFlagCategory->find('first', array(
                'conditions' => array(
                    'JobFlagCategory.id' => $this->request->params['named']['job_flag_category_id ']
                ) ,
                'fields' => array(
                    'JobFlagCategory.id',
                    'JobFlagCategory.name'
                ) ,
                'recursive' => -1
            ));
            if (empty($jobFlagCategory)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['JobFlagCategory.id'] = $jobFlagCategory['JobFlagCategory']['id'];
            $this->pageTitle.= sprintf(__l(' - Category - %s') , $jobFlagCategory['JobFlagCategory']['name']);
        }
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
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Job']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['JobFlag.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - Added today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['JobFlag.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Added in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['JobFlag.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Added in this month');
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['JobFlag']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->data['Job']['filter_id'])) {
            if ($this->request->data['Job']['filter_id'] == ConstMoreAction::UserFlagged) {
                $conditions['Job.job_flag_count'] != 0;
                $conditions['Job.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - User Flagged ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Job']['filter_id'];
        }
        $this->JobFlag->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username'
                    )
                ) ,
                'JobFlagCategory' => array(
                    'fields' => array(
                        'JobFlagCategory.name'
                    )
                ) ,
                'Job' => array(
                    'fields' => array(
                        'Job.title',
                        'Job.slug',
                        'Job.id',
                    ) ,
                    'Attachment' => array(
                        'fields' => array(
                            'Attachment.id',
                            'Attachment.filename',
                            'Attachment.dir',
                            'Attachment.width',
                            'Attachment.height',
                        )
                    )
                ) ,
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
                )
            ) ,
            'order' => array(
                'JobFlag.id' => 'desc'
            )
        );
        if (isset($this->request->data['JobFlag']['q'])) {
            $this->paginate['search'] = $this->request->data['JobFlag']['q'];
        }
        $this->set('jobFlags', $this->paginate());
        $moreActions = $this->JobFlag->moreActions;
        $this->set(compact('moreActions'));
        $this->set('page_title', $this->pageTitle);
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->JobFlag->delete($id)) {
            $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Flag has been cleared') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>