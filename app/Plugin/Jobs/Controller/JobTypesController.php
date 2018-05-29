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
class JobTypesController extends AppController
{
    public $name = 'JobTypes';
    function index()
    {
        $this->pageTitle =  sprintf(__l('%s Types'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps));
        $conditions = array();
        $this->paginate = array(
            'conditions' => array(
                'JobType.is_active' => 1
            ) ,
            'fields' => array(
                'JobType.id',
                'JobType.name',
                'JobType.job_count',
                'JobType.request_count',
				'JobType.job_category_id'
            ) ,
            'contain' => array(
                'JobCategory'
            ) ,
            'recursive' => 1
        );
        $this->set('jobTypes', $this->paginate());
    }
    function admin_index()
    {
        $this->pageTitle = sprintf(__l('%s Types'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps));
        $conditions = array();
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['JobType']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        $this->JobType->recursive = 0;
        $this->set('jobTypes', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Job Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $jobType = $this->JobType->find('first', array(
            'conditions' => array(
                'JobType.id = ' => $id
            ) ,
            'fields' => array(
                'JobType.id',
                'JobType.name',
                'JobType.job_count',
            ) ,
            'recursive' => -1,
        ));
        if (empty($jobType)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $jobType['JobType']['name'];
        $this->set('jobType', $jobType);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Job Type');
        if (!empty($this->request->data)) {
            $this->JobType->create();
            if ($this->JobType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Job Type has been added') , $this->request->data['JobType']['name']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Job Type could not be added. Please, try again.') , $this->request->data['JobType']['name']) , 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Job Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->JobType->save($this->request->data)) {
                $_data = array();
                if ($id == ConstJobType::Online) {
                    $_data['Setting']['id'] = 347;
                    if ($this->request->data['JobType']['is_active']) {
                        $_data['Setting']['value'] = 1;
                    } else {
                        $_data['Setting']['value'] = 0;
                    }
                } else {
                    $_data['Setting']['id'] = 348;
                    if ($this->request->data['JobType']['is_active']) {
                        $_data['Setting']['value'] = 1;
                    } else {
                        $_data['Setting']['value'] = 0;
                    }
                }
                App::import('Model', 'Setting');
                $this->Setting = new Setting();
                $this->Setting->save($_data);
                $this->Session->setFlash(sprintf(__l('"%s" Job Type has been updated') , $this->request->data['JobType']['name']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Job Type could not be updated. Please, try again.') , $this->request->data['JobType']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->JobType->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['JobType']['name'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->JobType->delete($id)) {
            $this->Session->setFlash(__l('Job Type deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>