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
class Request extends AppModel
{
    public $name = 'Request';
    public $displayField = 'name';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'name'
            )
        ) ,
        'SuspiciousWordsDetector' => array(
            'fields' => array(
                'name',
                'address'
            )
        ) ,
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
			'counterScope' => array(
                'Request.is_active' => 1,
                'Request.is_approved' => 1,
                'Request.admin_suspend' => 0,
            )
        ) ,
        'JobType' => array(
            'className' => 'Jobs.JobType',
            'foreignKey' => 'job_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'Request.is_active' => 1,
                'Request.is_approved' => 1,
                'Request.admin_suspend' => 0,
            )
        ) ,
        'JobCategory' => array(
            'className' => 'Jobs.JobCategory',
            'foreignKey' => 'job_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'Request.is_active' => 1,
                'Request.is_approved' => 1,
                'Request.admin_suspend' => 0,
            )
        ) ,
    );
    public $hasMany = array(
        'RequestView' => array(
            'className' => 'Requests.RequestView',
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
        ) ,
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
        ) ,
        'RequestFavorite' => array(
            'className' => 'RequestFavorites.RequestFavorite',
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
        )
    );
    public $hasAndBelongsToMany = array(
        'Job' => array(
            'className' => 'Jobs.Job',
            'joinTable' => 'jobs_requests',
            'foreignKey' => 'request_id',
            'associationForeignKey' => 'job_id',
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
        $this->moreActions = array(
            ConstMoreAction::Suspend => __l('Suspend') ,
            ConstMoreAction::Unsuspend => __l('Unsuspend') ,
            ConstMoreAction::Approved => __l('Approved') ,
            ConstMoreAction::Disapproved => __l('Disapproved') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
        $this->validate = array(
            'name' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'job_type_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'job_category_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'address' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
        );
    }
}
?>