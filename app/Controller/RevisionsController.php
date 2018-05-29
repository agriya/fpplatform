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
class RevisionsController extends AppController
{
    public $name = 'Revisions';
    function index()
    {
        $this->pageTitle = __l('Revisions');
        $this->Revision->recursive = 0;
        $this->set('revisions', $this->paginate());
    }
    function view($id = null)
    {
        $this->pageTitle = __l('Revision');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $revision = $this->Revision->find('first', array(
            'conditions' => array(
                'Revision.id = ' => $id
            ) ,
            'fields' => array(
                'Revision.id',
                'Revision.type',
                'Revision.node_id',
                'Revision.content',
                'Revision.revision_number',
                'Revision.user_id',
                'Revision.created',
            ) ,
            'recursive' => -1,
        ));
        if (empty($revision)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $revision['Revision']['id'];
        $this->set('revision', $revision);
    }
    function add()
    {
        $this->pageTitle = __l('Add Revision');
        if (!empty($this->request->data)) {
            $this->Revision->create();
            if ($this->Revision->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Revision has been added') , $this->request->data['Revision']['id']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Revision could not be added. Please, try again.') , $this->request->data['Revision']['id']) , 'default', null, 'error');
            }
        }
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit Revision');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->Revision->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Revision has been updated') , $this->request->data['Revision']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Revision could not be updated. Please, try again.') , $this->request->data['Revision']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Revision->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Revision']['id'];
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Revision->delete($id)) {
            $this->Session->setFlash(__l('Revision deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function admin_index()
    {
        $this->pageTitle = __l('Revisions');
        $this->Revision->recursive = 0;
        $this->set('revisions', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Revision');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $revision = $this->Revision->find('first', array(
            'conditions' => array(
                'Revision.id = ' => $id
            ) ,
            'fields' => array(
                'Revision.id',
                'Revision.type',
                'Revision.node_id',
                'Revision.content',
                'Revision.revision_number',
                'Revision.user_id',
                'Revision.created',
            ) ,
            'recursive' => -1,
        ));
        if (empty($revision)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $revision['Revision']['id'];
        $this->set('revision', $revision);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Revision');
        if (!empty($this->request->data)) {
            $this->Revision->create();
            if ($this->Revision->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Revision has been added') , $this->request->data['Revision']['id']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Revision could not be added. Please, try again.') , $this->request->data['Revision']['id']) , 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Revision');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->Revision->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Revision has been updated') , $this->request->data['Revision']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Revision could not be updated. Please, try again.') , $this->request->data['Revision']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Revision->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Revision']['id'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Revision->delete($id)) {
            $this->Session->setFlash(__l('Revision deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>