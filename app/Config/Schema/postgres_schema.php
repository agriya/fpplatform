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
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $acl_link_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $acl_links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'controller' => array('type' => 'string', 'null' => true),
		'action' => array('type' => 'string', 'null' => true),
		'named_key' => array('type' => 'string', 'null' => true),
		'named_value' => array('type' => 'string', 'null' => true),
		'pass_value' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $acl_links_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'role_id' => array('type' => 'integer', 'null' => true),
		'acl_link_id' => array('type' => 'integer', 'null' => true),
		'acl_link_status_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'acl_links_roles_acl_link_id_idx' => array('unique' => false, 'column' => 'acl_link_id'),
			'acl_links_roles_acl_link_status_id_idx' => array('unique' => false, 'column' => 'acl_link_status_id'),
			'acl_links_roles_role_id_idx' => array('unique' => false, 'column' => 'role_id')
		),
		'tableParameters' => array()
	);
	public $affiliate_cash_withdrawal_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $affiliate_cash_withdrawals = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'affiliate_cash_withdrawal_status_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliate_cash_withdrawals_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'affiliate_cash_withdrawals_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'iliate_cash_withdrawals_affiliate_cash_withdrawal_status_id_idx' => array('unique' => false, 'column' => 'affiliate_cash_withdrawal_status_id')
		),
		'tableParameters' => array()
	);
	public $affiliate_commission_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $affiliate_requests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'site_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'site_description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'site_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'site_category_id' => array('type' => 'integer', 'null' => true),
		'why_do_you_want_affiliate' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_web_site_marketing' => array('type' => 'boolean', 'null' => true),
		'is_search_engine_marketing' => array('type' => 'boolean', 'null' => true),
		'is_email_marketing' => array('type' => 'boolean', 'null' => true),
		'special_promotional_method' => array('type' => 'string', 'null' => true, 'default' => null),
		'special_promotional_description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_approved' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliate_requests_site_category_id_idx' => array('unique' => false, 'column' => 'site_category_id'),
			'affiliate_requests_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $affiliate_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => true),
		'modified' => array('type' => 'date', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $affiliate_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'model_name' => array('type' => 'string', 'null' => true),
		'commission' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'affiliate_commission_type_id' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliate_types_affiliate_commission_type_id_idx' => array('unique' => false, 'column' => 'affiliate_commission_type_id')
		),
		'tableParameters' => array()
	);
	public $affiliates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'class' => array('type' => 'string', 'null' => true),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'affiliate_type_id' => array('type' => 'integer', 'null' => true),
		'affliate_user_id' => array('type' => 'integer', 'null' => true),
		'affiliate_status_id' => array('type' => 'integer', 'null' => true),
		'commission_amount' => array('type' => 'float', 'null' => true),
		'commission_holding_start_date' => array('type' => 'date', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliates_affiliate_status_id_idx' => array('unique' => false, 'column' => 'affiliate_status_id'),
			'affiliates_affiliate_type_id_idx' => array('unique' => false, 'column' => 'affiliate_type_id'),
			'affiliates_affliate_user_id_idx' => array('unique' => false, 'column' => 'affliate_user_id')
		),
		'tableParameters' => array()
	);
	public $attachments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'filename' => array('type' => 'string', 'null' => true, 'default' => null),
		'dir' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'mimetype' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'filesize' => array('type' => 'integer', 'null' => true),
		'height' => array('type' => 'integer', 'null' => true),
		'width' => array('type' => 'integer', 'null' => true),
		'thumb' => array('type' => 'boolean', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'attachments_class_idx' => array('unique' => false, 'column' => 'class'),
			'attachments_foreign_id_idx' => array('unique' => false, 'column' => 'foreign_id')
		),
		'tableParameters' => array()
	);
	public $banned_ips = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'address' => array('type' => 'string', 'null' => true, 'default' => null),
		'range' => array('type' => 'string', 'null' => true, 'default' => null),
		'referer_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'reason' => array('type' => 'string', 'null' => true, 'default' => null),
		'redirect' => array('type' => 'string', 'null' => true, 'default' => null),
		'thetime' => array('type' => 'integer', 'null' => true),
		'timespan' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'banned_ips_address_idx' => array('unique' => false, 'column' => 'address'),
			'banned_ips_range_idx' => array('unique' => false, 'column' => 'range')
		),
		'tableParameters' => array()
	);
	public $blocks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'region_id' => array('type' => 'integer', 'null' => true),
		'title' => array('type' => 'string', 'null' => true, 'length' => 100),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'body' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'show_title' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null),
		'status' => array('type' => 'boolean', 'null' => true),
		'weight' => array('type' => 'integer', 'null' => true),
		'element' => array('type' => 'string', 'null' => true, 'default' => null),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'visibility_paths' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'visibility_php' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'modified' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'plugin_name' => array('type' => 'string', 'null' => true, 'length' => 220),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'blocks_alias_key' => array('unique' => true, 'column' => 'alias'),
			'blocks_plugin_name_idx' => array('unique' => false, 'column' => 'plugin_name'),
			'blocks_region_id_idx' => array('unique' => false, 'column' => 'region_id')
		),
		'tableParameters' => array()
	);
	public $cake_sessions = array(
		'id' => array('type' => 'string', 'null' => false, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'data' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'expires' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'cake_sessions_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $cities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'country_id' => array('type' => 'integer', 'null' => true),
		'state_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'latitude' => array('type' => 'float', 'null' => true),
		'longitude' => array('type' => 'float', 'null' => true),
		'timezone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'dma_id' => array('type' => 'integer', 'null' => true),
		'county' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4),
		'is_approved' => array('type' => 'boolean', 'null' => true),
		'language_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'cities_country_id_idx' => array('unique' => false, 'column' => 'country_id'),
			'cities_dma_id_idx' => array('unique' => false, 'column' => 'dma_id'),
			'cities_is_approved_idx' => array('unique' => false, 'column' => 'is_approved'),
			'cities_language_id_idx' => array('unique' => false, 'column' => 'language_id'),
			'cities_slug_idx' => array('unique' => false, 'column' => 'slug'),
			'cities_state_id_idx' => array('unique' => false, 'column' => 'state_id')
		),
		'tableParameters' => array()
	);
	public $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'node_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'body' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'rating' => array('type' => 'integer', 'null' => true),
		'status' => array('type' => 'boolean', 'null' => true),
		'notify' => array('type' => 'boolean', 'null' => true),
		'type' => array('type' => 'string', 'null' => true, 'length' => 100),
		'comment_type' => array('type' => 'string', 'null' => true, 'default' => 'comment', 'length' => 100),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'comments_lft_idx' => array('unique' => false, 'column' => 'lft'),
			'comments_node_id_idx' => array('unique' => false, 'column' => 'node_id'),
			'comments_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'comments_rght_idx' => array('unique' => false, 'column' => 'rght'),
			'comments_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contact_types = array(
		'id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'contact_types_id_key' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $contacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'contact_type_id' => array('type' => 'integer', 'null' => true),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'email' => array('type' => 'string', 'null' => true, 'default' => null),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'telephone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'job_id' => array('type' => 'integer', 'null' => true),
		'job_order_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'is_replied' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contacts_contact_type_id_idx' => array('unique' => false, 'column' => 'contact_type_id'),
			'contacts_job_id_idx' => array('unique' => false, 'column' => 'job_id'),
			'contacts_job_order_id_idx' => array('unique' => false, 'column' => 'job_order_id'),
			'contacts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $countries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'iso_alpha2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2),
		'iso_alpha3' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'iso_numeric' => array('type' => 'integer', 'null' => true),
		'fips_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'capital' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'areainsqkm' => array('type' => 'float', 'null' => true),
		'population' => array('type' => 'integer', 'null' => true),
		'continent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2),
		'tld' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'currency' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'currencyname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'postalcodeformat' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'postalcoderegex' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'languages' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'geonameid' => array('type' => 'integer', 'null' => true),
		'neighbours' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'equivalentfipscode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $dispute_closed_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'dispute_type_id' => array('type' => 'integer', 'null' => true),
		'job_user_type_id' => array('type' => 'integer', 'null' => true),
		'reason' => array('type' => 'string', 'null' => true, 'default' => null),
		'resolve_type' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'dispute_closed_types_dispute_type_id_idx' => array('unique' => false, 'column' => 'dispute_type_id'),
			'dispute_closed_types_job_user_type_id_idx' => array('unique' => false, 'column' => 'job_user_type_id')
		),
		'tableParameters' => array()
	);
	public $dispute_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $dispute_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'job_user_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'dispute_types_job_user_type_id_idx' => array('unique' => false, 'column' => 'job_user_type_id')
		),
		'tableParameters' => array()
	);
	public $email_templates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'from' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'reply_to' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null),
		'email_text_content' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'email_html_content' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'email_variables' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1000),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'email_templates_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $genders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $ips = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'ip' => array('type' => 'string', 'null' => true, 'default' => null),
		'city_id' => array('type' => 'integer', 'null' => true),
		'state_id' => array('type' => 'integer', 'null' => true),
		'country_id' => array('type' => 'integer', 'null' => true),
		'timezone_id' => array('type' => 'integer', 'null' => true),
		'latitude' => array('type' => 'float', 'null' => true),
		'longitude' => array('type' => 'float', 'null' => true),
		'user_agent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'ips_city_id_idx' => array('unique' => false, 'column' => 'city_id'),
			'ips_country_id_idx' => array('unique' => false, 'column' => 'country_id'),
			'ips_state_id_idx' => array('unique' => false, 'column' => 'state_id'),
			'ips_timezone_id_idx' => array('unique' => false, 'column' => 'timezone_id')
		),
		'tableParameters' => array()
	);
	public $job_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'job_type_id' => array('type' => 'integer', 'null' => true),
		'job_count' => array('type' => 'integer', 'null' => true),
		'request_count' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_categories_job_count_idx' => array('unique' => false, 'column' => 'job_count'),
			'job_categories_job_type_id_idx' => array('unique' => false, 'column' => 'job_type_id'),
			'job_categories_request_count_idx' => array('unique' => false, 'column' => 'request_count'),
			'job_categories_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $job_coverage_radius_units = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'job_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_coverage_radius_units_job_count_idx' => array('unique' => false, 'column' => 'job_count')
		),
		'tableParameters' => array()
	);
	public $job_favorites = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'job_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_favorites_job_id_idx' => array('unique' => false, 'column' => 'job_id'),
			'job_favorites_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $job_feedbacks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'job_id' => array('type' => 'integer', 'null' => true),
		'job_order_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'feedback' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'admin_comments' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'is_satisfied' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_auto_review' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_feedbacks_job_id_idx' => array('unique' => false, 'column' => 'job_id'),
			'job_feedbacks_job_order_id_idx' => array('unique' => false, 'column' => 'job_order_id'),
			'job_feedbacks_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $job_flag_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => true),
		'modified' => array('type' => 'date', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'job_flag_count' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_flag_categories_job_flag_count_idx' => array('unique' => false, 'column' => 'job_flag_count'),
			'job_flag_categories_name_idx' => array('unique' => false, 'column' => 'name'),
			'job_flag_categories_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $job_flags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'job_id' => array('type' => 'integer', 'null' => true),
		'job_flag_category_id' => array('type' => 'integer', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_flags_job_flag_category_id_idx' => array('unique' => false, 'column' => 'job_flag_category_id'),
			'job_flags_job_id_idx' => array('unique' => false, 'column' => 'job_id'),
			'job_flags_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $job_order_disputes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'job_id' => array('type' => 'integer', 'null' => true),
		'message_id' => array('type' => 'integer', 'null' => true),
		'job_order_id' => array('type' => 'integer', 'null' => true),
		'job_user_type_id' => array('type' => 'integer', 'null' => true),
		'dispute_type_id' => array('type' => 'integer', 'null' => true),
		'reason' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'dispute_status_id' => array('type' => 'integer', 'null' => true),
		'resolved_date' => array('type' => 'datetime', 'null' => true),
		'favour_user_type_id' => array('type' => 'integer', 'null' => true),
		'last_replied_user_id' => array('type' => 'integer', 'null' => true),
		'last_replied_date' => array('type' => 'datetime', 'null' => true),
		'dispute_closed_type_id' => array('type' => 'integer', 'null' => true),
		'dispute_converstation_count' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_order_disputes_dispute_closed_type_id_idx' => array('unique' => false, 'column' => 'dispute_closed_type_id'),
			'job_order_disputes_dispute_type_id_idx' => array('unique' => false, 'column' => 'dispute_type_id'),
			'job_order_disputes_favour_user_type_id_idx' => array('unique' => false, 'column' => 'favour_user_type_id'),
			'job_order_disputes_job_id_idx' => array('unique' => false, 'column' => 'job_id'),
			'job_order_disputes_job_order_id_idx' => array('unique' => false, 'column' => 'job_order_id'),
			'job_order_disputes_job_user_type_id_idx' => array('unique' => false, 'column' => 'job_user_type_id'),
			'job_order_disputes_last_replied_user_id_idx' => array('unique' => false, 'column' => 'last_replied_user_id'),
			'job_order_disputes_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $job_order_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'job_order_count' => array('type' => 'integer', 'null' => true),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_order_statuses_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $job_orders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'referred_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_id' => array('type' => 'integer', 'null' => true),
		'owner_user_id' => array('type' => 'integer', 'null' => true),
		'job_order_status_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'commission_amount' => array('type' => 'float', 'null' => true),
		'admin_commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'affiliate_commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'accepted_date' => array('type' => 'datetime', 'null' => true),
		'last_redeliver_accept_date' => array('type' => 'datetime', 'null' => true),
		'delivered_date' => array('type' => 'datetime', 'null' => true),
		'completed_date' => array('type' => 'datetime', 'null' => true),
		'pay_key' => array('type' => 'string', 'null' => true, 'length' => 100),
		'verification_code' => array('type' => 'string', 'null' => true, 'default' => null),
		'address' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'mobile' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'latitude' => array('type' => 'float', 'null' => true),
		'longitude' => array('type' => 'float', 'null' => true),
		'zoom_level' => array('type' => 'integer', 'null' => true),
		'is_meet_inprogress_overtime' => array('type' => 'boolean', 'null' => true),
		'information_from_buyer' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'is_redeliver_request' => array('type' => 'boolean', 'null' => true),
		'mutual_cancellation_requested_date' => array('type' => 'datetime', 'null' => true),
		'is_buyer_request_for_cancel' => array('type' => 'boolean', 'null' => true),
		'is_seller_request_for_cancel' => array('type' => 'boolean', 'null' => true),
		'cancel_initiator_user_id' => array('type' => 'integer', 'null' => true),
		'redeliver_count' => array('type' => 'string', 'null' => true, 'length' => 20),
		'redeliver_accept_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'mutual_cancel_request' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'mutual_cancel_accept' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_under_dispute' => array('type' => 'boolean', 'null' => true),
		'time_taken' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'is_delayed_chained_payment' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => true),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true),
		'sudopay_revised_amount' => array('type' => 'float', 'null' => true),
		'sudopay_token' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_orders_cancel_initiator_user_id_idx' => array('unique' => false, 'column' => 'cancel_initiator_user_id'),
			'job_orders_job_id_idx' => array('unique' => false, 'column' => 'job_id'),
			'job_orders_job_order_status_id_idx' => array('unique' => false, 'column' => 'job_order_status_id'),
			'job_orders_owner_user_id_idx' => array('unique' => false, 'column' => 'owner_user_id'),
			'job_orders_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'job_orders_referred_by_user_id_idx' => array('unique' => false, 'column' => 'referred_by_user_id'),
			'job_orders_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $job_service_locations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'job_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $job_tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'job_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_tags_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $job_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'descriptions' => array('type' => 'string', 'null' => true, 'default' => null),
		'job_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'request_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_category_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_types_job_category_count_idx' => array('unique' => false, 'column' => 'job_category_count'),
			'job_types_job_count_idx' => array('unique' => false, 'column' => 'job_count'),
			'job_types_request_count_idx' => array('unique' => false, 'column' => 'request_count')
		),
		'tableParameters' => array()
	);
	public $job_user_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $job_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'job_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'job_views_job_id_idx' => array('unique' => false, 'column' => 'job_id'),
			'job_views_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $jobs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'job_category_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'no_of_days' => array('type' => 'integer', 'null' => true),
		'is_instruction_from_buyer' => array('type' => 'boolean', 'null' => true),
		'instruction_to_buyer' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_instruction_requires_attachment' => array('type' => 'boolean', 'null' => true),
		'is_instruction_requires_input' => array('type' => 'boolean', 'null' => true),
		'job_type_id' => array('type' => 'integer', 'null' => true),
		'job_service_location_id' => array('type' => 'integer', 'null' => true),
		'address' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'mobile' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15),
		'latitude' => array('type' => 'float', 'null' => true),
		'longitude' => array('type' => 'float', 'null' => true),
		'zoom_level' => array('type' => 'integer', 'null' => true, 'default' => '5'),
		'job_coverage_radius' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_coverage_radius_unit_id' => array('type' => 'integer', 'null' => true),
		'mean_rating' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'actual_rating' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'job_view_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_feedback_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_favorite_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_tag_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_flag_count' => array('type' => 'integer', 'null' => true),
		'active_sale_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'complete_sale_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'revenue' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_approved' => array('type' => 'boolean', 'null' => true),
		'is_featured' => array('type' => 'boolean', 'null' => true),
		'admin_suspend' => array('type' => 'boolean', 'null' => true),
		'youtube_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'flickr_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'positive_feedback_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_system_flagged' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'detected_suspicious_words' => array('type' => 'string', 'null' => true, 'default' => null),
		'amount' => array('type' => 'integer', 'null' => true),
		'commission_amount' => array('type' => 'float', 'null' => true),
		'is_deleted' => array('type' => 'boolean', 'null' => true),
		'sales_cleared_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sales_cleared_amount' => array('type' => 'float', 'null' => true),
		'sales_pipeline_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sales_pipeline_amount' => array('type' => 'float', 'null' => true),
		'sales_lost_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sales_lost_amount' => array('type' => 'float', 'null' => true),
		'referred_purchase_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'request_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'in_progress_overtime_meet_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_received_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_accepted_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_success_without_overtime_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_success_with_overtime_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_failure_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_active_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_last_accepted_date' => array('type' => 'datetime', 'null' => true),
		'order_waiting_for_acceptance' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_in_progress_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_in_progress_overtime_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_review_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_completed_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_rejected_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_cancelled_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_expired_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'redeliver_count' => array('type' => 'integer', 'null' => true),
		'job_order_dispute_count' => array('type' => 'integer', 'null' => true),
		'average_time_taken' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'jobs_job_category_id_idx' => array('unique' => false, 'column' => 'job_category_id'),
			'jobs_job_coverage_radius_unit_id_idx' => array('unique' => false, 'column' => 'job_coverage_radius_unit_id'),
			'jobs_job_feedback_count_idx' => array('unique' => false, 'column' => 'job_feedback_count'),
			'jobs_job_service_location_id_idx' => array('unique' => false, 'column' => 'job_service_location_id'),
			'jobs_job_type_id_idx' => array('unique' => false, 'column' => 'job_type_id'),
			'jobs_job_view_count_idx' => array('unique' => false, 'column' => 'job_view_count'),
			'jobs_slug_idx' => array('unique' => false, 'column' => 'slug'),
			'jobs_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $jobs_job_tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'job_id' => array('type' => 'integer', 'null' => true),
		'job_tag_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'jobs_job_tags_job_id_idx' => array('unique' => false, 'column' => 'job_id'),
			'jobs_job_tags_job_tag_id_idx' => array('unique' => false, 'column' => 'job_tag_id')
		),
		'tableParameters' => array()
	);
	public $jobs_requests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'job_id' => array('type' => 'integer', 'null' => true),
		'request_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'jobs_requests_job_id_idx' => array('unique' => false, 'column' => 'job_id'),
			'jobs_requests_request_id_idx' => array('unique' => false, 'column' => 'request_id')
		),
		'tableParameters' => array()
	);
	public $labels = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'labels_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $labels_messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'label_id' => array('type' => 'integer', 'null' => true),
		'message_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'labels_messages_label_id_idx' => array('unique' => false, 'column' => 'label_id'),
			'labels_messages_message_id_idx' => array('unique' => false, 'column' => 'message_id')
		),
		'tableParameters' => array()
	);
	public $labels_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'label_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'labels_users_label_id_idx' => array('unique' => false, 'column' => 'label_id'),
			'labels_users_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $languages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 80),
		'iso2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5),
		'iso3' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'languages_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'menu_id' => array('type' => 'integer', 'null' => true),
		'title' => array('type' => 'string', 'null' => true),
		'class' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'link' => array('type' => 'string', 'null' => true),
		'target' => array('type' => 'string', 'null' => true, 'default' => null),
		'rel' => array('type' => 'string', 'null' => true, 'default' => null),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'modified' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'links_lft_idx' => array('unique' => false, 'column' => 'lft'),
			'links_menu_id_idx' => array('unique' => false, 'column' => 'menu_id'),
			'links_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'links_rght_idx' => array('unique' => false, 'column' => 'rght')
		),
		'tableParameters' => array()
	);
	public $menus = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true),
		'alias' => array('type' => 'string', 'null' => true),
		'class' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'weight' => array('type' => 'integer', 'null' => true),
		'link_count' => array('type' => 'integer', 'null' => true),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'modified' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'menus_alias_key' => array('unique' => true, 'column' => 'alias')
		),
		'tableParameters' => array()
	);
	public $message_contents = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'subject' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_system_flagged' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'detected_suspicious_words' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $message_filters = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'from_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'to_user_id' => array('type' => 'integer', 'null' => true),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null),
		'has_words' => array('type' => 'string', 'null' => true, 'default' => null),
		'does_not_has_words' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'message_filters_from_user_id_idx' => array('unique' => false, 'column' => 'from_user_id'),
			'message_filters_subject_idx' => array('unique' => false, 'column' => 'subject'),
			'message_filters_to_user_id_idx' => array('unique' => false, 'column' => 'to_user_id'),
			'message_filters_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $message_folders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'message_folders_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'other_user_id' => array('type' => 'integer', 'null' => true),
		'parent_message_id' => array('type' => 'integer', 'null' => true),
		'message_content_id' => array('type' => 'integer', 'null' => true),
		'message_folder_id' => array('type' => 'integer', 'null' => true),
		'is_sender' => array('type' => 'boolean', 'null' => true),
		'is_starred' => array('type' => 'boolean', 'null' => true),
		'is_read' => array('type' => 'boolean', 'null' => true),
		'is_deleted' => array('type' => 'boolean', 'null' => true),
		'is_archived' => array('type' => 'boolean', 'null' => true),
		'is_communication' => array('type' => 'boolean', 'null' => true),
		'hash' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'size' => array('type' => 'integer', 'null' => true),
		'job_id' => array('type' => 'integer', 'null' => true),
		'job_order_id' => array('type' => 'integer', 'null' => true),
		'is_review' => array('type' => 'boolean', 'null' => true),
		'job_order_status_id' => array('type' => 'integer', 'null' => true),
		'job_order_dispute_id' => array('type' => 'integer', 'null' => true),
		'is_auto' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'messages_job_id_idx' => array('unique' => false, 'column' => 'job_id'),
			'messages_job_order_dispute_id_idx' => array('unique' => false, 'column' => 'job_order_dispute_id'),
			'messages_job_order_id_idx' => array('unique' => false, 'column' => 'job_order_id'),
			'messages_job_order_status_id_idx' => array('unique' => false, 'column' => 'job_order_status_id'),
			'messages_message_content_id_idx' => array('unique' => false, 'column' => 'message_content_id'),
			'messages_message_folder_id_idx' => array('unique' => false, 'column' => 'message_folder_id'),
			'messages_other_user_id_idx' => array('unique' => false, 'column' => 'other_user_id'),
			'messages_parent_message_id_idx' => array('unique' => false, 'column' => 'parent_message_id'),
			'messages_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $meta = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'model' => array('type' => 'string', 'null' => true, 'default' => 'Node'),
		'foreign_key' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'weight' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $money_transfer_accounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'account' => array('type' => 'string', 'null' => true, 'length' => 100),
		'is_default' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'money_transfer_accounts_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'money_transfer_accounts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $nodes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'title' => array('type' => 'string', 'null' => true),
		'slug' => array('type' => 'string', 'null' => true),
		'body' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'excerpt' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'status' => array('type' => 'boolean', 'null' => true),
		'mime_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'comment_status' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'comment_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'promote' => array('type' => 'boolean', 'null' => true),
		'path' => array('type' => 'string', 'null' => true),
		'terms' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'sticky' => array('type' => 'boolean', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'node', 'length' => 100),
		'type_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'plugin_name' => array('type' => 'string', 'null' => true, 'length' => 220),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'nodes_lft_idx' => array('unique' => false, 'column' => 'lft'),
			'nodes_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'nodes_plugin_name_idx' => array('unique' => false, 'column' => 'plugin_name'),
			'nodes_rght_idx' => array('unique' => false, 'column' => 'rght'),
			'nodes_slug_idx' => array('unique' => false, 'column' => 'slug'),
			'nodes_type_id_idx' => array('unique' => false, 'column' => 'type_id'),
			'nodes_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $nodes_taxonomies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'node_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'taxonomy_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'nodes_taxonomies_node_id_idx' => array('unique' => false, 'column' => 'node_id'),
			'nodes_taxonomies_taxonomy_id_idx' => array('unique' => false, 'column' => 'taxonomy_id')
		),
		'tableParameters' => array()
	);
	public $payment_gateway_settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'type' => array('type' => 'string', 'null' => true, 'default' => null),
		'options' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'test_mode_value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'live_mode_value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'payment_gateway_settings_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id')
		),
		'tableParameters' => array()
	);
	public $payment_gateways = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'display_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'gateway_fees' => array('type' => 'float', 'null' => true),
		'transaction_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'payment_gateway_setting_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_test_mode' => array('type' => 'boolean', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'is_mass_pay_enabled' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $privacy_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $regions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'length' => 100),
		'alias' => array('type' => 'string', 'null' => true, 'length' => 100),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'block_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'regions_alias_key' => array('unique' => true, 'column' => 'alias')
		),
		'tableParameters' => array()
	);
	public $request_favorites = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'request_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'request_favorites_request_id_idx' => array('unique' => false, 'column' => 'request_id'),
			'request_favorites_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $request_flag_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => true),
		'modified' => array('type' => 'date', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'request_flag_count' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'request_flag_categories_name_idx' => array('unique' => false, 'column' => 'name'),
			'request_flag_categories_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $request_flags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'request_id' => array('type' => 'integer', 'null' => true),
		'request_flag_category_id' => array('type' => 'integer', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'request_flags_request_flag_category_id_idx' => array('unique' => false, 'column' => 'request_flag_category_id'),
			'request_flags_request_id_idx' => array('unique' => false, 'column' => 'request_id'),
			'request_flags_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $request_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'request_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'request_views_request_id_idx' => array('unique' => false, 'column' => 'request_id'),
			'request_views_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $requests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'amount' => array('type' => 'integer', 'null' => true),
		'slug' => array('type' => 'string', 'null' => true),
		'address' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'latitude' => array('type' => 'float', 'null' => true),
		'longitude' => array('type' => 'float', 'null' => true),
		'zoom_level' => array('type' => 'integer', 'null' => true, 'default' => '5'),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_system_flagged' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'admin_suspend' => array('type' => 'boolean', 'null' => true),
		'detected_suspicious_words' => array('type' => 'string', 'null' => true, 'default' => null),
		'job_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_type_id' => array('type' => 'integer', 'null' => true),
		'job_category_id' => array('type' => 'integer', 'null' => true),
		'request_flag_count' => array('type' => 'integer', 'null' => true),
		'request_view_count' => array('type' => 'integer', 'null' => true),
		'request_favorite_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_approved' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'requests_job_category_id_idx' => array('unique' => false, 'column' => 'job_category_id'),
			'requests_job_type_id_idx' => array('unique' => false, 'column' => 'job_type_id'),
			'requests_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $revisions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'type' => array('type' => 'string', 'null' => true, 'length' => 15),
		'node_id' => array('type' => 'integer', 'null' => true),
		'content' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'revision_number' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'revisions_node_id_idx' => array('unique' => false, 'column' => 'node_id'),
			'revisions_revision_number_idx' => array('unique' => false, 'column' => 'revision_number'),
			'revisions_type_idx' => array('unique' => false, 'column' => 'type'),
			'revisions_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'roles_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $security_questions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'slug' => array('type' => 'string', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'security_questions_name_idx' => array('unique' => false, 'column' => 'name'),
			'security_questions_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $send_moneys = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'pay_key' => array('type' => 'string', 'null' => true, 'length' => 100),
		'is_success' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'send_moneys_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $setting_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'plugin_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'setting_categories_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'setting_category_id' => array('type' => 'integer', 'null' => true),
		'setting_category_parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8),
		'options' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'label' => array('type' => 'string', 'null' => true, 'default' => null),
		'order' => array('type' => 'integer', 'null' => true),
		'plugin_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'settings_name_idx' => array('unique' => false, 'column' => 'name'),
			'settings_setting_category_id_idx' => array('unique' => false, 'column' => 'setting_category_id')
		),
		'tableParameters' => array()
	);
	public $site_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'site_categories_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $social_contact_details = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'length' => 250),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'facebook_user_id' => array('type' => 'string', 'null' => true, 'length' => 150),
		'twitter_user_id' => array('type' => 'string', 'null' => true, 'length' => 150),
		'googleplus_user_id' => array('type' => 'string', 'null' => true, 'length' => 150),
		'linkedin_user_id' => array('type' => 'string', 'null' => true, 'length' => 150),
		'social_contact_count' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'social_contact_details_facebook_user_id_idx' => array('unique' => false, 'column' => 'facebook_user_id'),
			'social_contact_details_twitter_user_id_idx' => array('unique' => false, 'column' => 'twitter_user_id')
		),
		'tableParameters' => array()
	);
	public $social_contacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'social_source_id' => array('type' => 'integer', 'null' => true),
		'social_contact_detail_id' => array('type' => 'integer', 'null' => true),
		'social_user_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'social_contacts_social_contact_detail_id_idx' => array('unique' => false, 'column' => 'social_contact_detail_id'),
			'social_contacts_social_source_id_idx' => array('unique' => false, 'column' => 'social_source_id'),
			'social_contacts_social_user_id_idx' => array('unique' => false, 'column' => 'social_user_id'),
			'social_contacts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $states = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'country_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8),
		'adm1code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4),
		'is_approved' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'states_country_id_idx' => array('unique' => false, 'column' => 'country_id')
		),
		'tableParameters' => array()
	);
	public $subscriptions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'email' => array('type' => 'string', 'null' => true, 'length' => 100),
		'is_subscribed' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'unsubscribed_on' => array('type' => 'date', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'invite_hash' => array('type' => 'string', 'null' => true, 'default' => null),
		'site_state_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_sent_private_beta_mail' => array('type' => 'boolean', 'null' => true),
		'is_social_like' => array('type' => 'boolean', 'null' => true),
		'is_invite' => array('type' => 'boolean', 'null' => true),
		'invite_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_email_verified' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'subscriptions_email_idx' => array('unique' => false, 'column' => 'email'),
			'subscriptions_invite_user_id_idx' => array('unique' => false, 'column' => 'invite_user_id'),
			'subscriptions_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'subscriptions_site_state_id_idx' => array('unique' => false, 'column' => 'site_state_id'),
			'subscriptions_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $sudopay_ipn_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'ip' => array('type' => 'integer', 'null' => true),
		'post_variable' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $sudopay_payment_gateways = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'sudopay_gateway_name' => array('type' => 'string', 'null' => true),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_group_id' => array('type' => 'integer', 'null' => true),
		'sudopay_gateway_details' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'days_after_amount_paid' => array('type' => 'integer', 'null' => true),
		'is_marketplace_supported' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'sudopay_payment_gateways_sudopay_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_gateway_id'),
			'sudopay_payment_gateways_sudopay_payment_group_id_idx' => array('unique' => false, 'column' => 'sudopay_payment_group_id')
		),
		'tableParameters' => array()
	);
	public $sudopay_payment_gateways_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'sudopay_payment_gateways_users_sudopay_payment_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_payment_gateway_id'),
			'sudopay_payment_gateways_users_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $sudopay_payment_groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'sudopay_group_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'thumb_url' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'sudopay_payment_groups_sudopay_group_id_idx' => array('unique' => false, 'column' => 'sudopay_group_id')
		),
		'tableParameters' => array()
	);
	public $sudopay_transaction_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'payment_id' => array('type' => 'integer', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null),
		'merchant_id' => array('type' => 'integer', 'null' => true),
		'gateway_id' => array('type' => 'integer', 'null' => true),
		'gateway_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'payment_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'buyer_id' => array('type' => 'integer', 'null' => true),
		'buyer_email' => array('type' => 'string', 'null' => true, 'default' => null),
		'buyer_address' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'sudopay_transaction_logs_buyer_id_idx' => array('unique' => false, 'column' => 'buyer_id'),
			'sudopay_transaction_logs_class_idx' => array('unique' => false, 'column' => 'class'),
			'sudopay_transaction_logs_foreign_id_idx' => array('unique' => false, 'column' => 'foreign_id'),
			'sudopay_transaction_logs_gateway_id_idx' => array('unique' => false, 'column' => 'gateway_id'),
			'sudopay_transaction_logs_merchant_id_idx' => array('unique' => false, 'column' => 'merchant_id'),
			'sudopay_transaction_logs_payment_id_idx' => array('unique' => false, 'column' => 'payment_id')
		),
		'tableParameters' => array()
	);
	public $taxonomies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'term_id' => array('type' => 'integer', 'null' => true),
		'vocabulary_id' => array('type' => 'integer', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'taxonomies_lft_idx' => array('unique' => false, 'column' => 'lft'),
			'taxonomies_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'taxonomies_rght_idx' => array('unique' => false, 'column' => 'rght'),
			'taxonomies_term_id_idx' => array('unique' => false, 'column' => 'term_id'),
			'taxonomies_vocabulary_id_idx' => array('unique' => false, 'column' => 'vocabulary_id')
		),
		'tableParameters' => array()
	);
	public $temp_contacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'contact_id' => array('type' => 'integer', 'null' => true),
		'contact_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'contact_email' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_member' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'temp_contacts_contact_id_idx' => array('unique' => false, 'column' => 'contact_id'),
			'temp_contacts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $terms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true),
		'slug' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'terms_slug_key' => array('unique' => true, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $timezones = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'gmt_offset' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $transaction_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_credit' => array('type' => 'boolean', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'transaction_variables' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $transactions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25),
		'transaction_type_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'gateway_fees' => array('type' => 'float', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'transactions_class_idx' => array('unique' => false, 'column' => 'class'),
			'transactions_foreign_id_idx' => array('unique' => false, 'column' => 'foreign_id'),
			'transactions_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'transactions_transaction_type_id_idx' => array('unique' => false, 'column' => 'transaction_type_id'),
			'transactions_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $translations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'language_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'lang_text' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_translated' => array('type' => 'boolean', 'null' => true),
		'is_google_translate' => array('type' => 'boolean', 'null' => true),
		'is_verified' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'translations_language_id_idx' => array('unique' => false, 'column' => 'language_id')
		),
		'tableParameters' => array()
	);
	public $types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true),
		'alias' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'format_show_author' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'format_show_date' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'comment_status' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'comment_approve' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'comment_spam_protection' => array('type' => 'boolean', 'null' => true),
		'comment_captcha' => array('type' => 'boolean', 'null' => true),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'plugin' => array('type' => 'string', 'null' => true, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'types_alias_key' => array('unique' => true, 'column' => 'alias')
		),
		'tableParameters' => array()
	);
	public $types_vocabularies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'type_id' => array('type' => 'integer', 'null' => true),
		'vocabulary_id' => array('type' => 'integer', 'null' => true),
		'weight' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'types_vocabularies_vocabulary_id_idx' => array('unique' => false, 'column' => 'vocabulary_id')
		),
		'tableParameters' => array()
	);
	public $user_add_wallet_amounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'pay_key' => array('type' => 'string', 'null' => true, 'length' => 100),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'is_success' => array('type' => 'boolean', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => true),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true),
		'sudopay_revised_amount' => array('type' => 'float', 'null' => true),
		'sudopay_token' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_add_wallet_amounts_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'user_add_wallet_amounts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_cash_withdrawals = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'withdrawal_status_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'remark' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_cash_withdrawals_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'user_cash_withdrawals_withdrawal_status_id_idx' => array('unique' => false, 'column' => 'withdrawal_status_id')
		),
		'tableParameters' => array()
	);
	public $user_friends = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'friend_user_id' => array('type' => 'integer', 'null' => true),
		'friend_status_id' => array('type' => 'integer', 'null' => true),
		'is_requested' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_friends_friend_status_id_idx' => array('unique' => false, 'column' => 'friend_status_id'),
			'user_friends_friend_user_id_idx' => array('unique' => false, 'column' => 'friend_user_id'),
			'user_friends_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_logins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'user_login_ip' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'host' => array('type' => 'string', 'null' => true, 'length' => 50),
		'user_agent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_logins_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_notifications = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'is_new_order_buyer_notification' => array('type' => 'boolean', 'null' => true),
		'is_new_order_seller_notification' => array('type' => 'boolean', 'null' => true),
		'is_accept_order_seller_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_accept_order_buyer_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_reject_order_seller_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_reject_order_buyer_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_cancel_order_seller_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_cancel_order_buyer_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_review_order_seller_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_review_order_buyer_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_complete_order_seller_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_complete_order_buyer_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_expire_order_seller_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_expire_order_buyer_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_admin_cancel_order_seller_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_admin_cancel_buyer_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_cleared_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_contact_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_in_progress_overtime_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_complete_later_order_buyer_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_complete_later_order_seller_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_receive_redeliver_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_recieve_mutual_cancel_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_recieve_dispute_notification' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_notifications_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_openids = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'openid' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_openids_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'full_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'mobile_phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'contact_address' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'about_me' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'message_page_size' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'latitude' => array('type' => 'float', 'null' => true),
		'longitude' => array('type' => 'float', 'null' => true),
		'zoom_level' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_profiles_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'viewing_user_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'host' => array('type' => 'string', 'null' => true, 'length' => 50),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_views_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'user_views_viewing_user_id_idx' => array('unique' => false, 'column' => 'viewing_user_id')
		),
		'tableParameters' => array()
	);
	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'role_id' => array('type' => 'integer', 'null' => true),
		'username' => array('type' => 'string', 'null' => true, 'default' => null),
		'email' => array('type' => 'string', 'null' => true, 'default' => null),
		'password' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'referred_by_user_id' => array('type' => 'integer', 'null' => true),
		'fb_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'fb_access_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'user_openid_count' => array('type' => 'integer', 'null' => true),
		'user_login_count' => array('type' => 'integer', 'null' => true),
		'user_view_count' => array('type' => 'integer', 'null' => true),
		'job_count' => array('type' => 'integer', 'null' => true),
		'active_job_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_favorite_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_feedback_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'positive_feedback_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_flag_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'job_view_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'request_flag_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'request_view_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'cookie_hash' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'cookie_time_modified' => array('type' => 'datetime', 'null' => true),
		'is_openid_register' => array('type' => 'boolean', 'null' => true),
		'is_gmail_register' => array('type' => 'boolean', 'null' => true),
		'is_yahoo_register' => array('type' => 'boolean', 'null' => true),
		'is_agree_terms_conditions' => array('type' => 'boolean', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'is_email_confirmed' => array('type' => 'boolean', 'null' => true),
		'is_affiliate_user' => array('type' => 'boolean', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'last_login_ip_id' => array('type' => 'integer', 'null' => true),
		'signup_ip' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15),
		'last_login_ip' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15),
		'last_logged_in_time' => array('type' => 'datetime', 'null' => true),
		'available_balance_amount' => array('type' => 'float', 'null' => true),
		'available_purchase_amount' => array('type' => 'float', 'null' => true),
		'blocked_amount' => array('type' => 'float', 'null' => true),
		'status_message' => array('type' => 'string', 'null' => true, 'default' => null),
		'cleared_amount' => array('type' => 'float', 'null' => true),
		'cleared_blocked_amount' => array('type' => 'float', 'null' => true),
		'total_commission_pending_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'total_commission_canceled_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'total_commission_completed_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'total_amount_withdrawn' => array('type' => 'float', 'null' => true),
		'total_withdraw_request_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'commission_line_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'commission_withdraw_request_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'commission_paid_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'available_wallet_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'twitter_access_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'twitter_access_key' => array('type' => 'string', 'null' => true, 'default' => null),
		'twitter_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'site_state_id' => array('type' => 'integer', 'null' => true),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => true),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_receiver_account_id' => array('type' => 'integer', 'null' => true),
		'user_avatar_source_id' => array('type' => 'integer', 'null' => true),
		'user_referred_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'last_sent_inactive_mail' => array('type' => 'datetime', 'null' => true),
		'sent_inactive_mail_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'referred_purchase_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'affiliate_refer_purchase_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'referred_by_user_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sales_cleared_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sales_cleared_amount' => array('type' => 'float', 'null' => true),
		'sales_pipeline_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sales_pipeline_amount' => array('type' => 'float', 'null' => true),
		'sales_lost_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sales_lost_amount' => array('type' => 'float', 'null' => true),
		'request_count' => array('type' => 'integer', 'null' => true),
		'request_favorite_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'in_progress_overtime_meet_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_received_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_accepted_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_success_without_overtime_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_success_with_overtime_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_failure_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_active_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'order_last_accepted_date' => array('type' => 'datetime', 'null' => true),
		'buyer_order_purchase_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_order_sucess_without_overtime_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_order_sucess_with_overtime_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_order_active_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_waiting_for_acceptance_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_in_progress_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_in_progress_overtime_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_review_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_completed_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_cancelled_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_rejected_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_cancelled_late_order_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_expired_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_redeliver_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_payment_pending_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'seller_waiting_for_acceptance' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'seller_in_progress_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'seller_in_progress_overtime_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'seller_review_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'seller_completed_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'seller_rejected_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'seller_cancelled_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'seller_expired_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'seller_redeliver_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'mean_rating' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'actual_rating' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'linkedin_user_id' => array('type' => 'string', 'null' => true),
		'linkedin_access_token' => array('type' => 'string', 'null' => true),
		'is_linkedin_register' => array('type' => 'integer', 'null' => true),
		'openid_user_id' => array('type' => 'string', 'null' => true, 'length' => 200),
		'google_user_id' => array('type' => 'string', 'null' => true),
		'google_access_token' => array('type' => 'string', 'null' => true),
		'yahoo_user_id' => array('type' => 'string', 'null' => true),
		'yahoo_access_token' => array('type' => 'string', 'null' => true),
		'is_google_connected' => array('type' => 'boolean', 'null' => true),
		'is_yahoo_connected' => array('type' => 'boolean', 'null' => true),
		'is_linkedin_connected' => array('type' => 'boolean', 'null' => true),
		'pwd_reset_token' => array('type' => 'string', 'null' => true),
		'pwd_reset_requested_date' => array('type' => 'datetime', 'null' => true),
		'security_question_id' => array('type' => 'integer', 'null' => true),
		'security_answer' => array('type' => 'string', 'null' => true),
		'fb_friends_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'twitter_followers_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'linkedin_contacts_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'google_contacts_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'yahoo_contacts_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_skipped_fb' => array('type' => 'boolean', 'null' => true),
		'is_skipped_twitter' => array('type' => 'boolean', 'null' => true),
		'is_skipped_linkedin' => array('type' => 'boolean', 'null' => true),
		'is_skipped_google' => array('type' => 'boolean', 'null' => true),
		'is_skipped_yahoo' => array('type' => 'boolean', 'null' => true),
		'googleplus_user_id' => array('type' => 'string', 'null' => true),
		'is_googleplus_connected' => array('type' => 'boolean', 'null' => true),
		'googleplus_contacts_count' => array('type' => 'integer', 'null' => true),
		'googleplus_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'google_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'linkedin_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_facebook_connected' => array('type' => 'boolean', 'null' => true),
		'is_facebook_register' => array('type' => 'boolean', 'null' => true),
		'facebook_access_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'facebook_user_id' => array('type' => 'integer', 'null' => true),
		'purchase_cleared_amount' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'purchase_cleared_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'purchase_pipeline_amount' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'purchase_pipeline_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'purchase_lost_amount' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'purchase_lost_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_twitter_register' => array('type' => 'boolean', 'null' => true),
		'is_twitter_connected' => array('type' => 'boolean', 'null' => true),
		'twitter_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'activity_message_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_idle' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_job_posted' => array('type' => 'boolean', 'null' => true),
		'is_job_requested' => array('type' => 'boolean', 'null' => true),
		'is_engaged' => array('type' => 'boolean', 'null' => true),
		'is_googleplus_register' => array('type' => 'boolean', 'null' => false),
		'is_google_register' => array('type' => 'boolean', 'null' => false),
		'sudopay_payment_gateways_user_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'buyer_mutual_cancelled_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'seller_mutual_cancelled_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'users_actual_rating_idx' => array('unique' => false, 'column' => 'actual_rating'),
			'users_email_idx' => array('unique' => false, 'column' => 'email'),
			'users_fb_user_id_idx' => array('unique' => false, 'column' => 'fb_user_id'),
			'users_mean_rating_idx' => array('unique' => false, 'column' => 'mean_rating'),
			'users_referred_by_user_id_idx' => array('unique' => false, 'column' => 'referred_by_user_id'),
			'users_role_id_idx' => array('unique' => false, 'column' => 'role_id'),
			'users_twitter_user_id_idx' => array('unique' => false, 'column' => 'twitter_user_id'),
			'users_username_idx' => array('unique' => false, 'column' => 'username')
		),
		'tableParameters' => array()
	);
	public $vocabularies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true),
		'alias' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'required' => array('type' => 'boolean', 'null' => true),
		'multiple' => array('type' => 'boolean', 'null' => true),
		'tags' => array('type' => 'boolean', 'null' => true),
		'plugin' => array('type' => 'string', 'null' => true, 'default' => null),
		'weight' => array('type' => 'integer', 'null' => true),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'vocabularies_alias_key' => array('unique' => true, 'column' => 'alias')
		),
		'tableParameters' => array()
	);
	public $withdrawal_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'user_cash_withdrawal_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
}
