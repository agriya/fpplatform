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
CmsNav::add('activities', array(
    'title' => __l('Activities') ,
    'weight' => 50,
	'children' => array(
        'Job Favorites' => array(
            'title' => sprintf(__l('%s Favorites'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)) ,
            'url' => array(
                'controller' => 'job_favorites',
                'action' => 'index',
            ) ,
            'weight' => 40,
        ) ,
    ) ,
));
$defaultModel = array();
if (isPluginEnabled('Jobs')) {
    $pluginModel = array(
        'Job' => array(
            'hasMany' => array(
                'JobFavorite' => array(
					'className' => 'JobFavorites.JobFavorite',
					'foreignKey' => 'job_id',
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'counterCache' => true,
				)
            ) ,
        ) ,
    );
    $defaultModel = $defaultModel + $pluginModel;
}
CmsHook::bindModel($defaultModel);
?>