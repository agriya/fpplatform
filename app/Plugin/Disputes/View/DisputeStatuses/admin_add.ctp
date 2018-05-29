<?php /* SVN: $Id: $ */ ?>
<div class="disputeStatuses form">
<?php echo $this->Form->create('DisputeStatus', array('class' => 'form-horizontal normal'));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('Dispute Statuses'), array('action' => 'index'));?> &raquo; <?php echo __l('Add Dispute Status');?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
