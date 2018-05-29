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
class SocialMarketingEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents() 
    {
        return array(
            'Controller.SocialMarketing.getShareUrl' => array(
                'callable' => 'getShareUrl',
            ) ,
            'Controller.SocialMarketing.redirectToShareUrl' => array(
                'callable' => 'redirectToShareUrl',
            ) ,
        );
    }
    public function getShareUrl($event) 
    {
		if(isset($event->data['request'])){
			$plugin	=	"Request";
		}
		else{
			$plugin	=	"Job";
		}
        $obj = $event->subject();
        $data = $event->data['data'];
        $publish_action = $event->data['publish_action'];
        $event->data['social_url'] = Router::url(array(
            'controller' => 'social_marketings',
            'action' => 'publish',
            $data,
            'type' => 'facebook',
			'publish_name' => $plugin,
            'publish_action' => $publish_action,
            'admin' => false
        ) , true);
    }
    public function redirectToShareUrl($event) 
    {
        $obj = $event->subject();
        $data = $event->data['data'];
        $publish_action = $event->data['publish_action'];
        $share = 1;
        if ($publish_action == 'fund') {
            $projectStatus = array();
            $response = Cms::dispatchEvent('Controller.ProjectType.GetProjectStatus', $obj, array(
                'projectStatus' => $projectStatus,
                'project' => $data,
                'type' => 'status'
            ));
            if (empty($response->data['is_allow_to_share'])) {
                $share = 0;
            }
            $data = $data['ProjectFund']['id'];
        }
        if (!empty($share)) {
            $obj->redirect(array(
                'controller' => 'social_marketings',
                'action' => 'publish',
                $data,
                'type' => 'facebook',
                'publish_action' => $publish_action,
                'admin' => false
            ));
        }
    }
}
?>