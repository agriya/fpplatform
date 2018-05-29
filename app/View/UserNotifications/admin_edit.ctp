<?php /* SVN: $Id: $ */ ?>
<div class="userNotifications form">
<?php echo $this->Form->create('UserNotification', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('User Notifications'), array('action' => 'index'));?> &raquo; <?php echo __l('Edit User Notification');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('is_new_order_buyer_notification');
		echo $this->Form->input('is_new_order_seller_notification');
		echo $this->Form->input('is_accept_order_seller_notification');
		echo $this->Form->input('is_accept_order_buyer_notification');
		echo $this->Form->input('is_reject_order_seller_notification');
		echo $this->Form->input('is_reject_order_buyer_notification');
		echo $this->Form->input('is_cancel_order_seller_notification');
		echo $this->Form->input('is_cancel_order_buyer_notification');
		echo $this->Form->input('is_review_order_seller_notification');
		echo $this->Form->input('is_review_order_buyer_notification');
		echo $this->Form->input('is_complete_order_seller_notification');
		echo $this->Form->input('is_complete_order_buyer_notification');
		echo $this->Form->input('is_expire_order_seller_notification');
		echo $this->Form->input('is_expire_order_buyer_notification');
		echo $this->Form->input('is_admin_cancel_order_seller_notification');
		echo $this->Form->input('is_admin_cancel_buyer_notification');
		echo $this->Form->input('is_cleared_notification');
		echo $this->Form->input('is_contact_notification');
		echo $this->Form->input('is_in_progress_overtime_notification');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>
