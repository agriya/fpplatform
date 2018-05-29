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
class UsersController extends AppController
{
    public $name = 'Users';
    public $components = array(
        'Email',
        'PersistentLogin',
    );
    // Photo, PhotoAlbum and PhotoComment are used in admin_stats
    public $uses = array(
        'User',
        'EmailTemplate',
        'Payment',
    );
    public $helpers = array(
        'Csv'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'index',
            'show_header',
            'dashboard',
            'change_password',
        ) ,
        'is_view_count_update' => true
    );
    public function admin_diagnostics()
    {
        $this->pageTitle = __l('Diagnostics');
        $this->set('pageTitle', $this->pageTitle);
    }
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'User.send_to_user_id',
            'User.referred_by_user_id',
            'User.adaptive_normal',
            'User.adaptive_connect',
            'adcopy_response',
            'adcopy_challenge',
            'User.payment_type',
        );
        parent::beforeFilter();
    }
    public function show_header()
    {
        $this->disableCache();
    }
    public function show_notification()
    {
        $this->disableCache();
    }
    public function admin_action_taken()
    {
        if (isPluginEnabled('Disputes')) {
            App::import('Model', 'Disputes.JobOrderDispute');
            $this->JobOrderDispute = new JobOrderDispute();
            $this->set('pending_dispute', $this->JobOrderDispute->find('count', array(
                'conditions' => array(
                    'JobOrderDispute.dispute_type_id' => ConstDisputeStatus::WaitingForAdministratorDecision
                ) ,
                'recursive' => -1
            )));
        }
        if (isPluginEnabled('Affiliates')) {
            App::import('Model', 'Affiliates.AffiliateRequest');
            $this->AffiliateRequest = new AffiliateRequest();
            $this->set('pending_afftilitate_request', $this->AffiliateRequest->find('count', array(
                'conditions' => array(
                    'AffiliateRequest.is_approved = ' => ConstAffiliateRequests::Pending,
                ) ,
                'recursive' => -1
            )));
            App::import('Model', 'Affiliates.AffiliateCashWithdrawal');
            $this->AffiliateCashWithdrawal = new AffiliateCashWithdrawal();
            $this->set('pending_afftilitate_withdraw_request', $this->AffiliateCashWithdrawal->find('count', array(
                'conditions' => array(
                    'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id = ' => ConstAffiliateCashWithdrawalStatus::Pending,
                ) ,
                'recursive' => -1
            )));
        }
        if (isPluginEnabled('Withdrawals')) {
            App::import('Model', 'Withdrawals.UserCashWithdrawal');
            $this->UserCashWithdrawal = new UserCashWithdrawal();
            $this->set('pending_usercash_withdraw_request', $this->UserCashWithdrawal->find('count', array(
                'conditions' => array(
                    'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending,
                ) ,
                'recursive' => -1
            )));
        }
    }
    function view($username = null)
    {
        $this->pageTitle = __l('User');
        if (is_null($username)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contain = array(
            'UserProfile' => array(
                'fields' => array(
                    'UserProfile.full_name',
                    'UserProfile.about_me',
                    'UserProfile.created',
                    'UserProfile.contact_address',
                    'UserProfile.mobile_phone',
                    'UserProfile.longitude',
                    'UserProfile.latitude',
                ) ,
            ) ,
            'UserAvatar' => array(
                'fields' => array(
                    'UserAvatar.id',
                    'UserAvatar.dir',
                    'UserAvatar.filename',
                    'UserAvatar.width',
                    'UserAvatar.height'
                )
            )
        );
        if (isPluginEnabled('Jobs')) {
            $contain['Job'] = array(
                'fields' => array(
                    'Job.id',
                    'Job.title',
                    'Job.slug',
                    'Job.description',
                    'Job.latitude',
                    'Job.longitude',
                ) ,
            );
        }
        if (isPluginEnabled('Requests')) {
            $contain['Request'] = array(
                'fields' => array(
                    'Request.id',
                    'Request.name',
                    'Request.slug',
                ) ,
            );
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.username = ' => $username
            ) ,
            'contain' => $contain,
            'recursive' => 2
        ));
        if ($this->RequestHandler->prefers('kml')) {
            $this->set('user', $user);
            $this->set('type', $this->request->params['named']['type']);
        } else {
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->User->UserView->create();
            $this->request->data['UserView']['user_id'] = $user['User']['id'];
            $this->request->data['UserView']['viewing_user_id'] = $this->Auth->user('id');
            $this->request->data['UserView']['ip_id'] = $this->User->toSaveIP();
            $this->request->data['UserView']['host'] = gethostbyaddr($this->RequestHandler->getClientIP());
            $this->User->UserView->save($this->request->data);
            $this->pageTitle.= ' - ' . $username;
            if (isPluginEnabled('Jobs')) {
                $job_user_count = $this->User->Job->find('count', array(
                    'conditions' => array(
                        'Job.user_id' => $user['User']['id']
                    ) ,
                    'recursive' => -1
                ));
                $this->set('job_user_count', $job_user_count);
            }
            $this->set('user', $user);
        }
    }
    public function register($type = null)
    {
        $this->pageTitle = __l('Register');
        $socialuser = $this->Session->read('socialuser');
        $is_register = 1;
        if (isPluginEnabled('LaunchModes')) {
            $this->loadModel('LaunchModes.Subscription');
        }
        if ((!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'social') && (!Configure::read('twitter.is_enabled_twitter_connect') && !Configure::read('facebook.is_enabled_facebook_connect') && !Configure::read('linkedin.is_enabled_linkedin_connect') && !Configure::read('yahoo.is_enabled_yahoo_connect') && !Configure::read('google.is_enabled_google_connect') && !Configure::read('googleplus.is_enabled_googleplus_connect') && !Configure::read('openid.is_enabled_openid_connect'))) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register',
            ));
        }
        if (Configure::read('site.launch_mode') == "Private Beta" && !empty($this->request->data) || !empty($_SESSION['invite_hash'])) {
            if (!empty($_SESSION['invite_hash'])) {
            } elseif (isset($this->request->data['User']['invite_hash']) && !empty($this->request->data['User']['invite_hash'])) {
                $is_valid = $this->Subscription->find('count', array(
                    'conditions' => array(
                        'Subscription.invite_hash' => $this->request->data['User']['invite_hash']
                    )
                ));
                if ($is_valid) {
                    $this->Session->setFlash(sprintf(__l('You have submitted invitation code successfully, Welcome to %s') , Configure::read('site.name')) , 'default', null, 'success');
                    unset($this->request->data['User']);
                }
            }
        } elseif (Configure::read('site.launch_mode') == "Private Beta") {
            if (empty($socialuser)) {
                $this->redirect(Router::url('/', true));
                $is_register = 0;
            }
        }
        if ($is_register) {
            if ($referred_by_user_id = $this->Cookie->read('referrer')) {
                $referredByUser = $this->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $referred_by_user_id
                    ) ,
                    'contain' => array(
                        'UserAvatar',
                        'UserProfile'
                    ) ,
                    'recursive' => 2
                ));
                $this->set('referredByUser', $referredByUser);
            }
            $captcha_flag = 1;
            $socialuser = $this->Session->read('socialuser');
            if (!empty($socialuser) && empty($this->request->data)) {
                $this->Session->delete('socialuser');
                $this->request->data['User'] = $socialuser;
                $captcha_flag = 0;
            }
            if (!empty($this->request->data['User']['identifier'])) {
                $captcha_flag = 0;
            }
            if (!empty($this->request->data)) {
                if (!empty($this->request->data['City']['name'])) {
                    //$this->request->data['UserProfile']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->User->UserProfile->City->findOrSaveAndGetId($this->request->data['City']['name']);

                }
                if (!empty($this->request->data['State']['name'])) {
                    $this->request->data['UserProfile']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->User->UserProfile->State->findOrSaveAndGetId($this->request->data['State']['name']);
                }
                if (!empty($this->request->data['User']['country_iso_code'])) {
                    $this->request->data['UserProfile']['country_id'] = $this->User->UserProfile->Country->findCountryIdFromIso2($this->request->data['User']['country_iso_code']);
                    if (empty($this->request->data['UserProfile']['country_id'])) {
                        unset($this->request->data['UserProfile']['country_id']);
                    }
                }
                $captcha_error = 0;
                if ($captcha_flag) {
                    if (Configure::read('system.captcha_type') == "Solve Media") {
                        if (!$this->User->_isValidCaptchaSolveMedia()) {
                            $captcha_error = 1;
                        }
                    }
                }
                if (empty($captcha_error)) {
                    $this->User->UserProfile->set($this->request->data);
                    $this->User->set($this->request->data);
                    if ($this->User->validates()) {
                        $this->User->create();
                        if (!isset($this->request->data['User']['passwd']) && !isset($this->request->data['User']['twitter_user_id'])) {
                            $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['email'] . Configure::read('Security.salt'));
                            //For open id register no need for email confirm, this will override is_email_verification_for_register setting
                            $this->request->data['User']['is_agree_terms_conditions'] = 1;
                            $this->request->data['User']['is_email_confirmed'] = 1;
                        } elseif (!empty($this->request->data['User']['twitter_user_id'])) { // Twitter modified registration: password  -> twitter user id and salt //
                            $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['twitter_user_id'] . Configure::read('Security.salt'));
                            $this->request->data['User']['is_email_confirmed'] = 1;
                        } else {
                            $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['passwd']);
                            $this->request->data['User']['is_email_confirmed'] = (Configure::read('user.is_email_verification_for_register')) ? 0 : 1;
                        }
                        if (!Configure::read('User.signup_fee')) {
                            $this->request->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
                        }
                        $this->request->data['User']['role_id'] = ConstUserTypes::User;
                        if ($referred_by_user_id = $this->Cookie->read('referrer')) {
                            $this->request->data['User']['referred_by_user_id'] = $referred_by_user_id;
                        }
                        $this->request->data['User']['ip_id'] = $this->User->toSaveIp();
                        if (isPluginEnabled('LaunchModes')) {
                            if (Configure::read('site.launch_mode') == 'Private Beta' && isset($_SESSION['invite_hash'])) {
                                $Subscription = $this->Subscription->find('first', array(
                                    'fields' => array(
                                        'Subscription.id',
                                        'Subscription.site_state_id'
                                    ) ,
                                    'conditions' => array(
                                        'Subscription.invite_hash' => $_SESSION['invite_hash']
                                    )
                                ));
                                $this->request->data['User']['is_sent_private_beta_mail'] = 1;
                                if (!empty($Subscription)) {
                                    $this->request->data['User']['site_state_id'] = $Subscription['Subscription']['site_state_id'];
                                } else {
                                    $this->request->data['User']['site_state_id'] = ConstSiteState::PrivateBeta;
                                }
                            } else {
                                $Subscription = $this->Subscription->find('first', array(
                                    'fields' => array(
                                        'Subscription.id',
                                        'Subscription.site_state_id'
                                    ) ,
                                    'conditions' => array(
                                        'Subscription.email' => $this->request->data['User']['email']
                                    )
                                ));
                                if (!empty($Subscription)) {
                                    $this->request->data['User']['site_state_id'] = $Subscription['Subscription']['site_state_id'];;
                                } else {
                                    $this->request->data['User']['site_state_id'] = ConstSiteState::Launch;
                                }
                            }
                        } else {
                            $this->request->data['User']['site_state_id'] = ConstSiteState::Launch;
                        }
                        if ($this->User->save($this->request->data, false)) {
                            if ($referred_by_user_id = $this->Cookie->read('referrer')) {
                                $referredUser = $this->User->find('first', array(
                                    'conditions' => array(
                                        'User.id' => $referred_by_user_id
                                    ) ,
                                    'recursive' => -1
                                ));
                                $this->request->data['User']['referred_by_user_id'] = $referred_by_user_id;
                            }
                            if (isPluginEnabled('LaunchModes')) {
                                //Update the subscription table
                                if (!empty($Subscription)) {
                                    $this->request->data['Subscription']['user_id'] = $this->User->id;
                                    $this->request->data['Subscription']['id'] = $Subscription['Subscription']['id'];
                                    $this->Subscription->save($this->request->data);
                                }
                                unset($_SESSION['invite_hash']);
                            }
                            if (!empty($_SESSION['refer_id'])) {
                                $this->User->updateAll(array(
                                    'User.referred_by_user_count' => 'User.referred_by_user_count + ' . '1'
                                ) , array(
                                    'User.id' => $_SESSION['refer_id']
                                ));
                                unset($_SESSION['refer_id']);
                            }
                            $this->request->data['UserProfile']['user_id'] = $this->User->getLastInsertId();
                            $this->User->UserProfile->create();
                            $this->User->UserProfile->save($this->request->data['UserProfile'], false);
                            $_data['UserProfile'] = $this->request->data['UserProfile'];
                            $_data['UserProfile']['id'] = $this->User->UserProfile->getLastInsertId();
                            // send to admin mail if is_admin_mail_after_register is true
                            if (Configure::read('user.is_admin_mail_after_register')) {
                                $emailFindReplace = array(
                                    '##USERNAME##' => $this->request->data['User']['username'],
                                    '##SITE_NAME##' => Configure::read('site.name') ,
                                    '##SITE_URL##' => Router::url('/', true) ,
                                    '##USEREMAIL##' => $this->request->data['User']['email'],
                                    '##SIGNUPIP##' => $this->RequestHandler->getClientIP() ,
                                );
                                App::import('Model', 'EmailTemplate');
                                $this->EmailTemplate = new EmailTemplate();
                                $template = $this->EmailTemplate->selectTemplate('New User Join');
                                $this->User->_sendEmail($template, $emailFindReplace, Configure::read('site.admin_email'));
                            }
                            if (!empty($this->request->data['User']['openid_url'])) {
                                $this->request->data['UserOpenid']['openid'] = $this->request->data['User']['openid_url'];
                                $this->request->data['UserOpenid']['user_id'] = $this->User->id;
                                $this->User->UserOpenid->create();
                                $this->User->UserOpenid->save($this->request->data);
                            }
                            if (Configure::read('User.signup_fee')) {
                                $is_third_party_register = 0;
                                if (!empty($this->request->data['User']['is_openid_register']) || !empty($this->request->data['User']['is_linkedin_register']) || !empty($this->request->data['User']['is_google_register']) || !empty($this->request->data['User']['is_googleplus_register']) || !empty($this->request->data['User']['is_yahoo_register']) || !empty($this->request->data['User']['is_facebook_register']) || !empty($this->request->data['User']['is_twitter_register'])) {
                                    $is_third_party_register = 1;
                                    // send welcome mail to user if is_welcome_mail_after_register is true
                                    if (Configure::read('user.is_welcome_mail_after_register')) {
                                        $this->User->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                                    }
                                } else {
                                    $is_third_party_register = 0;
                                    if (Configure::read('user.is_email_verification_for_register')) {
                                        $this->User->_sendActivationMail($this->request->data['User']['email'], $this->User->id, $this->User->getActivateHash($this->User->id));
                                    }
                                }
                                if (Configure::read('user.is_email_verification_for_register')) {
                                    $this->_sendMembershipMail($this->User->id, $this->User->getActivateHash($this->User->id));
                                }
                                if (Configure::read('user.is_admin_activate_after_register') && Configure::read('user.is_email_verification_for_register') && empty($is_third_party_register)) {
                                    $this->Session->setFlash(__l(' You have successfully registered with our site you can login after email verification and administrator approval, but you can able to access all features after paying sign up fee.') , 'default', null, 'success');
                                } else if (Configure::read('user.is_admin_activate_after_register')) {
                                    $this->Session->setFlash(__l(' You have successfully registered with our site. You can login in site after administrator approval, but you can able to access all features after paying sign up fee.') , 'default', null, 'success');
                                } else if (Configure::read('user.is_email_verification_for_register') && empty($is_third_party_register)) {
                                    $this->Session->setFlash(__l(' You have successfully registered with our site you can login after email verification, but you can able to access all features after paying sign up fee.') , 'default', null, 'success');
                                } else {
                                    $this->Session->setFlash(__l(' You have successfully registered with our site you can login now, but you can able to access all features after paying sign up fee.') , 'default', null, 'success');
                                }
                                $this->redirect(array(
                                    'controller' => 'payments',
                                    'action' => 'user_pay_now',
                                    $this->User->id,
                                    $this->User->getActivateHash($this->User->id)
                                ));
                            } else {
                                $user = $this->User->find('first', array(
                                    'conditions' => array(
                                        'User.id' => $this->User->id
                                    ) ,
                                    'recursive' => -1
                                ));
                                if (!empty($this->request->data['User']['is_linkedin_register'])) {
                                    $label = 'LinkedIn';
                                } else if (!empty($this->request->data['User']['is_facebook_register'])) {
                                    $label = 'Facebook';
                                } else if (!empty($this->request->data['User']['is_twitter_register'])) {
                                    $label = 'Twitter';
                                } else if (!empty($this->request->data['User']['is_yahoo_register'])) {
                                    $label = 'Yahoo!';
                                } else if (!empty($this->request->data['User']['is_google_register'])) {
                                    $label = 'Gmail';
                                } else if (!empty($this->request->data['User']['is_googleplus_register'])) {
                                    $label = 'GooglePlus';
                                } else {
                                    $label = 'Direct';
                                }
                                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                                    '_trackEvent' => array(
                                        'category' => 'User',
                                        'action' => 'Registered',
                                        'label' => $label,
                                        'value' => '',
                                    ) ,
                                    '_setCustomVar' => array(
                                        'ud' => $user['User']['id'],
                                        'rud' => $user['User']['referred_by_user_id'],
                                    )
                                ));
                                if (!empty($user['User']['referred_by_user_id'])) {
                                    $referredUser = $this->User->find('first', array(
                                        'conditions' => array(
                                            'User.id' => $user['User']['referred_by_user_id']
                                        ) ,
                                        'recursive' => -1
                                    ));
                                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                                        '_trackEvent' => array(
                                            'category' => 'User',
                                            'action' => 'Referred',
                                            'label' => $referredUser['User']['username'],
                                            'value' => '',
                                        ) ,
                                        '_setCustomVar' => array(
                                            'ud' => $user['User']['id'],
                                            'rud' => $user['User']['referred_by_user_id'],
                                        )
                                    ));
                                }
                            }
                            if (Configure::read('user.is_admin_activate_after_register')) {
                                $this->Session->setFlash(__l('You have successfully registered with our site. after administrator approval you can login to site') , 'default', null, 'success');
                            } else {
                                $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                            }
                            if (!empty($this->request->data['User']['openid_user_id']) || !empty($this->request->data['User']['linkedin_user_id']) || !empty($this->request->data['User']['google_user_id']) || !empty($this->request->data['User']['googleplus_user_id']) || !empty($this->request->data['User']['facebook_user_id']) || !empty($this->request->data['User']['twitter_user_id']) || !empty($this->request->data['User']['yahoo_user_id'])) {
                                // send welcome mail to user if is_welcome_mail_after_register is true
                                if (Configure::read('user.is_welcome_mail_after_register')) {
                                    $this->User->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                                }
                                if ($this->Auth->login()) {
                                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                                }
                            } else {
                                //For openid register no need to send the activation mail, so this code placed in the else
                                if (Configure::read('user.is_email_verification_for_register')) {
                                    $this->Session->setFlash(__l('You have successfully registered with our site and your activation mail has been sent to your mail inbox.') , 'default', null, 'success');
                                    $this->User->_sendActivationMail($this->request->data['User']['email'], $this->User->id, $this->User->getActivateHash($this->User->id));
                                }
                            }
                            if (!$this->Auth->user('id')) {
                                // send welcome mail to user if is_welcome_mail_after_register is true
                                if (!Configure::read('user.is_email_verification_for_register') and !Configure::read('user.is_admin_activate_after_register') and Configure::read('user.is_welcome_mail_after_register')) {
                                    $this->User->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                                }
                                if (!Configure::read('user.is_email_verification_for_register') and Configure::read('user.is_auto_login_after_register')) {
                                    $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                                    if ($this->Auth->login()) {
                                        $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                                    }
                                }
                            }
                            if ($this->Auth->user('id')) {
                                $this->redirect(array(
                                    'controller' => 'jobs',
                                    'action' => 'index',
                                    'type' => 'home'
                                ));
                            } else {
                                $this->redirect(array(
                                    'controller' => 'users',
                                    'action' => 'login'
                                ));
                            }
                        }
                    } else {
                        if (!empty($this->request->data['User']['provider'])) {
                            if (!empty($this->request->data['User']['is_google_register'])) {
                                $flash_verfy = 'Gmail';
                            } elseif (!empty($this->request->data['User']['is_googleplus_register'])) {
                                $flash_verfy = 'GooglePlus';
                            } elseif (!empty($this->request->data['User']['is_yahoo_register'])) {
                                $flash_verfy = 'Yahoo!';
                            } else {
                                $flash_verfy = $this->request->data['User']['provider'];
                            }
                            $this->Session->setFlash($flash_verfy . ' ' . __l('verification is completed successfully. But you have to fill the following required fields to complete our registration process.') , 'default', null, 'success');
                        } else {
                            $this->Session->setFlash(__l('Your registration process is not completed. Please, try again.') , 'default', null, 'error');
                        }
                    }
                } else {
                    $this->Session->setFlash(__l('Please enter valid captcha') , 'default', null, 'error');
                }
            }
            unset($this->request->data['User']['passwd']);
            // When already logged user trying to access the registration page we are redirecting to site home page
            if ($this->Auth->user()) {
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'dashboard',
                    'admin' => false,
                ));
            }
            if (isPluginEnabled('SecurityQuestions')) {
                $this->loadModel('SecurityQuestions.SecurityQuestion');
                $securityQuestions = $this->SecurityQuestion->find('list', array(
                    'conditions' => array(
                        'SecurityQuestion.is_active' => 1
                    )
                ));
                $this->set(compact('securityQuestions'));
            }
            if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'social' && $is_register) {
                $this->render('social');
            }
        }
        if (!$is_register && empty($socialuser)) {
            $this->layout = 'subscription';
            $this->render('invite_page');
        }
        $this->request->data['User']['passwd'] = '';
    }
    function _sendWelcomeMail($user_id, $user_email, $username)
    {
        $emailFindReplace = array(
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##USERNAME##' => $username,
            '##CONTACT_MAIL##' => Configure::read('site.admin_email') ,
            '##SITE_URL##' => Router::url('/', true)
        );
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $email_template = $this->EmailTemplate->selectTemplate('Welcome Email');
        $this->User->_sendEmail($email_template, $emailFindReplace, $user_email);
    }
    function activation($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Activate your account');
        if (is_null($user_id) or is_null($hash)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.is_email_confirmed' => 0
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            $this->Session->setFlash(__l('Invalid activation request, please register again'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register'
            ));
        }
        if (!$this->User->isValidActivateHash($user_id, $hash)) {
            $hash = $this->User->getActivateHash($user_id);
            $this->Session->setFlash(__l('Invalid activation request'));
            $this->set('show_resend', 1);
            $resend_url = Router::url(array(
                'controller' => 'users',
                'action' => 'resend_activation',
                $user_id,
                $hash
            ) , true);
            $this->set('resend_url', $resend_url);
        } else {
            $this->request->data['User']['id'] = $user_id;
            $this->request->data['User']['is_email_confirmed'] = 1;
            // admin will activate the user condition check
            $this->request->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
            $this->User->save($this->request->data);
            // active is false means redirect to home page with message
            if (!$this->request->data['User']['is_active']) {
                $this->Session->setFlash(__l('You have successfully activated your account. But you can login after admin activate your account.') , 'default', null, 'success');
                $this->redirect('/');
            }
            // send welcome mail to user if is_welcome_mail_after_register is true
            if (Configure::read('user.is_welcome_mail_after_register')) {
                $this->_sendWelcomeMail($user['User']['id'], $user['User']['email'], $user['User']['username']);
            }
            // after the user activation check script check the auto login value. it is true then automatically logged in
            if (Configure::read('user.is_auto_login_after_register')) {
                $this->Session->setFlash(__l('You have successfully activated and logged in to your account.') , 'default', null, 'success');
                $this->request->data['User']['email'] = $user['User']['email'];
                $this->request->data['User']['username'] = $user['User']['username'];
                $this->request->data['User']['password'] = $user['User']['password'];
                if ($this->Auth->login()) {
                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                    $this->redirect(array(
                        'controller' => 'user_profiles',
                        'action' => 'edit'
                    ));
                }
            }
            // user is active but auto login is false then the user will redirect to login page with message
            $this->Session->setFlash(__l(sprintf('You have successfully activated your account. Now you can login with your %s.', Configure::read('user.using_to_login'))) , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }
    function resend_activation($user_id = null, $hash = null)
    {
        if (is_null($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $hash = $this->User->getActivateHash($user_id);
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        if ($this->User->_sendActivationMail($user['User']['email'], $user_id, $hash)) {
            if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                $this->Session->setFlash(__l('Activation mail has been resent.') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('A Mail for activating your account has been sent.') , 'default', null, 'success');
            }
        } else {
            $this->Session->setFlash(__l('Try some time later as mail could not be dispatched due to some error in the server') , 'default', null, 'error');
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'index',
                'admin' => true
            ));
        } else {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }
    public function login()
    {
        $socialuser = $this->Session->read('socialuser');
        if (!empty($socialuser)) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register',
                'admin' => false,
            ));
        }
        $this->pageTitle = __l('Login');
        if ($this->Auth->user()) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'dashboard',
                'admin' => false,
            ));
        }
        $config = array(
            'base_url' => Router::url('/', true) . 'socialauth/',
            'providers' => array(
                'Facebook' => array(
                    'enabled' => Configure::read('facebook.is_enabled_facebook_connect') ,
                    'keys' => array(
                        'id' => Configure::read('facebook.app_id') ,
                        'secret' => Configure::read('facebook.secrect_key')
                    ) ,
                    'scope' => 'email, user_about_me, user_birthday, user_hometown',
                ) ,
                'Twitter' => array(
                    'enabled' => Configure::read('twitter.is_enabled_twitter_connect') ,
                    'keys' => array(
                        'key' => Configure::read('twitter.consumer_key') ,
                        'secret' => Configure::read('twitter.consumer_secret')
                    ) ,
                ) ,
                'Google' => array(
                    'enabled' => Configure::read('google.is_enabled_google_connect') ,
                    'keys' => array(
                        'id' => Configure::read('google.consumer_key') ,
                        'secret' => Configure::read('google.consumer_secret')
                    ) ,
                ) ,
                'GooglePlus' => array(
                    'enabled' => Configure::read('googleplus.is_enabled_googleplus_connect') ,
                    'keys' => array(
                        'id' => Configure::read('googleplus.consumer_key') ,
                        'secret' => Configure::read('googleplus.consumer_secret')
                    ) ,
                ) ,
                'Yahoo' => array(
                    'enabled' => Configure::read('yahoo.is_enabled_yahoo_connect') ,
                    'keys' => array(
                        'key' => Configure::read('yahoo.consumer_key') ,
                        'secret' => Configure::read('yahoo.consumer_secret')
                    ) ,
                ) ,
                'Openid' => array(
                    'enabled' => Configure::read('openid.is_enabled_openid_connect') ,
                ) ,
                'Linkedin' => array(
                    'enabled' => Configure::read('linkedin.is_enabled_linkedin_connect') ,
                    'keys' => array(
                        'key' => Configure::read('linkedin.consumer_key') ,
                        'secret' => Configure::read('linkedin.consumer_secret')
                    ) ,
                ) ,
            )
        );
        if (!empty($this->request->params['named']['type'])) {
            $options = array();
            $social_type = $this->request->params['named']['type'];
            if ($social_type == 'openid') {
                $options = array(
                    'openid_identifier' => 'https://openid.stackexchange.com/'
                );
            }
            try {
                require_once (APP . DS . WEBROOT_DIR . DS . 'socialauth/Hybrid/Auth.php');
                $hybridauth = new Hybrid_Auth($config);
                if (!empty($this->request->params['named']['redirecting'])) {
                    $adapter = $hybridauth->authenticate(ucfirst($social_type) , $options);
                    $loggedin_contact = $social_profile = $adapter->getUserProfile();
                    $social_profile = (array)$social_profile;
                    $social_profile['username'] = $social_profile['displayName'];
                    if ($social_type != 'openid') {
                        $session_data = $this->Session->read('HA::STORE');
                        $stored_access_token = $session_data['hauth_session.' . $social_type . '.token.access_token'];
                        $temp_access_token = explode(":", $stored_access_token);
                        $temp_access_token = str_replace('"', "", $temp_access_token);
                        $temp_access_token = str_replace(';', "", $temp_access_token);
                        $access_token = $temp_access_token[2];
                    }
                    $social_profile['provider'] = ucfirst($social_type);
                    $social_profile['is_' . $social_type . '_register'] = 1;
                    $social_profile[$social_type . '_user_id'] = $social_profile['identifier'];
                    if ($social_type != 'openid') {
                        $social_profile[$social_type . '_access_token'] = $access_token;
                    }
                    $condition['User.' . $social_type . '_user_id'] = $social_profile['identifier'];
                    if ($social_type != 'openid') {
                        $condition['OR'] = array(
                            'User.is_' . $social_type . '_register' => 1,
                            'User.is_' . $social_type . '_connected' => 1
                        );
                    } else {
                        $condition['User.is_' . $social_type . '_register'] = 1;
                    }
                    $user = $this->User->find('first', array(
                        'conditions' => $condition,
                        'recursive' => -1
                    ));
                    $is_social = 0;
                    if (!empty($user)) {
                        $this->request->data['User']['username'] = $user['User']['username'];
                        $this->request->data['User']['password'] = $user['User']['password'];
                        $is_social = 1;
                    } else {
                        if (Configure::read('site.launch_mode') == 'Pre-launch' || (Configure::read('site.launch_mode') == 'Private Beta' && empty($_SESSION['invite_hash']))) {
                            if (Configure::read('site.launch_mode') == 'Pre-launch') {
                                $this->Session->setFlash(__l('Sorry!!. Cannot register into the site in pre-launch mode') , 'default', null, 'error');
                            } else {
                                $this->Session->setFlash(__l('Sorry!!. Cannot register into the site without invitation') , 'default', null, 'error');
                            }
                            $this->Session->delete('HA::CONFIG');
                            $this->Session->delete('HA::STORE');
                            $this->Session->delete('socialuser');
                            echo '<script>window.close();</script>';
                            exit;
                        }
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        $this->Session->write('socialuser', $social_profile);
                        echo '<script>window.close();</script>';
                        exit;
                    }
                } else {
                    $reditect = Router::url(array(
                        'controller' => 'users',
                        'action' => 'login',
                        'type' => $social_type,
                        'redirecting' => $social_type
                    ) , true);
                    $this->layout = 'redirection';
                    $this->pageTitle.= ' - ' . ucfirst($social_type);
                    $this->set('redirect_url', $reditect);
                    $this->set('authorize_name', ucfirst($social_type));
                    $this->render('authorize');
                }
            }
            catch(Exception $e) {
                $error = "";
                switch ($e->getCode()) {
                    case 6:
                        $error = __l("User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.");
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        break;

                    case 7:
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        $error = __l("User not connected to the provider.");
                        break;

                    default:
                        $error = __l("Authentication failed. The user has canceled the authentication or the provider refused the connection");
                        break;
                }
                $this->Session->setFlash($error, 'default', null, 'error');
                echo '<script>window.close();</script>';
                exit;
            }
        }
        if (!empty($this->request->data)) {
            $this->request->data['User'][Configure::read('user.using_to_login') ] = !empty($this->request->data['User'][Configure::read('user.using_to_login') ]) ? trim($this->request->data['User'][Configure::read('user.using_to_login') ]) : '';
            //Important: For login unique username or email check validation not necessary. Also in login method authentication done before validation.
            unset($this->User->validate[Configure::read('user.using_to_login') ]['rule3']);
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                if (empty($social_type)) {
                    if (!empty($this->request->data['User'][Configure::read('user.using_to_login') ])) {
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.' . Configure::read('user.using_to_login') => $this->request->data['User'][Configure::read('user.using_to_login') ]
                            ) ,
                            'recursive' => -1
                        ));
                        $this->request->data['User']['password'] = crypt($this->request->data['User']['passwd'], $user['User']['password']);
                    }
                }
                if ($this->Auth->login()) {
                    if ($this->RequestHandler->isAjax()) {
                        echo 'success';
                        exit;
                    }
                    if (!empty($social_type) && $social_type == 'twitter' && !empty($social_profile['photoURL'])) {
                        $_data = array();
                        $_data['User']['id'] = $user['User']['id'];
                        $_data['User']['twitter_avatar_url'] = $social_profile['photoURL'];
                        $this->User->save($_data);
                    }
                    if (isPluginEnabled('SocialMarketing') && !empty($social_type) && $social_type != 'openid') {
                        $this->loadModel('SocialMarketing.SocialMarketing');
                        $social_contacts = $adapter->getUserContacts();
                        array_push($social_contacts, $loggedin_contact);
                        $this->SocialMarketing->import_contacts($social_contacts, $social_type);
                    }
                    if (!empty($social_type)) {
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                    }
                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                    if ($this->Auth->user()) {
                        Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                            '_trackEvent' => array(
                                'category' => 'User',
                                'action' => 'Loggedin',
                                'label' => $this->Auth->user('username') ,
                                'value' => '',
                            ) ,
                            '_setCustomVar' => array(
                                'ud' => $this->Auth->user('id') ,
                                'rud' => $this->Auth->user('referred_by_user_id') ,
                            )
                        ));
                        if (!empty($this->request->data['User']['is_remember'])) {
                            $user = $this->User->find('first', array(
                                'conditions' => array(
                                    'User.id' => $this->Auth->user('id')
                                ) ,
                                'recursive' => -1
                            ));
                            $this->PersistentLogin->_persistent_login_create_cookie($user, $this->request->data);
                        }
                        if (!empty($is_social)) {
                            echo '<script>window.close();</script>';
                            exit;
                        }
                        if (!empty($this->request->data['User']['f'])) {
                            $this->redirect(Router::url('/', true) . $this->request->data['User']['f']);
                        } elseif ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'stats',
                                'admin' => true
                            ));
                        } else {
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'dashboard',
                                'admin' => false,
                            ));
                        }
                    }
                } else {
                    if (!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {
                        $this->Session->setFlash(sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login')) , 'default', null, 'error');
                    } else {
                        $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                    }
                    if (!empty($is_social)) {
                        echo '<script>window.close();</script>';
                        exit;
                    }
                }
            }
        }
        $this->request->data['User']['passwd'] = '';
    }
    public function logout()
    {
        if ($this->Auth->user('facebook_user_id')) {
            // Quick fix for facebook redirect loop issue.
            $this->Session->delete('fbuser');
            $this->Session->write('is_fab_session_cleared', 1);
        }
        $this->Session->delete('HA::CONFIG');
        $this->Session->delete('HA::STORE');
        $this->Session->delete('socialuser');
        $this->Auth->logout();
        $this->Cookie->delete('User');
        $this->Cookie->delete('user_language');
        $cookie_name = $this->PersistentLogin->_persistent_login_get_cookie_name();
        $cookie_val = $this->Cookie->read($cookie_name);
        if (!empty($cookie_val)) {
            list($uid, $series, $token) = explode(':', $cookie_val);
            $this->User->PersistentLogin->deleteAll(array(
                'PersistentLogin.user_id' => $uid,
                'PersistentLogin.series' => $series
            ));
        }
        if (!empty($_COOKIE['_gz'])) {
            setcookie('_gz', '', time() -3600, '/');
        }
        $this->Session->setFlash(__l('You are now logged out of the site.') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'login'
        ));
    }
    public function forgot_password()
    {
        $this->pageTitle = __l('Forgot Password');
        if ($this->Auth->user('id')) {
            $this->redirect('/');
        }
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            //Important: For forgot password unique email id check validation not necessary.
            unset($this->User->validate['email']['rule3']);
            $captcha_error = 0;
            if (!$this->RequestHandler->isAjax()) {
                if (Configure::read('user.is_enable_forgot_password_captcha') && Configure::read('system.captcha_type') == "Solve Media") {
                    if (!$this->User->_isValidCaptchaSolveMedia()) {
                        $captcha_error = 1;
                    }
                }
            }
            if (empty($captcha_error)) {
                if ($this->User->validates()) {
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.email' => $this->request->data['User']['email'],
                            'User.is_active' => 1
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($user['User']['email'])) {
                        if (!empty($user['User']['is_openid_register']) || !empty($user['User']['is_yahoo_register']) || !empty($user['User']['is_google_register']) || !empty($user['User']['is_googleplus_register']) || !empty($user['User']['is_facebook_register']) || !empty($user['User']['is_twitter_register'])) {
                            if (!empty($user['User']['is_yahoo_register'])) {
                                $site = __l('Yahoo!');
                            } elseif (!empty($user['User']['is_google_register'])) {
                                $site = __l('Gmail');
                            } elseif (!empty($user['User']['is_googleplus_register'])) {
                                $site = __l('GooglePlus');
                            } elseif (!empty($user['User']['is_openid_register'])) {
                                $site = __l('OpenID');
                            } elseif (!empty($user['User']['is_facebook_register'])) {
                                $site = __l('Facebook');
                            } elseif (!empty($user['User']['is_twitter_register'])) {
                                $site = __l('Twitter');
                            }
                            $emailFindReplace = array(
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SITE_URL##' => Router::url('/', true) ,
                                '##SUPPORT_EMAIL##' => Configure::read('site.admin_email') ,
                                '##OTHER_SITE##' => $site,
                                '##USERNAME##' => $user['User']['username'],
                            );
                            $email_template = "Failed Social User";
                        } else {
                            $user = $this->User->find('first', array(
                                'conditions' => array(
                                    'User.email' => $user['User']['email']
                                ) ,
                                'recursive' => -1
                            ));
                            $reset_token = $this->User->getResetPasswordHash($user['User']['id']);
                            $this->User->updateAll(array(
                                'User.pwd_reset_token' => '\'' . $reset_token . '\'',
                                'User.pwd_reset_requested_date' => '\'' . date("Y-m-d H:i:s", time()) . '\'',
                            ) , array(
                                'User.id' => $user['User']['id']
                            ));
                            echo Router::url(array(
                                'controller' => 'users',
                                'action' => 'reset',
                                $user['User']['id'],
                                $reset_token
                            ) , true);
                            $emailFindReplace = array(
                                '##USERNAME##' => $user['User']['username'],
                                '##FIRST_NAME##' => (isset($user['User']['first_name'])) ? $user['User']['first_name'] : '',
                                '##LAST_NAME##' => (isset($user['User']['last_name'])) ? $user['User']['last_name'] : '',
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SITE_URL##' => Router::url('/', true) ,
                                '##SUPPORT_EMAIL##' => Configure::read('site.admin_email') ,
                                '##RESET_URL##' => Router::url(array(
                                    'controller' => 'users',
                                    'action' => 'reset',
                                    $user['User']['id'],
                                    $reset_token
                                ) , true)
                            );
                            $email_template = 'Forgot Password';
                        }
                    } else {
                        $email_template = 'Failed Forgot Password';
                        $emailFindReplace = array(
                            '##SITE_NAME##' => Configure::read('site.name') ,
                            '##SITE_URL##' => Router::url('/', true) ,
                            '##SUPPORT_EMAIL##' => Configure::read('site.admin_email') ,
                            '##user_email##' => $this->request->data['User']['email']
                        );
                    }
                    App::import('Model', 'EmailTemplate');
                    $this->EmailTemplate = new EmailTemplate();
                    $template = $this->EmailTemplate->selectTemplate($email_template);
                    $this->User->_sendEmail($template, $emailFindReplace, $this->request->data['User']['email']);
                    $this->Session->setFlash(__l('We have sent an email to ' . $this->request->data['User']['email'] . ' with further instructions.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'login'
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Please enter valid captcha') , 'default', null, 'error');
            }
        }
    }
    public function reset($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Reset Password');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.is_active' => 1,
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'date(User.pwd_reset_requested_date) as request_date',
                'User.security_question_id',
                'User.security_answer',
                'User.pwd_reset_requested_date',
                'User.pwd_reset_token',
                'User.email',
            ) ,
            'recursive' => -1
        ));
        $expected_date_diff = strtotime('now') -strtotime($user['User']['pwd_reset_requested_date']);
        if (empty($user) || empty($user['User']['pwd_reset_token']) || ($expected_date_diff < 0)) {
            $this->Session->setFlash(__l('Invalid request'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
        if (isPluginEnabled('SecurityQuestions')) {
            $security_questions = $this->User->SecurityQuestion->find('first', array(
                'conditions' => array(
                    'SecurityQuestion.id' => $user['User']['security_question_id']
                )
            ));
        }
        $this->set('user_id', $user_id);
        $this->set('hash', $hash);
        if (!empty($this->request->data)) {
            if (isset($this->request->data['User']['security_answer']) && isPluginEnabled('SecurityQuestions')) {
                if (strcmp($this->request->data['User']['security_answer'], $user['User']['security_answer'])) {
                    $this->Session->setFlash(__l('Sorry incorrect answer. Please try again') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'reset',
                        $user_id,
                        $hash
                    ));
                }
            } else {
                if ($this->User->isValidResetPasswordHash($this->request->data['User']['user_id'], $this->request->data['User']['hash'], $user[0]['request_date'])) {
                    $this->User->set($this->request->data);
                    if ($this->User->validates()) {
                        $this->User->updateAll(array(
                            'User.password' => '\'' . getCryptHash($this->request->data['User']['passwd']) . '\'',
                            'User.pwd_reset_token' => '\'' . '' . '\'',
                        ) , array(
                            'User.id' => $this->request->data['User']['user_id']
                        ));
                        $emailFindReplace = array(
                            '##SITE_NAME##' => Configure::read('site.name') ,
                            '##SITE_URL##' => Router::url('/', true) ,
                            '##SUPPORT_EMAIL##' => Configure::read('site.admin_email') ,
                            '##USERNAME##' => $user['User']['username']
                        );
                        App::import('Model', 'EmailTemplate');
                        $this->EmailTemplate = new EmailTemplate();
                        $template = $this->EmailTemplate->selectTemplate('Password changed');
                        $this->User->_sendEmail($template, $emailFindReplace, $user['User']['email']);
                        $this->Session->setFlash(__l('Your password has been changed successfully, Please login now') , 'default', null, 'success');
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                    $this->request->data['User']['passwd'] = '';
                    $this->request->data['User']['confirm_password'] = '';
                } else {
                    $this->Session->setFlash(__l('Invalid change password request'));
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'login'
                    ));
                }
            }
        } else {
            if (is_null($user_id) or is_null($hash)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if (empty($user)) {
                $this->Session->setFlash(__l('User cannot be found in server or admin deactivated your account, please register again'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            }
            if (!$this->User->isValidResetPasswordHash($user_id, $hash, $user[0]['request_date'])) {
                $this->Session->setFlash(__l('Invalid request'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login'
                ));
            }
            $this->request->data['User']['user_id'] = $user_id;
            $this->request->data['User']['hash'] = $hash;
            if (isPluginEnabled('SecurityQuestions') && !empty($user['User']['security_question_id']) && !empty($user['User']['security_answer'])) {
                $this->set('security_questions', $security_questions);
                $this->render('check_security_question');
            }
        }
    }
    public function change_password($user_id = null)
    {
        $this->pageTitle = __l('Change Password');
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                if ($this->User->updateAll(array(
                    'User.password' => '\'' . getCryptHash($this->request->data['User']['passwd']) . '\'',
                ) , array(
                    'User.id' => $this->request->data['User']['user_id']
                ))) {
                    if ($this->Auth->user('role_id') != ConstUserTypes::Admin && Configure::read('user.is_logout_after_change_password')) {
                        $this->Auth->logout();
                        $this->Session->setFlash(__l('Your password has been changed successfully. Please login now') , 'default', null, 'success');
                        $this->redirect(array(
                            'action' => 'login'
                        ));
                    } elseif ($this->Auth->user('role_id') == ConstUserTypes::Admin && $this->Auth->user('id') != $this->request->data['User']['user_id']) {
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->request->data['User']['user_id']
                            ) ,
                            'fields' => array(
                                'User.username',
                                'User.email'
                            ) ,
                            'recursive' => -1
                        ));
                        $emailFindReplace = array(
                            '##PASSWORD##' => $this->request->data['User']['passwd'],
                            '##USERNAME##' => $user['User']['username'],
                        );
                        // Send e-mail to users
                        App::import('Model', 'EmailTemplate');
                        $this->EmailTemplate = new EmailTemplate();
                        $template = $this->EmailTemplate->selectTemplate('Admin Change Password');
                        $this->User->_sendEmail($template, $emailFindReplace, $user['User']['email']);
                    }
                    if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                        $this->Session->setFlash(__l('Password has been changed successfully') , 'default', null, 'success');
                    } else {
                        $this->Session->setFlash(__l('Your password has been changed successfully') , 'default', null, 'success');
                    }
                } else {
                    $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
            }
            unset($this->request->data['User']['old_password']);
            unset($this->request->data['User']['passwd']);
            unset($this->request->data['User']['confirm_password']);
            if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                $this->redirect(array(
                    'action' => 'index',
                    'admin' => true
                ));
            }
        } else {
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
        }
        $conditions = array(
            'User.is_twitter_register' => 0,
            'User.is_facebook_register' => 0,
            'User.is_openid_register' => 0,
            'User.is_yahoo_register' => 0,
            'User.is_google_register' => 0,
            'User.is_googleplus_register' => 0,
        );
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $users = $this->User->find('list', array(
                'conditions' => $conditions,
            ));
            $this->set(compact('users'));
        }
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
            $conditions['User.id'] = $this->Auth->user('id');
            $user = $this->User->find('first', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->request->data['User']['user_id'] = (!empty($this->request->data['User']['user_id'])) ? $this->request->data['User']['user_id'] : $user_id;
    }
    function refer()
    {
        $cookie_value = $this->Cookie->read('referrer');
        $user_refername = '';
        if (!empty($this->request->params['named']['r'])) {
            $user_refername = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['r']
                ) ,
                'recursive' => -1
            ));
            if (empty($user_refername)) {
                $this->Session->setFlash(__l('Referrer username does not exist.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            }
        }
        //cookie value should be empty or same user id should not be over written
        if (!empty($user_refername)) {
            $this->Cookie->delete('referrer');
            $referrer = $user_refername['User']['id'];
            if (isPluginEnabled('Affiliates')) {
                $this->Cookie->write('referrer', $referrer, false, sprintf('+%s hours', Configure::read('affiliate.referral_cookie_expire_time')));
            }
            $cookie_value = $this->Cookie->read('referrer');
        }
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'register'
        ));
    }
    function top_rated()
    {
        $conditions = array();
        $order = array();
        if (!empty($this->request->params['named']['type'])) {
            if ($this->request->params['named']['type'] == 'top_seller') {
                $order['User.actual_rating'] = 'desc';
                $conditions['User.actual_rating !='] = '0';
            }
            $users = $this->User->find('all', array(
                'conditions' => $conditions,
                'recursive' => -1,
                'order' => $order,
                'limit' => 5
            ));
            $this->set('users', $users);
        }
    }
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'role_id',
            'filter_id',
            'q',
        ));
        $this->pageTitle = __l('Users');
        // total approved users list
        $this->set('pending', $this->User->find('count', array(
            'conditions' => array(
                'User.is_active = ' => 0,
            ) ,
            'recursive' => -1
        )));
        // total approved users list
        $this->set('approved', $this->User->find('count', array(
            'conditions' => array(
                'User.is_active = ' => 1,
            ) ,
            'recursive' => -1
        )));
        // total openid users list
        $this->set('openid', $this->User->find('count', array(
            'conditions' => array(
                'User.is_openid_register = ' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        // total Gmail users list
        $this->set('gmail', $this->User->find('count', array(
            'conditions' => array(
                'User.is_google_register = ' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        // total Yahoo users list
        $this->set('yahoo', $this->User->find('count', array(
            'conditions' => array(
                'User.is_yahoo_register = ' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('facebook', $this->User->find('count', array(
            'conditions' => array(
                'User.is_facebook_register = ' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('twitter', $this->User->find('count', array(
            'conditions' => array(
                'User.is_twitter_register = ' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('notified_inactive_users', $this->User->find('first', array(
            'conditions' => array(
                'User.last_sent_inactive_mail !=' => NULL
            ) ,
            'fields' => array(
                'COUNT(User.last_sent_inactive_mail) as inactive_mail_count'
            ) ,
            'recursive' => -1
        )));
        $this->set('googleplus', $this->User->find('count', array(
            'conditions' => array(
                'User.is_googleplus_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('linkedin', $this->User->find('count', array(
            'conditions' => array(
                'User.is_linkedin_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('admin_count', $this->User->find('count', array(
            'conditions' => array(
                'User.role_id' => ConstUserTypes::Admin,
            ) ,
            'recursive' => -1
        )));
		if (isPluginEnabled('Affiliates')) {
			$this->set('affiliate_user_count', $this->User->find('count', array(
				'conditions' => array(
					'User.is_affiliate_user' => 1,
				) ,
				'recursive' => -1
			)));
		}
        $this->set('site_users', $this->User->find('count', array(
            'conditions' => array(
                'User.is_facebook_register =' => 0,
                'User.is_twitter_register =' => 0,
                'User.is_openid_register =' => 0,
                'User.is_yahoo_register =' => 0,
                'User.is_google_register =' => 0,
                'User.is_googleplus_register =' => 0,
                'User.is_linkedin_register' => 0,
                'User.role_id !=' => ConstUserTypes::Admin,
            ) ,
            'recursive' => -1
        )));
        if (isPluginEnabled('LaunchModes')) {
            $this->loadModel('LaunchModes.Subscription');
            // total pre-launch users list
            $this->set('prelaunch_users', $this->User->find('count', array(
                'conditions' => array(
                    'User.site_state_id' => ConstSiteState::Prelaunch
                ) ,
                'recursive' => -1
            )));
            // total privatebeta users list
            $this->set('privatebeta_users', $this->User->find('count', array(
                'conditions' => array(
                    'User.site_state_id' => ConstSiteState::PrivateBeta
                ) ,
                'recursive' => -1
            )));
            // total pre-launch subscribed users list
            $this->set('prelaunch_subscribed', $this->Subscription->find('count', array(
                'conditions' => array(
                    'Subscription.site_state_id = ' => ConstSiteState::Prelaunch
                )
            )));
            // total privatebeta subscribed users list
            $this->set('privatebeta_subscribed', $this->Subscription->find('count', array(
                'conditions' => array(
                    'Subscription.site_state_id = ' => ConstSiteState::PrivateBeta
                )
            )));
        }
        $conditions = array();
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['User']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['User.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - Registered today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['User.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Registered in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['User.created >= '] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Registered in this month');
        }
        if (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstUserTypes::Admin) {
            $conditions['User.role_id'] = ConstUserTypes::Admin;
            $this->pageTitle.= ' - ' . __l('Admin') . ' ';
        }
        if (!empty($this->request->data['User']['filter_id'])) {
            if ($this->request->data['User']['filter_id'] == ConstMoreAction::OpenID) {
                $conditions['User.is_openid_register'] = 1;
                $this->pageTitle.= __l(' - Registered through OpenID ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Gmail) {
                $conditions['User.is_google_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Gmail ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::GooglePlus) {
                $conditions['User.is_googleplus_register'] = 1;
                $this->pageTitle.= ' - ' . __l('Registered through GooglePlus');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Yahoo) {
                $conditions['User.is_yahoo_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Yahoo ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Active) {
                $conditions['User.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Twitter) {
                $conditions['User.is_twitter_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Twitter ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Facebook) {
                $conditions['User.is_facebook_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Facebook ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['User.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::NotifiedInactiveUsers) {
                $conditions['User.last_sent_inactive_mail !='] = NULL;
                $this->pageTitle.= __l(' - Notified Inactive Users ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Site) {
                $conditions['User.is_yahoo_register'] = 0;
                $conditions['User.is_google_register'] = 0;
                $conditions['User.is_googleplus_register'] = 0;
                $conditions['User.is_openid_register'] = 0;
                $conditions['User.is_facebook_register'] = 0;
                $conditions['User.is_twitter_register'] = 0;
                $conditions['User.is_linkedin_register'] = 0;
                $conditions['User.role_id !='] = ConstUserTypes::Admin;
                $this->pageTitle.= ' - ' . __l('Site');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::LinkedIn) {
                $conditions['User.is_linkedin_register'] = 1;
                $this->pageTitle.= ' - ' . __l('Registered through LinkedIn');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::AffiliateUser) {
                $conditions['User.is_affiliate_user'] = 1;
                $this->pageTitle.= ' - ' . __l('Affiliate Users');
            } else if (isPluginEnabled('LaunchModes') && $this->request->data['User']['filter_id'] == ConstMoreAction::Prelaunch) {
                $conditions['User.site_state_id'] = ConstSiteState::Prelaunch;
                $this->pageTitle.= ' - ' . __l('Pre-launch Users');
            } else if (isPluginEnabled('LaunchModes') && $this->request->data['User']['filter_id'] == ConstMoreAction::PrivateBeta) {
                $conditions['User.site_state_id'] = ConstSiteState::PrivateBeta;
                $this->pageTitle.= ' - ' . __l('Private Beta Users');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['User']['filter_id'];
        }
        if (!empty($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['User.email LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->request->data['User']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->params['named']['role_id'])) {
            $this->request->data['User']['role_id'] = $this->request->params['named']['role_id'];
            $conditions['User.role_id'] = $this->request->data['User']['role_id'];
        }
        $this->set('page_title', $this->pageTitle);
        $contain = array();
        if ($this->RequestHandler->ext == 'csv') {
            Configure::write('debug', 0);
            $this->set('user', $this);
            $this->set('conditions', $conditions);
            if (isset($this->request->data['User']['q'])) {
                $this->set('q', $this->request->data['User']['q']);
            }
            $this->set('contain', $contain);
        } else {
            $this->User->recursive = 0;
            $this->paginate = array(
                'conditions' => $conditions,
                'contain' => array(
                    'Role',
                    'UserProfile' => array(
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        )
                    ) ,
                    'UserAvatar',
                    'Ip' => array(
                        'fields' => array(
                            'Ip.id',
                            'Ip.ip',
                            'Ip.city_id',
                            'Ip.state_id',
                            'Ip.country_id',
                        ) ,
                        'City' => array(
                            'fields' => array(
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        ) ,
                    ) ,
                    'ReferredByUser' => array(
                        'fields' => array(
                            'ReferredByUser.id',
                            'ReferredByUser.username'
                        )
                    ) ,
                ) ,
                'limit' => 15,
                'order' => array(
                    'User.id' => 'desc'
                ) ,
                'recursive' => 2
            );
            $this->set('users', $this->paginate());
            $filters = $this->User->isFilterOptions;
            $moreActions = $this->User->moreActions;
            $roles = $this->User->Role->find('list', array(
                'recursive' => -1
            ));
            $this->request->data['User']['role_id'] = !empty($this->request->params['named']['role_id']) ? $this->request->params['named']['role_id'] : '';
            $this->set('filters', $filters);
            $this->set('moreActions', $moreActions);
            $this->set('roles', $roles);
        }
    }
    function admin_connnected_payment_gateways($userid)
    {
        $this->pageTitle = __l('Connected Payment Gateways');
        App::import('Model', 'Sudopay.Sudopay');
        $this->Sudopay = new Sudopay();
        App::import('Model', 'Sudopay.SudopayPaymentGateway');
        $this->SudopayPaymentGateway = new SudopayPaymentGateway();
        $connected_gateways = $this->Sudopay->GetUserConnectedGateways($userid);
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $userid,
            ) ,
            'fields' => array(
                'User.username'
            ) ,
            'recursive' => -1
        ));
        $sudopayPaymentGateways = '';
        foreach($connected_gateways as $connected_gateway) {
            $sudopayPaymentGateways[] = $this->SudopayPaymentGateway->find('first', array(
                'conditions' => array(
                    'SudopayPaymentGateway.sudopay_gateway_id' => $connected_gateway
                ) ,
                'recursive' => -1
            ));
        }
        $this->set('sudopayPaymentGateways', $sudopayPaymentGateways);
        $this->set('user', $user);
    }
    function sales_revenues()
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.sales_cleared_amount',
                'User.sales_pipeline_amount',
                'User.sales_lost_amount',
            ) ,
            'recursive' => -1
        ));
        $this->set('user', $user);
    }
    function dashboard()
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'contain' => array(
                'Job',
                'JobOrder',
                'UserAvatar'
            ) ,
            'recursive' => 1
        ));
        $this->pageTitle = __l('Dashboard');
        $purchase_conditions['JobOrder.user_id'] = $this->Auth->user('id');
        $purchase_conditions['NOT']['JobOrder.job_order_status_id'] = array(
            ConstJobOrderStatus::Cancelled,
            ConstJobOrderStatus::Rejected,
            ConstJobOrderStatus::Expired,
            ConstJobOrderStatus::CancelledDueToOvertime,
            ConstJobOrderStatus::CancelledByAdmin,
        );
        $total_purchased = $this->User->JobOrder->find('first', array(
            'conditions' => $purchase_conditions,
            'fields' => array(
                'SUM(JobOrder.amount) as total_amount'
            ) ,
            'recursive' => -1
        ));
        $this->set('user', $user);
        $this->set('total_purchased', $total_purchased);
        // Buyer Orders //
        $filter_count = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $all_count = ($filter_count['User']['buyer_waiting_for_acceptance_count']+$filter_count['User']['buyer_in_progress_count']+$filter_count['User']['buyer_in_progress_overtime_count']+$filter_count['User']['buyer_review_count']+$filter_count['User']['buyer_completed_count']+$filter_count['User']['buyer_cancelled_count']+$filter_count['User']['buyer_rejected_count']+$filter_count['User']['buyer_cancelled_late_order_count']+$filter_count['User']['buyer_expired_count']+$filter_count['User']['buyer_payment_pending_count']);
        $this->set('all_count', $all_count);
        $status = array(
            __l('Active') => array(
                'active',
                ($filter_count['User']['buyer_in_progress_count']+$filter_count['User']['buyer_in_progress_overtime_count']+$filter_count['User']['buyer_review_count'])
            ) ,
            __l('Payment Pending') => array(
                'payment_pending',
                $filter_count['User']['buyer_payment_pending_count']
            ) ,
            __l('Pending Seller Accept') => array(
                'waiting_for_acceptance',
                $filter_count['User']['buyer_waiting_for_acceptance_count']
            ) ,
            __l('In Progress') => array(
                'in_progress',
                $filter_count['User']['buyer_in_progress_count']
            ) ,
            __l('In Progress Overtime') => array(
                'in_progress_overtime',
                $filter_count['User']['buyer_in_progress_overtime_count']
            ) ,
            __l('Waiting For Your Review') => array(
                'waiting_for_review',
                $filter_count['User']['buyer_review_count']
            ) ,
            __l('Completed') => array(
                'completed',
                $filter_count['User']['buyer_completed_count']
            ) ,
            __l('Cancelled') => array(
                'cancelled',
                $filter_count['User']['buyer_cancelled_count']
            ) ,
            __l('Seller Rejected') => array(
                'rejected',
                $filter_count['User']['buyer_rejected_count']
            ) ,
            __l('Cancelled Late Orders') => array(
                'cancelled_late_orders',
                $filter_count['User']['buyer_cancelled_late_order_count']
            ) ,
            __l('Expired') . ' ' . jobAlternateName(ConstJobAlternateName::Plural) => array(
                'expired',
                $filter_count['User']['buyer_expired_count']
            ) ,
            __l('Rework') . ' ' . jobAlternateName(ConstJobAlternateName::Plural) => array(
                'rework',
                $filter_count['User']['buyer_redeliver_count']
            ) ,
        );
        $this->set('moreActions', $status);
    }
    function selling_panel()
    {
        $user_id = $this->request->params['named']['user_id'];
        if (!empty($user_id)) {
            $periods = array(
                'day' => array(
                    'display' => __l('Today') ,
                    'conditions' => array(
                        'created >=' => date('Y-m-d', strtotime('now')) . ' 00:00:00',
                    )
                ) ,
                'week' => array(
                    'display' => __l('This week') ,
                    'conditions' => array(
                        'created >=' => date('Y-m-d', strtotime('now -7 days')) ,
                    )
                ) ,
                'month' => array(
                    'display' => __l('This month') ,
                    'conditions' => array(
                        'created >=' => date('Y-m-d', strtotime('now -30 days')) ,
                    )
                ) ,
                'total' => array(
                    'display' => __l('Total') ,
                    'conditions' => array()
                )
            );
            $models[] = array(
                'JobOrder' => array(
                    'display' => __l('Cleared') ,
                    'isNeedLoop' => false,
                    'alias' => 'JobOders',
                    'colspan' => 1
                )
            );
            $models[] = array(
                'JobOrders' => array(
                    'display' => '',
                    'conditions' => array(
                        'JobOrder.owner_user_id' => $user_id,
                        'JobOrder.job_order_status_id' => array(
                            ConstJobOrderStatus::PaymentCleared,
                        )
                    ) ,
                    'alias' => 'ClearedRevenueAmountRecieved',
                    'type' => 'cInt',
                    'isSub' => 'JobOders',
                    'class' => 'highlight-cleared'
                )
            );
            $models[] = array(
                'JobOrder' => array(
                    'display' => __l('Pipeline') ,
                    'isNeedLoop' => false,
                    'alias' => 'JobOders',
                    'colspan' => 1
                )
            );
            $models[] = array(
                'JobOrders' => array(
                    'display' => '',
                    'conditions' => array(
                        'JobOrder.owner_user_id' => $user_id,
                        'JobOrder.job_order_status_id' => array(
                            ConstJobOrderStatus::WaitingforAcceptance,
                            ConstJobOrderStatus::InProgress,
                            ConstJobOrderStatus::InProgressOvertime,
                            ConstJobOrderStatus::WaitingforReview,
                            ConstJobOrderStatus::Completed,
                            ConstJobOrderStatus::CompletedAndClosedByAdmin,
                        )
                    ) ,
                    'alias' => 'PipelineRevenueAmountRecieved',
                    'type' => 'cInt',
                    'isSub' => 'JobOders',
                    'class' => 'highlight-pipeline'
                )
            );
            $models[] = array(
                'JobOrder' => array(
                    'display' => __l('Lost') ,
                    'isNeedLoop' => false,
                    'alias' => 'JobOders',
                    'colspan' => 1
                )
            );
            $models[] = array(
                'JobOrders' => array(
                    'display' => '',
                    'conditions' => array(
                        'JobOrder.owner_user_id' => $user_id,
                        'JobOrder.job_order_status_id' => array(
                            ConstJobOrderStatus::Cancelled,
                            ConstJobOrderStatus::Rejected,
                            ConstJobOrderStatus::Expired,
                            ConstJobOrderStatus::CancelledDueToOvertime,
                            ConstJobOrderStatus::CancelledByAdmin,
                        )
                    ) ,
                    'alias' => 'LostRevenueAmountRecieved',
                    'type' => 'cInt',
                    'isSub' => 'JobOders',
                    'class' => 'highlight-lost'
                )
            );
            foreach($models as $unique_model) {
                foreach($unique_model as $model => $fields) {
                    foreach($periods as $key => $period) {
                        $conditions = $period['conditions'];
                        if (!empty($fields['conditions'])) {
                            $conditions = array_merge($periods[$key]['conditions'], $fields['conditions']);
                        }
                        $aliasName = !empty($fields['alias']) ? $fields['alias'] : $model;
                        if ($model == 'JobOrders') {
                            $RevenueRecieved = $this->User->JobOrder->find('first', array(
                                'conditions' => $conditions,
                                'fields' => array(
                                    'COUNT(JobOrder.id) as total_count'
                                ) ,
                                'recursive' => -1
                            ));
                            $this->set($aliasName . $key, $RevenueRecieved['0']['total_count']);
                        }
                    }
                }
            }
        }
        $this->set(compact('periods', 'models'));
    }
    function selling_panel_chart()
    {
        $user_id = $this->request->params['named']['user_id'];
        if (!empty($user_id)) {
            $periods = array(
                'day' => array(
                    'display' => __l('Today') ,
                    'conditions' => array(
                        'created >=' => date('Y-m-d', strtotime('now')) . ' 00:00:00',
                    )
                ) ,
                'week' => array(
                    'display' => __l('This week') ,
                    'conditions' => array(
                        'created >=' => date('Y-m-d', strtotime('now -7 days')) ,
                    )
                ) ,
                'month' => array(
                    'display' => __l('This month') ,
                    'conditions' => array(
                        'created >=' => date('Y-m-d', strtotime('now -30 days')) ,
                    )
                ) ,
                'year' => array(
                    'display' => __l('This year') ,
                    'conditions' => array(
                        'created >=' => date('Y-m-d', strtotime('now -365 days')) ,
                    )
                ) ,
            );
            $modelFields = array(
                __l('Cleared') ,
                __l('Pipeline') ,
                __l('Lost')
            );
            $models[] = array(
                'JobOrders' => array(
                    'display' => '',
                    'conditions' => array(
                        'JobOrder.owner_user_id' => $user_id,
                        'JobOrder.job_order_status_id' => array(
                            ConstJobOrderStatus::PaymentCleared,
                        )
                    ) ,
                    'alias' => 'ClearedRevenueAmountRecieved',
                    'isSub' => 'JobOders'
                )
            );
            $models[] = array(
                'JobOrders' => array(
                    'display' => '',
                    'conditions' => array(
                        'JobOrder.owner_user_id' => $user_id,
                        'JobOrder.job_order_status_id' => array(
                            ConstJobOrderStatus::WaitingforAcceptance,
                            ConstJobOrderStatus::InProgress,
                            ConstJobOrderStatus::InProgressOvertime,
                            ConstJobOrderStatus::WaitingforReview,
                            ConstJobOrderStatus::Completed,
                            ConstJobOrderStatus::CompletedAndClosedByAdmin,
                        )
                    ) ,
                    'alias' => 'PipelineRevenueAmountRecieved',
                    'isSub' => 'JobOders'
                )
            );
            $models[] = array(
                'JobOrders' => array(
                    'display' => '',
                    'conditions' => array(
                        'JobOrder.owner_user_id' => $user_id,
                        'JobOrder.job_order_status_id' => array(
                            ConstJobOrderStatus::Cancelled,
                            ConstJobOrderStatus::Rejected,
                            ConstJobOrderStatus::Expired,
                            ConstJobOrderStatus::CancelledDueToOvertime,
                            ConstJobOrderStatus::CancelledByAdmin,
                        )
                    ) ,
                    'alias' => 'LostRevenueAmountRecieved',
                    'isSub' => 'JobOders'
                )
            );
            foreach($models as $unique_model) {
                foreach($unique_model as $model => $fields) {
                    foreach($periods as $key => $period) {
                        $conditions = $period['conditions'];
                        if (!empty($fields['conditions'])) {
                            $conditions = array_merge($periods[$key]['conditions'], $fields['conditions']);
                        }
                        $aliasName = !empty($fields['alias']) ? $fields['alias'] : $model;
                        if ($model == 'JobOrders') {
                            $RevenueRecieved = $this->User->JobOrder->find('first', array(
                                'conditions' => $conditions,
                                'fields' => array(
                                    'COUNT(JobOrder.id) as total_count'
                                ) ,
                                'recursive' => -1
                            ));
                            $this->set($aliasName . $key, $RevenueRecieved['0']['total_count']);
                        }
                    }
                }
            }
        }
        $this->set(compact('periods', 'models', 'modelFields'));
    }
    function admin_export_filtered($hash = null)
    {
        $conditions = array();
        if (!empty($hash) && isset($_SESSION['user_export'][$hash])) {
            $ids = implode(',', $_SESSION['user_export'][$hash]);
            if ($this->User->isValidIdHash($ids, $hash)) {
                $conditions['User.id'] = $_SESSION['user_export'][$hash];
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'UserProfile',
                'ReferredByUser',
            )
        ));
        Configure::write('debug', 0);
        if (!empty($users)) {
            foreach($users as $user) {
                $data[]['User'] = array(
                    'Username' => $user['User']['username'],
                    'Email' => $user['User']['email'],
                    'Referred by' => (!empty($user['ReferredByUser']['username'])) ? $user['ReferredByUser']['username'] : '',
                    'Active' => ($user['User']['is_active']) ? __l('Active') : __l('Inactive') ,
                    'Email confirmed' => ($user['User']['is_email_confirmed']) ? __l('Yes') : __l('No') ,
                    'OpenID count' => $user['User']['user_openid_count'],
                    'Login count' => $user['User']['user_login_count'],
                    'View count' => $user['User']['user_view_count'],
                    'Reffered count' => $user['User']['user_referred_count'],
                    'Facebook user id' => $user['User']['fb_user_id'],
                    'twitter user id' => $user['User']['twitter_user_id'],
                    'Signup IP' => $user['User']['signup_ip'],
                    'Created' => $user['User']['created'],
                );
            }
        }
        $this->set('data', $data);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add New User/Admin');
        if (!empty($this->request->data)) {
            $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['passwd']);
            $this->request->data['User']['is_agree_terms_conditions'] = '1';
            $this->request->data['User']['is_email_confirmed'] = 1;
            $this->request->data['User']['is_active'] = 1;
            $this->request->data['User']['ip_id'] = $this->User->toSaveIP();
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                // Send mail to user to activate the account and send account details
                $emailFindReplace = array(
                    '##USERNAME##' => $this->request->data['User']['username'],
                    '##LOGINLABEL##' => ucfirst(Configure::read('user.using_to_login')) ,
                    '##USEDTOLOGIN##' => $this->request->data['User'][Configure::read('user.using_to_login') ],
                    '##SITE_NAME##' => Configure::read('site.name') ,
                    '##SITE_URL##' => Router::url('/', true) ,
                    '##PASSWORD##' => $this->request->data['User']['passwd']
                );
                App::import('Model', 'EmailTemplate');
                $this->EmailTemplate = new EmailTemplate();
                $email_template = $this->EmailTemplate->selectTemplate('Admin User Add');
                $this->User->_sendEmail($email_template, $emailFindReplace, $this->request->data['User']['email']);
                $this->Session->setFlash(__l('User has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                unset($this->request->data['User']['passwd']);
                $this->Session->setFlash(__l('User could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $userTypes = $this->User->Role->find('list');
        $this->set(compact('userTypes'));
        if (!isset($this->request->data['User']['role_id'])) {
            $this->request->data['User']['role_id'] = ConstUserTypes::User;
        }
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->_sendAdminActionMail($id, 'Admin User Delete');
        if ($this->User->delete($id)) {
            $this->Session->setFlash(__l('User has been deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function admin_update()
    {
        if (!empty($this->request->data['User'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $userIds = array();
            foreach($this->request->data['User'] as $user_id => $is_checked) {
                if ($is_checked['id']) {
                    $userIds[] = $user_id;
                }
            }
            if ($actionid && !empty($userIds)) {
                if ($actionid == ConstMoreAction::Inactive) {
                    $this->User->updateAll(array(
                        'User.is_active' => 0
                    ) , array(
                        'User.id' => $userIds
                    ));
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Deactivate');
                    }
                    $this->Session->setFlash(__l('Checked users has been inactivated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Active) {
                    $this->User->updateAll(array(
                        'User.is_active' => 1
                    ) , array(
                        'User.id' => $userIds
                    ));
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Active');
                    }
                    $this->Session->setFlash(__l('Checked users has been activated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Delete) {
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Delete');
                    }
                    $this->User->deleteAll(array(
                        'User.id' => $userIds
                    ));
                    $this->Session->setFlash(__l('Checked users has been deleted') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Export) {
                    $user_ids = implode(',', $userIds);
                    $hash = $this->User->getUserIdHash($user_ids);
                    $_SESSION['user_export'][$hash] = $userIds;
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'export',
                        'ext' => 'csv',
                        $hash,
                        'admin' => true
                    ));
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    function _sendAdminActionMail($user_id, $email_template)
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'contain' => array(
                'UserProfile'
            ) ,
            'recursive' => 1
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
    function admin_dashboard($refresh = '')
    {
        $this->pageTitle = __l('Dashboard');
        if (!empty($refresh) && $refresh = 'refresh') {
            $admin_stats_cache = APP . '/tmp/cache/views/element_0_admin_stats_dashboard';
            if (file_exists($admin_stats_cache)) {
                unlink($admin_stats_cache);
            }
        }
    }
    function admin_stats()
    {
        $this->pageTitle = __l('Site Stats');
        /*
        if (isPluginEnabled('Jobs')) {
        $models[] = array(
        'RevenueRecieved' => array(
        'display' => __l('Sales') ,
        'link' => array(
        'controller' => 'job_orders',
        'action' => 'index',
        'type' => 'cleared',
        'admin' => 'true'
        ) ,
        'conditions' => array(
        'JobOrder.job_order_status_id' => array(
        ConstJobOrderStatus::PaymentCleared,
        )
        ) ,
        'alias' => 'ClearedRevenueAmountRecieved',
        'type' => 'cCurrency',
        'isSub' => 'Revenue'
        )
        );
        $models[] = array(
        'RevenueCommission' => array(
        'display' => __l('Revenue/Commission earned') ,
        'link' => array(
        'controller' => 'job_orders',
        'action' => 'index',
        'type' => 'cleared',
        'admin' => 'true'
        ) ,
        'conditions' => array(
        'JobOrder.job_order_status_id' => array(
        ConstJobOrderStatus::PaymentCleared,
        )
        ) ,
        'alias' => 'ClearedRevenueCommissionAmount',
        'type' => 'cCurrency',
        'isSub' => 'Revenue',
        'class' => 'stats-highlights'
        )
        );
        $models[] = array(
        'RevenueRecieved' => array(
        'display' => __l('Sales') ,
        'link' => array(
        'controller' => 'job_orders',
        'action' => 'index',
        'type' => 'pipeline',
        'admin' => 'true'
        ) ,
        'conditions' => array(
        'JobOrder.job_order_status_id' => array(
        ConstJobOrderStatus::WaitingforAcceptance,
        ConstJobOrderStatus::InProgress,
        ConstJobOrderStatus::InProgressOvertime,
        ConstJobOrderStatus::WaitingforReview,
        ConstJobOrderStatus::Completed,
        ConstJobOrderStatus::CompletedAndClosedByAdmin,
        )
        ) ,
        'alias' => 'PipelineRevenueAmountRecieved',
        'type' => 'cCurrency',
        'isSub' => 'Revenue'
        )
        );
        $models[] = array(
        'RevenueCommission' => array(
        'display' => __l('Revenue/Commission') ,
        'link' => array(
        'controller' => 'job_orders',
        'action' => 'index',
        'type' => 'pipeline',
        'admin' => 'true'
        ) ,
        'conditions' => array(
        'JobOrder.job_order_status_id' => array(
        ConstJobOrderStatus::WaitingforAcceptance,
        ConstJobOrderStatus::InProgress,
        ConstJobOrderStatus::InProgressOvertime,
        ConstJobOrderStatus::WaitingforReview,
        ConstJobOrderStatus::Completed,
        ConstJobOrderStatus::CompletedAndClosedByAdmin,
        )
        ) ,
        'alias' => 'PipelineRevenueCommissionAmount',
        'type' => 'cCurrency',
        'isSub' => 'Revenue',
        'class' => 'highlight-pipeline'
        )
        );
        $models[] = array(
        'RevenueRecieved' => array(
        'display' => __l('Sales') ,
        'link' => array(
        'controller' => 'job_orders',
        'action' => 'index',
        'type' => 'lost',
        'admin' => 'true'
        ) ,
        'conditions' => array(
        'JobOrder.job_order_status_id' => array(
        ConstJobOrderStatus::Cancelled,
        ConstJobOrderStatus::Rejected,
        ConstJobOrderStatus::Expired,
        ConstJobOrderStatus::CancelledDueToOvertime,
        ConstJobOrderStatus::CancelledByAdmin,
        )
        ) ,
        'alias' => 'LostRevenueAmountRecieved',
        'type' => 'cCurrency',
        'isSub' => 'Revenue'
        )
        );
        $models[] = array(
        'RevenueCommission' => array(
        'display' => __l('Revenue/Commission') ,
        'link' => array(
        'controller' => 'job_orders',
        'action' => 'index',
        'type' => 'lost',
        'admin' => 'true'
        ) ,
        'conditions' => array(
        'JobOrder.job_order_status_id' => array(
        ConstJobOrderStatus::Cancelled,
        ConstJobOrderStatus::Rejected,
        ConstJobOrderStatus::Expired,
        ConstJobOrderStatus::CancelledDueToOvertime,
        ConstJobOrderStatus::CancelledByAdmin,
        )
        ) ,
        'alias' => 'LostRevenueCommissionAmount',
        'type' => 'cCurrency',
        'isSub' => 'Revenue',
        'class' => 'highlight-lost'
        )
        );
        */
    }
    public function admin_recent_users()
    {
        $recentUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'User.role_id != ' => ConstUserTypes::Admin
            ) ,
            'fields' => array(
                'User.username',
            ) ,
            'recursive' => -1,
            'limit' => 10,
            'order' => array(
                'User.id' => 'desc'
            )
        ));
        $this->set(compact('recentUsers'));
    }
    function admin_logs()
    {
        // Cache file read
        $error_log_path = APP . '/tmp/logs/error.log';
        $error_log = $debug_log = '';
        if (file_exists($error_log_path)) {
            $handle = fopen($error_log_path, "r");
            fseek($handle, -10240, SEEK_END);
            $error_log = fread($handle, 10240);
            fclose($handle);
        }
        $debug_log_path = APP . '/tmp/logs/debug.log';
        if (file_exists($debug_log_path)) {
            $handle = fopen($debug_log_path, "r");
            fseek($handle, -10240, SEEK_END);
            $debug_log = fread($handle, 10240);
            fclose($handle);
        }
        $this->set('error_log', $error_log);
        $this->set('debug_log', $debug_log);
        $this->set('tmpCacheFileSize', bytes_to_higher(dskspace(TMP . 'cache')));
        $this->set('tmpLogsFileSize', bytes_to_higher(dskspace(TMP . 'logs')));
    }
    function admin_change_password($user_id = null)
    {
        $this->setAction('change_password', $user_id);
    }
    function admin_send_mail()
    {
        $this->pageTitle = __l('Email to users');
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                $conditions = $emails = array();
                $notSendCount = $sendCount = 0;
                if (!empty($this->request->data['User']['send_to'])) {
                    $sendTo = explode(',', $this->request->data['User']['send_to']);
                    foreach($sendTo as $email) {
                        $email = trim($email);
                        if (!empty($email)) {
                            if ($this->User->find('count', array(
                                'conditions' => array(
                                    'User.email' => $email
                                )
                            ))) {
                                $emails[] = $email;
                                $sendCount++;
                            } else {
                                $notSendCount++;
                            }
                        }
                    }
                }
                if (!empty($this->request->data['User']['bulk_mail_option_id'])) {
                    if ($this->request->data['User']['bulk_mail_option_id'] == 2) {
                        $conditions['User.is_active'] = 0;
                    }
                    if ($this->request->data['User']['bulk_mail_option_id'] == 3) {
                        $conditions['User.is_active'] = 1;
                    }
                    $users = $this->User->find('all', array(
                        'conditions' => $conditions,
                        'fields' => array(
                            'User.email'
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($users)) {
                        $sendCount++;
                        foreach($users as $user) {
                            $emails[] = $user['User']['email'];
                        }
                    }
                }
                $this->request->data['User']['message'].= "\n\n";
                $this->request->data['User']['message'].= Configure::read('site.name') . "\n";
                $this->request->data['User']['message'].= Router::url('/', true);
                $content['text'] = $this->request->data['User']['message'];
                if (!empty($emails)) {
                    App::uses('CakeEmail', 'Network/Email');
                    $this->Email = new CakeEmail();
                    foreach($emails as $email) {
                        if (!empty($email)) {
                            $from_email = Configure::read('site.from_email');
                            $this->Email->from($from_email, Configure::read('site.name'));
                            $this->Email->replyTo = Configure::read('site.reply_to_email');
                            $this->Email->to(trim($email));
                            $this->Email->subject($this->request->data['User']['subject']);
                            $this->Email->emailFormat('text');
                            $this->Email->send($content);
                        }
                    }
                }
                if ($sendCount && !$notSendCount) {
                    $this->Session->setFlash(__l('Email sent successfully') , 'default', null, 'success');
                    if (!empty($this->request->data['Contact']['id'])) {
                        $this->User->Contact->updateAll(array(
                            'Contact.is_replied' => 1
                        ) , array(
                            'Contact.id' => $this->request->data['Contact']['id']
                        ));
                        $this->redirect(array(
                            'controller' => 'contacts',
                            'action' => 'index'
                        ));
                    }
                } elseif ($sendCount && $notSendCount) {
                    $this->Session->setFlash(__l('Email sent successfully. Some emails are not sent') , 'default', null, 'success');
                } else {
                    $this->Session->setFlash(__l('No email send') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Email couldn\'t be sent! Enter all required fields') , 'default', null, 'error');
                if (!empty($this->request->data['Contact']['id'])) {
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'send_mail',
                        'contact' => $this->request->data['Contact']['id']
                    ));
                }
            }
        }
        // Just to do the admin conatact us repay mangement
        if (!empty($this->request->params['named']['contact'])) {
            $contact_deatil = $this->User->Contact->find('first', array(
                'conditions' => array(
                    'Contact.id' => $this->request->params['named']['contact'],
                ) ,
                'contain' => array(
                    'ContactType'
                ) ,
                'recursive' => 0
            ));
            if (!empty($contact_deatil['Contact']['subject'])) {
                $subject = $contact_deatil['Contact']['subject'];
            } else {
                $subject = $contact_deatil['ContactType']['name'];
            }
            $this->pageTitle = __l('Contact us - Reply');
            $this->request->data['Contact']['id'] = $this->request->params['named']['contact'];
            $this->request->data['User']['subject'] = __l('Re:') . $subject;
            $this->request->data['User']['message'] = "\n\n\n";
            $this->request->data['User']['message'].= '------------------------------';
            $this->request->data['User']['message'].= "\n" . $contact_deatil['Contact']['message'];
            $this->request->data['User']['send_to'] = $contact_deatil['Contact']['email'];
        }
        $bulkMailOptions = $this->User->bulkMailOptions;
        $this->set(compact('bulkMailOptions'));
    }
    function admin_login()
    {
        $this->setAction('login');
    }
    function admin_logout()
    {
        $this->setAction('logout');
    }
    function admin_export($hash = null)
    {
        $conditions = array();
        if (!empty($hash) && isset($_SESSION['user_export'][$hash])) {
            $user_ids = implode(',', $_SESSION['user_export'][$hash]);
            if ($this->User->isValidUserIdHash($user_ids, $hash)) {
                $conditions['User.id'] = $_SESSION['user_export'][$hash];
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'User.username',
                'User.email',
                'User.user_openid_count',
                'User.user_login_count',
            ) ,
            'recursive' => -1
        ));
        Configure::write('debug', 0);
        if (!empty($users)) {
            foreach($users as $user) {
                $data[]['User'] = array(
                    'Username' => $user['User']['username'],
                    'Email' => $user['User']['email'],
                    'OpenID count' => $user['User']['user_openid_count'],
                    'Login count' => $user['User']['user_login_count'],
                );
            }
        }
        $this->set('data', $data);
    }
    function whois($ip = null)
    {
        if (!empty($ip)) {
            $this->redirect(Configure::read('site.look_up_url') . $ip);
        }
    }
    function admin_clear_logs()
    {
        if (!empty($this->request->params['named']['type'])) {
            if ($this->request->params['named']['type'] == 'error_log') {
                $error_log_path = APP . '/tmp/logs/error.log';
                if (file_exists($error_log_path)) {
                    unlink(APP . '/tmp/logs/error.log');
                }
                $this->Session->setFlash(__l('Error log has been cleared') , 'default', null, 'success');
            } elseif ($this->request->params['named']['type'] == 'debug_log') {
                $debug_log_path = APP . '/tmp/logs/debug.log';
                if (file_exists($debug_log_path)) {
                    unlink(APP . '/tmp/logs/debug.log');
                }
                $this->Session->setFlash(__l('Debug log has been cleared') , 'default', null, 'success');
            }
        }
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'admin_logs'
        ));
    }
    function admin_clear_cache()
    {
        App::import('Folder');
        $folder = new Folder();
        $folder->delete(CACHE . DS . 'models');
        $folder->delete(CACHE . DS . 'persistent');
        $folder->delete(CACHE . DS . 'views');
        $this->Session->setFlash(__l('Cache Files has been cleared') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'admin_stats'
        ));
    }
    public function private_beta_register($id = null)
    {
        $referred_by_user_id = $this->Cookie->read('referrer');
        $user_refername = '';
        if (!empty($id)) {
            $data = $id;
            $data = Cms::dispatchEvent('Controller.User.inviteCheck', $this, array(
                'data' => $data
            ));
            $user_refername = $data->data['content'];
            if (empty($user_refername)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        //cookie value should be empty or same user id should not be over written
        if (!empty($user_refername)) {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $user_refername
                ) ,
                'recursive' => -1
            ));
            $this->Cookie->delete('referrer');
            $this->Cookie->write('referrer', $user['User']['id'], false, sprintf('+%s hours', Configure::read('affiliate.referral_cookie_expire_time')));
        }
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'register'
        ));
    }
    public function show_admin_control_panel()
    {
        $this->disableCache();
        if (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'user') {
            App::import('Model', 'User');
            $this->User = new User();
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['id']
                ) ,
                'recursive' => -1
            ));
            $this->set('user', $user);
        }
        $this->layout = 'ajax';
    }
    public function facepile()
    {
        $conditions = array(
            'OR' => array(
                array(
                    'User.is_facebook_connected' => 1
                ) ,
                array(
                    'User.is_facebook_register' => 1
                )
            ) ,
            'User.is_active' => 1,
        );
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'UserAvatar'
            ) ,
            'order' => array(
                'User.created' => 'desc'
            ) ,
            'limit' => 12,
            'recursive' => 0
        ));
        $this->set('users', $users);
        $totalUserCount = $this->User->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        $this->set('totalUserCount', $totalUserCount);
    }
}
?>