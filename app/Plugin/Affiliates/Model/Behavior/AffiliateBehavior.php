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
 * CounterCacheHabtmBehavior - add counter cache support for HABTM relations
 *
 * Based on CounterCacheBehavior by Derick Ng aka dericknwq
 *
 * @see http://bakery.cakephp.org/articles/view/counter-cache-behavior-for-habtm-relations
 * @author Yuri Pimenov aka Danaki (http://blog.gate.lv)
 * @version 2009-05-28
 */
class AffiliateBehavior extends ModelBehavior
{
    function afterSave(Model $model, $created) 
    {
        if (isPluginEnabled('Affiliates')) {
            $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
            if (array_key_exists($model->name, $affiliate_model)) {
                if ($created) {
                    $this->__createAffiliate($model);
                } else {
                    $this->__updateAffiliate($model);
                }
            }
        }
    }
    function __createAffiliate(&$model)
    {
        App::import('Core', 'Cookie');
        $collection = new ComponentCollection();
		$cookie = new CookieComponent($collection);
        $referrer['refer_id'] = $cookie->read('referrer');
        $this->User = $this->__getparentClass('User');
        $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
        if (((!empty($referrer['refer_id'])) || (!empty($model->data['User']['referred_by_user_id']))) && ($model->name == 'User')) {
            if (empty($referrer['refer_id'])) {
                $referrer['refer_id'] = $model->data['User']['referred_by_user_id'];
            }
            // update refer_id
            $data['User']['referred_by_user_id'] = $referrer['refer_id'];
            $data['User']['id'] = $model->id;
            $this->User->save($data);
            // referred count update
            $this->User->updateAll(array(
                'User.referred_by_user_count' => 'User.referred_by_user_count + ' . '1'
            ) , array(
                'User.id' => $referrer['refer_id']
            ));
            if ($this->__CheckAffiliateUSer($referrer['refer_id'])) {
                $this->AffiliateType = $this->__getparentClass('AffiliateType', 'Affiliates');
                $affiliateType = $this->AffiliateType->find('first', array(
                    'conditions' => array(
                        'AffiliateType.id' => $affiliate_model['User']
                    ) ,
                    'fields' => array(
                        'AffiliateType.id',
                        'AffiliateType.commission',
                        'AffiliateType.affiliate_commission_type_id'
                    ) ,
                    'recursive' => - 1
                ));
                $affiliate_commision_amount = 0;
                if (!empty($affiliateType)) {
                    if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
                        $affiliate_commision_amount = 0.0; //($model->data['JobOrder']['commission_amount'] * $affiliateType['AffiliateType']['commission']) / 100;
                        
                    } else {
                        $affiliate_commision_amount = $affiliateType['AffiliateType']['commission'];
                    }
                }
                // set affiliate data
                $affiliate['Affiliate']['class'] = 'User';
                $affiliate['Affiliate']['foreign_id'] = $model->id;
                $affiliate['Affiliate']['affiliate_type_id'] = $affiliate_model['User'];
                $affiliate['Affiliate']['affliate_user_id'] = $referrer['refer_id'];
                $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
                $affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
                $affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
                $this->__saveAffiliate($affiliate);
                $cookie->delete('referrer');
            }
        } else if ($model->name == 'JobOrder') {
            $this->JobOrder = $this->__getparentClass('JobOrder', 'Jobs');
            if (empty($referrer['refer_id'])) {
                if (isset($model->data['JobOrder']['user_id']) && !empty($model->data['JobOrder']['user_id'])) {
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $model->data['JobOrder']['user_id']
                        ) ,
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.referred_by_user_id'
                        ) ,
                        'recursive' => - 1
                    ));
                    if (!empty($user['User']['referred_by_user_id'])) {
                        if (Configure::read('affiliate.commission_on_every_job_purchase')) {
                            $referrer['refer_id'] = $user['User']['referred_by_user_id'];
                        } else {
                            $gigorders = $this->JobOrder->find('count', array(
                                'conditions' => array(
                                    'JobOrder.id <>' => $model->id,
                                    'JobOrder.user_id' => $model->data['JobOrder']['user_id'],
                                    'JobOrder.referred_by_user_id' => $user['User']['referred_by_user_id'],
                                ) ,
                            ));
                            if ($gigorders < 1) $referrer['refer_id'] = $user['User']['referred_by_user_id'];
                        }
                    }
                }
            }
            if (!empty($referrer['refer_id']) && $this->__CheckAffiliateUSer($referrer['refer_id'])) {
                $this->AffiliateType = $this->__getparentClass('AffiliateType', 'Affiliates');
                $affiliateType = $this->AffiliateType->find('first', array(
                    'conditions' => array(
                        'AffiliateType.id' => $affiliate_model['JobOrder']
                    ) ,
                    'fields' => array(
                        'AffiliateType.id',
                        'AffiliateType.commission',
                        'AffiliateType.affiliate_commission_type_id'
                    ) ,
                    'recursive' => - 1
                ));
                $affiliate_commision_amount = 0;
                $admin_commision_amount = 0;
                if (!empty($affiliateType)) {
                    if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
                        $affiliate_commision_amount = ($model->data['JobOrder']['commission_amount'] * $affiliateType['AffiliateType']['commission']) / 100;
                    } else {
                        $affiliate_commision_amount = ($model->data['JobOrder']['commission_amount'] - $affiliateType['AffiliateType']['commission']);
                    }
                    $admin_commision_amount = $model->data['JobOrder']['commission_amount'] - $affiliate_commision_amount;
                }
                if (!empty($model->data['JobOrder']['job_order_status_id'])) {
                    $data['JobOrder']['job_order_status_id'] = $model->data['JobOrder']['job_order_status_id'];
                }
                $data['JobOrder']['referred_by_user_id'] = $referrer['refer_id'];
                $data['JobOrder']['admin_commission_amount'] = $admin_commision_amount;
                $data['JobOrder']['affiliate_commission_amount'] = $affiliate_commision_amount;
                $data['JobOrder']['id'] = $model->id;
                $this->JobOrder->save($data['JobOrder']);
                // set affiliate data
                $affiliate['Affiliate']['class'] = 'JobOrder';
                $affiliate['Affiliate']['foreign_id'] = $model->id;
                $affiliate['Affiliate']['affiliate_type_id'] = $affiliate_model['JobOrder'];
                $affiliate['Affiliate']['affliate_user_id'] = $referrer['refer_id'];
                $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
                $affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
                $this->__saveAffiliate($affiliate);
                $cookie->delete('referrer');
                $this->User->updateAll(array(
                    'User.referred_purchase_count' => 'User.referred_purchase_count + ' . '1'
                ) , array(
                    'User.id' => $referrer['refer_id']
                ));
                $this->User->updateAll(array(
                    'User.affiliate_refer_purchase_count' => 'User.affiliate_refer_purchase_count + ' . '1'
                ) , array(
                    'User.id' => $model->data['JobOrder']['user_id']
                ));
                $conditions['Affiliate.class'] = 'JobOrder';
                $conditions['Affiliate.foreign_id'] = $model->id;
                $affliates = $this->__findAffiliate($conditions);
                $this->JobOrder->Job->updateAll(array(
                    'Job.referred_purchase_count' => 'Job.referred_purchase_count + ' . '1'
                ) , array(
                    'Job.id' => $affliates['JobOrder']['job_id']
                ));
            }
        }
    }
    function __updateAffiliate(&$model)
    {
        if ($model->name == 'JobOrder' && isset($model->data['JobOrder']['job_order_status_id']) && ($model->data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::PaymentCleared || $model->data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Cancelled || $model->data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Rejected || $model->data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Expired || $model->data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::CancelledDueToOvertime || $model->data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::CancelledByAdmin || $model->data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::MutualCancelled || $model->data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::CompletedAndClosedByAdmin)) {
            $conditions['Affiliate.class'] = 'JobOrder';
            $conditions['Affiliate.foreign_id'] = $model->id;
            $affliates = $this->__findAffiliate($conditions);
            if (!empty($affliates['JobOrder']['referred_by_user_id'])) {
                $affiliate['Affiliate']['id'] = $affliates['Affiliate']['id'];
                if ($model->data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::PaymentCleared || $model->data['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::CompletedAndClosedByAdmin) {
                    $affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
                    $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
                } else {
                    $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Canceled;
                    $this->User = $this->__getparentClass('User');
                    $this->User->updateAll(array(
                        'User.total_commission_canceled_amount' => 'User.total_commission_canceled_amount + ' . $affliates['Affiliate']['commission_amount']
                    ) , array(
                        'User.id' => $affliates['Affiliate']['affliate_user_id']
                    ));
                }
                $this->__saveAffiliate($affiliate);
            }
        }
    }
    function __saveAffiliate($data)
    {
        $this->Affiliate = $this->__getparentClass('Affiliate', 'Affiliates');
        if (!isset($data['Affiliate']['id'])) {
            $this->Affiliate->create();
            $this->Affiliate->AffiliateUser->updateAll(array(
                'AffiliateUser.total_commission_pending_amount' => 'AffiliateUser.total_commission_pending_amount + ' . $data['Affiliate']['commission_amount']
            ) , array(
                'AffiliateUser.id' => $data['Affiliate']['affliate_user_id']
            ));
        }
        $this->Affiliate->save($data);
    }
    function __findAffiliate($condition)
    {
        $this->Affiliate = $this->__getparentClass('Affiliate', 'Affiliates');
        $affiliate = $this->Affiliate->find('first', array(
            'conditions' => $condition,
            'recursive' => - 1
        ));
        return $affiliate;
    }
    function __CheckAffiliateUSer($refer_user_id)
    {
        $this->User = $this->__getparentClass('User');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $refer_user_id
            ) ,
            'recursive' => - 1
        ));
        if (!empty($user) && ($user['User']['is_affiliate_user'])) {
            return true;
        }
        return false;
    }
    function __getparentClass($parentClass, $pluginName = null)
    {        
        if(!is_null($pluginName)){
            $pluginName = $pluginName . '.';
        } else {
            $pluginName = $pluginName;
        }
        App::import('Model', $pluginName . $parentClass);       
        return new $parentClass;
    }
}
?>