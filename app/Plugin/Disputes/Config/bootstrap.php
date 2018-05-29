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
		'disputes' => array(
            'title' => __l('Disputes') ,
            'url' => array(
                'admin' => true,
                'controller' => 'job_order_disputes',
                'action' => 'admin_index',
            ) ,
            'weight' => 90,
        ) ,
    )
));
$defaultModel = array(
'User' => array(
	'hasMany' => array(	
		'JobOrderDispute' => array(
					'className' => 'Disputes.JobOrderDispute',
					'foreignKey' => 'user_id',
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
			),
		),
'Message' => array(
	'hasMany' => array(	
		'JobOrderDispute' => array(
					'className' => 'Disputes.JobOrderDispute',
					'foreignKey' => 'message_id',
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
			),
		),
);
if (isPluginEnabled('Jobs')) {
    $pluginModel = array(
        'DisputeType' => array(
            'belongsTo' => array(
                'JobUserType' => array(
					'className' => 'Jobs.JobUserType',
					'foreignKey' => 'job_user_type_id',
					'conditions' => '',
					'fields' => '',
					'order' => '',
				),
            ) ,	
			'hasMany' => array(
				'JobOrderDispute' => array(
					'className' => 'Disputes.JobOrderDispute',
					'foreignKey' => 'dispute_type_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
				),
			),
        ) ,
		'DisputeClosedType' => array(
			'belongsTo' => array(
				'JobUserType' => array(
					'className' => 'Jobs.JobUserType',
					'foreignKey' => 'job_user_type_id',
					'conditions' => '',
					'fields' => '',
					'order' => '',
				),
            ) ,
			'hasMany' => array(
				'JobOrderDispute' => array(
					'className' => 'Disputes.JobOrderDispute',
					'foreignKey' => 'dispute_closed_type_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
				),
			),
		),
		'DisputeStatus' => array(
			'hasMany' => array(
				'JobOrderDispute' => array(
					'className' => 'Disputes.JobOrderDispute',
					'foreignKey' => 'dispute_status_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
				),
			),
		),
		'JobOrderDispute' => array(
			'belongsTo' => array(
				'DisputeType' => array(
					'className' => 'Disputes.DisputeType',
					'foreignKey' => 'dispute_type_id',
					'conditions' => '',
					'fields' => '',
					'order' => '',
				) ,
				'DisputeStatus' => array(
					'className' => 'Disputes.DisputeStatus',
					'foreignKey' => 'dispute_status_id',
					'conditions' => '',
					'fields' => '',
					'order' => '',
				) ,
				'DisputeClosedType' => array(
					'className' => 'Disputes.DisputeClosedType',
					'foreignKey' => 'dispute_closed_type_id',
					'conditions' => '',
					'fields' => '',
					'order' => '',
				)
			) ,
			'hasMany' => array(
				'JobOrderDispute' => array(
					'className' => 'Disputes.JobOrderDispute',
					'foreignKey' => 'job_order_id',
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
		)
    );
    $defaultModel = $defaultModel + $pluginModel;
}
CmsHook::bindModel($defaultModel);
?>