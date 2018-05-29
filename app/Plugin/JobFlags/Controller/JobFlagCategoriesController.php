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
class JobFlagCategoriesController extends AppController
{
    public $name = 'JobFlagCategories';
    function beforeFilter()
    {
        parent::beforeFilter();
    }
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'filter_id'
        ));
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Flag Categories');
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
        $this->JobFlagCategory->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'JobFlagCategory.id',
                'JobFlagCategory.name',
                'JobFlagCategory.job_flag_count',
                'JobFlagCategory.is_active'
            ) ,
            'order' => array(
                'JobFlagCategory.id' => 'desc'
            )
        );
        $this->set('jobFlagCategories', $this->paginate());
        $filters = $this->JobFlagCategory->isFilterOptions;
        $moreActions = $this->JobFlagCategory->moreActions;
        $this->set(compact('moreActions', 'filters'));
        $this->set('pending', $this->JobFlagCategory->find('count', array(
            'conditions' => array(
                'JobFlagCategory.is_active' => 0
            )
        )));
        $this->set('approved', $this->JobFlagCategory->find('count', array(
            'conditions' => array(
                'JobFlagCategory.is_active' => 1
            )
        )));
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Flag Category');
        if (!empty($this->request->data)) {
            $this->JobFlagCategory->create();
            if ($this->JobFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Flag Category has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Flag Category could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Flag Category');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->JobFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Flag Category has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Flag Category could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->JobFlagCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['JobFlagCategory']['name'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->JobFlagCategory->delete($id)) {
            $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Flag Category deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>