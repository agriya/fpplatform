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
class JobServiceLocationsController extends AppController
{
    public $name = 'JobServiceLocations';
    function admin_index()
    {
        $this->pageTitle = __l('Job Service Locations');
        $this->JobServiceLocation->recursive = 0;
        $this->set('jobServiceLocations', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Job Service Location');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $jobServiceLocation = $this->JobServiceLocation->find('first', array(
            'conditions' => array(
                'JobServiceLocation.id = ' => $id
            ) ,
            'fields' => array(
                'JobServiceLocation.id',
                'JobServiceLocation.name',
                'JobServiceLocation.job_count',
                'JobServiceLocation.description',
            ) ,
            'recursive' => -1,
        ));
        if (empty($jobServiceLocation)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $jobServiceLocation['JobServiceLocation']['name'];
        $this->set('jobServiceLocation', $jobServiceLocation);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Job Service Location');
        if (!empty($this->request->data)) {
            $this->JobServiceLocation->create();
            if ($this->JobServiceLocation->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Job Service Location has been added') , $this->request->data['JobServiceLocation']['name']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Job Service Location could not be added. Please, try again.') , $this->request->data['JobServiceLocation']['name']) , 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Job Service Location');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->JobServiceLocation->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Job Service Location has been updated') , $this->request->data['JobServiceLocation']['name']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Job Service Location could not be updated. Please, try again.') , $this->request->data['JobServiceLocation']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->JobServiceLocation->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['JobServiceLocation']['name'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->JobServiceLocation->delete($id)) {
            $this->Session->setFlash(__l('Job Service Location deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>