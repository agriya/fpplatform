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
// Possible controllers for with name job

	$job_alternate_name = strtolower(Configure::read('job.job_alternate_name', 'long'));
	$job_alternate_name  = !empty($job_alternate_name) ? $job_alternate_name : 'jobs';
	$job_alternate_name_plural =  Inflector::pluralize($job_alternate_name);
	$job_alternate_name_singular =  Inflector::singularize($job_alternate_name);

	CmsRouter::Connect('/'.$job_alternate_name_plural.'/add/request/:request_id', array(
		'controller' => 'jobs',
		'action' => 'add'),
		array('request_id' => '[0-9]+')
	);
	CmsRouter::Connect('/'.$job_alternate_name_plural.'/add/request/:request_id/step/:skip', array(
		'controller' => 'jobs',
		'action' => 'add'),
		array('request_id' => '[0-9]+', 'step' => 'skip')
	);
	CmsRouter::Connect('/'.$job_alternate_name_plural.'/category/:category/*', array(
		'controller' => 'jobs',
		'action' => 'index'),
		array('category' => '[^\/]+')
	);
	CmsRouter::Connect('/'.$job_alternate_name_plural.'/amount/:amount', array(
		'controller' => 'jobs',
		'action' => 'index'),
		array('amount' => '[^\/]+')
	);
	CmsRouter::Connect('/'.$job_alternate_name_plural.'/tag/:tag', array(
		'controller' => 'jobs',
		'action' => 'index'),
		array('tag' => '[^\/]+')
	);
	CmsRouter::Connect('/'.$job_alternate_name_plural.'/filter/:filter', array(
		'controller' => 'jobs',
		'action' => 'index'),
		array('filter' => '[^\/]+')
	);
 	CmsRouter::Connect('/'.$job_alternate_name_plural.'/manage', array(
		'controller' => 'jobs',
		'action' => 'index',
		'type' => 'manage_jobs',
	));
	CmsRouter::Connect('/'.$job_alternate_name_singular.'/*', array(
		'controller' => 'jobs',
		'action' => 'view',
	));
	CmsRouter::Connect('/'.$job_alternate_name_plural.'/:action/*', array(
		'controller' => 'jobs',
	));
	
	CmsRouter::Connect('/'.$job_alternate_name_plural, array(
		'controller' => 'jobs'
	));
	CmsRouter::Connect('/admin/'.$job_alternate_name_plural.'/:action/*', array(
		'controller' => 'jobs',
		'admin' => true,
		'prefix'=>'admin'
	));
	CmsRouter::Connect('/admin/'.$job_alternate_name_plural, array(
		'controller' => 'jobs',
		'admin' => true,
		'prefix'=>'admin'
	));
	CmsRouter::Connect('/admin/'.$job_alternate_name_singular.'/*', array(
		'controller' => 'jobs',
		'action' => 'view',
		'admin' => true
	));
	CmsRouter::Connect('/2:slug', array(
        'controller' => 'jobs',
        'action' => 'v',
        'view_type' => ConstViewType::NormalView
    ) , array(
        'slug' => '[a-zA-Z0-9\-]+'
    ));
    CmsRouter::Connect('/e2:slug', array(
        'controller' => 'jobs',
        'action' => 'v',
		'view_type' => ConstViewType::EmbedView
    ) , array(
        'slug' => '[a-zA-Z0-9\-]+'
    ));
	$job_models = array(
		'job_orders',
		'job_favorites',
		'job_categories',
		'job_feedbacks',
		'job_flags',
		'job_flag_categories',
		'job_views',
		'job_types',
		'job_order_disputes',
	);
	foreach($job_models  as $job_model)
	{
		$job_model_exploded= explode('_', $job_model);
		unset($job_model_exploded[0]);
		$model_with_new_prefix = $job_alternate_name_singular.'_' . implode('_', $job_model_exploded);

		// For User index
		CmsRouter::Connect('/'.$model_with_new_prefix.'/:action/*', array(
			'controller' =>  $job_model,
		));
		// For User view 
		CmsRouter::Connect('/'.$model_with_new_prefix.'/*', array(
			'controller' =>  $job_model,
			'action' => 'view',
		));
		// For Admin index
		CmsRouter::Connect('/admin/'.$model_with_new_prefix.'/:action/*', array(
			'controller' =>  $job_model,
			'admin' => 1
		));	
		CmsRouter::Connect('/admin/'.$model_with_new_prefix, array(
			'controller' =>  $job_model,
			'admin' => 1
		));	
		// for Admin View
		CmsRouter::Connect('/admin/'.$model_with_new_prefix.'/*', array(
			'controller' =>  $job_model,
			'action' => 'view',
			'admin' => 1
		));
	}
CmsRouter::connect('/messages/type/:type', array(
    'controller' => 'messages',
    'action' => 'notification',
) , array(
    'type' => '[a-zA-Z0-9\-]+'
));
