<div class="users form js-login-response ajax-login-block">
<div class="forgot-info">
	<?php echo __l('Enter your Email, and we will send you instructions for resetting your password.'); ?>
</div>
<?php
	echo $this->Form->create('User', array('action' => 'forgot_password', 'class' => 'normal form-horizontal  js-ajax-login'));
	echo $this->Form->input('email', array('type' => 'text'));
?>
<div class="clearfix submit-block">
<?php echo $this->Form->submit(__l('Send'));?>	
</div> 
<?php echo $this->Form->end();?>
</div>