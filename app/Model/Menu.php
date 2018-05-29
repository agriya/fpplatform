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
class Menu extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'Menu';
    /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    public $actsAs = array(
        'Cached' => array(
            'prefix' => array(
                'link_',
                'menu_',
                'cms_menu_',
            ) ,
        ) ,
        'Params',
    );
    /**
     * Model associations: hasMany
     *
     * @var array
     * @access public
     */
    public $hasMany = array(
        'Link' => array(
            'className' => 'Link',
            'foreignKey' => 'menu_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'Link.lft ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ) ,
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'title' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
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
