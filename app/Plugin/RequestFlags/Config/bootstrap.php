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
        'Request Flags' => array(
            'title' => sprintf(__l('%s Flags'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)) ,
            'url' => array(
                'controller' => 'request_flags',
                'action' => 'index',
            ) ,
            'weight' => 90,
        )
    )
));
CmsNav::add('masters', array(
    'title' => __l('Masters') ,
	'weight' => 100,
	'children' => array(
		'Requests' => array(
			'title' => requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps) ,
			'url' => '',
			'weight' => 380,
		) ,
		'Request Flag Categories' => array(
			'title' => sprintf(__l('%s Flag Categories'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)) ,
			'url' => array(
				'admin' => true,
				'controller' => 'request_flag_categories',
				'action' => 'index',
			) ,
			'weight' => 390,
		)
	)
));
$defaultModel = array();
if (isPluginEnabled('Requests')) {
    $pluginModel = array(
        'Request' => array(
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
				),
            ) ,	
		) ,
		'User' => array(
			'hasMany' => array(
				'RequestFlag' => array(
					'className' => 'RequestFlags.RequestFlag',
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
				),
			) ,			
		) ,
    );
    $defaultModel = $defaultModel + $pluginModel;
}
CmsHook::bindModel($defaultModel);