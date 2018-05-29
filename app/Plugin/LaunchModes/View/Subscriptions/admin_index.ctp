<div class="projectRatings index js-response">
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
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::AffiliateUser) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Affiliate Users') . '</dt><dd title="' . $affiliate_user_count . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($affiliate_user_count) . '</dd>  </dl>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::AffiliateUser), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Affiliate Users'), 'escape' => false));?>	
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
  <?php   echo $this->Form->create('Subscription' , array('class' => 'normal ','action' => 'update'));?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<section class="space">
<div class="tab-pane active in no-mar" id="active-users">
  <div class="sep bot-mspace img-rounded clearfix">
     <table class="table no-mar table-striped table-hover">
		<thead>
	  <tr class="no-mar no-pad">
      <th class="dc sep-right textn"><?php echo __l('Select'); ?></th>
      <th class="dc sep-right textn"><?php echo __l('Actions');?></th>
      <th class="dc sep-right textn"><div><?php echo $this->Paginator->sort('email', __l('Email'), array('class' => 'graydarkerc no-under'));?></div></th>
      <th class="dc sep-right textn"><?php echo $this->Paginator->sort('is_sent_private_beta_mail', __l('Invitation Sent'), array('class' => 'graydarkerc no-under')); ?></th>
      <th class="dc sep-right textn"><?php echo __l('Registered');?></th>
      <th class="dc sep-right textn"><?php echo __l('From Friends Invite');?></th>
      <th class="dc sep-right textn"><span class="clearfix"><?php echo __l('Invitation to Friends');?></span><br /><span class="clearfix"><?php echo __l('Registered');?>&nbsp;/&nbsp;<?php echo __l('Invited');?>&nbsp;/&nbsp;<?php echo __l('Allowed invitation');?></span></th>
      <th class="dc sep-right textn"><?php echo __l('Subscribed On');?></th>
      <th class="dc sep-right textn"><?php echo $this->Paginator->sort('ip_id', __l('IP'), array('class' => 'graydarkerc no-under')); ?></th>
      </tr>
	  </thead>
      <?php
        if (!empty($subscriptions)):
          foreach ($subscriptions as $subscription):
            if($subscription['Subscription']['is_email_verified'] == '1')  :
              $status_class = 'js-checkbox-active';
              $disabled = '';
            else:
              $status_class = 'js-checkbox-inactive';
              $disabled = 'class="disabled"';
            endif;
      ?>
      <tr >
	  <td class="dc grayc"><?php echo $this->Form->input('Subscription.'.$subscription['Subscription']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$subscription['Subscription']['id'], 'label' => '', 'div' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>

      <td class="span1 dc">
	  <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
             <ul class="unstyled dropdown-menu dl arrow clearfix">
            <li>
              <?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $subscription['Subscription']['id']), true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
            </li>
          <?php if(Configure::read('site.launch_mode') == 'Private Beta' && empty($subscription['Subscription']['is_sent_private_beta_mail']))   { ?>
            <li>
              <?php echo $this->Html->link('<i class="icon-envelope"></i>'.__l('Send Invitation Code'), Router::url(array('action'=>'send_invitation', $subscription['Subscription']['id']), true).'?r='.$this->request->url, array('escape'=>false, 'title' => __l('Send Invitation Code')));?>
            </li>
          <?php }  ?>
          </ul>
          </div>

      </td>
      <td><?php echo $this->Html->cText($subscription['Subscription']['email'],false);?></td>
      <td class="dc"><?php echo $this->Html->cBool($subscription['Subscription']['is_sent_private_beta_mail'],false);?></td>
      <?php if(!empty($subscription['User']['id'])) { ?>
      <td class="span4 dl">
        <div class="row-fluid">
          <div class="span6"><?php echo $this->Html->getUserAvatar($subscription['User'], 'micro_thumb',true, '', 'admin');?></div>
          <div class="span12 vtop hor-smspace">
		  <?php echo $this->Html->link($this->Html->cText($subscription['User']['username']), array('controller'=> 'users', 'action' => 'view', $subscription['User']['username'], 'admin' => false), array('escape' => false, 'class' => 'span5 htruncate grayc'));?>
		  </div>
        </div>
      </td>
      <?php } else { ?>
      <td class="dc"><?php echo $this->Html->cBool(($subscription['User']['id'])?'1':'0',false);?></td>
      <?php } ?>
      <?php if(!empty($subscription['Subscription']['invite_user_id'])) { ?>
      <td class="span4 dl">
        <div class="row-fluid">
          <div class="span6"><?php echo $this->Html->getUserAvatar($subscription['InviteUser'], 'micro_thumb',true, '', 'admin');?></div>
          <div class="span12 vtop hor-smspace">
		   <?php echo $this->Html->link($this->Html->cText($subscription['InviteUser']['username']), array('controller'=> 'users', 'action' => 'view', $subscription['InviteUser']['username'], 'admin' => false), array('escape' => false, 'class' => 'span5 htruncate grayc'));?>
		  </div>
        </div>
      </td>
      <?php } else { ?>
         <td class="dc"><?php echo __l('No');?></td>
      <?php } ?>
      <td class="dc">
      <?php
        $no_of_users_to_invite = Configure::read('site.no_of_users_to_invite');
        $no_of_users_to_invite = (!empty($no_of_users_to_invite))?$no_of_users_to_invite:'-';
        $invite_count = empty($subscription['User']['invite_count'])?'0':$subscription['User']['invite_count'];
        echo $this->Html->cText($this->App->getUserInvitedFriendsRegisteredCount($subscription['User']['id']). ' / ' . $invite_count . ' / ' .  $no_of_users_to_invite, false);
      ?>
      </td>
      <td class="dc"><?php echo $this->Html->cDateTimeHighlight($subscription['Subscription']['created']);?></td>
      <td class="dl">
        <?php if(!empty($subscription['Ip']['ip'])): ?>
        <?php echo  $this->Html->link($subscription['Ip']['ip'], array('controller' => 'subscriptions', 'action' => 'whois', $subscription['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$subscription['Ip']['ip'], 'escape' => false));
        ?>
        <p>
        <?php
        if(!empty($subscription['Ip']['Country'])):
        ?>
        <span class="flags flag-<?php echo strtolower($subscription['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $subscription['Ip']['Country']['name']; ?>">
        <?php echo $subscription['Ip']['Country']['name']; ?>
        </span>
        <?php
        endif;
        if(!empty($subscription['Ip']['City'])):
        ?>
        <span>   <?php echo $subscription['Ip']['City']['name']; ?>  </span>
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
      <td colspan="10" class="grayc text-16 notice dc"><?php echo sprintf(__l('No %s available'), __l('Users'));?></td>
    </tr>
      <?php
      endif;
      ?>
  </table>
  </div>
  </div>
</section>
<section class="clearfix hor-mspace bot-space">
    <?php if (!empty($subscriptions)): ?>
          <div class="ver-space pull-left">
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"}','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"}','title' => __l('None'))); ?>
          </div>
          <div class="admin-checkbox-button pull-left hor-space">
            <div class="input select">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
            </div>
          </div>
          <div class="pull-right">
            <?php echo $this->element('paging_links'); ?>
          </div>
      <div class="hide"><?php echo $this->Form->submit('Submit');  ?></div>
</section>
    <?php endif; ?>
  <?php echo $this->Form->end(); ?>
</div>