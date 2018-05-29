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
class LabelsUsersController extends AppController
{
    public $name = 'LabelsUsers';
    public $uses = array(
        'LabelsUser',
        'Label'
    );
    function index()
    {
        $this->pageTitle = __l('Labels Users');
        $this->paginate = array(
            'conditions' => array(
                'LabelsUser.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => 2
        );
        $this->set('labelsUsers', $this->paginate());
    }
    function add()
    {
        $this->pageTitle = __l('Add Labels User');
        if (!empty($this->request->data)) {
            $this->LabelsUser->create();
            if ($this->LabelsUser->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Labels User has been added') , $this->request->data['LabelsUser']['id']) , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'labels_users',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Labels User could not be added. Please, try again.') , $this->request->data['LabelsUser']['id']) , 'default', null, 'error');
            }
        }
        $labels = $this->LabelsUser->Label->find('list');
        $users = $this->LabelsUser->User->find('list');
        $this->set(compact('labels', 'users'));
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit Labels User');
        if (is_null($id)) {
            $label = $this->LabelsUser->find('first', array(
                'conditions' => array(
                    'LabelsUser.id' => $this->request->data['lables_users']['id']
                )
            ));
        } else {
            $label = $this->LabelsUser->find('first', array(
                'conditions' => array(
                    'LabelsUser.id' => $id
                )
            ));
        }
        if (!empty($this->request->data)) {
            $label_data = $this->Label->find('first', array(
                'conditions' => array(
                    'Label.name' => $this->request->data['LabelsUser']['label']
                )
            ));
            if (!empty($label_data)) {
                $label_id = $label_data['Label']['id'];
            } else {
                $this->request->data['Label']['name'] = $this->request->data['LabelsUser']['label'];
                $this->Label->create();
                $this->Label->save($this->request->data);
                $label_id = $this->Label->id;
            }
            $is_exist = $this->LabelsUser->find('count', array(
                'conditions' => array(
                    'LabelsUser.label_id' => $label_id,
                    'LabelsUser.user_id' => $this->Auth->user('id')
                )
            ));
            if ($is_exist == 0) {
                $this->request->data['LabelsUser']['label_id'] = $label_id;
                if ($this->LabelsUser->save($this->request->data)) {
                    $this->Session->setFlash(__l(' Labels User has been updated') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'labels_users',
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(__l(' Labels User could not be updated. Please, try again.') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l(' Labels already exist.') , 'default', null, 'error');
            }
        } else {
            $this->request->data['LabelsUser']['id'] = $id;
            $this->request->data['LabelsUser']['label'] = $label['Label']['name'];
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->LabelsUser->delete($id)) {
            $this->Session->setFlash(__l('Labels User deleted') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'messages',
                'action' => 'settings',
                '#message-label'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function lst()
    {
        $this->pageTitle = __l('Labels Users');
        $this->paginate = array(
            'conditions' => array(
                'LabelsUser.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => 2
        );
        $this->set('labelsUsers', $this->paginate());
    }
}
?>