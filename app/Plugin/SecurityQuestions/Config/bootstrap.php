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
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 100,
	'children' => array(
        'Account' => array(
            'title' => __l('Account') ,
            'url' => '',
            'weight' => 500,
        ) ,
        'Security Questions' => array(
            'title' => __l('Security Questions') ,
            'url' => array(
                'controller' => 'security_questions',
                'action' => 'index'
            ) ,
            'weight' => 510,
        ) ,
    )
));
$defaultModel = array(
    'User' => array(
        'belongsTo' => array(
            'SecurityQuestion' => array(
                'className' => 'SecurityQuestions.SecurityQuestion',
                'foreignKey' => 'security_question_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
        ) ,
    ) ,
);
CmsHook::bindModel($defaultModel);