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
class MemcachedBehavior extends ModelBehavior
{
    /**
     * Setup
     *
     * @param object $model
     * @param array  $config
     * @return void
     */
    private function updateCounter($model) 
    {
        $tag = !empty($model->name) ? '_' . $model->name : 'appmodel';
        Cache::write($tag, 1+(int)Cache::read($tag, 'queries') , 'queries');
    }
    public function afterDelete(Model $model) 
    {
        $this->updateCounter($model);
        parent::afterDelete($model);
    }
    public function afterSave(Model $model, $created) 
    {
        $this->updateCounter($model);
        parent::afterSave($model, $created);
    }
}
