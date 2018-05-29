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
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7847 $
 * @modifiedby    $LastChangedBy: renan.saddam $
 * @lastmodified  $Date: 2008-11-08 08:24:07 +0530 (Sat, 08 Nov 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
App::uses('Model', 'Model');
class AppModel extends Model
{
    var $actsAs = array(
        'Containable',
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        Cms::applyHookProperties('Hook.model_properties', $this);
        CmsHook::applyBindModel($this);
        parent::__construct($id, $table, $ds);
        // filter options in admin index
        $this->isFilterOptions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active') ,
        );
        $this->moreActions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function findOrSaveAndGetId($data)
    {
        $findExist = $this->find('first', array(
            'conditions' => array(
                'name' => $data
            ) ,
            'fields' => array(
                'id'
            ) ,
            'recursive' => -1
        ));
        if (!empty($findExist)) {
            return $findExist[$this->name]['id'];
        } else {
            $this->data[$this->name]['name'] = $data;
            $this->save($this->data[$this->name]);
            return $this->id;
        }
    }
    function _isValidCaptcha($captcha = null, $session_var = null, $field_name = 'captcha')
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new Securimage();
        $img->session_var = $session_var;
        return $img->check($captcha[$field_name]);
    }
    public function _isValidCaptchaSolveMedia()
    {
        include_once VENDORS . DS . 'solvemedialib.php';
        $privkey = Configure::read('captcha.verification_key');
        $hashkey = Configure::read('captcha.hash_key');
        $solvemedia_response = solvemedia_check_answer($privkey, $_SERVER["REMOTE_ADDR"], $_POST["adcopy_challenge"], $_POST["adcopy_response"], $hashkey);
        if (!$solvemedia_response->is_valid) {
            //handle incorrect answer
            return false;
        } else {
            return true;
        }
    }
    function getIdHash($ids = null)
    {
        return md5($ids . Configure::read('Security.salt'));
    }
    function isValidIdHash($ids = null, $hash = null)
    {
        return (md5($ids . Configure::read('Security.salt')) == $hash);
    }
    function getJobOrder($job_order_id = null)
    {
        App::import('Model', 'Jobs.JobOrder');
        $this->JobOrder = new JobOrder();
        if (!empty($job_order_id)) {
            $conditions['JobOrder.id'] = $job_order_id;
        }
        $jobInfo = $this->JobOrder->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.title',
                        'Job.slug',
                        'Job.user_id',
                        'Job.no_of_days',
                        'Job.job_category_id',
                        'Job.is_active',
                        'Job.amount',
                        'Job.commission_amount',
                    ) ,
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
            'recursive' => 2
        ));
        return $jobInfo;
    }
    function _sendAlertOnNewMessage($email, $message, $message_id, $template)
    {
        App::import('Model', 'Jobs.Message');
        $this->Message = new Message();
        App::import('Model', 'Jobs.MessageContent');
        $this->MessageContent = new MessageContent();
        $get_message_hash = $this->Message->find('first', array(
            'conditions' => array(
                'Message.message_content_id = ' => $message_id,
                'Message.is_sender' => 0
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
                'Message.hash',
                'Message.job_order_id',
                'Message.job_id',
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.id',
                        'MessageContent.message',
                        'MessageContent.is_system_flagged',
                        'MessageContent.detected_suspicious_words',
                    )
                )
            ) ,
            'recursive' => 2
        ));
        if (!empty($get_message_hash) && empty($get_message_hash['MessageContent']['is_system_flagged'])) {
            $get_user = $this->Message->User->find('first', array(
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
                '##FROM_USER##' => (($template == 'Order Alert Mail') ? 'Administrator' : $_SESSION['Auth']['User']['username']) ,
                '##SITE_NAME##' => Configure::read('site.name') ,
                '##FROM_USER##' => (($template == 'Order Alert Mail') ? 'Administrator' : $_SESSION['Auth']['User']['username']) ,
                '##SUBJECT##' => $message['subject'],
            );
            App::import('Model', 'EmailTemplate');
            $this->EmailTemplate = new EmailTemplate();
            $email_template = $this->EmailTemplate->selectTemplate($template);
            $this->_sendEmail($email_template, $emailFindReplace, $email);
        }
    }
    public function _sendEmail($template, $replace_content, $to, $from = null)
    {
        App::uses('CakeEmail', 'Network/Email');
        $this->Email = new CakeEmail();
        if (isPluginEnabled('HighPerformance') && Configure::read('mail.is_smtp_enabled')) {
            $this->Email->config('smtp');
        }
        $from_email = $template['from'];
        if (!empty($from)) {
            $from_email = $from;
        } elseif ($template['from'] == '##FROM_EMAIL##') {
            $from_email = Configure::read('site.from_email');
        }
        $default_content = array(
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_URL##' => Router::url('/', true) ,
            '##SITE_LINK##' => Router::url('/', true) ,
            '##FROM_EMAIL##' => Configure::read('site.from_email') ,
            '##CONTACT_URL##' => Router::url(array(
                'controller' => 'contacts',
                'action' => 'add',
                'admin' => false
            ) , true) ,
        );
        $emailFindReplace = array_merge($default_content, $replace_content);
        $content['text'] = strtr($template['email_text_content'], $emailFindReplace);
        $content['html'] = strtr($template['email_html_content'], $emailFindReplace);
        $subject = strtr($template['subject'], $emailFindReplace);
        $from_email = strtr($from_email, $emailFindReplace);
        $this->Email->from($from_email, Configure::read('site.name'));
        $reply_to_email = (!empty($template['reply_to']) && $template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
        if (!empty($reply_to_email)) {
            $this->Email->replyTo($reply_to_email);
        }
        $this->Email->to($to);
        $this->Email->subject($subject);
        $this->Email->emailFormat('both');
        $this->Email->send($content);
    }
    function _checkUserNotifications($to_user_id, $order_status_id, $is_sender, $is_contact = null)
    {
        App::import('Model', 'UserNotification');
        $this->UserNotification = new UserNotification();
        $conditions = array();
        $notification_check_array = array(
            '1' => 'is_new_order_seller_notification',
            '2' => 'is_accept_order_buyer_notification',
            '3' => 'is_review_order_buyer_notification',
            '4' => 'is_complete_order_seller_notification',
            '5' => 'is_cancel_order_seller_notification',
            '6' => 'is_reject_order_buyer_notification',
            '7' => 'is_cleared_notification',
            '8' => 'is_expire_order_seller_notification',
            '9' => 'is_in_progress_overtime_notification',
            '10' => 'is_cancel_order_seller_notification',
            '11' => 'is_admin_cancel_order_seller_notification',
            '12' => 'is_complete_later_order_seller_notification',
            '46' => 'is_recieve_dispute_notification',
            '48' => 'is_recieve_mutual_cancel_notification',
            '49' => 'is_receive_redeliver_notification',
        );
        $notification_check_sender_array = array(
            '1' => 'is_new_order_buyer_notification',
            '2' => 'is_accept_order_seller_notification',
            '3' => 'is_review_order_seller_notification',
            '4' => 'is_complete_order_buyer_notification',
            '5' => 'is_cancel_order_buyer_notification',
            '6' => 'is_reject_order_seller_notification',
            '7' => 'is_cleared_notification',
            '8' => 'is_expire_order_buyer_notification',
            '9' => 'is_in_progress_overtime_notification',
            '10' => 'is_cancel_order_buyer_notification',
            '11' => 'is_admin_cancel_buyer_notification',
            '12' => 'is_complete_later_order_buyer_notification',
            '15' => 'is_recieve_mutual_cancel_notification',
            '46' => 'is_recieve_dispute_notification',
            '48' => 'is_recieve_mutual_cancel_notification',
            '49' => 'is_receive_redeliver_notification',
        );
        if (!empty($is_contact)) {
            $conditions['UserNotification.is_contact_notification'] = 1;
        }
        if (!empty($to_user_id)) {
            $check_notifications = $this->UserNotification->find('first', array(
                'conditions' => array(
                    'UserNotification.user_id' => $to_user_id
                ) ,
                'recursive' => -1
            ));
            if (!empty($check_notifications)) {
                $conditions['UserNotification.user_id'] = $to_user_id;
                if (empty($is_contact)) {
                    if (empty($is_sender)) {
                        if (isset($notification_check_array[$order_status_id])) $conditions["UserNotification.$notification_check_array[$order_status_id]"] = '1';
                    } else {
                        $conditions["UserNotification.$notification_check_sender_array[$order_status_id]"] = '1';
                    }
                }
                $check_send_mail = $this->UserNotification->find('first', array(
                    'conditions' => $conditions,
                    'recursive' => -1
                ));
                if (!empty($check_send_mail)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
    }
    function siteCurrencyFormat($amount)
    {
        if (Configure::read('site.currency_symbol_place') == 'left') {
            return Configure::read('site.currency') . $amount;
        } else {
            return $amount . Configure::read('site.currency');
        }
    }
    function formatToAddress($user = null)
    {
        if (!empty($user['UserProfile']['full_name'])) {
            return $user['UserProfile']['full_name'] . ' <' . $user['User']['email'] . '>';
        } else {
            return $user['User']['email'];
        }
    }
    function getJobRating($total_rating, $possitive_rating)
    {
        if (!$total_rating) {
            return __l('Not Rated Yet');
        } else {
            if ($possitive_rating) {
                return floor(($possitive_rating/$total_rating) *100) . '% ' . __l('Positive');
            } else {
                return '100% ' . __l('Negative');
            }
        }
    }
    function siteJobAmount($verb = 'and')
    {
        $amount = explode(',', Configure::read('job.price'));
        if (count($amount) > 1) {
            $last_value = $amount[count($amount) -1];
            unset($amount[count($amount) -1]);
            $amount = Configure::read('site.currency') . implode(', ' . Configure::read('site.currency') , $amount);
            $amount = $amount . ' ' . $verb . ' ' . Configure::read('site.currency') . $last_value;
        } else {
            $amount = Configure::read('site.currency') . $amount['0'];
        }
        return $amount;
    }
    function getGatewayTypes($field = null)
    {
        App::uses('PaymentGateway', 'Model');
        $this->PaymentGateway = new PaymentGateway();
        $settingsCondition = array(
            'PaymentGatewaySetting.test_mode_value' => 1
        );
        if (!is_null($field)) {
            $settingsCondition['PaymentGatewaySetting.name'] = $field;
        }
        $paymentGateways = $this->PaymentGateway->find('all', array(
            'conditions' => array(
                'PaymentGateway.is_active' => 1
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'conditions' => $settingsCondition,
                ) ,
            ) ,
            'order' => array(
                'PaymentGateway.display_name' => 'asc'
            ) ,
            'recursive' => 1
        ));
        $payment_gateway_types = array();
        foreach($paymentGateways as $paymentGateway) {
            if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                if (($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) || ($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::Wallet && isPluginEnabled('Wallets'))) {
                    $payment_gateway_types[$paymentGateway['PaymentGateway']['id']] = $paymentGateway['PaymentGateway']['display_name'];
                }
            }
        }
        return $payment_gateway_types;
    }
    public function toSaveIp()
    {
        App::import('Model', 'Ip');
        $this->Ip = new Ip();
        $this->data['Ip']['ip'] = RequestHandlerComponent::getClientIP();
        $ip = $this->Ip->find('first', array(
            'conditions' => array(
                'Ip.ip' => $this->data['Ip']['ip']
            ) ,
            'fields' => array(
                'Ip.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($ip)) {
            if (!empty($_COOKIE['_geo'])) {
                $_geo = explode('|', $_COOKIE['_geo']);
                $country = $this->Ip->Country->find('first', array(
                    'conditions' => array(
                        'Country.iso_alpha2' => $_geo[0]
                    ) ,
                    'fields' => array(
                        'Country.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($country)) {
                    $this->data['Ip']['country_id'] = 0;
                } else {
                    $this->data['Ip']['country_id'] = $country['Country']['id'];
                }
                $state = $this->Ip->State->find('first', array(
                    'conditions' => array(
                        'State.name' => $_geo[1]
                    ) ,
                    'fields' => array(
                        'State.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($state)) {
                    $this->data['State']['name'] = $_geo[1];
                    $this->Ip->State->create();
                    $this->Ip->State->save($this->data['State']);
                    $this->data['Ip']['state_id'] = $this->Ip->getLastInsertId();
                } else {
                    $this->data['Ip']['state_id'] = $state['State']['id'];
                }
                $city = $this->Ip->City->find('first', array(
                    'conditions' => array(
                        'City.name' => $_geo[2]
                    ) ,
                    'fields' => array(
                        'City.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($city)) {
                    $this->data['City']['name'] = $_geo[2];
                    $this->Ip->City->create();
                    $this->Ip->City->save($this->data['City']);
                    $this->data['Ip']['city_id'] = $this->Ip->City->getLastInsertId();
                } else {
                    $this->data['Ip']['city_id'] = $city['City']['id'];
                }
                $this->data['Ip']['latitude'] = $_geo[3];
                $this->data['Ip']['longitude'] = $_geo[4];
            } else {
                $this->data['Ip']['user_agent'] = env('HTTP_USER_AGENT');
            }
            $this->Ip->create();
            $this->Ip->save($this->data['Ip']);
            return $this->Ip->getLastInsertId();
        } else {
            return $ip['Ip']['id'];
        }
    }
    /**
     * Updates multiple model records based on a set of conditions.
     *
     * call afterSave() callback after successful update.
     *
     * @param array $fields     Set of fields and values, indexed by fields.
     *                          Fields are treated as SQL snippets, to insert literal values manually escape your data.
     * @param mixed $conditions Conditions to match, true for all records
     * @return boolean True on success, false on failure
     * @access public
     */
    public function updateAll($fields, $conditions = true)
    {
        $args = func_get_args();
        $output = call_user_func_array(array(
            'parent',
            'updateAll'
        ) , $args);
        if ($output) {
            $created = false;
            $options = array();
            $field = sprintf('%s.%s', $this->alias, $this->primaryKey);
            if (!empty($args[1][$field]) && is_array($args[1][$field])) {
                foreach($args[1][$field] as $id) {
                    $this->id = $id;
                    $event = new CakeEvent('Model.afterSave', $this, array(
                        $created,
                        $options
                    ));
                    $this->getEventManager()->dispatch($event);
                }
            }
            $this->_clearCache();
            return true;
        }
        return false;
    }
    function sendNotifications($to, $subject, $message, $job_order_id, $is_review = 0, $job_id, $job_order_status_id, $job_order_dispute_id = null, $is_auto = 0)
    {
        App::import('Model', 'Jobs.Message');
        $this->Message = new Message();
        App::import('Model', 'Jobs.MessageContent');
        $this->MessageContent = new MessageContent();
        //  to save message content
        $message_content['MessageContent']['id'] = '';
        $message_content['MessageContent']['subject'] = $subject;
        $message_content['MessageContent']['message'] = $message;
        $this->MessageContent->save($message_content);
        $message_id = $this->MessageContent->id;
        $size = strlen($subject) +strlen($message);
        $from = ConstUserIds::Admin;
        // To save in inbox //
        $is_saved = $this->Message->saveMessage($to, $from, $message_id, ConstMessageFolder::Inbox, 0, 0, 0, $size, $job_id, $job_order_id, $is_review, $job_order_status_id, $job_order_dispute_id, $is_auto);
        // To save in sent iteams //
        $is_saved = $this->Message->saveMessage($from, $to, $message_id, ConstMessageFolder::SentMail, 1, 1, 0, $size, $job_id, $job_order_id, $is_review, $job_order_status_id, $job_order_dispute_id, $is_auto);
        return $message_id;
    }
}
?>