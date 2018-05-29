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
class JobServiceLocationData {

	public $table = 'job_service_locations';

	public $records = array(
		array(
			'id' => '1',
			'name' => 'Buyer',
			'job_count' => '0',
			'description' => 'Service in seller location. Buyer needs to visit seller location for his/her job.'
		),
		array(
			'id' => '2',
			'name' => 'Seller',
			'job_count' => '0',
			'description' => 'Service in buyer location. Seller needs to visit buyer location for his/her job.'
		),
	);

}
