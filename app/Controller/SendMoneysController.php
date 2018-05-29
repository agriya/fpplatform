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
class SendMoneysController extends AppController
{
    public $name = 'SendMoneys';
    function index()
    {
        $this->pageTitle = __l('Received Money');
        $conditions = array();
        $conditions['SendMoney.is_success'] = 1;
        $conditions['SendMoney.user_id'] = $this->Auth->user('id');
        $this->paginate = array(
            'conditions' => $conditions,
            'recursive' => 0
        );
        $this->set('sendMoneys', $this->paginate());
    }
    function admin_index()
    {
        $this->pageTitle = __l('Send Money');
        $this->SendMoney->recursive = 0;
        $this->set('sendMoneys', $this->paginate());
    }
}
?>