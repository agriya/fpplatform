<?php /* SVN: $Id: edit.ctp 4216 2010-04-21 12:14:26Z siva_063at09 $ */ ?>
<div class="userMessagePreferences form">
<?php echo $this->Form->create('UserMessagePreference', array('class' => 'normal form-horizontal ', 'action' => 'edit'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		if ($admin_settings['AdminPrivacySetting']['is_allow_send_in_message'] and $admin_settings['AdminPrivacySetting']['is_allow_privacy_for_message']) :
			echo $this->Form->input('is_allow_send', array('options' => $privacy_types, 'label' => 'Yoc can receive message from'));
        endif;
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>
