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
class SiteCategoriesController extends AppController
{
    public $name = 'SiteCategories';
    function admin_index()
    {
        $this->pageTitle = __l('Site Categories');
        $this->SiteCategory->recursive = 0;
        $this->set('siteCategories', $this->paginate());
    }
    function admin_view($slug = null)
    {
        $this->pageTitle = __l('Site Category');
        if (is_null($slug)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $siteCategory = $this->SiteCategory->find('first', array(
            'conditions' => array(
                'SiteCategory.slug = ' => $slug
            ) ,
            'fields' => array(
                'SiteCategory.id',
                'SiteCategory.created',
                'SiteCategory.modified',
                'SiteCategory.name',
                'SiteCategory.slug',
                'SiteCategory.is_active',
            ) ,
            'recursive' => -1,
        ));
        if (empty($siteCategory)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $siteCategory['SiteCategory']['name'];
        $this->set('siteCategory', $siteCategory);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Site Category');
        if (!empty($this->request->data)) {
            $this->SiteCategory->create();
            if ($this->SiteCategory->save($this->request->data)) {
                $this->Session->setFlash(__l('Site Category has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Site Category could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Site Category');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->SiteCategory->save($this->request->data)) {
                $this->Session->setFlash(__l('Site Category has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Site Category could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->SiteCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['SiteCategory']['name'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->SiteCategory->delete($id)) {
            $this->Session->setFlash(__l('Site Category deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>