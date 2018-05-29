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
class JobsController extends AppController
{
    public $name = 'Jobs';
    public $components = array(
        'RequestHandler',
        'OauthConsumer',
        'Email'
    );
    public $helpers = array(
        'Gateway'
    );
    public $uses = array(
        'Jobs.Job'
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Attachment',
            'Attachment.file',
            'Job.type',
            'Job.type_activate',
            'Job.type_suspend',
            'Job.type_delete',
            'Job.request_id',
            'Job.latitude',
            'Job.longitude',
            'Job.zoom_level',
            'Job.job_service_location_id',
            'Job.job',
            'Job.r',
            'Job.job_coverage_radius_unit_id',
        );
        parent::beforeFilter();
    }
    /*
    This 'index' method is used in Homepage, Manage Jobs in user page,
    Other Jobs n related Jobs in Job view page,
    Recent Jobs for category n other categories
    User Jobs in user profile page
    Favorite Jobs
    Filters in homepage,
    Search
    */
    function index($type = null, $user_id = null, $job_id = null)
    {
        if (!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'add_form') {
            $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . __l(' has been added successfully.') , 'default', null, 'success');
        }
        $this->_redirectGET2Named(array(
            'q',
        ));
        if ((Configure::read('site.launch_mode') == 'Pre-launch' && $this->Auth->user('role_id') != ConstUserTypes::Admin) || (Configure::read('site.launch_mode') == 'Private Beta' && !$this->Auth->user('id'))) {
            if (!empty($this->request->params['ext']) && $this->request->params['ext'] == 'rss') {
                $this->redirect(array(
                    'controller' => 'jobs',
                    'action' => 'index',
                    'admin' => false
                ));
            }
            $this->layout = 'subscription';
            $this->pageTitle = Configure::read('site.launch_mode');
        } else {
            if ($this->request->url == '/') {
                $this->pageTitle = __l('Home');
            } elseif (!empty($this->request->params['url']['ext']) && ($this->request->params['url']['ext'] == 'rss')) {
                $this->pageTitle = Configure::read('site.name');
            } else {
                $this->pageTitle = jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps);
            }
            $this->Job->recursive = 0;
            $conditions = $conditions_fav = array();
            $limit = 8;
            $this->_redirectGET2Named(array(
                'q',
                'latitude',
                'longitude',
                'job_search',
                'sw_latitude',
                'sw_longitude',
                'ne_latitude',
                'ne_longitude',
            ));
            $view = '';
            if (!empty($this->request->params['named']['view'])) {
                $view = $this->request->params['named']['view'];
            }
            $conditions['Job.is_active'] = 1;
            $conditions['Job.is_approved'] = 1;
            $conditions['Job.admin_suspend'] = 0;
            $conditions['Job.is_deleted'] = '0';
            if (!empty($this->request->params['named']['type'])) {
                if ($this->request->params['named']['type'] == 'related_jobs') {
                    $conditions['Job.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
                } else if ($this->request->params['named']['type'] == 'manage_jobs') {
                    $this->pageTitle = __l('My') . ' ' . jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps);
                    $conditions['Job.user_id'] = $this->Auth->user('id');
                    unset($conditions['Job.is_approved']);
                    unset($conditions['Job.is_active']);
                    unset($conditions['Job.admin_suspend']);
                    if (!$this->Auth->user('id')) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                } else if ($this->request->params['named']['type'] == 'other') {
                    $get_user = $this->Job->User->find('first', array(
                        'conditions' => array(
                            'username' => $this->request->params['named']['user']
                        ) ,
                        'recursive' => -1
                    ));
                    $get_job = $this->Job->find('first', array(
                        'conditions' => array(
                            'slug' => $this->request->params['named']['job']
                        ) ,
                        'recursive' => -1
                    ));
                    $conditions['Job.user_id'] = $get_user['User']['id'];
                    $conditions['Job.id !='] = $get_job['Job']['id'];
                    $limit = 10;
                    $this->pageTitle = jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps);
                } else if ($this->request->params['named']['type'] == 'recent') {
                    $this->pageTitle = jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' - ' . __l('Category - ') . $this->request->params['named']['type'];
                    $order['Job.id'] = 'desc';
                } else if ($this->request->params['named']['type'] == 'related') {
                    $this->pageTitle = jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps);
                    $limit = '10';
                    $jobs = $this->Job->find('first', array(
                        'conditions' => array(
                            'Job.slug' => $this->request->params['named']['job']
                        ) ,
                        'fields' => array(
                            'Job.id',
                            'Job.job_category_id',
                        ) ,
                        'contain' => array(
                            'JobTag'
                        ) ,
                        'recursive' => 1,
                    ));
                    if (!empty($jobs['JobTag'])) {
                        foreach($jobs['JobTag'] as $job_tag) {
                            $job_tag_id[] = $job_tag['id'];
                        }
                        $jobs_job_tags = $this->Job->JobsJobTag->find('all', array(
                            'conditions' => array(
                                'JobsJobTag.job_tag_id' => $job_tag_id
                            ) ,
                            'recursive' => -1
                        ));
                        if (!empty($jobs_job_tags)) {
                            foreach($jobs_job_tags as $jobs_job_tag) {
                                if ($jobs_job_tag['JobsJobTag']['job_id'] != $jobs['Job']['id']) {
                                    $related_job_id[] = $jobs_job_tag['JobsJobTag']['job_id'];
                                }
                            }
                            if (!empty($related_job_id)) {
                                $conditions['Job.id'] = $related_job_id;
                            }
                        }
                    }
                } else if ($this->request->params['named']['type'] == 'user_jobs' || $this->request->params['named']['type'] == 'user_jobs_listing') {
                    $user_jobs = $this->Job->User->find('first', array(
                        'conditions' => array(
                            'User.username' => $this->request->params['named']['username']
                        ) ,
                        'recursive' => -1
                    ));
                    $conditions['Job.user_id'] = $user_jobs['User']['id'];
                    $conditions['Job.is_active'] = '1';
                    $conditions['Job.admin_suspend'] = '0';
                } else if (($this->request->params['named']['type'] == 'favorite') && (isPluginEnabled('JobFavorites'))) {
                    $this->pageTitle = jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('I Like');
                    if (!empty($this->request->params['named']['username'])) {
                        $user_fav = $this->Job->User->find('first', array(
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
                    $jobs_favorites = $this->Job->JobFavorite->find('all', array(
                        'conditions' => array(
                            'JobFavorite.user_id' => $user_id
                        ) ,
                        'fields' => array(
                            'JobFavorite.id',
                            'JobFavorite.user_id',
                            'JobFavorite.job_id',
                        ) ,
                        'recursive' => -1
                    ));
                    foreach($jobs_favorites as $jobs_favorite) {
                        $job_id[] = $jobs_favorite['JobFavorite']['job_id'];
                    }
                    $conditions['Job.id'] = $job_id;
                }
                if ($this->request->params['named']['type'] == 'search') {
                    $limit = 3;
                }
            } else if (!empty($this->request->params['named']['filter'])) {
                $this->pageTitle = jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' - ' . $this->request->params['named']['filter'];
                if ($this->request->params['named']['filter'] == 'featured') {
                    $conditions['Job.is_featured'] = '1';
                    $order['Job.is_featured'] = 'desc';
                } elseif ($this->request->params['named']['filter'] == 'recent') {
                    $order['Job.id'] = 'desc';
                } elseif ($this->request->params['named']['filter'] == 'popular') {
                    $order['Job.job_view_count'] = 'desc';
                } elseif ($this->request->params['named']['filter'] == 'highest-rated') {
                    $order['Job.actual_rating'] = 'desc';
                } elseif ($this->request->params['named']['filter'] == 'request-jobs' && !empty($this->request->params['named']['request_id'])) {
                    $job_list = $this->Job->JobsRequest->find('list', array(
                        'conditions' => array(
                            'JobsRequest.request_id' => $this->request->params['named']['request_id'],
                        ) ,
                        'fields' => array(
                            'JobsRequest.job_id',
                            'JobsRequest.job_id',
                        ) ,
                        'recursive' => -1
                    ));
                    $get_request = $this->Job->Request->find('first', array(
                        'conditions' => array(
                            'Request.id' => $this->request->params['named']['request_id'],
                        ) ,
                        'fields' => array(
                            'Request.user_id',
                            'Request.id',
                            'Request.slug',
                        ) ,
                        'recursive' => -1
                    ));
                    $conditions['Job.id'] = $job_list;
                    $request_choosen = $this->Job->JobOrder->find('list', array(
                        'conditions' => array(
                            'JobOrder.job_id' => $job_list,
                            'JobOrder.user_id' => $get_request['Request']['user_id']
                        ) ,
                        'fields' => array(
                            'JobOrder.job_id',
                            'JobOrder.job_id'
                        ) ,
                        'recursive' => -1
                    ));
                    $this->set('request_choosen', $request_choosen);
                } elseif ($this->request->params['named']['filter'] == 'request-related-jobs' && !empty($this->request->params['named']['request_id'])) {
                    $request = $this->Job->Request->find('first', array(
                        'conditions' => array(
                            'Request.id' => $this->request->params['named']['request_id'],
                        ) ,
                        'recursive' => -1
                    ));
                    $conditions['OR'] = array(
                        'Job.job_type_id' => $request['Request']['job_type_id'],
                        'Job.job_category_id' => $request['Request']['job_category_id']
                    );
                }
            }
            if (!empty($this->request->params['named']['amount'])) {
                $this->pageTitle = jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' - ' . $this->Job->siteCurrencyFormat($this->request->params['named']['amount']);
                $conditions['Job.amount'] = $this->request->params['named']['amount'];
            }
            if (!empty($this->request->params['named']['category'])) {
                $this->pageTitle = jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' - ' . __l('Category') . ' - ' . $this->request->params['named']['category'];
                $Category = $this->Job->JobCategory->find('first', array(
                    'conditions' => array(
                        'JobCategory.slug' => $this->request->params['named']['category']
                    ) ,
                    'fields' => array(
                        'JobCategory.id'
                    ) ,
                    'recursive' => -1
                ));
                $conditions['Job.job_category_id'] = $Category['JobCategory']['id'];
            }
            if (!empty($this->request->params['named']['job_type_id'])) {
                $title = jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' - ' . __l('Type') . ' - ';
                $title.= ($this->request->params['named']['job_type_id'] == ConstJobType::Online) ? __l('Online') : __l('Offline');
                $this->pageTitle = $title;
                $conditions['Job.job_type_id'] = $this->request->params['named']['job_type_id'];
            }
            if (!empty($this->request->params['named']['tag'])) {
                $this->pageTitle = jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' - ' . __l('Tag') . ' - ' . $this->request->params['named']['tag'];
                $Tags = $this->Job->JobTag->find('first', array(
                    'conditions' => array(
                        'JobTag.slug' => $this->request->params['named']['tag']
                    ) ,
                    'contain' => array(
                        'Job' => array(
                            'fields' => array(
                                'Job.id'
                            ) ,
                        ) ,
                    ) ,
                    'recursive' => 1
                ));
                foreach($Tags['Job'] as $tag) {
                    $tag_job_id[] = $tag['id'];
                }
                if (!empty($tag_job_id)) {
                    $conditions['Job.id'] = $tag_job_id;
                }
            }
            if (isset($this->request->params['named']['view'])) {
                $view = $this->request->params['named']['view'];
            }
            if (isset($this->request->params['named']['q'])) {
                $this->request->data['Job']['q'] = $this->request->params['named']['q'];
                $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
            }
            if ($this->Auth->user()) {
                $conditions_fav['JobFavorite.user_id'] = $this->Auth->user('id');
            }
            if (isset($this->request->params['named']['view'])) {
                $limit = 10;
            }
            if (!empty($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'request') {
                $limit = 5;
            }
            $contain = array(
                'User' => array(
                    'fields' => array(
                        'User.username'
                    ) ,
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
                'JobTag' => array(
                    'fields' => array(
                        'JobTag.name',
                        'JobTag.slug'
                    ) ,
                ) ,
                'JobOrder', // Todo: no need for listing; Not yet confirmed
                'JobType' => array(
                    'fields' => array(
                        'JobType.id',
                        'JobType.name',
                        'JobType.job_count',
                        'JobType.request_count',
                    ) ,
                ) ,
                'JobServiceLocation' => array(
                    'fields' => array(
                        'JobServiceLocation.id',
                        'JobServiceLocation.name',
                        'JobServiceLocation.description',
                        'JobServiceLocation.job_count',
                    ) ,
                ) ,
                'JobCategory' => array(
                    'fields' => array(
                        'JobCategory.id',
                        'JobCategory.created',
                        'JobCategory.modified',
                        'JobCategory.name',
                        'JobCategory.slug',
                        'JobCategory.is_active',
                        'JobCategory.job_count',
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
                ) ,
            );
            if (isPluginEnabled('JobFavorites')) {
                $contain['JobFavorite'] = array(
                    'conditions' => $conditions_fav,
                    'fields' => array(
                        'JobFavorite.id',
                        'JobFavorite.user_id',
                        'JobFavorite.job_id',
                    )
                );
            }
            if (!empty($this->request->params['named']['q'])) {
                $conditions[] = array(
                    'OR' => array(
                        array(
                            'LOWER(Job.title) LIKE ' => '%' . strtolower($this->request->params['named']['q']) . '%'
                        ) ,
                        array(
                            'LOWER(User.username) LIKE ' => '%' . strtolower($this->request->params['named']['q']) . '%'
                        ) ,
                        array(
                            'LOWER(Job.description) LIKE ' => '%' . strtolower($this->request->params['named']['q']) . '%'
                        )
                    )
                );
            }
            $order['Job.is_featured'] = 'desc';
            $order['Job.id'] = 'desc';
            if ($view == 'json') {
                $this->paginate = array(
                    'conditions' => $conditions,
                    'fields' => array(
                        'Job.latitude',
                        'Job.longitude',
                        'Job.slug',
                        'Job.title'
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
                            'limit' => 1,
                            'order' => array(
                                'Attachment.id' => 'asc'
                            )
                        )
                    ) ,
                    'recursive' => 2,
                    'order' => $order,
                );
            } else {
                $this->paginate = array(
                    'conditions' => $conditions,
                    'fields' => array(
                        'Job.id',
                        'Job.title',
                        'Job.created',
                        'Job.slug',
                        'Job.job_category_id',
                        'Job.user_id',
                        'Job.is_system_flagged',
                        'Job.description',
                        'Job.no_of_days',
                        'Job.job_view_count',
                        'Job.job_feedback_count',
                        'Job.job_favorite_count',
                        'Job.job_tag_count',
                        'Job.is_active',
                        'Job.is_approved',
                        'Job.amount',
                        'Job.is_featured',
                        'Job.positive_feedback_count',
                        'Job.admin_suspend',
                        'Job.job_type_id',
                        'Job.job_service_location_id',
                        'Job.active_sale_count',
                        'Job.complete_sale_count',
                        'Job.youtube_url',
                        'Job.flickr_url',
                        'Job.is_instruction_requires_attachment',
                        'Job.is_instruction_requires_input',
                        'Job.revenue',
                    ) ,
                    'contain' => $contain,
                    'recursive' => 2,
                    'order' => $order,
                    'limit' => $limit
                );
                if (isset($this->request->data['Job']['q'])) {
                    $conditions['Job.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
                }
            }
            $jobs = $this->paginate();
            if (!empty($this->request->params['ext']) && $this->request->params['ext'] == 'rss') {
                $this->set('conditions', $conditions);
                $this->set('contain', $contain);
                $this->set('order', $order);
                $this->set('job', $this);
            }
            if ($view != 'json') {
                $this->set('jobs', $jobs);
            }
            if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'search' && !(isset($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'json')) {
                $this->render('search-index');
            }
            if (isset($this->request->params['named']['filter']) && ($this->request->params['named']['filter'] == 'request-jobs' || ($this->request->params['named']['filter'] == 'request-related-jobs')) && empty($this->request->params['named']['view_type'])) {
                $this->render('request-index');
            }
            if (isset($this->request->params['named']['job_category_id']) && isset($this->request->params['named']['job_type_id']) && $this->request->params['named']['view'] == 'request' && empty($this->request->params['named']['view_type'])) {
                if (isset($this->request->params['named']['isajax'])) {
                    $this->set('isajax', $this->request->params['named']['isajax']);
                }
                $this->render('index_request');
            }
            if (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'expanded') {
                $this->render('index_request_expaned');
            }
            if (!empty($this->request->params['named']['type'])) {
                if ($this->request->params['named']['type'] == 'related_jobs') {
                    $this->render('related_jobs');
                }
                if ($this->request->params['named']['type'] == 'manage_jobs' && isset($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'grid') {
                    $this->render('manage_jobs_grid');
                } else if ($this->request->params['named']['type'] == 'manage_jobs') {
                    $this->render('manage_jobs');
                } else if ($this->request->params['named']['type'] == 'other') {
                    $this->set('other_job_user', $get_user);
                    $this->render('simple-index');
                } else if ($this->request->params['named']['type'] == 'related') {
                    if (!empty($related_job_id)) {
                        $this->set('related_job_id', $related_job_id);
                    }
                    $this->render('simple-index');
                } else if ($this->request->params['named']['type'] == 'user_jobs') {
                    $job_user = $this->Job->User->find('first', array(
                        'conditions' => array(
                            'User.username' => $this->request->params['named']['username']
                        ) ,
                        'recursive' => -1
                    ));
                    if ($this->Auth->user('id')) {
                        $user = $this->Job->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->Auth->user('id')
                            ) ,
                            'recursive' => -1
                        ));
                        $this->set('user_purchase_avail_amount', $user['User']['available_purchase_amount']);
                    }
                    $this->set('job_user', $job_user);
                    $this->render('simple-index');
                } else if ($this->request->params['named']['type'] == 'user_jobs_listing') {
                    $this->render('my_jobs_listing');
                } else if ($this->request->params['named']['type'] == 'favorite') {
                    if (!empty($this->request->params['named']['username'])) {
                        $user_fav = $this->Job->User->find('first', array(
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
                    $job_user = $this->Job->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $user_id
                        ) ,
                        'recursive' => -1
                    ));
                    $this->set('job_user', $job_user);
                    $this->render('simple-index');
                }
            }
            if ($view == 'json') {
                if (!empty($jobs)) {
                    $job_count = count($jobs);
                    for ($r = 0; $r < $job_count; $r++) {
                        $image_options = array(
                            'dimension' => 'medium_thumb',
                            'class' => '',
                            'alt' => $jobs[$r]['Job']['title'],
                            'title' => $jobs[$r]['Job']['title'],
                            'type' => 'png'
                        );
                        $job_image = $this->Job->getImageUrl('Job', $jobs[$r]['Attachment']['0'], $image_options);
                        $jobs[$r]['Job']['medium_thumb'] = $job_image;
                    }
                }
                $this->view = 'Json';
                $this->set('json', $jobs);
            }
            App::import('Model', 'Jobs.JobType');
            $this->JobType = new JobType();
            $jobTypes = $this->JobType->find('list', array(
                'conditions' => array(
                    'JobType.is_active' => 1
                ) ,
                'recursive' => -1
            ));
            $this->set(compact('jobTypes'));
            $amounts = explode(',', Configure::read('job.price'));
            $amounts = array_combine($amounts, $amounts);
            $this->set('amounts', $amounts);
        }
    }
    function view($slug = null, $view = null)
    {
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps);
        if (is_null($slug)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions = array();
        $contain = array();
        if ($this->Auth->user() && isPluginEnabled('JobFavorites')) {
            $conditions['JobFavorite.user_id'] = $this->Auth->user('id');
        }
        if (!empty($this->request->params['named']['order_id'])) {
            $order = $this->Job->JobOrder->find('first', array(
                'conditions' => array(
                    'JobOrder.id' => $this->request->params['named']['order_id']
                ) ,
                'fields' => array(
                    'JobOrder.id',
                    'JobOrder.user_id',
                    'User.id',
                    'User.username'
                ) ,
                'contain' => array(
                    'User'
                ) ,
                'recursive' => 0
            ));
            $this->set('order', $order);
        }
        $main_conditions['Job.slug'] = $slug;
        if (!$this->Auth->user('id') || $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            $main_conditions['Job.is_deleted'] = 0;
        }
        $contain = array(
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
            'JobOrder' => array(
                'fields' => array(
                    'JobOrder.id',
                )
            ) ,
            'JobCategory' => array(
                'fields' => array(
                    'JobCategory.id',
                    'JobCategory.created',
                    'JobCategory.modified',
                    'JobCategory.name',
                    'JobCategory.slug',
                    'JobCategory.is_active',
                    'JobCategory.job_count',
                )
            ) ,
            'Attachment' => array(
                'fields' => array(
                    'Attachment.id',
                    'Attachment.filename',
                    'Attachment.dir',
                    'Attachment.width',
                    'Attachment.height'
                ) ,
            ) ,
            'JobServiceLocation',
            'JobTag' => array(
                'fields' => array(
                    'JobTag.name',
                    'JobTag.slug'
                )
            ) ,
            'JobType' => array(
                'fields' => array(
                    'JobType.name',
                    'JobType.id'
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
            ) ,
        );
        if (isPluginEnabled('JobFavorites')) {
            $contain['JobFavorite'] = array(
                'conditions' => $conditions,
                'fields' => array(
                    'JobFavorite.id',
                    'JobFavorite.user_id',
                    'JobFavorite.job_id',
                )
            );
        }
        if (isPluginEnabled('JobFlags')) {
            $contain['JobFlag'] = array(
                'fields' => array(
                    'JobFlag.id',
                    'JobFlag.user_id',
                    'JobFlag.message',
                    'JobFlag.job_id'
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username'
                    )
                )
            );
        }
        $job = $this->Job->find('first', array(
            'conditions' => $main_conditions,
            'contain' => $contain,
            'recursive' => 2
        ));
        if (empty($job['Job']['is_approved']) && $this->Auth->user('id') != $job['Job']['user_id'] && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        // Getting tags for setting in metatags below.
        $job_tags = array();
        if (!empty($job['JobTag'])) {
            foreach($job['JobTag'] as $job_tag) {
                $job_tags[] = $job_tag['name'];
            }
            if (!empty($job_tags)) {
                $job_tags = implode(', ', $job_tags);
            }
        }
        if (empty($job)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (($job['Job']['is_active'] == 0 || $job['Job']['admin_suspend'] == 1) && ($this->Auth->user('id') != $job['Job']['user_id']) && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        Configure::write('meta.title', $job['User']['username'] . ' ' . __l('will') . ' ' . $job['Job']['title'] . ' ' . __l('for') . ' ' . $this->Job->siteCurrencyFormat($job['Job']['amount']));
        Configure::write('meta.description', $job['Job']['description']);
        Configure::write('meta.page_url', Router::url(array(
            'controller' => 'jobs',
            'action' => 'view',
            $job['Job']['slug']
        ) , true));
        if (!empty($job['Attachment']['0'])) {
            $image_options = array(
                'dimension' => 'large_thumb',
                'class' => '',
                'alt' => $job['User']['username'] . ' ' . __l('will') . ' ' . $job['Job']['title'] . ' ' . __l('for') . ' ' . $this->Job->siteCurrencyFormat($job['Job']['amount']) ,
                'title' => $job['User']['username'] . ' ' . __l('will') . ' ' . $job['Job']['title'] . ' ' . __l('for') . ' ' . $this->Job->siteCurrencyFormat($job['Job']['amount']) ,
                'type' => 'png'
            );
            $job_image = $this->Job->getImageUrl('Job', $job['Attachment']['0'], $image_options);
            Configure::write('meta.image_url', $job_image);
        }
        if ($this->Auth->user('id')) {
            $user = $this->Job->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            $this->set('user_purchase_avail_amount', $user['User']['available_purchase_amount']);
        }
        // Setting meta tag and descriptions //
        if (!empty($job_tags)) {
            Configure::write('meta.keywords', Configure::read('meta.keywords') . ', ' . $job_tags . ', ' . $job['JobCategory']['name']);
        }
        if (!empty($job['Job']['description'])) {
            Configure::write('meta.description', $job['Job']['description']);
        }
        $job_view = array();
        $this->Job->JobView->create();
        $job_view['JobView']['user_id'] = $this->Auth->user('id');
        $job_view['JobView']['job_id'] = $job['Job']['id'];
        $job_view['JobView']['ip_id'] = $this->Job->toSaveIP();
        $this->Job->JobView->save($job_view);
        $this->pageTitle.= ' - ' . $job['Job']['title'];
        $this->set('job', $job);
        if (isPluginEnabled('SocialMarketing')) {
            $url = Cms::dispatchEvent('Controller.SocialMarketing.getShareUrl', $this, array(
                'data' => $job['Job']['id'],
                'publish_action' => 'add',
            ));
            $this->set('share_url', $url->data['social_url']);
        }
        if (!empty($view)) {
            $this->render('simple-view');
        }
    }
    function v()
    {
        $this->pageTitle = __l('Job');
        if (is_null($this->request->params['named']['slug'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions = array();
        $contain = array();
        $conditions['Job.slug'] = $this->request->params['named']['slug'];
        if (!$this->Auth->user()) {
            $conditions['Job.admin_suspend'] = 0;
        }
        $contain = array(
            'Attachment' => array(
                'fields' => array(
                    'Attachment.id',
                    'Attachment.filename',
                    'Attachment.dir',
                    'Attachment.width',
                    'Attachment.height'
                ) ,
            ) ,
        );
        $job = $this->Job->find('first', array(
            'conditions' => $conditions,
            'contain' => $contain,
            'recursive' => 2,
        ));
        if (empty($job)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $jobtags = array();
        if (!empty($job['JobTag'])) {
            foreach($job['JobTag'] as $job_tag) {
                $jobtags[] = $job_tag['name'];
            }
            if (!empty($jobtags)) {
                $jobtags = implode(', ', $jobtags);
            }
        }
        // Setting meta tag and descriptions //
        if (!empty($jobtags)) {
            Configure::write('meta.keywords', Configure::read('meta.keywords') . ', ' . $jobtags);
        }
        if (!empty($job['Job']['description'])) {
            $short_desc = $this->myTruncate($job['Job']['description'], 300, " ");
            if (!empty($short_desc)) {
                Configure::write('meta.description', $short_desc);
            }
        }
        // Facebook Like Comment - Used in default.ctp //
        Configure::write('meta.product_name', $job['Job']['title']);
        Configure::write('meta.product_url', Router::url(array(
            'controller' => 'jobs',
            'action' => 'v',
            $job['Job']['slug']
        ) , true));
        $this->pageTitle.= ' - ' . $job['Job']['title'];
        $this->set('job', $job);
        if (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == ConstViewType::EmbedView) {
            $this->layout = 'ajax';
            $this->render('v_embed');
        }
    }
    function add()
    {
        $this->pageTitle = __l('Create a New') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps);
        if (!empty($this->request->data)) {
            Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                '_trackEvent' => array(
                    'category' => 'Job',
                    'action' => sprintf(__l('%s Posted') , jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps)) ,
                    'label' => 'Step1',
                    'value' => '',
                ) ,
                '_setCustomVar' => array(
                    'ud' => $this->Auth->user('id') ,
                    'rud' => $this->Auth->user('referred_by_user_id') ,
                )
            ));
            $this->request->data['Job']['ip_id'] = $this->Job->toSaveIP();
            if (empty($this->request->data['Job']['user_id'])) {
                $this->request->data['Job']['user_id'] = $this->Auth->user('id');
            }
            if (empty($this->request->data['Job']['r'])) {
                $amount = explode(',', Configure::read('job.price'));
                if (count($amount) == 1) $this->request->data['Job']['amount'] = Configure::read('job.price');
                $this->request->data['Job']['commission_amount'] = $this->Job->getCommisonforAmount($this->request->data['Job']['amount']);
                if ($this->request->data['Job']['job_service_location_id'] == ConstServiceLocation::BuyerToSeller) {
                    unset($this->request->data['Job']['job_coverage_radius']);
                }
                $this->Job->set($this->request->data);
                if ($this->request->data['Job']['job_type_id'] == ConstJobType::Online) {
                    unset($this->Job->validate['address']);
                    unset($this->Job->validate['mobile']);
                    unset($this->Job->validate['job_coverage_radius']);
                    unset($this->Job->validate['job_service_location_id']);
                } elseif ($this->request->data['Job']['job_type_id'] == '') {
                    unset($this->Job->validate['address']);
                }
                if ($this->Job->validates()) {
                    $this->request->data['Job']['is_approved'] = (Configure::read('job.is_admin_job_auto_approval')) ? 1 : 0;
                    $jobexist = $this->Job->find('first', array(
                        'conditions' => array(
                            'title' => $this->request->data['Job']['title'],
                            'user_id' => $this->Auth->user('id')
                        ) ,
                        'recursive' => -1
                    ));
                    $jobexists = false;
                    if (!empty($jobexist)) {
                        $job_id = $jobexist['Job']['id'];
                        $jobexists = true;
                    } else {
                        if (isPluginEnabled('Sudopay') && !isPluginEnabled('Wallets')) {
                            $this->loadModel('Sudopay.Sudopay');
                            $user_id = $this->Auth->user('id');
                            $connected_gateways = $this->Sudopay->GetUserConnectedGateways($user_id);
                            if (empty($connected_gateways)) {
                                $this->request->data['Job']['is_active'] = 0;
                            }
                        }
                        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                            $this->request->data['Job']['is_active'] = 1;
                            $this->request->data['Job']['is_approved'] = 1;
                        }
                        if ($this->Job->save($this->request->data['Job'])) {
                            $job_id = $this->Job->getLastInsertId();
                            $jobexists = true;
                        }
                    }
                    if ($jobexists) {
                        $_user_data = array();
                        $_user_data['User']['id'] = $this->Auth->user('id');
                        $_user_data['User']['is_idle'] = 0;
                        $_user_data['User']['is_job_posted'] = 1;
                        $this->User->save($_user_data);
                        Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                            '_trackEvent' => array(
                                'category' => 'Job',
                                'action' => sprintf(__l('%s Posted') , jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps)) ,
                                'label' => 'Step2',
                                'value' => '',
                            ) ,
                            '_setCustomVar' => array(
                                'jd' => $job_id,
                                'ud' => $this->Auth->user('id') ,
                                'rud' => $this->Auth->user('referred_by_user_id') ,
                            )
                        ));
                        $this->Job->Attachment->create();
                        if (!isset($this->request->data['Attachment'])) { // Flash Upload
                            $this->request->data['Attachment']['foreign_id'] = $job_id;
                            $this->request->data['Attachment']['description'] = 'Job';
                            $this->XAjax->flashuploadset($this->request->data);
                        } else { // Normal Upload
                            $is_form_valid = true;
                            $upload_photo_count = 0;
                            $this->request->data['Image'] = $this->request->data['Attachment'];
                            for ($i = 0; $i < count($this->request->data['Image']['filename']); $i++) {
                                if (!empty($this->request->data['Image']['filename'][$i]['tmp_name'])) {
                                    $upload_photo_count++;
                                    $image_info = getimagesize($this->request->data['Image']['filename'][$i]['tmp_name']);
                                    $this->request->data['Attachment']['filename'] = $this->request->data['Image']['filename'][$i];
                                    $this->request->data['Attachment']['filename']['type'] = $image_info['mime'];
                                    $this->Job->Attachment->Behaviors->attach('ImageUpload', Configure::read('photo.file'));
                                    $this->Job->Attachment->set($this->request->data);
                                    if (!$this->Job->validates() |!$this->Job->Attachment->validates()) {
                                        $attachmentValidationError[$i] = $this->Job->Attachment->validationErrors;
                                        $is_form_valid = false;
                                        $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . __l('could not be added. Please, try again.') , 'default', null, 'error');
                                    }
                                }
                            }
                            if (!$upload_photo_count) {
                                $this->Job->validates();
                                $this->Job->Attachment->validationErrors[0]['filename'] = __l('Required');
                                $is_form_valid = false;
                            }
                            if (!empty($attachmentValidationError)) {
                                foreach($attachmentValidationError as $key => $error) {
                                    $this->Job->Attachment->validationErrors[$key]['filename'] = $error;
                                }
                            }
                            if ($is_form_valid) {
                                $this->request->data['foreign_id'] = $job_id;
                                $this->request->data['Attachment'] = $this->request->data['Image'];
                                $this->request->data['Attachment']['description'] = 'Job';
								$this->request->data['Attachment']['filename']['type'] = get_mime($this->request->data['Attachment']['filename']['tmp_name']);
                                $this->XAjax->normalupload($this->request->data, false);
                                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been added.') , 'default', null, 'success');
                                if (isPluginEnabled('SocialMarketing')) {
                                    $this->redirect(array(
                                        'controller' => 'social_marketings',
                                        'action' => 'publish',
                                        'type' => 'facebook',
                                        $job_id,
                                        'publish_action' => 'add',
                                        'publish_name' => 'Job',
                                        'admin' => false
                                    ));
                                }
                                $job = $this->Job->find('first', array(
                                    'conditions' => array(
                                        'Job.id' => $this->Job->id
                                    ) ,
                                    'recursive' => -1
                                ));
                                $this->redirect(array(
                                    'controller' => 'jobs',
                                    'action' => 'view',
                                    $job['Job']['slug'],
                                    'admin' => false
                                ));
                            }
                        }
                    } else {
                        $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('could not be added. Please, try again.') , 'default', null, 'error');
                    }
                } else {
                    $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('could not be added. Please, try again.') , 'default', null, 'error');
                }
            }
        } else {
            $this->request->data['Request']['id'] = 0;
            $userProfile = $this->Job->User->UserProfile->find('first', array(
                'conditions' => array(
                    'UserProfile.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            if (!empty($userProfile)) {
                $this->request->data['Job']['address'] = $userProfile['UserProfile']['contact_address'];
                $this->request->data['Job']['mobile'] = $userProfile['UserProfile']['mobile_phone'];
                $this->request->data['Job']['latitude'] = $userProfile['UserProfile']['latitude'];
                $this->request->data['Job']['longitude'] = $userProfile['UserProfile']['longitude'];
                $this->request->data['Job']['zoom_level'] = $userProfile['UserProfile']['zoom_level'];
            }
        }
        if ((isset($this->request->params['named']['request_id']) && !empty($this->request->params['named']['request_id'])) || !empty($this->request->data['Job']['request_id'])) {
            $request = $this->Job->Request->find('first', array(
                'conditions' => array(
                    'Request.id' => (!empty($this->request->data['Job']['request_id']) ? $this->request->data['Job']['request_id'] : $this->request->params['named']['request_id']) ,
                    'Request.is_approved' => 1
                ) ,
                'recursive' => -1
            ));
            $jobs = $this->Job->find('list', array(
                'conditions' => array(
                    'Job.user_id' => $this->Auth->user('id')
                )
            ));
            $this->set('jobs', $jobs);
            if (!empty($request)) {
                $this->request->data['Job']['request_id'] = $request['Request']['id'];
                $this->request->data['Job']['title'] = $request['Request']['name'];
                $this->request->data['Job']['amount'] = $request['Request']['amount'];
                $this->request->data['Job']['job_type_id'] = $request['Request']['job_type_id'];
                $this->request->data['Job']['job_category_id'] = $request['Request']['job_category_id'];
            }
            $this->set('request', $request);
        }
        $userProfile = $this->Job->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $this->set('userProfile', $userProfile);
        $jobCategories = $this->Job->JobCategory->find('list', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'order' => array(
                'JobCategory.name' => 'asc'
            ) ,
            'recursive' => -1
        ));
        $jobCategoriesClass = $this->Job->JobCategory->find('all', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'fields' => array(
                'JobCategory.id',
                'JobCategory.name',
                'JobCategory.job_type_id',
            ) ,
            'order' => array(
                'JobCategory.name' => 'asc'
            ) ,
            'recursive' => -1
        ));
        $users = $this->Job->User->find('list', array(
            'conditions' => array(
                'User.is_active' => 1
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
        $job_types = $this->Job->JobType->find('list', array(
            'conditions' => $jobTypeConditions,
            'recursive' => -1,
            'order' => array(
                'JobType.id' => 'asc'
            )
        ));
        if (count($job_types) < 2) {
            $this->request->data['Job']['job_type_id'] = array_pop(array_keys($job_types));
        } else {
            $this->request->data['Job']['job_type_id'] = ConstJobType::Online;
        }
        $job_type_descriptions = $this->Job->JobType->find('list', array(
            'fields' => array(
                'JobType.id',
                'JobType.descriptions',
            ) ,
            'order' => array(
                'JobType.id' => 'asc'
            )
        ));
        $jobServiceLocations = $this->Job->JobServiceLocation->find('all', array(
            'recursive' => -1
        ));
        /*Check receiver id */
        $userDetails = $this->Job->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $is_payout_error = 0;
        if (isPluginEnabled('Sudopay')) {
            $this->loadModel('Sudopay.Sudopay');
            $user_id = $this->Auth->user('id');
            $is_having_pending_gateways_connect = $this->Sudopay->isHavingPendingGatewayConnect($user_id);
            $connected_gateways = $this->Sudopay->GetUserConnectedGateways($user_id);
            if (!empty($is_having_pending_gateways_connect)) {
                $is_payout_error = 1;
            }
            if (!empty($this->request->params['named']['step'])) {
                $is_payout_error = 0;
            }
        }
        $this->set(compact('is_payout_error', 'userDetails'));
        $job_service_locations = array();
        foreach($jobServiceLocations as $jobServiceLocation) {
            $job_service_locations[$jobServiceLocation['JobServiceLocation']['id']] = $jobServiceLocation['JobServiceLocation']['name'] . ' <span class="offline-info">' . $jobServiceLocation['JobServiceLocation']['description'] . '</span>';
        }
        $job_service_location_desc = $this->Job->JobServiceLocation->find('list', array(
            'fields' => array(
                'JobServiceLocation.id',
                'JobServiceLocation.description',
            )
        ));
        $job_coverage_radius_units = $this->Job->JobCoverageRadiusUnit->find('list');
        $amounts = explode(',', Configure::read('job.price'));
        $amounts = array_combine($amounts, $amounts);
        $this->set(compact('jobCategories', 'users', 'amounts', 'job_types', 'job_service_locations', 'radius_values', 'job_coverage_radius_units'));
        $this->set('job_type_descriptions', $job_type_descriptions);
        $this->set('job_types', $job_types);
        $this->set('job_service_location_desc', $job_service_location_desc);
        $this->set('jobCategoriesClass', $jobCategoriesClass);
    }
    function flashupload()
    {
        $this->Job->Attachment->Behaviors->attach('ImageUpload', Configure::read('photo.file'));
        $this->XAjax->flashupload();
    }
    /*
    After Adding jobs, it is posted in Site Facebook and Site Twitter account
    If user logged using Fb_connect or twitter account, it will be posted on their facebook and twitter account respectively
    */
    function updateSocialNetworking()
    {
        if (!empty($this->request->params['named']['job_id'])) {
            $job_id = $this->request->params['named']['job_id'];
        } else {
            $uploaded_data = $this->Session->read('flashupload_data');
            $job_id = $uploaded_data['Jobs']['Attachment']['foreign_id'];
        }
        $job = $this->Job->find('first', array(
            'conditions' => array(
                'Job.id = ' => $job_id,
            ) ,
            'fields' => array(
                'Job.id',
                'Job.title',
                'Job.slug',
                'Job.job_category_id',
                'Job.user_id',
                'Job.description',
                'Job.amount',
                'Job.no_of_days',
                'Job.job_view_count',
                'Job.job_feedback_count',
                'Job.is_system_flagged',
                'Job.job_favorite_count',
                'Job.job_tag_count',
                'Job.is_active',
                'Job.is_featured',
            ) ,
            'contain' => array(
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.filename',
                        'Attachment.dir',
                        'Attachment.width',
                        'Attachment.height'
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
                ) ,
            ) ,
            'recursive' => 2
        ));
        $url = Router::url(array(
            'controller' => 'jobs',
            'action' => 'view',
            $job['Job']['slug'],
        ) , true);
        // Job willn't be posted if it is autoflagged and suspend
        if (!$job['Job']['is_system_flagged'] || ($job['Job']['is_system_flagged'] && !Configure::read('job.auto_suspend_job_on_system_flag'))) {
            // Post on user facebook
            if (Configure::read('social_networking.post_job_on_user_facebook')) {
                if ($this->Auth->user('fb_user_id') > 0) {
                    $fb_message = $this->Auth->user('username') . ' ' . __l('created a new') . ' ' . jobAlternateName(ConstJobAlternateName::Singular) . ' "' . $this->Auth->user('username') . ' ' . __l('will') . ' ' . $job['Job']['title'] . ' ' . __l('for') . ' ' . $this->Job->siteCurrencyFormat($job['Job']['amount']) . __l('" in ') . Configure::read('site.name');
                    $getFBReturn = $this->postOnFacebook($job, $fb_message, 0);
                }
            }
            // post on user twitter
            if (Configure::read('social_networking.post_job_on_user_twitter')) {
                $user = $this->Job->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $this->Auth->user('id')
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($user['User']['twitter_access_token']) && !empty($user['User']['twitter_access_key'])) {
                    $message = $this->Auth->user('username') . __l(' will ') . $job['Job']['title'] . __l(' for ') . $this->Job->siteCurrencyFormat($job['Job']['amount']) . ' .' . $url;
                    $xml = $this->OauthConsumer->post('Twitter', $user['User']['twitter_access_token'], $user['User']['twitter_access_key'], 'https://twitter.com/statuses/update.xml', array(
                        'status' => $message
                    ));
                }
            }
            if (Configure::read('job.post_job_on_facebook')) { // post on site facebook
                $fb_message = $this->Auth->user('username') . ' ' . __l('created a new') . ' ' . jobAlternateName(ConstJobAlternateName::Singular) . ' "' . $this->Auth->user('username') . ' ' . __l('will') . ' ' . $job['Job']['title'] . ' ' . __l('for') . ' ' . $this->Job->siteCurrencyFormat($job['Job']['amount']) . __l('" in ') . Configure::read('site.name');
                $getFBReturn = $this->postOnFacebook($job, $fb_message, 1);
            }
            if (Configure::read('job.post_job_on_twitter')) { // post on site twitter
                $message = 'via' . ' ' . '@' . Configure::read('twitter.site_username') . ': ' . $url . ' ' . $this->Auth->user('username') . __l(' will ') . $job['Job']['title'] . __l(' for ') . $this->Job->siteCurrencyFormat($job['Job']['amount']);
                $xml = $this->OauthConsumer->post('Twitter', Configure::read('twitter.site_user_access_token') , Configure::read('twitter.site_user_access_key') , 'https://twitter.com/statuses/update.xml', array(
                    'status' => $message
                ));
            }
        }
        if (!empty($getFBReturn) && ($getFBReturn == '2')) {
            $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been added. But unable to post it on facebook.') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been added.') , 'default', null, 'success');
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $this->redirect(array(
                'controller' => 'jobs',
                'action' => 'index',
                'admin' => 'true',
            ));
        }
        $this->redirect(array(
            'controller' => 'jobs',
            'action' => 'index',
            'type' => 'manage_jobs'
        ));
    }
    // Posting Job on Facebook
    function postOnFacebook($job = null, $message = null, $admin = null)
    {
        if (!empty($job)) {
            $slug = $job['Job']['slug'];
            $image_options = array(
                'dimension' => 'normal_thumb',
                'class' => '',
                'alt' => $job['Job']['title'],
                'title' => $job['Job']['title'],
                'type' => 'jpg'
            );
            if ($admin) {
                //$facebook_dest_user_id = Configure::read('facebook.fb_user_id');	// Site USER ID
                $facebook_dest_user_id = Configure::read('facebook.page_id'); // Site Page ID
                $facebook_dest_access_token = Configure::read('facebook.fb_access_token');
            } else {
                $facebook_dest_user_id = $this->Auth->user('fb_user_id');
                $facebook_dest_access_token = $this->Auth->user('fb_access_token');
            }
            App::import('Vendor', 'facebook/facebook');
            $this->facebook = new Facebook(array(
                'appId' => Configure::read('facebook.api_key') ,
                'secret' => Configure::read('facebook.secrect_key') ,
                'cookie' => true
            ));
            if (empty($message)) {
                $message = $job['Job']['title'];
            }
            $image_url = Router::url('/', true) . $this->getImageUrl('Job', $job['Attachment']['0'], $image_options);
            $image_link = Router::url(array(
                'controller' => 'jobs',
                'action' => 'view',
                'admin' => false,
                $slug
            ) , true);
            try {
                $getPostCheck = $this->facebook->api('/' . $facebook_dest_user_id . '/feed', 'POST', array(
                    'access_token' => $facebook_dest_access_token,
                    'message' => $message,
                    'picture' => $image_url,
                    'icon' => $image_url,
                    'link' => $image_link,
                    'description' => $job['Job']['description']
                ));
            }
            catch(Exception $e) {
                $this->log('Post on facebook error');
                return 2;
            }
        }
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps);
        $job = $this->Job->find('first', array(
            'conditions' => array(
                'Job.id = ' => $id,
            ) ,
            'recursive' => -1
        ));
        if (is_null($id) || !empty($job['Job']['admin_suspend']) && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ((is_null($id) || ($job['Job']['user_id'] != $this->Auth->user('id'))) && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['OldAttachment'])) {
                $attachmentIds = array();
                foreach($this->request->data['OldAttachment'] as $attachment_id => $is_checked) {
                    if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                        $this->Job->Attachment->delete($attachment_id);
                    }
                }
            }
            unset($this->request->data['OldAttachment']);
            if (!empty($this->request->data['Job']['amount'])) {
                $amount = explode(',', Configure::read('job.price'));
                if (count($amount) == 1) {
                    $this->request->data['Job']['amount'] = Configure::read('job.price');
                }
                $this->request->data['Job']['commission_amount'] = $this->Job->getCommisonforAmount($this->request->data['Job']['amount']);
            }
            if (!empty($this->request->data['Job']['job_type_id']) && $this->request->data['Job']['job_type_id'] == ConstJobType::Online) {
                unset($this->Job->validate['address']);
                unset($this->Job->validate['mobile']);
                unset($this->Job->validate['job_coverage_radius']);
                unset($this->Job->validate['job_service_location_id']);
            } elseif (!empty($this->request->data['Job']['job_type_id']) && $this->request->data['Job']['job_type_id'] == '') {
                unset($this->Job->validate['address']);
            }
            if (!empty($this->request->data['Job']['job_service_location_id']) && $this->request->data['Job']['job_service_location_id'] == ConstServiceLocation::BuyerToSeller) {
                unset($this->Job->validate['job_coverage_radius']);
            }
            if ($this->Job->save($this->request->data)) {
                $this->Job->Attachment->create();
                $job_id = $this->request->data['Job']['id'];
                if (!isset($this->request->data['Attachment']) && $this->RequestHandler->isAjax()) {
                    $this->request->data['Attachment']['foreign_id'] = $job_id;
                    $this->request->data['Attachment']['description'] = 'Job';
                    $this->XAjax->flashuploadset($this->request->data);
                } else {
                    $is_form_valid = true;
                    $upload_photo_count = 0;
                    if (!empty($this->request->data['Attachment'])) {
                        for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                            if (!empty($this->request->data['Attachment'][$i]['filename']['tmp_name'])) {
                                $upload_photo_count++;
                                $image_info = getimagesize($this->request->data['Attachment'][$i]['filename']['tmp_name']);
                                $this->request->data['Attachment']['filename'] = $this->request->data['Attachment'][$i]['filename'];
                                $this->request->data['Attachment']['filename']['type'] = $image_info['mime'];
                                $this->request->data['Attachment'][$i]['filename']['type'] = $image_info['mime'];
                                $this->Job->Attachment->Behaviors->attach('ImageUpload', Configure::read('photo.file'));
                                $this->Job->Attachment->set($this->request->data);
                                if (!$this->Job->validates() |!$this->Job->Attachment->validates()) {
                                    $attachmentValidationError[$i] = $this->Job->Attachment->validationErrors;
                                    $is_form_valid = false;
                                    $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('could not be Edited. Please, try again.') , 'default', null, 'error');
                                }
                            }
                        }
                    }
                    if (!empty($attachmentValidationError)) {
                        foreach($attachmentValidationError as $key => $error) {
                            $this->Job->Attachment->validationErrors[$key]['filename'] = $error;
                        }
                    }
                    if ($is_form_valid) {
                        $this->request->data['foreign_id'] = $job_id;
                        if (!empty($this->request->data['Attachment'])) {
                            $this->request->data['Attachment']['description'] = 'Job';
                            $this->XAjax->normalupload($this->request->data, false);
                        }
                        $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been Edited.') , 'default', null, 'success');
                        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                            $this->redirect(array(
                                'controller' => 'jobs',
                                'action' => 'index',
                            ));
                        } else {
                            $this->redirect(array(
                                'controller' => 'jobs',
                                'action' => 'index',
                                'type' => 'manage_jobs',
                            ));
                        }
                    }
                }
            } else {
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('could not be Edited. Please, try again.') , 'default', null, 'error');
            }
            $conditions['JobOrder.job_id'] = $this->request->data['Job']['id'];
            $conditions['JobOrder.job_order_status_id'] = array(
                ConstJobOrderStatus::WaitingforAcceptance,
                ConstJobOrderStatus::InProgress,
                ConstJobOrderStatus::WaitingforReview,
                ConstJobOrderStatus::InProgressOvertime
            );
            $check_job_order = $this->Job->JobOrder->find('first', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            if (!empty($check_job_order) && ($this->Auth->user('role_id') != ConstUserIds::Admin)) {
                $this->set('has_active_order', 1);
            }
        } else {
            $this->request->data = $this->Job->find('first', array(
                'conditions' => array(
                    'Job.id' => $id
                ) ,
                'recursive' => 1
            ));
            if ($this->request->data['Job']['job_type_id'] == ConstJobType::Online) {
                unset($this->Job->validate['address']);
            }
            $conditions['JobOrder.job_id'] = $this->request->data['Job']['id'];
            $conditions['JobOrder.job_order_status_id'] = array(
                ConstJobOrderStatus::WaitingforAcceptance,
                ConstJobOrderStatus::InProgress,
                ConstJobOrderStatus::WaitingforReview,
                ConstJobOrderStatus::InProgressOvertime
            );
            $check_job_order = $this->Job->JobOrder->find('first', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            if (!empty($check_job_order) && ($this->Auth->user('role_id') != ConstUserIds::Admin)) {
                $this->set('has_active_order', 1);
            }
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->request->data['Job']['tag'] = $this->Job->formatTags($this->request->data['JobTag']);
        }
        $this->pageTitle.= ' - ' . $this->request->data['Job']['title'];
        $jobCategories = $this->Job->JobCategory->find('list', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'order' => array(
                'JobCategory.name' => 'asc'
            ) ,
            'recursive' => -1
        ));
        $jobCategoriesClass = $this->Job->JobCategory->find('all', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'fields' => array(
                'JobCategory.id',
                'JobCategory.name',
                'JobCategory.job_type_id',
            ) ,
            'order' => array(
                'JobCategory.name' => 'asc'
            ) ,
            'recursive' => -1
        ));
        $users = $this->Job->User->find('list', array(
            'conditions' => array(
                'User.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        $job_type_descriptions = $this->Job->JobType->find('list', array(
            'fields' => array(
                'JobType.id',
                'JobType.descriptions',
            )
        ));
        $job_service_locations = $this->Job->JobServiceLocation->find('list');
        $job_service_location_desc = $this->Job->JobServiceLocation->find('list', array(
            'fields' => array(
                'JobServiceLocation.id',
                'JobServiceLocation.description',
            )
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
        $job_types = $this->Job->JobType->find('list', array(
            'conditions' => $jobTypeConditions,
            'recursive' => -1
        ));
        if (count($job_types) < 2) {
            $this->request->data['Job']['job_type_id'] = array_pop(array_keys($job_types));
        }
        $job_service_locations = $this->Job->JobServiceLocation->find('list');
        $jobCoverageRadiusUnits = $this->Job->JobCoverageRadiusUnit->find('list');
        $amounts = explode(',', Configure::read('job.price'));
        $amounts = array_combine($amounts, $amounts);
        $this->set(compact('jobCategories', 'users', 'amounts', 'job_types', 'job_service_locations', 'radius_values', 'jobCoverageRadiusUnits'));
        $this->set('job_type_descriptions', $job_type_descriptions);
        $this->set('job_types', $job_types);
        $this->set('job_service_location_desc', $job_service_location_desc);
        $this->set('jobCategoriesClass', $jobCategoriesClass);
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $job = $this->Job->find('first', array(
            'conditions' => array(
                'Job.id = ' => $id,
            ) ,
            'recursive' => -1
        ));
        if ((is_null($id) || ($job['Job']['user_id'] != $this->Auth->user('id'))) && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Job->delete($id)) {
            $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('deleted') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'jobs',
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function mapping_jobs()
    {
        App::import('Model', 'Jobs.JobsRequest');
        $this->JobsRequest = new JobsRequest();
        $r = $this->request->data['Job']['r'];
        if (!empty($this->request->data['Job']['request_id']) && !empty($this->request->data['Job']['job'])) {
            $this->Job->_updateJobRequest($this->request->data['Job']['request_id'], $this->request->data['Job']['job']);
            $this->Session->setFlash(__l('A') . ' ' . jobAlternateName(ConstJobAlternateName::Singular) . ' ' . __l('for this') . ' ' . requestAlternateName(ConstRequestAlternateName::Singular) . ' ' . __l('has been added.') , 'default', null, 'success');
            $request = $this->JobsRequest->Request->find('first', array(
                'conditions' => array(
                    'Request.id' => $this->request->data['Job']['request_id'],
                ) ,
                'fields' => array(
                    'Request.slug'
                ) ,
                'recursive' => -1
            ));
            $this->redirect(array(
                'controller' => 'requests',
                'action' => 'view',
                $request['Request']['slug']
            ));
        } else {
            $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l(' Couldn\'t Map to Request') , 'default', null, 'error');
            $this->redirect(Router::url('/', true) . $r);
        }
    }
    function search()
    {
    }
    function admin_index()
    {
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps);
        $this->Job->recursive = 0;
        $conditions = array();
        $this->_redirectGET2Named(array(
            'q',
            'username',
            'job_category_id'
        ));
        $this->set('active_jobs', $this->Job->find('count', array(
            'conditions' => array(
                'Job.is_active = ' => 1,
                'Job.admin_suspend = ' => 0,
                'Job.is_deleted = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('feautured_jobs', $this->Job->find('count', array(
            'conditions' => array(
                'Job.is_featured = ' => 1,
                'Job.is_deleted = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('suspended_jobs', $this->Job->find('count', array(
            'conditions' => array(
                'Job.admin_suspend = ' => 1,
                'Job.is_deleted = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('user_suspended_jobs', $this->Job->find('count', array(
            'conditions' => array(
                'Job.is_active = ' => 0,
                'Job.is_deleted = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('system_flagged', $this->Job->find('count', array(
            'conditions' => array(
                'Job.is_system_flagged = ' => 1,
                'Job.admin_suspend = ' => 0,
                'Job.is_deleted = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('trash', $this->Job->find('count', array(
            'conditions' => array(
                'Job.is_deleted = ' => 1,
            ) ,
            'recursive' => -1
        )));
        $this->set('total_jobs', $this->Job->find('count', array(
            'conditions' => array(
                'Job.is_deleted = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('online_jobs', $this->Job->find('count', array(
            'conditions' => array(
                'Job.job_type_id = ' => 1,
                'Job.admin_suspend = ' => 0,
                'Job.is_deleted = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('offline_jobs', $this->Job->find('count', array(
            'conditions' => array(
                'Job.job_type_id = ' => 2,
                'Job.admin_suspend = ' => 0,
                'Job.is_deleted = ' => 0,
            ) ,
            'recursive' => -1
        )));
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Job']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['Job']['filter_id'])) {
            if ($this->request->data['Job']['filter_id'] == ConstMoreAction::Approved) {
                $conditions['Job.is_approved'] = 1;
                $this->pageTitle.= __l(' - Approved ');
            } else if ($this->request->data['Job']['filter_id'] == ConstMoreAction::Disapproved) {
                $conditions['Job.is_approved'] = 0;
                $this->pageTitle.= __l(' - Disapproved ');
            } else if ($this->request->data['Job']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Job.is_active'] = 1;
                $conditions['Job.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->data['Job']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Job.is_active'] = 0;
                $this->pageTitle.= __l(' - User suspended ');
            } else if ($this->request->data['Job']['filter_id'] == ConstMoreAction::Suspend) {
                $conditions['Job.admin_suspend'] = 1;
                $this->pageTitle.= __l(' - Suspended ');
            } else if ($this->request->data['Job']['filter_id'] == ConstMoreAction::Feature) {
                $conditions['Job.is_featured'] = 1;
                $this->pageTitle.= __l(' - Featured ');
            } else if ($this->request->data['Job']['filter_id'] == ConstMoreAction::Flagged) {
                $conditions['Job.is_system_flagged'] = 1;
                $conditions['Job.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Flagged ');
            } else if ($this->request->data['Job']['filter_id'] == ConstMoreAction::UserFlagged) {
                $conditions['Job.job_flag_count !='] = 0;
                $conditions['Job.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - User Flagged ');
            } else if ($this->request->data['Job']['filter_id'] == ConstMoreAction::Trash) {
                $conditions['Job.is_deleted'] = 1;
                $this->pageTitle.= __l(' - Trashed ');
            } else if ($this->request->data['Job']['filter_id'] == ConstMoreAction::Offline) {
                $conditions['Job.job_type_id'] = ConstJobType::Offline;
                $conditions['Job.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Offline ');
            } else if ($this->request->data['Job']['filter_id'] == ConstMoreAction::Online) {
                $conditions['Job.job_type_id'] = ConstJobType::Online;
                $conditions['Job.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Online ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Job']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['Job.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['Job.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['Job.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - in this month');
        }
        if (isset($this->request->params['named']['job_category_id'])) {
            $this->request->data['Job']['job_category_id'] = $this->request->params['named']['job_category_id'];
            $conditions['Job.job_category_id'] = $this->request->params['named']['job_category_id'];
            // Get the Job Category name
            $category_name = $this->Job->JobCategory->find('first', array(
                'conditions' => array(
                    'JobCategory.id' => $this->request->params['named']['job_category_id']
                ) ,
                'fields' => array(
                    'JobCategory.name',
                ) ,
                'recursive' => -1
            ));
            $this->pageTitle.= __l(' - Category - ') . $category_name['JobCategory']['name'];
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
                        'Job.title LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'User.username LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Job.description LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    )
                )
            );
            $this->request->data['Job']['q'] = $this->request->params['named']['q'];
        }
        if ((!empty($this->request->data['Job']['filter_id']) && ($this->request->data['Job']['filter_id'] != ConstMoreAction::Trash)) || empty($this->request->data['Job']['filter_id'])) {
            $conditions['Job.is_deleted'] = 0;
        }
        if (isset($this->request->params['named']['job_type_id'])) {
            $this->request->data['Job']['job_type_id'] = $this->request->params['named']['job_type_id'];
            $conditions['Job.job_type_id'] = $this->request->params['named']['job_type_id'];
        }
        $this->set('page_title', $this->pageTitle);
        $contain = array();
        $contain = array(
            'User' => array(
                'UserAvatar' => array(
                    'fields' => array(
                        'UserAvatar.id',
                        'UserAvatar.dir',
                        'UserAvatar.filename',
                        'UserAvatar.width',
                        'UserAvatar.height'
                    )
                ) ,
                'fields' => array(
                    'User.is_active',
                    'User.username'
                ) ,
            ) ,
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
            'JobTag' => array(
                'fields' => array(
                    'JobTag.name',
                    'JobTag.slug'
                )
            ) ,
            'JobOrder' => array(
                'conditions' => array(
                    'job_order_status_id' => array(
                        ConstJobOrderStatus::WaitingforAcceptance,
                        ConstJobOrderStatus::InProgress,
                        ConstJobOrderStatus::WaitingforReview,
                        ConstJobOrderStatus::InProgressOvertime,
                    )
                )
            ) ,
            'JobCategory' => array(
                'fields' => array(
                    'JobCategory.id',
                    'JobCategory.created',
                    'JobCategory.modified',
                    'JobCategory.name',
                    'JobCategory.slug',
                    'JobCategory.is_active',
                    'JobCategory.job_count',
                )
            ) ,
            'JobType' => array(
                'fields' => array(
                    'JobType.id',
                    'JobType.name',
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
            ) ,
        );
        if (isPluginEnabled('JobFlags')) {
            $contain['JobFlag'] = array(
                'fields' => array(
                    'JobFlag.id',
                    'JobFlag.user_id',
                    'JobFlag.job_id'
                )
            );
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'order' => array(
                'Job.id' => 'desc'
            ) ,
            'recursive' => 2
        );
        $jobCategories = $this->Job->JobCategory->find('list', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        $moreActions = $this->Job->moreActions;
        $this->set(compact('moreActions', 'jobCategories'));
        if (isset($this->request->data['Job']['q'])) {
            $this->paginate['search'] = $this->request->data['Job']['q'];
            $search_result = $this->paginate();
            if (empty($search_result)) {
                $this->set('search_result', '1');
            }
        }
        $this->set('jobs', $this->paginate());
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps);
        $this->setAction('add');
    }
    function admin_edit($id = null)
    {
        if (is_null($id) && empty($this->request->data)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->setAction('edit', $id);
    }
    function admin_purge()
    {
        $this->autoRender = false;
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $jobs = $this->Job->find('all', array(
            'conditions' => array(
                'Job.is_deleted' => 1
            ) ,
        ));
        foreach($jobs as $job) {
            $this->Job->delete($job['Job']['id']);
        }
        $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been purged') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'jobs',
            'action' => 'index'
        ));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $order_cancelled = 0;
        $get_orders = $this->Job->find('first', array(
            'conditions' => array(
                'Job.id' => $id,
            ) ,
            'contain' => array(
                'JobOrder' => array(
                    'conditions' => array(
                        'JobOrder.job_order_status_id' => array(
                            ConstJobOrderStatus::WaitingforAcceptance,
                            ConstJobOrderStatus::InProgress,
                            ConstJobOrderStatus::WaitingforReview,
                            ConstJobOrderStatus::Completed,
                            ConstJobOrderStatus::InProgressOvertime,
                        )
                    ) ,
                ) ,
            ) ,
            'recursive' => 1
        ));
        if (!empty($get_orders['JobOrder'])) {
            foreach($get_orders['JobOrder'] as $job_order) {
                $order_cancelled = 1;
                $this->Job->JobOrder->processOrder($job_order['id'], 'admin_cancel');
            }
        }
        $this->request->data['Job']['id'] = $id;
        $this->request->data['Job']['is_deleted'] = '1';
        if ($this->Job->save($this->request->data)) {
            if (!empty($order_cancelled)) {
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('deleted') . ' ' . __l('and its order has been cancelled and refunded') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('deleted') , 'default', null, 'success');
            }
            $this->redirect(array(
                'controller' => 'jobs',
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function update()
    {
        if (!empty($this->request->data)) {
            $JobIds = array();
            $r = $this->request->data[$this->modelClass]['r'];
            $error = 0;
            $is_deleted = 0;
            foreach($this->request->data[$this->modelClass] as $id => $is_checked) {
                if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                    $job_id[] = $id;
                }
            }
            unset($this->request->data[$this->modelClass]['r']);
            if ((!empty($this->request->data[$this->modelClass]['type_suspend']) || !empty($this->request->data[$this->modelClass]['type_activate']) || !empty($this->request->data[$this->modelClass]['type_delete'])) && !empty($job_id)) {
                if (!empty($this->request->data[$this->modelClass]['type_suspend']) || !empty($this->request->data[$this->modelClass]['type_delete'])) {
                    foreach($job_id as $id) {
                        $conditions['JobOrder.job_id'] = $id;
                        $conditions['JobOrder.job_order_status_id'] = array(
                            ConstJobOrderStatus::WaitingforAcceptance,
                            ConstJobOrderStatus::InProgress,
                            ConstJobOrderStatus::WaitingforReview
                        );
                        $check_job_order = $this->Job->JobOrder->find('first', array(
                            'conditions' => $conditions,
                            'recursive' => -1
                        ));
                        if (empty($check_job_order)) {
                            $saveJob['id'] = $id;
                            if (!empty($this->request->data[$this->modelClass]['type_delete'])) {
                                $is_deleted = 1;
                                $saveJob['is_deleted'] = 1;
                            } else {
                                $saveJob['is_active'] = 0;
                            }
                            $this->Job->save($saveJob);
                        } else {
                            $error = 1;
                        }
                    }
                    if ($error) {
                        $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('with active orders cannot be suspended or deleted.') , 'default', null, 'error');
                    } else {
                        if (!empty($is_deleted)) {
                            $this->Session->setFlash(__l('Selected') . ' ' . jobAlternateName(ConstJobAlternateName::Plural) . ' ' . __l('has been deleted.') , 'default', null, 'success');
                        } else {
                            $this->Session->setFlash(__l('Selected') . ' ' . jobAlternateName(ConstJobAlternateName::Plural) . ' ' . __l('has been suspended') , 'default', null, 'success');
                        }
                    }
                } else if (!empty($this->request->data[$this->modelClass]['type_activate'])) {
                    if (isPluginEnabled('Sudopay')) {
                        $this->loadModel('Sudopay.Sudopay');
                        $user_id = $this->Auth->user('id');
                        $connected_gateways = $this->Sudopay->GetUserConnectedGateways($user_id);
                    }
                    if ((isPluginEnabled('Sudopay') && !empty($connected_gateways)) || isPluginEnabled('Wallets')) {
                        foreach($this->request->data[$this->modelClass] as $job_id => $is_checked) {
                            if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                                $saveJob['id'] = $job_id;
                                $saveJob['is_active'] = 1;
                                $this->Job->save($saveJob);
                            }
                        }
                        $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been activated') , 'default', null, 'success');
                    } else {
                        $this->Session->setFlash(__l('Sorry you can\'t activate your ') . jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . __l('. Since you payout connections are empty. Please connect anyone your payment account.') , 'default', null, 'error');
                    }
                }
            }
            $this->redirect(Router::url('/', true) . $r);
        }
    }
    function admin_update()
    {
        if (!empty($this->request->data[$this->modelClass])) {
            $this->Job->Behaviors->detach('SuspiciousWordsDetector');
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $ids = array();
            foreach($this->request->data[$this->modelClass] as $id => $is_checked) {
                if ($is_checked['id']) {
                    $ids[] = $id;
                }
            }
            if ($actionid && !empty($ids)) {
                switch ($actionid) {
                    case ConstMoreAction::Inactive:
                        foreach($ids as $id) {
                            $saveJob['id'] = $id;
                            $saveJob['is_active'] = 0;
                            $this->Job->save($saveJob);
                        }
                        $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been inactivated') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Active:
                        foreach($ids as $id) {
                            $saveJob['id'] = $id;
                            $saveJob['is_active'] = 1;
                            $this->Job->save($saveJob);
                        }
                        $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been activated') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Feature:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_featured' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been changed to featured') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unfeature:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_featured' => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been changed to unfeatured') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Suspend:
                        foreach($ids as $id) {
                            $get_orders = $this->Job->find('first', array(
                                'conditions' => array(
                                    'Job.id' => $id,
                                ) ,
                                'contain' => array(
                                    'JobOrder'
                                ) ,
                                'recursive' => 1
                            ));
                            if (!empty($get_orders['JobOrder'])) {
                                foreach($get_orders['JobOrder'] as $job_order) {
                                    $this->Job->JobOrder->processOrder($job_order['id'], 'admin_cancel');
                                }
                            }
                            $saveJob['id'] = $id;
                            $saveJob['admin_suspend'] = 1;
                            $this->Job->save($saveJob);
                        }
                        $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been Suspended') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unsuspend:
                        foreach($ids as $id) {
                            $saveJob['id'] = $id;
                            $saveJob['admin_suspend'] = 0;
                            $this->Job->save($saveJob);
                        }
                        $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been changed to Unsuspended') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Flagged:
                        foreach($ids as $id) {
                            $saveJob['id'] = $id;
                            $saveJob['is_system_flagged'] = 1;
                            $this->Job->save($saveJob);
                        }
                        $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been changed to flagged') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unflagged:
                        foreach($ids as $id) {
                            $saveJob['id'] = $id;
                            $saveJob['is_system_flagged'] = 0;
                            $this->Job->save($saveJob);
                        }
                        $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('has been changed to Unflagged') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::ActivateUser:
                        foreach($ids as $id) {
                            if (!empty($id)) {
                                $jobUserId = $this->Job->find('first', array(
                                    'conditions' => array(
                                        'Job.id' => $id
                                    ) ,
                                    'recursive' => -1
                                ));
                                $saveJobUser['id'] = $jobUserId['Job']['user_id'];
                                $saveJobUser['is_active'] = 1;
                                $this->Job->User->save($saveJobUser);
                                $this->_sendAdminActionMail($jobUserId['Job']['user_id'], 'Admin User Active');
                            }
                        }
                        $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('user has been changed to active') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::DeActivateUser:
                        foreach($ids as $id) {
                            if (!empty($id)) {
                                $jobUserId = $this->Job->find('first', array(
                                    'conditions' => array(
                                        'Job.id' => $id
                                    ) ,
                                    'recursive' => -1
                                ));
                                $saveJobUser['id'] = $jobUserId['Job']['user_id'];
                                $saveJobUser['is_active'] = 0;
                                $this->Job->User->save($saveJobUser);
                                $this->_sendAdminActionMail($jobUserId['Job']['user_id'], 'Admin User Deactivate');
                            }
                        }
                        $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('user has been changed to inactive') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Delete:
                        $order_cancelled = 0;
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_deleted' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        foreach($ids as $id) {
                            $get_orders = $this->Job->find('first', array(
                                'conditions' => array(
                                    'Job.id' => $id,
                                ) ,
                                'contain' => array(
                                    'JobOrder' => array(
                                        'conditions' => array(
                                            'JobOrder.job_order_status_id' => array(
                                                ConstJobOrderStatus::WaitingforAcceptance,
                                                ConstJobOrderStatus::InProgress,
                                                ConstJobOrderStatus::WaitingforReview,
                                                ConstJobOrderStatus::Completed,
                                                ConstJobOrderStatus::InProgressOvertime,
                                            )
                                        ) ,
                                    ) ,
                                ) ,
                                'recursive' => 1
                            ));
                            if (!empty($get_orders['JobOrder'])) {
                                $order_cancelled = 1;
                                foreach($get_orders['JobOrder'] as $job_order) {
                                    $this->Job->JobOrder->processOrder($job_order['id'], 'admin_cancel');
                                }
                            }
                        }
                        if (!empty($order_cancelled)) {
                            $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('deleted') . ' ' . __l('and its order has been cancelled and refunded') , 'default', null, 'success');
                        } else {
                            $this->Session->setFlash(__l('Checked') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('deleted') , 'default', null, 'success');
                        }
                        break;

                    case ConstMoreAction::Approved:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_approved' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been approved') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Disapproved:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_approved' => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        if ($this->modelClass == 'Job') {
                            $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been disapproved') , 'default', null, 'success');
                        }
                        break;
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    function myTruncate($string, $limit, $break = ".", $pad = "...")
    {
        // return with no change if string is shorter than $limit
        if (strlen($string) <= $limit) return $string;
        // is $break present between $limit and the end of the string?
        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < strlen($string) -1) {
                $string = substr($string, 0, $breakpoint) . $pad;
            }
        }
        return $string;
    }
    function youtube_url_print()
    {
        $id = $this->request->params['named']['job_id'];
        $get_job = $this->Job->find('first', array(
            'conditions' => array(
                'id' => $id
            ) ,
            'recursive' => -1
        ));
        $this->set('url', $get_job['Job']['youtube_url']);
    }
    public function show_admin_control_panel()
    {
        $this->disableCache();
        if (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'job') {
            $job = $this->Job->find('first', array(
                'conditions' => array(
                    'Job.id' => $this->request->params['named']['id']
                ) ,
                'recursive' => 0
            ));
            $this->set('job', $job);
        }
        $this->layout = 'ajax';
    }
    public function job_location()
    {
        $job = $this->Job->find('first', array(
            'conditions' => array(
                'Job.id' => $this->request->params['named']['job_id']
            ) ,
            'fields' => array(
                'Job.id',
                'Job.created',
                'Job.title',
                'Job.slug',
                'Job.job_category_id',
                'Job.user_id',
                'Job.job_type_id',
                'Job.description',
                'Job.no_of_days',
                'Job.job_view_count',
                'Job.job_feedback_count',
                'Job.job_favorite_count',
                'Job.job_tag_count',
                'Job.latitude',
                'Job.longitude',
                'Job.zoom_level',
                'Job.is_active',
                'Job.amount',
                'Job.is_featured',
                'Job.admin_suspend',
                'Job.youtube_url',
                'Job.job_service_location_id',
                'Job.flickr_url',
                'Job.active_sale_count',
                'Job.complete_sale_count',
                'Job.address',
                'Job.mobile',
                'Job.positive_feedback_count',
                'Job.revenue',
                'Job.is_system_flagged',
                'Job.instruction_to_buyer',
                'Job.detected_suspicious_words',
                'Job.sales_cleared_count',
                'Job.sales_pipeline_count',
                'User.sales_cleared_count',
                'User.sales_pipeline_count',
                'Job.order_received_count',
                'Job.order_accepted_count',
                'Job.order_success_without_overtime_count',
                'Job.order_success_with_overtime_count',
                'Job.order_failure_count',
                'Job.order_active_count',
                'Job.order_completed_count',
                'Job.order_last_accepted_date',
                'Job.job_coverage_radius',
                'Job.job_coverage_radius_unit_id',
                'Job.is_instruction_requires_attachment',
                'Job.is_instruction_requires_input',
                'Job.average_time_taken',
                'User.positive_feedback_count',
                'User.job_feedback_count',
                'User.id',
                'User.username',
                'User.email',
                'Job.is_approved'
            ) ,
            'contains' => array(
                'User'
            ) ,
            'recursive' => 0
        ));
        $this->set('job', $job);
    }
}
?>