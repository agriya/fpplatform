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
class MenusController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Menus';
    public function admin_index()
    {
        $this->pageTitle = __l('Menus');
        $this->Menu->recursive = 0;
        $this->paginate['Menu']['order'] = 'Menu.id ASC';
        $this->set('menus', $this->paginate());
    }
    public function admin_add()
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Menu'));
        if (!empty($this->request->data)) {
            $this->Menu->create();
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Menu')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Menu')) , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Menu'));
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Menu')) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (!empty($this->request->data)) {
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Menu')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Menu')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Menu->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Menu']['title'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Menu->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Menu')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
