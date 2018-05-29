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
class TransactionTypeData {

	public $table = 'transaction_types';

	public $records = array(
		array(
			'id' => '2',
			'created' => '2010-03-04 10:17:14',
			'modified' => '2010-09-09 07:15:41',
			'name' => 'Bought new job',
			'is_credit' => '',
			'message' => '##BUYER## bought a ##JOB_ALT_NAME## ##JOB##  for ##JOB_AMOUNT##, order# ##ORDER_NO##',
			'transaction_variables' => 'BUYER, JOB, JOB_AMOUNT, ORDER_NO, JOB_ALT_NAME'
		),
		array(
			'id' => '3',
			'created' => '2010-03-04 10:17:05',
			'modified' => '2010-03-04 10:17:08',
			'name' => 'Paid amount for job to user',
			'is_credit' => '1',
			'message' => '##SELLER## amount enter clearing stage for the ##JOB_ALT_NAME## ##JOB##, order# ##ORDER_NO##',
			'transaction_variables' => 'SELLER, JOB, ORDER_NO, JOB_ALT_NAME'
		),
		array(
			'id' => '4',
			'created' => '2010-03-04 10:17:14',
			'modified' => '2010-03-04 10:17:16',
			'name' => 'Withdrawn amount from wallet',
			'is_credit' => '',
			'message' => 'Withdraw request has been made by user, ##USER## ',
			'transaction_variables' => 'USER '
		),
		array(
			'id' => '5',
			'created' => '2010-03-04 10:19:09',
			'modified' => '2010-03-04 10:19:14',
			'name' => 'Refund for rejected jobs',
			'is_credit' => '1',
			'message' => '##BUYER## refunded for rejected ##JOB_ALT_NAME##, ##JOB##, order# ##ORDER_NO##',
			'transaction_variables' => 'BUYER, JOB, ORDER_NO, JOB_ALT_NAME'
		),
		array(
			'id' => '6',
			'created' => '2010-03-04 10:19:34',
			'modified' => '2010-03-04 10:19:37',
			'name' => 'Refund for cancelled jobs',
			'is_credit' => '1',
			'message' => '##BUYER## refunded ##JOB_AMOUNT## for cancelled ##JOB_ALT_NAME##, ##JOB##, order# ##ORDER_NO##',
			'transaction_variables' => 'BUYER, JOB_AMOUNT, JOB, ORDER_NO, JOB_ALT_NAME'
		),
		array(
			'id' => '7',
			'created' => '2010-03-04 10:20:11',
			'modified' => '2010-03-04 10:20:14',
			'name' => 'Paid cash withdraw request amount to user',
			'is_credit' => '',
			'message' => 'Cash withdraw request made by user, ##USER## has been accepted.',
			'transaction_variables' => 'USER'
		),
		array(
			'id' => '8',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Amount transferred for seller',
			'is_credit' => '1',
			'message' => '##SELLER## recieved amount ##JOB_RECIEVED_AMOUNT## for the ##JOB##, order# ##ORDER_NO## and status in pending',
			'transaction_variables' => 'SELLER, JOB_RECIEVED_AMOUNT, JOB,ORDER_NO'
		),
		array(
			'id' => '9',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Seller amount cleared',
			'is_credit' => '1',
			'message' => '##SELLER## amount gets cleared,  for the ##JOB_ALT_NAME## ##JOB##, order# ##ORDER_NO##',
			'transaction_variables' => 'SELLER, JOB, ORDER_NO, JOB_ALT_NAME'
		),
		array(
			'id' => '10',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Seller deducted for rejected job',
			'is_credit' => '',
			'message' => 'Order ###ORDER_NO## rejected. ##SELLER## deducted for the ##JOB_ALT_NAME## ##JOB##',
			'transaction_variables' => 'ORDER_NO, SELLER, JOB, JOB_ALT_NAME'
		),
		array(
			'id' => '11',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Seller deducted for cancelled job',
			'is_credit' => '',
			'message' => 'Order ###ORDER_NO## cancelled. ##SELLER## deducted for the ##JOB_ALT_NAME## ##JOB##',
			'transaction_variables' => 'ORDER_NO, SELLER, JOB, JOB_ALT_NAME'
		),
		array(
			'id' => '14',
			'created' => '2010-07-12 11:40:11',
			'modified' => '2010-07-12 11:40:11',
			'name' => 'Cancelled by admin and refunded to buyer',
			'is_credit' => '1',
			'message' => '##BUYER## refunded ##JOB_AMOUNT## for admin cancelled ##JOB_ALT_NAME##, ##JOB##, order# ##ORDER_NO##',
			'transaction_variables' => 'BUYER, JOB_AMOUNT, JOB, ORDER_NO, JOB_ALT_NAME'
		),
		array(
			'id' => '15',
			'created' => '2010-07-12 11:39:17',
			'modified' => '2010-07-12 11:39:20',
			'name' => 'Refund for expired job',
			'is_credit' => '1',
			'message' => '##BUYER## refunded for rejected ##JOB_ALT_NAME##, ##JOB##, order# ##ORDER_NO##',
			'transaction_variables' => 'BUYER, JOB, ORDER_NO, JOB_ALT_NAME'
		),
		array(
			'id' => '16',
			'created' => '2010-07-12 11:40:11',
			'modified' => '2010-07-12 11:40:13',
			'name' => 'Deducted for expired job',
			'is_credit' => '',
			'message' => 'Order ###ORDER_NO## has been expired. ##SELLER## deducted for the ##JOB_ALT_NAME## ##JOB##',
			'transaction_variables' => 'SELLER, JOB, ORDER_NO, JOB_ALT_NAME'
		),
		array(
			'id' => '17',
			'created' => '2010-07-12 11:40:11',
			'modified' => '2010-07-12 11:40:11',
			'name' => 'Cancelled by admin and deducted to seller',
			'is_credit' => '',
			'message' => 'Order ###ORDER_NO## cancelled by admin. ##SELLER## deducted for the ##JOB_ALT_NAME## ##JOB##',
			'transaction_variables' => 'ORDER_NO, SELLER, JOB, JOB_ALT_NAME'
		),
		array(
			'id' => '13',
			'created' => '2010-07-12 11:40:11',
			'modified' => '2010-07-12 11:40:11',
			'name' => 'Buyer cancelled due to overtime',
			'is_credit' => '1',
			'message' => 'Order ###ORDER_NO## cancelled. ##BUYER## recieved amount for the ##JOB_ALT_NAME## ##JOB##',
			'transaction_variables' => 'ORDER_NO, BUYER, JOB, JOB_ALT_NAME'
		),
		array(
			'id' => '18',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'user cash withdrawal request',
			'is_credit' => '',
			'message' => 'Cash withdrawal request made by ##SELLER##',
			'transaction_variables' => 'SELLER'
		),
		array(
			'id' => '19',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Admin approved withdrawal request',
			'is_credit' => '',
			'message' => 'Admin approved the ##SELLER## withdrawal request',
			'transaction_variables' => 'SELLER'
		),
		array(
			'id' => '20',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Admin rejected withdrawal request',
			'is_credit' => '',
			'message' => '##SELLER## has rejected the withdrawal request',
			'transaction_variables' => 'SELLER'
		),
		array(
			'id' => '21',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Failed withdrawal request',
			'is_credit' => '',
			'message' => 'Withdrawal request for ##SELLER## has been failed',
			'transaction_variables' => 'SELLER'
		),
		array(
			'id' => '24',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Withdrawal request approved for user by admin',
			'is_credit' => '',
			'message' => 'Withdrawal request approved for ##SELLER## ',
			'transaction_variables' => 'SELLER'
		),
		array(
			'id' => '23',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Amount refunded for rejected withdrawal request',
			'is_credit' => '1',
			'message' => 'Amount refunded to ##SELLER## for rejected withdrawal request',
			'transaction_variables' => 'SELLER'
		),
		array(
			'id' => '25',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Failed withdrawal request and refunded to user',
			'is_credit' => '1',
			'message' => 'Withdrawal request failed from paypal for user ##SELLER##',
			'transaction_variables' => 'SELLER'
		),
		array(
			'id' => '26',
			'created' => '2010-09-23 18:48:00',
			'modified' => '2010-09-23 18:47:58',
			'name' => 'Send Money to user',
			'is_credit' => '1',
			'message' => 'Admin send money to your account.',
			'transaction_variables' => ''
		),
		array(
			'id' => '1',
			'created' => '2010-03-04 10:17:05',
			'modified' => '2010-03-04 10:17:05',
			'name' => 'Amount added to wallet ',
			'is_credit' => '1',
			'message' => 'Amount added to wallet ',
			'transaction_variables' => ''
		),
		array(
			'id' => '28',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'user cash withdrawal request',
			'is_credit' => '',
			'message' => 'Affiliate commission amount withdrawal request made by ##AFFILIATE_USER##',
			'transaction_variables' => 'AFFILIATE_USER'
		),
		array(
			'id' => '29',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Admin approved withdrawal request',
			'is_credit' => '',
			'message' => 'Admin approved the ##AFFILIATE_USER## withdrawal request',
			'transaction_variables' => 'AFFILIATE_USER'
		),
		array(
			'id' => '30',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Admin rejected withdrawal request',
			'is_credit' => '',
			'message' => '##AFFILIATE_USER## has rejected the withdrawal request',
			'transaction_variables' => 'AFFILIATE_USER'
		),
		array(
			'id' => '31',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Failed withdrawal request',
			'is_credit' => '',
			'message' => 'Withdrawal request for ##AFFILIATE_USER## has been failed',
			'transaction_variables' => 'AFFILIATE_USER'
		),
		array(
			'id' => '32',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Withdrawal request approved for user by admin',
			'is_credit' => '',
			'message' => 'Withdrawal request approved for ##AFFILIATE_USER## ',
			'transaction_variables' => 'AFFILIATE_USER'
		),
		array(
			'id' => '33',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Amount refunded for rejected withdrawal request',
			'is_credit' => '1',
			'message' => 'Amount refunded to ##AFFILIATE_USER## for rejected withdrawal request',
			'transaction_variables' => 'AFFILIATE_USER'
		),
		array(
			'id' => '34',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Failed withdrawal request and refunded to user',
			'is_credit' => '1',
			'message' => 'Withdrawal request failed from paypal for user ##AFFILIATE_USER##',
			'transaction_variables' => 'AFFILIATE_USER'
		),
		array(
			'id' => '35',
			'created' => '2010-03-04 10:17:14',
			'modified' => '2010-03-04 10:17:16',
			'name' => 'Withdrawn amount from Affiliate',
			'is_credit' => '',
			'message' => 'Withdraw request has been made by user, ##AFFILIATE_USER## ',
			'transaction_variables' => 'AFFILIATE_USER'
		),
		array(
			'id' => '36',
			'created' => '2010-03-04 10:20:11',
			'modified' => '2010-03-04 10:20:14',
			'name' => 'Paid cash withdraw request amount to user',
			'is_credit' => '',
			'message' => 'Cash withdraw request made by user, ##AFFILIATE_USER## has been accepted.',
			'transaction_variables' => 'AFFILIATE_USER'
		),
		array(
			'id' => '38',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Paid cash withdraw request amount to user',
			'is_credit' => '',
			'message' => 'Withdraw request has been successfully made and paid to your money transfer account',
			'transaction_variables' => 'Withdraw request for ##USER## was successfully paid to his money transfer account'
		),
		array(
			'id' => '39',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'User cash withdrawal request',
			'is_credit' => '',
			'message' => 'Withdraw request has been made',
			'transaction_variables' => 'Withdraw request has been made by user, ##USER##'
		),
		array(
			'id' => '40',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Approved withdrawal request',
			'is_credit' => '',
			'message' => 'Administrator have approved your withdrawal request',
			'transaction_variables' => 'You (Administrator) have approved the withdrawal request for ##USER##'
		),
		array(
			'id' => '41',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Amount refunded for rejected withdrawal request',
			'is_credit' => '1',
			'message' => 'Administrator have rejected the withdrawal request',
			'transaction_variables' => 'Amount refunded to ##USER## for rejected withdrawal request'
		),
	);

}
