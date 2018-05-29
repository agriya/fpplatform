<?php /* SVN: $Id: $ */ ?>
<div class="disputeClosedTypes form">
<?php echo $this->Form->create('DisputeClosedType', array('class' => 'form-horizontal normal'));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('Dispute Closed Types'), array('action' => 'index'));?> &raquo; <?php echo __l('Add Dispute Closed Type');?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
