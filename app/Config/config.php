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
/**
 * Custom configurations
 */
 if (!defined('DEBUG')) {
    define('DEBUG', 0);
    // permanent cache re1ated settings
    define('PERMANENT_CACHE_CHECK', (!empty($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] != '127.0.0.1') ? true : false);
    // site default language
    define('PERMANENT_CACHE_DEFAULT_LANGUAGE', 'en');
    // cookie variable name for site language
    define('PERMANENT_CACHE_COOKIE', 'user_language');
	// salt used in setcookie
    define('PERMANENT_CACHE_GZIP_SALT', 'e9a556134534545ab47c6c81c14f06c0b8sdfsdf');
	// Enable support for HTML5 History/State API
	// By enabling this, users will not see full page load
	define('IS_ENABLE_HTML5_HISTORY_API', false);
	// Force hashbang based URL for all browsers
	// When this is disabled, browsers that don't support History API (IE, etc) alone will use hashbang based URL. When enabled, all browsers--including links in Google search results will use hashbang based URL (similar to new Twitter).
    define('IS_ENABLE_HASHBANG_URL', false);
    $_is_hashbang_supported_bot = (!empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Googlebot') !== false);
    define('IS_HASHBANG_SUPPORTED_BOT', $_is_hashbang_supported_bot);
}
$config['debug'] = DEBUG;
$config['site']['license_key'] = 'enter your license key';
// site actions that needs random attack protection...
$config['site']['_hashSecuredActions'] = array(
    'edit',
    'delete',
    'update',
    'admin_update_status',
    'download',
);
 $config['permanent_cache']['view_action'] = array(
    'jobs',
    'requests',
    'users',
);
$config['photo']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
		'image/pjpeg',
		'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
	'allowEmpty' => true
);
$config['job_category']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
		'image/pjpeg',
		'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '1',
    'allowedSizeUnits' => 'MB',
	'allowEmpty' => true
);
$config['message']['file'] = array(
    'allowedSize' => '*',
);
$config['invite']['file'] = array(
    'allowedMime' => array(
        'text/csv',
    ) ,
    'allowedExt' => array(
        'csv',
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
	'allowEmpty' => false
);
$config['avatar']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
		'image/pjpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
$config['job']['file'] = array(
    'allowedMime' => '*',
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png',
        'doc',
        'pdf',
        'xls',
        'wmv',
        'txt',
        'flv',
		'zip',
		'rar'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
// CDN...
$config['cdn']['images'] = null; // 'http://images.localhost/';
$config['cdn']['css'] = null; // 'http://static.localhost/';

$config['site']['site_element_cache_2_min'] = '2 min';
$config['site']['site_element_cache_5_min'] = '5 min';
$config['site']['site_element_cache_10_min'] = '10 min';
$config['site']['site_element_cache_15_min'] = '15 min';
$config['site']['site_element_cache_1_hour'] = '1 hour';
$config['site']['site_element_cache_1_day'] = '1 day';
$config['site']['site_element_cache_1_week'] = '1 week';


// $_SERVER['HTTP_HOST']
$config['Page']['home_page_id'] = 1;
$default_timezone = 'Europe/Berlin';
if (ini_get('date.timezone')) {
	$default_timezone = ini_get('date.timezone');
}
date_default_timezone_set($default_timezone);
/*
date_default_timezone_set('Asia/Calcutta');

Configure::write('Config.language', 'spa');
setlocale (LC_TIME, 'es');
*/
/*
 ** to do move to settings table
*/
if (class_exists('CmsHook') && method_exists('CmsHook', 'setExceptionUrl')) {
    CmsHook::setExceptionUrl(array(
            'pages/view',
			'users/facepile',
            'nodes/display',
            'nodes/how_it_works',
            'jobs/index',
            'jobs/view',
            'jobs/youtube_url_print',
            'jobs/v',
            'requests/index',
            'requests/view',
            'requests/v',
            'job_categories/index',
            'users/register',
            'users/login',
            'users/logout',
            'users/reset',
            'users/forgot_password',
            'users/openid',
            'users/activation',
            'users/resend_activation',
            'users/view',
            'users/top_rated',
            'users/show_captcha',
            'users/captcha_play',
            'images/view',
            'users/refer',
            'devs/robots',
            'contacts/add',
            'users/admin_login',
            'users/admin_logout',
            'languages/change_language',
            'contacts/show_captcha',
            'contacts/captcha_play',
            'job_orders/processpayment',
            'job_orders/payment_success',
            'job_orders/payment_cancel',
            'user_cash_withdrawals/process_masspay_ipn',
            'job_feedbacks/index',
            'users/oauth_callback',
            'pages/view',
            'pages/display',
            'pages/home',
            'pages/term-and-conditions',
            'pages/about',
            'devs/sitemap',
            'crons/update_job_orders',
            'crons/auto_expire',
            'crons/inactive_users',
            'crons/in_progress_overtime',
            'crons/auto_review_complete',
            'job_types/index',
            'affiliates/index',
			'users/oauth_facebook',
			'devs/asset_css',
			'devs/asset_js',
			'subscriptions/confirmation',
			'subscriptions/add',
            'subscriptions/check_invitation',
			'high_performances/update_content',
			'users/show_header',
			'users/show_notification',
			'nodes/view',
			'nodes/display',
			'nodes/home',
			'nodes/term-and-conditions',
			'sudopays/process_ipn',
            'sudopays/success_payment',
            'sudopays/cancel_payment',
            'sudopays/update_account',
			'jobs/job_location',
			'requests/request_location',
			'devs/yadis',
    ));
}
$config['sitemap']['models'] = array(
    'Job' => array(
		'fields' => array(
			'slug',
			'id'
		) ,
		'conditions' => array(
			'Job.is_active' => 1,
            'Job.is_approved' => 1,
            'Job.admin_suspend' => 0,
            'Job.is_deleted' => 0
		)
	),
	'User' => array(
		'fields' => array(
			'username',
			'id'
		) ,
		'conditions' => array(
			'User.is_active' => 1,
            'User.is_email_confirmed' => 1,
            'User.role_id !=' => 1,
		)
	)
);
$config['StretchType']=array(
     "Repeat" => 'bg-repeat',
     "Stretch" => 'bg-stretch',
     "AutoResize" => 'bg-stretch-autoresize'
);
$config['site']['is_admin_settings_enabled'] = true;
if ($_SERVER['HTTP_HOST'] == 'fpplatform.dev.agriya.com' && !in_array($_SERVER['REMOTE_ADDR'], array('115.111.183.202', '118.102.143.2', '119.82.115.146', '122.183.135.202', '122.183.136.34', '122.183.136.36'))) {
	$config['site']['is_admin_settings_enabled'] = false;
	$config['site']['admin_demomode_updation_not_allowed_array'] = array(
		'nodes/admin_edit',
		'nodes/admin_delete',
		'users/admin_change_password',
		'users/admin_send_mail',
	);
	$config['site']['admin_demo_mode_not_allowed_actions'] = array(
		'admin_delete',
		'admin_update',
	);
}

?>