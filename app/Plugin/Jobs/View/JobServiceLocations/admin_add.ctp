<?php /* SVN: $Id: $ */ ?>
<div class="jobServiceLocations form">
<?php echo $this->Form->create('JobServiceLocation', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('Job Service Locations'), array('action' => 'index'));?> &raquo; <?php echo __l('Add Job Service Location');?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('job_count');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
