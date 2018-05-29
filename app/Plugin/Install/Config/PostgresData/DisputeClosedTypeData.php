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
class DisputeClosedTypeData {

	public $table = 'dispute_closed_types';

	public $records = array(
		array(
			'id' => '1',
			'name' => 'Favor buyer',
			'dispute_type_id' => '1',
			'job_user_type_id' => '1',
			'reason' => 'Item didn\'t matched buyer requirement',
			'resolve_type' => 'refunded'
		),
		array(
			'id' => '2',
			'name' => 'Favor seller',
			'dispute_type_id' => '1',
			'job_user_type_id' => '2',
			'reason' => 'Item matched the buyer requirement',
			'resolve_type' => 'resolve without any change'
		),
		array(
			'id' => '3',
			'name' => 'Favor buyer',
			'dispute_type_id' => '2',
			'job_user_type_id' => '1',
			'reason' => 'Item doesn\'t match the requirements so frequent redeliver request accepted',
			'resolve_type' => 'resolve without any change'
		),
		array(
			'id' => '4',
			'name' => 'Favor seller',
			'dispute_type_id' => '2',
			'job_user_type_id' => '2',
			'reason' => 'Item match the requirements so seller order closed by administrator',
			'resolve_type' => 'Complete order and pay seller'
		),
		array(
			'id' => '5',
			'name' => 'Favor buyer',
			'dispute_type_id' => '3',
			'job_user_type_id' => '1',
			'reason' => 'Item quality not good so negative feedback by buyer accepted',
			'resolve_type' => 'resolve without any change'
		),
		array(
			'id' => '6',
			'name' => 'Favor seller',
			'dispute_type_id' => '3',
			'job_user_type_id' => '2',
			'reason' => 'Item matches quality and requirement so seller rating changed to positive',
			'resolve_type' => 'Update seller rating'
		),
		array(
			'id' => '7',
			'name' => 'Favor buyer',
			'dispute_type_id' => '1',
			'job_user_type_id' => '1',
			'reason' => 'Failure to respond in time limit',
			'resolve_type' => 'refunded'
		),
		array(
			'id' => '8',
			'name' => 'Favor seller',
			'dispute_type_id' => '2',
			'job_user_type_id' => '2',
			'reason' => 'Failure to respond in time limit',
			'resolve_type' => 'Complete order and pay seller'
		),
		array(
			'id' => '9',
			'name' => 'Favor seller',
			'dispute_type_id' => '3',
			'job_user_type_id' => '2',
			'reason' => 'Failure to respond in time limit',
			'resolve_type' => 'Update seller rating'
		),
	);

}
