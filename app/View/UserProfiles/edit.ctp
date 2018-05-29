<?php /* SVN: $Id: edit.ctp 4895 2010-05-13 08:49:37Z josephine_065at09 $ */ ?>
<div class="bot-mspace">
<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin && !empty($this->request->prefix)) { ?>
	<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(__l('Users'), array('controller' => 'users', 'action' => 'index'), array('class' => 'bluec','title'=>__l('Users'))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Edit');?></li>      
	</ul>
<?php } else {
	?>
	<section class="sep-bot top-smspace">
		<div class="container clearfix bot-space">
			<div class="label label-info show text-18 clearfix no-round ver-mspace">
				<div class="span smspace"><?php echo __l("Edit Profile"); ?></div>
				<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
			</div>
		</div>
	</section>
	<?php
}
?>
	<?php
		//echo $this->element('users_edit-profile_link', array('cache' => array('time' => Configure::read('site.element_cache_duration'))));
	?>
</div>
<div class="<?php echo empty($this->request->prefix)?'container':''; ?>">
<div>
	<?php echo $this->Form->create('UserProfile', array('action' => 'edit', 'class' => 'normal form-horizontal  js-add-map', 'enctype' => 'multipart/form-data'));?>
   <fieldset class="form-block round-5 clearfix">
		<legend class="round-5">
		   <?php echo __l('Profile'); ?>
		</legend>
         <div class="span3 pull-right">
            <div class="span"><?php echo $this->Html->getUserAvatarLink($this->request->data['User'], 'small_big_thumb', true);?> <?php //echo $this->Html->getUserAvatar($this->request->data['User'], 'small_big_thumb'); ?></div>
			<?php if (isPluginEnabled('SocialMarketing')): ?>
				<div class="span"><?php echo $this->Html->link(__l('Change Image'), array('controller' => 'user_profiles', 'action' => 'profile_image',$this->request->data['User']['id'], 'admin' => false)); ?></div>
			<?php endif; ?>
         </div>
<div class="clearfix pull-left">
		<?php
			if($this->Auth->user('role_id') == ConstUserTypes::Admin):
				echo $this->Form->input('User.id');
			endif;
			if($this->request->data['User']['role_id'] == ConstUserTypes::Admin):
				echo $this->Form->input('User.username',array('readonly' => 'readonly'));
			endif;
			echo $this->Form->input('full_name', array('label' => __l('Full Name')));
			if($this->Auth->user('role_id') == ConstUserTypes::Admin):
				echo $this->Form->input('User.email');
			endif;            
			echo $this->Form->input('about_me', array('label' => __l('About Me'), 'class' => 'span17'));
			if (!isPluginEnabled('SocialMarketing')):
				echo $this->Form->input('UserAvatar.filename', array('type' => 'file', 'label' => __l('Upload Photo'),'class' =>'browse-field'));
			endif;
		?>
		<!-- <div class="profile-image">
            <?php echo $this->Html->link($this->Html->showImage('UserAvatar', $this->request->data['UserAvatar'], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($this->request->data['User']['username'], false)), 'title' => $this->Html->cText($this->request->data['User']['username'], false))), array('controller' => 'users', 'action' => 'view',  $this->request->data['User']['username'], 'admin' => false), array('escape' => false)); ?>
		</div> -->
		</div>
	</fieldset>
   <fieldset class="form-block round-5">
		<legend class="round-5">
		   <?php echo __l('Contact details'); ?>
		</legend>
		<?php
			echo $this->Form->input('contact_address', array('id' => 'JobAddress', 'label' => __l('Address')));
			echo $this->Form->input('mobile_phone', array('label' => __l('Mobile'))); 
			echo $this->Form->input('latitude', array('id' => 'JobLatitude', 'type' => 'hidden', 'value' => ($this->request->data['UserProfile']['latitude'] ? $this->request->data['UserProfile']['latitude'] :'37.4419')));
			echo $this->Form->input('longitude', array('id' => 'JobLongitude', 'type' => 'hidden','value' => ($this->request->data['UserProfile']['longitude'] ? $this->request->data['UserProfile']['longitude'] :'-122.1419')));
			echo $this->Form->input('zoom_level', array('id' => 'JobZoomLevel', 'type' => 'hidden','value' => ($this->request->data['UserProfile']['zoom_level'] ? $this->request->data['UserProfile']['zoom_level'] :'4')));	
		?>
		<div class="show-map hide" style="">				
			<div id="js-map-container"></div>
		</div>
	</fieldset>
	<?php if(isPluginEnabled('SecurityQuestions') && $this->request->data['User']['security_question_id'] == 0 && $this->Auth->user('role_id') != ConstUserTypes::Admin): ?>
	<?php if(empty($this->request->data['User']['is_openid_register']) && empty($this->request->data['User']['is_google_register']) && empty($this->request->data['User']['is_yahoo_register']) && empty($this->request->data['User']['is_facebook_register']) && empty($this->request->data['User']['is_twitter_register']) && empty($this->request->data['User']['is_linkedin_register']) && empty($this->request->data['User']['is_googleplus_register'])):?>
    <fieldset class="form-block round-5">
        <legend class="round-5 "><?php echo __l('Security Question'); ?></legend>
        <div class="alert alert-info clearfix">
       <div class="page-information clearfix"> <?php

      echo sprintf(__l('Setting a security question helps us to identify you as the owner of your %s account.'),Configure::read('site.name'));
    ?></div>
        </div>
        <div class="clearfix">
        <?php
      echo $this->Form->input('User.security_question_id',array('id'=>'js-security_question_id', 'empty' => __l('Please select questions')));
      echo $this->Form->input('User.security_answer', array('label' => __l('Answer')));
    ?>
        </div>
      </fieldset>
	  
<?php endif; ?>
	<?php
	endif;
		if($this->Auth->user('role_id') == ConstUserTypes::Admin):
			echo $this->Form->input('User.is_active', array('label' => __l('Active')));
		endif;
	?>
	<div class="submit-block well no-bor no-round dr clearfix">
	<?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-warning textb btn-large text-20'));?>
</div>
<?php echo $this->Form->end();?>
</div>
</div>