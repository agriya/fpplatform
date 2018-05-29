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
class JobFeedback extends AppModel
{
    public $name = 'JobFeedback';
    public $actsAs = array(
        'Aggregatable'
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
        ) ,
        'Job' => array(
            'className' => 'Jobs.Job',
            'foreignKey' => 'job_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'JobOrder' => array(
            'className' => 'Jobs.JobOrder',
            'foreignKey' => 'job_order_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'ip_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'feedback' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
        $this->moreActions = array(
            ConstMoreAction::Unsatisfy => __l('Unsatisfied') ,
            ConstMoreAction::Satisfy => __l('Satisfied') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function beforeFind($queryData)
    {
        $queryData['conditions']['JobFeedback.is_auto_review !='] = 1;
        return parent::beforeFind($queryData);
    }
    function afterSave($created)
    {
        $jobFeedback = $this->find('first', array(
            'conditions' => array(
                'JobFeedback.id' => $this->id,
            ) ,
            'fields' => array(
                'JobFeedback.job_id',
            ) ,
            'recursive' => -1
        ));
        $this->data['JobFeedback']['job_id'] = !empty($this->data['JobFeedback']['job_id']) ? $this->data['JobFeedback']['job_id'] : $jobFeedback['JobFeedback']['job_id'];
        $this->_updateFeedbackCount($this->data['JobFeedback']['job_id']);
        return true;
    }
    function beforeDelete($cascade = true)
    {
        $jobFeedback = $this->find('first', array(
            'conditions' => array(
                'JobFeedback.id' => $this->id,
            ) ,
            'fields' => array(
                'JobFeedback.job_id',
            ) ,
            'recursive' => -1
        ));
        $this->data['JobFeedback']['job_id'] = $jobFeedback['JobFeedback']['job_id'];
        return true;
    }
    function afterDelete()
    {
        $this->_updateFeedbackCount($this->data['JobFeedback']['job_id']);
        return true;
    }
    function _updateFeedbackCount($job_id)
    {
        $jobPossitive = $this->find('count', array(
            'conditions' => array(
                'JobFeedback.job_id' => $job_id,
                'is_satisfied' => 1
            ) ,
        ));
        $emptyData = $_data['Job']['id'] = $job_id;
        $_data['Job']['positive_feedback_count'] = $jobPossitive;
        $this->User->Job->save($_data);
    }
    function _getFeedback($job_order_id)
    {
        $get_feedback = $this->find('first', array(
            'conditions' => array(
                'JobFeedback.job_order_id' => $job_order_id,
            ) ,
            'recursive' => -1
        ));
        if (!empty($get_feedback)) {
            return $get_feedback;
        } else {
            return '';
        }
    }
}
?>