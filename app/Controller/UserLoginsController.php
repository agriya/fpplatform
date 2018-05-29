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
class UserLoginsController extends AppController
{
    public $name = 'UserLogins';
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'user_id',
            'q'
        ));
        $conditions = array();
        $this->pageTitle = __l('User Logins');
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
            $this->request->data['User']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['UserLogin.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - Login today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['UserLogin.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Login in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['UserLogin.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Login in this month');
        }
        if (!empty($this->request->data['User']['filter_id'])) {
            if ($this->request->data['User']['filter_id'] == ConstMoreAction::OpenID) {
                $conditions['User.is_openid_register'] = 1;
                $this->pageTitle.= __l(' - Login through OpenID ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Gmail) {
                $conditions['User.is_google_register'] = 1;
                $this->pageTitle.= __l(' - Login through Gmail ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Yahoo) {
                $conditions['User.is_yahoo_register'] = 1;
                $this->pageTitle.= __l(' - Login through Yahoo ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Active) {
                $conditions['User.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Twitter) {
                $conditions['User.twitter_user_id != '] = 0;
                $this->pageTitle.= __l(' - Login through Twitter ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Facebook) {
                $conditions['User.fb_user_id !='] = 0;
                $this->pageTitle.= __l(' - Login through Facebook ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['User.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::NotifiedInactiveUsers) {
                $conditions['User.last_sent_inactive_mail !='] = NULL;
                $this->pageTitle.= __l(' - Notified Inactive Users ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Normal) {
                $conditions['User.fb_user_id'] = 0;
                $conditions['User.twitter_user_id'] = 0;
                $conditions['User.is_openid_register'] = 0;
                $this->pageTitle.= __l(' - Normal Users ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['User']['filter_id'];
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Ip.ip LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'UserLogin.user_agent LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['UserLogin']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->set('page_title', $this->pageTitle);
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
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
                'UserLogin.id' => 'desc'
            ) ,
            'recursive' => 2,
        );
        if (isset($this->request->data['UserLogin']['q'])) {
            $this->paginate['search'] = $this->request->data['UserLogin']['q'];
        }
        $this->set('userLogins', $this->paginate());
        $moreActions = $this->UserLogin->moreActions;
        $this->set(compact('moreActions'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserLogin->delete($id)) {
            $this->Session->setFlash(__l('User Login deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>