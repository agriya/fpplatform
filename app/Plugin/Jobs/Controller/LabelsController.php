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
class LabelsController extends AppController
{
    public $name = 'Labels';
    function beforeFilter()
    {
        $this->Security->enabled = false;
        parent::beforeFilter();
    }
    function add()
    {
        $this->pageTitle = __l('Add Label');
        if (!empty($this->request->data)) {
            $id = $this->Label->find('first', array(
                'conditions' => array(
                    'Label.name' => $this->request->data['Label']['name']
                ) ,
                'fields' => array(
                    'Label.id'
                )
            ));
            if (empty($id)) {
                $this->Label->create();
                $this->Label->save($this->request->data);
                $label_id = $this->Label->id;
            } else {
                $label_id = $id['Label']['id'];
            }
            if (!empty($label_id)) {
                $is_exist = $this->Label->LabelsUser->find('count', array(
                    'conditions' => array(
                        'LabelsUser.label_id' => $label_id,
                        'LabelsUser.user_id' => $this->Auth->user('id')
                    )
                ));
                if ($is_exist == 0) {
                    $this->request->data['LabelsUser']['label_id'] = $label_id;
                    $this->request->data['LabelsUser']['user_id'] = $this->Auth->user('id');
                    $this->Label->LabelsUser->create();
                    $this->Label->LabelsUser->save($this->request->data);
                }
                $this->Session->setFlash(__l(' Label has been added') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l(' Label could not be added. Please, try again') , 'default', null, 'error');
            }
            $this->redirect(array(
                'controller' => 'messages',
                'action' => 'settings',
                '#message-label'
            ));
        }
        $messages = $this->Label->Message->find('list');
        $users = $this->Label->User->find('list');
        $this->set(compact('messages', 'users'));
    }
    function label()
    {
        $this->pageTitle = __l('Add Label');
        if (!empty($this->request->data)) {
            $id = $this->Label->find('first', array(
                'conditions' => array(
                    'Label.name' => $this->request->data['Label']['name']
                ) ,
                'fields' => array(
                    'Label.id'
                )
            ));
            if (empty($id)) {
                $this->Label->create();
                $this->Label->save($this->request->data);
                $label_id = $this->Label->id;
            } else {
                $label_id = $id['Label']['id'];
            }
            if (!empty($label_id)) {
                $is_exist = $this->Label->LabelsUser->find('count', array(
                    'conditions' => array(
                        'LabelsUser.label_id' => $label_id,
                        'LabelsUser.user_id' => $this->Auth->user('id')
                    )
                ));
                if ($is_exist == 0) {
                    $this->request->data['LabelsUser']['label_id'] = $label_id;
                    $this->request->data['LabelsUser']['user_id'] = $this->Auth->user('id');
                    $this->Label->LabelsUser->create();
                    $this->Label->LabelsUser->save($this->request->data);
                }
                $this->Session->setFlash(__l(' Label has been added') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l(' Label could not be added. Please, try again') , 'default', null, 'error');
            }
            $this->redirect(array(
                'controller' => 'messages',
                'action' => 'inbox'
            ));
        }
        $messages = $this->Label->Message->find('list');
        $users = $this->Label->User->find('list');
        $this->set(compact('messages', 'users'));
    }
}
?>