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
/* SVN FILE: $Id: app_controller.php 4993 2010-05-17 09:43:02Z subingeorge_082at09 $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @version       $Revision: 7805 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
App::uses('Controller', 'Controller');
class AppController extends Controller
{
    /**
     * Components
     *
     * @var array
     * @access public
     */
    public $components = array(
        'Security',
        'Auth',
        'Acl.AclFilter',
        'XAjax',
        'RequestHandler',
        'Cookie',
        'Cms'
    );
    /**
     * Helpers
     *
     * @var array
     * @access public
     */
    public $helpers = array(
        'Html',
        'Form',
        'Javascript',
        'Session',
        'Text',
        'Js',
        'Time',
        'Layout',
        'Auth',
    );
    /**
     * Models
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Block',
        'Link',
        'Setting',
        'Node',
    );
    /**
     * Pagination
     */
    public $paginate = array(
        'limit' => 10,
    );
    /**
     * Cache pagination results
     *
     * @var boolean
     * @access public
     */
    public $usePaginationCache = true;
    /**
     * View
     *
     * @var string
     * @access public
     */
    public $viewClass = 'Theme';
    /**
     * Theme
     *
     * @var string
     * @access public
     */
    public $theme;
    /**
     * Constructor
     *
     * @access public
     */
    public $homePageId;
    var $cookieTerm = '+4 weeks';
    function beforeRender()
    {
        $this->set('meta_for_layout', Configure::read('meta'));
        $this->set('js_vars_for_layout', (isset($this->js_vars)) ? $this->js_vars : '');
        parent::beforeRender();
    }
    function __construct($request = null, $response = null)
    {
        App::uses('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Security');
        $this->Security = new SecurityComponent($collection);
        App::import('Component', 'Auth');
        $this->Auth = new AuthComponent($collection);
        App::import('Component', 'Session');
        $this->Session = new SessionComponent($collection);
        Cms::applyHookProperties('Hook.controller_properties', $this);
        parent::__construct($request, $response);
    }
    function beforeFilter()
    {
        $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
        // Coding done to disallow demo user to change the admin settings
        if ($this->request->params['action'] != 'flashupload') {
            $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
            if ($this->Auth->user('id') && !Configure::read('site.is_admin_settings_enabled') && (in_array($this->request->params['action'], Configure::read('site.admin_demo_mode_not_allowed_actions')) || (!empty($this->request->data) && in_array($cur_page, Configure::read('site.admin_demo_mode_update_not_allowed_pages'))))) {
                $this->Session->setFlash(__l('Sorry. We have disabled this action in demo mode') , 'default', null, 'error');
                if (in_array($this->request->params['controller'], array(
                    'settings',
                    'email_templates'
                ))) {
                    unset($this->request->data);
                } else {
                    $this->redirect(array(
                        'controller' => $this->request->params['controller'],
                        'action' => 'index'
                    ));
                }
            }
        }
        // End of Code
        if (!$this->Auth->user('id') && !empty($_COOKIE['_gz'])) {
            setcookie('_gz', '', time() -3600, '/');
        }
        if ($this->Auth->user('id') && empty($_COOKIE['_gz'])) {
            $hashed_val = md5($this->Auth->user('id') . session_id() . PERMANENT_CACHE_GZIP_SALT);
            $hashed_val = substr($hashed_val, 0, 7);
            $form_cookie = $this->Auth->user('id') . '|' . $hashed_val;
            setcookie('_gz', $form_cookie, time() +60*60*24, '/');
        }
        if (($job_alternate_name = Cache::read('job.job_alternate_name', 'long')) === false) {
            Cache::write('job.job_alternate_name', Configure::read('job.job_alternate_name') , 'long');
        }
        if (($job_alternate_name = Cache::read('request.request_alternate_name', 'long')) === false) {
            Cache::write('request.request_alternate_name', Configure::read('request.request_alternate_name') , 'long');
        }
        // check ip is banned or not. redirect it to 403 if ip is banned
        $this->loadModel('BannedIp');
        $bannedIp = $this->BannedIp->checkIsIpBanned($this->RequestHandler->getClientIP());
        if (empty($bannedIp)) {
            $bannedIp = $this->BannedIp->checkRefererBlocked(env('HTTP_REFERER'));
        }
        if (!empty($bannedIp)) {
            if (!empty($bannedIp['BannedIp']['redirect'])) {
                header('location: ' . $bannedIp['BannedIp']['redirect']);
            } else {
                throw new ForbiddenException(__l('Forbidden'));
            }
        }
        // Writing site name in cache, required for getting sitename retrieving in cron
        if (!(Cache::read('site_url_for_shell', 'long'))) {
            Cache::write('site_url_for_shell', Router::url('/', true) , 'long');
        }
        // check site is under maintenance mode or not. admin can set in settings page and then we will display maintenance message, but admin side will work.
        $maintenance_exception_array = array(
            'devs/asset_js',
            'devs/asset_css',
            'devs/robots',
            'devs/sitemap',
            'users/show_header',
        );
        if (Configure::read('site.maintenance_mode') && $this->Auth->user('role_id') != ConstUserTypes::Admin && empty($this->request->params['prefix']) && !in_array($cur_page, $maintenance_exception_array)) {
            throw new MaintenanceModeException(__l('Maintenance Mode'));
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin && (isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin')) {
            $this->layout = 'admin';
        }
        if (Configure::read('site.maintenance_mode') && !$this->Auth->user('role_id')) {
            $this->layout = 'maintenance';
        }
        $this->AclFilter->_checkAuth();
        //Fix to upload the file through the flash multiple uploader
        if ((isset($_SERVER['HTTP_USER_AGENT']) and ((strtolower($_SERVER['HTTP_USER_AGENT']) == 'shockwave flash') or (strpos(strtolower($_SERVER['HTTP_USER_AGENT']) , 'adobe flash player') !== false))) and isset($this->request->params['pass'][0]) and ($this->request->action == 'flashupload')) {
            session_id($this->request->params['pass'][0]);
            session_start();
        }
        if ($this->Auth->user('id')) {
            $this->loadModel('User');
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
        }
        $is_redirect_to_social_marketing = 1;
        if (isPluginEnabled('SocialMarketing') && empty($this->request->params['requested']) && !empty($is_redirect_to_social_marketing)) {
            $skip_urls = array(
                'users/login',
                'users/logout',
                'devs/asset_js',
                'devs/asset_css',
                'social_marketings/import_friends',
                'social_contacts/index',
                'social_contacts/update',
                'user_followers/add_multiple',
                'messages/activities',
                'users/show_header',
                'social_marketings/publish_success',
                'messages/notification',
                'images/view'
            );
            if ($this->Auth->user('id') && !in_array($cur_page, $skip_urls) && !empty($user) && (!$user['User']['is_skipped_fb'] || !$user['User']['is_skipped_twitter'] || !$user['User']['is_skipped_google'] || !$user['User']['is_skipped_yahoo'])) {
                if (!$user['User']['is_skipped_fb']) {
                    $type = 'facebook';
                } elseif (!$user['User']['is_skipped_twitter']) {
                    $type = 'twitter';
                } elseif (!$user['User']['is_skipped_google']) {
                    $type = 'gmail';
                } elseif (!$user['User']['is_skipped_yahoo']) {
                    $type = 'yahoo';
                } elseif (!$user['User']['is_skipped_linkedin']) {
                    $type = 'linkedin';
                }
                $this->redirect(array(
                    'controller' => 'social_marketings',
                    'action' => 'import_friends',
                    'type' => $type,
                    'admin' => false
                ));
            }
        }
        if (strpos($this->request->here, '/view/') !== false) {
            trigger_error('*** dev1framework: Do not view page through /view/; use singular/slug', E_USER_ERROR);
        }
        // check the method is exist or not in the controller
        $methods = array_flip($this->methods);
        if (!isset($methods[strtolower($this->request->params['action']) ])) {
            throw new NotFoundException('Invalid request');
        }
        // Home page ID
        $this->homePageId = intval(Configure::read('Page.home_page_id'));
        // referral link that update cookies
        $this->_affiliate_referral();
        /* *
        Todo: need to move this code to Tranlation plugin
        */
        /*
        $this->js_vars['cfg']['job_alternatename'] = jobAlternateName(ConstJobAlternateName::Singular);
        $this->js_vars['cfg']['path_relative'] = Router::url('/');
        $this->js_vars['cfg']['path_absolute'] = Router::url('/', true);
        $this->js_vars['cfg']['date_format'] = Configure::read('site.date.format');
        $this->js_vars['cfg']['today_date'] = date('Y-m-d');
        $this->js_vars['cfg']['maximum_job_title_length'] = Configure::read('job.maximum_title_length');
        $this->js_vars['cfg']['maximum_job_description_length'] = Configure::read('job.maximum_description_length');
        */
        parent::beforeFilter();
        if (isPluginEnabled('LaunchModes')) {
            $pre_launch_exception_array = array(
                'subscriptions/add',
                'subscriptions/check_invitation',
                'subscriptions/confirmation',
                'users/logout',
                'users/facepile',
                'nodes/view',
                'jobs/index',
                'pages/view',
                'images/view',
                'devs/asset_js',
                'devs/asset_css',
                'devs/robots',
                'devs/sitemap',
                'users/show_captcha',
                'users/captcha_play',
                'payments/user_pay_now',
                'payments/get_gateways',
                'users/show_header',
                'users/show_notification',
            );
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                if (Configure::read('site.launch_mode') == 'Pre-launch' && !in_array($cur_page, $pre_launch_exception_array)) {
                    if (empty($this->request->params['prefix'])) {
                        $this->redirect(array(
                            'controller' => 'jobs',
                            'action' => 'index',
                            'admin' => false
                        ));
                    }
                }
            }
            $private_beta_exception_array = array_merge($pre_launch_exception_array, array(
                'users/login',
                'users/logout',
                'users/register',
                'users/admin_login',
                'users/show_header',
                'users/show_notification',
                'users/forgot_password',
                'users/activation',
                'users/reset',
            ));
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                if (Configure::read('site.launch_mode') == 'Private Beta' && !in_array($cur_page, $private_beta_exception_array) && !$this->Auth->user('id')) {
                    if (empty($this->request->params['prefix'])) {
                        $this->redirect(array(
                            'controller' => 'jobs',
                            'action' => 'index',
                            'admin' => false
                        ));
                    } else {
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                }
            }
        }
        // user avail balance
        if ($this->Auth->user('id')) {
            $this->loadModel('User');
            App::import('Model', 'User');
            $user_model_obj = new User();
            $user = $user_model_obj->find('first', array(
                'conditions' => array(
                    'User.id =' => $this->Auth->user('id') ,
                ) ,
                'contain' => array(
                    'UserAvatar',
                    'UserProfile' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2'
                            )
                        )
                    ) ,
                ) ,
                'recursive' => 2
            ));
            $this->set('logged_in_user', $user);
        }
        // to check wallet disable/enable
        App::import('Model', 'PaymentGateway');
        $payment_gateway = new PaymentGateway();
        $this->is_wallet_enabled = $payment_gateway->find('count', array(
            'conditions' => array(
                'PaymentGateway.id =' => ConstPaymentGateways::Wallet,
                'PaymentGateway.is_active =' => 1,
            ) ,
            'recursive' => -1
        ));
        $this->set('is_wallet_enabled', $this->is_wallet_enabled);
    }
    function autocomplete($param_encode = null, $param_hash = null)
    {
        $modelClass = Inflector::singularize($this->name);
        $conditions = false;
        if (isset($this->{$modelClass}->_schema['is_approved'])) {
            $conditions['is_approved = '] = '1';
        }
        // For 0171977: [QA] - In auto completion own username should not display in compose message
        if ($modelClass == 'User' && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            $conditions['User.id !='] = $this->Auth->user('id');
        }
        $this->XAjax->autocomplete($param_encode, $param_hash, $conditions);
    }
    function _redirectGET2Named($whitelist_param_names = null)
    {
        $query_strings = array();
        if (is_array($whitelist_param_names)) {
            foreach($whitelist_param_names as $param_name) {
                if (isset($this->request->query[$param_name])) { // querystring
                    $query_strings[$param_name] = $this->request->query[$param_name];
                }
            }
        } else {
            $query_strings = $this->request->params['url'];
            unset($query_strings['url']); // Can't use ?url=foo

        }
        if (!empty($query_strings)) {
            $query_strings = array_merge($this->request->params['named'], $query_strings);
            $this->redirect($query_strings, null, true);
        }
    }
    function show_captcha($session_var = null)
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new securimage();
        $img->session_var = $session_var;
        $img->show(); // alternate use:  $img->show('/path/to/background.jpg');
        $this->autoRender = false;
    }
    function captcha_play($session_var = null)
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new Securimage();
        $img->session_var = $session_var;
        $this->disableCache();
        $this->RequestHandler->respondAs('mp3', array(
            'attachment' => 'captcha.mp3'
        ));
        $img->audio_format = 'mp3';
        echo $img->getAudibleCode('mp3');
    }
    function admin_update()
    {
        if (!empty($this->request->data[$this->modelClass])) {
            if ($this->modelClass == 'Message' || $this->modelClass == 'MessageContent') // Detach the model for message and message content,so to disable flagging for admin functions
            $this->Message->MessageContent->Behaviors->detach('SuspiciousWordsDetector');
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $ids = array();
            foreach($this->request->data[$this->modelClass] as $id => $is_checked) {
                if ($is_checked['id']) {
                    $ids[] = $id;
                }
            }
            if ($actionid && !empty($ids)) {
                switch ($actionid) {
                    case ConstMoreAction::Inactive:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_active' => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        if ($this->modelClass == 'Request') {
                            $this->Session->setFlash(__l('Checked ' . requestAlternateName(ConstRequestAlternateName::Singular) . ' has been inactivated') , 'default', null, 'success');
                        }
                        if ($this->modelClass == 'Job') {
                            $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been inactivated') , 'default', null, 'success');
                        }
                        break;

                    case ConstMoreAction::Active:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_active' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        if ($this->modelClass == 'Request') {
                            $this->Session->setFlash(__l('Checked ' . requestAlternateName(ConstRequestAlternateName::Singular) . ' has been activated') , 'default', null, 'success');
                        }
                        if ($this->modelClass == 'Job') {
                            $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been activated') , 'default', null, 'success');
                        }
                        break;

                    case ConstMoreAction::Disapproved:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_approved' => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        if ($this->modelClass == 'Request') {
                            $this->Session->setFlash(__l('Checked ' . requestAlternateName(ConstRequestAlternateName::Singular) . ' has been disapproved') , 'default', null, 'success');
                        }
                        if ($this->modelClass == 'Job') {
                            $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been disapproved') , 'default', null, 'success');
                        }
                        break;

                    case ConstMoreAction::Approved:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_approved' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        if ($this->modelClass == 'Request') {
                            $this->Session->setFlash(__l('Checked ' . requestAlternateName(ConstRequestAlternateName::Singular) . ' has been approved') , 'default', null, 'success');
                        }
                        if ($this->modelClass == 'Job') {
                            $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been approved') , 'default', null, 'success');
                        }
                        break;

                    case ConstMoreAction::Satisfy:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_satisfied' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been changed to satisfied') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unsatisfy:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_satisfied' => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been changed to unsatisfied') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Feature:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_featured' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been changed to featured') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unfeature:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_featured' => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been changed to unfeatured') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Suspend:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.admin_suspend' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        if ($this->modelClass == 'Job') {
                            foreach($ids as $id) {
                                $get_orders = $this->Job->find('first', array(
                                    'conditions' => array(
                                        'Job.id' => $id,
                                    ) ,
                                    'contain' => array(
                                        'JobOrder'
                                    ) ,
                                    'recursive' => 1
                                ));
                                if (!empty($get_orders['JobOrder'])) {
                                    foreach($get_orders['JobOrder'] as $job_order) {
                                        $this->JobOrder->processOrder($job_order['id'], 'admin_cancel');
                                    }
                                }
                            }
                            $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been Suspended') , 'default', null, 'success');
                        }
                        if ($this->modelClass == 'Request') {
                            $this->Session->setFlash(__l('Checked ' . requestAlternateName(ConstRequestAlternateName::Singular) . ' has been Suspended') , 'default', null, 'success');
                        }
                        break;

                    case ConstMoreAction::Unsuspend:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.admin_suspend' => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        if ($this->modelClass == 'Request') {
                            $this->Session->setFlash(__l('Checked ' . requestAlternateName(ConstRequestAlternateName::Singular) . ' has been changed to Unsuspended') , 'default', null, 'success');
                        }
                        if ($this->modelClass == 'Job') {
                            $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been changed to Unsuspended') , 'default', null, 'success');
                        }
                        break;

                    case ConstMoreAction::Unflagged:
                        foreach($ids as $id) {
                            if (!empty($id)) {
                                $messageUserId = $this->Message->find('first', array(
                                    'conditions' => array(
                                        'Message.id' => $id
                                    ) ,
                                    'recursive' => -1
                                ));
                                $saveMessage['id'] = $messageUserId['Message']['message_content_id'];
                                if (Configure::read('messages.is_send_email_on_new_message')) {
                                    $this->_reSendMail($messageUserId['Message']['message_content_id']); // RESEND CLEARED MESSAGES //

                                }
                                $saveMessage['is_system_flagged'] = 0;
                                $this->Message->MessageContent->save($saveMessage);
                            }
                        }
                        $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been changed to Unflagged') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Flagged:
                        foreach($ids as $id) {
                            if (!empty($id)) {
                                $messageUserId = $this->Message->find('first', array(
                                    'conditions' => array(
                                        'Message.id' => $id
                                    ) ,
                                    'recursive' => -1
                                ));
                                $saveMessage['id'] = $messageUserId['Message']['message_content_id'];
                                $saveMessage['is_system_flagged'] = 1;
                                $this->Message->MessageContent->save($saveMessage);
                            }
                        }
                        $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been changed to flagged') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::ActivateUser:
                        foreach($ids as $id) {
                            if (!empty($id)) {
                                $messageUserId = $this->Message->find('first', array(
                                    'conditions' => array(
                                        'Message.id' => $id
                                    ) ,
                                ));
                                if ($messageUserId['User']['role_id'] != ConstUserTypes::Admin) {
                                    $saveMessageUser['id'] = $messageUserId['Message']['user_id'];
                                    $saveMessageUser['is_active'] = 1;
                                    $this->Message->User->save($saveMessageUser);
                                }
                            }
                        }
                        $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' user has been changed to active') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::DeActivateUser:
                        foreach($ids as $id) {
                            if (!empty($id)) {
                                $messageUserId = $this->Message->find('first', array(
                                    'conditions' => array(
                                        'Message.id' => $id
                                    ) ,
                                ));
                                if ($messageUserId['User']['role_id'] != ConstUserTypes::Admin) {
                                    $saveMessageUser['id'] = $messageUserId['Message']['user_id'];
                                    $saveMessageUser['is_active'] = 0;
                                    $this->Message->User->save($saveMessageUser);
                                }
                            }
                        }
                        $this->Session->setFlash(__l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' user has been changed to inactive') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Delete:
                        foreach($ids as $id) {
                            $this->{$this->modelClass}->delete($id, true);
                        }
                        $successMessage = __l('Checked records has been deleted');
                        if ($this->modelClass == 'Job') {
                            $successMessage = __l('Checked ' . jobAlternateName(ConstJobAlternateName::Singular) . ' has been deleted');
                        }
                        if ($this->modelClass == 'RequestView') {
                            $successMessage = __l('Checked ' . requestAlternateName(ConstRequestAlternateName::Singular) . ' view has been deleted');
                        }
                        $this->Session->setFlash($successMessage, 'default', null, 'success');
                        break;

                    case ConstMoreAction::Export:
                        $user_ids = implode(',', $userIds);
                        $hash = $this->{$this->modelClass}->getUserIdHash($user_ids);
                        $_SESSION['user_export'][$hash] = $userIds;
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'export',
                            'ext' => 'csv',
                            $hash,
                            'admin' => true
                        ));
                        break;

                    case ConstMoreAction::Unpublish:
                        $field_name = 'status';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been unpublished') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Publish:
                        $field_name = 'status';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been published') , 'default', null, 'success');
                        break;
                    }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    function _sendAlertOnNewMessage($email, $message, $message_id, $template, $resend = null)
    {
        $this->loadModel('User');
        App::import('Model', 'Message');
        $this->Message = new Message();
        App::import('Model', 'MessageContent');
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
            $this->User->_sendEmail($email_template, $emailFindReplace, $email);
        }
    }
    function admin_update_status($id = null)
    {
        $this->loadModel('JobOrder');
        App::import('Model', 'Jobs.JobOrder');
        $this->JobOrder = new JobOrder;
        $ajax_repsonse = '';
        $error_message = '';
        $success_message = '';
        if (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'deactivate')) {
            $field = 'is_active';
            $value = 0;
            $ajax_repsonse = 'user_blocked';
            $url = Router::url(array(
                'controller' => 'users',
                'action' => 'admin_update_status',
                'status' => 'activate',
                $id
            ) , true);
            $success_message = $this->modelClass . ' ' . __l('has been deactivated successfully');
            $this->_sendAdminActionMail($id, 'Admin User Deactivate');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'activate')) {
            $field = 'is_active';
            $value = 1;
            $ajax_repsonse = 'user_unblocked';
            $url = Router::url(array(
                'controller' => 'users',
                'action' => 'admin_update_status',
                'status' => 'deactivate',
                $id
            ) , true);
            $success_message = $this->modelClass . ' ' . __l('has been activated successfully');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'inactive')) {
            $field = 'status';
            $value = 0;
            $ajax_repsonse = 'node_published';
            $url = Router::url(array(
                'controller' => 'nodes',
                'action' => 'admin_update_status',
                'status' => 'active',
                $id
            ) , true);
            $success_message = $this->modelClass . ' ' . __l('has been inactive successfully');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'active')) {
            $field = 'status';
            $value = 1;
            $ajax_repsonse = 'node_unpublished';
            $url = Router::url(array(
                'controller' => 'users',
                'action' => 'admin_update_status',
                'status' => 'deactivate',
                $id
            ) , true);
            $success_message = $this->modelClass . ' ' . __l('has been active successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'suspend')) {
            $field = 'admin_suspend';
            $value = 1;
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_suspend';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'flag' => 'unsuspend',
                    $id
                ) , true);
            } else {
                $ajax_repsonse = 'job_suspend';
                if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                    $get_orders = $this->Job->find('first', array(
                        'conditions' => array(
                            'Job.id' => $id,
                        ) ,
                        'contain' => array(
                            'JobOrder' => array(
                                'conditions' => array(
                                    'JobOrder.job_order_status_id' => array(
                                        ConstJobOrderStatus::WaitingforAcceptance,
                                        ConstJobOrderStatus::InProgress,
                                        ConstJobOrderStatus::WaitingforReview,
                                        ConstJobOrderStatus::InProgressOvertime,
                                    )
                                )
                            )
                        ) ,
                        'recursive' => 1
                    ));
                    if (!empty($get_orders['JobOrder'])) {
                        foreach($get_orders['JobOrder'] as $job_order) {
                            $this->JobOrder->processOrder($job_order['id'], 'admin_cancel');
                        }
                    }
                }
                $url = Router::url(array(
                    'controller' => 'jobs',
                    'action' => 'admin_update_status',
                    'flag' => 'unsuspend',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('has been suspended successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'unsuspend')) {
            $field = 'admin_suspend';
            $value = 0;
            $ajax_repsonse = 'job_unsuspend';
            $url = Router::url(array(
                'controller' => 'jobs',
                'action' => 'admin_update_status',
                'flag' => 'suspend',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_unsuspend';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'flag' => 'suspend',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('has been unsuspended successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'active')) {
            $field = 'is_system_flagged';
            $value = 1;
            $ajax_repsonse = 'flagged';
            $url = Router::url(array(
                'controller' => 'jobs',
                'action' => 'admin_update_status',
                'flag' => 'deactivate',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_flagged';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'flag' => 'deactivate',
                    $id
                ) , true);
            }
            // $this->_sendAdminActionMail($id, 'Admin User Active');
            $success_message = $this->modelClass . ' ' . __l('has been flagged successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'deactivate')) {
            $field = 'is_system_flagged';
            $value = 0;
            $ajax_repsonse = 'flag_cleared';
            $url = Router::url(array(
                'controller' => 'jobs',
                'action' => 'admin_update_status',
                'flag' => 'active',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_flag_cleared';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'flag' => 'active',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('has been unflagged successfully');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'disapproved')) {
            $field = 'is_approved';
            $value = 0;
            $ajax_repsonse = 'job_approved';
            $url = Router::url(array(
                'controller' => 'jobs',
                'action' => 'admin_update_status',
                'status' => 'approved',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_approved';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'status' => 'approved',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('has been disapproved successfully');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'approved')) {
            $field = 'is_approved';
            $value = 1;
            $ajax_repsonse = 'job_disapproved';
            $url = Router::url(array(
                'controller' => 'jobs',
                'action' => 'admin_update_status',
                'status' => 'disapproved',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_disapproved';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'status' => 'disapproved',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('has been approved successfully');
        } else {
            $ajax_repsonse = 'failed';
        }
        if ($this->modelClass == 'Message' && !empty($this->request->params['named']['flag'])) {
            $this->Message->MessageContent->updateAll(array(
                $field => $value
            ) , array(
                'MessageContent.id' => $id
            ));
            if (!empty($this->request->params['named']['flag']) == 'deactivate') {
                if (Configure::read('messages.is_send_email_on_new_message')) {
                    $this->_reSendMail($id); // RESEND CLEARED MESSAGES //

                }
            }
            if (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'active')) {
                $ajax_repsonse = 'message_flagged';
                $url = Router::url(array(
                    'controller' => 'messages',
                    'action' => 'admin_update_status',
                    'flag' => 'deactivate',
                    $id
                ) , true);
            } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'deactivate')) {
                $ajax_repsonse = 'message_flag_cleared';
                $url = Router::url(array(
                    'controller' => 'messages',
                    'action' => 'admin_update_status',
                    'flag' => 'active',
                    $id
                ) , true);
            }
        } else {
            if ($error_message == '') {
                $data[$this->modelClass]['id'] = $id;
                $data[$this->modelClass][$field] = $value;
                $this->{$this->modelClass}->save($data, false);
                // Quickfix, since above doesn't work for flagged alone //
                $this->{$this->modelClass}->updateAll(array(
                    $this->modelClass . '.' . $field => $value
                ) , array(
                    $this->modelClass . '.id' => $id
                ));
                if (!empty($success_message)) {
                    $this->Session->setFlash($success_message, 'default', null, 'success');
                }
            } else {
                $this->Session->setFlash($error_message, 'default', null, 'error');
            }
        }
        if ($this->RequestHandler->isAjax() && !empty($ajax_repsonse)) {
            echo $ajax_repsonse . '|' . $url;
            exit;
        } else {
            $this->redirect(array(
                'action' => 'index',
            ));
        }
    }
    function _sendAdminActionMail($user_id, $email_template)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.username',
                'User.email'
            ) ,
            'recursive' => -1
        ));
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_LINK##' => Router::url('/', true) ,
        );
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $email_template = $this->EmailTemplate->selectTemplate($email_template);
        $this->User->_sendEmail($email_template, $emailFindReplace, $user['User']['email']);
    }
    function _reSendMail($message_content_id = null)
    { // RESEND MAIL AFTER UNFLAGGING //
        App::import('Model', 'Message');
        $this->Message = new Message();
        if (!empty($message_content_id)) {
            $getMessage = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.message_content_id' => $message_content_id,
                    'Message.is_sender' => 1
                ) ,
                'contain' => array(
                    'User',
                    'MessageContent'
                ) ,
                'recursive' => 0
            ));
            if (!empty($getMessage)) {
                $message['message'] = $getMessage['MessageContent']['message'];
                $message['subject'] = $getMessage['MessageContent']['subject'];
                $this->_sendAlertOnNewMessage($getMessage['User']['email'], $message, $message_content_id, 'Alert Mail', 1);
            }
        }
    }
    function redirect($url, $status = null, $exit = true)
    {
        // Possible controllers for with name job
        $job_alternate_name = strtolower(Configure::read('job.job_alternate_name'));
        $job_alternate_name = !empty($job_alternate_name) ? $job_alternate_name : 'jobs';
        $job_alternate_name_plural = Inflector::pluralize($job_alternate_name);
        $job_alternate_name_singular = Inflector::singularize($job_alternate_name);
        $request_alternate_name = strtolower(Configure::read('request.request_alternate_name'));
        $request_alternate_name = !empty($request_alternate_name) ? $request_alternate_name : 'requests';
        $request_alternate_name_plural = Inflector::pluralize($request_alternate_name);
        $request_alternate_name_singular = Inflector::singularize($request_alternate_name);
        if (!empty($url['controller'])) {
            $job_array = array(
                'jobs',
                'job_orders',
                'job_favorites',
                'job_categories',
                'job_feedbacks',
                'job_flags',
                'job_flag_categories',
                'job_views',
                'job_types',
            );
            $request_array = array(
                'requests',
                'request_views',
                'request_flags',
                'request_flag_categories',
                'request_favorites',
            );
            if (in_array($url['controller'], $job_array)) {
                if ($url['controller'] == 'jobs') {
                    $url['controller'] = $job_alternate_name_plural;
                } else {
                    $url_exploded = explode('_', $url['controller']);
                    unset($url_exploded[0]);
                    $url['controller'] = $job_alternate_name_singular . '_' . implode('_', $url_exploded);
                }
            } else if (in_array($url['controller'], $request_array)) {
                if ($url['controller'] == 'requests') {
                    $url['controller'] = $request_alternate_name_plural;
                } else {
                    $url_exploded = explode('_', $url['controller']);
                    unset($url_exploded[0]);
                    $url['controller'] = $request_alternate_name_singular . '_' . implode('_', $url_exploded);
                }
            }
        }
        parent::redirect($url, $status, $exit);
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
        return 'img/' . $image_hash;
    }
    function userJobCount($user_id = null)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
            ) ,
            'recursive' => -1
        ));
        return $user['User']['job_count'];
    }
    function _affiliate_referral()
    {
        foreach($this->request->params['named'] as $key => $value) {
            if (empty($key)) {
                $this->loadModel('User');
                if ($this->User->find('count', array(
                    'conditions' => array(
                        'User.username' => $value,
                        'User.is_affiliate_user' => 1
                    ) ,
                    'recursive' => -1
                ))) {
                    $this->request->params['named']['r'] = $value;
                    unset($this->request->params['named'][$key]);
                    unset($this->request->params['named']['referer']);
                }
            }
        }
    }
    function _redirectPOST2Named($whitelist_param_names = null)
    {
        $query_strings = array();
        $model = Inflector::classify($this->request->params['controller']);
        if (is_array($whitelist_param_names)) {
            foreach($whitelist_param_names as $param_name) {
                if (isset($this->request->data[$model][$param_name])) { // querystring
                    $query_strings[$param_name] = strip_tags($this->request->data[$model][$param_name]);
                }
            }
        } else {
            $query_strings = $this->request->query;
            unset($query_strings['url']); // Can't use ?url=foo

        }
        if (!empty($query_strings)) {
            $query_strings = array_merge($this->request->params['named'], $query_strings);
            $this->redirect($query_strings, null, true);
        }
    }
}
?>