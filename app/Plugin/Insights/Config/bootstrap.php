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
$content_analytics = '';
if (isPluginEnabled('IntegratedGoogleAnalytics')) {
    $content_analytics = __l('To analyze the site analytic status detail and also it shows the graphical representation of overall bounce rate and traffic');
}
CmsHook::setExceptionUrl(array(
    'insights/public_stats',
));
CmsNav::add('analytics', array(
    'title' => __l('Analytics') ,
    'data-bootstro-step' => '3',
    'data-bootstro-content' => __l('To analyze overall user registration rate, their demographics, user login rate and also the overall project posting/funding rate.') . ' ' . $content_analytics,
    'icon-class' => 'bar-chart',
    'weight' => 30,
    'children' => array(
        'insights' => array(
            'title' => __l('Insights') ,
            'url' => array(
                'admin' => true,
                'controller' => 'insights',
                'action' => 'admin_index',
            ) ,
            'weight' => 20,
        ) ,
    )
));
$defaultModel = array(
    'UserProfile' => array(
        'belongsTo' => array(
            'Education' => array(
                'className' => 'Insights.Education',
                'foreignKey' => 'education_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
            'Employment' => array(
                'className' => 'Insights.Employment',
                'foreignKey' => 'employment_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
            'Relationship' => array(
                'className' => 'Insights.Relationship',
                'foreignKey' => 'relationship_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
            'IncomeRange' => array(
                'className' => 'Insights.IncomeRange',
                'foreignKey' => 'income_range_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
        ) ,
    )
);
CmsHook::bindModel($defaultModel);
?>