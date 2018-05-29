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
class DisputeStatusesController extends AppController
{
    public $name = 'DisputeStatuses';
    function admin_index()
    {
        $this->pageTitle = __l('Dispute Statuses');
        $this->DisputeStatus->recursive = 0;
        $this->set('disputeStatuses', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Dispute Status');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $disputeStatus = $this->DisputeStatus->find('first', array(
            'conditions' => array(
                'DisputeStatus.id = ' => $id
            ) ,
            'fields' => array(
                'DisputeStatus.id',
                'DisputeStatus.created',
                'DisputeStatus.modified',
                'DisputeStatus.name',
            ) ,
            'recursive' => -1,
        ));
        if (empty($disputeStatus)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $disputeStatus['DisputeStatus']['name'];
        $this->set('disputeStatus', $disputeStatus);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Dispute Status');
        if (!empty($this->request->data)) {
            $this->DisputeStatus->create();
            if ($this->DisputeStatus->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Status has been added') , $this->request->data['DisputeStatus']['name']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Status could not be added. Please, try again.') , $this->request->data['DisputeStatus']['name']) , 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Dispute Status');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->DisputeStatus->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Status has been updated') , $this->request->data['DisputeStatus']['name']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Status could not be updated. Please, try again.') , $this->request->data['DisputeStatus']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->DisputeStatus->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['DisputeStatus']['name'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->DisputeStatus->delete($id)) {
            $this->Session->setFlash(__l('Dispute Status deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>