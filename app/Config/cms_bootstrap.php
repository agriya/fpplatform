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
 * Default Acl plugin.  Custom Acl plugin should override this value.
 */
Configure::write('Site.acl_plugin', 'Acl');
/**
 * Locale
 */
Configure::write('Config.language', 'eng');
/**
 * Admin theme
 */
//Configure::write('Site.admin_theme', 'sample');

/**
 * Cache configuration
 */
$cacheConfig = array(
    'duration' => '+1 hour',
    'path' => CACHE . 'queries',
    'engine' => 'File',
);
// models
Cache::config('setting_write_configuration', $cacheConfig);
// components
Cache::config('cms_blocks', $cacheConfig);
Cache::config('cms_menus', $cacheConfig);
Cache::config('cms_nodes', $cacheConfig);
Cache::config('cms_types', $cacheConfig);
Cache::config('cms_vocabularies', $cacheConfig);
// controllers
Cache::config('nodes_view', $cacheConfig);
Cache::config('nodes_promoted', $cacheConfig);
Cache::config('nodes_term', $cacheConfig);
Cache::config('nodes_index', $cacheConfig);
Cache::config('contacts_view', $cacheConfig);
/**
 * Failed login attempts
 *
 * Default is 5 failed login attempts in every 5 minutes
 */
Configure::write('User.failed_login_limit', 5);
Configure::write('User.failed_login_duration', 300);
Cache::config('users_login', array_merge($cacheConfig, array(
    'duration' => '+' . Configure::read('User.failed_login_duration') . ' seconds',
)));
/**
 * Plugins
 */
$aclPlugin = Configure::read('Site.acl_plugin');
$pluginBootstraps = Configure::read('Hook.bootstraps');
$plugins = array_filter(explode(',', $pluginBootstraps));
if (!in_array($aclPlugin, $plugins)) {
    $plugins = Set::merge($aclPlugin, $plugins);
}
foreach($plugins AS $plugin) {
    $pluginName = Inflector::camelize($plugin);
    if (!file_exists(APP . 'Plugin' . DS . $pluginName)) {
        CakeLog::write(LOG_ERR, 'Plugin not found during bootstrap: ' . $pluginName);
        continue;
    }
    $bootstrapFile = APP . 'Plugin' . DS . $pluginName . DS . 'Config' . DS . 'bootstrap.php';
    $bootstrap = file_exists($bootstrapFile);
    $routesFile = APP . 'Plugin' . DS . $pluginName . DS . 'Config' . DS . 'routes.php';
    $routes = file_exists($routesFile);
    $option = array(
        $pluginName => array(
            'bootstrap' => $bootstrap,
            'routes' => $routes,
        )
    );
    CmsPlugin::load($option);
    _pluginControllerCache($pluginName);
}
_pluginControllerCache('Extensions');
function _pluginControllerCache($pluginName)
{
    $plugins_controllers = Cache::read($pluginName . '_controllers_list', 'long');
    if ($plugins_controllers != 'null' || $plugins_controllers === false) {
        $plugins_controllers = App::objects($pluginName . '.Controller');
		// alternate name
		$job_alternate_name = strtolower(Configure::read('job.job_alternate_name'));
		$job_alternate_name  = !empty($job_alternate_name) ? $job_alternate_name : 'jobs';
		$job_alternate_name_plural =  Inflector::pluralize($job_alternate_name);
		$job_alternate_name_singular =  Inflector::singularize($job_alternate_name);
		$job_array = array(
			'jobs',
			'job_orders',
			'job_favorites',
			'job_categories',
			'job_feedbacks',
			'job_flags',
			'job_flag_categories',
			'job_views',
			'job_types',
		);
		// Possible controllers for with name request
		$request_alternate_name = strtolower(Configure::read('request.request_alternate_name'));
		$request_alternate_name  = !empty($request_alternate_name) ? $request_alternate_name : 'requests';
		$request_alternate_name_plural =  Inflector::pluralize($request_alternate_name);
		$request_alternate_name_singular =  Inflector::singularize($request_alternate_name);
		$request_array = array(
			'requests',
			'request_orders',
			'request_favorites',
			'request_categories',
			'request_feedbacks',
			'request_flags',
			'request_flag_categories',
			'request_views',
		);
		//
        foreach($plugins_controllers as $value) {
			$value = str_replace('_controller', '', Inflector::underscore($value));
			$new_plugins_controllers[] = '\/' . $value;
			if(in_array($value, $request_array)) {
				if($value == 'requests') {
					$new_plugins_controllers[] = '\/' .$request_alternate_name_plural;
				} else {
					$url_exploded= explode('_', $value);
					unset($url_exploded[0]);
					$new_plugins_controllers[] = '\/' . $request_alternate_name_singular . '_' . implode('_', $url_exploded);
				}
			}
			if(in_array($value, $job_array)) {
				if($value == 'jobs') {
					$new_plugins_controllers[] = '\/' . $job_alternate_name_plural;
				} else {
					$url_exploded= explode('_', $value);
					unset($url_exploded[0]);
					$new_plugins_controllers[] = '\/' . $job_alternate_name_singular . '_' . implode('_', $url_exploded);
				}
			}
        }
        foreach($new_plugins_controllers as $key) {
            $new_plugins_controllers[] = Inflector::singularize($key) . '\/';
        }
        $plugins_controllers = implode('|', $new_plugins_controllers);
        Cache::write($pluginName . '_controllers_list', $plugins_controllers, 'long');
    }
    Configure::write('plugins.' . strtolower(Inflector::underscore($pluginName)) , $plugins_controllers);
}
CmsEventManager::loadListeners();
