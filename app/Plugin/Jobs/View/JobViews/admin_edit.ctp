<?php /* SVN: $Id: $ */ ?>
<div class="jobViews form">
<?php echo $this->Form->create('JobView', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(sprintf(__l('%s Views'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('action' => 'index'));?> &raquo; <?php echo __l('Edit Job View');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('job_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('ip');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>
