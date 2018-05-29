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
class UserOpenidsController extends AppController
{
    public $name = 'UserOpenids';
    public $components = array(
        'Openid'
    );
    function beforeFilter()
    {
        if (!Configure::read('openid.is_enabled_openid_connect')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        parent::beforeFilter();
    }
    function index()
    {
        $this->pageTitle = __l('User Openids');
        $this->paginate = array(
            'conditions' => array(
                'UserOpenid.user_id' => $this->Auth->user('id')
            )
        );
        $this->UserOpenid->recursive = -1;
        $this->set('userOpenids', $this->paginate());
    }
    function add()
    {
        $this->pageTitle = __l('Add New Openid');
        if (!empty($this->request->data)) {
            $this->UserOpenid->set($this->request->data);
            if ($this->UserOpenid->validates()) {
                // send to openid function with open id url and redirect page
                if ((!empty($this->request->data['UserOpenid']['openid']) && $this->request->data['UserOpenid']['openid'] != 'Click to Sign In' && $this->request->data['UserOpenid']['openid'] != 'http://')) {
                    $check = true;
                    if ($this->Auth->user('role_id') == ConstUserTypes::Admin && !$this->request->data['UserOpenid']['verify']) {
                        $check = false;
                    }
                    if ($check) {
                        $this->request->data['UserOpenid']['redirect_page'] = 'add';
                        $this->_openid();
                    }
                }
            }
        }
        // handle the fields return from openid
        if (count($_GET) > 1) {
            $returnTo = Router::url(array(
                'controller' => 'user_openids',
                'action' => 'add'
            ) , true);
            $response = $this->Openid->getResponse($returnTo);
            if ($response->status == Auth_OpenID_SUCCESS) {
                $this->request->data['UserOpenid']['openid'] = $response->identity_url;
                $this->request->data['UserOpenid']['user_id'] = $this->Auth->user('id');
            } else {
                $this->Session->setFlash(__l('Authenticated failed or you may not have profile in your OpenID account'));
            }
        }
        // check the auth user id is set in the useropenid data
        if (!empty($this->request->data['UserOpenid']['user_id'])) {
            $this->UserOpenid->create();
            if ($this->UserOpenid->save($this->request->data)) {
                $this->Session->setFlash(__l('User Openid has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Openid could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $users = $this->UserOpenid->User->find('list');
            $this->set(compact('users'));
        }
    }
    function _openid()
    {
        $returnTo = Router::url(array(
            'controller' => 'user_openids',
            'action' => $this->request->data['UserOpenid']['redirect_page']
        ) , true);
        $siteURL = Router::url(array(
            '/'
        ) , true);
        // send openid url and fields return to our server from openid
        if (!empty($this->request->data)) {
            try {
                $this->Openid->authenticate($this->request->data['UserOpenid']['openid'], $returnTo, $siteURL, array() , array());
            }
            catch(InvalidArgumentException $e) {
                $this->Session->setFlash(__l('Invalid OpenID') , 'default', null, 'error');
            }
            catch(Exception $e) {
                $this->Session->setFlash(__l($e->getMessage()));
            }
        }
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->UserOpenid->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.is_openid_register'
            ) ,
            'recursive' => -1
        ));
        //Condition added to check user should have atleast one OpenID account for login
        if ($this->UserOpenid->find('count', array(
            'conditions' => array(
                'UserOpenid.user_id' => $this->Auth->user('id')
            )
        )) > 1 || $user['User']['is_openid_register'] == 0) {
            if ($this->UserOpenid->delete($id)) {
                $this->Session->setFlash(__l('User Openid deleted') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        } else {
            $this->Session->setFlash(__l('Sorry, you registered through OpenID account. So you should have atleast one OpenID account for login') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'username',
            'q'
        ));
        $this->pageTitle = __l('User Openids');
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
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['UserOpenid']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->UserOpenid->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'UserOpenid.id',
                'UserOpenid.created',
                'UserOpenid.user_id',
                'UserOpenid.openid',
                'User.username'
            ) ,
            'order' => array(
                'UserOpenid.id' => 'desc'
            ) ,
        );
        if (isset($this->request->data['UserOpenid']['q'])) {
            $this->paginate['search'] = $this->request->data['UserOpenid']['q'];
        }
        $this->set('userOpenids', $this->paginate());
        $moreActions = $this->UserOpenid->moreActions;
        $this->set(compact('moreActions'));
    }
    function admin_add()
    {
        $this->setAction('add');
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserOpenid->delete($id)) {
            $this->Session->setFlash(__l('User Openid deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
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
                    $this->{$this->modelClass}->deleteAll(array(
                        $this->modelClass . '.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked user OpenIDs has been deleted') , 'default', null, 'success');
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
}
?>