<?php /* SVN: $Id: admin_add.ctp 4507 2010-05-03 13:34:54Z josephine_065at09 $ */ ?>
<div class="users form">
<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(__l('Users'), array('controller' => 'users', 'action' => 'index'), array('class' => 'bluec','title'=>__l('Users'))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Add User');?></li>      
	</ul>
<?php echo $this->Form->create('User', array('class' => 'normal form-horizontal '));?>
	<?php
        echo $this->Form->input('role_id', array('label' => __l('User Type'), 'options' => $userTypes));
		echo $this->Form->input('email');
		echo $this->Form->input('username');
		echo $this->Form->input('passwd', array('label' => __l('Password')));
	?>
	<div class="clearfix submit-block">
			<?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-primary'));?>
		</div>

	<?php echo $this->Form->end(); ?>
</div>