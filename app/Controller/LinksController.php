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
class LinksController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Links';
    /**
     * Menu ID
     *
     * holds the current menu ID (if any)
     *
     * @var string
     * @access public
     */
    public $menuId = '';
    public function admin_index($menuId = null)
    {
        if (!$menuId) {
            $this->redirect(array(
                'controller' => 'menus',
                'action' => 'index',
            ));
            return;
        }
        $menu = $this->Link->Menu->findById($menuId);
        if (!isset($menu['Menu']['id'])) {
            $this->redirect(array(
                'controller' => 'menus',
                'action' => 'index',
            ));
            return;
        }
        $this->pageTitle = sprintf(__l('%s: %s') , __l('Links') , $menu['Menu']['title']);
        $this->Link->recursive = 0;
        $linksTree = $this->Link->generateTreeList(array(
            'Link.menu_id' => $menuId,
        ));
        $linksStatus = $this->Link->find('list', array(
            'conditions' => array(
                'Link.menu_id' => $menuId,
            ) ,
            'fields' => array(
                'Link.id',
                'Link.status',
            ) ,
        ));
        $this->set(compact('linksTree', 'linksStatus', 'menu'));
        $moreActions = $this->Link->moreActions;
        $this->set('moreActions', $moreActions);
    }
    public function admin_add($menuId = null)
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Link'));
        if (!empty($this->request->data)) {
            $this->Link->create();
            $this->Link->Behaviors->attach('Tree', array(
                'scope' => array(
                    'Link.menu_id' => $this->request->data['Link']['menu_id'],
                ) ,
            ));
            if ($this->Link->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Link')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index',
                    $this->request->data['Link']['menu_id']
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Link')) , 'default', null, 'error');
            }
        }
        $menu = $this->Link->Menu->find('first', array(
            'conditions' => array(
                'Menu.id' => $menuId,
            ) ,
            'recursive' => -1
        ));
        $this->pageTitle.= ' - ' . $menu['Menu']['title'];
        $menus = $this->Link->Menu->find('list');
        $parentLinks = $this->Link->generateTreeList(array(
            'Link.menu_id' => $menuId,
        ));
        $this->set(compact('menus', 'parentLinks', 'menuId'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Link'));
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Link')) , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'menus',
                'action' => 'index',
            ));
        }
        if (!empty($this->request->data)) {
            $this->Link->Behaviors->attach('Tree', array(
                'scope' => array(
                    'Link.menu_id' => $this->request->data['Link']['menu_id'],
                ) ,
            ));
            if ($this->Link->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Link')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index',
                    $this->request->data['Link']['menu_id']
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Link')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Link->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $menus = $this->Link->Menu->find('list');
        $menu = $this->Link->Menu->findById($this->request->data['Link']['menu_id']);
        $parentLinks = $this->Link->generateTreeList(array(
            'Link.menu_id' => $menu['Menu']['id'],
        ));
        $menuId = $menu['Menu']['id'];
        $this->pageTitle.= ' - ' . $this->request->data['Link']['title'];
        $this->set(compact('menus', 'parentLinks', 'menuId'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $link = $this->Link->findById($id);
        if (!isset($link['Link']['id'])) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Link')) , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'menus',
                'action' => 'index',
            ));
        }
        $this->Link->Behaviors->attach('Tree', array(
            'scope' => array(
                'Link.menu_id' => $link['Link']['menu_id'],
            ) ,
        ));
        if ($this->Link->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Link')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index',
                $link['Link']['menu_id'],
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_moveup($id, $step = 1)
    {
        $link = $this->Link->findById($id);
        if (!isset($link['Link']['id'])) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Link')) , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'menus',
                'action' => 'index',
            ));
        }
        $this->Link->Behaviors->attach('Tree', array(
            'scope' => array(
                'Link.menu_id' => $link['Link']['menu_id'],
            ) ,
        ));
        if ($this->Link->moveUp($id, $step)) {
            $this->Session->setFlash(__l('Moved up successfully') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('Could not move up') , 'default', null, 'error');
        }
        $this->redirect(array(
            'action' => 'index',
            $link['Link']['menu_id'],
        ));
    }
    public function admin_movedown($id, $step = 1)
    {
        $link = $this->Link->findById($id);
        if (!isset($link['Link']['id'])) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Link')) , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'menus',
                'action' => 'index',
            ));
        }
        $this->Link->Behaviors->attach('Tree', array(
            'scope' => array(
                'Link.menu_id' => $link['Link']['menu_id'],
            ) ,
        ));
        if ($this->Link->moveDown($id, $step)) {
            $this->Session->setFlash(__l('Moved down successfully') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('Could not move down') , 'default', null, 'error');
        }
        $this->redirect(array(
            'action' => 'index',
            $link['Link']['menu_id'],
        ));
    }
    public function admin_process($menuId = null)
    {
        $action = $this->request->data['Link']['action'];
        $ids = array();
        foreach($this->request->data['Link'] as $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }
        if (count($ids) == 0 || $action == null) {
            $this->Session->setFlash(__l('No items selected.') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index',
                $menuId,
            ));
        }
        $menu = $this->Link->Menu->findById($menuId);
        if (!isset($menu['Menu']['id'])) {
            $this->redirect(array(
                'controller' => 'menus',
                'action' => 'index',
            ));
        }
        $this->Link->Behaviors->attach('Tree', array(
            'scope' => array(
                'Link.menu_id' => $menuId,
            ) ,
        ));
        if ($action == 'delete' && $this->Link->deleteAll(array(
            'Link.id' => $ids
        ) , true, true)) {
            $this->Session->setFlash(__l('Checked records has been deleted') , 'default', null, 'success');
        } elseif ($action == 'publish' && $this->Link->updateAll(array(
            'Link.status' => 1
        ) , array(
            'Link.id' => $ids
        ))) {
            $this->Session->setFlash(__l('Checked records has been published') , 'default', null, 'success');
        } elseif ($action == 'unpublish' && $this->Link->updateAll(array(
            'Link.status' => 0
        ) , array(
            'Link.id' => $ids
        ))) {
            $this->Session->setFlash(__l('Checked records has been unpublished') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('An error occurred.') , 'default', null, 'error');
        }
        $this->redirect(array(
            'action' => 'index',
            $menuId,
        ));
    }
}
