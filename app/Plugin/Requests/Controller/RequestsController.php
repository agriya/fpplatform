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
class RequestsController extends AppController
{
    public $name = 'Requests';
    public $uses = array(
        'Requests.Request',
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Request.continue',
            'Request.name',
            'Request.post',
            'Request.type_activate',
            'Request.type_suspend',
            'Request.type_delete',
            'Request.latitude',
            'Request.longitude',
            'Request.zoom_level',
            'Request.r'
        );
        parent::beforeFilter();
    }
    function index()
    {
        $this->pageTitle = requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps);
        $view = '';
        $request_id = array();
        if (!empty($this->request->params['named']['view'])) {
            $view = $this->request->params['named']['view'];
        }
        $this->_redirectGET2Named(array(
            'q',
        ));
        $this->Request->recursive = 0;
        $order = array();
        $limit = 20;
        $conditions['Request.is_approved'] = '1';
        $conditions['Request.is_active'] = '1';
        $conditions['Request.admin_suspend'] = '0';
        if (!empty($this->request->params['named']['filter'])) {
            $this->pageTitle.= ' - ' . $this->request->params['named']['filter'];
            if ($this->request->params['named']['filter'] == 'recent') {
                $order['Request.id'] = 'desc';
            } elseif ($this->request->params['named']['filter'] == 'popular') {
                $order['Request.request_view_count'] = 'desc';
            }
        }
        if (!empty($this->request->params['named']['user_id'])) {
            $conditions['Request.user_id'] = $this->request->params['named']['user_id'];
        }
        if (!empty($this->request->params['named']['view_request_id'])) {
            $conditions['Request.id !='] = $this->request->params['named']['view_request_id'];
        }
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'manage_requests')) {
            if (!$this->Auth->user('id')) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $user = $this->Request->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->Auth->user('username')
                ) ,
                'fields' => array(
                    'User.id',
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (!empty($user)) {
                $conditions['Request.user_id'] = $user['User']['id'];
                unset($conditions['Request.is_approved']);
                unset($conditions['Request.is_active']);
                unset($conditions['Request.admin_suspend']);
                $this->pageTitle = __l('My') . ' ' . requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps);
            }
        } elseif (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'favorite') && isPluginEnabled('RequestFavorites')) {
            $this->pageTitle = requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('I Like');
            $requests_favorites = $this->Request->RequestFavorite->find('all', array(
                'conditions' => array(
                    'RequestFavorite.user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'RequestFavorite.id',
                    'RequestFavorite.user_id',
                    'RequestFavorite.request_id',
                ) ,
                'recursive' => -1
            ));
            foreach($requests_favorites as $requests_favorite) {
                $request_id[] = $requests_favorite['RequestFavorite']['request_id'];
            }
            $conditions['Request.id'] = $request_id;
        } elseif (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type']) == 'request') {
            $user_requests = $this->Request->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['username']
                ) ,
                'recursive' => -1
            ));
            $conditions['Request.user_id'] = $user_requests['User']['id'];
            $this->set('user_requests', $user_requests);
        }
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'search')) {
            $limit = 5;
        }
        if (!empty($this->request->params['named']['amount'])) {
            $this->pageTitle.= ' - ' . $this->Request->siteCurrencyFormat($this->request->params['named']['amount']);
            $conditions['Request.amount'] = $this->request->params['named']['amount'];
        }
        if (!empty($this->request->params['named']['category'])) {
            $this->pageTitle = requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps) . ' - ' . __l('Category') . ' - ' . $this->request->params['named']['category'];
            $Category = $this->Request->JobCategory->findBySlug($this->request->params['named']['category']);
            $conditions['Request.job_category_id'] = $Category['JobCategory']['id'];
        }
        if (!empty($this->request->params['named']['job_type_id'])) {
            $title = requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps) . ' - ' . __l('Type') . ' - ';
            $title.= ($this->request->params['named']['job_type_id'] == ConstJobType::Online) ? __l('Online') : __l('Offline');
            $this->pageTitle = $title;
            $conditions['Request.job_type_id'] = $this->request->params['named']['job_type_id'];
        }
        if (!empty($this->request->params['form']['sw_latitude']) || !empty($this->request->params['named']['sw_latitude'])) {
            $limit = 5;
            $lon1 = (!empty($this->request->params['named']['sw_longitude']) ? $this->request->params['named']['sw_longitude'] : $this->request->params['form']['sw_longitude']);
            $lon2 = (!empty($this->request->params['named']['ne_longitude']) ? $this->request->params['named']['ne_longitude'] : $this->request->params['form']['ne_longitude']);
            $lat1 = (!empty($this->request->params['named']['sw_latitude']) ? $this->request->params['named']['sw_latitude'] : $this->request->params['form']['sw_latitude']);
            $lat2 = (!empty($this->request->params['named']['ne_latitude']) ? $this->request->params['named']['ne_latitude'] : $this->request->params['form']['ne_latitude']);
            $conditions['Request.latitude BETWEEN ? AND ?'] = array(
                $lat1,
                $lat2
            );
            $conditions['Request.longitude BETWEEN ? AND ?'] = array(
                $lon1,
                $lon2
            );
            $conditions[] = 'Request.latitude IS NOT NULL';
            $conditions[] = 'Request.longitude IS NOT NULL';
            if (isset($this->request->params['form']['q']) && !empty($this->request->params['form']['q'])) {
                $this->request->data['Request']['q'] = $this->request->params['form']['q'];
                $this->request->params['named']['q'] = $this->request->data['Job']['q'];
            }
            // setting values for paginations
            $this->request->params['named']['sw_longitude'] = $lon1;
            $this->request->params['named']['ne_longitude'] = $lon2;
            $this->request->params['named']['sw_latitude'] = $lat1;
            $this->request->params['named']['ne_latitude'] = $lat2;
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions['LOWER(Request.name) LIKE'] = '%' . strtolower($this->request->params['named']['q']) . '%';
            $this->request->data['Request']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $order['Request.id'] = 'desc';
        if ($view == 'json') {
            $this->paginate = array(
                'conditions' => $conditions,
                'fields' => array(
                    'Request.latitude',
                    'Request.longitude',
                    'Request.slug',
                    'Request.name',
                    'Request.amount'
                ) ,
                'order' => array(
                    'Request.id' => 'desc'
                ) ,
                'limit' => 20
            );
        } else {
            $contains = array();
            $contains = array(
                'User' => array(
                    'UserAvatar',
                ) ,
            );
            if (isPluginEnabled('Jobs')) {
                $contains['JobType'] = array(
                    'fields' => array(
                        'JobType.name',
                        'JobType.id',
                    )
                );
            }
            if (isPluginEnabled('Jobs')) {
                $contains['JobCategory'] = array(
                    'fields' => array(
                        'JobCategory.name',
                        'JobCategory.slug',
                    )
                );
            }
            if (isPluginEnabled('RequestFavorites')) {
                $contains['RequestFavorite'] = array(
                    'conditions' => array(
                        'RequestFavorite.user_id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'RequestFavorite.id',
                        'RequestFavorite.user_id',
                        'RequestFavorite.request_id',
                    )
                );
            }
            $this->paginate = array(
                'conditions' => $conditions,
                'contain' => $contains,
                'order' => $order,
                'limit' => $limit
            );
        }
        $requests = $this->paginate();
        if ($view != 'json') {
            $this->set('requests', $requests);
        } else {
            $this->view = 'Json';
            if (!empty($requests)) {
                $request_count = count($requests);
                for ($r = 0; $r < $request_count; $r++) {
                    $requests[$r]['Request']['display_amount'] = Configure::read('site.currency') . $requests[$r]['Request']['amount'];
                }
            }
            $this->set('json', $requests);
        }
        $this->set('requests', $requests);
        $amounts = explode(',', Configure::read('job.price'));
        $amounts = array_combine($amounts, $amounts);
        if (isPluginEnabled('Jobs')) {
            App::import('Model', 'Jobs.JobType');
            $this->JobType = new JobType();
            $jobTypes = $this->JobType->find('list', array(
                'recursive' => -1
            ));
            $this->set(compact('amounts', 'jobTypes'));
        }
        if (!empty($this->request->params['named']['type'])) {
            if (($this->request->params['named']['type'] == 'favorite') && (isPluginEnabled('RequestFavorites'))) {
                if (!empty($this->request->params['named']['username'])) {
                    $user_fav = $this->Request->User->find('first', array(
                        'conditions' => array(
                            'User.username' => $this->request->params['named']['username']
                        ) ,
                        'recursive' => -1
                    ));
                    $user_id = $user_fav['User']['id'];
                }
                if (empty($user_id)) {
                    $user_id = $this->Auth->user('id');
                }
                $request_user = $this->Request->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $user_id
                    ) ,
                    'recursive' => -1
                ));
                $this->set('request_user', $request_user);
            }
        }
        if (isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'manage_requests') && isset($this->request->params['named']['view']) && ($this->request->params['named']['view']) == 'grid') {
            $this->render('manage_requests_grid');
        } elseif (isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'manage_requests')) {
            $this->render('manage_requests');
        } elseif (isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'request')) {
            $this->render('user_requests');
        } elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'search' && !(isset($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'json')) {
            $this->render('request-index');
        } elseif (isset($this->request->params['named']['view_type']) && ($this->request->params['named']['view_type'] == 'simple_index')) {
            $this->render('simple_index');
        }
    }
    function add()
    {
        $this->pageTitle = __l('Create a New') . ' ' . requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps);
        if (!empty($this->request->data)) {
            $this->request->data['Request']['user_id'] = $this->Auth->user('id');
            $this->Request->create();
            //Check whether admin approved or not
            if (Configure::read('request.is_admin_request_auto_approval') == 1) {
                $this->request->data['Request']['is_approved'] = 1;
            } else {
                $this->request->data['Request']['is_approved'] = 0;
            }
            if ((!empty($this->request->data['Request']['job_type_id']) && $this->request->data['Request']['job_type_id'] == ConstJobType::Online) || empty($this->request->data['Request']['job_type_id'])) {
                unset($this->Request->validate['address']);
            }
            $this->request->data['Request']['user_id'] = $this->Auth->user('id');
            $this->Request->set($this->request->data);
            if (empty($this->request->data['Request']['post']) && $this->Request->validates()) {
                $conditions = array();
                $conditions['Job.job_type_id'] = $this->request->data['Request']['job_type_id'];
                //$conditions['Job.job_category_id'] = $this->request->data['Request']['job_category_id'];
                $job_count = $this->Request->Job->find('count', array(
                    'conditions' => array(
                        'Job.job_type_id' => $this->request->data['Request']['job_type_id'],
                        'Job.job_category_id' => $this->request->data['Request']['job_category_id']
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($job_count)) {
                    $request_filter = '1';
                    $this->set('request_filters', $request_filter);
                }
            }
            if (empty($request_filter)) {
                /* if ((!empty($this->request->data['Request']['job_type_id']) && $this->request->data['Request']['job_type_id'] == ConstJobType::Online) || empty($this->request->data['Request']['job_type_id'])) {
                unset($this->Request->validate['address']);
                }*/
                if ($this->Request->save($this->request->data)) {
                    $_user_data = array();
                    $_user_data['User']['id'] = $this->Auth->user('id');
                    $_user_data['User']['is_idle'] = 0;
                    $_user_data['User']['is_job_requested'] = 1;
                    $this->User->save($_user_data);
                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                        '_trackEvent' => array(
                            'category' => 'User',
                            'action' => 'RequestPosted',
                            'label' => $this->Auth->user('username') ,
                            'value' => $this->Auth->user('id') ,
                        ) ,
                        '_setCustomVar' => array(
                            'ud' => $this->Auth->user('id') ,
                            'rud' => $this->Auth->user('referred_by_user_id') ,
                        )
                    ));
                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                        '_trackEvent' => array(
                            'category' => 'Request',
                            'action' => 'Posted',
                            'label' => $this->request->data['Request']['name'],
                            'value' => $this->Request->getLastInsertId() ,
                        ) ,
                        '_setCustomVar' => array(
                            'ud' => $this->Auth->user('id') ,
                            'rud' => $this->Auth->user('referred_by_user_id') ,
                        )
                    ));
                    if (Configure::read('request.is_admin_request_auto_approval') == 1) {
                        $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . __l(' has been added.') , 'default', null, 'success');
                        if (isPluginEnabled('SocialMarketing')) {
                            $this->redirect(array(
                                'controller' => 'social_marketings',
                                'action' => 'publish',
                                'type' => 'facebook',
                                $this->Request->getLastInsertId() ,
                                'publish_action' => 'add',
                                'publish_name' => 'Request',
                                'admin' => false,
                                'request' => true
                            ));
                        }
                    } elseif (Configure::read('request.is_admin_request_auto_approval') == 0) {
                        $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . __l(' has been added and waiting for admin approval.') , 'default', null, 'success');
                    }
					$request = $this->Request->find('first', array(
						'conditions' => array(
							'Request.id = ' => $this->Request->getLastInsertId()
						) ,
						'recursive' => -1,
					));
					$this->redirect(array(
						'controller' => 'requests',
						'action' => 'view',
						$request['Request']['slug']
					));
                } else {
                    $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . __l(' couldn\'t be added. Try again!') , 'default', null, 'error');
                }
            }
        }
        unset($this->Request->validate['address']);
        if (isPluginEnabled('Jobs')) {
            $jobCategories = $this->Request->JobCategory->find('list', array(
                'conditions' => array(
                    'JobCategory.is_active' => 1
                ) ,
                'recursive' => -1
            ));
            $jobTypeConditions['JobType.is_active'] = 1;
            $jobType_ids = array();
            if (Configure::read('job.is_enable_online')) {
                $jobType_ids[] = ConstJobType::Online;
            }
            if (Configure::read('job.is_enable_offline')) {
                $jobType_ids[] = ConstJobType::Offline;
            }
            $jobTypeConditions['JobType.id'] = $jobType_ids;
            $job_types = $this->Request->JobType->find('list', array(
                'conditions' => $jobTypeConditions,
                'recursive' => -1
            ));
            if (count($job_types) < 2) {
                $this->request->data['Request']['job_type_id'] = array_pop(array_keys($job_types));
            }
            $this->set(compact('jobCategories', 'job_types'));
            $this->set('job_types', $job_types);
            $jobCategoriesClass = $this->Request->JobCategory->find('all', array(
                'conditions' => array(
                    'JobCategory.is_active' => 1
                ) ,
                'fields' => array(
                    'JobCategory.id',
                    'JobCategory.name',
                    'JobCategory.job_type_id',
                ) ,
                'recursive' => -1
            ));
            $this->set('jobCategoriesClass', $jobCategoriesClass);
        }
        if (empty($this->request->data)) {
            $userProfile = $this->Request->User->UserProfile->find('first', array(
                'conditions' => array(
                    'UserProfile.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
        }
        if (!empty($userProfile['UserProfile']['contact_address'])) {
            $this->request->data['Request']['address'] = $userProfile['UserProfile']['contact_address'];
        }
    }
    function view($slug = null)
    {
        $this->pageTitle = requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps);
        if (is_null($slug)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contains = array();
        $contains = array(
            'User' => array(
                'UserAvatar',
            ) ,
            'JobType',
            'JobCategory'
        );
        if (isPluginEnabled('RequestFavorites')) {
            $contains['RequestFavorite'] = array(
                'conditions' => array(
                    'RequestFavorite.user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'RequestFavorite.id',
                    'RequestFavorite.user_id',
                    'RequestFavorite.request_id',
                )
            );
        }
        if (isPluginEnabled('RequestFlags')) {
            $contains['RequestFlag'] = array(
                'fields' => array(
                    'RequestFlag.id',
                    'RequestFlag.user_id',
                    'RequestFlag.message',
                    'RequestFlag.request_id'
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username'
                    )
                ) ,
            );
        }
        $request = $this->Request->find('first', array(
            'conditions' => array(
                'Request.slug = ' => $slug
            ) ,
            'contain' => $contains,
            'recursive' => 2,
        ));
        if (empty($request)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (($request['Request']['is_active'] == 0 || $request['Request']['admin_suspend'] == 1) && ($this->Auth->user('id') != $request['Request']['user_id']) && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (isPluginEnabled('SocialMarketing')) {
            $url = Cms::dispatchEvent('Controller.SocialMarketing.getShareUrl', $this, array(
                'data' => $request['Request']['id'],
                'publish_action' => 'add',
                'request' => true
            ));
            $this->set('share_url', $url->data['social_url']);
        }
        $this->pageTitle.= ' - ' . $request['Request']['name'];
        // Setting meta tag and descriptions //
        if (!empty($request['JobCategory']['name'])) {
            Configure::write('meta.keywords', Configure::read('meta.keywords') . ', ' . $request['JobCategory']['name']);
        }
        if (!empty($request['Request']['name'])) {
            Configure::write('meta.description', $request['Request']['name']);
        }
        Configure::write('meta.description', __l('I\'m looking for someone who will') . ' ' . $request['Request']['name']) . ' ' . __l('for') . $this->Request->siteCurrencyFormat($request['Request']['amount']);
        Configure::write('meta.page_url', Router::url(array(
            'controller' => 'requests',
            'action' => 'view',
            $request['Request']['slug']
        ) , true));
        $image_options = array(
            'dimension' => 'large_thumb',
            'class' => '',
            'alt' => $request['User']['username'],
            'title' => $request['User']['username'],
            'type' => 'png'
        );
        if (!empty($request['User']['UserAvatar'])) {
            $user_image = $this->getImageUrl('UserAvatar', $request['User']['UserAvatar'], $image_options);
            Configure::write('meta.image_url', $user_image);
        }
        $request_view = array();
        $this->Request->RequestView->create();
        $request_view['RequestView']['user_id'] = $this->Auth->user('id');
        $request_view['RequestView']['request_id'] = $request['Request']['id'];
        $request_view['RequestView']['ip_id'] = $this->Request->toSaveIP();
        $request_view['RequestView']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $this->Request->RequestView->save($request_view);
        $this->set('request', $request);
    }
    function v()
    {
        $this->pageTitle = requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps);
        if (is_null($this->request->params['named']['slug'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $slug = $this->request->params['named']['slug'];
        $request = $this->Request->find('first', array(
            'conditions' => array(
                'Request.slug' => $slug
            ) ,
            'recursive' => -1,
        ));
        if (empty($request)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $request['Request']['name'];
        $this->set('request', $request);
        $this->layout = 'ajax';
        $this->render('v_embed');
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit') . ' ' . requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps);
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $request = $this->Request->find('first', array(
            'conditions' => array(
                'Request.id = ' => $id,
            ) ,
            'recursive' => -1
        ));
        if ((is_null($id) || ($request['Request']['user_id'] != $this->Auth->user('id'))) && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ((!empty($this->request->data['Request']['job_type_id']) && $this->request->data['Request']['job_type_id'] == ConstJobType::Online) || empty($this->request->data['Request']['job_type_id'])) {
                unset($this->Request->validate['address']);
            }
            if (empty($this->request->data['Request']['address'])) {
                $this->request->data['Request']['latitude'] = '';
                $this->request->data['Request']['longitude'] = '';
                $this->request->data['Request']['zoom_level'] = '';
            }
            if ($this->Request->save($this->request->data)) {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . __l(' has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'requests',
                    'action' => 'manage'
                ));
            } else {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . __l(' could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Request->find('first', array(
                'conditions' => array(
                    'Request.id = ' => $id,
                ) ,
                'recursive' => -1
            ));
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if ($this->request->data['Request']['job_type_id'] == ConstJobType::Online) {
                unset($this->Request->validate['address']);
            }
        }
        $jobCategories = $this->Request->JobCategory->find('list', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        $this->pageTitle.= ' - ' . $this->request->data['Request']['name'];
        $users = $this->Request->User->find('list');
        $jobTypeConditions['JobType.is_active'] = 1;
        $jobType_ids = array();
        if (Configure::read('job.is_enable_online')) {
            $jobType_ids[] = ConstJobType::Online;
        }
        if (Configure::read('job.is_enable_offline')) {
            $jobType_ids[] = ConstJobType::Offline;
        }
        $jobTypeConditions['JobType.id'] = $jobType_ids;
        $job_types = $this->Request->JobType->find('list', array(
            'conditions' => $jobTypeConditions,
            'recursive' => -1
        ));
        if (count($job_types) < 2) {
            $this->request->data['Request']['job_type_id'] = array_pop(array_keys($job_types));
        }
        $this->set(compact('users', 'jobCategories', 'job_types'));
        $this->set('job_types', $job_types);
        $jobCategoriesClass = $this->Request->JobCategory->find('all', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'fields' => array(
                'JobCategory.id',
                'JobCategory.name',
                'JobCategory.job_type_id',
            ) ,
            'recursive' => -1
        ));
        $this->set('jobCategoriesClass', $jobCategoriesClass);
    }
    function update()
    {
        if (!empty($this->request->data)) {
            $request_id = array();
            $r = $this->request->data[$this->modelClass]['r'];
            $error = 0;
            $is_deleted = 0;
            foreach($this->request->data[$this->modelClass] as $id => $is_checked) {
                if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                    $request_id[] = $id;
                }
            }
            unset($this->request->data[$this->modelClass]['r']);
            if ((!empty($this->request->data[$this->modelClass]['type_suspend']) || !empty($this->request->data[$this->modelClass]['type_activate']) || !empty($this->request->data[$this->modelClass]['type_delete'])) && !empty($request_id)) {
                if (!empty($this->request->data[$this->modelClass]['type_suspend'])) {
                    foreach($request_id as $id) {
                        $saveRequest['id'] = $id;
                        $saveRequest['is_active'] = 0;
                        $this->Request->save($saveRequest);
                    }
                    $this->Session->setFlash(__l('Selected') . ' ' . requestAlternateName(ConstRequestAlternateName::Plural) . ' ' . __l('has been suspended') , 'default', null, 'success');
                } else if (!empty($this->request->data[$this->modelClass]['type_activate'])) {
                    foreach($this->request->data[$this->modelClass] as $request_id => $is_checked) {
                        if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                            $saveRequest['id'] = $request_id;
                            $saveRequest['is_active'] = 1;
                            $this->Request->save($saveRequest);
                        }
                    }
                    $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('has been activated') , 'default', null, 'success');
                } else if (!empty($this->request->data[$this->modelClass]['type_delete'])) {
                    foreach($this->request->data[$this->modelClass] as $request_id => $is_checked) {
                        if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                            $this->Request->delete($request_id);
                        }
                    }
                    $this->Session->setFlash(__l('Selected') . ' ' . requestAlternateName(ConstRequestAlternateName::Plural) . ' ' . __l('has been deleted.') , 'default', null, 'success');
                }
            }
            $this->redirect(Router::url('/', true) . $r);
        }
    }
    function admin_index()
    {
        $this->pageTitle = requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps);
        $conditions = array();
        $this->_redirectGET2Named(array(
            'q',
            'username',
            'job_category_id'
        ));
        $this->set('active_requests', $this->Request->find('count', array(
            'conditions' => array(
                'Request.is_active = ' => 1,
                'Request.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('suspended_requests', $this->Request->find('count', array(
            'conditions' => array(
                'Request.admin_suspend = ' => 1,
            ) ,
            'recursive' => -1
        )));
        $this->set('user_suspended_requests', $this->Request->find('count', array(
            'conditions' => array(
                'Request.is_active = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('system_flagged', $this->Request->find('count', array(
            'conditions' => array(
                'Request.is_system_flagged = ' => 1,
                'Request.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('total_requests', $this->Request->find('count', array(
            'conditions' => array(
                'Request.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('online_requests', $this->Request->find('count', array(
            'conditions' => array(
                'Request.job_type_id = ' => 1,
                'Request.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('offline_requests', $this->Request->find('count', array(
            'conditions' => array(
                'Request.job_type_id = ' => 2,
                'Request.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Request']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['Request']['filter_id'])) {
            if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Approved) {
                $conditions['Request.is_approved'] = 1;
                $this->pageTitle.= __l(' - Approved ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Disapproved) {
                $conditions['Request.is_approved'] = 0;
                $this->pageTitle.= __l(' - Disapproved ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Request.is_active'] = 1;
                $conditions['Request.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Request.is_active'] = 0;
                $this->pageTitle.= __l(' - User suspended ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Suspend) {
                $conditions['Request.admin_suspend'] = 1;
                $this->pageTitle.= __l(' - Suspended ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Flagged) {
                $conditions['Request.is_system_flagged'] = 1;
                $conditions['Request.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Flagged ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::UserFlagged) {
                $conditions['Request.request_flag_count !='] = 0;
                $conditions['Request.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - User Flagged ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Online) {
                $conditions['Request.job_type_id'] = ConstJobType::Online;
                $conditions['Request.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Online ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Offline) {
                $conditions['Request.job_type_id'] = ConstJobType::Offline;
                $conditions['Request.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Offline ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Request']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['Request.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['Request.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $$conditions['Request.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - in this month');
        }
        if (isset($this->request->params['named']['job_category_id'])) {
            $this->request->data['Request']['job_category_id'] = $this->request->params['named']['job_category_id'];
            $conditions['Request.job_category_id'] = $this->request->params['named']['job_category_id'];
        }
        if (isset($this->request->params['named']['job_type_id'])) {
            $title = ' - ' . requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . __l('Type') . ' - ';
            $title.= ($this->request->params['named']['job_type_id'] == ConstJobType::Online) ? __l('Online') : __l('Offline');
            $this->pageTitle.= $title;
            $this->request->data['Request']['job_type_id'] = $this->request->params['named']['job_type_id'];
            $conditions['Request.job_type_id'] = $this->request->params['named']['job_type_id'];
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
            $this->request->data['Request']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->set('page_title', $this->pageTitle);
        $this->Request->recursive = 2;
        $contains = array();
        $contains = array(
            'User' => array(
                'fields' => array(
                    'User.id',
                    'User.username',
                    'User.is_active'
                )
            ) ,
            'JobCategory' => array(
                'fields' => array(
                    'JobCategory.name',
                )
            ) ,
            'JobType' => array(
                'fields' => array(
                    'JobType.name',
                )
            )
        );
        if (isPluginEnabled('RequestFlags')) {
            $contains['RequestFlag'] = array(
                'fields' => array(
                    'RequestFlag.id',
                    'RequestFlag.user_id',
                    'RequestFlag.request_id'
                )
            );
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'Request.id',
                'Request.created',
                'Request.user_id',
                'Request.name',
                'Request.slug',
                'Request.amount',
                'Request.is_approved',
                'Request.job_count',
                'Request.request_view_count',
                'Request.request_flag_count',
                'Request.is_active',
                'Request.admin_suspend',
                'Request.detected_suspicious_words',
                'Request.is_system_flagged',
                'Request.request_favorite_count',
            ) ,
            'contain' => $contains,
            'order' => array(
                'Request.id' => 'desc'
            )
        );
        if (isset($this->request->data['Request']['q'])) {
            $this->paginate['search'] = $this->request->data['Request']['q'];
        }
        $moreActions = $this->Request->moreActions;
        $this->set(compact('moreActions'));
        $this->set('requests', $this->paginate());
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add') . ' ' . requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps);
        if (!empty($this->request->data)) {
            if ((!empty($this->request->data['Request']['job_type_id']) && $this->request->data['Request']['job_type_id'] == ConstJobType::Online) || empty($this->request->data['Request']['job_type_id'])) {
                unset($this->Request->validate['address']);
            }
            if ($this->Request->save($this->request->data)) {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'requests',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        unset($this->Request->validate['address']);
        $jobCategories = $this->Request->JobCategory->find('list', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        $job_types = $this->Request->JobType->find('list');
        $users = $this->Request->User->find('list');
        $this->set(compact('users', 'jobCategories', 'job_types'));
        $jobCategoriesClass = $this->Request->JobCategory->find('all', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'fields' => array(
                'JobCategory.id',
                'JobCategory.name',
                'JobCategory.job_type_id',
            ) ,
            'recursive' => -1
        ));
        $this->set('jobCategoriesClass', $jobCategoriesClass);
        $jobTypeConditions['JobType.is_active'] = 1;
        $jobType_ids = array();
        if (Configure::read('job.is_enable_online')) {
            $jobType_ids[] = ConstJobType::Online;
        }
        if (Configure::read('job.is_enable_offline')) {
            $jobType_ids[] = ConstJobType::Offline;
        }
        $jobTypeConditions['JobType.id'] = $jobType_ids;
        $job_types = $this->Request->JobType->find('list', array(
            'conditions' => $jobTypeConditions,
            'recursive' => -1
        ));
        if (count($job_types) < 2) {
            $this->request->data['Request']['job_type_id'] = array_pop(array_keys($job_types));
        }
        if (count($job_types) < 2) {
            $this->request->data['Request']['job_type_id'] = array_pop(array_keys($job_types));
        } else {
            $this->request->data['Request']['job_type_id'] = ConstJobType::Online;
        }
        $this->set('job_types', $job_types);
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit') . ' ' . requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps);
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->Request->save($this->request->data)) {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . __l(' has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'requests',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . __l(' could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Request->find('first', array(
                'conditions' => array(
                    'Request.id = ' => $id,
                ) ,
                'recursive' => -1
            ));
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if ($this->request->data['Request']['job_type_id'] == ConstJobType::Online) {
                unset($this->Request->validate['address']);
            }
        }
        $jobCategories = $this->Request->JobCategory->find('list', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        $job_types = $this->Request->JobType->find('list');
        $this->pageTitle.= ' - ' . $this->request->data['Request']['name'];
        $users = $this->Request->User->find('list');
        $this->set(compact('users', 'jobCategories', 'job_types'));
        $jobCategoriesClass = $this->Request->JobCategory->find('all', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'fields' => array(
                'JobCategory.id',
                'JobCategory.name',
                'JobCategory.job_type_id',
            ) ,
            'recursive' => -1
        ));
        $this->set('jobCategoriesClass', $jobCategoriesClass);
        $jobTypeConditions['JobType.is_active'] = 1;
        $jobType_ids = array();
        if (Configure::read('job.is_enable_online')) {
            $jobType_ids[] = ConstJobType::Online;
        }
        if (Configure::read('job.is_enable_offline')) {
            $jobType_ids[] = ConstJobType::Offline;
        }
        $jobTypeConditions['JobType.id'] = $jobType_ids;
        $job_types = $this->Request->JobType->find('list', array(
            'conditions' => $jobTypeConditions,
            'recursive' => -1
        ));
        if (count($job_types) < 2) {
            $this->request->data['Request']['job_type_id'] = array_pop(array_keys($job_types));
        }
        $this->set('job_types', $job_types);
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Request->delete($id)) {
            $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . __l(' deleted') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'requests',
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function show_admin_control_panel()
    {
        $this->disableCache();
        if (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'request') {
            $request = $this->Request->find('first', array(
                'conditions' => array(
                    'Request.id' => $this->request->params['named']['id']
                ) ,
                'recursive' => 0
            ));
            $this->set('request', $request);
        }
        $this->layout = 'ajax';
    }
    public function request_location()
    {
        $request = $this->Request->find('first', array(
            'conditions' => array(
                'Request.id' => $this->request->params['named']['request_id']
            ) ,
            'contain' => array(
                'User'
            ) ,
            'recursive' => 0,
        ));
        $this->set('request', $request);
    }
}
?>