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
class IpsController extends AppController
{
    public $name = 'Ips';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('IPs');
        $conditions = array();
        if (isset($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'City.name LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Ip.ip LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Country.name LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'State.name LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['Ip']['q'] = $this->request->params['named']['q'];
        }
        $this->Ip->recursive = 0;
        $order = array(
            'Ip.id' => 'DESC'
        );
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => $order
        );
        $moreActions = $this->Ip->moreActions;
        $this->set('moreActions', $moreActions);
        $this->set('ips', $this->paginate());
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Ip->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('IP')) , 'default', null, 'success');
            if (!empty($this->request->query['r'])) {
                $this->redirect(Router::url('/', true) . $this->request->query['r']);
            } else {
                $this->redirect(array(
                    'action' => 'index'
                ));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>