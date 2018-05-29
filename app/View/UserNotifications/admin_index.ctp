<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userNotifications index">
<h2><?php echo __l('User Notifications');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($userNotifications)):

$i = 0;
foreach ($userNotifications as $userNotification):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $this->Html->cInt($userNotification['UserNotification']['id']);?></p>
		<p><?php echo $this->Html->cDateTime($userNotification['UserNotification']['created']);?></p>
		<p><?php echo $this->Html->cDateTime($userNotification['UserNotification']['modified']);?></p>
		<p><?php echo $this->Html->link($this->Html->cText($userNotification['User']['username']), array('controller'=> 'users', 'action' => 'view', $userNotification['User']['username']), array('escape' => false));?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_new_order_buyer_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_new_order_seller_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_accept_order_seller_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_accept_order_buyer_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_reject_order_seller_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_reject_order_buyer_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_cancel_order_seller_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_cancel_order_buyer_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_review_order_seller_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_review_order_buyer_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_complete_order_seller_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_complete_order_buyer_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_expire_order_seller_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_expire_order_buyer_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_admin_cancel_order_seller_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_admin_cancel_buyer_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_cleared_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_contact_notification']);?></p>
		<p><?php echo $this->Html->cBool($userNotification['UserNotification']['is_in_progress_overtime_notification']);?></p>
		<div class="actions"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $userNotification['UserNotification']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $userNotification['UserNotification']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No User Notifications available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($userNotifications)) {
    echo $this->element('paging_links');
}
?>
</div>
