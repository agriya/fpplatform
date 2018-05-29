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
class SudopayIpnLogsController extends AppController
{
    var $name = 'SudopayIpnLogs';
    function admin_index() 
    {
        $this->pageTitle = __l('Sudopay IPN Logs');
		$conditions = array(
            'SudopayIpnLog.post_variable !=' => ''
        );
        $this->paginate = array(
			'conditions' => $conditions,
            'order' => array(
                'SudopayIpnLog.id' => 'desc'
            ) ,
            'recursive' => 0
        );
        $this->set('sudopayIpnLogs', $this->paginate());
    }
}
?>
