<div class="sep-bot bot-mspace">
  <h2 class="container text-32 bot-space mob-dc"><?php echo __l('Security Question'); ?></h2>
</div>
<section class="container clearfix ver-space">
	<?php
	  echo $this->Form->create('User', array('action' => 'reset/'.$user_id.'/'.$hash ,'class' => 'form-horizontal'));
	  echo $this->Form->input('user_id', array('type' => 'hidden'));
	  echo $this->Form->input('hash', array('type' => 'hidden'));
	  if(isPluginEnabled('SecurityQuestions')) {
		echo $this->Form->input('security_answer', array('label' => $security_questions['SecurityQuestion']['name'], 'id' => 'security_answer', 'autocomplete' => 'off'));
	  }
	?>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Submit'), array('class'=>'btn btn-primary')); ?>
	</div>
	<?php echo $this->Form->end(); ?>
</section>