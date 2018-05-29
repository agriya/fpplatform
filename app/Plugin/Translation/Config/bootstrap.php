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
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 100,
	'children' => array(
        'Translation' => array(
            'title' => __l('Translations') ,
            'url' => '',
            'weight' => 1200,
        ) ,
        'Translations' => array(
            'title' => __l('Translations') ,
            'url' => array(
                'controller' => 'translations',
                'action' => 'index',
            ) ,
            'weight' => 1210,
        ) ,
        'Language' => array(
            'title' => __l('Languages') ,
            'url' => array(
                'admin' => true,
                'controller' => 'languages',
                'action' => 'index',
            ) ,
            'access' => array(
                'admin'
            ) ,
            'weight' => 1220,
        ) ,
    )
));
App::import('Model', 'Translation.Translation');
$translation_model_obj = new Translation();
$lang_code = !empty($_COOKIE['CakeCookie']['user_language']) ? $_COOKIE['CakeCookie']['user_language'] : Configure::read('site.language');
Cache::set(array(
	'duration' => '+100 days'
));
Configure::write('lang_code', $lang_code);
$translations = Cache::read($lang_code . '_translations');
if (empty($translations) and $translations === false) {
	$translations = $translation_model_obj->find('all', array(
		'conditions' => array(
			'Language.iso2' => $lang_code
		) ,
		'fields' => array(
			'Translation.name',
			'Translation.lang_text'
		) ,
		'contain' => array(
			'Language' => array(
				'fields' => array(
					'Language.iso2'
				)
			)
		) ,
		'recursive' => 0
	));
	Cache::set(array(
		'duration' => '+100 days'
	));
	Cache::write($lang_code . '_translations', $translations);
}
if (!empty($translations)) {
    foreach($translations as $translation) {
        $GLOBALS['_langs'][$lang_code][$translation['Translation']['name']] = $translation['Translation']['lang_text'];
    }
}
$js_vars = array();
$js_trans_array = array(
	'Login',
	'Register',
	'Like',
	'Unlike',
	'Please select alteast one file',
	'Clear All Files',
	'Are you sure you want to',
	'Are you sure you want to Remove the photo?',
	'Are you sure you want to do this action?',
	'Invalid extension, Only csv is allowed',
	'Order has been Cancelled.',
	'Order has been Rejected.',
	'Order has been Accepted.',
	'No action',
	'Unable to update Order, Please try again.',
	'Please select atleast one record!',
	'You cannot delete all the Photos!',
	'Please wait...',
	'Clear Flag',
	'Suspend',
	'Unsuspend',
	'Flag',
	'has been Unsuspended.',
	'has been suspended.',
	'Flag has been cleared.',
	'has been flagged.',
	'has been approved.',
	'has been disapproved.',
	'Job has been disapproved.',
	'Job has been Approved.',
	'Approved',
	'Disapproved',
);
$job_alternate_name = Configure::read('job.job_alternate_name');
$job_alternate_name = !empty($job_alternate_name) ? $job_alternate_name : 'jobs';
$job_alternate_name_plural = Inflector::pluralize($job_alternate_name);
$job_alternate_name_singular = Inflector::singularize($job_alternate_name);
$js_trans_array['Jobs'] = $job_alternate_name_plural;
$js_trans_array['Job'] = $job_alternate_name_singular;
$js_trans_array['jobs'] = strtolower($job_alternate_name_plural);
$js_trans_array['job'] = strtolower($job_alternate_name_singular);
$request_alternate_name = Configure::read('request.request_alternate_name');
$request_alternate_name = !empty($request_alternate_name) ? $request_alternate_name : 'requests';
$request_alternate_name_plural = Inflector::pluralize($request_alternate_name);
$request_alternate_name_singular = Inflector::singularize($request_alternate_name);
$js_trans_array['Requests'] = $request_alternate_name_plural;
$js_trans_array['Request'] = $request_alternate_name_singular;
$js_trans_array['requests'] = strtolower($request_alternate_name_plural);
$js_trans_array['request'] = strtolower($request_alternate_name_singular);
foreach($js_trans_array as $k => $v) {
	Configure::write('Js.cfg.lang.' . $k, $v);
}
?>