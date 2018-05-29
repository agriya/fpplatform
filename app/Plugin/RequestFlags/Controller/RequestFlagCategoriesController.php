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
class RequestFlagCategoriesController extends AppController
{
    public $name = 'RequestFlagCategories';
    function beforeFilter()
    {
        parent::beforeFilter();
    }
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'filter_id'
        ));
        $this->pageTitle = requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('Flag Categories');
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
        $this->RequestFlagCategory->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'RequestFlagCategory.id',
                'RequestFlagCategory.name',
                'RequestFlagCategory.request_flag_count',
                'RequestFlagCategory.is_active'
            ) ,
            'order' => array(
                'RequestFlagCategory.id' => 'desc'
            )
        );
        $this->set('requestFlagCategories', $this->paginate());
        $filters = $this->RequestFlagCategory->isFilterOptions;
        $moreActions = $this->RequestFlagCategory->moreActions;
        $this->set(compact('moreActions', 'filters'));
        $this->set('pending', $this->RequestFlagCategory->find('count', array(
            'conditions' => array(
                'RequestFlagCategory.is_active' => 0
            )
        )));
        $this->set('approved', $this->RequestFlagCategory->find('count', array(
            'conditions' => array(
                'RequestFlagCategory.is_active' => 1
            )
        )));
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Request Flag Category');
        if (!empty($this->request->data)) {
            $this->RequestFlagCategory->create();
            if ($this->RequestFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('Flag Category has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('Flag Category could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $users = $this->RequestFlagCategory->User->find('list');
        $this->set(compact('users'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Request Flag Category');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->RequestFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('Flag Category has been updated.') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('Flag Category could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->RequestFlagCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['RequestFlagCategory']['name'];
        $users = $this->RequestFlagCategory->User->find('list');
        $this->set(compact('users'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RequestFlagCategory->delete($id)) {
            $this->Session->setFlash(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) . ' ' . __l('Flag Category deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>