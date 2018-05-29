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
class Meta extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'Meta';
    /**
     * Table name
     *
     * @var string
     * @access public
     */
    public $useTable = 'meta';
    /**
     * Model associations: belongsTo
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Node' => array(
            'className' => 'Node',
            'foreignKey' => 'foreign_key',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
    );
}
