<?php /* SVN: $Id: admin_edit.ctp 4216 2010-04-21 12:14:26Z siva_063at09 $ */ ?>
<div class="userMessagePreferences form">
<?php echo $this->Form->create('UserMessagePreference', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('User Message Preferences'), array('action' => 'index'),array('title' => __l('User Message Preferences')));?> &raquo; <?php echo __l('Edit User Message Preference');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('is_allow_send');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>
