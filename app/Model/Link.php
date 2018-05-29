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
class Link extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'Link';
    /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    public $actsAs = array(
        'Encoder',
        'Tree',
        'Cached' => array(
            'prefix' => array(
                'link_',
                'menu_',
                'cms_menu_',
            ) ,
        ) ,
    );
    /**
     * Model associations: belongsTo
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Menu' => array(
            'counterCache' => true
        )
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'menu_id' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
            ) ,
            'title' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
            ) ,
            'link' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
            ) ,
        );
        $this->moreActions = array(
            ConstMoreAction::Publish => __l('Publish') ,
            ConstMoreAction::Unpublish => __l('Unpublish') ,
        );
    }
}
