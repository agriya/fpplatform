<section class="top-smspace">
<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin && !empty($this->request->prefix)) { ?>
   <ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(__l('Users'), array('controller' => 'users', 'action' => 'index'), array('class' => 'bluec','title'=>__l('Users'))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Change Password');?></li>      
	</ul>    
    <?php } else {
	?>
	<section class="sep-bot top-smspace">
		<div class="container clearfix bot-space">
			<div class="label label-info show text-18 clearfix no-round ver-mspace">
				<div class="span smspace"><?php echo __l("Change Password"); ?></div>
				<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
			</div>
		</div>
	</section>
	<?php
}
?>
</section>

<section class="container">
<?php
	if(empty($this->request->params['prefix'])):
		//echo $this->element('users_edit-profile_link', array('cache' => array('time' => Configure::read('site.element_cache_duration'))));
	endif;
?>
<div class="user-edit-form-block top-space top-mspace">
<?php
	echo $this->Form->create('User', array('action' => 'change_password' ,'class' => 'normal form-horizontal top-space '));
	if($this->Auth->user('role_id') == ConstUserTypes::Admin) :
    	echo $this->Form->input('user_id', array('empty' => 'Select'));
    endif;
    if($this->Auth->user('role_id') != ConstUserTypes::Admin) :
        echo $this->Form->input('user_id', array('type' => 'hidden'));
    	echo $this->Form->input('old_password', array('type' => 'password','label' => __l('Old password') ,'id' => 'old-password'));
    endif;
    echo $this->Form->input('passwd', array('type' => 'password','label' => __l('New password') , 'id' => 'new-password'));
	echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => __l('Confirm Password')));
    ?>
    <div class="submit-block clearfix">
    <?php
    echo $this->Form->submit(__l('Change password'), array('class'=>'btn btn-primary'));
?>
</div>
<?php
	echo $this->Form->end();
?>
</div>
</section>