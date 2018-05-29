<?php /* SVN: $Id: $ */ ?>
<div class="jobTypes form">
<?php echo $this->Form->create('JobType', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('Job Types'), array('action' => 'index'));?> &raquo; <?php echo __l('Edit Job Type');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>
