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
class Job extends AppModel
{
    public $name = 'Job';
    public $displayField = 'title';
    public $actsAs = array(
        'Versionable' => array(
            'modified',
            'title',
            'amount',
            'job_category_id',
            'description',
            'no_of_days',
            'commission_amount',
            'youtube_url',
            'flickr_url',
        ) ,
        'Sluggable' => array(
            'label' => array(
                'title'
            )
        ) ,
        'SuspiciousWordsDetector' => array(
            'fields' => array(
                'title',
                'description',
                'tag',
                'address',
                'mobile'
            )
        ) ,
        'Taggable',
        'Aggregatable',
    );
    var $aggregatingFields = array(
        'active_sale_count' => array(
            'mode' => 'real',
            'key' => 'job_id',
            'foreignKey' => 'job_id',
            'model' => 'Jobs.JobOrder',
            'function' => 'COUNT(JobOrder.job_id)',
            'conditions' => array(
                'JobOrder.job_order_status_id' => array(
                    ConstJobOrderStatus::InProgress,
                    ConstJobOrderStatus::InProgressOvertime,
                    ConstJobOrderStatus::WaitingforReview
                )
            )
        ) ,
        'complete_sale_count' => array(
            'mode' => 'real',
            'key' => 'job_id',
            'foreignKey' => 'job_id',
            'model' => 'Jobs.JobOrder',
            'function' => 'COUNT(JobOrder.job_id)',
            'conditions' => array(
                'JobOrder.job_order_status_id' => array(
                    ConstJobOrderStatus::Completed,
                    ConstJobOrderStatus::PaymentCleared,
                    ConstJobOrderStatus::CompletedAndClosedByAdmin,
                )
            )
        ) ,
        'order_waiting_for_acceptance' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'Jobs.JobOrder',
            'function' => 'COUNT(JobOrder.owner_user_id)',
            'conditions' => array(
                'JobOrder.job_order_status_id' => ConstJobOrderStatus::WaitingforAcceptance,
            )
        ) ,
        'order_in_progress_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'Jobs.JobOrder',
            'function' => 'COUNT(JobOrder.owner_user_id)',
            'conditions' => array(
                'JobOrder.job_order_status_id' => ConstJobOrderStatus::InProgress,
            )
        ) ,
        'order_in_progress_overtime_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'Jobs.JobOrder',
            'function' => 'COUNT(JobOrder.owner_user_id)',
            'conditions' => array(
                'JobOrder.job_order_status_id' => ConstJobOrderStatus::InProgressOvertime,
            )
        ) ,
        'order_review_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'Jobs.JobOrder',
            'function' => 'COUNT(JobOrder.owner_user_id)',
            'conditions' => array(
                'JobOrder.job_order_status_id' => ConstJobOrderStatus::WaitingforReview,
            )
        ) ,
        'order_completed_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'Jobs.JobOrder',
            'function' => 'COUNT(JobOrder.owner_user_id)',
            'conditions' => array(
                'JobOrder.job_order_status_id' => array(
                    ConstJobOrderStatus::Completed,
                    ConstJobOrderStatus::PaymentCleared,
                    ConstJobOrderStatus::CompletedAndClosedByAdmin,
                )
            )
        ) ,
        'order_rejected_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'Jobs.JobOrder',
            'function' => 'COUNT(JobOrder.owner_user_id)',
            'conditions' => array(
                'JobOrder.job_order_status_id' => array(
                    ConstJobOrderStatus::Rejected,
                )
            )
        ) ,
        'order_cancelled_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'Jobs.JobOrder',
            'function' => 'COUNT(JobOrder.owner_user_id)',
            'conditions' => array(
                'JobOrder.job_order_status_id' => array(
                    ConstJobOrderStatus::Cancelled,
                    ConstJobOrderStatus::CancelledByAdmin,
                    ConstJobOrderStatus::CancelledDueToOvertime,
                )
            )
        ) ,
        'order_expired_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'Jobs.JobOrder',
            'function' => 'COUNT(JobOrder.owner_user_id)',
            'conditions' => array(
                'JobOrder.job_order_status_id' => ConstJobOrderStatus::Expired,
            )
        ) ,
        'redeliver_count' => array(
            'mode' => 'real',
            'key' => 'job_id',
            'foreignKey' => 'job_id',
            'model' => 'Jobs.JobOrder',
            'function' => 'COUNT(JobOrder.job_id)',
            'conditions' => array(
                'JobOrder.redeliver_count' => array(
                    ConstJobOrderStatus::Redeliver,
                )
            )
        ) ,
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'JobCategory' => array(
            'className' => 'Jobs.JobCategory',
            'foreignKey' => 'job_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'Job.is_active' => 1,
                'Job.is_approved' => 1,
                'Job.admin_suspend' => 0,
                'Job.is_deleted' => 0
            )
        ) ,
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'JobType' => array(
            'className' => 'Jobs.JobType',
            'foreignKey' => 'job_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'Job.is_active' => 1,
                'Job.is_approved' => 1,
                'Job.admin_suspend' => 0,
                'Job.is_deleted' => 0
            )
        ) ,
        'JobServiceLocation' => array(
            'className' => 'Jobs.JobServiceLocation',
            'foreignKey' => 'job_service_location_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'JobCoverageRadiusUnit' => array(
            'className' => 'Jobs.JobCoverageRadiusUnit',
            'foreignKey' => 'job_coverage_radius_unit_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
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
    public $hasMany = array(
        'JobFeedback' => array(
            'className' => 'Jobs.JobFeedback',
            'foreignKey' => 'job_id',
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
        'JobOrder' => array(
            'className' => 'Jobs.JobOrder',
            'foreignKey' => 'job_id',
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
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'conditions' => array(
                'Attachment.class =' => 'Job'
            ) ,
            'dependent' => true
        ) ,
        'JobView' => array(
            'className' => 'Jobs.JobView',
            'foreignKey' => 'job_id',
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
    );
    public $hasAndBelongsToMany = array(
        'JobTag' => array(
            'className' => 'Jobs.JobTag',
            'joinTable' => 'jobs_job_tags',
            'foreignKey' => 'job_id',
            'associationForeignKey' => 'job_tag_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ) ,
        'Request' => array(
            'className' => 'Request',
            'joinTable' => 'jobs_requests',
            'foreignKey' => 'job_id',
            'associationForeignKey' => 'request_id',
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
        $min_day = Configure::read('job.min_days');
        $max_day = Configure::read('job.max_days');
        $this->validate = array(
            'title' => array(
                'rule2' => array(
                    'rule' => array(
                        'between',
                        Configure::read('job.minimum_title_length') ,
                        Configure::read('job.maximum_title_length'),
                    ) ,
                    'message' => sprintf(__l('Must be between of') . ' ' . Configure::read('job.minimum_title_length') . ' to ' . Configure::read('job.maximum_title_length'))
                ) ,
		'rule3' => array(
                    'rule' => array(
                        '_betweencheck',
                        Configure::read('job.minimum_title_length') ,
                        Configure::read('job.maximum_title_length'),
                    ) ,
                    'message' => sprintf(__l('Must be between of') . ' ' . Configure::read('job.minimum_title_length') . ' to ' . Configure::read('job.maximum_title_length'))
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Enter work name')
                ) ,
            ) ,
            'slug' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'address' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'mobile' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'job_coverage_radius' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'description' => array(
                'rule2' => array(
                    'rule' => array(
                        '_checkDescriptionLength',
                        'description'
                    ) ,
                    'message' => __l('Maximum allowed character length ' . Configure::read('job.maximum_description_length'))
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'job_category_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'tag' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'tag' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'no_of_days' => array(
                'rule4' => array(
                    'rule' => array(
                        'custom',
                        '/^[1-9]\d*\.?[0]*$/'
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Should be a number')
                ) ,
                'rule3' => array(
                    'rule' => array(
                        '_checkNumber',
                        'no_of_days',
                        $min_day,
                        $max_day,
                    ) ,
                    'message' => __l('Should be greater than or equal to ' . Configure::read('job.min_days') . ' day(s) and less than or equal to ' . Configure::read('job.max_days') . ' day(s)')
                ) ,
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Should be numeric')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Enter valid numeric value')
                ) ,
            ) ,
            'youtube_url' => array(
                'rule' => 'url',
                'message' => __l('Enter valid URL') ,
                'allowEmpty' => true,
            ) ,
            'flickr_url' => array(
                'rule' => 'url',
                'allowEmpty' => true,
                'message' => __l('Enter valid URL') ,
            ) ,
        );
        $this->moreActions = array(
            ConstMoreAction::Feature => __l('Feature') ,
            ConstMoreAction::Unfeature => __l('Unfeatured') ,
            ConstMoreAction::Suspend => __l('Suspend') ,
            ConstMoreAction::Unsuspend => __l('Unsuspend') ,
            ConstMoreAction::Flagged => __l('Flag') ,
            ConstMoreAction::Unflagged => __l('Clear flag') ,
            ConstMoreAction::ActivateUser => __l('Activate') . ' ' . jobAlternateName() . ' ' . __l('seller') ,
            ConstMoreAction::DeActivateUser => __l('Deactivate') . ' ' . jobAlternateName() . ' ' . __l('seller') ,
            ConstMoreAction::Approved => __l('Approved') ,
            ConstMoreAction::Disapproved => __l('Disapproved') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function _checkNumber($field1 = array() , $field2 = null)
    {
        if (($this->data[$this->name][$field2] >= Configure::read('job.min_days')) && ($this->data[$this->name][$field2] <= Configure::read('job.max_days'))) {
            return true;
        }
        return false;
    }
    //Validation check in JS just function declaration here
    function _betweencheck($field1,$field2){
	return true;
    }
    function _checkDescriptionLength($field1 = array() , $field2 = null)
    {
        $replace1 = str_replace("\n", '', $this->data[$this->name][$field2]);
        $replace2 = strlen(str_replace("\t", '', $replace1));
        if ($replace2 > Configure::read('job.maximum_description_length')) {
            return false;
        } else {
            return true;
        }
    }
    function getCommisonforAmount($amount)
    {
        $job_amounts = explode(',', Configure::read('job.price'));
        $commission_amounts = explode(',', Configure::read('job.commission_amount'));
        if (count($job_amounts) == count($commission_amounts)) $amount_commsion_array = array_combine($job_amounts, $commission_amounts);
        else $amount_commsion_array = array_combine($job_amounts, array_fill(0, count($job_amounts) , $commission_amounts[0]));
        if (Configure::read('job.commission_type') == ConstCommsisionType::Amount) return $amount_commsion_array[$amount];
        else return $amount_commsion_array[$amount]*$amount*.01;
    }
    function getImageUrl($model, $attachment, $options)
    {
        $default_options = array(
            'dimension' => 'big_thumb',
            'class' => '',
            'alt' => 'alt',
            'title' => 'title',
            'type' => 'jpg'
        );
        $options = array_merge($default_options, $options);
        $image_hash = $options['dimension'] . '/' . $model . '/' . $attachment['id'] . '.' . md5(Configure::read('Security.salt') . $model . $attachment['id'] . $options['type'] . $options['dimension'] . Configure::read('site.name')) . '.' . $options['type'];
        return Cache::read('site_url_for_shell', 'long') . 'img/' . $image_hash;
    }
    function beforeDelete($cascade = true)
    {
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'Jobs.Message');
        $this->Message = new Message();
        $this->Transaction->deleteAll(array(
            'Transaction.class' => 'JobOrder',
            'Transaction.foreign_id' => $this->id
        ));
        $this->Message->deleteAll(array(
            'Message.Job_id' => $this->id
        ) , $cascade = true);
        return 'deleted';
    }
    function beforeSave($options = array())
    {
        if (isset($this->data['Job']['request_id'])) {
            $this->request_id = $this->data['Job']['request_id'];
        }
        return true;
    }
    function afterSave($created)
    {
        if ($created) {
            $job_id = $this->getLastInsertId();
            $job = $this->find('first', array(
                'conditions' => array(
                    'Job.id' => $job_id
                ) ,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                            'User.available_balance_amount',
                            'User.blocked_amount',
                            'User.cleared_amount',
                            'User.available_purchase_amount',
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                '_trackEvent' => array(
                    'category' => 'User',
                    'action' => sprintf(__l('%s Posted') , jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps)) ,
                    'label' => $_SESSION['Auth']['User']['username'],
                    'value' => $_SESSION['Auth']['User']['id'],
                ) ,
                '_setCustomVar' => array(
                    'ud' => $_SESSION['Auth']['User']['id'],
                    'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                )
            ));
            Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                '_trackEvent' => array(
                    'category' => 'Job',
                    'action' => 'Posted',
                    'label' => $job['Job']['title'],
                    'value' => $job_id,
                ) ,
                '_setCustomVar' => array(
                    'ud' => $_SESSION['Auth']['User']['id'],
                    'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                )
            ));
            if (!empty($this->request_id)) {
                $this->_updateJobRequest($this->request_id, $this->getLastInsertId());
            }
        }
        return true;
    }
    function _updateJobRequest($request_id, $job_id)
    {
        $job_request = $this->JobsRequest->find('count', array(
            'conditions' => array(
                'JobsRequest.job_id' => $job_id,
                'JobsRequest.request_id' => $request_id,
            ) ,
        ));
        if (!$job_request) {
            $this->data['JobsRequest']['request_id'] = $request_id;
            $this->data['JobsRequest']['job_id'] = $job_id;
            $this->JobsRequest->save($this->data['JobsRequest']);
            $reques_count = $this->JobsRequest->find('count', array(
                'conditions' => array(
                    'JobsRequest.job_id' => $job_id,
                ) ,
            ));
            $job_count = $this->JobsRequest->find('count', array(
                'conditions' => array(
                    'JobsRequest.request_id' => $request_id,
                ) ,
            ));
            $this->Request->updateAll(array(
                'Request.job_count' => $job_count,
            ) , array(
                'Request.id' => $request_id
            ));
            $this->updateAll(array(
                'Job.request_count' => $reques_count,
            ) , array(
                'Job.id' => $job_id
            ));
        }
        $this->_requestJobNotificationMail($request_id, $job_id);
    }
    function _requestJobNotificationMail($request_id, $job_id)
    {
        App::import('Model', 'Jobs.Message');
        $this->Message = new Message();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        $request_job = $this->find('first', array(
            'conditions' => array(
                'Job.id' => $job_id
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.available_balance_amount',
                        'User.blocked_amount',
                        'User.cleared_amount',
                        'User.available_purchase_amount',
                    )
                )
            ) ,
            'recursive' => 0
        ));
        $request_user = $this->Request->find('first', array(
            'conditions' => array(
                'Request.id' => $request_id
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email'
                    )
                ) ,
            ) ,
            'recursive' => 0
        ));
        $emailFindReplace = array(
            '##USERNAME##' => $request_user['User']['username'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##ACTIVATION_URL##' => Router::url(array(
                'controller' => 'jobs',
                'action' => 'view',
                $request_job['Job']['slug'],
            ) , true) ,
            '##SITE_LINK##' => Router::url('/', true) ,
            '##JOB_ALTERNATIVE_NAME##' => jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) ,
            '##REQUEST_ALTERNATIVE_NAME##' => requestAlternateName(ConstRequestAlternateName::Plural) ,
            '##REQUEST_URL##' => "<a href=" . Router::url(array(
                'controller' => 'requests',
                'action' => 'view',
                $request_user['Request']['slug']
            ) , true) . " target = '_blank' title='" . $request_user['Request']['name'] . "'>" . $request_user['Request']['name'] . "</a>",
            '##JOB_URL##' => "<a href=" . Router::url(array(
                'controller' => 'jobs',
                'action' => 'view',
                $request_job['Job']['slug']
            ) , true) . " target = '_blank' title = '" . $request_job['Job']['title'] . "'>" . $request_job['Job']['title'] . "</a>",
        );
        $sender_email = $request_job['User']['email'];
        $email = $this->EmailTemplate->selectTemplate('Requested Job Notification');
        $to = $request_user['User']['id'];
        $subject = strtr($email['subject'], $emailFindReplace);
        $message = strtr($email['email_text_content'], $emailFindReplace);
        $is_auto = 1;
        if (Configure::read('messages.is_send_internal_message')) {
            $message_id = $this->Message->sendNotifications($to, $subject, $message, 0, 0, $job_id, '0', '0', $is_auto);
            if (Configure::read('messages.is_send_email_on_new_message')) {
                $content['subject'] = __l('New') . ' ' . jobAlternateName(ConstJobAlternateName::Singular) . ' ' . __l('has been posted for your') . ' ' . requestAlternateName(ConstRequestAlternateName::Singular) . '.';
                $content['subject'] = __l('New') . ' ' . jobAlternateName(ConstJobAlternateName::Singular) . ' ' . __l('has been posted for your') . ' ' . requestAlternateName(ConstRequestAlternateName::Singular) . '.';
                $content['message'] = __l('New') . ' ' . jobAlternateName(ConstJobAlternateName::Singular) . ' ' . __l('has been posted for your') . ' ' . requestAlternateName(ConstRequestAlternateName::Singular) . '.';
                $content['message'] = __l('New') . ' ' . jobAlternateName(ConstJobAlternateName::Singular) . ' ' . __l('has been posted for your') . ' ' . requestAlternateName(ConstRequestAlternateName::Singular) . '.';
                $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
            }
        }
    }
}
?>