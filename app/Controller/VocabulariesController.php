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
class VocabulariesController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Vocabularies';
    public function admin_index()
    {
        $this->pageTitle = __l('Vocabularies');
        $this->Vocabulary->recursive = 0;
        $this->paginate['Vocabulary']['order'] = 'Vocabulary.weight ASC';
        $this->set('vocabularies', $this->paginate());
    }
    public function admin_add()
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Vocabulary'));
        if (!empty($this->request->data)) {
            $this->Vocabulary->create();
            if ($this->Vocabulary->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Vocabulary')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Vocabulary')) , 'default', null, 'error');
            }
        }
        $types = $this->Vocabulary->Type->find('list');
        $this->set(compact('types'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Vocabulary'));
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Vocabulary')) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (!empty($this->request->data)) {
            if ($this->Vocabulary->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Vocabulary')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Vocabulary')) , 'default', null, 'error');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Vocabulary->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Vocabulary']['title'];
        $types = $this->Vocabulary->Type->find('list');
        $this->set(compact('types'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Vocabulary->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Vocabulary')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_moveup($id, $step = 1)
    {
        if ($this->Vocabulary->moveUp($id, $step)) {
            $this->Session->setFlash(__l('Moved up successfully') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('Could not move up') , 'default', null, 'error');
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    public function admin_movedown($id, $step = 1)
    {
        if ($this->Vocabulary->moveDown($id, $step)) {
            $this->Session->setFlash(__l('Moved down successfully') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('Could not move down') , 'default', null, 'error');
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }
}
