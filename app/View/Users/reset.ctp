<div class="sep-bot bot-mspace"><h2  class="container text-32 bot-space mob-dc"><?php echo __l('Reset your password');?></h2></div>
<section class="container clearfix ver-space">
<?php
	echo $this->Form->create('User', array('action' => 'reset/'.$user_id.'/'.$hash ,'class' => 'normal form-horizontal '));
	echo $this->Form->input('user_id', array('type' => 'hidden'));
	echo $this->Form->input('hash', array('type' => 'hidden'));
	echo $this->Form->input('passwd', array('type' => 'password','label' => __l('New password') ,'id' => 'password'));
	echo $this->Form->input('confirm_password', array('type' => 'password','label' => __l('Confirm Password')));
    ?>
    <div class="submit-block clearfix">
<?php

	echo $this->Form->submit(__l('Change password'), array('class'=>'btn btn-primary'));
?>
</div>
<?php echo $this->Form->end(); ?>
</section>