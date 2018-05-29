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
class JobCategoriesController extends AppController
{
    public $name = 'JobCategories';
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Attachment.filename',
        );
        parent::beforeFilter();
    }
    function index()
    {
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Categories');
        $this->JobCategory->recursive = -1;
        $conditions['JobCategory.is_active'] = 1;
        if (!empty($this->request->params['named']['type'])) {
            $conditions['JobCategory.job_type_id'] = $this->request->params['named']['type'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'JobCategory.name' => 'asc'
            )
        );
        //Get the online job count
        $jobcounts = $this->JobCategory->JobType->find('all', array(
            'fields' => array(
                'JobType.job_count',
                'JobType.request_count'
            ) ,
            'recursive' => -1
        ));
        if (!empty($this->request->params['named']['display']) && $this->request->params['named']['display'] == 'requests') {
            $online = $jobcounts[0]['JobType']['request_count'];
            $offline = $jobcounts[1]['JobType']['request_count'];
        } else {
            $online = $jobcounts[0]['JobType']['job_count'];
            $offline = $jobcounts[1]['JobType']['job_count'];
        }
        $this->set('jobCategories', $this->paginate());
        $this->set(compact('online', 'offline'));
    }
    function listing()
    {
        $jobCategories = $this->JobCategory->find('list', array(
            'conditions' => array(
                'JobCategory.job_type_id' => $this->request->params['named']['id'],
                'JobCategory.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        $this->set(compact('jobCategories'));
    }
    function admin_index()
    {
        $this->pageTitle = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Categories');
        $conditions = array();
        if (isset($this->request->params['named']['job_type_id'])) {
            $this->pageTitle.= jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' - ' . __l('Type') . ' - ';
            $this->pageTitle.= ($this->request->params['named']['job_type_id'] == ConstJobType::Online) ? __l('Online') : __l('Offline');
            $this->request->data['JobCategory']['job_type_id'] = $this->request->params['named']['job_type_id'];
            $conditions['JobCategory.job_type_id'] = $this->request->params['named']['job_type_id'];
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['JobCategory.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['JobCategory.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }		
        $this->JobCategory->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'JobCategory.id' => 'desc'
            )
        );
        $this->set('active', $this->JobCategory->find('count', array(
            'conditions' => array(
                'JobCategory.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive', $this->JobCategory->find('count', array(
            'conditions' => array(
                'JobCategory.is_active' => 0
            ) ,
            'recursive' => -1
        )));
		
        $moreActions = $this->JobCategory->moreActions;
        $this->set(compact('moreActions'));
        $this->set('jobCategories', $this->paginate());
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Category');
        $this->JobCategory->Attachment->Behaviors->attach('ImageUpload', Configure::read('job_category.file'));
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['Attachment']['filename']['name'])) {
                $this->request->data['Attachment']['filename']['type'] = get_mime($this->request->data['Attachment']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['Attachment']['filename']['name']) || (!Configure::read('job_category.file.allowEmpty') && empty($this->request->data['Attachment']['id']))) {
                $this->JobCategory->Attachment->set($this->request->data);
            }
            $ini_upload_error = 1;
            if ($this->request->data['Attachment']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            $this->JobCategory->set($this->request->data);
            if ($this->JobCategory->validates() &$this->JobCategory->Attachment->validates() && $ini_upload_error) {
                $this->JobCategory->create();
                $this->JobCategory->save($this->request->data);
                if (!empty($this->request->data['Attachment']['filename']['name'])) {
                    $this->JobCategory->Attachment->create();
                    $this->request->data['Attachment']['class'] = 'JobCategory';
                    $this->request->data['Attachment']['foreign_id'] = $this->JobCategory->getLastInsertId();
                    $this->JobCategory->Attachment->save($this->request->data['Attachment']);
                }
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Category has been added.') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'job_categories',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Category could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $job_types = $this->JobCategory->JobType->find('list');
        $this->set(compact('job_types'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit') . ' ' . jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Category');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->JobCategory->save($this->request->data)) {
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Category has been updated.') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'job_categories',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Category could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->JobCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['JobCategory']['name'];
        $job_types = $this->JobCategory->JobType->find('list');
        $this->set(compact('job_types'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->JobCategory->delete($id)) {
            $this->Session->setFlash(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Category deleted') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'job_categories',
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>