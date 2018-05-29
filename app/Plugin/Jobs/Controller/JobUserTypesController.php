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
class JobUserTypesController extends AppController
{
    public $name = 'JobUserTypes';
    function admin_index()
    {
        $this->pageTitle = __l('Job User Types');
        $this->JobUserType->recursive = 0;
        $this->set('jobUserTypes', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Job User Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $jobUserType = $this->JobUserType->find('first', array(
            'conditions' => array(
                'JobUserType.id = ' => $id
            ) ,
            'fields' => array(
                'JobUserType.id',
                'JobUserType.name',
            ) ,
            'recursive' => -1,
        ));
        if (empty($jobUserType)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $jobUserType['JobUserType']['name'];
        $this->set('jobUserType', $jobUserType);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Job User Type');
        if (!empty($this->request->data)) {
            $this->JobUserType->create();
            if ($this->JobUserType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Job User Type has been added') , $this->request->data['JobUserType']['name']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Job User Type could not be added. Please, try again.') , $this->request->data['JobUserType']['name']) , 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Job User Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->JobUserType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Job User Type has been updated') , $this->request->data['JobUserType']['name']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Job User Type could not be updated. Please, try again.') , $this->request->data['JobUserType']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->JobUserType->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['JobUserType']['name'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->JobUserType->delete($id)) {
            $this->Session->setFlash(__l('Job User Type deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>