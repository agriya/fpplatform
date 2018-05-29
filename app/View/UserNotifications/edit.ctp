<?php /* SVN: $Id: $ */ ?>
<section class="sep-bot top-smspace">
	<div class="container clearfix bot-space">
		<div class="label label-info show text-18 clearfix no-round ver-mspace">
			<div class="span smspace"><?php echo __l('Manage Email Settings'); ?></div>
			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
	</div>
</section>
<section class="container top-space">

<?php
	//echo $this->element('users_edit-profile_link', array('cache' => array('time' => Configure::read('site.element_cache_duration'))));
?>
<div class="userNotifications form">
<?php echo $this->Form->create('UserNotification', array('action' => 'edit', 'class' => 'normal top-mspace'));?>
	<fieldset>
	<?php
		if($this->Auth->user('role_id') == ConstUserTypes::Admin):
			echo $this->Form->input('id');
		endif;
	?>
	<table class="table table-striped table-hover sep">
		<tr>
			<th class='dl'><?php echo __l('Seller');?></th>
			<th class='dl'><?php echo __l('Buyer');?></th>
		</tr>
		<tr>
			<td class='dl'><?php echo $this->Form->input('is_new_order_seller_notification', array('label' => __l('Send notification when you receive an order')));?></td>
			<td class='dl'><?php echo $this->Form->input('is_new_order_buyer_notification', array('label' => __l('Send notification when you make an order')));?></td>
		</tr>
		<tr>
			<td class='dl'><?php echo $this->Form->input('is_accept_order_seller_notification', array('label' => __l('Send notification when you accept an order')));?></td>
			<td class='dl'><?php echo $this->Form->input('is_accept_order_buyer_notification', array('label' => __l('Send notification when your order was accepted')));?></td>
		</tr>
		<tr>
			<td class='dl'><?php echo $this->Form->input('is_review_order_seller_notification', array('label' => __l('Send notification when you complete your order and waiting for buyers review')));?></td>
			<td class='dl'><?php echo $this->Form->input('is_review_order_buyer_notification', array('label' => __l('Send notification when your order was completed and waiting for your review')));?></td>
		</tr>
		<tr>
			<td class='dl'><?php echo $this->Form->input('is_admin_cancel_order_seller_notification', array('label' => __l('Send notification when your').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('ordered by a buyer was cancelled by admin')));?></td>
			<td class='dl'><?php echo $this->Form->input('is_admin_cancel_buyer_notification', array('label' => __l('Send notification when the order made by you was cancelled by admin')));?></td>
		</tr>
		<tr>
			<td class='dl'><?php echo $this->Form->input('is_complete_order_seller_notification', array('label' => __l('Send notification when your order was reviewed by the buyer')));?></td>
			<td class='dl'><?php echo $this->Form->input('is_complete_order_buyer_notification', array('label' => __l('Send notification when you make an review for an order'))); ?></td>
		</tr>
		<tr>
			<td class='dl'><?php echo $this->Form->input('is_complete_later_order_seller_notification', array('label' => __l('Send notification when your order was auto reviewed by the admin when buyer doesn\'t make the review')));?></td>
			<td class='dl'><?php echo $this->Form->input('is_complete_later_order_buyer_notification', array('label' => __l('Send notification when admin makes the review, when you are unable to make an review for your order'))); ?></td>
		</tr>
		<tr>
			<td class='dl'><?php echo $this->Form->input('is_expire_order_seller_notification', array('label' => __l('Send notification when your').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('ordered by a buyer was expired on non-acceptance by you')));?></td>
			<td class='dl'><?php echo $this->Form->input('is_expire_order_buyer_notification', array('label' => __l('Send notification when the order made by you was expired on non-acceptance by the seller')));?></td>
		</tr>
		<tr>
			<td class='dl'><?php echo $this->Form->input('is_cancel_order_seller_notification', array('label' => __l('Send notification when your').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('ordered was cancelled by the buyer')));?></td>
			<td class='dl'><?php echo $this->Form->input('is_cancel_order_buyer_notification', array('label' => __l('Send notification when you cancel the order made by you')));?></td>
		</tr>
		<tr>
			<td class='dl'><?php echo $this->Form->input('is_reject_order_seller_notification', array('label' => __l('Send notification when you reject an order')));?></td>
			<td class='dl'><?php echo $this->Form->input('is_reject_order_buyer_notification', array('label' => __l('Send notification when your order was rejected by the seller')));?></td>
		</tr>
		<tr>
			<td class='dl'><?php echo $this->Form->input('is_cleared_notification', array('label' => __l('Send notification when your amount for the order was cleared for withdrawal')));?></td>
			<td><?php echo '-';?></td>
		</tr>
		<tr>
			<td colspan='2' class='dl'><?php echo $this->Form->input('is_in_progress_overtime_notification', array('label' => __l('Send notification when your order has not completed within the').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('completion date')));?></td>
		</tr>
		<tr>
			<td colspan='2' class='dl'><?php echo $this->Form->input('is_recieve_dispute_notification', array('label' => __l('Email me when i receive dispute related messages')));?></td>
		</tr>
		<tr>
			<td colspan='2' class='dl'><?php echo $this->Form->input('is_recieve_mutual_cancel_notification', array('label' => __l('Email me when i receive mutual cancel related messages')));?></td>
		</tr>
		<tr>
			<td colspan='2' class='dl'><?php echo $this->Form->input('is_receive_redeliver_notification', array('label' => __l('Email me when i receive redeliver related messages')));?></td>
		</tr>
		<tr>
			<td colspan='2' class='dl'><?php echo $this->Form->input('is_contact_notification', array('label' => __l('Send notification when you have contacted by other users')));?></td>
		</tr>
		<!--<tr>
			<td colspan='2' class='dl'>
				<div>
					<h4>Email me, when i receive</h4>
					<div>
						<ul>
							<li><?//php echo $this->Form->input('is_in_progress_overtime_notification', array('label' => __l('Send notification when your order has not completed within the').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('completion date')));?></li>
							<li><?//php echo $this->Form->input('is_recieve_dispute_notification', array('label' => __l('Email me when i receive dispute related messages')));?></li>
							<li><?//php echo $this->Form->input('is_recieve_mutual_cancel_notification', array('label' => __l('Email me when i receive mutual cancel related messages')));?></li>
							<li><?//php echo $this->Form->input('is_receive_redeliver_notification', array('label' => __l('Email me when i receive redeliver related messages')));?></li>
							<li><?//php echo $this->Form->input('is_contact_notification', array('label' => __l('Send notification when you have contacted by other users')));?></li>
						</ul>
					</div>				
				</div>
			</td>
		</tr>-->
	</table>
</fieldset>
<div class="well no-bor no-shad clearfix dc">
<?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-warning textb btn-large text-20'));?>
</div>
<?php echo $this->Form->end();?>
</div>
</section>