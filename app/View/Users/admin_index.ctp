<?php /* SVN: $Id: admin_index.ctp 4852 2010-05-12 12:58:27Z aravindan_111act10 $ */ ?>
<div class="hor-space js-response js-responses">
	<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo __l('Users'); ?></li>
	</ul>
	<div class="tabbable ver-space sep-top top-mspace">
      <div id="list" class="tab-pane active in no-mar">
        <div class="clearfix">
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Active Users') . '</dt><dd title="' . $approved . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($approved) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Active), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Active users'), 'escape' => false));?>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Inactive Users') . '</dt><dd title="' . $pending . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($pending) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Inactive Users'), 'escape' => false));?>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Site) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Site Users') . '</dt><dd title="' . $site_users . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($site_users) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Site), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Site Users'), 'escape' => false));?>			
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::OpenID) ? ' active' : null; ?>
 			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('OpenID Users') . '</dt><dd title="' . $openid . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($openid) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::OpenID), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('OpenID users'), 'escape' => false));?>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Facebook) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Facebook Users') . '</dt><dd title="' . $facebook . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($facebook) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Facebook), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Facebook users'), 'escape' => false));?>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Twitter) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Twitter Users') . '</dt><dd title="' . $twitter . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($twitter) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Twitter), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Twitter users'), 'escape' => false));?>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Gmail) ? ' active' : null; ?>
 			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Gmail Users') . '</dt><dd title="' . $gmail . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($gmail) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Gmail), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Gmail users'), 'escape' => false));?>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::GooglePlus) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Google+ Users') . '</dt><dd title="' . $googleplus . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($googleplus) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::GooglePlus), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Google+ Users'), 'escape' => false));?>	
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::LinkedIn) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('LinkedIn Users') . '</dt><dd title="' . $linkedin . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($linkedin) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::LinkedIn), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('LinkedIn Users'), 'escape' => false));?>				
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Yahoo) ? ' active' : null; ?>
 			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Yahoo Users') . '</dt><dd title="' . $yahoo . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($yahoo) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Yahoo), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Yahoo users'), 'escape' => false));?>
			<?php if (isPluginEnabled('Affiliates')) { ?>
				<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::AffiliateUser) ? ' active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Affiliate Users') . '</dt><dd title="' . $affiliate_user_count . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($affiliate_user_count) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::AffiliateUser), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Affiliate Users'), 'escape' => false));?>	
			<?php } ?>
			<?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstUserTypes::Admin) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Admin Users') . '</dt><dd title="' . $admin_count . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($admin_count) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','main_filter_id' => ConstUserTypes::Admin), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Admin Users'), 'escape' => false));?>				
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::NotifiedInactiveUsers) ? ' active' : null; ?>
			<?php $count = !empty($notified_inactive_users['0']['inactive_mail_count']) ? $notified_inactive_users['0']['inactive_mail_count'] : 0; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Notified Inactive Users') . '</dt><dd title="' . $count . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($count) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::NotifiedInactiveUsers), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Notified Inactive users'), 'escape' => false));?>
			<?php if (isPluginEnabled('LaunchModes')) {?>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Prelaunch) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Pre-launch Users') . '</dt><dd title="' . $prelaunch_users . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($prelaunch_users) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Prelaunch), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Pre-launch Users'), 'escape' => false));?>	
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrivateBeta) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Private Beta Users') . '</dt><dd title="' . $privatebeta_users . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($privatebeta_users) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::PrivateBeta), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Private Beta Users'), 'escape' => false));?>	
			<?php } ?>
			<?php $class = (empty($this->request->params['named']['filter_id'])) ? ' active' : null; 
			$count = $pending + $approved;?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Total Users') . '</dt><dd title="' . $count . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($count) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Active), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Total users'), 'escape' => false));?>
			
		</div>
		<?php if (isPluginEnabled('LaunchModes')) {?>
			<div class="filter-block clearfix">

			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrelaunchSubscribed) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Subscribed for Pre-launch') . '</dt><dd title="' . $prelaunch_subscribed . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($prelaunch_subscribed) . '</dd>  </dl>', array('controller'=>'subscriptions','action'=>'index','filter_id' => ConstMoreAction::PrelaunchSubscribed), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Subscribed for Pre-launch'), 'escape' => false));?>

			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrivateBetaSubscribed) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Subscribed for Private Beta') . '</dt><dd title="' . $privatebeta_subscribed . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($privatebeta_subscribed) . '</dd>  </dl>', array('controller'=>'subscriptions','action'=>'index','filter_id' => ConstMoreAction::PrivateBetaSubscribed), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Subscribed for Private Beta'), 'escape' => false));?>
		 </div>
		 <?php } ?>
		
		<div class="clearfix top-space top-mspace sep-top">
		  <div class="pull-right span10 users-form tab-clr">
			<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('User', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
				<div class="input text required ver-smspace">
				  <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
				</div>
				<div class="submit left-space">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
			<div class="pull-right top-space top-mspace mob-clr mob-dc tab-clr">
				<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18"></i> <span class="grayc">' . __l('Add') . '</span>', array('controller' => 'users', 'action' => 'add'), array('class' => 'hor-mspace bluec textb text-13','title'=>__l('Add'), 'escape' => false)); ?>
				<?php echo $this->Html->link('<i class="icon-signout no-pad text-18"></i> <span class="grayc">' . __l('Export') . '</span>', array_merge(array('controller' => 'users', 'action' => 'index', 'ext' => 'csv', 'admin' => true),$this->request->params['named']), array('title' => __l('Export This Report In CSV'), 'class' => 'textb bluec text-13 js-no-pjax', 'escape' => false));?>
			</div>
		  </div>
		  <?php echo $this->element('paging_counter'); ?>
		</div>
		</div>
		</div>
<div>
  <?php   echo $this->Form->create('User' , array('class' => 'normal ','action' => 'update'));?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="tab-pane active in no-mar" id="active-users">
  <div class="sep bot-mspace img-rounded clearfix">
    <table class="table no-mar table-striped table-hover">
  	  <thead>
	  <tr class="no-mar no-pad">
		<th class="dc sep-right textn"><?php echo __l('Select'); ?></th>
		<th class="dc sep-right textn"><?php echo __l('Actions'); ?></th>
		<th class="sep-right textn"><?php echo $this->Paginator->sort('username', __l('Username'), array('class' => 'graydarkerc no-under')); ?></th>
		<th class="dc sep-right textn"><?php echo $this->Paginator->sort('User.referred_by_user_id', __l('Referred by'), array('class' => 'graydarkerc no-under')); ?></th>
		<th class="dr sep-right textn"><?php echo $this->Paginator->sort('User.available_balance_amount', __l('Available Balance Amount') . '(' . Configure::read('site.currency') . ')', array('class' => 'graydarkerc no-under')); ?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('User.job_count', __l(jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)), array('class' => 'graydarkerc no-under')); ?></th>
		<?php if (isPluginEnabled('Requests')) { ?>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('User.request_count', __l(requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps)), array('class' => 'graydarkerc no-under')); ?></th>
		<?php } ?>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('User.user_login_count', __l('Logins'), array('class' => 'graydarkerc no-under')); ?></th>
		<th class="dc sep-right textn"><?php echo $this->Paginator->sort('User.user_view_count', __l('Views'), array('class' => 'graydarkerc no-under')); ?></th>
		<th class="dc sep-right textn"><?php echo $this->Paginator->sort('User.user_referred_counts', __l('Referrals'), array('class' => 'graydarkerc no-under')); ?></th>
		<?php if (isPluginEnabled('Sudopay')) {?>
		<th class="sep-right textn"><?php echo $this->Paginator->sort('User.sudopay_payment_gateways_user_count', __l('Connected Payment Gateways'), array('class' => 'graydarkerc no-under')); ?></th>
		<?php } ?>
		<th class="dc sep-right textn"><?php echo $this->Paginator->sort('created', __l('Created'), array('class' => 'graydarkerc no-under')); ?></th>
		<th class="sep-right textn"><?php echo $this->Paginator->sort('User.signup_ip', __l('IP'), array('class' => 'graydarkerc no-under')); ?></th>
 	</tr>
	</thead>
    <tbody>
<?php
if (!empty($users)):
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0):
		$class = ' class="altrow"';
	endif;
	if($user['User']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
		$status_class = 'js-checkbox-inactive';
	endif;
?>
	<tr<?php echo $class;?>>
		<td class="dc grayc"><?php echo $this->Form->input('User.'.$user['User']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$user['User']['id'], 'label' => '', 'div' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
		<td class="dc grayc">
		  <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
            <ul class="dropdown-menu arrow dl">
			<?php if(Configure::read('user.is_email_verification_for_register') and ($user['User']['is_email_confirmed'] == 0)):?>
					<li><?php echo $this->Html->link('<i class="icon-envelope"></i>' . __l('Resend Activation'), array('controller' => 'users', 'action'=>'resend_activation', $user['User']['id'], 'admin' => false),array('title' => __l('Resend Activation'),'class' =>'js-no-pjax activate-user', 'escape' => false));?>
					</li>
			<?php	endif; ?>
			<li><?php echo $this->Html->link('<i class="icon-edit"></i>' . __l('Edit'), array('controller' => 'user_profiles', 'action'=>'edit', $user['User']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'), 'escape' => false));?></li>
            <?php if($user['User']['role_id'] != ConstUserTypes::Admin){ ?>
                <li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('action'=>'delete', $user['User']['id']), array('class' => 'delete js-confirm', 'title' => __l('Delete'), 'escape' => false));?></li>
            <?php } ?>
			<?php if (empty($user['User']['is_facebook_register']) && empty($user['User']['is_twitter_register']) && empty($user['User']['is_yahoo_register']) && empty($user['User']['is_google_register']) && empty($user['User']['is_googleplus_register']) && empty($user['User']['is_linkedin_register']) && empty($user['User']['is_openid_register'])): ?>
				<li>
				  <?php echo $this->Html->link('<i class="icon-lock"></i>'.__l('Change password'), array('controller' => 'users', 'action'=>'admin_change_password', $user['User']['id']), array('escape'=>false,'title' => __l('Change password')));?>
				</li>
		    <?php endif; ?>
		  </ul>
          </div>
        </td>
		<?php $reg_type_class='';
		$title = '';
		$icon_class = '';
		$icon_img = '';
		if(!empty($user['User']['is_facebook_register'])):
			$icon_class = 'icon-facebook-sign facebookc';
			$title = __l('Facebook');
		elseif(!empty($user['User']['is_twitter_register'])):
			 $icon_class = 'icon-twitter-sign twitterc';
			 $title = __l('Twitter');
		elseif(!empty($user['User']['is_linkedin_register'])):
			 $icon_class = 'icon-linkedin-sign linkedc';
			 $title = __l('LinkedIn');
		elseif(!empty($user['User']['is_google_register'])):
			 $icon_class = 'icon-google-sign googlec';
			 $title = __l('Google');
		elseif(!empty($user['User']['is_googleplus_register'])):
			 $icon_class = 'icon-google-plus-sign googlec';
			 $title = __l('Google+');
		elseif(!empty($user['User']['is_yahoo_register'])):
			 $icon_class = 'icon-yahoo yahooc';
			 $title = __l('Yahoo');
		elseif(!empty($user['User']['is_openid_register'])):
			$icon_img = $this->Html->image('open-id.png', array('title' => __l('OpenId'), 'alt' => __l('[Image: OpenID]') ,'width' => 14, 'height' => 14, 'class' => 'text-12 pull-left no-mar ver-smspace'));
		endif; ?>
		<td>
          <div class="span5 no-mar">
            <div class="clearfix admin_user_avatar"> 
			  <?php echo $this->Html->getUserAvatar($user['User'], 'micro_thumb',true, '', 'admin');?>
			  <?php echo $this->Html->link($this->Html->cText($user['User']['username']), array('controller'=> 'users', 'action' => 'view', $user['User']['username'], 'admin' => false), array('escape' => false, 'class' => 'span4 htruncate grayc'));?>
		    </div>
			<div class="clearfix">
			  <?php if (empty($icon_img)) : ?>
				<i title="<?php echo $title; ?>" class="<?php echo $icon_class;?> text-16 pull-left no-mar"></i>
			  <?php else:
				echo $icon_img;
			  endif;?>
			  <i title="<?php echo $user['User']['email'];?>" class="icon-envelope-alt grayc pull-left ver-smspace <?php echo !empty($icon_img)?'left-smspace':''; ?>"></i><span title="<?php echo $user['User']['email'];?>" class="grayc">
			  <?php
				if (strlen($user['User']['email']) > 20):
					echo '..' . substr($user['User']['email'], strlen($user['User']['email'])-15, strlen($user['User']['email']));
				else:
					echo $user['User']['email'];
				endif;
			?>
			</span>
			</div>
			<div class="clearfix">
				<?php if($user['User']['is_affiliate_user']):?>
				  <span class="label label-warning"><?php echo __l('Affiliate'); ?></span>
				<?php endif; ?>
				<?php if($user['User']['role_id'] == ConstUserTypes::Admin):?>
				  <span class="label label-success"><?php echo __l('Admin'); ?></span>
				<?php endif; ?>
			</div>
		  </div>
        </td>
		<td class="dc grayc"><?php echo $this->Html->link($this->Html->cText($user['ReferredByUser']['username'], false), array('controller'=> 'users', 'action' => 'view', $user['ReferredByUser']['username'], 'admin' => false), array('class' => 'grayc', 'escape' => false));?></td>
		<td class="dr grayc"><?php echo $this->Html->cCurrency($user['User']['available_wallet_amount']); ?></td>
        <td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($user['User']['job_count'], false), array('controller' => 'jobs', 'action' => 'index', 'user_id' => $user['User']['id']), array('class' => 'grayc'));?></td>
		<?php if (isPluginEnabled('Requests')) { ?>
        <td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($user['User']['request_count'], false), array('controller' => 'requests', 'action' => 'index', 'user_id' => $user['User']['id']), array('class' => 'grayc'));?></td>
		<?php } ?>
        <td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($user['User']['user_login_count'], false), array('controller' => 'user_logins', 'action' => 'index', 'username' => $user['User']['username']), array('class' => 'grayc'));?></td>
        <td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($user['User']['user_view_count'], false), array('controller' => 'user_views', 'action' => 'index', 'username' => $user['User']['username']), array('class' => 'grayc'));?></td>
        <td class="dc grayc"><?php echo $this->Html->cInt($user['User']['user_referred_count']);?></td>
		 <?php if (isPluginEnabled('Sudopay')) {?>
		 <td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($user['User']['sudopay_payment_gateways_user_count'], false), array('controller' => 'users', 'action' => 'connnected_payment_gateways', $user['User']['id']));?></td>
		 <?php } ?>
        <td class="dc grayc"><?php echo $this->Html->cDateTimeHighlight($user['User']['created']);?></td>
		<td class="grayc">
          <?php if(!empty($user['Ip']['ip'])): ?>
            <?php echo  $this->Html->link($user['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $user['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$user['Ip']['ip'], 'escape' => false)); ?>
      <p>
      <?php
       if(!empty($user['Ip']['Country'])):
              ?>
              <span class="flags flag-<?php echo strtolower($user['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $user['Ip']['Country']['name']; ?>">
        <?php echo $user['Ip']['Country']['name']; ?>
      </span>
              <?php
            endif;
       if(!empty($user['Ip']['City'])):
            ?>
            <span>   <?php echo $user['Ip']['City']['name']; ?>  </span>
            <?php endif; ?>
            </p>
          <?php else: ?>
      <?php echo __l('n/a'); ?>
    <?php endif; ?>
   </td> 
    </tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="14" class="grayc notice text-16 dc"><?php echo __l('No users available');?></td>
	</tr>
<?php
endif;
?>
<tbody>
</table>
</div>
</div>
<?php
if (!empty($users)):
?>
  <div class="ver-mspace mob-dc clearfix">
    <div class="top-space pull-left dc mob-clr mob-inline clearfix admin-select-block">
       <div class="pull-left ver-space">
			<?php echo __l('Select:'); ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-select {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-smspace grayc', 'title' => __l('Inactive'))); ?>
			<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-smspace grayc', 'title' => __l('Active'))); ?>
		</div>
        <div class="pull-left hor-mspace mob-no-mar">
                <?php echo $this->Form->input('more_action_id', array('class' => 'span4 js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
      </div>
      <div class=" pull-right top-space">
         <?php echo $this->element('paging_links'); ?>
      </div>
	  <div class="hide">
        <?php echo $this->Form->submit('Submit');  ?>
      </div>
	</div>
<?php endif;
echo $this->Form->end();
?>
</div>
</div>
