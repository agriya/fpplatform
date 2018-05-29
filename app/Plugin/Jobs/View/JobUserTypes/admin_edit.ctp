<?php /* SVN: $Id: $ */ ?>
<div class="jobUserTypes form">
<?php echo $this->Form->create('JobUserType', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('Job User Types'), array('action' => 'index'));?> &raquo; <?php echo __l('Edit Job User Type');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>
