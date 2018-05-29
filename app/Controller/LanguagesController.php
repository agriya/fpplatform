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
class LanguagesController extends AppController
{
    public $name = 'Languages';
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'filter_id',
            'q'
        ));
        $this->pageTitle = __l('Languages');
        $conditions = array();
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data[$this->modelClass]['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data[$this->modelClass]['filter_id'])) {
            if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Active) {
                $conditions[$this->modelClass . '.is_active'] = 1;
                $this->pageTitle.= __l(' - Approved');
            } else if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Inactive) {
                $conditions[$this->modelClass . '.is_active'] = 0;
                $this->pageTitle.= __l(' - Unapproved');
            }
            $this->request->params['named']['filter_id'] = $this->request->data[$this->modelClass]['filter_id'];
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data[$this->modelClass]['q'] = $this->request->params['named']['q'];
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions['OR'][] = array(
                'Language.name LIKE ' => '%' . $this->request->params['named']['q'] . '%'
            );
            $this->request->data['Language']['q'] = $this->request->params['named']['q'];
        }
        $this->Language->recursive = -1;
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'Language.name' => 'asc'
            )
        );
        $this->set('languages', $this->paginate());
        $this->set('pending', $this->Language->find('count', array(
            'conditions' => array(
                'Language.is_active = ' => 0
            ) ,
            'recursive' => -1
        )));
        $this->set('approved', $this->Language->find('count', array(
            'conditions' => array(
                'Language.is_active = ' => 1
            ) ,
            'recursive' => -1
        )));
        $filters = $this->Language->isFilterOptions;
        $moreActions = $this->Language->moreActions;
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                unset($moreActions[ConstMoreAction::Active]);
            } elseif ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                unset($moreActions[ConstMoreAction::Inactive]);
            }
        }
        $this->set(compact('moreActions', 'filters'));
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Language');
        if (!empty($this->request->data)) {
            $this->Language->create();
            if ($this->Language->save($this->request->data)) {
                $this->Session->setFlash(__l('Language has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Language could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Language');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->Language->save($this->request->data)) {
                $this->Session->setFlash(__l('Language  has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Language  could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Language->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Language']['name'];
    }
    public function change_language()
    {
        $this->request->data['Language']['language_id'] = !empty($this->request->params['named']['language_id']) ? $this->request->params['named']['language_id'] : '';
        $this->request->data['Language']['f'] = !empty($this->request->params['named']['f']) ? $this->request->params['named']['f'] : $_GET['f'];
        if (!empty($this->request->data)) {
            if ($this->Auth->user('id')) {
                $this->Cookie->write('user_language', $this->request->data['Language']['language_id'], false);
            } else {
                $this->Cookie->write('user_language', $this->request->data['Language']['language_id'], false, time() +60*60*4);
            }
            if ($this->request->data['Language']['f'] == 'users/show_header.js') {
                $this->request->data['Language']['f'] = '';
            }
            $this->redirect(Router::url('/', true) . $this->request->data['Language']['f']);
        } else {
            $this->redirect(Router::url('/', true) . $this->request->params['named']['city']);
        }
    }
}
?>