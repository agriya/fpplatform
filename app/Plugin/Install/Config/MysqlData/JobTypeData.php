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

class JobTypeData
{
	public $table = 'job_types';
	public $records = array(
		array(
			'id' => '1',
			'name' => 'Online',
			'descriptions' => 'Seller or buyer can accomplish his/her job completly over net.',
			'job_count' => '0',
			'request_count' => '0',
			'job_category_count' => '0',
			'is_active' => '1'
		),
		array(
			'id' => '2',
			'name' => 'Offline',
			'descriptions' => 'Seller or buyer needs to physically interact with each other.',
			'job_count' => '0',
			'request_count' => '0',
			'job_category_count' => '0',
			'is_active' => '1'
		),
	);}