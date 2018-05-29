<div class="js-responses">

	<div class="alert alert-info clearfix"><?php echo __l('You need to enter the verification code you got from buyer to complete your work');?></div>

	<div class="option-block clearfix">
		<?php echo $this->Form->create('JobOrder', array('action' => 'verify_work', 'class' => 'normal form-horizontal  js-ajax-form')); ?>
		<?php
			echo $this->Form->input('verification_code');
			echo $this->Form->input('id', array('type' => 'hidden'));
		?>
		<div class="submit-block clearfix">
			<?php echo $this->Form->submit(__l('Continue'), array('class'=>'btn btn-primary'));?>
		</div>
	<?php echo $this->Form->end();?>
	</div>

</div>