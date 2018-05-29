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
App::uses('File', 'Utility');
class Setting extends AppModel
{
    var $validate = array();
    public $belongsTo = array(
        'SettingCategory' => array(
            'className' => 'SettingCategory',
            'foreignKey' => 'setting_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'ExtensionsPlugin',
        );
    }
    /**
     * Runs after a find() operation.
     * this is to Repace the name 'Job'
     * @param array $results Results of the find operation.
     * @access public
     */
    function afterFind($results, $primary = false)
    {
        $job_alternate_name = strtolower(Configure::read('job.job_alternate_name'));
        $job_alternate_name = !empty($job_alternate_name) ? $job_alternate_name : 'jobs';
        $job_alternate_name_plural = Inflector::pluralize($job_alternate_name);
        $job_alternate_name_singular = Inflector::singularize($job_alternate_name);
        $request_alternate_name = strtolower(Configure::read('request.request_alternate_name'));
        $request_alternate_name = !empty($request_alternate_name) ? $request_alternate_name : 'requests';
        $request_alternate_name_plural = Inflector::pluralize($request_alternate_name);
        $request_alternate_name_singular = Inflector::singularize($request_alternate_name);
        $replaceable_words = array(
            'jobs' => $job_alternate_name_plural,
            'job' => $job_alternate_name_singular,
            'Jobs' => ucfirst($job_alternate_name_plural) ,
            'Job' => ucfirst($job_alternate_name_singular) ,
            'requests' => $request_alternate_name_plural,
            'request' => $request_alternate_name_singular,
            'Requests' => ucfirst($request_alternate_name_plural) ,
            'Request' => ucfirst($request_alternate_name_singular)
        );
        // loop through results
        foreach($results as &$row) {
            // loop through fields
            foreach($row as $main_key => &$field) {
                // check field exists
                if (!is_array($field)) {
                    if ($main_key != 'name' and $main_key != 'value') {
                        foreach($replaceable_words as $key => $word) $field = preg_replace('/' . $key . '/', $word, $field);
                    }
                } else
                // for second level
                {
                    foreach($field as $sub_key => &$sub_field) if ($sub_key != 'name' and $sub_key != 'value') {
                        foreach($replaceable_words as $key => $word1) $sub_field = preg_replace('/' . $key . '/', $word1, $sub_field);
                    }
                }
            }
        }
        return $results;
    }
    function validateJobAmount($job_amount, $commission_amount, $commission_type)
    {
        $error = '';
        $return = array();
        $formattedAmounts = $this->jobFormatAmount($job_amount, $commission_amount);
        if (count($formattedAmounts['Job_amount']) == count($formattedAmounts['commission_amount'])) {
            if ($commission_type == 'percentage') {
                foreach($formattedAmounts['commission_amount'] as $formattedCommissionAmount) {
                    if ($formattedCommissionAmount >= '100') {
                        $return['error'] = 1;
                        $return['flash'] = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('commission amount should not exceed 100 when commission type is set to percentage');
                    }
                }
            } else {
                foreach($formattedAmounts['Job_amount'] as $key => $value) {
                    if ($formattedAmounts['commission_amount'][$key] >= $value) {
                        $return['error'] = 1;
                        $return['flash'] = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('amount and commission should be set the same amount when commission type is set to amount');
                    }
                }
            }
        } else {
            $return['error'] = 1;
            $return['flash'] = jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('amount and commission amount must match properly');
        }
        return $return;
    }
    function jobFormatAmount($job_amount, $commission_amount)
    {
        $job_amounts = explode(',', $job_amount);
        foreach($job_amounts as $job_amount) {
            $job_amount = trim($job_amount);
            if (!empty($job_amount) && ($job_amount > 0)) {
                $formatedAmount['Job_amount'][] = $job_amount;
            }
        }
        $commission_amounts = explode(',', $commission_amount);
        foreach($commission_amounts as $commission_amount) {
            $commission_amount = trim($commission_amount);
            if (!empty($commission_amount) && ($commission_amount > 0)) {
                $formatedAmount['commission_amount'][] = $commission_amount;
            }
        }
        return $formatedAmount;
    }
    function checkTransactionFee($settings)
    {
        if (!empty($settings[231]['name']) && $settings[231]['name'] == 'amount') {
            if ($settings[170]['name'] <= $settings[230]['name']) { // Minim withdrawal less than transaction fee......or viceversa .....hit the error.
                $return['error'] = 1;
                $return['flash'] = __l('Transaction fee should be less than minimum withdrawal amount');
                return $return;
            }
        }
    }
    function ValidateJobDays($day1, $day2)
    {
        if ($day1['name'] >= $day2['name']) { // Minimum days less than max days......or viceversa .....hit the error.
            $return['error'] = 1;
            $return['flash'] = __l('Maximum days should be greater than minimum withdrawal amount');
            return $return;
        }
    }
    /**
     * afterSave callback
     *
     * @return void
     */
    public function afterSave($created)
    {
        $this->updateYaml();
        $this->writeConfiguration();
        @unlink(APP . 'webroot' . DS . 'index.html');
    }
    /**
     * afterDelete callback
     *
     * @return void
     */
    public function afterDelete()
    {
        $this->updateYaml();
        $this->writeConfiguration();
    }
    /**
     * Find list and save yaml dump in app/config/settings.yml file.
     * Data required in bootstrap.
     *
     * @return void
     */
    public function updateYaml()
    {
        $list = $this->find('list', array(
            'fields' => array(
                'name',
                'value',
            ) ,
            'order' => array(
                'Setting.name' => 'ASC',
            ) ,
            'recursive' => -1
        ));
        $filePath = APP . 'Config' . DS . 'settings.yml';
        $file = new File($filePath, true);
        $listYaml = Spyc::YAMLDump($list, 4, 60);
        $file->write($listYaml);
    }
    /**
     * All key/value pairs are made accessible from Configure class
     *
     * @return void
     */
    public function writeConfiguration()
    {
        $settings = $this->find('all', array(
            'fields' => array(
                'Setting.name',
                'Setting.value',
            ) ,
            'cache' => array(
                'name' => 'setting_write_configuration',
                'config' => 'setting_write_configuration',
            ) ,
        ));
        foreach($settings AS $setting) {
            if (isPluginEnabled('Jobs')) {
                $_data = array();
                if ($setting['Setting']['name'] == 'job.is_enable_online') {
                    $_data['JobType']['id'] = ConstJobType::Online;
                    if ($setting['Setting']['value']) {
                        $_data['JobType']['is_active'] = 1;
                    } else {
                        $_data['JobType']['is_active'] = 0;
                    }
                }
                if ($setting['Setting']['name'] == 'job.is_enable_offline') {
                    $_data['JobType']['id'] = ConstJobType::Offline;
                    if ($setting['Setting']['value']) {
                        $_data['JobType']['is_active'] = 1;
                    } else {
                        $_data['JobType']['is_active'] = 0;
                    }
                }
                App::import('Model', 'Jobs.JobType');
                $this->JobType = new JobType();
                $this->JobType->save($_data);
            }
            Configure::write($setting['Setting']['name'], $setting['Setting']['value']);
        }
    }
    /**
     * Creates a new record with name/value pair if name does not exist.
     *
     * @param string $name
     * @param string $value
     * @param array $options
     * @return boolean
     */
    public function write($key, $value, $options = array())
    {
        $_options = array(
            'description' => '',
            'input_type' => '',
            'editable' => 0,
            'params' => '',
        );
        $options = array_merge($_options, $options);
        $setting = $this->findByName($key);
        if (isset($setting['Setting']['id'])) {
            $setting['Setting']['id'] = $setting['Setting']['id'];
            $setting['Setting']['value'] = $value;
            $setting['Setting']['description'] = $options['description'];
            $setting['Setting']['input_type'] = $options['input_type'];
            $setting['Setting']['editable'] = $options['editable'];
            $setting['Setting']['params'] = $options['params'];
        } else {
            $setting = array();
            $setting['name'] = $key;
            $setting['value'] = $value;
            $setting['description'] = $options['description'];
            $setting['input_type'] = $options['input_type'];
            $setting['editable'] = $options['editable'];
            $setting['params'] = $options['params'];
        }
        $this->id = false;
        if ($this->save($setting)) {
            Configure::write($key, $value);
            return true;
        } else {
            return false;
        }
    }
}
