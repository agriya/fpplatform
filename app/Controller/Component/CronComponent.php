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
class CronComponent extends Component
{
    var $controller;
    function run_crons()
    {
        $this->update_job_orders();
        $this->auto_expire();
        $this->inactive_users();
        $this->in_progress_overtime();
        $this->auto_review_complete();
        if (isPluginEnabled('Disputes')) {
            $this->auto_dispute_close();
        }
        if (Configure::read('job.auto_accept_mutual_cancel_request') != 0) {
            $this->auto_accept_mutual_cancellation();
        }
        if (isPluginEnabled('Affiliates')) {
            App::import('Model', 'Affiliates.Affiliate');
            $this->Affiliate = new Affiliate();
            $this->Affiliate->update_affiliate_status();
        }
    }
    function update_job_orders($conditions = array())
    {
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        App::import('Model', 'Jobs.JobOrder');
        $this->JobOrder = new JobOrder();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
        $jobOrders = $this->JobOrder->find('all', array(
            'conditions' => array_merge(array(
                'JobOrder.job_order_status_id' => array(
                    ConstJobOrderStatus::Completed,
                    ConstJobOrderStatus::CompletedAndClosedByAdmin,
                )
            ) , $conditions) ,
            'fields' => array(
                'JobOrder.id',
                'JobOrder.created',
                'JobOrder.user_id',
                'JobOrder.job_id',
                'JobOrder.job_order_status_id',
                'JobOrder.amount',
                'JobOrder.completed_date',
                'JobOrder.commission_amount',
                'JobOrder.payment_gateway_id',
                'JobOrder.is_delayed_chained_payment'
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                    )
                ) ,
                'JobOrderStatus' => array(
                    'fields' => array(
                        'JobOrderStatus.id',
                        'JobOrderStatus.name',
                    )
                ) ,
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.created',
                        'Job.title',
                        'Job.user_id',
                        'Job.slug',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                            'User.blocked_amount',
                            'User.available_balance_amount',
                            'User.cleared_amount',
                        )
                    )
                ) ,
            ) ,
            'recursive' => 2,
        ));
        $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
        foreach($jobOrders as $jobOrder) {
            $expected_date_diff = strtotime('now') -strtotime($jobOrder['JobOrder']['completed_date']);
            if ($expected_date_diff != '') {
                if ($expected_date_diff >= Configure::read('job.days_after_amount_withdraw')) {
                    $refund = array();
                    if ($jobOrder['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                        App::import('Model', 'Payment');
                        $this->Payment = new Payment();
                        $refund = $this->Payment->_executeProcessOrder($jobOrder['JobOrder']['id']);
                    }
                    if (empty($refund['error'])) {
                        $job_order['JobOrder']['id'] = $jobOrder['JobOrder']['id'];
                        $job_order['JobOrder']['job_order_status_id'] = ConstJobOrderStatus::PaymentCleared;
                        $this->JobOrder->save($job_order);
                        $this->JobOrder->User->updateAll(array(
                            'User.available_balance_amount' => 'User.available_balance_amount - ' . ($jobOrder['JobOrder']['amount']-$jobOrder['JobOrder']['commission_amount']) ,
                            'User.cleared_amount' => 'User.cleared_amount + ' . ($jobOrder['JobOrder']['amount']-$jobOrder['JobOrder']['commission_amount']) ,
                        ) , array(
                            'User.id' => $jobOrder['Job']['User']['id']
                        ));
                        if ($jobOrder['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::Wallet && isPluginEnabled('Wallets')) {
                            $this->JobOrder->User->updateAll(array(
                                'User.available_wallet_amount' => 'User.available_wallet_amount + ' . ($jobOrder['JobOrder']['amount']-$jobOrder['JobOrder']['commission_amount'])
                            ) , array(
                                'User.id' => $jobOrder['Job']['User']['id']
                            ));
                        }
                        // Updating transaction again for seller //
                        $transaction['Transaction']['id'] = '';
                        $transaction['Transaction']['user_id'] = $jobOrder['Job']['User']['id'];
                        $transaction['Transaction']['foreign_id'] = $jobOrder['JobOrder']['id'];
                        $transaction['Transaction']['class'] = 'JobOrder';
                        $transaction['Transaction']['amount'] = ($jobOrder['JobOrder']['amount']-$jobOrder['JobOrder']['commission_amount']);
                        $transaction['Transaction']['description'] = 'Amount cleared';
                        $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::SellerAmountCleared;
                        $this->Transaction->save($transaction);
                        // Send notification mail //
                        // Send Notification Message //
                        $user = $jobOrder['Job']['User']['id'];
                        $username = $jobOrder['Job']['User']['username'];
                        $template = $this->EmailTemplate->selectTemplate('Cleared amount notification');
                        $emailFindReplace = array(
                            '##USERNAME##' => $username,
                            '##JOB_NAME##' => "<a href=" . Router::url(array(
                                'controller' => 'jobs',
                                'action' => 'view',
                                $jobOrder['Job']['slug'],
                                'admin' => false
                            ) , true) . ">" . $jobOrder['Job']['title'] . "</a>",
                            '##ORDERNO##' => $jobOrder['JobOrder']['id'],
                            '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                            '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
                        );
                        $message = strtr($template['email_text_content'], $emailFindReplace);
                        $subject = strtr($template['subject'], $emailFindReplace);
                        $message_id = $this->send_notifications($user, $subject, $message, $jobOrder['JobOrder']['id'], $is_review = 0, $jobOrder['Job']['id'], ConstJobOrderStatus::PaymentCleared);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $sender_email = $jobOrder['Job']['User']['email'];
                            $content['subject'] = 'Your amount has been cleared for withdrawal';
                            $content['message'] = 'Your amount has been cleared for withdrawal';
                            $content['cache_site_name'] = $cache_site_name;
                            if (!empty($sender_email)) {
                                if ($this->JobOrder->_checkUserNotifications($user, ConstJobOrderStatus::PaymentCleared, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    function auto_expire()
    {
        App::import('Model', 'Job');
        $this->Job = new Job();
        App::import('Model', 'JobOrder');
        $this->JobOrder = new JobOrder();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Jobs.Message');
        $this->Message = new Message();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
        $jobOrders = $this->JobOrder->find('all', array(
            'conditions' => array(
                'JobOrder.job_order_status_id' => ConstJobOrderStatus::WaitingforAcceptance,
            ) ,
            'fields' => array(
                'JobOrder.id',
                'JobOrder.created',
                'JobOrder.user_id',
                'JobOrder.job_id',
                'JobOrder.job_order_status_id',
                'JobOrder.amount',
                'JobOrder.completed_date',
                'JobOrder.commission_amount',
                'JobOrder.payment_gateway_id',
                'JobOrder.is_delayed_chained_payment',
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.available_balance_amount',
                    )
                ) ,
                'JobOrderStatus' => array(
                    'fields' => array(
                        'JobOrderStatus.id',
                        'JobOrderStatus.name',
                    )
                ) ,
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.created',
                        'Job.title',
                        'Job.user_id',
                        'Job.slug',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                            'User.blocked_amount',
                            'User.available_balance_amount',
                            'User.cleared_amount',
                            'User.available_purchase_amount',
                        )
                    )
                ) ,
            ) ,
            'recursive' => 2,
        ));
        $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
        foreach($jobOrders as $jobOrder) {
            $start = $jobOrder['JobOrder']['created'];
            $end = date('Y-m-d H:i:s');
            $order['start'] = strtotime($start);
            $order['end'] = strtotime($end);
            $diff = $order['end']-$order['start'];
            $days = intval((floor($diff/86400)));
            if ($days != '' || $days == '0') {
                if ($days >= Configure::read('job.auto_expire')) {
                    $refund = array();
                    if (!empty($jobOrder['JobOrder']['payment_gateway_id']) && $jobOrder['JobOrder']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('SudoPay')) {
                        App::import('Model', 'Payment');
                        $this->Payment = new Payment();
                        $refund = $this->Payment->_refundProcessOrder($jobOrder['JobOrder']['id']);
                    }
                    if (empty($refund['error'])) {
                        if (!empty($jobOrder['JobOrder']['payment_gateway_id']) && ($jobOrder['JobOrder']['payment_gateway_id'] != ConstPaymentGateways::SudoPay)) { // Paypal adaptive reverse process shouldn't reduce from wallet
                            // Update Buyer //
                            $this->JobOrder->User->updateAll(array(
                                'User.available_wallet_amount' => 'User.available_wallet_amount + ' . $jobOrder['JobOrder']['amount'],
                            ) , array(
                                'User.id' => $jobOrder['User']['id']
                            ));
                        }
                        // Update Seller //
                        $this->JobOrder->User->updateAll(array(
                            'User.blocked_amount' => 'User.blocked_amount - ' . ($jobOrder['JobOrder']['amount']-$jobOrder['JobOrder']['commission_amount']) ,
                        ) , array(
                            'User.id' => $jobOrder['Job']['User']['id']
                        ));
                        // Update Job order Status //
                        $job_order['JobOrder']['id'] = $jobOrder['JobOrder']['id'];
                        $job_order['JobOrder']['job_order_status_id'] = ConstJobOrderStatus::Expired;
                        $this->JobOrder->save($job_order);
                        // Updating transaction again for buyer //
                        $transaction['Transaction']['id'] = '';
                        $transaction['Transaction']['user_id'] = $jobOrder['User']['id'];
                        $transaction['Transaction']['foreign_id'] = $jobOrder['JobOrder']['id'];
                        $transaction['Transaction']['class'] = 'JobOrder';
                        $transaction['Transaction']['amount'] = $jobOrder['JobOrder']['amount'];
                        $transaction['Transaction']['description'] = "Job order has been expired";
                        $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::RefundForExpiredJobs;
                        $this->Transaction->save($transaction);
                        // Updating transaction again for buyer //
                        $transaction['Transaction']['id'] = '';
                        $transaction['Transaction']['user_id'] = $jobOrder['Job']['User']['id'];
                        $transaction['Transaction']['foreign_id'] = $jobOrder['JobOrder']['id'];
                        $transaction['Transaction']['class'] = 'JobOrder';
                        $transaction['Transaction']['amount'] = $jobOrder['JobOrder']['amount']-$jobOrder['JobOrder']['commission_amount'];
                        $transaction['Transaction']['description'] = "Job order has been expired";
                        $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::SellerDeductedForExpiredJob;
                        $this->Transaction->save($transaction);
                        // Send Notification Message //
                        $users = array(
                            $jobOrder['Job']['User']['id'] => $jobOrder['Job']['User']['username'], // SELLER
                            $jobOrder['User']['id'] => $jobOrder['User']['username'] // BUYER

                        );
                        $mail_template = 'Auto expired notification';
                        $days_check = Configure::read('job.auto_expire');
                        foreach($users as $key => $value) {
                            $template = $this->EmailTemplate->selectTemplate($mail_template);
                            $emailFindReplace = array(
                                '##USERNAME##' => $value,
                                '##JOB_NAME##' => "<a href=" . Router::url(array(
                                    'controller' => 'jobs',
                                    'action' => 'view',
                                    $jobOrder['Job']['slug'],
                                    'admin' => false
                                ) , true) . ">" . $jobOrder['Job']['title'] . "</a>",
                                '##ORDERNO##' => $jobOrder['JobOrder']['id'],
                                '##EXPIRE_DATE##' => (empty($days_check) || ($days_check == '1')) ? $days_check . ' ' . __l('day') : $days_check . ' ' . __l('days') ,
                                '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                                '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
                            );
                            $message = strtr($template['email_text_content'], $emailFindReplace);
                            $subject = strtr($template['subject'], $emailFindReplace);
                            $message_id = $this->send_notifications($key, $subject, $message, $jobOrder['JobOrder']['id'], $is_review = 0, $jobOrder['Job']['id'], ConstJobOrderStatus::Expired);
                            if (Configure::read('messages.is_send_email_on_new_message')) {
                                $sender_emails = array(
                                    $jobOrder['Job']['User']['id'] => $jobOrder['Job']['User']['email'],
                                    $jobOrder['User']['id'] => $jobOrder['User']['email']
                                );
                                $content['subject'] = 'Your order has been auto expired';
                                $content['message'] = 'Your order has been auto expired';
                                $content['cache_site_name'] = $cache_site_name;
                                if ($jobOrder['Job']['User']['id'] == $jobOrder['Job']['user_id']) {
                                    $notification_check = '0';
                                }
                                if ($jobOrder['JobOrder']['user_id'] == $jobOrder['User']['id']) {
                                    $notification_check = '1';
                                }
                                if ($this->JobOrder->_checkUserNotifications($key, ConstJobOrderStatus::Expired, $notification_check)) {
                                    $this->_sendAlertOnNewMessage($sender_emails[$key], $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    function inactive_users()
    {
        App::import('Model', 'User');
        $this->User = new User();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        $users = $this->User->find('all', array(
            'conditions' => array(
                'User.active_job_count >' => 0
            ) ,
            'fields' => array(
                'User.id',
                'User.created',
                'User.username',
                'User.email',
                'User.last_sent_inactive_mail',
                'User.last_logged_in_time'
            ) ,
            'contain' => array(
                'UserProfile'
            ) ,
            'recursive' => 1
        ));
        $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
        foreach($users as $user) {
            $to_send = '';
            $diff_date = strtotime('now') -strtotime($user['User']['last_logged_in_time']);
            $last_sent_diff_date = strtotime('now') -strtotime($user['User']['last_sent_inactive_mail']);
            if (!empty($user['User']['last_sent_inactive_mail']) && ($last_sent_diff_date >= Configure::read('user.notification_for_inactive_users'))) {
                $to_send = $user['User']['username'];
            } elseif ((empty($user['User']['last_sent_inactive_mail']) || ($user['User']['last_sent_inactive_mail'] == '0000-00-00 00:00:00')) && $diff_date >= Configure::read('user.notification_for_inactive_users')) {
                $to_send = $user['User']['username'];
            }
            if (!empty($to_send)) {
                $emailFindReplace = array(
                    '##USERNAME##' => $to_send,
                    '##SITE_NAME##' => Configure::read('site.name') ,
                    '##SITE_URL##' => $cache_site_name,
                    '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                    '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
                );
                $emailSubjectFindReplace = array(
                    '##SITE_NAME##' => Configure::read('site.name') ,
                );
                App::import('Model', 'EmailTemplate');
                $this->EmailTemplate = new EmailTemplate();
                $email_template = $this->EmailTemplate->selectTemplate('Notification For Inactive Users');
                $this->User->_sendEmail($email_template, $emailFindReplace, $this->User->formatToAddress($user));
                $this->User->updateAll(array(
                    'User.sent_inactive_mail_count' => 'User.sent_inactive_mail_count + ' . '1',
                    'User.last_sent_inactive_mail' => "'" . date('Y-m-d h:i:s') . "'",
                ) , array(
                    'User.id' => $user['User']['id']
                ));
            }
        }
    }
    function in_progress_overtime()
    {
        App::import('Model', 'Job');
        $this->Job = new Job();
        App::import('Model', 'JobOrder');
        $this->JobOrder = new JobOrder();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $conditions = array();
        $conditions['JobOrder.job_order_status_id'] = array(
            ConstJobOrderStatus::InProgress,
            ConstJobOrderStatus::Redeliver
        );
        $conditions['JobOrder.is_under_dispute'] = 0;
        $jobOrders = $this->JobOrder->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'JobOrder.id',
                'JobOrder.created',
                'JobOrder.user_id',
                'JobOrder.job_id',
                'JobOrder.job_order_status_id',
                'JobOrder.amount',
                'JobOrder.completed_date',
                'JobOrder.commission_amount',
                'JobOrder.accepted_date',
                'JobOrder.last_redeliver_accept_date',
                'JobOrder.accepted_date',
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                    )
                ) ,
                'JobOrderStatus' => array(
                    'fields' => array(
                        'JobOrderStatus.id',
                        'JobOrderStatus.name',
                    )
                ) ,
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.created',
                        'Job.title',
                        'Job.user_id',
                        'Job.no_of_days',
                        'Job.slug',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                            'User.blocked_amount',
                            'User.available_balance_amount',
                            'User.cleared_amount',
                        )
                    )
                ) ,
            ) ,
            'recursive' => 2,
        ));
        $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
        $k = 0;
        foreach($jobOrders as $jobOrder) {
            $diff_date = strtotime('now') -strtotime($jobOrder['JobOrder']['accepted_date']);
            $diff_redeliver_date = strtotime('now') -strtotime($jobOrder['JobOrder']['last_redeliver_accept_date']);
            if ($diff_date != '') {
                if ((($diff_date-$jobOrder['Job']['no_of_days']) >= Configure::read('job.days_in_progress_to_overtime') && $jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgress) || (($diff_redeliver_date-$jobOrder['Job']['no_of_days']) >= Configure::read('job.days_in_progress_to_overtime') && $jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Redeliver)) {
                    $job_order['JobOrder']['id'] = $jobOrder['JobOrder']['id'];
                    $job_order['JobOrder']['job_order_status_id'] = ConstJobOrderStatus::InProgressOvertime;
                    $job_order['JobOrder']['is_meet_inprogress_overtime'] = 1;
                    $this->JobOrder->save($job_order);
                    // Send Notification Message //
                    if (Configure::read('messages.is_send_internal_message')) {
                        $users = array(
                            $jobOrder['Job']['User']['id'] => $jobOrder['Job']['User']['username'],
                            $jobOrder['User']['id'] => $jobOrder['User']['username']
                        );
                        $mail_template = 'In Progress Overtime';
                        foreach($users as $key => $value) {
                            $username = $value;
                            $user = $key;
                            $template = $this->EmailTemplate->selectTemplate($mail_template);
                            $emailFindReplace = array(
                                '##USERNAME##' => $username,
                                '##TO_USER##' => $username,
                                '##JOB_NAME##' => "<a href=" . Router::url(array(
                                    'controller' => 'jobs',
                                    'action' => 'view',
                                    $jobOrder['Job']['slug'],
                                    'admin' => false
                                ) , true) . ">" . $jobOrder['Job']['title'] . "</a>",
                                '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                            );
                            $message = strtr($template['email_text_content'], $emailFindReplace);
                            $subject = strtr($template['subject'], $emailFindReplace);
                            $message_id = $this->send_notifications($user, $subject, $message, $jobOrder['JobOrder']['id'], $is_review = 0, $jobOrder['Job']['id'], ConstJobOrderStatus::InProgressOvertime);
                            if (Configure::read('messages.is_send_email_on_new_message')) {
                                $sender_emails = array(
                                    $jobOrder['Job']['User']['email'],
                                    $jobOrder['User']['email']
                                );
                                $sender_ids = array(
                                    $jobOrder['Job']['User']['id'],
                                    $jobOrder['User']['id']
                                );
                                $content['subject'] = 'Your order has exceed the published duration';
                                $content['message'] = 'Your order has exceed the published duration';
                                $content['cache_site_name'] = $cache_site_name;
                                if ($this->JobOrder->_checkUserNotifications($sender_ids[$k], ConstJobOrderStatus::InProgressOvertime, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_emails[$k], $content, $message_id, 'Order Alert Mail');
                                }
                                $k++;
                            }
                        }
                    }
                }
            }
        }
    }
    function auto_review_complete()
    {
        App::import('Model', 'Job');
        $this->Job = new Job();
        App::import('Model', 'JobOrder');
        $this->JobOrder = new JobOrder();
        App::import('Model', 'Jobs.JobFeedback');
        $this->JobFeedback = new JobFeedback();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $jobOrders = $this->JobOrder->find('all', array(
            'conditions' => array(
                'JobOrder.job_order_status_id' => ConstJobOrderStatus::WaitingforReview,
                'JobOrder.is_under_dispute' => 0
            ) ,
            'fields' => array(
                'JobOrder.id',
                'JobOrder.created',
                'JobOrder.user_id',
                'JobOrder.job_id',
                'JobOrder.job_order_status_id',
                'JobOrder.amount',
                'JobOrder.completed_date',
                'JobOrder.commission_amount',
                'JobOrder.delivered_date'
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                    )
                ) ,
                'JobOrderStatus' => array(
                    'fields' => array(
                        'JobOrderStatus.id',
                        'JobOrderStatus.name',
                    )
                ) ,
                'Job' => array(
                    'fields' => array(
                        'Job.id',
                        'Job.created',
                        'Job.title',
                        'Job.user_id',
                        'Job.no_of_days',
                        'Job.slug',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                            'User.blocked_amount',
                            'User.available_balance_amount',
                            'User.cleared_amount',
                        )
                    )
                ) ,
            ) ,
            'recursive' => 2,
        ));
        $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
        foreach($jobOrders as $jobOrder) {
            $diff_date = strtotime('now') -strtotime($jobOrder['JobOrder']['delivered_date']);
            if ($diff_date != '') {
                if (($diff_date) >= Configure::read('job.auto_review_complete')) {
                    $seller_user_id = $jobOrder['Job']['user_id'];
                    $this->JobOrder->User->updateAll(array(
                        'User.blocked_amount' => 'User.blocked_amount - ' . ($jobOrder['JobOrder']['amount']-$jobOrder['JobOrder']['commission_amount']) ,
                        'User.available_balance_amount' => 'User.available_balance_amount + ' . ($jobOrder['JobOrder']['amount']-$jobOrder['JobOrder']['commission_amount'])
                    ) , array(
                        'User.id' => $seller_user_id
                    ));
                    // Change order status & completed_on datetime //
                    $JobOrder['JobOrder']['id'] = $jobOrder['JobOrder']['id'];
                    $JobOrder['JobOrder']['job_order_status_id'] = ConstJobOrderStatus::CompletedAndClosedByAdmin;
                    $JobOrder['JobOrder']['completed_date'] = date('Y-m-d H:i:s');
                    $this->JobOrder->save($JobOrder);
                    // auto review update job feedback table [rating we used]
                    $this->JobFeedback->create();
                    //$jobFeedback['JobFeedback']['ip'] = $this->RequestHandler->getClientIP();
                    $jobFeedback['JobFeedback']['job_id'] = $jobOrder['JobOrder']['job_id'];
                    $jobFeedback['JobFeedback']['user_id'] = $jobOrder['JobOrder']['user_id'];
                    $jobFeedback['JobFeedback']['feedback'] = 'Auto Rreview';
                    $jobFeedback['JobFeedback']['is_satisfied'] = 1;
                    $jobFeedback['JobFeedback']['is_auto_review'] = 1;
                    $this->JobFeedback->save($jobFeedback, false);
                    // Update Transactions //
                    $transaction['Transaction']['user_id'] = $seller_user_id;
                    $transaction['Transaction']['foreign_id'] = $jobOrder['JobOrder']['id'];
                    $transaction['Transaction']['class'] = 'JobOrder';
                    $transaction['Transaction']['amount'] = ($jobOrder['JobOrder']['amount']-$jobOrder['JobOrder']['commission_amount']);
                    $transaction['Transaction']['description'] = 'Job - Amount paid for job to user';
                    $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::PaidAmountToUser;
                    $this->Transaction->save($transaction);
                    $to = $seller_user_id;
                    $order_id = $jobOrder['JobOrder']['id'];
                    $to_user = $jobOrder['Job']['User']['username'];
                    $sender_email = $jobOrder['Job']['User']['email'];
                    $email_message = 'Your order has been auto completed and closed by admin';
                    $mail_template = 'Completed order notification';
                    $redirect = 'myorders';
                    $success_message = 'Your review has been added!';
                    $status = 'completed';
                    // buyer
                    $buyer_to = $jobOrder['User']['id'];
                    $buyer_to_user = $jobOrder['User']['username'];
                    $buyer_email = $jobOrder['User']['email'];
                    // Send Notification Message //
                    $template = $this->EmailTemplate->selectTemplate($mail_template);
                    $emailFindReplace = array(
                        '##USERNAME##' => $to_user,
                        '##JOB_NAME##' => "<a href=" . Router::url(array(
                            'controller' => 'jobs',
                            'action' => 'view',
                            $jobOrder['Job']['slug'],
                            'admin' => false
                        ) , true) . ">" . $jobOrder['Job']['title'] . "</a>",
                        '##ORDERNO##' => $order_id,
                        '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                        '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
                        '##BUYER_USERNAME##' => $jobOrder['User']['username'],
                        '##REVIEW_URL##' => "<a href=" . Router::url(array(
                            'controller' => 'job_feedbacks',
                            'action' => 'add',
                            'admin' => false,
                            'job_order_id' => $order_id,
                        ) , true) . ">" . Router::url(array(
                            'controller' => 'job_feedbacks',
                            'action' => 'add',
                            'admin' => false,
                            'job_order_id' => $order_id,
                        ) , true) . "</a>",
                    );
                    $message = strtr($template['email_text_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    if (Configure::read('messages.is_send_internal_message')) {
                        $message_id = $this->send_notifications($to, $subject, $message, $order_id, $is_review = 0, $jobOrder['Job']['id'], ConstJobOrderStatus::CompletedAndClosedByAdmin);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = $email_message;
                            $content['message'] = $email_message;
                            $content['cache_site_name'] = $cache_site_name;
                            if (!empty($sender_email)) {
                                if ($this->JobOrder->_checkUserNotifications($to, ConstJobOrderStatus::CompletedAndClosedByAdmin, 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Order Alert Mail');
                                }
                            }
                        }
                        //------------
                        // Auto review notification sent to buyer
                        $emailFindReplace['##USERNAME##'] = $buyer_to_user;
                        $template = $this->EmailTemplate->selectTemplate('Auto review notification');
                        $message = strtr($template['email_text_content'], $emailFindReplace);
                        $subject = strtr($template['subject'], $emailFindReplace);
                        $message_for_buyer = strtr($template['email_text_content'], $emailFindReplace);
                        $is_auto = 1;
                        if (Configure::read('messages.send_notification_mail_for_sender')) {
                            $message_id_buyer = $this->Message->sendNotifications($buyer_to, $subject, $message_for_buyer, $order_id, $is_review = 0, $jobOrder['JobOrder']['job_id'], ConstJobOrderStatus::SenderNotification, '0', $is_auto);
                            if (Configure::read('messages.is_send_email_on_new_message')) {
                                $content['subject'] = $email_message;
                                $content['message'] = $email_message;
                                $content['cache_site_name'] = $cache_site_name;
                                if (!empty($buyer_email)) {
                                    if ($this->JobOrder->_checkUserNotifications($buyer_to, ConstJobOrderStatus::CompletedAndClosedByAdmin, 1)) {
                                        $this->JobOrder->_sendAlertOnNewMessage($buyer_email, $content, $message_id_buyer, 'Order Alert Mail');
                                    }
                                }
                            }
                        }
                        //------------

                    }
                }
            }
        }
    }
    function send_notifications($to, $subject, $message, $job_order_id, $is_review = 0, $job_id, $job_order_status_id)
    {
        App::import('Model', 'Message');
        $this->Message = new Message();
        //  to save message content
        $message_content['MessageContent']['id'] = '';
        $message_content['MessageContent']['subject'] = $subject;
        $message_content['MessageContent']['message'] = $message;
        $this->Message->MessageContent->save($message_content);
        $message_id = $this->Message->MessageContent->id;
        $size = strlen($subject) +strlen($message);
        $from = ConstUserIds::Admin;
        // To save in inbox //
        $is_saved = $this->saveMessage($to, $from, $message_id, ConstMessageFolder::Inbox, 0, 0, 0, $size, $job_id, $job_order_id, $is_review, $job_order_status_id);
        // To save in sent iteams //
        $is_saved = $this->saveMessage($from, $to, $message_id, ConstMessageFolder::SentMail, 1, 1, 0, $size, $job_id, $job_order_id, $is_review, $job_order_status_id);
        return $message_id;
    }
    function saveMessage($user_id, $other_user_id, $message_id, $folder_id, $is_sender = 0, $is_read = 0, $parent_id = null, $size, $job_id = null, $job_order_id, $is_review = 0, $job_order_status_id)
    {
        App::import('Model', 'Message');
        $this->Message = new Message();
        $message['Message']['id'] = '';
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
        if (!empty($job_order_status_id)) {
            $message['Message']['job_order_status_id'] = $job_order_status_id;
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
    function _sendAlertOnNewMessage($email, $message, $message_id, $template)
    {
        App::import('Model', 'User');
        $this->User = new User();
        App::import('Model', 'Message');
        $this->Message = new Message();
        App::import('Model', 'MessageContent');
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
                'MessageContent.id',
                'MessageContent.id',
                'MessageContent.message',
                'MessageContent.detected_suspicious_words',
            ) ,
            'recursive' => 1
        ));
        if (!empty($get_message_hash) && empty($get_message_hash['MessageContent']['MessageContent'])) {
            $get_user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $get_message_hash['Message']['user_id']
                ) ,
                'recursive' => -1
            ));
            $emailFindReplace = array(
                '##MESSAGE##' => $message['message'],
                '##SITE_NAME##' => Configure::read('site.name') ,
                '##SITE_URL##' => $message['cache_site_name'],
                '##REPLY_LINK##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                    'controller' => 'messages',
                    'action' => 'compose',
                    'admin' => false,
                    $get_message_hash['Message']['hash'],
                    'reply'
                ) , false) , 1) ,
                '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular) ,
                '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
                '##VIEW_LINK##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                    'controller' => 'messages',
                    'action' => 'view',
                    'admin' => false,
                    $get_message_hash['Message']['hash'],
                ) , false) , 1) ,
                '##TO_USER##' => $get_user['User']['username'],
                '##FROM_USER##' => __l('Administrator') ,
                '##SITE_NAME##' => Configure::read('site.name') ,
                '##FROM_USER##' => 'Administrator',
                '##SUBJECT##' => $message['subject'],
            );
            App::import('Model', 'EmailTemplate');
            $this->EmailTemplate = new EmailTemplate();
            $email_template = $this->EmailTemplate->selectTemplate($template);
            $this->User->_sendEmail($email_template, $emailFindReplace, $email);
        }
    }
    function auto_dispute_close()
    {
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        App::import('Model', 'Jobs.JobOrder');
        $this->JobOrder = new JobOrder();
        App::import('Model', 'Disputes.JobOrderDispute');
        $this->JobOrderDispute = new JobOrderDispute();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $conditions = array();
        $contain_conditions = array();
        $conditions['JobOrderDispute.dispute_status_id'] = array(
            ConstDisputeStatus::Open,
            ConstDisputeStatus::UnderDiscussion,
        );
        $contain_conditions['JobOrder.job_order_status_id'] = array(
            ConstJobOrderStatus::InProgress,
            ConstJobOrderStatus::WaitingforReview,
            ConstJobOrderStatus::Completed,
            ConstJobOrderStatus::InProgressOvertime,
            ConstJobOrderStatus::Redeliver,
        );
        $jobOrderDisputes = $this->JobOrderDispute->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'JobOrderDispute.id',
                'JobOrderDispute.created',
                'JobOrderDispute.user_id',
                'JobOrderDispute.dispute_type_id',
                'JobOrderDispute.dispute_status_id',
                'JobOrderDispute.last_replied_date',
                'JobOrderDispute.last_replied_user_id',
                'JobOrderDispute.job_id',
                'JobOrderDispute.job_order_id',
                'JobOrderDispute.reason'
            ) ,
            'contain' => array(
                'DisputeStatus',
                'JobUserType' => array(
                    'fields' => array(
                        'JobUserType.id',
                        'JobUserType.name',
                    )
                ) ,
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
                            'User.email',
                            'User.blocked_amount',
                        )
                    ) ,
                ) ,
                'JobOrder' => array(
                    'fields' => array(
                        'JobOrder.id',
                        'JobOrder.user_id',
                        'JobOrder.amount',
                        'JobOrder.job_id',
                        'JobOrder.commission_amount',
                        'JobOrder.payment_gateway_id',
                        'JobOrder.job_order_status_id',
                    ) ,
                    'conditions' => $contain_conditions,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                            'User.available_balance_amount',
                        )
                    ) ,
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email'
                    )
                ) ,
            ) ,
            'recursive' => 3,
        ));
        if (!empty($jobOrderDisputes)) {
            foreach($jobOrderDisputes as $dispute) {
                $last_replied_date_diff = strtotime('now') -strtotime($dispute['JobOrderDispute']['last_replied_date']);
                $is_buyer = $is_seller = 0;
                if (empty($last_replied_date_diff) && empty($dispute['JobOrderDispute']['last_replied_date'])) {
                    if ($dispute['JobOrderDispute']['created'] >= Configure::read('dispute.days_left_for_disputed_user_to_reply')) {
                        if ($dispute['JobOrderDispute']['user_id'] == $dispute['JobOrder']['user_id']) {
                            $is_buyer = 1;
                        } else {
                            $is_seller = 1;
                        }
                    }
                } else {
                    if ($last_replied_date_diff >= Configure::read('dispute.days_left_for_disputed_user_to_reply')) {
                        if ($dispute['JobOrderDispute']['last_replied_user_id'] == $dispute['JobOrder']['user_id']) {
                            $is_buyer = 1;
                        } else {
                            $is_seller = 1;
                        }
                    }
                }
                // Resolution //
                if (!empty($is_buyer)) {
                    switch ($dispute['JobOrderDispute']['dispute_type_id']) {
                        case 1: //I received an item that does not match the seller's description.
                            $close_type['close_type_7'] = 'close_type_7';
                            $this->JobOrderDispute->_resolveByRefund($dispute);
                            $this->JobOrderDispute->_closeDispute($close_type, $dispute_detail);
                            break;

                        case 2: // Buyer requesting rework without reason
                            $close_type['close_type_3'] = 'close_type_3';
                            $this->JobOrderDispute->_closeDispute($close_type, $dispute);
                            break;

                        case 3: // Buyer given poor feedback
                            $close_type['close_type_5'] = 'close_type_5';
                            $this->JobOrderDispute->_closeDispute($close_type, $dispute);
                            break;
                    }
                } elseif (!empty($is_seller)) {
                    switch ($dispute['JobOrderDispute']['dispute_type_id']) {
                        case 1: //I received an item that does not match the seller's description.
                            $close_type['close_type_2'] = 'close_type_2';
                            $this->JobOrderDispute->_closeDispute($close_type, $dispute);
                            break;

                        case 2: // Buyer requesting rework without reason
                            $close_type['close_type_8'] = 'close_type_8';
                            $this->JobOrderDispute->_resolveByPaySeller($dispute);
                            $this->JobOrderDispute->_closeDispute($close_type, $dispute);
                            break;

                        case 3: // Buyer given poor feedback
                            $close_type['close_type_9'] = 'close_type_9';
                            $this->JobOrderDispute->_resolveByReview($dispute);
                            $this->JobOrderDispute->_closeDispute($close_type, $dispute);
                            break;
                    }
                }
            }
        }
    }
    function auto_accept_mutual_cancellation()
    {
        App::import('Model', 'JobOrder');
        $this->JobOrder = new JobOrder();
        $conditions = array();
        $conditions['OR'] = array(
            'JobOrder.is_seller_request_for_cancel' => 1,
            'JobOrder.is_buyer_request_for_cancel' => 1,
        );
        $conditions['JobOrder.job_order_status_id'] = array(
            ConstJobOrderStatus::InProgress,
            ConstJobOrderStatus::InProgressOvertime,
            ConstJobOrderStatus::WaitingforReview,
            ConstJobOrderStatus::Redeliver,
        );
        $jobOrders = $this->JobOrder->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'JobOrder.id',
                'JobOrder.created',
                'JobOrder.user_id',
                'JobOrder.job_id',
                'JobOrder.job_order_status_id',
                'JobOrder.mutual_cancel_request',
                'JobOrder.mutual_cancel_accept',
                'JobOrder.mutual_cancellation_requested_date',
                'JobOrder.amount',
                'JobOrder.completed_date',
                'JobOrder.commission_amount',
                'JobOrder.payment_gateway_id'
            ) ,
            'recursive' => -1,
        ));
        foreach($jobOrders as $joborder) {
            $cancellation_diff_date = strtotime('now') -strtotime($joborder['JobOrder']['mutual_cancellation_requested_date']);
            if (!empty($cancellation_diff_date) && $cancellation_diff_date >= Configure::read('job.auto_accept_mutual_cancel_request')) {
                $this->JobOrder->updateAll(array(
                    'JobOrder.mutual_cancel_accept' => $joborder['JobOrder']['mutual_cancel_accept']+1, // reset redeliver request because request has been accepted

                ) , array(
                    'JobOrder.id' => $joborder['JobOrder']['id']
                ));
                $message = __l('Mutual cancellation request made on') . ' ' . $joborder['JobOrder']['mutual_cancellation_requested_date'] . ' ' . __l('was not accepted by within auto cancellation days of') . ' ' . Configure::read('job.auto_accept_mutual_cancel_request') . '. ' . __l('So, mutual cancellation request has been cancelled automatically accepted.');
                $this->JobOrder->processOrder($joborder['JobOrder']['id'], 'mutual_cancel', $message);
            }
        }
    }
    public function daily()
    {
        $this->_cronsInPlugin('daily');
    }
    public function _cronsInPlugin($function)
    {
        $plugins = explode(',', Configure::read('Hook.bootstraps'));
        if (!empty($plugins)) {
            App::uses('ComponentCollection', 'Controller');
            $collection = new ComponentCollection();
            foreach($plugins AS $plugin) {
                $pluginName = Inflector::camelize($plugin);
                if (file_exists(APP . 'Plugin' . DS . $pluginName . DS . 'Controller' . DS . 'Component' . DS . $pluginName . 'CronComponent.php')) {
                    $pluginComponent = $pluginName . 'CronComponent';
                    App::uses($pluginComponent, $pluginName . '.Controller/Component');
                    $cronObj = new $pluginComponent($collection);
                    if (method_exists($cronObj, $function)) {
                        $cronObj->{$function}();
                    }
                }
            }
        }
    }
}
?>
