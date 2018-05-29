<?php 
if(!empty($this->request->params['named']['job_order_id']) && empty($job_order_id)):
	$job_order_id = $this->request->params['named']['job_order_id'];
endif;
if(!empty($this->request->params['named']['job_type_id'])):
	$job_type_id = $this->request->params['named']['job_type_id'];
endif;
?>
<?php $container = (!empty($this->request->params['named']['selected']) && $this->request->params['named']['selected'] == 'no')?'':'container';  ?>
<div class="secondary-bg no-round top-space">
<div class="<?php echo $container; ?> clearfix xltriggered"  id="ajax-tab-container-review-tabs">
  <ul id="Tab" class="nav nav-tabs no-bor top-mspace activities-tab">
  <?php if(empty($is_under_dispute)):?>
			<?php if(($order_status_id == ConstJobOrderStatus::InProgress || $order_status_id == ConstJobOrderStatus::InProgressOvertime || $order_status_id == ConstJobOrderStatus::Redeliver) && $this->request->params['named']['type'] == 'myworks'):?>
	    <li class="text-16 span8 no-bor dc no-mar">
		<?php
					if($job_type_id == ConstJobType::Offline):
						echo $this->Html->link('<span class="show ver-space">'.__l('Verify Order').'</span>', array('controller' => 'job_orders', 'action' => 'verify_work', 'job_order_id' => $job_order_id), array('data-toggle' =>'tab', 'data-target' =>'#verify-order', 'title' => __l('Verify Order'), 'escape' => false, 'class'=>'js-no-pjax'));
					else:
						echo $this->Html->link('<span class="show ver-space">'.__l('Deliver Order').'</span>', array('controller' => 'messages', 'action' => 'compose', 'job_order_id' => $job_order_id, 'order' => 'deliver', 'view_type' => 'simple-deliver'), array('data-toggle' =>'tab', 'data-target' =>'#deliver-order', 'title' => __l('Deliver Order'), 'escape' => false, 'class'=>'js-no-pjax'));
					endif;
		?>
		</li>
	<?php endif;?>
	<?php if($order_status_id == ConstJobOrderStatus::WaitingforReview && (empty($this->request->params['named']['type']) || $this->request->params['named']['type'] != 'myworks')):?>
		<li class="text-16 span8 no-bor dc no-mar active first-child"><?php echo $this->Html->link('<span class="show ver-space">'.__l('Want to Close').'</span>', array('controller' => 'job_feedbacks', 'action' => 'add', 'job_order_id' => $job_order_id, 'view_type' => 'simple-feedback','selected' => 'want_to_close'), array('title' => __l('Want to close'),'data-toggle' =>'tab', 'data-target' =>'#want-to-close', 'escape' => false, 'class'=>'js-no-pjax')); ?></li>
	<?php if($job_type_id == ConstJobType::Online):?>
		<li class="text-16 span8 no-bor dc no-mar"><?php echo $this->Html->link('<span class="show ver-space">'.__l('Request Improvement').'</span>', array('controller' => 'job_orders', 'action' => 'manage', 'job_order_id' => $job_order_id, 'view_type' => 'simple-feedback','selected' => 'redeliver'), array('title' => __l('Request Improvement'), 'data-toggle' =>'tab', 'data-target' =>'#request-improvement', 'escape' => false, 'class'=>'js-no-pjax')); ?></li>
			<?php endif;?>
		<?php endif;?>
	<?php endif;?>
		<?php if(empty($is_under_dispute)):?>
			<?php if($order_status_id == ConstJobOrderStatus::WaitingforReview && !empty($is_redeliver_request) && $this->request->params['named']['type'] != 'myorders' && $job_type_id == ConstJobType::Online):?>
				<li class="text-16 span8 no-bor dc no-mar active"><?php echo $this->Html->link('<span class="show ver-space">'.__l('Request Improvement').'</span>', array('controller' => 'job_orders', 'action' => 'manage', 'job_order_id' => $job_order_id, 'view_type' => 'simple-feedback','selected' => 'redeliver'), array('title' => __l('Request Improvement'), 'data-toggle' =>'tab', 'data-target' =>'#request-improvement', 'escape' => false, 'class'=>'js-no-pjax')); ?></li>
			<?php endif;?>
		<?php endif;?>
		<?php if($order_status_id == ConstJobOrderStatus::InProgress || $order_status_id == ConstJobOrderStatus::InProgressOvertime || $order_status_id == ConstJobOrderStatus::Redeliver || $order_status_id == ConstJobOrderStatus::WaitingforReview):?>
			<li class="text-16 span8 no-bor dc no-mar"><?php echo $this->Html->link('<span class="show ver-space">'.__l('Mutual Cancel').'</span>', array('controller' => 'job_orders', 'action' => 'manage', 'job_order_id' => $job_order_id, 'view_type' => 'simple-feedback','selected' => 'mutual_cancel'), array('title' => __l('Mutual Cancel'), 'data-toggle' =>'tab', 'data-target' =>'#mutual-cancel', 'escape' => false, 'class'=>'js-no-pjax')); ?></li>
		<?php endif;?>
		<?php if (isPluginEnabled('Disputes')) :  ?> 
			<li class="text-16 span8 no-bor dc no-mar"><?php echo $this->Html->link('<span class="show ver-space">'.__l('Dispute').'</span>', array('controller' => 'job_orders', 'action' => 'manage', 'job_order_id' => $job_order_id, 'view_type' => 'simple-feedback','selected' => 'dispute'), array('title' => __l('Dispute'), 'data-toggle' =>'tab', 'data-target' =>'#dispute', 'escape' => false, 'class'=>'js-no-pjax')); ?></li>
		<?php endif; ?>
  </ul>


<div class="<?php echo $container; ?> tab-content top-space top-mspace" id="TabContent">
	<?php if(($order_status_id == ConstJobOrderStatus::InProgress || $order_status_id == ConstJobOrderStatus::InProgressOvertime || $order_status_id == ConstJobOrderStatus::Redeliver) && $this->request->params['named']['type'] == 'myworks'):?>
		<div class="tab-pane" id="verify-order">
			<div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
		</div>
		<div class="tab-pane" id="deliver-order">
			<div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
		</div>
	<?php endif; ?>
	<div class="tab-pane" id="want-to-close">
		<div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
	</div>
	<div class="tab-pane" id="request-improvement">
		<div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
	</div>
	<div class="tab-pane" id="mutual-cancel">
		<div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
	</div>
    <div class="tab-pane" id="dispute">
		<div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
	</div>
</div>
</div>