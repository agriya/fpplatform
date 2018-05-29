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
class RequestFlagsController extends AppController
{
    public $name = 'RequestFlags';
    function add($request_id = null)
    {
        $this->pageTitle = __l('Add Request Flag');
        if (!empty($this->request->data)) {
            $this->RequestFlag->create();
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $this->request->data['RequestFlag']['user_id'] = $this->Auth->user('id');
            }
            $this->request->data['RequestFlag']['ip_id'] = $this->RequestFlag->toSaveIP();
            if ($this->RequestFlag->save($this->request->data)) {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('Flag has been added') , 'default', null, 'success');
                $request = $this->RequestFlag->Request->find('first', array(
                    'conditions' => array(
                        'Request.id' => $this->request->data['RequestFlag']['request_id'],
                    ) ,
                    'fields' => array(
						'Request.id',
                        'Request.slug',
                    ) ,
                    'recursive' => 0
                ));
                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'User',
                        'action' => 'RequestFlagged',
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
                        'category' => 'RequestFlag',
                        'action' => 'Flagged',
                        'label' => $request['Request']['id'],
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $request['Request']['id'],
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                if ($this->RequestHandler->isAjax()) {
                    echo "success";
                    exit;
                } else {
                    $this->redirect(array(
                        'controller' => 'requests',
                        'action' => 'view',
                        $request['Request']['slug'],
                        'admin' => false
                    ));
                }
            } else {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l(' Flag could not be added. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->RequestFlag->Request->find('first', array(
                'conditions' => array(
                    'Request.id' => $request_id,
                ) ,
                'recursive' => 1
            ));
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->request->data['RequestFlag']['request_id'] = $this->request->data['Request']['id'];
        }
        $requestFlagCategories = $this->RequestFlag->RequestFlagCategory->find('list', array(
            'conditions' => array(
                'RequestFlagCategory.is_active' => 1
            )
        ));
        $users = $this->RequestFlag->User->find('list');
        $requests = $this->RequestFlag->Request->find('list');
        $this->set(compact('users', 'requests', 'requestFlagCategories'));
    }
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('Flags');
        $conditions = array();
        if (!empty($this->request->params['named']['request_flag_category_id'])) {
            $requestFlagCategory = $this->{$this->modelClass}->RequestFlagCategory->find('first', array(
                'conditions' => array(
                    'RequestFlagCategory.id' => $this->request->params['named']['request_flag_category_id']
                ) ,
                'fields' => array(
                    'RequestFlagCategory.id',
                    'RequestFlagCategory.name'
                ) ,
                'recursive' => -1
            ));
            if (empty($requestFlagCategory)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['RequestFlagCategory.id'] = $requestFlagCategory['RequestFlagCategory']['id'];
            $this->pageTitle.= sprintf(__l(' - Category - %s') , $requestFlagCategory['RequestFlagCategory']['name']);
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
            $this->request->data['Request']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['RequestFlag.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - Added today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['RequestFlag.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Added in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['RequestFlag.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Added in this month');
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['RequestFlag']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->data['Request']['filter_id'])) {
            if ($this->request->data['Request']['filter_id'] == ConstMoreAction::UserFlagged) {
                $conditions['Request.request_flag_count'] != 0;
                $conditions['Request.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - User Flagged ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Request']['filter_id'];
        }
        if (!empty($this->request->params['named']['request']) || !empty($this->request->params['named']['request_id'])) {
            $requestConditions = !empty($this->request->params['named']['request']) ? array(
                'Request.slug' => $this->request->params['named']['request']
            ) : array(
                'Request.id' => $this->request->params['named']['request_id']
            );
            $request = $this->{$this->modelClass}->Request->find('first', array(
                'conditions' => $requestConditions,
                'fields' => array(
                    'Request.id',
                    'Request.name'
                ) ,
                'recursive' => -1
            ));
            if (empty($request)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Request.id'] = $this->request->data[$this->modelClass]['request_id'] = $request['Request']['id'];
            $this->pageTitle.= ' - ' . $request['Request']['name'];
        }
        $this->RequestFlag->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username'
                    )
                ) ,
                'RequestFlagCategory' => array(
                    'fields' => array(
                        'RequestFlagCategory.name'
                    )
                ) ,
                'Request' => array(
                    'fields' => array(
                        'Request.name',
                        'Request.slug',
                        'Request.id',
                    ) ,
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
                'RequestFlag.id' => 'desc'
            )
        );
        if (isset($this->request->data['RequestFlag']['q'])) {
            $this->paginate['search'] = $this->request->data['RequestFlag']['q'];
        }
        $this->set('requestFlags', $this->paginate());
        $moreActions = $this->RequestFlag->moreActions;
        $this->set(compact('moreActions'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RequestFlag->delete($id)) {
            $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('Flag has been cleared') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>