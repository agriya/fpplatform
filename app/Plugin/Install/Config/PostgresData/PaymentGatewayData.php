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
class PaymentGatewayData {

	public $table = 'payment_gateways';

	public $records = array(
		array(
			'id' => '2',
			'created' => '2010-05-10 10:43:02',
			'modified' => '2010-05-10 10:43:02',
			'name' => 'Wallet',
			'display_name' => 'Wallet',
			'description' => 'Wallet option for purchase',
			'gateway_fees' => '',
			'transaction_count' => '0',
			'payment_gateway_setting_count' => '0',
			'is_test_mode' => '',
			'is_active' => '1',
			'is_mass_pay_enabled' => '0'
		),
		array(
			'id' => '3',
			'created' => '2013-11-13 10:26:07',
			'modified' => '2013-12-07 10:15:47',
			'name' => 'SudoPay',
			'display_name' => 'SudoPay',
			'description' => 'Payment through SudoPay',
			'gateway_fees' => '2.9',
			'transaction_count' => '0',
			'payment_gateway_setting_count' => '0',
			'is_test_mode' => '1',
			'is_active' => '1',
			'is_mass_pay_enabled' => '0'
		),
	);

}
