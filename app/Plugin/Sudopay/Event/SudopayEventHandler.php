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
class SudopayEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents()
    {
        return array(
            'View.Payment.GetGatewayList' => array(
                'callable' => 'onGetGatewayList'
            ) ,
        );
    }
    public function onGetGatewayList($event)
    {
        App::import('Model', 'Sudopay.Sudopay');
        $this->Sudopay = new Sudopay();
        $s = $this->Sudopay->getSudoPayObject();
        $gateway_response = $s->callGateways();
		if (empty($gateway_response['error']['code'])) {
			$event->gatewayGroups = $this->Sudopay->getGatewayGroups($gateway_response);
			$event->gateways = $this->Sudopay->getGateways($gateway_response);
			$event->form_fields_tpls = $gateway_response['_form_fields_tpls'];
		}
    }
}
?>