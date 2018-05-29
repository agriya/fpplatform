<?php /* SVN: $Id: admin_edit.ctp 4216 2010-04-21 12:14:26Z siva_063at09 $ */ ?>
<div class="targetFileTypes form">
<?php echo $this->Form->create('TargetFileType', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('Target File Types'), array('action' => 'index'),array('title' => __l('Target File Types')));?> &raquo; <?php echo __l('Edit Target File Type');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('extension');
     	echo $this->Form->input('is_active', array('label' => __l('Active')));
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>