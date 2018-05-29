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
 * Setting Category Model
 *
 * Site settings.
 *
 */
class SettingCategory extends AppModel
{
    public $name = 'SettingCategory';
    public $displayField = 'name';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $hasMany = array(
        'Setting' => array(
            'className' => 'Setting',
            'foreignKey' => 'setting_category_id',
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
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
    function afterFind($results, $primary = false)
    {
        $job_alternate_name = strtolower(Configure::read('job.job_alternate_name'));
        $job_alternate_name = !empty($job_alternate_name) ? $job_alternate_name : 'jobs';
        $job_alternate_name_plural = Inflector::pluralize($job_alternate_name);
        $job_alternate_name_singular = Inflector::singularize($job_alternate_name);
        $request_alternate_name = strtolower(Configure::read('request.request_alternate_name'));
        $request_alternate_name = !empty($request_alternate_name) ? $request_alternate_name : 'requests';
        $request_alternate_name_plural = Inflector::pluralize($request_alternate_name);
        $request_alternate_name_singular = Inflector::singularize($request_alternate_name);
        $replaceable_words = array(
            'jobs' => $job_alternate_name_plural,
            'job' => $job_alternate_name_singular,
            'Jobs' => ucfirst($job_alternate_name_plural) ,
            'Job' => ucfirst($job_alternate_name_singular) ,
            'requests' => $request_alternate_name_plural,
            'request' => $request_alternate_name_singular,
            'Requests' => ucfirst($request_alternate_name_plural) ,
            'Request' => ucfirst($request_alternate_name_singular)
        );
        // loop through results
        foreach($results as &$row) {
            // loop through fields
            if (is_array($row)) {
                foreach($row as $main_key => &$field) {
                    // check field exists
                    if (!is_array($field)) {
                        foreach($replaceable_words as $key => $word) $field = preg_replace('/' . $key . '/', $word, $field);
                    } else
                    // for second level
                    {
                        foreach($field as $sub_key => &$sub_field) foreach($replaceable_words as $key => $word1) $sub_field = preg_replace('/' . $key . '/', $word1, $sub_field);
                    }
                }
            }
        }
        return $results;
    }
}
