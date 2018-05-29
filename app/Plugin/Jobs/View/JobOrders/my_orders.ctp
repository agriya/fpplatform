<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="jobOrders index js-response js-responses">
<?php if($this->request->params['named']['type'] == 'myorders'): ?>

 <section class="sep-bot bot-mspace">
  <div class="container ">
  <div class="label label-info show text-18 clearfix no-round ver-mspace">
  <div class="span smspace"><?php echo __l('Buyer Control Panel');?></div>
  <?php echo $this->element('buying-cp-settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
  </div>
   <h2 class="textb text-32 bot-space mob-dc"><?php echo __l('Shopping');?></h2>
		
  </div>
</section>


<?php endif;?>
<div class="container top-space clearfix">
<div class="clearfix shopping-list dr ver-space">
	<div class="cancel-block active">
		<?php echo $this->Html->link('<span><i class="icon-eye-open"></i>'.__l('View Order History').'</span>', array('controller' => 'job_orders', 'action' => 'index','type'=>'history','admin' => false), array('escape'=>false, 'title' => __l('View Order History')));?>
	</div>
</div>
<div class="alert alert-info clearfix">
	<?php
		echo "<p>".__l("Auto Review: Orders in 'Waiting for review' status needs to be reviewed by the buyer within").' '.Configure::read('job.auto_review_complete').' '.__l("days to avoid auto reviewing by admin, which will automatically close the order as success.")."</p>";
	?>
</div>
<div class="alert alert-warning clearfix">
	<?php
		echo "<p>".__l("In Progress Overtime: Orders in 'In Progress' needs to completed with the 'no of days' given for the").' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l("  + ").' '.Configure::read('job.days_in_progress_to_overtime').' '.__l("days, to avoid changing the status automatically to 'In Progress Overtime'. In this status, Buyer has the option to cancel the order.")."</p>";
	?>
</div>
<div class="select-block">
	<div class="inbox-option">


		<div class="clearfix"> 
				

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'active')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Active').'</dt><dd title="'.($filter_count['User']['buyer_in_progress_count'] + $filter_count['User']['buyer_in_progress_overtime_count'] + $filter_count['User']['buyer_review_count']).'" class="text-32 graydarkerc pr hor-mspace">'.($filter_count['User']['buyer_in_progress_count'] + $filter_count['User']['buyer_in_progress_overtime_count'] + $filter_count['User']['buyer_review_count']).'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'active','admin' => false), array('escape' => false, 'title' => __l('Active'))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'payment_pending')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Payment Pending').'</dt><dd title="'.$filter_count['User']['buyer_payment_pending_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_payment_pending_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'payment_pending','admin' => false), array('escape' => false, 'title' => __l('Payment Pending'))); ?>

				
				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'waiting_for_acceptance')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Pending Seller Accept').'</dt><dd title="'.$filter_count['User']['buyer_waiting_for_acceptance_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_waiting_for_acceptance_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'waiting_for_acceptance','admin' => false), array('escape' => false, 'title' => __l('Pending Seller Accept'))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'in_progress')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('In Progress').'</dt><dd title="'.$filter_count['User']['buyer_in_progress_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_in_progress_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'in_progress','admin' => false), array('escape' => false, 'title' => __l('In Progress'))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'in_progress_overtime')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('In Progress Overtime').'</dt><dd title="'.$filter_count['User']['buyer_in_progress_overtime_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_in_progress_overtime_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'in_progress_overtime','admin' => false), array('escape' => false, 'title' => __l('In Progress Overtime'))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'waiting_for_review')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Waiting For Your Review').'</dt><dd title="'.$filter_count['User']['buyer_review_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_review_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'waiting_for_review','admin' => false), array('escape' => false, 'title' => __l('Waiting For Your Review'))); ?>


				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'completed')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Completed').'</dt><dd title="'.$filter_count['User']['buyer_completed_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_completed_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'completed','admin' => false), array('escape' => false, 'title' => __l('Completed'))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'cancelled')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Cancelled').'</dt><dd title="'.$filter_count['User']['buyer_cancelled_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_cancelled_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'cancelled','admin' => false), array('escape' => false, 'title' => __l('Cancelled'))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'rejected')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Seller Rejected').'</dt><dd title="'.$filter_count['User']['buyer_rejected_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_rejected_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'rejected','admin' => false), array('escape' => false, 'title' => __l('Seller Rejected'))); ?>

				
				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'cancelled_late_orders')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'. __l('Cancelled Late Orders').'</dt><dd title="'.$filter_count['User']['buyer_cancelled_late_order_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_cancelled_late_order_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'cancelled_late_orders','admin' => false), array('escape' => false, 'title' =>  __l('Cancelled Late Orders'))); ?>



				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'expired')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'. __l('Expired'). ' ' . jobAlternateName(ConstJobAlternateName::Plural).'</dt><dd title="'.$filter_count['User']['buyer_expired_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_expired_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'expired','admin' => false), array('escape' => false, 'title' =>  __l('Expired'). ' ' . jobAlternateName(ConstJobAlternateName::Plural))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'rework')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Rework'). ' ' . jobAlternateName(ConstJobAlternateName::Plural).'</dt><dd title="'.$filter_count['User']['buyer_redeliver_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_redeliver_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'rework','admin' => false), array('escape' => false, 'title' => __l('Rework'). ' ' . jobAlternateName(ConstJobAlternateName::Plural))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'mutual_canceled')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Mutual Cancelled').'</dt><dd title="'.$filter_count['User']['buyer_mutual_cancelled_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['buyer_mutual_cancelled_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'mutual_canceled','admin' => false), array('escape' => false, 'title' => __l('Mutual Cancelled'))); ?>


				<?php $class = (empty($this->request->params['named']['status'])) ? 'active' : ''; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('All').'</dt><dd title="'.(!empty($all_count) ? $all_count : '0').'" class="text-32 graydarkerc pr hor-mspace">'.(!empty($all_count) ? $all_count : '0').'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','admin' => false), array('escape' => false, 'title' => __l('All'))); ?>
				 
				  </div>
		
	</div>
</div>
<div class="clearfix sep-bot bot-space bot-mspace"><?php echo $this->element('paging_counter');?></div>
<table class="table table-striped table-hover sep">
	<tr>
		<th><?php echo __l('Date'); ?></th>
		<th><?php echo __l('Order'); ?></th>
		<th><?php echo __l('Status'); ?></th>
		<th class="dc"><?php echo __l('Action'); ?></th>
	</tr>
<?php
if (!empty($jobOrders)):

$i = 0;
foreach ($jobOrders as $jobOrder):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php echo $this->Html->cDateTimeHighlight($jobOrder['JobOrder']['created']);?></td>
		<td>
			<?php echo '#'.$this->Html->cInt($jobOrder['JobOrder']['id']);?>
			<?php echo $this->Html->link($this->Html->cText($jobOrder['Job']['title']), array('controller'=> 'jobs', 'action' => 'view', $jobOrder['Job']['slug']), array('title' => $this->Html->cText($jobOrder['Job']['title'], false), 'escape' => false));?>
			<?php if(!empty($jobOrder['JobOrder']['is_under_dispute'])):?>
		         <?php if(!($jobOrder['JobOrderStatus']['id'] != ConstJobOrderStatus::WaitingforAcceptance && $jobOrder['JobOrderStatus']['id'] != ConstJobOrderStatus::PaymentPending && $jobOrder['JobOrderStatus']['id'] != ConstJobOrderStatus::WaitingforAcceptance && $jobOrder['JobOrderStatus']['id'] != ConstJobOrderStatus::WaitingforReview)): ?>
						<div class="clearfix"><span class="label label-important"><?php echo __l('Under dispute');?></span></div>
				<?php endif; ?>
			<?php endif; ?>
            <?php if($jobOrder['JobOrder']['is_seller_request_for_cancel'] && empty($jobOrder['JobOrder']['is_buyer_request_for_cancel'])):?>
				<?php echo ' - '.__l('Mutual Cancel');?>
			<?php endif;?>
            <?php if(!empty($jobOrder['JobOrder']['last_redeliver_accept_date']) && $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgressOvertime):?>
				<?php echo ' - '.__l('Rework');?>
			<?php endif;?>
		</td>
		<td>
		<?php
			if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myorders'):   
				if($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforAcceptance):				
					echo __l('Pending Seller Accept');
				elseif($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::PaymentPending):				
					echo __l('Payment process pending');
				elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforReview): 
					echo __l('Waiting For Your Review');
				elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::PaymentCleared || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Completed || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CompletedAndClosedByAdmin): 
					echo __l('Completed');
				else:
					echo $this->Html->cText($jobOrder['JobOrderStatus']['name']);
				endif;
			endif; 
		?>
		</td>
		<td class="dc">

		<div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-16 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
					<ul class="dropdown-menu arrow dl arrow-right">
					<?php
					if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myorders' && $jobOrder['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::PaymentPending):
					?>
					<li><?php echo $this->Html->link(__l('View activities'), array('controller' => 'messages', 'action' => 'activities', 'type' => 'myorders','order_id' => $jobOrder['JobOrder']['id']));?></li>
					 <?php	endif;?>

					<?php
			if(empty($jobOrder['JobOrder']['is_under_dispute'])):
				if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myorders'): 
					 if($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforAcceptance):?>
						<li><?php 
						echo $this->Html->link(__l('Cancel Order'), array('action'=>'update_order','order'=> 'cancel','job_order_id' => $jobOrder['JobOrder']['id']), array('class' => 'cancel-order js-order-update', 'title' => __l('Cancel Order'))); ?></li>
					<?php elseif($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::PaymentPending):?>
						<li><?php echo $this->Html->link(__l('Complete Purchase'), array('controller'=>'job_orders','action'=>'add','job' => $jobOrder['Job']['id'],'order_id' => $jobOrder['JobOrder']['id']), array('title' => __l('Complete Purchase')));?></li>

					<?php  elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgressOvertime):?>
						<li><?php  echo $this->Html->link(__l('Cancel Late Order'), array('action'=>'update_order','order'=> 'cancel','job_order_id' => $jobOrder['JobOrder']['id']), array('class' => 'cancel-order js-alert-message', 'title' => __l('Cancel Order')));?></li>
					<?php  elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforReview):?>
						 <li><?php 
						 $url = Router::url(array('controller' => 'messages', 'action' => 'activities', 'type' => 'myorders','order_id' => $jobOrder['JobOrder']['id']) , true);
						 echo $this->Html->link(__l('Review'), $url.'#ajax-tab-container-review', array('class' => 'review','title' => __l('Review')));?><li>
					<?php  endif;
				 endif; 		
		endif; ?>
					
					</ul>
					
				 </div>
		
		</td>
	</tr>
<?php
    endforeach;
else:
?>
<tr>
	<td colspan='7'>		
		<div class="thumbnail space dc grayc">
	        <p class="ver-mspace top-space text-16"><?php echo __l('No Orders available');?></p>
        </div>
	</td>
</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($jobOrders)) { ?>
<div class="clearfix pull-right mob-clr ver-space mob-dc">
<?php echo $this->element('paging_links'); ?>
</div>
<?php } ?>
</div>
</div>