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
CmsNav::add('jobs', array(
    'title' => jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps) ,
    'weight' => 40,
	'children' => array(
        'Collections' => array(
            'title' => requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps),
            'url' => array(
                'controller' => 'requests',
                'action' => 'index',
            ) ,
            'weight' => 20,
        )
    ) ,
));
if (isPluginEnabled('Requests')) {
CmsNav::add('activities', array(
    'title' => __l('Activities') ,
    'weight' => 50,
	'children' => array(
        'Request Views' => array(
            'title' => sprintf(__l('%s Views'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)) ,
            'url' => array(
                'controller' => 'request_views',
                'action' => 'index',
            ) ,
            'weight' => 80,
        )
    ) ,
));
}
$defaultModel = array(
    'User' => array(
		'hasMany' => array(	
			'Request' => array(
				'className' => 'Requests.Request',
				'foreignKey' => 'user_id',
				'dependent' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			) ,
		),
	),
);
if (isPluginEnabled('RequestFlags')) {
    $pluginModel = array(
        'Requests' => array(
            'hasMany' => array(
                'RequestFlag' => array(
					'className' => 'RequestFlags.RequestFlag',
					'foreignKey' => 'request_id',
					'dependent' => true,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
				) ,
            ) ,
        ) ,
    );
    $defaultModel = $defaultModel + $pluginModel;
}
if (isPluginEnabled('RequestFavorites')) {
    $pluginModel = array(
        'Requests' => array(
            'hasMany' => array(
                'RequestFavorite' => array(
					'className' => 'RequestFavorites.RequestFavorite',
					'foreignKey' => 'request_id',
					'dependent' => true,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
				)
            ) ,
        ) ,
    );
    $defaultModel = $defaultModel + $pluginModel;
}
if (isPluginEnabled('Jobs')) {
    $pluginModel = array(
        'Requests' => array(
			'belongsTo' => array(
                'JobCategory' => array(
					'className' => 'Jobs.JobCategory',
					'foreignKey' => 'job_category_id',
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'counterCache' => true,
					'counterScope' => array(
						'Request.is_active' => 1,
						'Request.is_approved' => 1,
						'Request.admin_suspend' => 0,
					)
				),
				'JobType' => array(
					'className' => 'Jobs.JobType',
					'foreignKey' => 'job_type_id',
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'counterCache' => true,
					'counterScope' => array(
						'Request.is_active' => 1,
						'Request.is_approved' => 1,
						'Request.admin_suspend' => 0,
					)
				) ,
            ) ,
            'hasAndBelongsToMany' => array(
                'Job' => array(
					'className' => 'Jobs.Job',
					'joinTable' => 'jobs_requests',
					'foreignKey' => 'request_id',
					'associationForeignKey' => 'job_id',
					'unique' => true,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'finderQuery' => '',
					'deleteQuery' => '',
					'insertQuery' => ''
				)
            ) ,
        ) ,
    );
    $defaultModel = $defaultModel + $pluginModel;
}
CmsHook::bindModel($defaultModel);