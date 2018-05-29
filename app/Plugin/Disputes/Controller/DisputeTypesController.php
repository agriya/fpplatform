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
class DisputeTypesController extends AppController
{
    public $name = 'DisputeTypes';
    function admin_index()
    {
        $this->pageTitle = __l('Dispute Types');
        $this->DisputeType->recursive = 0;
        $this->paginate = array(
            'order' => array(
                'DisputeType.id' => 'desc'
            )
        );
        $this->set('disputeTypes', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Dispute Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $disputeType = $this->DisputeType->find('first', array(
            'conditions' => array(
                'DisputeType.id = ' => $id
            ) ,
            'fields' => array(
                'DisputeType.id',
                'DisputeType.created',
                'DisputeType.modified',
                'DisputeType.name',
                'DisputeType.job_user_type_id',
                'DisputeType.is_active',
                'JobUserType.id',
                'JobUserType.name',
            ) ,
            'recursive' => 0,
        ));
        if (empty($disputeType)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $disputeType['DisputeType']['name'];
        $this->set('disputeType', $disputeType);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Dispute Type');
        if (!empty($this->request->data)) {
            $this->DisputeType->create();
            if ($this->DisputeType->save($this->request->data)) {
                $this->Session->setFlash(__l('Dispute Type has been added.') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Dispute Type could not be updated. Please, try again.') , 'default', null, 'error');
            }
        }
        $jobUserTypes = $this->DisputeType->JobUserType->find('list');
        $this->set(compact('jobUserTypes'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Dispute Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->DisputeType->save($this->request->data)) {
                $this->Session->setFlash(__l(' Dispute Type has been updated.') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Type could not be updated. Please, try again.') , $this->request->data['DisputeType']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->DisputeType->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['DisputeType']['name'];
        $jobUserTypes = $this->DisputeType->JobUserType->find('list');
        $this->set(compact('jobUserTypes'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->DisputeType->delete($id)) {
            $this->Session->setFlash(__l('Dispute Type deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>