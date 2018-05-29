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
class RequestFavoritesController extends AppController
{
    public $name = 'RequestFavorites';
    function index()
    {
        $this->pageTitle = sprintf(__l('%s Favorites') , requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps));
        $this->RequestFavorite->recursive = 0;
        $this->set('requestFavorites', $this->paginate());
    }
    function add($slug = null)
    {
        $request = $this->RequestFavorite->Request->find('first', array(
            'conditions' => array(
                'Request.slug' => $slug
            ) ,
            'recursive' => -1
        ));
        if (empty($request)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->RequestFavorite->find('first', array(
            'conditions' => array(
                'user_id' => $this->Auth->user('id') ,
                'request_id' => $request['Request']['id']
            ) ,
            'recursive' => -1
        ));
        if (empty($chkFavorites)) {
            $this->request->data['RequestFavorite']['request_id'] = $request['Request']['id'];
            $this->request->data['RequestFavorite']['user_id'] = $this->Auth->user('id');
            $this->request->data['RequestFavorite']['ip_id'] = $this->RequestFavorite->toSaveIP();
            if (!empty($this->request->data)) {
                $this->RequestFavorite->create();
                if ($this->RequestFavorite->save($this->request->data)) {
                    $request = $this->RequestFavorite->Request->find('first', array(
                        'conditions' => array(
                            'Request.id = ' => $this->request->data['RequestFavorite']['request_id'],
                        ) ,
                        'recursive' => -1,
                    ));
                    $url = Router::url(array(
                        'controller' => 'requests',
                        'action' => 'view',
                        $request['Request']['slug'],
                    ) , true);
                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                        '_trackEvent' => array(
                            'category' => 'User',
                            'action' => 'RequestFavorited ',
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
                            'category' => 'RequestFavorite',
                            'action' => 'Favorited',
                            'label' => $request['Request']['id'],
                            'value' => '',
                        ) ,
                        '_setCustomVar' => array(
                            'pd' => $request['Request']['id'],
                            'ud' => $this->Auth->user('id') ,
                            'rud' => $this->Auth->user('referred_by_user_id') ,
                        )
                    ));
                    // Update Social Networking//
                    if (Configure::read('social_networking.post_job_on_user_facebook')) {
                        if ($this->Auth->user('fb_user_id') > 0) {
                            $image_options = array(
                                'dimension' => 'normal_thumb',
                                'class' => '',
                                'alt' => $request['Request']['name'],
                                'title' => $request['Request']['name'],
                                'type' => 'jpg'
                            );
                            App::import('Vendor', 'facebook/facebook');
                            $this->facebook = new Facebook(array(
                                'appId' => Configure::read('facebook.api_key') ,
                                'secret' => Configure::read('facebook.secrect_key') ,
                                'cookie' => true
                            ));
                            $image_url = Router::url('/', true) . $this->getImageUrl('Request', $request['Attachment']['0'], $image_options);
                            $facebook_dest_user_id = $this->Auth->user('fb_user_id');
                            $facebook_dest_access_token = $this->Auth->user('fb_access_token');
                            $message = $this->Auth->user('username') . ' ' . __l('likes the') . ' ' . requestAlternateName(ConstRequestAlternateName::Singular) . ' ' . $request['Request']['title'] . '.';
                            try {
                                $this->facebook->api('/' . $facebook_dest_user_id . '/feed', 'POST', array(
                                    'access_token' => $facebook_dest_access_token,
                                    'message' => $message,
                                    //'picture' => $image_url,
                                    //'icon' => $image_url,
                                    'link' => $url,
                                    'description' => $request['Request']['name']
                                ));
                            }
                            catch(Exception $e) {
                                $this->log('Post like on facebook error');
                            }
                        }
                    }
                    if (Configure::read('social_networking.post_job_on_user_twitter')) {
                        $user = $this->RequestFavorite->Request->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->Auth->user('id')
                            ) ,
                            'recursive' => -1
                        ));
                        if (!empty($user['User']['twitter_access_token']) && !empty($user['User']['twitter_access_key'])) {
                            $message = $this->Auth->user('username') . ' ' . __l('likes the') . ' ' . requestAlternateName(ConstRequestAlternateName::Singular) . ' ' . $request['Request']['title'] . '.' . $url;
                            $xml = $this->OauthConsumer->post('Twitter', $user['User']['twitter_access_token'], $user['User']['twitter_access_key'], 'https://twitter.com/statuses/update.xml', array(
                                'status' => $message
                            ));
                        }
                    }
                    // END of Social Networking //
                    if ($this->RequestHandler->isAjax()) {
                        echo "added|" . Router::url(array(
                            'controller' => 'request_favorites',
                            'action' => 'delete',
                            $request['Request']['slug']
                        ) , true);
                        exit;
                    }
                    $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular) . ' ' . __l('has been added to your Favorites') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'requests',
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular) . ' ' . __l('Favorite could not be added. Please, try again.') , 'default', null, 'error');
                }
            }
        } else {
			$this->Session->setFlash(sprintf(__l('You have already added this %s as your favorites') , requestAlternateName(ConstRequestAlternateName::Singular)) , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'requests',
                'action' => 'index'
            ));
        }
    }
    function delete($slug = null)
    {
        $request = $this->RequestFavorite->Request->find('first', array(
            'conditions' => array(
                'Request.slug = ' => $slug
            ) ,
            'recursive' => -1
        ));
        if (empty($request)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->RequestFavorite->find('first', array(
            'conditions' => array(
                'RequestFavorite.user_id' => $this->Auth->user('id') ,
                'RequestFavorite.request_id' => $request['Request']['id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($chkFavorites['RequestFavorite']['id'])) {
            $id = $chkFavorites['RequestFavorite']['id'];
            if ($this->RequestFavorite->delete($id)) {
                if ($this->RequestHandler->isAjax()) {
                    echo "removed|" . Router::url(array(
                        'controller' => 'request_favorites',
                        'action' => 'add',
                        $request['Request']['slug']
                    ) , true);
                    exit;
                }
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('removed from favorites') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'requests',
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
        $this->pageTitle = __l(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps)) . ' ' . __l('Favorites');
        $this->_redirectGET2Named(array(
            'q',
            'username',
        ));
        $conditions = array();
        if (!empty($this->request->params['named']['request'])) {
            $conditions['Request.slug'] = $this->request->params['named']['request'];
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
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['RequestFavorite.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - Today\'s Favorite');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['RequestFavorite.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - This Week\' Favorite');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['RequestFavorite.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - This Month\' Favorite');
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['RequestFavorite']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->RequestFavorite->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Request',
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
                'User'
            ) ,
            'order' => array(
                'RequestFavorite.id' => 'desc'
            )
        );
        if (isset($this->request->data['RequestFavorite']['q'])) {
            $this->paginate['search'] = $this->request->data['RequestFavorite']['q'];
        }
        $moreActions = $this->RequestFavorite->moreActions;
        $this->set(compact('moreActions'));
        $this->set('requestFavorites', $this->paginate());
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RequestFavorite->delete($id)) {
            $this->Session->setFlash(__l(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps)) . ' ' . __l('Favorite deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>