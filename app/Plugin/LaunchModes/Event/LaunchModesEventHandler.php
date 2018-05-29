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
class LaunchModesEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents()
    {
        return array(
            'Controller.Settings.redirectToPreLaunch' => array(
                'callable' => 'SubscribeMailonLaunch',
            ) ,
            'Controller.User.inviteCheck' => array(
                'callable' => 'isSiteInvitedUser',
            ) ,
        );
    }
    public function SubscribeMailonLaunch($event)
    {
        $obj = $event->subject();
        $data = $event->data['data'];
        App::import('Model', 'LaunchModes.Subscription');
		$this->Subscription = new Subscription;
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
        if ($data['Setting']['launch_type'] == 'Pre-launch' || $data['Setting']['launch_type'] == 'Private Beta') {
            $email_template = $this->EmailTemplate->selectTemplate('Launch mail');
        }
        if ($data['Setting']['launch_type'] == 'private_beta') {
            $email_template = $this->EmailTemplate->selectTemplate('Private Beta mail');
        }
        $subscriptions = $this->Subscription->find('all', array(
            'recursive' => -1,
            'order' => array(
                'Subscription.is_social_like' => 'desc',
                'Subscription.id' => 'asc'
            )
        ));
        foreach($subscriptions as $subscription) {
            $emailFindReplace = array(
                '##INVITE_LINK##' => Router::url(array(
					'controller' => 'users',
					'action' => 'register',
					'type' => 'social',
					'admin' => false
				) , true),
				'##INVITE_CODE##' => $subscription['Subscription']['invite_hash'],
				'##SITE_LINK##' => Router::url('/', true) ,
				'##CONTACT_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add'
                        ) , true) ,
            );
            $this->Subscription->_sendEmail($email_template, $emailFindReplace, $subscription['Subscription']['email']);
			$this->Subscription->updateAll(array(
                'Subscription.is_sent_private_beta_mail' => 1
            ) , array(
                'Subscription.id' => $subscription['Subscription']['id']
            ));
        }
    }
    public function isSiteInvitedUser($event)
    {
        $subscriber_id = $event->data['data'];
        $obj = $event->subject();
        App::import('Model', 'LaunchModes.Subscription');
        $this->Subscription = new Subscription;
        $suscriber = $this->Subscription->find('first', array(
            'conditions' => array(
                'Subscription.id' => $subscriber_id
            )
        ));
        $event->data['content'] = $suscriber;
    }
}
?>