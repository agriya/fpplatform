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
class JobsJobTag extends AppModel
{
    public $name = 'JobsJobTag';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Job' => array(
            'className' => 'Jobs.Job',
            'foreignKey' => 'job_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'JobTag' => array(
            'className' => 'Jobs.JobTag',
            'foreignKey' => 'job_tag_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
}
?>