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
/* SVN FILE: $Id: routes.php 173 2009-01-31 12:51:40Z rajesh_04ag02 $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7820 $
 * @modifiedby    $LastChangedBy: renan.saddam $
 * @lastmodified  $Date: 2008-11-03 23:57:56 +0530 (Mon, 03 Nov 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
CakePlugin::routes();
Router::parseExtensions('rss', 'csv', 'json', 'txt', 'kml', 'xml', 'svg', 'js','css');

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
CmsRouter::Connect('/', array('controller' => 'nodes', 'action' => 'home'));
//  pages/install as home page...
//	CmsRouter::Connect('/', array('controller' => 'jobs', 'action' => 'index'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */ 
CmsRouter::connect('/admin', array(
	'controller' => 'users',
	'action' => 'stats',
	'prefix' => 'admin',
	'admin' => true
));
	// Basic
CmsRouter::connect('/how-it-works', array(
    'controller' => 'nodes',
    'action' => 'how_it_works',
));
CmsRouter::connect('/promoted/*', array(
    'controller' => 'nodes',
    'action' => 'promoted'
));
CmsRouter::connect('/search/*', array(
    'controller' => 'nodes',
    'action' => 'search'
));
// Node
CmsRouter::connect('/node', array(
    'controller' => 'nodes',
    'action' => 'index',
    'type' => 'node'
));
CmsRouter::connect('/node/archives/*', array(
    'controller' => 'nodes',
    'action' => 'index',
    'type' => 'node'
));
CmsRouter::connect('/node/:slug', array(
    'controller' => 'nodes',
    'action' => 'view',
    'type' => 'node'
));
CmsRouter::connect('/node/term/:slug/*', array(
    'controller' => 'nodes',
    'action' => 'term',
    'type' => 'node'
));
// Page
CmsRouter::connect('/page/:slug/*', array(
    'controller' => 'nodes',
    'action' => 'view',
    'type' => 'page'
));
CmsRouter::connect('/contactus', array(
    'controller' => 'contacts',
    'action' => 'add'
));

	//Code to show the images uploaded by upload behaviour
	CmsRouter::Connect('/img/:size/*', array('controller' => 'images', 'action' => 'view'), array('size' => '(?:[a-zA-Z_]*)*'));
	CmsRouter::Connect('/files/*', array('controller' => 'images', 'action' => 'view', 'size' => 'original'));
	CmsRouter::Connect('/img/*', array('controller' => 'images', 'action' => 'view', 'size' => 'original'));

	CmsRouter::connect('/users/register', array(
		'controller' => 'users',
		'action' => 'register',
		'type' => 'social'
	));
	CmsRouter::connect('/users/register/manual', array(
		'controller' => 'users',
		'action' => 'register'
	));
	CmsRouter::connect('/users/twitter/login', array(
			'controller' => 'users',
			'action' => 'login',
			'type' => 'twitter'
	));
	CmsRouter::connect('/users/facebook/login', array(
        'controller' => 'users',
        'action' => 'login',
        'type' => 'facebook'
    ));
	CmsRouter::connect('/users/yahoo/login', array(
			'controller' => 'users',
			'action' => 'login',
			'type' => 'yahoo'
	));	
	CmsRouter::connect('/users/gmail/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'gmail'
    ));
    CmsRouter::connect('/users/googleplus/login', array(
			'controller' => 'users',
			'action' => 'login',
			'type' => 'googleplus'
	));
	CmsRouter::connect('/users/openid/login', array(
			'controller' => 'users',
			'action' => 'login',
			'type' => 'openid'
	));
    CmsRouter::connect('/users/linkedin/login', array(
			'controller' => 'users',
			'action' => 'login',
			'type' => 'linkedin'
	));
	CmsRouter::Connect('/cron/:action/*', array(
        'controller' => 'crons',
    ));
	CmsRouter::connect('/contactus', array(
		'controller' => 'contacts',
		'action' => 'add'
	));
	CmsRouter::Connect('/feeds', array('controller' => 'jobs', 'action' => 'index'));
	CmsRouter::Connect('/sitemap', array('controller' => 'devs', 'action' => 'sitemap'));
	CmsRouter::Connect('/robots', array('controller' => 'devs', 'action' => 'robots'));
    CmsRouter::Connect('/feedback', array('controller' => 'contacts', 'action' => 'add'));
	CmsRouter::Connect('/css/*', array(
        'controller' => 'devs',
        'action' => 'asset_css'
    ));
	CmsRouter::Connect('/js/*', array(
        'controller' => 'devs',
        'action' => 'asset_js'
    ));
  //  RootPagesCache::connect();
/**
 * Wildflower root pages routes cache API
 *
 * Pages without a parent are each passed to Route::connect().
 *
 * @package wildflower
 */
 
if(!class_exists('RootPagesCache')){
	class RootPagesCache {

		static function connect() {
			$file = Configure::read('Page.rootPageCache');
			$rootPages = array();

			if (file_exists($file)) {
				$content = file_get_contents($file);
				$rootPages = json_decode($content, true);
			} else {
				$rootPages = self::update();
			};

			if (!is_array($rootPages)) {
				$rootPages = self::update();
			}
				if(!empty($rootPages)){
					foreach ($rootPages as $page) {
							CmsRouter::Connect('/about-us', array('controller' => 'pages', 'action' => 'v', 'id' => 2));
						// It's children
					/*	$children = $page['Page']['url'] . '/*';
						CmsRouter::Connect(
							$children,
							array('controller' => 'pages', 'action' => 'v')
						);*/
					}
				}
		}
		static function update() {
			return Router::requestAction(array('controller' => 'pages', 'action' => 'update_rootcache'), array('return' => 1));
		}
	}
}
?>