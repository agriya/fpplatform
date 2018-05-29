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
class MessagesController extends AppController
{
    public $name = 'Messages';
    public $components = array(
        'Email'
    );
    public $uses = array(
        'Jobs.Message',
        'Attachment',
        'Jobs.LabelsMessage',
        'Jobs.LabelsUser',
        'Jobs.Label',
        'User',
        'EmailTemplate',
        'Jobs.JobOrder',
        'Jobs.Job'
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Attachment.filename',
            'Message.Archive',
            'Message.ReportSpam',
            'Message.Delete',
            'Message.more_action_1',
            'Message.more_action_2',
            'Message.send',
            'Message.save',
            'Message.Id',
            'Message.is_starred',
            'Message.label_slug',
            'Message.folder_type',
            'Message.user_id',
            'Message.other_user_id',
            'User.username',
            'JobOrder.Id',
            'Job.title',
            'Job.id',
            'User.id',
        );
        if ((!empty($this->request->params['action']) and ($this->request->params['action'] == 'move_to')) || ($this->request->params['action'] == 'admin_update')) {
            $this->Security->enabled = false;
        }
        parent::beforeFilter();
    }
    function index($folder_type = 'inbox', $is_starred = 0, $label_slug = 'null')
    {
        if ($folder_type == 'inbox') {
            $this->pageTitle = __l('Messages - Inbox');
            $condition = array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender ' => 0,
                'Message.message_folder_id' => ConstMessageFolder::Inbox
            );
            if (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'unread') {
                $condition['Message.is_read'] = 0;
            } else if (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'read') {
                $condition['Message.is_read'] = 1;
            } else if (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'spam') {
                $condition = array(
                    'Message.user_id' => $this->Auth->user('id') ,
                    'Message.message_folder_id' => ConstMessageFolder::Spam
                );
            }
            if (!empty($this->request->params['named']['job_order_id'])) {
                $condition['Message.job_order_id'] = $this->request->params['named']['job_order_id'];
            }
        } elseif ($folder_type == 'sent') {
            $this->pageTitle = __l('Messages - Sent Mail');
            $condition = array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 1,
                'Message.message_folder_id' => ConstMessageFolder::SentMail
            );
            if (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'unread') {
                $condition['Message.is_read'] = 0;
            } else if (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'read') {
                $condition['Message.is_read'] = 1;
            }
        } elseif ($folder_type == 'draft') {
            $this->pageTitle = __l('Messages - Drafts');
            $condition = array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 1,
                'Message.message_folder_id' => ConstMessageFolder::Drafts
            );
        } elseif ($folder_type == 'spam') {
            $this->pageTitle = __l('Messages - Spam');
            $condition = array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.message_folder_id' => ConstMessageFolder::Spam
            );
        } elseif ($folder_type == 'trash') {
            $this->pageTitle = __l('Messages - Trash');
            $condition = array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.message_folder_id' => ConstMessageFolder::Trash
            );
        } elseif ($folder_type == 'all') {
            $this->pageTitle = __l('Messages - All');
            $condition['Message.user_id'] = $this->Auth->user('id');
        } else {
            $condition['Message.other_user_id'] = $this->Auth->User('id');
        }
        if (!empty($this->request->params['named']['order_id'])) {
            $condition = array();
            $condition['Message.job_order_id'] = $this->request->params['named']['order_id'];
            $condition['Message.is_sender'] = 0;
        }
        App::import('Model', 'Jobs.Message');
        $this->Message = new Message();
        // To find all messges size
        $total_size = $this->Message->myUsedSpace();
        // Getting users inbox paging size
        $message_page_size = $this->Message->myMessagePageSize();
        $condition['Message.is_deleted'] = 0;
        $condition['Message.is_archived'] = 0;
        if ($is_starred) {
            $condition['Message.is_starred'] = 1;
        }
        if (!empty($label_slug)) {
            $label = $this->Label->find('first', array(
                'conditions' => array(
                    'Label.slug' => $label_slug
                ) ,
                'recursive' => -1
            ));
            if (!empty($label)) {
                $this->pageTitle = sprintf(__l('Messages - %s') , $label['Label']['name']);
                $label_message_id = $this->LabelsMessage->find('all', array(
                    'conditions' => array(
                        'LabelsMessage.label_id' => $label['Label']['id']
                    ) ,
                    'fields' => array(
                        'LabelsMessage.message_id'
                    ) ,
                    'recursive' => -1
                ));
                $message_ids = array();
                if (!empty($label_message_id)) {
                    foreach($label_message_id as $id) {
                        array_push($message_ids, $id['LabelsMessage']['message_id']);
                    }
                }
                $condition['Message.id'] = $message_ids;
            }
        }
        $condition['MessageContent.is_system_flagged'] = '0';
        if (!empty($this->request->params['named']['order_id'])) {
            $contain = array(
                'User' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                ) ,
                'OtherUser' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                ) ,
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.subject',
                        'MessageContent.message'
                    ) ,
                    'Attachment'
                ) ,
                'Label' => array(
                    'fields' => array(
                        'Label.name'
                    )
                ) ,
                'JobOrderStatus',
                'JobOrder' => array(
                    'fields' => array(
                        'JobOrder.id',
                        'JobOrder.user_id',
                        'JobOrder.owner_user_id',
                        'JobOrder.created',
                        'JobOrder.accepted_date',
                    ) ,
                    'User' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                    ) ,
                    'Job' => array() ,
                    'JobFeedback' => array() ,
                ) ,
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.user_id',
                        'Job.no_of_days',
                    ) ,
                    'User' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                    )
                ) ,
            );
            $order = array(
                'Message.id' => 'asc'
            );
            unset($contain['JobOrder']['JobFeedback']);
        } else {
            $order = array(
                'Message.id' => 'desc'
            );
            $contain = array(
                'User',
                'OtherUser',
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.subject',
                        'MessageContent.message'
                    ) ,
                    'Attachment'
                ) ,
                'Label' => array(
                    'fields' => array(
                        'Label.name'
                    )
                ) ,
                'JobOrderStatus',
                'JobOrder' => array(
                    'fields' => array(
                        'JobOrder.id',
                        'JobOrder.user_id',
                        'JobOrder.owner_user_id',
                        'JobOrder.created',
                        'JobOrder.accepted_date',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                        )
                    )
                ) ,
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.user_id',
                        'Job.no_of_days',
                    ) ,
                    'User',
                ) ,
            );
        }
		if (empty($this->request->params['named']['order_id'])) {      $condition['Message.is_auto'] = 0; }
        $limit = (!empty($this->request->params['named']['order_id'])) ? 100 : $message_page_size;
		$this->paginate = array(
            'conditions' => $condition,
            'recursive' => 3,
            'contain' => $contain,
            'order' => $order,
            'limit' => $limit
        );
        $labels = $this->LabelsUser->find('all', array(
            'conditions' => array(
                'LabelsUser.user_id' => $this->Auth->user('id')
            )
        ));
        if (!empty($this->request->params['named']['job_order_id'])) {
            $job_order = $this->JobOrder->findById($this->request->params['named']['job_order_id']);
            $this->set('job_order_messages', $job_order);
        }
        $this->set('messages', $this->paginate());
        $this->set('labels', $labels);
        $this->set('folder_type', $folder_type);
        $this->set('is_starred', $is_starred);
        $this->set('label_slug', $label_slug);
        $this->set('user_id', $this->Auth->user('id'));
        $this->set('size', $total_size);
        $this->set('mail_options', $this->Message->getMessageOptionArray($folder_type));
        $allowed_size = higher_to_bytes(Configure::read('message.allowed_message_size') , Configure::read('message.allowed_message_size_unit'));
        // to find the percentage of the uploaded photos size of the user
        $size_percentage = ($allowed_size) ? ($total_size/$allowed_size) *100 : 0;
        $this->set('size_percentage', round($size_percentage));
        if (!empty($this->request->params['named']['order_id'])) {
            $this->render('message-conversation');
        }
    }
	public function notification()
	{
	$condition = array();
	$condition['Message.user_id'] = $this->Auth->user('id');
	$condition['Message.is_auto'] = 1;
	$order = array(
		'Message.id' => 'desc'
	);

	$contain = array(
		'User' => array(
			'fields' => array(
				'User.username',
				'User.role_id'
			)
		) ,
		'OtherUser' => array(
			'fields' => array(
				'OtherUser.username',
				'OtherUser.role_id'
			)
		) ,
		'MessageContent' => array(
			'fields' => array(
				'MessageContent.subject',
				'MessageContent.message'
			) ,
			'Attachment'
		) ,
		'Label' => array(
			'fields' => array(
				'Label.name'
			)
		) ,
		'JobOrderStatus',
		'JobOrder' => array(
			'fields' => array(
				'JobOrder.id',
				'JobOrder.user_id',
				'JobOrder.owner_user_id',
				'JobOrder.created',
				'JobOrder.accepted_date',
			) ,
			'User' => array(
				'fields' => array(
					'User.id',
					'User.username',
				)
			)
		) ,
		'Job' => array(
			'fields' => array(
				'Job.id',
				'Job.user_id',
				'Job.no_of_days',
				'Job.title',
				'Job.slug',
			) ,
			'User' => array(
				'fields' => array(
					'User.id',
					'User.username',
				)
			)
		) ,
	);
	$limit=(empty($this->request->params['named']['type']))?'20':'3';
	$this->paginate = array(
		'conditions' => $condition,
		'recursive' => 2,
		'contain' => $contain,
		'order' => $order,
		'limit' => $limit
	);
	 $final_id = $this->Message->find('first', array(
		'conditions' => $condition,
		'fields' => array(
			'Message.id'
		) ,
		'recursive' => 0,
		'limit' => 1,
		'order' => array(
			'Message.id' => 'desc'
		) ,
	));
	$this->set('final_id', $final_id);
	$type=!empty($this->request->params['named']['type'])? $this->request->params['named']['type']:'';
	$this->set('messages',  $this->paginate());
	$this->set('type', $type  );
	
	}
	public function clear_notifications() 
    {
        $this->loadModel('User');
        $data['User']['activity_message_id'] = $this->request->params['named']['final_id'];
        $data['User']['id'] = $this->Auth->user('id');
        $this->User->save($data);
        $this->Session->setFlash(__l('Notifications cleared successfully') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'dashboard'
        ));
    }
    function inbox()
    {
        $this->setAction('index', 'inbox');
    }
    function sentmail()
    {
        $this->setAction('index', 'sent');
    }
    function drafts()
    {
        $this->setAction('index', 'draft');
    }
    function all()
    {
        $this->setAction('index', 'all');
    }
    function spam()
    {
        $this->setAction('index', 'spam');
    }
    function trash()
    {
        $this->setAction('index', 'trash');
    }
    function starred($folder_type = 'all')
    {
        $this->setAction('index', $folder_type, 1);
        $this->pageTitle = __l('Messages - Starred');
    }
    function label($label_slug = null)
    {
        $this->setAction('index', 'all', 0, $label_slug);
    }
    function view($hash = null, $folder_type = 'inbox', $is_starred = 0, $label_slug = 'null')
    { 
        $this->pageTitle = __l('Message');
        if (is_null($hash)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions['Message.hash = '] = $hash;
        if ($this->Auth->user('role_id') != ConstUserIds::Admin) {
            $conditions['OR'] = array(
                'Message.user_id' => $this->Auth->User('id')
            );
        }
		if(!empty($this->request->params['named']['is_view'])){
		$this->set('is_view', $this->request->params['named']['is_view']);
		}
        $message = $this->Message->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Message.id',
                'Message.created',
                'Message.user_id',
                'Message.other_user_id',
                'Message.parent_message_id',
                'Message.message_content_id',
                'Message.message_folder_id',
                'Message.is_sender',
                'Message.is_starred',
                'Message.is_read',
                'Message.is_deleted',
                'Message.hash',
                'Message.job_order_id',
                'Message.job_id',
                'Message.is_review',
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.subject',
                        'MessageContent.message',
                        'MessageContent.is_system_flagged',
                        'MessageContent.detected_suspicious_words'
                    ) ,
                    'Attachment'
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.role_id',
                        'User.is_active'
                    )
                ) ,
                'OtherUser' => array(
                    'fields' => array(
                        'OtherUser.email',
                        'OtherUser.username',
                        'OtherUser.role_id'
                    )
                ) ,
                'Job',
                'JobOrder' => array(
                    'Attachment'
                )
            ) ,
            'recursive' => 2,
        ));
				
        if (empty($message) || $message['MessageContent']['is_system_flagged'] == 1 && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $all_parents = array();
        if (!empty($message['Message']['parent_message_id'])) {
            $parent_message = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.id' => $message['Message']['parent_message_id']
                ) ,
                'recursive' => 0
            ));
            $all_parents = $this->_findParent($parent_message['Message']['hash']);
        }
        //Its for display details -> Who got this message
        $select_to_details = $this->Message->find('all', array(
            'conditions' => array(
                'Message.message_content_id = ' => $message['Message']['message_content_id'],
            ) ,
            'recursive' => 0,
            'contain' => array(
                'User.email',
                'User.username',
                'User.id'
            )
        ));
        if (!empty($select_to_details)) {
            $receiverNames = array();
            $show_detail_to = array();
            foreach($select_to_details as $select_to_detail) {
                if ($select_to_detail['Message']['is_sender'] == 0) {
                    if ($this->Auth->User('id') != $select_to_detail['User']['id']) {
                        array_push($receiverNames, __l($select_to_detail['User']['username']));
                    }
                    array_push($show_detail_to, __l($select_to_detail['User']['username']));
                }
            }
            $show_detail_to = implode(', ', $show_detail_to);
            $receiverNames = implode(', ', $receiverNames);
            $this->set('show_detail_to', $show_detail_to);
            $this->set('receiverNames', $receiverNames);
        }
        App::import('Model', 'Jobs.LabelsUser');
        $this->LabelsUser = new LabelsUser();
        $labels = $this->LabelsUser->find('all', array(
            'conditions' => array(
                'LabelsUser.user_id' => $this->Auth->user('id')
            )
        ));
        if (!empty($message['Message']['job_order_id'])) {
            $jobOrderInfo = $this->Message->JobOrder->find('first', array(
                'conditions' => array(
                    'JobOrder.id' => $message['Message']['job_order_id']
                ) ,
                'contain' => array(
                    'Job' => array(
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.blocked_amount',
                            )
                        )
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.blocked_amount',
                        )
                    )
                ) ,
            ));
            if ($jobOrderInfo['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview) {
                if ($message['Message']['user_id'] == $jobOrderInfo['JobOrder']['user_id']) {
                    $review_url = Router::url(array(
                        'controller' => 'job_feedbacks',
                        'action' => 'add',
                        'job_order_id' => $jobOrderInfo['JobOrder']['id'],
                    ) , true);
                    $this->set('review_url', $review_url);
                }
            }
            $job['name'] = $jobOrderInfo['Job']['title'];
            $job['slug'] = $jobOrderInfo['Job']['slug'];
        }
        if (!empty($message['Message']['job_id'])) {
            $jobInfo = $this->Job->find('first', array(
                'conditions' => array(
                    'Job.id' => $message['Message']['job_id']
                ) ,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.blocked_amount',
                        )
                    )
                ) ,
            ));
            $job['name'] = $jobInfo['Job']['title'];
            $job['slug'] = $jobInfo['Job']['slug'];
        }
        $this->pageTitle.= ' - ' . $message['MessageContent']['subject'];
        $this->set('message', $message);
        if (!empty($job)) {
            $this->set('job', $job);
        }
        $this->set('all_parents', $all_parents);
        $this->set('user_email', $this->Auth->user('email'));
        $this->set('labels', $labels);
        $this->set('folder_type', $folder_type);
        $this->set('is_starred', $is_starred);
        $this->set('label_slug', $label_slug);
        $this->set('user_id', $this->Auth->user('id'));
        // set the mail options array
        $this->set('mail_options', $this->Message->getMessageOptionArray($folder_type));
        // Set the folder type link
        $back_link_msg = ($folder_type == 'all') ? __l('All mails') : $folder_type;
        $this->set('back_link_msg', $back_link_msg);
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Message->delete($id)) {
            $this->Session->setFlash(__l('Message deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function left_sidebar()
    {
        $folder_type = $this->request->params['folder_type'];
        $is_starred = $this->request->params['is_starred'];
        $contacts = $this->request->params['contacts'];
        $compose = $this->request->params['compose'];
        $settings = $this->request->params['settings'];
        $id = $this->Auth->user('id');
        $inbox = $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 0,
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'Message.is_read' => 0,
                'Message.is_auto' => 0,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0
            )
        ));
        $draft = $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 1,
                'Message.message_folder_id' => ConstMessageFolder::Drafts,
                'Message.is_deleted' => 0,
                'Message.is_auto' => 0,
                'Message.is_archived' => 0
            )
        ));
        $spam = $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 0,
                'Message.message_folder_id' => ConstMessageFolder::Spam,
                'Message.is_read' => 0,
                'Message.is_auto' => 0,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0
            )
        ));
        $stared = $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'MessageContent.is_system_flagged' => 0,
                'Message.is_auto' => 0,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0,
                'Message.is_starred' => 1
            )
        ));
        $trash = $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.message_folder_id' => ConstMessageFolder::Trash,
                'Message.is_read' => 0,
                'Message.is_auto' => 0,
            )
        ));
        $this->set('inbox', $inbox);
        $this->set('draft', $draft);
        $this->set('spam', $spam);
        $this->set('stared', $stared);
        $this->set('trash', $trash);
        $this->set('folder_type', $folder_type);
        $this->set('is_starred', $is_starred);
        $this->set('contacts', $contacts);
        $this->set('compose', $compose);
        $this->set('settings', $settings);
    }
    function compose($hash = null, $action = null, $slug = null)
    {
        $this->pageTitle = __l('Messages - Compose');
        if (!empty($hash)) {
            $parent_message = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.hash' => $hash
                ) ,
                'recursive' => 0
            ));
            $all_parents = $this->_findParent($hash);
        }
        $this->pageTitle = __l('Messages - New Message');
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['Message']['type'])) {
                $this->request->params['named']['order'] = $this->request->data['Message']['type'];
            }
            if (!empty($this->request->data['Message']['job_order_id'])) {
                $this->request->params['named']['job_order_id'] = $this->request->data['Message']['job_order_id'];
            }
            $this->Message->MessageContent->Attachment->Behaviors->attach('ImageUpload', Configure::read('job.file'));
            $this->Message->set($this->request->data);
            $validation_errors = $this->Message->invalidFields();
            if (!empty($this->request->data['Attachment']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty'))) {
                $this->Message->MessageContent->Attachment->set($this->request->data);
            }
            $ini_upload_error = 1;
            if (!empty($this->request->data['Attachment']['filename']['error']) && $this->request->data['Attachment']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            if (empty($validation_errors) &$this->Message->MessageContent->Attachment->validates() && $ini_upload_error) {
                // To take the admin privacy settings
                $is_saved = 0;
                if (!intval(Configure::read('messages.is_allow_send_messsage'))) {
                    $this->Session->setFlash(__l('Message send is temporarily stopped. Please try again later.') , 'default', null, 'error');
                    $this->redirect(array(
                        'action' => 'inbox'
                    ));
                }
                $size = strlen($this->request->data['Message']['message']) +strlen($this->request->data['Message']['subject']);
				$to_users = array();
				if(!empty($this->request->data['Message']['to'])){
					$to_users = explode(',', $this->request->data['Message']['to']);
				}
                if (!empty($this->request->data['User']['id']) && $this->request->data['User']['id']) {
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $this->request->data['User']['id']
                        ) ,
                        'fields' => array(
                            'User.username'
                        ) ,
                        'recursive' => -1
                    ));
                    $to_users = $user['User'];
                }
                if (!empty($to_users)) {
                    //  to save message content
                    $message_content['MessageContent']['subject'] = $this->request->data['Message']['subject'];
                    $message_content['MessageContent']['message'] = $this->request->data['Message']['message'];
                    $this->Message->MessageContent->save($message_content);
                    $message_id = $this->Message->MessageContent->id;
                    if (!empty($this->request->data['Attachment'])) {
                        $filename = array();
                        $filename = $this->request->data['Attachment']['filename'];
                        if (!empty($filename['name'])) {
                            $attachment['Attachment']['filename'] = $filename;
                            $attachment['Attachment']['class'] = 'MessageContent';
                            $attachment['Attachment']['description'] = 'message';
                            $attachment['Attachment']['foreign_id'] = $message_id;
                            $this->Message->MessageContent->Attachment->set($attachment);
                            $this->Message->MessageContent->Attachment->create();
                            $this->Message->MessageContent->Attachment->save($attachment);
                            $size+= $filename['size'];
                        }
                    }
                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                        '_trackEvent' => array(
                            'category' => 'User',
                            'action' => 'JobCommented',
                            'label' => $this->Auth->user('username') ,
                            'value' => '',
                        ) ,
                        '_setCustomVar' => array(
                            'ud' => $this->Auth->user('id') ,
                            'rud' => $this->Auth->user('referred_by_user_id') ,
                        )
                    ));
                    if (!empty($this->request->data['Message']['job_id'])) {
                        Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                            '_trackEvent' => array(
                                'category' => 'JobComment',
                                'action' => 'JobCommented',
                                'label' => $this->request->data['Message']['job_id'],
                                'value' => '',
                            ) ,
                            '_setCustomVar' => array(
                                'pd' => $this->request->data['Message']['job_id'],
                                'ud' => $this->Auth->user('id') ,
                                'rud' => $this->Auth->user('referred_by_user_id') ,
                            )
                        ));
                    }
                    foreach($to_users as $user_to) {
                        // To find the user id of the user
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.username' => trim($user_to)
                            ) ,
                            'fields' => array(
                                'User.id',
                                'User.email',
                                'User.username'
                            ) ,
                            'recursive' => 0
                        ));
                        if (!empty($user)) {
                            $is_send_message = true;
                            $job_order_id = $job_id = $other_user_id = '';
                            $is_review = 0;
                            // to check for allowed message sizes
                            $allowed_size = higher_to_bytes(Configure::read('messages.allowed_message_size') , Configure::read('messages.allowed_message_size_unit'));
                            $total_used_size = $this->Message->myUsedSpace();
                            //$is_size_ok = (($total_used_size+($size*2)) <= $allowed_size) ? true : false;
                            if ($is_send_message) {
                                if (!empty($this->request->data['Message']['parent_message_id'])) {
                                    $parent_id = $this->request->data['Message']['parent_message_id'];
                                } else {
                                    $parent_id = 0;
                                }
                                if (!empty($this->request->data['Message']['job_id'])) {
                                    $job_id = $this->request->data['Message']['job_id'];
                                }
                                if (!empty($this->request->data['Message']['job_order_id'])) {
                                    $job_order_id = $this->request->data['Message']['job_order_id'];
                                }
                                if (!empty($this->request->data['Message']['contact_type'])) {
                                    if ($this->request->data['Message']['contact_type'] == 'deliver') {
                                        $is_review = 1;
                                        $other_user_id = ConstUserIds::Admin;
                                    } else if ($this->request->data['Message']['contact_type'] == 'contact') {
                                        $other_user_id = $this->Auth->user('id');
                                        if (!empty($this->request->data['Message']['job_is_from_review']) && ($this->request->data['Message']['job_is_from_review'] == '1')) {
                                            $is_review = 1;
                                        }
                                    } else if ($this->request->data['Message']['contact_type'] == 'user') {
                                        $other_user_id = $this->Auth->user('id');
                                        if (!empty($this->request->data['Message']['job_is_from_review']) && ($this->request->data['Message']['job_is_from_review'] == '1')) {
                                            $is_review = 1;
                                        }
                                    }
                                }
                                if (!empty($this->request->data['Message']['type']) && ($this->request->data['Message']['type'] == 'reply')) {
                                    $other_user_id = $this->Auth->user('id');
                                    $is_review = 0;
                                }
                                $order_status_id = '';
                                if (!empty($this->request->data['Message']['contact_type']) && ($this->request->data['Message']['contact_type'] == 'deliver')) {
                                    $order_status_id = ConstJobOrderStatus::WorkDelivered;
                                }
                                //ConstUserIds::Admin
                                // To save in inbox //
                                $is_saved = $this->_saveMessage($user['User']['id'], $this->Auth->user('id') , $message_id, ConstMessageFolder::Inbox, 0, 0, $parent_id, $size, $job_id, $job_order_id, $is_review, $order_status_id);
                                // To save in sent iteams //
                                $is_saved = $this->_saveMessage($this->Auth->user('id') , $user['User']['id'], $message_id, ConstMessageFolder::SentMail, 1, 1, $parent_id, $size, $job_id, $job_order_id, $is_review, $order_status_id);
                                // Job Order Status Changed //
                                if (!empty($this->request->data['Message']['contact_type']) && ($this->request->data['Message']['contact_type'] == 'deliver')) {
									if ($this->request->is('ajax')) {
										echo 'redirect*' . Router::url(array(
												'controller' => 'job_orders',
												'action' => 'update_order',
												'order' => 'review',
												'job_order_id' => $this->request->data['Message']['job_order_id']
											), true );
										exit;
									} else {
										$this->redirect(array(
											'controller' => 'job_orders',
											'action' => 'update_order',
											'order' => 'review',
											'job_order_id' => $this->request->data['Message']['job_order_id']
										 ));
									}
                                } else {
                                    if (Configure::read('messages.is_send_email_on_new_message')) {
                                        if (!empty($user['User']['email'])) {
                                            if ($this->Message->_checkUserNotifications($user['User']['id'], '', 0, 1)) {
                                                $this->_sendAlertOnNewMessage($user['User']['email'], $this->request->data['Message'], $message_id, 'Alert Mail');
                                            }
                                        }
                                    }
                                    $this->Session->setFlash(__l('Message has been sent successfully') , 'default', null, 'success');
                                }
                            } else {
                                if (!empty($this->request->data['Message']['contact_type']) && ($this->request->data['Message']['contact_type'] == 'deliver')) {
                                    $this->Session->setFlash(__l('Your') . ' ' . jobAlternateName(ConstJobAlternateName::Singular) . ' ' . __l('couldn\'t been delievered . Try again') , 'default', null, 'error');
                                } else {
                                    $this->Session->setFlash(__l('Message couldn\'t be sent successfully. Try again') , 'default', null, 'error');
                                }
                            }
                            if (!empty($this->request->data['Message']['contact_type']) && ($this->request->data['Message']['contact_type'] == 'deliver')) {
                                $this->redirect(array(
                                    'controller' => 'job_orders',
                                    'action' => 'index',
                                    'type' => 'myworks'
                                ));
                            } else if (!empty($this->request->data['Message']['contact_type']) && ($this->request->data['Message']['contact_type'] == 'user')) {
                                $this->redirect(array(
                                    'controller' => 'users',
                                    'action' => 'view',
                                    $this->request->data['Message']['to']
                                ));
                            } else if (!empty($this->request->data['Message']['contact_type']) && ($this->request->data['Message']['contact_type'] == 'contact')) {
                                $this->redirect(array(
                                    'controller' => 'users',
                                    'action' => 'view',
                                    $this->request->data['Message']['to']
                                ));
                            } else if (!empty($this->request->data['Message']['type']) && ($this->request->data['Message']['type'] == 'reply')) {
                                $this->redirect(array(
                                    'controller' => 'messages',
                                    'action' => 'index',
                                ));
                            } else {
                                if (!empty($this->request->data['Message']['job_slug'])) {
                                    $this->redirect(array(
                                        'controller' => 'jobs',
                                        'action' => 'view',
                                        $this->request->data['Message']['job_slug']
                                    ));
                                } else {
                                    $this->redirect(array(
                                        'action' => 'sentmail'
                                    ));
                                }
                            }
                        }
                    }
                    $this->redirect(array(
                        'action' => 'inbox'
                    ));
                } else {
                    $this->Session->setFlash(__l('Please specify atleast one recipient.') , 'default', null, 'error');
                }
            } else {
					$this->Session->setFlash(__l('Message couldn\'t be sent. Try again.') , 'default', null, 'error');
            }
            if (!empty($this->request->data['Message']['type']) and $this->request->data['Message']['type'] == 'draft') {
                //deleting the old draft message for this messsage
                if ($is_saved and !empty($this->request->data['Message']['parent_message_id'])) {
                    $this->Message->delete($this->request->data['Message']['parent_message_id']);
                }
            }
        }
        if (!empty($this->request->data) && !empty($this->request->data['Message']['is_from_activities'])) {
            $compose_message['is_from_activities'] = $this->request->data['Message']['is_from_activities'];
        }
        if (!empty($this->request->params['named']['order']) && ($this->request->params['named']['order'] == 'deliver')) {
            $this->pageTitle = __l('Submit Complete Work');
            $job_order = $this->Message->getJobOrder($this->request->params['named']['job_order_id']);
            if ($job_order['Job']['User']['id'] != $this->Auth->user('id')) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if ($job_order['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::InProgress && $job_order['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::InProgressOvertime && $job_order['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::Redeliver) {
                $this->Session->setFlash(__l('It seems that you already responded to this order before.') , 'default', null, 'error');
                $this->redirect(array(
                    'action' => 'index',
                    'type' => 'myworks'
                ));
            }
            $compose_message['to_username'] = $job_order['User']['username'];
            $compose_message['job_id'] = $job_order['Job']['id'];
            $compose_message['job_name'] = $job_order['Job']['title'];
            $compose_message['job_slug'] = $job_order['Job']['slug'];
            $compose_message['job_amount'] = $job_order['Job']['amount'];
            $compose_message['job_order_id'] = $job_order['JobOrder']['id'];
            $compose_message['ordered_date'] = $job_order['JobOrder']['accepted_date'];
            $compose_message['subject'] = 'Your order has been completed';
            $compose_message['type'] = $this->request->params['named']['order'];
            $compose_message['contact_type'] = $this->request->params['named']['order'];
            $sum = strtotime(date("Y-m-d", strtotime($job_order['JobOrder']['accepted_date'])) . $job_order['Job']['no_of_days'] . "days");
            $deliever_date = date('Y-m-d', $sum);
            $compose_message['on_time_delivery'] = (date('Y-m-d') <= $deliever_date) ? 'Yes' : 'No';
        } else if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'contact') && (!empty($this->request->params['named']['slug']))) {
            $conditions['Job.slug'] = $this->request->params['named']['slug'];
            $job = $this->Job->find('first', array(
                'conditions' => $conditions,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.available_balance_amount',
                            'User.blocked_amount',
                            'User.cleared_amount',
                        )
                    )
                )
            ));
            $compose_message['to_username'] = $job['User']['username'];
            $compose_message['job_id'] = $job['Job']['id'];
            $compose_message['job_name'] = $job['Job']['title'];
            $compose_message['job_slug'] = $job['Job']['slug'];
            $compose_message['type'] = 'contact';
            $compose_message['contact_type'] = $this->request->params['named']['type'];
        } else if (!empty($action) && ($action == 'reply')) {
            $conditions['Job.id'] = $parent_message['Message']['job_id'];
            $job = $this->Job->find('first', array(
                'conditions' => $conditions,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.available_balance_amount',
                            'User.blocked_amount',
                            'User.cleared_amount',
                        )
                    )
                ) ,
                'recursive' => 2,
            ));
            $compose_message['to_username'] = $parent_message['OtherUser']['username'];
            $compose_message['job_id'] = $job['Job']['id'];
            $compose_message['job_name'] = $job['Job']['title'];
            $compose_message['job_slug'] = $job['Job']['slug'];
            if ($parent_message['Message']['job_order_id']) {
                $compose_message['job_order_id'] = $parent_message['Message']['job_order_id'];
            }
            if ($parent_message['Message']['is_review']) {
                $compose_message['is_review'] = $parent_message['Message']['is_review'];
            }
            $compose_message['job_slug'] = $job['Job']['slug'];
            $compose_message['type'] = 'reply';
        } else if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'contact') && (!empty($this->request->params['named']['to']))) {
            $compose_message['to_username'] = $this->request->params['named']['to'];
            $compose_message['type'] = 'user';
            $compose_message['contact_type'] = $this->request->params['named']['type'];
            if (!empty($this->request->params['named']['job_order_id'])) {
                $job_order = $this->Message->getJobOrder($this->request->params['named']['job_order_id']);
                $compose_message['job_id'] = $job_order['Job']['id'];
                $compose_message['job_name'] = $job_order['Job']['title'];
                $compose_message['job_slug'] = $job_order['Job']['slug'];
                $compose_message['job_order_id'] = $job_order['JobOrder']['id'];
                $compose_message['subject'] = $job_order['Job']['title'];
            }
        }
        if (!empty($compose_message)) {
            //            $this->set('compose_message', $compose_message);
            $this->request->data['Message'] = $compose_message;
        }
        if (!empty($parent_message)) {
            if (!empty($action)) {
                switch ($action) {
                    case 'reply':
                        $this->request->data['Message']['subject'] = __l('Re:') . $parent_message['MessageContent']['subject'];
                        $this->set('all_parents', $all_parents);
                        $this->set('type', 'reply');
                        $this->request->data['Message']['type'] = 'reply';
                        break;

                    case 'draft':
                        $this->request->data['Message']['subject'] = __l('Re:') . $parent_message['MessageContent']['subject'];
                        $this->request->data['Message']['type'] = 'draft';
                        break;
                }
                $this->request->data['Message']['message'] = "\n\n\n";
                $this->request->data['Message']['message'].= '------------------------------';
                $this->request->data['Message']['message'].= "\n" . $parent_message['MessageContent']['message'];
                $this->request->data['Message']['to'] = $parent_message['OtherUser']['username'];
                $this->request->data['Message']['parent_message_id'] = $parent_message['Message']['id'];
            }
        }
        $user_settings = $this->Message->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'UserProfile.message_page_size',
            ) ,
            'recursive' => -1
        ));
        if (!empty($this->request->params['named']['user'])) {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['user']
                ) ,
                'fields' => array(
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            $this->request->data['Message']['to'] = $user['User']['username'];
        }
        if ((!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'simple-deliver') || !empty($this->request->data['Message']['is_from_activities'])) {
            $this->render('simple-deliver');
        }
        //	pr($this->request->data);
        //	pr($compose_message);

    }
    public function update_message_read($message_id = null,$is_auto = 0)
    {
        $message = $this->Message->find('first', array(
            'conditions' => array(
                'Message.id = ' => $message_id,
            ) ,
            'fields' => array(
                'Message.id',
                'Message.created',
                'Message.user_id',
                'Message.other_user_id',
                'Message.parent_message_id',
                'Message.message_content_id',
                'Message.message_folder_id',
                'Message.is_sender',
                'Message.is_starred',
                'Message.is_read',
                'Message.is_deleted',
                'Message.job_id'
            ) ,
            'recursive' => -1,
        ));
        if (!empty($message) and $message['Message']['is_read'] == 0 && $message['Message']['user_id'] == $this->Auth->user('id')) {
            $this->request->data['Message']['is_read'] = 1;
            $this->request->data['Message']['id'] = $message['Message']['id'];
            $this->Message->save($this->request->data);
        }
        $unread_count = $this->Message->find('count', array(
            'conditions' => array(
                'Message.is_read' => '0',
				'Message.is_auto' => $is_auto,
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => '0',
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0,
            ) ,
            'recursive' => 0
        ));
        $unread_count = !empty($unread_count) ? $unread_count : '';
        $unread_count = $unread_count;
        echo $unread_count;
        exit;
    }
    function simple_compose()
    {
        $conditions['JobOrderDispute.job_order_id'] = !empty($this->request->params['named']['order_id']) ? $this->request->params['named']['order_id'] : $this->request->data['Message']['job_order_id'];
        $conditions['JobOrderDispute.dispute_status_id'] = array(
            ConstDisputeStatus::Open,
            ConstDisputeStatus::UnderDiscussion,
            ConstDisputeStatus::WaitingForAdministratorDecision,
        );
        $order = $this->Message->JobOrderDispute->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.slug',
                        'Job.user_id',
                        'Job.title',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email'
                        )
                    ) ,
                ) ,
                'JobOrder' => array(
                    'fields' => array(
                        'JobOrder.id',
                        'JobOrder.user_id',
                        'JobOrder.owner_user_id'
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email'
                        )
                    ) ,
                    'Job'
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email'
                    )
                ) ,
            ) ,
            'recursive' => 2
        ));
        if (empty($order)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            $this->Message->set($this->request->data);
            if ($this->Message->validates()) {
                // SENDING MAIL AND UPDATING CONVERSTATION //
                $order_id = $this->request->data['Message']['job_order_id'];
                $template = $this->EmailTemplate->selectTemplate("Dispute Conversation Notification");
                $emailFindReplace = array(
                    '##JOB_NAME##' => "<a href=" . Router::url(array(
                        'controller' => 'jobs',
                        'action' => 'view',
                        $order['Job']['slug'],
                        'admin' => false,
                    ) , true) . ">" . $order['Job']['title'] . "</a>",
                    '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                    '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
                    '##ORDERNO##' => $order_id,
                    '##MESSAGE##' => $this->request->data['Message']['message']
                );
                // buyer sent mail
                if ($order['JobOrder']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin) {
                    $emailFindReplace['##USERNAME##'] = $order['Job']['User']['username'];
                    $emailFindReplace['##OTHER_USER##'] = $this->Auth->user('username');
                    $to = $order['Job']['User']['id'];
                    $sender_email = $order['Job']['User']['email'];
                    $message = strtr($template['email_text_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    if (Configure::read('messages.is_send_internal_message')) {
                        $status = ConstJobOrderStatus::DisputeConversation;
                        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                            $status = ConstJobOrderStatus::AdminDisputeConversation;
                        }
                        $is_auto = 1;
                        $message_id = $this->Message->sendNotifications($to, $subject, $message, $order_id, '0', $order['Job']['id'], $status, $order['JobOrderDispute']['id'], '0', $is_auto);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = $subject;
                            $content['message'] = $subject;
                            if (!empty($sender_email)) {
                                if ($this->Message->_checkUserNotifications($to, ConstJobOrderStatus::DisputeOpened, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                }
                // seller sent email
                if ($order['JobOrder']['owner_user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin) {
                    $emailFindReplace['##USERNAME##'] = $order['JobOrder']['User']['username'];
                    $emailFindReplace['##OTHER_USER##'] = $this->Auth->user('username');
                    $to = $order['JobOrder']['User']['id'];
                    $sender_email = $order['JobOrder']['User']['email'];
                    $message = strtr($template['email_text_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    if (Configure::read('messages.is_send_internal_message')) {
                        $type = ConstJobOrderStatus::DisputeConversation;
                        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) $type = ConstJobOrderStatus::SenderNotification;
                        $is_auto = 1;
                        $message_id = $this->Message->sendNotifications($to, $subject, $message, $order_id, '0', $order['Job']['id'], $type, $order['JobOrderDispute']['id'], '0', $is_auto);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = $subject;
                            $content['message'] = $subject;
                            if (!empty($sender_email)) {
                                if ($this->Message->_checkUserNotifications($to, ConstJobOrderStatus::DisputeOpened, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                }
                // END OF SEND MAIL //
                // UPDATING STATUS //
                // open statsu to UnderDiscussion status changes
                if ($order['JobOrderDispute']['dispute_status_id'] == ConstDisputeStatus::Open) {
                    $this->Message->JobOrderDispute->updateAll(array(
                        'JobOrderDispute.dispute_status_id' => ConstDisputeStatus::UnderDiscussion
                    ) , array(
                        'JobOrderDispute.id' => $order['JobOrderDispute']['id']
                    ));
                }
                // update count and last reply user and date
                $count = $order['JobOrderDispute']['dispute_converstation_count']+1;
                if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                    $this->Message->JobOrderDispute->updateAll(array(
                        'JobOrderDispute.dispute_converstation_count' => $count,
                        'JobOrderDispute.last_replied_user_id' => $this->Auth->user('id') ,
                        'JobOrderDispute.last_replied_date' => "'" . date('Y-m-d h:i:s') . "'"
                    ) , array(
                        'JobOrderDispute.id' => $order['JobOrderDispute']['id']
                    ));
                } else {
                    $this->Message->JobOrderDispute->updateAll(array(
                        'JobOrderDispute.dispute_converstation_count' => $count,
                    ) , array(
                        'JobOrderDispute.id' => $order['JobOrderDispute']['id']
                    ));
                }
                // Discussion Threshold for Admin Decision start
                if ($count == Configure::read('dispute.discussion_threshold_for_admin_decision')) {
                    $this->Message->JobOrderDispute->updateAll(array(
                        'JobOrderDispute.dispute_status_id' => ConstDisputeStatus::WaitingForAdministratorDecision
                    ) , array(
                        'JobOrderDispute.id' => $order['JobOrderDispute']['id']
                    ));
                    $order_id = $this->request->data['Message']['job_order_id'];
                    $template = $this->EmailTemplate->selectTemplate("Discussion Threshold for Admin Decision");
                    // -------------------------------------------------------------------------------------------------------------------------------------
                    // buyer sent mail
                    $emailFindReplace['##USERNAME##'] = $order['Job']['User']['username'];
                    $emailFindReplace['##OTHER_USER##'] = 'Admin';
                    $to = $order['Job']['User']['id'];
                    $sender_email = $order['Job']['User']['email'];
                    $message = strtr($template['email_text_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    $is_auto = 1;
                    if (Configure::read('messages.is_send_internal_message')) {
                        $message_id = $this->Message->sendNotifications($to, $subject, $message, $order_id, '0', $order['Job']['id'], ConstJobOrderStatus::DisputeAdminAction, $order['JobOrderDispute']['id'], $is_auto);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = $subject;
                            $content['message'] = $subject;
                            if (!empty($sender_email)) {
                                if ($this->Message->_checkUserNotifications($to, ConstJobOrderStatus::DisputeOpened, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                    // seller sent email
                    $emailFindReplace['##USERNAME##'] = $order['JobOrder']['User']['username'];
                    $emailFindReplace['##OTHER_USER##'] = 'Admin';
                    $to = $order['JobOrder']['User']['id'];
                    $sender_email = $order['JobOrder']['User']['email'];
                    $message = strtr($template['email_text_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    $is_auto = 1;
                    if (Configure::read('messages.is_send_internal_message')) {
                        $message_id = $this->Message->sendNotifications($to, $subject, $message, $order_id, '0', $order['Job']['id'], ConstJobOrderStatus::SenderNotification, $order['JobOrderDispute']['id'], $is_auto);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = $subject;
                            $content['message'] = $subject;
                            if (!empty($sender_email)) {
                                if ($this->Message->_checkUserNotifications($to, ConstJobOrderStatus::DisputeOpened, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                    // END OF SEND MAIL //
                    // -------------------------------------------------------------------------------------------------------------------------------------

                }
                // END OF UP.STATUS //
                $this->Session->setFlash(__l('Conversation Updated.') , 'default', null, 'success');
                if ($this->RequestHandler->isAjax()) {
                    $ajax_url = Router::url(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'order_id' => $order_id,
                        'type' => $this->request->data['Message']['type'],
                        'admin' => ($this->Auth->user('role_id') == ConstUserTypes::Admin) ? true : false,
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            }
        } else {
            $this->request->data['Message']['job_order_id'] = $order['JobOrderDispute']['job_order_id'];
            $this->request->data['Message']['job_id'] = $order['JobOrderDispute']['job_id'];
            $this->request->data['Message']['job_order_dispute_id'] = $order['JobOrderDispute']['id'];
            if ($order['JobOrder']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin) {
                $this->request->data['Message']['to_user_id'] = $order['Job']['User']['id'];
                $this->request->data['Message']['to_username'] = $order['Job']['User']['username'];
                $this->request->data['Message']['to_useremail'] = $order['Job']['User']['email'];
            } else {
                $this->request->data['Message']['to_user_id'] = $order['JobOrder']['User']['id'];
                $this->request->data['Message']['to_username'] = $order['JobOrder']['User']['username'];
                $this->request->data['Message']['to_useremail'] = $order['JobOrder']['User']['email'];
            }
            $this->request->data['Message']['type'] = $this->request->params['named']['type'];
        }
    }
    function admin_activities()
    {
        $this->pageTitle = __l('Activities');
        $this->setAction('activities');
    }
    function activities()
    {
        if (!empty($this->request->params['named']['order_id']) && !empty($this->request->params['named']['type'])) {
            $conditions = array();
            $conditions['JobOrder.id'] = $this->request->params['named']['order_id'];
            if ($this->request->params['named']['type'] == 'myorders' || $this->request->params['named']['type'] == 'admin_order_view') {
                if ($this->request->params['named']['type'] == 'admin_order_view') {
                    $conditions['JobOrder.id'] = $this->request->params['named']['order_id'];
                } else {
                    $conditions['JobOrder.user_id'] = $this->Auth->User('id');
                }
            } elseif ($this->request->params['named']['type'] == 'myworks' || $this->request->params['named']['type'] == 'admin_order_view') {
                if ($this->request->params['named']['type'] == 'admin_order_view') {
                    $conditions['JobOrder.id'] = $this->request->params['named']['order_id'];
                } else {
                    $conditions['Job.user_id'] = $this->Auth->User('id');
                }
            }
            App::import('Model', 'Jobs.JobOrder');
            $this->JobOrder = new JobOrder();
            $order = $this->JobOrder->find('first', array(
                'conditions' => $conditions,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                        )
                    ) ,
                    'Attachment',
                    'Job' => array(
                        'fields' => array(
                            'Job.id',
                            'Job.title',
                            'Job.slug',
                            'Job.user_id',
                            'Job.amount',
                            'Job.job_type_id',
                            'Job.description',
                        ) ,
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.email',
                            )
                        ) ,
                        'JobCategory',
                        'JobType',
                    ) ,
                    'JobOrderStatus'
                ) ,
                'recursive' => 2
            ));
            if (empty($order)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->pageTitle = __l('Activities') . ' - ' . $order['Job']['title'] . ' - #' . $order['JobOrder']['id'];
            $this->set('orders', $order);
            if (!empty($this->request->params['prefix']) && isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'compact')) {
                $this->render('admin_activities_compact');
            }
        } else if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'compact' || $this->request->params['named']['type'] == 'list') {
            $conditions['Message.is_sender'] = 1;
            $limit = $this->request->params['named']['type'] == 'compact' ? 3 : '';
            $messages = $this->Message->find('all', array(
                'conditions' => $conditions,
                'contain' => array(
                    'User',
                    'MessageContent',
                    'OtherUser',
                    'Job'
                ) ,
                'order' => array(
                    'Message.id' => 'desc'
                ) ,
                'limit' => $limit,
                'recursive' => 2
            ));
            $this->set('messages', $messages);
            if (!empty($this->request->params['prefix']) && isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'compact')) {
                $this->render('admin_activities_compact');
            } else {
                $this->render('admin_activities');
            }
        }
    }
    function admin_index()
    {
        $this->pageTitle = __l('Messages');
        $this->Message->recursive = 1;
        $conditions['Message.is_sender'] = 1;
        if (!empty($this->request->data['Job']['id'])) {
            $conditions['Message.job_id'] = $this->request->data['Job']['id'];
        }
        if (!empty($this->request->data['Job']['title'])) {
            $job = $this->Message->Job->find('first', array(
                'conditions' => array(
                    'Job.title' => $this->request->data['Job']['title'],
                ) ,
                'fields' => array(
                    'Job.id',
                    'Job.title',
                ) ,
                'recursive' => -1
            ));
            $conditions['Message.job_id'] = $job['Job']['id'];
            $this->request->data['Job']['title'] = $job['Job']['title'];
            $this->request->params['named']['job'] = $job['Job']['id'];
        }
        if (!empty($this->request->data['JobOrder']['Id'])) {
            $conditions['Message.job_order_id'] = $this->request->data['JobOrder']['Id'];
        }
        if (!empty($this->request->data['Message']['username']) || !empty($this->request->params['named']['from'])) {
            $this->request->data['Message']['username'] = !empty($this->request->data['Message']['username']) ? $this->request->data['Message']['username'] : $this->request->params['named']['from'];
            $conditions['User.username'] = $this->request->data['Message']['username'];
            $this->request->params['named']['from'] = $this->request->data['Message']['username'];
        }
        if (!empty($this->request->data['Message']['other_username']) || !empty($this->request->params['named']['to'])) {
            $this->request->data['Message']['other_username'] = !empty($this->request->data['Message']['other_username']) ? $this->request->data['Message']['other_username'] : $this->request->params['named']['to'];
            $conditions['OtherUser.username'] = $this->request->data['Message']['other_username'];
            $this->request->params['named']['to'] = $this->request->data['Message']['other_username'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'MessageContent',
                'OtherUser',
                'Job',
                'JobOrder'
            ) ,
            'order' => array(
                'Message.id' => 'desc'
            ) ,
            'recursive' => 2
        );
        $this->Message->Job->validate = array();
        $this->Message->Job->JobOrder->validate = array();
        $this->Message->User->validate = array();
        $moreActions = $this->Message->moreActions;
        $this->set(compact('moreActions'));
        $this->set('messages', $this->paginate());
    }
    function admin_compose($hash = null, $action = null)
    {
        $this->pageTitle = __l('Messages') . ' | ' . __l('Compose message');
        if (!empty($this->request->data)) {
            $condition = array();
            if ($this->request->data['Message']['to_user'] != '0') {
                if ($this->request->data['Message']['to_user'] == '2') {
                    $condition['User.is_active'] = 1;
                } else if ($this->request->data['Message']['to_user'] == '3') {
                    $condition['User.is_active'] = 0;
                }
                $users = $this->User->find('all', array(
                    'conditions' => $condition,
                    'recursive' => -1
                ));
                foreach($users as $user) {
                    $id[] = $user['User']['id'];
                    $email[] = $user['User']['email'];
                }
            }
            if (!empty($this->request->data['Message']['to'])) {
                $to_users = explode(",", $this->request->data['Message']['to']);
                foreach($to_users as $user_to) {
                    $user_id = $this->User->find('first', array(
                        'fields' => array(
                            'User.id',
                            'User.email'
                        ) ,
                        'recursive' => -1
                    ));
                    $id[] = $user_id['User']['id'];
                    $email[] = $user_id['User']['email'];
                }
            }
            $has_sent = false;
            if (!empty($id)) {
                //  to save message content
                $message_content['MessageContent']['subject'] = $this->request->data['Message']['subject'];
                $message_content['MessageContent']['message'] = $this->request->data['Message']['message'];
                $this->Message->MessageContent->save($message_content);
                $message_id = $this->Message->MessageContent->id;
                $size = strlen($this->request->data['Message']['message']) +strlen($this->request->data['Message']['subject']);
                foreach($id as $user_id) {
                    if ($this->_saveMessage($user_id, $this->Auth->User('id') , $message_id, 1, $is_sender = 0, $is_read = 0, '', $size, $is_review = 0)) {
                        $has_sent = true;
                    }
                }
            }
            if ($has_sent) {
                $this->Session->setFlash(__l('Message has been sent successfully') , 'default', null, 'success');
            }
            if (!empty($email)) {
                foreach($email as $user_email) {
                    $this->_sendMail($user_email, $this->request->data['Message']['subject'], $this->request->data['Message']['message']);
                }
            } else {
                $this->Session->setFlash(__l('Problem in sending mail to the appropriate user.') , 'default', null, 'error');
            }
        }
        $option = array(
            0 => 'Select',
            1 => 'All users',
            2 => 'All approved users',
            3 => 'All pending users'
        );
        $this->set('user_id', $this->Auth->user('id'));
        $this->set('option', $option);
    }
    function _sendMail($to, $subject, $body, $format = 'text')
    {
        $from = Configure::read('site.no_reply_email');
        $subject = $subject;
        $this->Email->from = (!empty($template['from']) && ($template['from'] == '##FROM_EMAIL##')) ? Configure::read('site.from_email') : $template['from'];
        $this->Email->replyTo = (!empty($template['from']) && $template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
        $this->Email->to = $to;
        $this->Email->subject = $subject;
        $this->Email->sendAs = $format;
        return $this->Email->send($body);
    }
    function _saveMessage($user_id, $other_user_id, $message_id, $folder_id, $is_sender = 0, $is_read = 0, $parent_id = null, $size, $job_id = null, $job_order_id, $is_review = 0, $order_status_id = 0)
    {
        $message['Message']['message_content_id'] = $message_id;
        $message['Message']['user_id'] = $user_id;
        $message['Message']['other_user_id'] = $other_user_id;
        $message['Message']['message_folder_id'] = $folder_id;
        $message['Message']['is_sender'] = $is_sender;
        $message['Message']['is_read'] = $is_read;
        $message['Message']['parent_message_id'] = $parent_id;
        $message['Message']['size'] = $size;
        $message['Message']['job_id'] = $job_id;
        $message['Message']['job_order_id'] = $job_order_id;
        $message['Message']['is_review'] = $is_review;
        if (!empty($order_status_id)) {
            $message['Message']['job_order_status_id'] = $order_status_id;
        }
        $this->Message->create();
        $this->Message->save($message);
        $id = $this->Message->id;
        $hash = md5(Configure::read('Security.salt') . $id);
        $message['Message']['id'] = $id;
        $message['Message']['hash'] = $hash;
        $this->Message->save($message);
        return $id;
    }
    function download($message_hash = null, $attachment_id = null)
    {
        //checking Authontication
        if (empty($message_hash) or empty($attachment_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $message = $this->Message->find('first', array(
            'conditions' => array(
                'Message.hash =' => $message_hash,
            ) ,
            'fields' => array(
                'MessageContent.id'
            ) ,
            'recursive' => 0
        ));
        if (empty($message)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $file = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.id =' => $attachment_id,
                'Attachment.class =' => 'MessageContent',
                'Attachment.description =' => 'message',
            ) ,
            'recursive' => -1
        ));
        if ($file['Attachment']['foreign_id'] != $message['MessageContent']['id']) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $filename = substr($file['Attachment']['filename'], 0, strrpos($file['Attachment']['filename'], '.'));
        $file_extension = substr($file['Attachment']['filename'], strrpos($file['Attachment']['filename'], '.') +1, strlen($file['Attachment']['filename']));
        $file_path = str_replace('\\', '/', 'media' . DS . $file['Attachment']['dir'] . DS . $file['Attachment']['filename']);
        // Code to download
        Configure::write('debug', 0);
        $this->viewClass = 'Media';
        $this->autoLayout = false;
        $this->set('name', trim($filename));
        $this->set('download', true);
        $this->set('extension', trim($file_extension));
        $this->set('mimeType', array(
            $file_extension => get_mime($file_path)
        ));
        $this->set('path', $file_path);
    }
    // Function move_to . One copy of this action is in search action
    // If do change change.. please also make in search action
    function move_to()
    {
        if (!empty($this->request->data)) {
            if ((isset($this->request->data['Message']['more_action_1']) and $this->request->data['Message']['more_action_1'] == 'Create Label') or (isset($this->request->data['Message']['more_action_2']) and $this->request->data['Message']['more_action_2'] == 'Create Label')) {
                $this->redirect(array(
                    'controller' => 'labels',
                    'action' => 'add',
                ));
            }
            if (!empty($this->request->data['Message']['mark_as_read'])) {
                $this->request->data['Message']['more_action_1'] = 'Mark as read';
            }
            if (!empty($this->request->data['Message']['Id'])) {
                // To show alert message when message is not selected
                // By checking if any of the (Message id,value) pair have value=1
                if (!in_array('1', $this->request->data['Message']['Id'])) {
                    $this->Session->setFlash(__l('No messages selected.') , 'default', null, 'error');
                } else {
                    $do_action = '';
                    if (isset($this->request->data['Message']['more_action_1']) and $this->request->data['Message']['more_action_1'] != 'More actions' && $this->request->data['Message']['more_action_1'] != 'Apply label') {
                        $do_action = $this->request->data['Message']['more_action_1'];
                    } elseif (isset($this->request->data['Message']['more_action_2']) and $this->request->data['Message']['more_action_2'] != 'More actions' && $this->request->data['Message']['more_action_2'] != 'Apply label') {
                        $do_action = $this->request->data['Message']['more_action_2'];
                    }
                    foreach($this->request->data['Message']['Id'] AS $message_id => $is_checked) {
                        if ($is_checked) {
                            //	For make archived.  -- Change Status
                            if (!empty($this->request->data['Message']['Archive'])) {
                                $this->_make_archive($message_id);
                            }
                            //	For make spam.	-- Change folder
                            if (!empty($this->request->data['Message']['ReportSpam'])) {
                                $this->_change_folder($message_id, ConstMessageFolder::Spam);
                            }
                            //	For make delete.	-- Change folder
                            if (!empty($this->request->data['Message']['Delete'])) {
                                if ($this->request->data['Message']['folder_type'] == 'trash') {
                                    $this->Message->updateAll(array(
                                        'Message.is_deleted' => 1
                                    ) , array(
                                        'Message.id' => $message_id,
                                        'Message.user_id' => $this->Auth->user('id')
                                    ));
                                }
                                $this->_change_folder($message_id, ConstMessageFolder::Trash);
								$this->Session->setFlash(__l('Message has been deleted successfully') , 'default', null, 'success');
                            }
                            //	Its from the Dropdown
                            switch ($do_action) {
                                case 'Mark as read':
                                    $this->_make_read($message_id, 1);
                                    break;

                                case 'Mark as unread':
                                    $this->_make_read($message_id, 0);
                                    break;

                                case 'Add star':
                                    $this->_make_starred($message_id, 1);
                                    break;

                                case 'Remove star':
                                    $this->_make_starred($message_id, 0);
                                    break;

                                case 'Move to inbox':
                                    $this->_change_folder($message_id, ConstMessageFolder::Inbox);
                                    $message = $this->Message->find('first', array(
                                        'conditions' => array(
                                            'Message.user_id =' => $this->Auth->User('id') ,
                                            'Message.id =' => $message_id
                                        ) ,
                                        'fields' => array(
                                            'Message.id',
                                            'Message.user_id',
                                            'Message.other_user_id',
                                            'Message.parent_message_id',
                                            'Message.is_sender',
                                        ) ,
                                        'recursive' => -1
                                    ));
                                    if ($message['Message']['is_sender'] == 1) {
                                        $this->Message->id = $message_id;
                                        $this->Message->saveField('is_sender', 2);
                                    }
                                    break;

                                default:
                                    //	Apply label.
                                    $is_apply = sizeof(explode('##apply##', $do_action)) -1;
                                    if ($is_apply) {
                                        $_do_action = str_replace('##apply##', '', $do_action);
                                        $label = $this->Label->find('first', array(
                                            'conditions' => array(
                                                'Label.slug' => $_do_action
                                            )
                                        ));
                                        if (!empty($label)) {
                                            $is_exist = $this->LabelsMessage->find('count', array(
                                                'conditions' => array(
                                                    'LabelsMessage.label_id' => $label['Label']['id'],
                                                    'LabelsMessage.message_id' => $message_id
                                                )
                                            ));
                                            if ($is_exist == 0) {
                                                $labelMessage['LabelsMessage']['label_id'] = $label['Label']['id'];
                                                $labelMessage['LabelsMessage']['message_id'] = $message_id;
                                                $this->Message->LabelsMessage->create();
                                                $this->Message->LabelsMessage->save($labelMessage);
                                            }
                                        }
                                    }
                                    //	Remove label.
                                    $is_remove = sizeof(explode('##remove##', $do_action)) -1;
                                    if ($is_remove) {
                                        $_do_action = str_replace('##remove##', '', $do_action);
                                        $label = $this->Label->find('first', array(
                                            'conditions' => array(
                                                'Label.slug' => $_do_action
                                            )
                                        ));
                                        if (!empty($label)) {
                                            $labelMessages = $this->LabelsMessage->find('first', array(
                                                'conditions' => array(
                                                    'LabelsMessage.label_id' => $label['Label']['id'],
                                                    'LabelsMessage.message_id' => $message_id
                                                )
                                            ));
                                            if (!empty($labelMessages)) {
                                                $this->LabelsMessage->delete($labelMessages['LabelsMessage']['id']);
                                            }
                                        }
                                    }
                                    break;
                            }
                        }
                    }
                }
            }
            // to redirect to to the previous page
            $folder_type = $this->request->data['Message']['folder_type'];
            $is_starred = $this->request->data['Message']['is_starred'];
            $label_slug = $this->request->data['Message']['label_slug'];
            if (!empty($label_slug) && $label_slug != 'null') {
                $this->redirect(array(
                    'action' => 'label',
                    $label_slug
                ));
            } elseif (!empty($is_starred)) {
                $this->redirect(array(
                    'action' => 'starred'
                ));
            } else {
                if ($folder_type == 'sent') $folder_type = 'sentmail';
                elseif ($folder_type == 'draft') $folder_type = 'drafts';
                $this->redirect(array(
                    'action' => $folder_type
                ));
            }
        } else {
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
    function _sendAlertOnNewMessage($email, $message, $message_id, $template, $resend = null)
    {
        $this->loadModel('User');
		App::import('Model', 'Jobs.Message');
        $this->Message = new Message();
        App::import('Model', 'Jobs.MessageContent');
        $this->MessageContent = new MessageContent();
        $get_message_hash = $this->Message->find('first', array(
            'conditions' => array(
                'Message.message_content_id = ' => $message_id,
                'Message.is_sender' => 0
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.id',
                        'MessageContent.message',
                        'MessageContent.is_system_flagged',
                        'MessageContent.detected_suspicious_words',
                    ) ,
                ) ,
                'OtherUser' => array(
                    'fields' => array(
                        'OtherUser.id',
                        'OtherUser.username',
                        'OtherUser.email',
                    ) ,
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                    ) ,
                ) ,
            ) ,
            'recursive' => 2
        ));
        if (!empty($get_message_hash) && empty($get_message_hash['MessageContent']['is_system_flagged'])) {
            $get_user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $get_message_hash['Message']['user_id']
                ) ,
                'recursive' => -1
            ));
            $emailFindReplace = array(
                '##MESSAGE##' => $message['message'],
                '##SITE_NAME##' => Configure::read('site.name') ,
                '##SITE_URL##' => Router::url('/', true) ,
                '##REPLY_LINK##' => Router::url(array(
                    'controller' => 'messages',
                    'action' => 'compose',
                    'admin' => false,
                    $get_message_hash['Message']['hash'],
                    'reply'
                ) , true) ,
                '##VIEW_LINK##' => Router::url(array(
                    'controller' => 'messages',
                    'action' => 'view',
                    'admin' => false,
                    $get_message_hash['Message']['hash'],
                ) , true) ,
                '##TO_USER##' => $get_user['User']['username'],
                '##FROM_USER##' => (($template == 'Order Alert Mail') ? 'Administrator' : $this->Auth->user('username')) ,
                '##SITE_NAME##' => Configure::read('site.name') ,
                '##SUBJECT##' => $message['subject'],
            );
            if (!empty($resend)) {
                $emailFindReplace['##FROM_USER##'] = $get_message_hash['OtherUser']['username'];
            }
            App::import('Model', 'EmailTemplate');
            $this->EmailTemplate = new EmailTemplate();
            $email_template = $this->EmailTemplate->selectTemplate($template);
            $this->Message->_sendEmail($email_template, $emailFindReplace, $email);
        }
    }
    /*
    function star($message_id, $current_star)
    {
    $message = '';
    $message['Message']['id'] = $message_id;
    if ($current_star == 'star') $message['Message']['is_starred'] = 1;
    else $message['Message']['is_starred'] = 0;
    if ($this->Message->save($message)) {
    if (!$this->RequestHandler->isAjax()) {
    $this->Session->setFlash(__l('Message has been starred') , 'default', null, 'success');
    $this->redirect(array(
    'action' => 'index'
    ));
    } else {
    if ($message['Message']['is_starred'] == 1) $message = $message_id . '/unstar';
    else $message = $message_id . '/star';
    }
    }
    $this->set('message', $message);
    }*/
    public function star($message_id, $current_star = "")
    {
        $message = $message1 = $this->Message->find('first', array(
            'conditions' => array(
                'Message.id' => $message_id,
            ) ,
            'recursive' => -1
        ));
        if ($this->Auth->user('id') != $message['Message']['user_id'] && $this->Auth->user('id') != $message['Message']['other_user_id']) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $message = '';
        $message['Message']['id'] = $message_id;
        if ($current_star == 'star') {
            $message['Message']['is_starred'] = 1;
            if ($message1['Message']['other_user_id'] == $this->Auth->user('id')) $message['Message']['is_starred_by_otheruser'] = 1;
            else if ($message1['Message']['user_id'] == $this->Auth->user('id')) $message['Message']['is_starred_by_user'] = 1;
        } else {
            $message['Message']['is_starred'] = 0;
            if ($message1['Message']['other_user_id'] == $this->Auth->user('id')) $message['Message']['is_starred_by_otheruser'] = 0;
            else if ($message1['Message']['user_id'] == $this->Auth->user('id')) $message['Message']['is_starred_by_user'] = 0;
        }
        if ($this->Message->save($message)) {
            if (!$this->RequestHandler->isAjax()) {
                // #[app json response]
                if ($this->RequestHandler->prefers('json')) {
                    if ($current_star == 'star') {
                        $current_star = 'unstar';
                    } else {
                        $current_star = 'star';
                    }
                    $resonse = array(
                        'status' => 0,
                        'message' => __l('success') ,
                        'url' => 'messages/star/' . $message_id . '/' . $current_star . '.json',
                    );
                    $this->view = 'Json';
                    $this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
                } else {
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                }
            } else {
                if ($message['Message']['is_starred'] == 1) {
                    $message_link = 'messages/star/' . $message_id . '/unstar';
                } else {
                    $message_link = 'messages/star/' . $message_id . '/star';
                }
                if ($this->RequestHandler->prefers('json')) {
                    if ($current_star == 'star') {
                        $current_star = 'unstar';
                    } else {
                        $current_star = 'star';
                    }
                    $resonse = array(
                        'status' => 0,
                        'message' => __l('success') ,
                        'url' => 'messages/star/' . $message_id . '/' . $current_star . '.json',
                    );
                    $this->view = 'Json';
                    $this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
                }
            }
        }
        $this->set('message', $message);
    }
    function _make_read($message_id, $read_status)
    {
        $this->Message->id = $message_id;
        $this->Message->saveField('is_read', $read_status);
    }
    function _make_starred($message_id, $starred_status)
    {
        $this->Message->id = $message_id;
        $this->Message->saveField('is_starred', $starred_status);
    }
    function _make_archive($message_id)
    {
        $this->Message->id = $message_id;
        $this->Message->saveField('is_archived', 1);
    }
    function _change_folder($message_id, $folder_id)
    {
        $this->Message->id = $message_id;
        $this->Message->saveField('message_folder_id', $folder_id);
    }
    function search($hash = null)
    {
        if (isset($_SESSION['named_url'][$hash])) {
            if ($this->isValidNamedHash($_SESSION['named_url'][$hash], $hash)) {
                $url = $_SESSION['named_url'][$hash];
                foreach($url as $key => $value) {
                    $this->request->params['named'][$key] = $value;
                }
            }
            $this->set('hash', $hash);
        }
        if (!empty($this->request->params)) {
            // this is copy of move_to function
            if (!empty($this->request->data['Message']['Id'])) {
                $do_action = '';
                if ($this->request->params['Message']['more_action_1'] != 'More actions' && $this->request->params['Message']['more_action_1'] != 'Apply label') {
                    $do_action = $this->request->params['Message']['more_action_1'];
                } elseif ($this->request->params['Message']['more_action_2'] != 'More actions' && $this->request->params['Message']['more_action_2'] != 'Apply label') {
                    $do_action = $this->request->params['Message']['more_action_2'];
                }
                foreach($this->request->params['Message']['Id'] AS $message_id => $is_checked) {
                    if ($is_checked) {
                        //	For make archived.  -- Change Status
                        if (!empty($this->request->params['Message']['Archive'])) {
                            MessagesController::_make_archive($message_id);
                        }
                        //	For make spam.	-- Change folder
                        if (!empty($this->request->params['Message']['ReportSpam'])) {
                            MessagesController::_change_folder($message_id, ConstMessageFolder::Spam);
                        }
                        //	For make delete.	-- Change folder
                        if (!empty($this->request->params['Message']['Delete'])) {
                            MessagesController::_change_folder($message_id, ConstMessageFolder::Trash);
                        }
                        //	Its from the Dropdown
                        if ($do_action == 'Mark as read') {
                            MessagesController::_make_read($message_id, 1);
                        } elseif ($do_action == 'Mark as unread') {
                            MessagesController::_make_read($message_id, 0);
                        } elseif ($do_action == 'Add star') {
                            MessagesController::_make_starred($message_id, 1);
                        } elseif ($do_action == 'Remove star') {
                            MessagesController::_make_starred($message_id, 0);
                        } elseif (!empty($do_action)) {
                            //	Apply label.
                            $is_apply = sizeof(explode('##apply##', $do_action)) -1;
                            if ($is_apply) {
                                $_do_action = str_replace('##apply##', '', $do_action);
                                $label = $this->Label->find('first', array(
                                    'conditions' => array(
                                        'Label.slug' => $_do_action
                                    )
                                ));
                                if (!empty($label)) {
                                    $is_exist = $this->LabelsMessage->find('count', array(
                                        'conditions' => array(
                                            'LabelsMessage.label_id' => $label['Label']['id'],
                                            'LabelsMessage.message_id' => $message_id
                                        )
                                    ));
                                    if ($is_exist == 0) {
                                        $labelMessage['LabelsMessage']['label_id'] = $label['Label']['id'];
                                        $labelMessage['LabelsMessage']['message_id'] = $message_id;
                                        $this->Message->LabelsMessage->create();
                                        $this->Message->LabelsMessage->save($labelMessage);
                                    }
                                }
                            }
                            //	Remove label.
                            $is_remove = sizeof(explode('##remove##', $do_action)) -1;
                            if ($is_remove) {
                                $_do_action = str_replace('##remove##', '', $do_action);
                                $label = $this->Label->find('first', array(
                                    'conditions' => array(
                                        'Label.slug' => $_do_action
                                    )
                                ));
                                if (!empty($label)) {
                                    $labelMessages = $this->LabelsMessage->find('first', array(
                                        'conditions' => array(
                                            'LabelsMessage.label_id' => $label['Label']['id'],
                                            'LabelsMessage.message_id' => $message_id
                                        )
                                    ));
                                    if (!empty($labelMessages)) {
                                        $this->LabelsMessage->delete($labelMessages['LabelsMessage']['id']);
                                    }
                                }
                            }
                        }
                    }
                }
            } //More Action End\
            // pr($this->request->data);
            $this->pageTitle = __l('Search Results');
            $this->request->params['form']['search'] = $this->request->data['Message']['search'];
            $this->request->params['form']['from'] = $this->request->data['Message']['from'];
            $this->request->params['form']['to'] = $this->request->data['Message']['to'];
            $this->request->params['form']['subject'] = $this->request->data['Message']['subject'];
            $this->request->params['form']['has_the_words'] = $this->request->data['Message']['has_the_words'];
            $this->request->params['form']['doesnt_have'] = $this->request->data['Message']['doesnt_have'];
            $this->request->params['form']['from_date'] = $this->request->data['Message']['from_date'];
            $this->request->params['form']['to_date'] = $this->request->data['Message']['to_date'];
            //	$this->request->params['form']['advanced_search']=$this->request->data['Message']['advanced_search'];
            $this->request->params['form']['search_by'] = $this->request->data['Message']['search_by'];
            $this->request->params['form']['has_attachment'] = $this->request->data['Message']['has_attachment'];
            $this->_redirectPOST2Named(array(
                'from',
                'to',
                'subject',
                'has_the_words',
                'doesnt_have',
                'from_date',
                'to_date',
                'search_by',
                'has_attachment',
                'search'
            ));
            $search = isset($this->request->params['named']['search']) ? $this->request->params['named']['search'] : '';
            $from = isset($this->request->params['named']['from']) ? $this->request->params['named']['from'] : '';
            $to = isset($this->request->params['named']['to']) ? $this->request->params['named']['to'] : '';
            $subject = isset($this->request->params['named']['subject']) ? $this->request->params['named']['subject'] : '';
            $has_the_words = isset($this->request->params['named']['has_the_words']) ? $this->request->params['named']['has_the_words'] : '';
            $doesnt_have = isset($this->request->params['named']['doesnt_have']) ? $this->request->params['named']['doesnt_have'] : '';
            $from_date = isset($this->request->params['named']['from_date']) ? $this->request->params['named']['from_date'] : '';
            $to_date = isset($this->request->params['named']['to_date']) ? $this->request->params['named']['to_date'] : '';
            $advanced_search = isset($this->request->params['named']['advanced_search']) ? $this->request->params['named']['advanced_search'] : '';
            $search_by = isset($this->request->params['named']['search_by']) ? $this->request->params['named']['search_by'] : '';
            $has_attachment = isset($this->request->params['named']['has_attachment']) ? 1 : '';
            $condition['is_deleted != '] = 1;
            $condition['is_archived != '] = 1;
            if (!empty($subject)) {
                $condition[] = array(
                    'MessageContent.subject LIKE ' => '%' . $subject . '%',
                );
            }
            if (!empty($from)) {
                $from_condition = '';
                $from_users = $this->Message->User->find('first', array(
                    'conditions' => array(
                        'or' => array(
                            'User.email LIKE ' => '%' . $from . '%',
                            'User.username LIKE ' => '%' . $from . '%'
                        )
                    ) ,
                    'recursive' => -1
                ));
                $which_user = '';
                if ($this->Auth->User('id') == $from_users['User']['id']) {
                    $which_user = 'user_id';
                    $condition['Message.is_sender'] = 1;
                } else {
                    $which_user = 'other_user_id';
                    $condition['Message.is_sender'] = 0;
                }
                $condition['Message.' . $which_user] = $from_users['User']['id'];
            }
            if (!empty($to)) {
                $to_condition = '';
                $to_users = $this->Message->User->find('first', array(
                    'conditions' => array(
                        'or' => array(
                            'User.email LIKE ' => '%' . $to . '%',
                            'User.username LIKE ' => '%' . $to . '%'
                        )
                    ) ,
                    'recursive' => -1
                ));
                $check_message_content = array();
                $from_user = isset($from_users['User']['id']) ? $from_users['User']['id'] : $this->Auth->User('id');
                $check_messages = $this->Message->find('all', array(
                    'conditions' => array(
                        'Message.other_user_id =' => $to_users['User']['id'],
                        'Message.user_id =' => $from_user,
                    ) ,
                    'recursive' => -1
                ));
                foreach($check_messages as $check_message) {
                    $check_message_content[] = $check_message['Message']['message_content_id'];
                }
                if ($check_message_content) {
                    $condition['Message.message_content_id'] = $check_message_content;
                }
                $condition['Message.user_id'] = $this->Auth->User('id');
            }
            if (!empty($search_by)) {
                if ($search_by == 'Inbox') {
                    $condition['Message.message_folder_id'] = ConstMessageFolder::Inbox;
                    $condition['Message.is_sender'] = 0;
                    $condition['Message.user_id'] = $this->Auth->User('id');
                } else if ($search_by == 'Starred') {
                    $condition['Message.user_id'] = $this->Auth->User('id');
                    $condition['Message.is_starred'] = 1;
                    $condition['Message.user_id'] = $this->Auth->User('id');
                } else if ($search_by == 'Sent Mail') {
                    $condition['Message.message_folder_id'] = ConstMessageFolder::SentMail;
                    $condition['Message.is_sender'] = 1;
                    $condition['Message.user_id'] = $this->Auth->User('id');
                } else if ($search_by == 'Drafts') {
                    $condition['Message.message_folder_id'] = ConstMessageFolder::Drafts;
                    $condition['Message.user_id'] = $this->Auth->User('id');
                } else if ($search_by == 'Spam') {
                    $condition['Message.message_folder_id'] = ConstMessageFolder::Spam;
                    $condition['Message.user_id'] = $this->Auth->User('id');
                } else if ($search_by == 'Trash') {
                    $condition['Message.message_folder_id'] = ConstMessageFolder::Trash;
                    $condition['Message.user_id'] = $this->Auth->User('id');
                } else if ($search_by == 'Read Mail') {
                    $condition['Message.is_sender'] = 0;
                    $condition['Message.is_read'] = 1;
                    $condition['Message.user_id'] = $this->Auth->User('id');
                } else if ($search_by == 'Unread Mail') {
                    $condition['Message.is_sender'] = 0;
                    $condition['Message.is_read'] = 0;
                    $condition['Message.user_id'] = $this->Auth->User('id');
                } else if ($search_by == 'All Mail') {
                    $condition['Message.user_id'] = $this->Auth->User('id');
                }
            }
            if (!empty($search)) {
                $check_message = array();
                $find_mail_users = $this->Message->User->find('first', array(
                    'conditions' => array(
                        'or' => array(
                            'User.email LIKE ' => '%' . $search . '%',
                            'User.username LIKE ' => '%' . $search . '%'
                        )
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($find_mail_users['User']['id'])) {
                    $condition['Message.other_user_id'] = $find_mail_users['User']['id'];
                } else {
                    $condition['or'] = array(
                        'Messagecontent.subject LIKE ' => '%' . $search . '%',
                        'Messagecontent.message LIKE ' => '%' . $search . '%'
                    );
                }
            }
            if (!empty($from_date)) {
                $condition['Message.created >= '] = $from_date;
            }
            if (!empty($to_date)) {
                $condition['Message.created <= '] = $to_date;
            }
            if (!empty($has_attachment)) {
                $this->set('hasattachment', 1);
            }
            if (!empty($has_the_words)) {
                $condition[] = array(
                    'or' => array(
                        'MessageContent.subject LIKE ' => '%' . $has_the_words . '%',
                        'MessageContent.message LIKE ' => '%' . $has_the_words . '%'
                    )
                );
            }
            if (!empty($doesnt_have)) {
                $condition[] = array(
                    'and' => array(
                        'MessageContent.subject NOT LIKE ' => '%' . $doesnt_have . '%',
                        'MessageContent.message NOT LIKE ' => '%' . $doesnt_have . '%'
                    )
                );
            }
            $condition['Message.user_id'] = $this->Auth->User('id');
            $whichSearch = 'advanced';
            $message_page_size = $this->UserSetting->find('first', array(
                'conditions' => array(
                    'UserSetting.user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'UserSetting.message_page_size'
                )
            ));
            if (!empty($message_page_size['UserSetting']['message_page_size'])) {
                $limit = $message_page_size['UserSetting']['message_page_size'];
            } else {
                $limit = Configure::read('messages.page_size');
            }
            $this->paginate = array(
                'conditions' => $condition,
                'recursive' => 1,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.username'
                        )
                    ) ,
                    'OtherUser' => array(
                        'fields' => array(
                            'OtherUser.username'
                        )
                    ) ,
                    'MessageContent' => array(
                        'Attachment' => array(
                            'fields' => array(
                                'Attachment.id'
                            )
                        ) ,
                        'fields' => array(
                            'MessageContent.subject',
                            'MessageContent.message'
                        )
                    )
                ) ,
                'order' => array(
                    'Message.created DESC'
                ) ,
                'limit' => $limit
            );
            $this->set('messages', $this->paginate());
        }
        $labels = $this->LabelsUser->find('all', array(
            'conditions' => array(
                'LabelsUser.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $options = array();
        $options['More actions'] = __l('---- More actions ----');
        $options['Mark as read'] = __l('Mark as read');
        $options['Mark as unread'] = __l('Mark as unread');
        $options['Add star'] = __l('Add star');
        $options['Remove star'] = __l('Remove star');
        if (!empty($labels)) {
            $options['Apply label'] = __l('----Apply label----');
            foreach($labels as $label) {
                $options['##apply##' . $label['Label']['slug']] = $label['Label']['name'];
            }
            $options['Remove label'] = __l('----Remove label----');
            foreach($labels as $label) {
                $options['##remove##' . $label['Label']['slug']] = $label['Label']['name'];
            }
        }
        $this->set('user_id', $this->Auth->user('id'));
        $this->set('more_option', $options);
    }
    function settings()
    {
        $this->pageTitle.= __l('Settings');
        $setting = $this->Message->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'UserProfile.user_id',
                'UserProfile.id',
                'UserProfile.message_page_size',
            )
        ));
        if (!empty($this->request->data)) {
            if (empty($setting)) {
                $this->Message->User->UserProfile->create();
                $this->request->data['UserProfile']['user_id'] = $this->Auth->user('id');
            } else {
                $this->request->data['UserProfile']['id'] = $setting['UserProfile']['id'];
            }
            $this->Message->User->UserProfile->save($this->request->data);
            $this->Session->setFlash(__l('Message Settings  has been updated') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'messages',
                'action' => 'settings'
            ));
        } else {
            $this->request->data['UserProfile']['message_page_size'] = $setting['UserProfile']['message_page_size'];
            $this->set($this->request->data);
            $this->set('user_id', $this->Auth->user('id'));
        }
    }
    function _findParent($hash = null)
    {
        $all_parents = array();
        for ($i = 0;; $i++) {
            $parent_message = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.hash' => $hash
                ) ,
                'recursive' => 0
            ));
            array_unshift($all_parents, $parent_message);
            if ($parent_message['Message']['parent_message_id'] != 0) {
                $parent_message_data = $this->Message->find('first', array(
                    'conditions' => array(
                        'Message.id' => $parent_message['Message']['parent_message_id']
                    ) ,
                    'recursive' => 0
                ));
                $hash = $parent_message_data['Message']['hash'];
            } else {
                break;
            }
        }
        return $all_parents;
    }
    function home_sidebar()
    {
        $inbox = $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 0,
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'Message.is_read' => 0,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0
            )
        ));
        $friend_request = $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 0,
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'Message.is_read' => 0,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0,
                'MessageContent.subject LIKE ' => '%' . 'has requested to be your friend' . '%'
            ) ,
            'recursive' => 1
        ));
        $referer_request = $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 0,
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'Message.is_read' => 0,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0,
                'MessageContent.subject' => 'Reference Request'
            ) ,
            'recursive' => 1
        ));
        $this->set('inbox', $inbox);
        $this->set('friend_request', $friend_request);
        $this->set('referer_request', $referer_request);
    }
}
?>