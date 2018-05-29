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
	$request_alternate_name = strtolower(Configure::read('request.request_alternate_name', 'long'));
	$request_alternate_name  = !empty($request_alternate_name) ? $request_alternate_name : 'requests';
	$request_alternate_name_plural =  Inflector::pluralize($request_alternate_name);
	$request_alternate_name_singular =  Inflector::singularize($request_alternate_name);
	
	CmsRouter::Connect('/'.$request_alternate_name_plural.'/category/:category', array(
		'controller' => 'requests',
		'action' => 'index'),
		array('category' => '[^\/]+')
	);
	CmsRouter::Connect('/'.$request_alternate_name_plural.'/amount/:amount', array(
		'controller' => 'requests',
		'action' => 'index'),
		array('amount' => '[^\/]+')
	);
	CmsRouter::Connect('/'.$request_alternate_name_plural.'/filter/:filter', array(
		'controller' => 'requests',
		'action' => 'index'),
		array('filter' => '[^\/]+')
	);
 	CmsRouter::Connect('/'.$request_alternate_name_plural.'/manage', array(
		'controller' => 'requests',
		'action' => 'index',
		'type' => 'manage_requests',
	));
	CmsRouter::Connect('/'.$request_alternate_name_singular.'/*', array(
		'controller' => 'requests',
		'action' => 'view',
	));
	CmsRouter::Connect('/'.$request_alternate_name_plural.'/:action/*', array(
		'controller' => 'requests',
	));
	CmsRouter::Connect('/'.$request_alternate_name_plural, array(
		'controller' => 'requests',
	));

	CmsRouter::Connect('/admin/'.$request_alternate_name_plural.'/:action/*', array(
		'controller' => 'requests',
		'admin' => true
	));

	CmsRouter::Connect('/admin/'.$request_alternate_name_plural, array(
		'controller' => 'requests',
		'admin' => true
	));

    $request_models = array(
		'request_views',
		'request_flags',
		'request_flag_categories',
		'request_favorites',

	);
	foreach($request_models  as $request_model)
	{
		$request_model_exploded= explode('_', $request_model);
		unset($request_model_exploded[0]);
		$model_with_new_prefix = $request_alternate_name_singular.'_' . implode('_', $request_model_exploded);

		// For User index
		CmsRouter::Connect('/'.$model_with_new_prefix.'/:action/*', array(
			'controller' =>  $request_model,
		));
		// For User view
		CmsRouter::Connect('/'.$model_with_new_prefix.'/*', array(
			'controller' =>  $request_model,
			'action' => 'view',
		));
		// For Admin index
		CmsRouter::Connect('/admin/'.$model_with_new_prefix.'/:action/*', array(
			'controller' =>  $request_model,
			'admin' => 1
		));
		CmsRouter::Connect('/admin/'.$model_with_new_prefix, array(
			'controller' =>  $request_model,
			'admin' => 1
		));
		// for Admin View
		CmsRouter::Connect('/admin/'.$model_with_new_prefix.'/*', array(
			'controller' =>  $request_model,
			'action' => 'view',
			'admin' => 1
		));
	}