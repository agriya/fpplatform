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
class CronShell extends Shell {
    function main()
    {
        // site settings are set in config
		require_once (CAKE . 'router.php');
        App::import('Model', 'Setting');
        $setting_model_obj = new Setting();
        $settings = $setting_model_obj->getKeyValuePairs();
        Configure::write($settings);
		App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
		App::import('Component', 'Cron');
        $this->Cron = new CronComponent($collection);
        $option = !empty($this->args[0]) ? $this->args[0] : '';
        $this->log('Cron started without any issue.', LOG_DEBUG);
        switch ($option) {
            case 'run_crons':
                $this->Cron->run_crons();
                break;
            default: ;
        } // switch
        $this->log('Cron finished successfully', LOG_DEBUG);
    }
}

?>