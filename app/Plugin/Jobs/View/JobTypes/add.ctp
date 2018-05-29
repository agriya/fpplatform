<?php /* SVN: $Id: $ */ ?>
<div class="jobTypes form">
<?php echo $this->Form->create('JobType', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('Job Types'), array('action' => 'index'));?> &raquo; <?php echo __l('Add Job Type');?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('job_count');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
