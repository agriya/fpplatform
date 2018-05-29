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
class DisputeClosedTypesController extends AppController
{
    public $name = 'DisputeClosedTypes';
    function index()
    {
        $this->pageTitle = __l('Dispute Closed Types');
        $this->DisputeClosedType->recursive = 0;
        $this->set('disputeClosedTypes', $this->paginate());
    }
    function view($id = null)
    {
        $this->pageTitle = __l('Dispute Closed Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $disputeClosedType = $this->DisputeClosedType->find('first', array(
            'conditions' => array(
                'DisputeClosedType.id = ' => $id
            ) ,
            'fields' => array(
                'DisputeClosedType.id',
                'DisputeClosedType.name',
            ) ,
            'recursive' => -1,
        ));
        if (empty($disputeClosedType)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $disputeClosedType['DisputeClosedType']['name'];
        $this->set('disputeClosedType', $disputeClosedType);
    }
    function add()
    {
        $this->pageTitle = __l('Add Dispute Closed Type');
        if (!empty($this->request->data)) {
            $this->DisputeClosedType->create();
            if ($this->DisputeClosedType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Closed Type has been added') , $this->request->data['DisputeClosedType']['name']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Closed Type could not be added. Please, try again.') , $this->request->data['DisputeClosedType']['name']) , 'default', null, 'error');
            }
        }
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit Dispute Closed Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->DisputeClosedType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Closed Type has been updated') , $this->request->data['DisputeClosedType']['name']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Closed Type could not be updated. Please, try again.') , $this->request->data['DisputeClosedType']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->DisputeClosedType->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['DisputeClosedType']['name'];
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->DisputeClosedType->delete($id)) {
            $this->Session->setFlash(__l('Dispute Closed Type deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function admin_index()
    {
        $this->pageTitle = __l('Dispute Closed Types');
        $this->DisputeClosedType->recursive = 0;
        $this->set('disputeClosedTypes', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Dispute Closed Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $disputeClosedType = $this->DisputeClosedType->find('first', array(
            'conditions' => array(
                'DisputeClosedType.id = ' => $id
            ) ,
            'fields' => array(
                'DisputeClosedType.id',
                'DisputeClosedType.name',
            ) ,
            'recursive' => -1,
        ));
        if (empty($disputeClosedType)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $disputeClosedType['DisputeClosedType']['name'];
        $this->set('disputeClosedType', $disputeClosedType);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Dispute Closed Type');
        if (!empty($this->request->data)) {
            $this->DisputeClosedType->create();
            if ($this->DisputeClosedType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Closed Type has been added') , $this->request->data['DisputeClosedType']['name']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Closed Type could not be added. Please, try again.') , $this->request->data['DisputeClosedType']['name']) , 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Dispute Closed Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->DisputeClosedType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Closed Type has been updated') , $this->request->data['DisputeClosedType']['name']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Dispute Closed Type could not be updated. Please, try again.') , $this->request->data['DisputeClosedType']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->DisputeClosedType->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['DisputeClosedType']['name'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->DisputeClosedType->delete($id)) {
            $this->Session->setFlash(__l('Dispute Closed Type deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>