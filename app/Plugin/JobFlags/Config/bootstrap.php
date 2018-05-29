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
        'Job Flags' => array(
            'title' => sprintf(__l('%s Flags'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)) ,
            'url' => array(
                'controller' => 'job_flags',
                'action' => 'index',
            ) ,
            'weight' => 50,
        )
    )
));
CmsNav::add('masters', array(
    'title' => __l('Masters') ,
	'weight' => 100,
	'children' => array(
		'Job Flag Categories' => array(
			'title' => sprintf(__l('%s Flag Categories'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)) ,
			'url' => array(
				'admin' => true,
				'controller' => 'job_flag_categories',
				'action' => 'index',
			) ,
			'weight' => 370,
		)
	)
));
$defaultModel = array();
if (isPluginEnabled('Jobs')) {
    $pluginModel = array(
		 'User' => array(
            'hasMany' => array(
                'JobFlag' => array(
					'className' => 'JobFlags.JobFlag',
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
            ) ,
        ) ,
        'Job' => array(
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
CmsHook::bindModel($defaultModel);