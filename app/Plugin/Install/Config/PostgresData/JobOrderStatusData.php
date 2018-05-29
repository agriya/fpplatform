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
class JobOrderStatusData {

	public $table = 'job_order_statuses';

	public $records = array(
		array(
			'id' => '4',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Completed',
			'job_order_count' => '0',
			'slug' => 'completed',
			'description' => 'Order completed!'
		),
		array(
			'id' => '8',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Expired',
			'job_order_count' => '0',
			'slug' => 'expired',
			'description' => 'Order was expired due to non acceptance by the seller. Buyer amount has been refunded.'
		),
		array(
			'id' => '9',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'In progress overtime',
			'job_order_count' => '0',
			'slug' => 'in-progress-overtime',
			'description' => 'Order status has been changed to in progress overtime since it didn\'t delivered on time.Buyer now has option to cancel the order.'
		),
		array(
			'id' => '10',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Cancelled due to overtime',
			'job_order_count' => '0',
			'slug' => 'cancelled-due-to-overtime',
			'description' => 'Order was cancelled by the ##BUYER## during overtime status.Buyer amount has been refunded.'
		),
		array(
			'id' => '12',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'completed and closed by admin',
			'job_order_count' => '0',
			'slug' => 'completed-and-closed-by-admin',
			'description' => 'Order was closed automatically by Site Administrator since buyer was not able to give review for the order in time.Seller has been paid.'
		),
		array(
			'id' => '14',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Rework',
			'job_order_count' => '0',
			'slug' => 'rework',
			'description' => '##BUYER## requested redeliver the work. '
		),
		array(
			'id' => '15',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Mutual Cancelled',
			'job_order_count' => '0',
			'slug' => 'mutual-cancel',
			'description' => 'Order mutually cancelled.'
		),
		array(
			'id' => '13',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Payment pending',
			'job_order_count' => '0',
			'slug' => 'payment-pending',
			'description' => 'Order is in payment pending status'
		),
		array(
			'id' => '11',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Cancelled by admin',
			'job_order_count' => '0',
			'slug' => 'cancelled-by-admin',
			'description' => 'Order was cancelled by Site Administrator. Buyer amount has been refunded'
		),
		array(
			'id' => '7',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Payment cleared',
			'job_order_count' => '0',
			'slug' => 'payment-cleared',
			'description' => 'Amount has been cleared for seller to withdraw.'
		),
		array(
			'id' => '6',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Rejected',
			'job_order_count' => '0',
			'slug' => 'rejected',
			'description' => 'Order was rejected by the ##SELLER##. Buyer amount has been refunded.'
		),
		array(
			'id' => '5',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Cancelled',
			'job_order_count' => '0',
			'slug' => 'cancelled',
			'description' => 'Order was cancelled by the ##BUYER##. Buyer amount has been refunded.'
		),
		array(
			'id' => '3',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Waiting for review',
			'job_order_count' => '0',
			'slug' => 'waiting-for-review',
			'description' => 'Your Order is ready!'
		),
		array(
			'id' => '2',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'In progress',
			'job_order_count' => '0',
			'slug' => 'in-progress',
			'description' => 'Order was accepted by the ##SELLER## on ##ACCEPTED_DATE##. Expected delivery in approximately ##DELIVERY_DATE##.'
		),
		array(
			'id' => '1',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Waiting for acceptance',
			'job_order_count' => '0',
			'slug' => 'waiting-for-acceptance',
			'description' => 'Payment successfully collected. Your payment for this order was successfully collected by ##SITE_NAME##. Seller will be paid when order is complete. Order was made by the ##BUYER## on ##CREATED_DATE##. Waiting for seller to accept the order.'
		),
	);

}
