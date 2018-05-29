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
    'icon-class' => 'suitcase',
    'weight' => 40,
    'data-bootstro-step' => '4',
    'data-bootstro-content' => sprintf(__l('To manage %s and %s.'), jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps), requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps)) ,
	'children' => array(
		'jobs' => array(
            'title' => jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps) ,
            'url' => array(
                'admin' => true,
                'controller' => 'jobs',
                'action' => 'admin_index',
            ) ,
            'weight' => 10,
        ) ,
	)
));
CmsNav::add('activities', array(
    'title' => __l('Activities') ,
    'weight' => 50,
	'children' => array(
		'jobViews' => array(
            'title' => sprintf(__l('%s Views'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)) ,
            'url' => array(
                'admin' => true,
                'controller' => 'job_views',
                'action' => 'admin_index',
            ) ,
            'weight' => 70,
        ) ,
		'jobOrders' => array(
            'title' => sprintf(__l('%s Orders'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)) ,
            'url' => array(
                'admin' => true,
                'controller' => 'job_orders',
                'action' => 'admin_index',
            ) ,
            'weight' => 80,
        ) ,
		'Job Feedbacks' => array(
            'title' => sprintf(__l('%s Feedbacks'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)) ,
            'url' => array(
                'controller' => 'job_feedbacks',
                'action' => 'index',
            ) ,
            'weight' => 60,
        ) ,
    )
));
CmsNav::add('masters', array(
    'title' => __l('Masters') ,
	'weight' => 100,
	'children' => array(
		'Jobs' => array(
			'title' => jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps) ,
			'url' => '',
			'weight' => 350,
		) ,
		'Job Type' => array(
			'title' => sprintf(__l('%s Type'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)) ,
			'url' => array(
				'admin' => true,
				'controller' => 'job_types',
				'action' => 'index',
			) ,
			'weight' => 355,
		),
		'Job Category' => array(
			'title' => sprintf(__l('%s Category'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)) ,
			'url' => array(
				'admin' => true,
				'controller' => 'job_categories',
				'action' => 'index',
			) ,
			'weight' => 360,
		)
	)
));
CmsHook::setExceptionUrl(array(
	'jobs/index',
	'jobs/view',
	'jobs/show_admin_control_panel'
));
$defaultModel = array(
	'Transaction' => array(
        'belongsTo' => array(
            'Job' => array(
                'className' => 'Jobs.Job',
                'foreignKey' => 'foreign_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
            ) ,
            'JobOrder' => array(
                'className' => ' Jobs.JobOrder',
                'foreignKey' => 'foreign_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
            )
        ) ,
    ) ,
    'User' => array(
		'hasMany' => array(			
			'Job' => array(
				'className' => 'Jobs.Job',
				'foreignKey' => 'user_id',
				'dependent' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => '',
			) ,
		   'JobOrder' => array(
				'className' => 'Jobs.JobOrder',
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
			'MessageFilter' => array(
				'className' => 'Jobs.MessageFilter',
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
			'Message' => array(
				'className' => 'Jobs.Message',
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
			'JobFeedback' => array(
				'className' => 'Jobs.JobFeedback',
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
		)
    ) ,
	'Job' => array(
		'hasMany' => array(
			'JobFeedback' => array(
				'className' => 'Jobs.JobFeedback',
				'foreignKey' => 'job_id',
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
		)
	),
);
if (isPluginEnabled('JobFavorites')) {
    $pluginModel = array(
        'Jobs' => array(
            'hasMany' => array(
                'JobFavorite' => array(
					'className' => 'JobFavorites.JobFavorite',
					'foreignKey' => 'job_id',
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
if (isPluginEnabled('Requests')) {
    $pluginModel = array(
        'Request' => array(
            'belongsTo' => array(
                'JobType' => array(
					'className' => 'Jobs.JobType',
					'foreignKey' => 'job_type_id',
					'conditions' => '',
					'fields' => '',
					'order' => '',
				) ,
				'JobCategory' => array(
					'className' => 'Jobs.JobCategory',
					'foreignKey' => 'job_category_id',
					'conditions' => '',
					'fields' => '',
					'order' => '',
				) ,
            ) ,
        ) ,
    );
    $defaultModel = $defaultModel + $pluginModel;
}
if (isPluginEnabled('JobFlags')) {
    $pluginModel = array(
        'Jobs' => array(
            'hasMany' => array(
                'JobFlag' => array(
					'className' => 'JobFlags.JobFlag',
					'foreignKey' => 'job_id',
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
if (isPluginEnabled('Disputes')) {
    $pluginModel = array(
        'JobUserType' => array(
            'hasMany' => array(
                'DisputeClosedType' => array(
					'className' => 'Disputes.DisputeClosedType',
					'foreignKey' => 'job_user_type_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
				) ,
				 'DisputeType' => array(
					'className' => 'Disputes.DisputeType',
					'foreignKey' => 'job_user_type_id',
					'dependent' => false,
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
if (isPluginEnabled('Requests')) {
    $pluginModel = array(
        'JobCategory' => array(
            'hasMany' => array(
                'Request' => array(
					'className' => 'Requests.Request',
					'foreignKey' => 'job_category_id',
					'dependent' => false,
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
		'JobsRequest' => array(
			'belongsTo' => array(
				'Request' => array(
					'className' => 'Requests.Request',
					'foreignKey' => 'request_id',
					'conditions' => '',
					'fields' => '',
					'order' => '',
				),
			),
		),
		'JobType' => array(
			'hasMany' => array(
                'Request' => array(
					'className' => 'Requests.Request',
					'foreignKey' => 'job_type_id',
					'dependent' => false,
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
		)
    );
    $defaultModel = $defaultModel + $pluginModel;
}
if (isPluginEnabled('Labels')) {
    $pluginModel = array(
        'Message' => array(
            'hasAndBelongsToMany' => array(
                'Label' => array(
					'className' => 'Labels.Label',
					'joinTable' => 'labels_messages',
					'foreignKey' => 'message_id',
					'associationForeignKey' => 'label_id',
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
if (isPluginEnabled('Disputes')) {
    $pluginModel = array(
        'Job' => array(
            'hasMany' => array(
				'JobOrderDispute' => array(
					'className' => 'Disputes.JobOrderDispute',
					'foreignKey' => 'job_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
				) ,
			)
        ) ,

    );
    $defaultModel = $defaultModel + $pluginModel;
}

CmsHook::bindModel($defaultModel);
?>