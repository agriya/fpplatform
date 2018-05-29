<?php /* SVN: $Id: admin_add.ctp 4507 2010-05-03 13:34:54Z josephine_065at09 $ */ ?>
<div class="disputeTypes form">
<?php echo $this->Form->create('DisputeType', array('class' => 'form-horizontal normal'));?>
	<h2><?php echo __l('Add Dispute Type');?></h2>
	<?php
	    echo $this->Form->input('name');
        echo $this->Form->input('job_user_type_id');
		echo $this->Form->input('is_active',array('checked' => 'checked'));
	?>
	<div class="clearfix submit-block">
			<?php echo $this->Form->submit(__l('Add'));?>
		</div>

	<?php echo $this->Form->end(); ?>
</div>