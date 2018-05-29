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
class Label extends AppModel
{
    public $name = 'Label';
    public $displayField = 'name';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'name'
            )
        ) ,
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $hasAndBelongsToMany = array(
        'User' => array(
            'className' => 'User',
            'joinTable' => 'labels_users',
            'foreignKey' => 'label_id',
            'associationForeignKey' => 'user_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'name' => array(
                'rule2' => array(
                    'rule' => array(
                        '_checkLabelAvailability',
                    ) ,
                    'message' => __l('Labels already exist.')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                ) ,
            )
        );
    }
    function _checkLabelAvailability()
    {
        $is_available = true;
        $id = $this->find('first', array(
            'conditions' => array(
                'Label.name' => $this->data['Label']['name']
            ) ,
            'fields' => array(
                'Label.id'
            )
        ));
        if (!empty($label_id)) {
            $label_count = $this->Label->LabelsUser->find('count', array(
                'conditions' => array(
                    'LabelsUser.label_id' => $label_id,
                    'LabelsUser.user_id' => $_SESSION['Auth']['User']['id'],
                )
            ));
            if ($label_count > 0) $is_available = false;
        }
        return $is_available;
    }
    function findLableId($label)
    {
        $id = $this->find('first', array(
            'conditions' => array(
                'Label.name' => $label
            ) ,
            'fields' => array(
                'Label.id'
            )
        ));
        if (!empty($id)) {
            return $id['Label']['id'];
        } else {
            $data['Label']['name'] = $label;
            $this->create();
            if (!empty($data['Label']['name'])) $this->save($data);
            $id = $this->id;
            return $id;
        }
    }
}
?>
