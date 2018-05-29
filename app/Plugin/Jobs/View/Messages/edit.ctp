<?php /* SVN: $Id: edit.ctp 4216 2010-04-21 12:14:26Z siva_063at09 $ */ ?>
<div class="messages form">
<?php echo $this->Form->create('Message', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('Messages'), array('action' => 'index'),array('title' => __l('Messages')));?> &raquo; <?php echo __l('Edit Message');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('other_user_id');
		echo $this->Form->input('parent_message_id');
		echo $this->Form->input('message_content_id');
		echo $this->Form->input('message_folder_id');
		echo $this->Form->input('is_sender');
		echo $this->Form->input('is_starred');
		echo $this->Form->input('is_read');
		echo $this->Form->input('is_deleted');
		echo $this->Form->input('Label');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>
