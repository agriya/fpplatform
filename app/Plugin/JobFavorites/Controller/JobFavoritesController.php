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
class JobFavoritesController extends AppController
{
    public $name = 'JobFavorites';
    public $components = array(
        'OauthConsumer'
    );
    function index()
    {
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Favorites');
        $this->JobFavorite->recursive = 0;
        $this->set('jobFavorites', $this->paginate());
    }
    // Add Favourites and update in facebook and twitter if user is logged in using FB Connect or Twitter Connect //
    function add($slug = null)
    {
        $job = $this->JobFavorite->Job->find('first', array(
            'conditions' => array(
                'Job.slug = ' => $slug
            ) ,
            'recursive' => -1
        ));
        if (empty($job)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->JobFavorite->find('first', array(
            'conditions' => array(
                'user_id' => $this->Auth->user('id') ,
                'job_id' => $job['Job']['id']
            ) ,
            'recursive' => -1
        ));
        if (empty($chkFavorites)) {
            $this->request->data['JobFavorite']['job_id'] = $job['Job']['id'];
            $this->request->data['JobFavorite']['user_id'] = $this->Auth->user('id');
            $this->request->data['JobFavorite']['ip_id'] = $this->JobFavorite->toSaveIP();
            if (!empty($this->request->data)) {
                $this->JobFavorite->create();
                if ($this->JobFavorite->save($this->request->data)) {
                    $favorite_id = $this->JobFavorite->id;
                    // Update Social Networking//
                    $job = $this->JobFavorite->Job->find('first', array(
                        'conditions' => array(
                            'Job.id = ' => $this->request->data['JobFavorite']['job_id'],
                        ) ,
                        'fields' => array(
                            'Job.id',
                            'Job.title',
                            'Job.slug',
                            'Job.job_category_id',
                            'Job.user_id',
                            'Job.description',
                            'Job.no_of_days',
                            'Job.job_view_count',
                            'Job.job_feedback_count',
                            'Job.job_favorite_count',
                            'Job.job_tag_count',
                            'Job.ip_id',
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
                        ) ,
                        'recursive' => 2,
                    ));
                    $url = Router::url(array(
                        'controller' => 'jobs',
                        'action' => 'view',
                        $job['Job']['slug'],
                    ) , true);
                    $response = '';
                    $response = Cms::dispatchEvent('Controller.SocialMarketing.getShareUrl', $this, array(
                        'data' => $favorite_id,
                        'publish_action' => 'follow'
                    ));
                    // END of Social Networking //
                    if ($this->RequestHandler->isAjax()) {
                        echo "added|" . Router::url(array(
                            'controller' => 'job_favorites',
                            'action' => 'delete',
                            $job['Job']['slug']
                        ) , true);
                        exit;
                    }
                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                        '_trackEvent' => array(
                            'category' => 'User',
                            'action' => 'Favorited',
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
                            'category' => 'JobFavorite',
                            'action' => 'Favorited',
                            'label' => $job['Job']['id'],
                            'value' => '',
                        ) ,
                        '_setCustomVar' => array(
                            'pd' => $job['Job']['id'],
                            'ud' => $this->Auth->user('id') ,
                            'rud' => $this->Auth->user('referred_by_user_id') ,
                        )
                    ));
                    $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular) . ' ' . __l('has been added to your Favorites') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'jobs',
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular) . ' ' . __l('Favorite could not be added. Please, try again.') , 'default', null, 'error');
                }
            }
        } else {
            $this->Session->setFlash(sprintf(__l('You have already added this %s as your favorites') , jobAlternateName(ConstJobAlternateName::Singular)) , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'jobs',
                'action' => 'index'
            ));
        }
    }
    function delete($slug = null)
    {
        $job = $this->JobFavorite->Job->find('first', array(
            'conditions' => array(
                'Job.slug = ' => $slug
            ) ,
            'recursive' => -1
        ));
        if (empty($job)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->JobFavorite->find('first', array(
            'conditions' => array(
                'JobFavorite.user_id' => $this->Auth->user('id') ,
                'JobFavorite.job_id' => $job['Job']['id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($chkFavorites['JobFavorite']['id'])) {
            $id = $chkFavorites['JobFavorite']['id'];
            if ($this->JobFavorite->delete($id)) {
                if ($this->RequestHandler->isAjax()) {
                    echo "removed|" . Router::url(array(
                        'controller' => 'job_favorites',
                        'action' => 'add',
                        $job['Job']['slug']
                    ) , true);
                    exit;
                }
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('removed from favorites') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'jobs',
                    'action' => 'index'
                ));
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function admin_index()
    {
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Favorites');
        $this->_redirectGET2Named(array(
            'q',
            'username',
        ));
        App::import('Model', 'JobFavorites.JobFavorite');
        $this->JobFavorite = new JobFavorite();
        $conditions = array();
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
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['JobFavorite.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['JobFavorite.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['JobFavorite.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - in this month');
        }
        if (!empty($this->request->params['named']['job'])) {
            $conditions['Job.slug'] = $this->request->params['named']['job'];
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['JobFavorite']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->JobFavorite->recursive = 0;
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
                'JobFavorite.id' => 'desc'
            )
        );
        if (isset($this->request->data['JobFavorite']['q'])) {
            $this->paginate['search'] = $this->request->data['JobFavorite']['q'];
        }
        $moreActions = $this->JobFavorite->moreActions;
        $this->set(compact('moreActions'));
        $this->set('jobFavorites', $this->paginate());
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->JobFavorite->delete($id)) {
            $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Favorite deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>