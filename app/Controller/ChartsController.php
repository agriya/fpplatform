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
class ChartsController extends AppController
{
    public $name = 'Charts';
    public $lastDays;
    public $lastMonths;
    public $lastYears;
    public $lastWeeks;
    public $selectRanges;
    public $lastDaysStartDate;
    public $lastMonthsStartDate;
    public $lastYearsStartDate;
    public $lastWeeksStartDate;
    public $lastDaysPrev;
    public $lastWeeksPrev;
    public $lastMonthsPrev;
    public $lastYearsPrev;
    public function initChart()
    {
        //# last days date settings
        $days = 6;
        $this->lastDaysStartDate = date('Y-m-d', strtotime("-$days days"));
        for ($i = $days; $i > 0; $i--) {
            $this->lastDays[] = array(
                'display' => date('D, M d', strtotime("-$i days")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("-$i days")) ,
                    '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("-$i days"))
                )
            );
        }
        $this->lastDays[] = array(
            'display' => date('D, M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("now")) ,
                '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("now"))
            )
        );
        $days = 13;
        for ($i = $days; $i >= 7; $i--) {
            $this->lastDaysPrev[] = array(
                'display' => date('M d, Y', strtotime("-$i days")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("-$i days")) ,
                    '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("-$i days"))
                )
            );
        }
        //# last weeks date settings
        $timestamp_end = strtotime('last Saturday');
        $weeks = 3;
        $this->lastWeeksStartDate = date('Y-m-d', $timestamp_end-((($weeks*7) -1) *24*3600));
        for ($i = $weeks; $i > 0; $i--) {
            $start = $timestamp_end-((($i*7) -1) *24*3600);
            $end = $start+(6*24*3600);
            $this->lastWeeks[] = array(
                'display' => date('M d', $start) . ' - ' . date('M d', $end) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d 00:00:00', $start) ,
                    '#MODEL#.created <=' => date('Y-m-d 23:59:59', $end) ,
                )
            );
        }
        $this->lastWeeks[] = array(
            'display' => date('M d', $timestamp_end+24*3600) . ' - ' . date('M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-d 00:00:00', $timestamp_end+24*3600) ,
                '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime('now'))
            )
        );
        $weeks = 7;
        for ($i = $weeks; $i > 3; $i--) {
            $start = $timestamp_end-((($i*7) -1) *24*3600);
            $end = $start+(6*24*3600);
            $this->lastWeeksPrev[] = array(
                'display' => date('M d', $start) . ' - ' . date('M d', $end) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d 00:00:00', $start) ,
                    '#MODEL#.created <=' => date('Y-m-d 23:59:59', $end)
                )
            );
        }
        //# last months date settings
        $months = 2;
        $this->lastMonthsStartDate = date('Y-m-01', strtotime("-$months months"));
        for ($i = $months; $i > 0; $i--) {
            $this->lastMonths[] = array(
                'display' => date('M, Y', strtotime("-$i months")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-01', strtotime("-$i months")) ,
                    '#MODEL#.created <=' => date('Y-m-t', strtotime("-$i months")) ,
                )
            );
        }
        $this->lastMonths[] = array(
            'display' => date('M, Y') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-01', strtotime('now')) ,
                '#MODEL#.created <=' => date('Y-m-t', strtotime('now')) ,
            )
        );
        $months = 5;
        for ($i = $months; $i > 2; $i--) {
            $this->lastMonthsPrev[] = array(
                'display' => date('M, Y', strtotime("-$i months")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-01', strtotime("-$i months")) ,
                    '#MODEL#.created <=' => date('Y-m-' . date('t', strtotime("-$i months")) , strtotime("-$i months"))
                )
            );
        }
        //# last years date settings
        $years = 2;
        $this->lastYearsStartDate = date('Y-01-01', strtotime("-$years years"));
        for ($i = $years; $i > 0; $i--) {
            $this->lastYears[] = array(
                'display' => date('Y', strtotime("-$i years")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-01-01', strtotime("-$i years")) ,
                    '#MODEL#.created <=' => date('Y-12-31', strtotime("-$i years")) ,
                )
            );
        }
        $this->lastYears[] = array(
            'display' => date('Y') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-01-01', strtotime('now')) ,
                '#MODEL#.created <=' => date('Y-12-31', strtotime('now')) ,
            )
        );
        $years = 5;
        for ($i = $years; $i > 2; $i--) {
            $this->lastYearsPrev[] = array(
                'display' => date('Y', strtotime("-$i years")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-01-01', strtotime("-$i years")) ,
                    '#MODEL#.created <=' => date('Y-12-' . date('t', strtotime("-$i years")) , strtotime("-$i years")) ,
                )
            );
        }
        $this->selectRanges = array(
            'lastDays' => __l('Last 7 days') ,
            'lastWeeks' => __l('Last 4 weeks') ,
            'lastMonths' => __l('Last 3 months') ,
            'lastYears' => __l('Last 3 years')
        );
    }
    public function admin_chart_overview()
    {
        $this->initChart();
    }
    public function admin_chart_users()
    {
        $this->initChart();
        $this->loadModel('User');
        if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (!empty($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['role_id'] = $role_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_google_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_linkedin_register' => 0,
            )
        );
        if (Configure::read('twitter.is_enabled_twitter_connect')) {
            $model_datas['Twitter'] = array(
                'display' => __l('Twitter') ,
                'conditions' => array(
                    'User.is_twitter_register' => 1,
                ) ,
            );
        }
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('openid.is_enabled_openid_connect')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        if (Configure::read('google.is_enabled_google_connect')) {
            $model_datas['Gmail'] = array(
                'display' => __l('Gmail') ,
                'conditions' => array(
                    'User.is_google_register' => 1,
                )
            );
        }
        if (Configure::read('yahoo.is_enabled_yahoo_connect')) {
            $model_datas['Yahoo'] = array(
                'display' => __l('Yahoo') ,
                'conditions' => array(
                    'User.is_yahoo_register' => 1,
                )
            );
        }
        if (Configure::read('linkedin.is_enabled_linkedin_connect')) {
            $model_datas['LinkedIn'] = array(
                'display' => __l('LinkedIn') ,
                'conditions' => array(
                    'User.is_linkedin_register' => 1,
                )
            );
        }
        if (isPluginEnabled('Affiliates')) {
            $_periods['Affiliate'] = array(
                'display' => __l('Affiliate') ,
                'conditions' => array(
                    'User.is_affiliate_user' => 1,
                )
            );
        }
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'User', 'User', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d 23:59:59');
        $total_users = $this->User->find('count', array(
            'conditions' => array(
                'User.role_id' => $role_id,
                'created >=' => $startDate,
                'created <=' => $endDate
            ) ,
            'recursive' => -1
        ));
        unset($model_datas['All']);
        unset($model_datas['Affiliate']);
        $_pie_data = $chart_pie_gender_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'created >=' => $startDate,
                    'created <=' => $endDate
                ));
                $new_conditions['User.role_id'] = $role_id;
                $sub_total = $this->User->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => -1
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
            // demographics
            $conditions = array(
                'User.created >=' => $startDate,
                'User.created <=' => $endDate,
                'User.role_id' => $role_id
            );
            $this->_setDemographics($total_users, $conditions);
        }
        $this->set('chart_pie_data', $_pie_data);
        $is_ajax_load = false;
        if ($this->RequestHandler->isAjax()) {
            $is_ajax_load = true;
        }
        $this->set('is_ajax_load', $is_ajax_load);
    }
    public function admin_chart_user_logins()
    {
        $this->initChart();
        $this->loadModel('UserLogin');
        if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['role_id'] = $role_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_google_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_linkedin_register' => 0,
            )
        );
        if (Configure::read('twitter.is_enabled_twitter_connect')) {
            $model_datas['Twitter'] = array(
                'display' => __l('Twitter') ,
                'conditions' => array(
                    'User.is_twitter_register' => 1,
                ) ,
            );
        }
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('openid.is_enabled_openid_connect')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        if (Configure::read('google.is_enabled_google_connect')) {
            $model_datas['Gmail'] = array(
                'display' => __l('Gmail') ,
                'conditions' => array(
                    'User.is_google_register' => 1,
                )
            );
        }
        if (Configure::read('yahoo.is_enabled_yahoo_connect')) {
            $model_datas['Yahoo'] = array(
                'display' => __l('Yahoo') ,
                'conditions' => array(
                    'User.is_yahoo_register' => 1,
                )
            );
        }
        if (Configure::read('linkedin.is_enabled_linkedin_connect')) {
            $model_datas['LinkedIn'] = array(
                'display' => __l('LinkedIn') ,
                'conditions' => array(
                    'User.is_linkedin_register' => 1,
                )
            );
        }
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'UserLogin', 'UserLogin', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d H:i:s');
        $total_users = $this->UserLogin->find('count', array(
            'conditions' => array(
                'User.role_id' => $role_id,
                'UserLogin.created >=' => $startDate,
                'UserLogin.created <=' => $endDate,
            ) ,
            'recursive' => 0
        ));
        unset($model_datas['All']);
        $_pie_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'UserLogin.created >=' => $startDate,
                    'UserLogin.created <=' => $endDate
                ));
                $new_conditions['User.role_id'] = $role_id;
                $sub_total = $this->UserLogin->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_data', $_pie_data);
        $is_ajax_load = false;
        if ($this->RequestHandler->isAjax()) {
            $is_ajax_load = true;
        }
        $this->set('is_ajax_load', $is_ajax_load);
    }
    protected function _setDemographics($total_users = null, $conditions = array())
    {
        //# genders
        $this->loadModel('User');
        $this->loadModel('Gender');
        $this->loadModel('UserProfile');
        $not_mentioned = array(
            '0' => __l('Not Mentioned')
        );
        $chart_pie_gender_data = $chart_pie_age_data = array();
        $genders = $this->Gender->find('list');
        $genders = array_merge($not_mentioned, $genders);
        foreach($genders As $gen_key => $gender) {
            $new_conditions = $conditions;
            if ($gen_key == 0) {
                $new_conditions['UserProfile.gender_id'] = NULL;
            } else {
                $new_conditions['UserProfile.gender_id'] = $gen_key;
            }
            $gender_count = $this->UserProfile->find('count', array(
                'conditions' => $new_conditions,
                'recursive' => 0
            ));
            $chart_pie_gender_data[$gender] = number_format(($gender_count/$total_users) *100, 2);
        }
        //# age calculation
        $user_ages = array(
            '1' => __l('18 - 34 Yrs') ,
            '2' => __l('35 - 44 Yrs') ,
            '3' => __l('45 - 54 Yrs') ,
            '4' => __l('55+ Yrs')
        );
        $user_ages = array_merge($not_mentioned, $user_ages);
        foreach($user_ages As $age_key => $user_ages) {
            $new_conditions = $conditions;
            if ($age_key == 1) {
                $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -18 years'));
                $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -34 years'));
            } elseif ($age_key == 2) {
                $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -35 years'));
                $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -44 years'));
            } elseif ($age_key == 3) {
                $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -45 years'));
                $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -54 years'));
            } elseif ($age_key == 4) {
                $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -55 years'));
            } elseif ($age_key == 0) {
                $new_conditions['OR']['UserProfile.dob'] = NULL;
                $new_conditions['UserProfile.dob < '] = date('Y-m-d', strtotime('now -18 years'));
            }
            $age_count = $this->User->UserProfile->find('count', array(
                'conditions' => $new_conditions,
                'recursive' => 0
            ));
            $chart_pie_age_data[$user_ages] = number_format(($age_count/$total_users) *100, 2);
        }
    }
    protected function _setLineData($select_var, $model_datas, $models, $model = '', $common_conditions = array() , $return_field = '')
    {
        if (is_array($models)) {
            foreach($models as $m) {
                $this->loadModel($m);
            }
        } else {
            $this->loadModel($models);
        }
        $_data = array();
        foreach($this->$select_var as $val) {
            foreach($model_datas as $model_data) {
                $new_conditions = array();
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $model, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                $new_conditions = array_merge($new_conditions, $common_conditions);
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = $model;
                }
                if ($modelClass == 'Transaction') {
                    $_data[$val['display']] = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Transaction.amount) as total_amount'
                        ) ,
                        'recursive' => 0
                    ));
                } else if (($modelClass == 'ContestUser') && (!empty($return_field))) {
                    $_data[$val['display']] = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(ContestUser.site_revenue) as total_amount'
                        ) ,
                        'recursive' => 0
                    ));
                } else {
                    $_data[$val['display']][] = $this->{$modelClass}->find('count', array(
                        'conditions' => $new_conditions,
                        'recursive' => 0
                    ));
                }
            }
        }
        return $_data;
    }
    public function admin_chart_stats()
    {
    }
    public function admin_chart_metrics()
    {
        $this->pageTitle = __l('Metrics');
    }
    public function admin_user_activities()
    {
        if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        $this->initChart();
        $this->loadModel('UserLogin');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['role_id'] = $role_id;
        $_total_user_reg = $_total_user_login = $_total_user_follow = $_total_jobs = $_total_job_order = $_total_job_feedbacks = $_total_requests = $_job_feedbacks = $_total_contest_ratings = $_total_job_favorites = $_total_job_flag = $_transaction_data = $_total_transaction_data = $_total_request_flag = $job_favorites_data_per = $_total_request_flag_prev = $_total_user_flag = $_total_user_flag_prev = $_total_request_favorites = 0;
        $_total_user_reg_prev = $_total_user_login_prev = $_total_user_follow_prev = $_total_jobs_prev = $_total_job_order_prev = $_total_job_feedbacks_prev = $_total_requests_prev = $_total_contest_update_comments_prev = $_total_contest_ratings_prev = $_total_job_favorites_prev = $_job_favorites_data_prev = $_total_job_flag_prev = $_transaction_data_prev = $_total_transaction_data_prev = $_total_rev_transaction_data = $_total_rev_transaction_data_prev = $total_revenue = $rev_per = $_total_request_favorites_prev = 0;
        $prev_select_var = $select_var . 'Prev';
        // User Registeration
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $model_datas['user_reg'] = array(
            'display' => __l('User Registration') ,
            'conditions' => array()
        );
        $_user_reg_data = $this->_setLineData($select_var, $model_datas, 'User', 'User', $common_conditions);
        $_user_reg_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'User', 'User', $common_conditions);
        $sparklin_data = array();
        foreach($_user_reg_data as $display_name => $chart_data):
            $sparklin_data[] = $chart_data['0'];
            $_total_user_reg+= $chart_data['0'];
        endforeach;
        $_user_reg_data = implode(',', $sparklin_data);
        foreach($_user_reg_data_prev as $display_name => $chart_data):
            $_total_user_reg_prev+= $chart_data['0'];
        endforeach;
        // User Login
        $model_datas['user_login'] = array(
            'display' => __l('User Login') ,
            'conditions' => array()
        );
        $_user_log_data = $this->_setLineData($select_var, $model_datas, 'UserLogin', 'UserLogin');
        $_user_log_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'UserLogin', 'UserLogin');
        $sparklin_data = array();
        foreach($_user_log_data as $display_name => $chart_data):
            $sparklin_data[] = $chart_data['0'];
            $_total_user_login+= $chart_data['0'];
        endforeach;
        $_user_log_data = implode(',', $sparklin_data);
        foreach($_user_log_data_prev as $display_name => $chart_data):
            $_total_user_login_prev+= $chart_data['0'];
        endforeach;
        // User Follow
        if (isPluginEnabled('UserFavourites')) {
            $model_datas['user-follow'] = array(
                'display' => __l('User Followers') ,
                'conditions' => array()
            );
            $_user_follow_data = $this->_setLineData($select_var, $model_datas, 'UserFavourites.UserFavorite', 'UserFavorite');
            $_user_follow_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'UserFavourites.UserFavorite', 'UserFavorite');
            $sparklin_data = array();
            foreach($_user_follow_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_user_follow+= $chart_data['0'];
            endforeach;
            $_user_follow_data = implode(',', $sparklin_data);
            foreach($_user_follow_data_prev as $display_name => $chart_data):
                $_total_user_follow_prev+= $chart_data['0'];
            endforeach;
            $this->set('user_follow_data', $_user_follow_data);
            $this->set('total_user_follow', $_total_user_follow);
            if (!empty($_total_user_follow_prev) && !empty($_total_user_follow)) {
                $user_follow_data_per = round((($_total_user_follow-$_total_user_follow_prev) *100) /$_total_user_follow_prev);
            } else if (empty($_total_user_follow_prev) && !empty($_total_user_follow)) {
                $user_follow_data_per = 100;
            } else {
                $user_follow_data_per = 0;
            }
            $this->set('user_follow_data_per', $user_follow_data_per);
        }
        // Jobs
        if (isPluginEnabled('Jobs')) {
            $model_datas['jobs'] = array(
                'display' => jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) ,
                'conditions' => array()
            );
            $_jobs_data = $this->_setLineData($select_var, $model_datas, 'Jobs.Job', 'Job');
            $_jobs_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Jobs.Job', 'Job');
            $sparklin_data = array();
            foreach($_jobs_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_jobs+= $chart_data['0'];
            endforeach;
            $_jobs_data = implode(',', $sparklin_data);
            foreach($_jobs_data_prev as $display_name => $chart_data):
                $_total_jobs_prev+= $chart_data['0'];
            endforeach;
            $this->set('jobs_data', $_jobs_data);
            $this->set('total_jobs', $_total_jobs);
            if (!empty($_total_jobs_prev) && !empty($_total_jobs)) {
                $jobs_data_per = round((($_total_jobs-$_total_jobs_prev) *100) /$_total_jobs_prev);
            } else if (empty($_total_jobs_prev) && !empty($_total_jobs)) {
                $jobs_data_per = 100;
            } else {
                $jobs_data_per = 0;
            }
            $this->set('jobs_data_per', $jobs_data_per);
        }
        if (isPluginEnabled('Requests')) {
            $model_datas['jobs'] = array(
                'display' => jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) ,
                'conditions' => array()
            );
            $_requests_data = $this->_setLineData($select_var, $model_datas, 'Requests.Request', 'Request');
            $_requests_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Requests.Request', 'Request');
            $sparklin_data = array();
            foreach($_requests_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_requests+= $chart_data['0'];
            endforeach;
            $_requests_data = implode(',', $sparklin_data);
            foreach($_requests_data_prev as $display_name => $chart_data):
                $_total_requests_prev+= $chart_data['0'];
            endforeach;
            $this->set('requests_data', $_requests_data);
            $this->set('total_requests', $_total_requests);
            if (!empty($_total_requests_prev) && !empty($_total_requests)) {
                $requests_data_per = round((($_total_requests-$_total_requests_prev) *100) /$_total_requests_prev);
            } else if (empty($_total_requests_prev) && !empty($_total_requests)) {
                $requests_data_per = 100;
            } else {
                $requests_data_per = 0;
            }
            $this->set('requests_data_per', $requests_data_per);
        }
        // Order
        if (isPluginEnabled('Jobs')) {
            $model_datas['job_order'] = array(
                'display' => __l('Orders') ,
                'conditions' => array()
            );
            $_job_order_data = $this->_setLineData($select_var, $model_datas, 'Jobs.JobOrder', 'JobOrder');
            $_job_order_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Jobs.JobOrder', 'JobOrder');
            $sparklin_data = array();
            foreach($_job_order_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_job_order+= $chart_data['0'];
            endforeach;
            $_job_order_data = implode(',', $sparklin_data);
            foreach($_job_order_data_prev as $display_name => $chart_data):
                $_total_job_order_prev+= $chart_data['0'];
            endforeach;
            $this->set('job_order_data', $_job_order_data);
            $this->set('total_job_order', $_total_job_order);
            if (!empty($_total_job_order_prev) && !empty($_total_job_order)) {
                $job_order_data_per = round((($_total_job_order-$_total_job_order_prev) *100) /$_total_job_order_prev);
            } else if (empty($_total_job_order_prev) && !empty($_total_job_order)) {
                $job_order_data_per = 100;
            } else {
                $job_order_data_per = 0;
            }
            $this->set('job_order_data_per', $job_order_data_per);
        }
        // Contest Comments
        $model_datas['job_feedbacks'] = array(
            'display' => sprintf(__l('%s Feedbacks') , jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps)) ,
            'conditions' => array()
        );
        $_job_feedbacks_data = $this->_setLineData($select_var, $model_datas, 'Jobs.JobFeedback', 'JobFeedback');
        $_job_feedbacks_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Jobs.JobFeedback', 'JobFeedback');
        $sparklin_data = array();
        foreach($_job_feedbacks_data as $display_name => $chart_data):
            $sparklin_data[] = $chart_data['0'];
            $_job_feedbacks+= $chart_data['0'];
        endforeach;
        $_job_feedbacks_data = implode(',', $sparklin_data);
        foreach($_job_feedbacks_data_prev as $display_name => $chart_data):
            $_total_job_feedbacks_prev+= $chart_data['0'];
        endforeach;
        $this->set('job_feedbacks_data', $_job_feedbacks_data);
        $this->set('total_job_feedbacks', $_total_job_feedbacks);
        if (!empty($_total_job_feedbacks_prev) && !empty($_total_job_feedbacks)) {
            $job_feedbacks_data_per = round((($_total_job_feedbacks-$_total_job_feedbacks_prev) *100) /$_total_job_feedbacks_prev);
        } else if (empty($_total_job_feedbacks_prev) && !empty($_total_job_feedbacks)) {
            $job_feedbacks_data_per = 100;
        } else {
            $job_feedbacks_data_per = 0;
        }
        $this->set('job_feedbacks_data_per', $job_feedbacks_data_per);
        // Entry Ratings
        if (isPluginEnabled('RequestFavorites')) {
            $model_datas['request_favorites'] = array(
                'display' => sprintf(__l('%s Favorites') , requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps)) ,
                'conditions' => array()
            );
            $_request_favorites_data = $this->_setLineData($select_var, $model_datas, 'RequestFavorites.RequestFavorite', 'RequestFavorite');
            $_request_favorites_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'RequestFavorites.RequestFavorite', 'RequestFavorite');
            $sparklin_data = array();
            foreach($_request_favorites_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_request_favorites+= $chart_data['0'];
            endforeach;
            $_request_favorites_data = implode(',', $sparklin_data);
            foreach($_request_favorites_data_prev as $display_name => $chart_data):
                $_total_request_favorites_prev+= $chart_data['0'];
            endforeach;
            $this->set('request_favorites_data', $_request_favorites_data);
            $this->set('total_request_favorites', $_total_request_favorites);
            if (!empty($_total_request_favorites_prev) && !empty($_total_request_favorites)) {
                $request_favorites_data_per = round((($_total_request_favorites-$_total_request_favorites_prev) *100) /$_total_request_favorites_prev);
            } else if (empty($_total_request_favorites_prev) && !empty($_total_request_favorites)) {
                $request_favorites_data_per = 100;
            } else {
                $request_favorites_data_per = 0;
            }
            $this->set('request_favorites_data_per', $request_favorites_data_per);
        }
        // Contest Followers
        if (isPluginEnabled('JobFavorites')) {
            $model_datas['job_favorites'] = array(
                'display' => sprintf(__l('%s Favorites') , jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps)) ,
                'conditions' => array()
            );
            $_job_favorites_data = $this->_setLineData($select_var, $model_datas, 'JobFavorites.JobFavorite', 'JobFavorite');
            $_job_favorites_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'JobFavorites.JobFavorite', 'JobFavorite');
            $sparklin_data = array();
            foreach($_job_favorites_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_job_favorites+= $chart_data['0'];
            endforeach;
            $_job_favorites_data = implode(',', $sparklin_data);
            foreach($_job_favorites_data_prev as $display_name => $chart_data):
                $_total_job_favorites_prev+= $chart_data['0'];
            endforeach;
            $this->set('job_favorites_data', $_job_favorites_data);
            $this->set('total_job_favorites', $_total_job_favorites);
            if (!empty($_total_job_favorites_prev) && !empty($_total_job_favorites)) {
                $job_favorites_data_per = round((($_total_job_favorites-$_total_job_favorites_prev) *100) /$_total_job_favorites_prev);
            } else if (empty($_total_job_favorites_prev) && !empty($_total_job_favorites)) {
                $job_favorites_data_per = 100;
            } else {
                $job_favorites_data_per = 0;
            }
            $this->set('job_favorites_data_per', $job_favorites_data_per);
        }
        // Contest Flags
        if (isPluginEnabled('JobFlags')) {
            $model_datas['job_flag'] = array(
                'display' => sprintf(__l('%s Flags') , jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps)) ,
                'conditions' => array()
            );
            $_job_flag_data = $this->_setLineData($select_var, $model_datas, 'JobFlags.JobFlag', 'JobFlag');
            $_job_flag_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'JobFlags.JobFlag', 'JobFlag');
            $sparklin_data = array();
            foreach($_job_flag_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_job_flag+= $chart_data['0'];
            endforeach;
            $_job_flag_data = implode(',', $sparklin_data);
            foreach($_job_flag_data_prev as $display_name => $chart_data):
                $_total_job_flag_prev+= $chart_data['0'];
            endforeach;
            $this->set('job_flag_data', $_job_flag_data);
            $this->set('total_job_flag', $_total_job_flag);
            if (!empty($_total_job_flag_prev) && !empty($_total_job_flag)) {
                $job_flag_data_per = round((($_total_job_flag-$_total_job_flag_prev) *100) /$_total_job_flag_prev);
            } else if (empty($_total_job_flag_prev) && !empty($_total_job_flag)) {
                $job_flag_data_per = 100;
            } else {
                $job_flag_data_per = 0;
            }
            $this->set('job_flag_data_per', $job_flag_data_per);
        }
        // Entry Flags
        if (isPluginEnabled('RequestFlags')) {
            $model_datas['request_flag'] = array(
                'display' => sprintf(__l('%s Flags') , requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps)) ,
                'conditions' => array()
            );
            $_request_flag_data = $this->_setLineData($select_var, $model_datas, 'RequestFlags.RequestFlag', 'RequestFlag');
            $_request_flag_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'RequestFlags.RequestFlag', 'RequestFlag');
            $sparklin_data = array();
            foreach($_request_flag_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_request_flag+= $chart_data['0'];
            endforeach;
            $_request_flag_data = implode(',', $sparklin_data);
            foreach($_request_flag_data_prev as $display_name => $chart_data):
                $_total_request_flag_prev+= $chart_data['0'];
            endforeach;
            $this->set('request_flag_data', $_request_flag_data);
            $this->set('total_request_flag', $_total_request_flag);
            if (!empty($_total_request_flag_prev) && !empty($_total_request_flag)) {
                $request_flag_data_per = round((($_total_request_flag-$_total_request_flag_prev) *100) /$_total_request_flag_prev);
            } else if (empty($_total_request_flag_prev) && !empty($_total_request_flag)) {
                $request_flag_data_per = 100;
            } else {
                $request_flag_data_per = 0;
            }
            $this->set('request_flag_data_per', $request_flag_data_per);
        }
        // User Flags
        if (isPluginEnabled('UserFlags')) {
            $model_datas['user_flag'] = array(
                'display' => __l('User Flags') ,
                'conditions' => array()
            );
            $_user_flag_data = $this->_setLineData($select_var, $model_datas, 'UserFlags.UserFlag', 'UserFlag');
            $_user_flag_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'UserFlags.UserFlag', 'UserFlag');
            $sparklin_data = array();
            foreach($_user_flag_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_user_flag+= $chart_data['0'];
            endforeach;
            $_user_flag_data = implode(',', $sparklin_data);
            foreach($_user_flag_data_prev as $display_name => $chart_data):
                $_total_user_flag_prev+= $chart_data['0'];
            endforeach;
            $this->set('user_flag_data', $_user_flag_data);
            $this->set('total_user_flag', $_total_user_flag);
            if (!empty($_total_user_flag_prev) && !empty($_total_user_flag)) {
                $user_flag_data_per = round((($_total_user_flag-$_total_user_flag_prev) *100) /$_total_user_flag_prev);
            } else if (empty($_total_user_flag_prev) && !empty($_total_user_flag)) {
                $user_flag_data_per = 100;
            } else {
                $user_flag_data_per = 0;
            }
            $this->set('user_flag_data_per', $user_flag_data_per);
        }
        // Revenue
        $sparklin_data = array();
        $conditions = array();
        $conditions['OR'][]['Transaction.transaction_type_id'] = ConstTransactionTypes::BuyJob;
        $conditions['OR'][]['Transaction.transaction_type_id'] = ConstTransactionTypes::SignupFee;
        $model_datas['transaction'] = array(
            'display' => __l('Transaction') ,
            'conditions' => array()
        );
        $_transaction_data = $this->_setLineData($select_var, $model_datas, 'Transaction', 'Transaction', $conditions);
        $_transaction_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Transaction', 'Transaction', $conditions);
        $return_field = 'amount';
        $common_conditions = array();
        $model_datas['ContestUser'] = array(
            'display' => __l('Order') ,
            'conditions' => array()
        );
        $_rev_transaction_data = $this->_setLineData($select_var, $model_datas, 'Jobs.JobOrder', 'JobOrder', $common_conditions, $return_field);
        $_rev_transaction_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Jobss.JobOrder', 'JobOrder', $common_conditions, $return_field);
        foreach($_rev_transaction_data as $display_name => $chart_data):
            $sparklin_data[$display_name] = $chart_data['0']['0']['total_amount']+$_transaction_data[$display_name]['0']['0']['total_amount'];
            $_total_transaction_data+= $_transaction_data[$display_name]['0']['0']['total_amount'];
            $_total_rev_transaction_data+= $chart_data['0']['0']['total_amount'];
        endforeach;
        foreach($_transaction_data_prev as $display_name => $chart_data):
            $_total_transaction_data_prev+= $chart_data['0']['0']['total_amount'];
            $_total_rev_transaction_data_prev+= $_rev_transaction_data_prev[$display_name]['0']['0']['total_amount'];
        endforeach;
        $revenue = implode(',', $sparklin_data);
        $total_revenue = $_total_transaction_data+$_total_rev_transaction_data;
        $total_revenue_prev = $_total_transaction_data_prev+$_total_rev_transaction_data_prev;
        $this->set('user_reg_data', $_user_reg_data);
        $this->set('total_user_reg', $_total_user_reg);
        if (!empty($_total_user_reg_prev) && !empty($_total_user_reg)) {
            $user_reg_data_per = round((($_total_user_reg-$_total_user_reg_prev) *100) /$_total_user_reg_prev);
        } else if (empty($_total_user_reg_prev) && !empty($_total_user_reg)) {
            $user_reg_data_per = 100;
        } else {
            $user_reg_data_per = 0;
        }
        $this->set('user_reg_data_per', $user_reg_data_per);
        $this->set('user_log_data', $_user_log_data);
        $this->set('total_user_login', $_total_user_login);
        if (!empty($_total_user_login_prev) && !empty($_total_user_login)) {
            $user_log_data_per = round((($_total_user_login-$_total_user_login_prev) *100) /$_total_user_login_prev);
        } else if (empty($_total_user_login_prev) && !empty($_total_user_login)) {
            $user_log_data_per = 100;
        } else {
            $user_log_data_per = 0;
        }
        $this->set('user_log_data_per', $user_log_data_per);
        $this->set('revenue', $revenue);
        $this->set('total_revenue', $total_revenue);
        if (!empty($total_revenue_prev) && !empty($total_revenue)) {
            $rev_per = round((($total_revenue-$total_revenue_prev) *100) /$total_revenue_prev);
        } else if (empty($total_revenue_prev) && !empty($total_revenue)) {
            $rev_per = 100;
        } else {
            $rev_per = 0;
        }
        $this->set('rev_per', $rev_per);
    }
    public function admin_user_engagement()
    {
        $total_users = $this->User->find('count', array(
            'recursive' => -1
        ));
        $idle_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_idle' => 1
            ) ,
            'recursive' => -1
        ));
        $job_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_job_posted' => 1
            ) ,
            'recursive' => -1
        ));
        $request_posted_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_job_requested' => 1
            ) ,
            'recursive' => -1
        ));
        $engaged_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_engaged' => 1
            ) ,
            'recursive' => -1
        ));
        $this->set('idle_users', $idle_users);
        $this->set('total_users', $total_users);
        $this->set('job_users', $job_users);
        $this->set('request_posted_users', $request_posted_users);
        $this->set('engaged_users', $engaged_users);
    }
}
