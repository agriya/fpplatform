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
class ContactTypesController extends AppController
{
    public $name = 'ContactTypes';
    function admin_index()
    {
        $this->pageTitle = __l('Contact Types');
        $this->ContactType->recursive = 0;
        $this->paginate = array(
            'order' => array(
                'ContactType.id' => 'desc'
            )
        );
        $moreActions = $this->ContactType->moreActions;
        $this->set(compact('moreActions'));
        $this->set('contactTypes', $this->paginate());
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Contact Type');
        if (!empty($this->request->data)) {
            $this->ContactType->create();
            if ($this->ContactType->save($this->request->data)) {
                $this->Session->setFlash(__l('Contact Type has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Contact Type could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Contact Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->ContactType->save($this->request->data)) {
                $this->Session->setFlash(__l('Contact Type has been updated.') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Contact Type could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->ContactType->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['ContactType']['name'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ContactType->delete($id)) {
            $this->Session->setFlash(__l('Contact Type deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>