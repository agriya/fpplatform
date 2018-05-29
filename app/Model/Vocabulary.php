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
class Vocabulary extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'Vocabulary';
    /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    public $actsAs = array(
        'Ordered' => array(
            'field' => 'weight',
            'foreign_key' => false,
        ) ,
        'Cached' => array(
            'prefix' => array(
                'vocabulary_',
                'cms_vocabulary_',
                'cms_vocabularies_',
            ) ,
        ) ,
    );
    /**
     * Model associations: hasAndBelongsToMany
     *
     * @var array
     * @access public
     */
    public $hasAndBelongsToMany = array(
        'Type' => array(
            'className' => 'Type',
            'joinTable' => 'types_vocabularies',
            'foreignKey' => 'vocabulary_id',
            'associationForeignKey' => 'type_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => '',
        ) ,
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'title' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
            ) ,
            'alias' => array(
                'rule2' => array(
                    'rule' => 'isUnique',
                    'message' => __l('Already exists') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required') ,
                    'allowEmpty' => false
                ) ,
            ) ,
        );
    }
}
