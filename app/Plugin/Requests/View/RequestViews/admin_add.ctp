<?php /* SVN: $Id: $ */ ?>
<div class="requestViews form">
<?php echo $this->Form->create('RequestView', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(sprintf(__l('%s Views'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)), array('action' => 'index'));?> &raquo; <?php echo __l('Add Request View');?></legend>
	<?php
		echo $this->Form->input('request_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('ip');
		echo $this->Form->input('host');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
