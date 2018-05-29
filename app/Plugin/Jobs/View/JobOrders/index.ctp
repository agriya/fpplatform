<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="jobOrders index">
<?php if($this->request->params['named']['type'] == 'myworks'): ?>
 <section class="sep-bot bot-mspace">
  <div class="container ">
  <div class="label label-info show text-18 clearfix no-round ver-mspace">
  <div class="span smspace"><?php echo __l('Seller Control Panel');?></div>
  <?php echo $this->element('selling-cp-settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
  </div>
   <h2 class="textb text-32 bot-space mob-dc"><?php echo __l('My Todo List');?></h2>
		
  </div>
</section>
<?php endif;?>
<div class="container top-space clearfix">
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
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Active').'</dt><dd title="'.($filter_count['User']['seller_in_progress_count'] + $filter_count['User']['seller_in_progress_overtime_count'] + $filter_count['User']['seller_review_count']).'" class="text-32 graydarkerc pr hor-mspace">'.($filter_count['User']['seller_in_progress_count'] + $filter_count['User']['seller_in_progress_overtime_count'] + $filter_count['User']['seller_review_count']).'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'active','admin' => false), array('escape' => false, 'title' => __l('Active'))); ?>
				
				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'waiting_for_acceptance')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Waiting for you to accept').'</dt><dd title="'.$filter_count['User']['seller_waiting_for_acceptance'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['seller_waiting_for_acceptance'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'waiting_for_acceptance','admin' => false), array('escape' => false, 'title' => __l('Waiting for you to accept'))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'in_progress')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('In Progress').'</dt><dd title="'.$filter_count['User']['seller_in_progress_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['seller_in_progress_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'in_progress','admin' => false), array('escape' => false, 'title' => __l('In Progress'))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'in_progress_overtime')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('In Progress Overtime').'</dt><dd title="'.$filter_count['User']['seller_in_progress_overtime_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['seller_in_progress_overtime_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'in_progress_overtime','admin' => false), array('escape' => false, 'title' => __l('In Progress Overtime'))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'waiting_for_Review')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('In buyer review').'</dt><dd title="'.$filter_count['User']['seller_review_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['seller_review_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'waiting_for_Review','admin' => false), array('escape' => false, 'title' => __l('In buyer review'))); ?>


				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'completed')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Completed').'</dt><dd title="'.$filter_count['User']['seller_completed_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['seller_completed_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'completed','admin' => false), array('escape' => false, 'title' => __l('Completed'))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'rejected')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Rejected').'</dt><dd title="'.$filter_count['User']['seller_rejected_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['seller_rejected_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'rejected','admin' => false), array('escape' => false, 'title' => __l('Rejected'))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'cancelled')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Cancelled').'</dt><dd title="'.$filter_count['User']['seller_cancelled_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['seller_cancelled_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'cancelled','admin' => false), array('escape' => false, 'title' => __l('Cancelled'))); ?>


				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'expired')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'. __l('Expired'). ' ' . jobAlternateName(ConstJobAlternateName::Plural).'</dt><dd title="'.$filter_count['User']['seller_expired_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['seller_expired_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'expired','admin' => false), array('escape' => false, 'title' =>  __l('Expired'). ' ' . jobAlternateName(ConstJobAlternateName::Plural))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'rework')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Rework'). ' ' . jobAlternateName(ConstJobAlternateName::Plural).'</dt><dd title="'.$filter_count['User']['seller_redeliver_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['seller_redeliver_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'rework','admin' => false), array('escape' => false, 'title' => __l('Rework'). ' ' . jobAlternateName(ConstJobAlternateName::Plural))); ?>

				<?php $class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'mutual_canceled')) ? 'active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Mutual Cancelled').'</dt><dd title="'.$filter_count['User']['seller_mutual_cancelled_count'].'" class="text-32 graydarkerc pr hor-mspace">'.$filter_count['User']['seller_mutual_cancelled_count'].'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'mutual_canceled','admin' => false), array('escape' => false, 'title' => __l('Mutual Cancelled'))); ?>

				<?php $class = (empty($this->request->params['named']['status'])) ? 'active' : ''; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace  users '.$class.' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('All').'</dt><dd title="'.(!empty($all_count) ? $all_count : '0').'" class="text-32 graydarkerc pr hor-mspace">'.(!empty($all_count) ? $all_count : '0').'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','admin' => false), array('escape' => false, 'title' => __l('All'))); ?>
				 
				  </div>

		
	</div>
</div>
<div class="clearfix sep-bot bot-space"><?php echo $this->element('paging_counter');?></div>

<ol class="unstyled" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($jobOrders)):
$i = 0;
foreach ($jobOrders as $jobOrder):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>

<li>
<div class="ver-space sep-bot no-mar clearfix">
<div class="span1 pull-left">
<span class="text-16 textb"><?php echo '#'.$this->Html->cInt($jobOrder['JobOrder']['id']);?></span>
</div>
<div class="span pull-left hor-space">

<?php $attachment = '';?>
	<?php if(!empty($jobOrder['Job']['Attachment']['0'])){?>
			<p class="jobs-order-img-left"><?php echo $this->Html->link($this->Html->showImage('Job', $jobOrder['Job']['Attachment']['0'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($jobOrder['Job']['title'], false)), 'class'=>'sep sep-big sep-black', 'title' => $this->Html->cText($jobOrder['Job']['title'], false))), array('controller' => 'jobs', 'action' => 'view', $jobOrder['Job']['slug'], 'admin' => false), array('escape' => false));?></p>
	<?php }else{ ?>
			<p class="jobs-order-img-left"><?php echo $this->Html->link($this->Html->showImage('Job', $attachment, array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($jobOrder['Job']['title'], false)), 'class'=>'sep sep-big sep-black', 'title' => $this->Html->cText($jobOrder['Job']['title'], false))), array('controller' => 'jobs', 'action' => 'view', $jobOrder['Job']['slug'], 'admin' => false), array('escape' => false));?></p>
	<?php } ?>

</div>
  <div class="pull-left span13 left-space clearfix">
		<h3 class="text-18 no-mar clearfix">
		<span class="pull-left top-smspace" title="<?php echo $jobOrder['Job']['JobType']['name']; ?>">
		<i class="icon-desktop top-space right-mspace <?php echo ($jobOrder['Job']['JobType']['id'] == ConstJobType::Online)?'greenc':'grayc'; ?>"></i>
		</span>
		<?php if($jobOrder['JobOrder']['is_buyer_request_for_cancel'] && empty($jobOrder['JobOrder']['is_seller_request_for_cancel'])):?>
			<span class="pull-left top-smspace" title="<?php echo __l('Mutual Cancel');?>">
			<i class="icon-ban top-space right-mspace grayc"></i>
			</span>
		<?php endif;?>
         <?php if(!empty($jobOrder['JobOrder']['last_redeliver_accept_date']) && $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgressOvertime):?>
			<span class="pull-left top-smspace" title="<?php echo __l('Rework');?>">
				<i class="icon-retweet top-space right-mspace grayc"></i>
				</span>
		<?php endif;?>


		<?php echo $this->Html->link($this->Html->cText($jobOrder['Job']['title']), array('controller'=> 'jobs', 'action' => 'view', $jobOrder['Job']['slug']), array('class' => 'span12 no-mar js-bootstrap-tooltip htruncate graydarkerc', 'title' => __l($this->Html->cText($jobOrder['Job']['title'], false)), 'escape' => false));?>
		</h3>
		<p class="top-space left-mspace">
		<?php echo __l('Ordered by: ').' '.$this->Html->link($this->Html->cText($jobOrder['User']['username']), array('controller'=> 'users', 'action' => 'view', $jobOrder['User']['username']), array('class' => 'graydarkerc no-under bot-space right-mspace textb left-smspace','title' => $this->Html->cText($jobOrder['User']['username'],false),'escape' => false));?>
		<span class="grayc"><?php echo $this->Time->timeAgoInWords($jobOrder['JobOrder']['created']);?></span>
		</p>
		<?php if(!empty($jobOrder['JobOrder']['is_under_dispute'])):
        if($jobOrder['JobOrderStatus']['id'] != ConstJobOrderStatus::CancelledByAdmin && $jobOrder['JobOrderStatus']['id'] != ConstJobOrderStatus::Cancelled && $jobOrder['JobOrderStatus']['id'] != ConstJobOrderStatus::Rejected && $jobOrder['JobOrderStatus']['id'] != ConstJobOrderStatus::MutualCancelled && $jobOrder['JobOrderStatus']['id'] != ConstJobOrderStatus::Expired):?>
		<div class="clearfix hor-space"><span class="label label-important"><?php echo __l('Under dispute');?></span></div>
		<?php endif;
		endif; ?>
	  </div>
  <div class="pull-right span6 space clearfix">
  <?php $order_status_class = ($jobOrder['JobOrderStatus']['slug']) ? 'status_'.$jobOrder['JobOrderStatus']['slug'] : null; ?>
    	<div class="jobs-order-right <?php echo $order_status_class;?>">
		<div class="js-order-udpate-<?php echo $jobOrder['JobOrder']['id'];?>">
<?php
				if(!empty($this->request->params['named']['type'])):
					if($this->request->params['named']['type'] == 'myworks'):  	
						if($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforAcceptance):	?>			
							<span class="joborder-status-info joborder-status-waiting_for_acceptance"><?php echo __l('New Order - Please accept'); ?></span>
							<span class="span4 no-mar htruncate js-bootstrap-tooltip" title="<?php echo __l('New Order - Please accept'); ?>"><?php echo __l('New Order - Please accept'); ?></span>
						<?php elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgress): ?>
							<span class="joborder-status-info joborder-status-in_progress"> <?php echo __l('Work in progress'); ?></span>
							<span class="span4 no-mar htruncate js-bootstrap-tooltip" title="<?php echo __l('Work in progress'); ?>"><?php echo __l('Work in progress'); ?></span>
						<?php elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgressOvertime): ?>
							<span class="joborder-status-info joborder-status-in_progress_overtime"> <?php echo __l('In progress overtime'); ?></span> 
							<span class="span4 no-mar htruncate js-bootstrap-tooltip" title="<?php echo __l('In progress overtime');?>"><?php echo __l('In progress overtime');?></span>
						<?php elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CancelledDueToOvertime): ?> 
							<span class="joborder-status-info joborder-status-cancelled_late_orders"> <?php echo __l('Cancelled due to overtime'); ?></span>
							<span class="span4 no-mar htruncate js-bootstrap-tooltip" title="<?php echo __l('Cancelled due to overtime'); ?>"><?php echo __l('Cancelled due to overtime'); ?></span>
						<?php elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CancelledByAdmin): ?>
							<span class="joborder-status-info joborder-status-cancelled_late_orders"> <?php echo __l('Cancelled By Admin'); ?></span>
							<span class="span4 no-mar htruncate js-bootstrap-tooltip" title="<?php echo __l('Cancelled By Admin');?>"><?php echo __l('Cancelled By Admin');?></span>
						<?php elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CompletedAndClosedByAdmin): ?>
							<span class="joborder-status-info joborder-status-completed"> <?php echo __l('Completed and closed by admin'); ?></span> 
							<span class="span4 no-mar htruncate js-bootstrap-tooltip" title="<?php echo __l('Completed and closed by admin');?>"><?php echo __l('Completed and closed by admin');?></span>
						<?php elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforReview): ?>
							<span class="joborder-status-info joborder-status-waiting_for_review"> <?php echo __l('Completed - No action required'); ?></span>
							<span class="span4 no-mar htruncate js-bootstrap-tooltip" title="<?php echo __l('Completed - No action required!');?>"><?php echo __l('Completed - No action required!');?></span>
						<?php elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Cancelled): ?>
							<span class="joborder-status-info joborder-status-cancelled_late_orders"> <?php echo __l('Cancelled'); ?></span>
							<span class="span4 no-mar htruncate js-bootstrap-tooltip" title="<?php echo __l('Cancelled');?>"><?php echo __l('Cancelled');?></span>
						<?php elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Rejected): ?>
							<span class="joborder-status-info joborder-status-rejected"> <?php echo __l('Rejected'); ?></span>
							<span class="span4 no-mar htruncate js-bootstrap-tooltip" title="<?php echo __l('Rejected');?>"><?php echo __l('Rejected');?></span>
						<?php elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::PaymentCleared || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Completed): ?>
							<span class="joborder-status-info joborder-status-completed"> <?php echo __l('Done, No action required.'); ?></span>
							<span class="span4 no-mar htruncate js-bootstrap-tooltip" title=" <?php echo __l('Done, No action required.');?>"> <?php echo __l('Done, No action required.');?></span>
						<?php else:?>
							<span class="joborder-status-info joborder-status-all"> <?php echo $this->Html->cText($jobOrder['JobOrderStatus']['name']); ?></span>
							<span class="span4 no-mar htruncate js-bootstrap-tooltip" title="<?php echo $this->Html->cText($jobOrder['JobOrderStatus']['name'],false); ?>"><?php echo $this->Html->cText($jobOrder['JobOrderStatus']['name']); ?></span>
						<?php endif;
					endif; 
				endif; 
			?>
			</div>
			</div>
	<div class="dropdown pull-right">
	 <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Settings"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Settings'); ?></span> </span>
		<ul class="unstyled dropdown-menu arrow arrow-right dl clearfix">
		<li><?php echo $this->Html->link(__l('View activities'), array('controller' => 'messages', 'action' => 'activities', 'type' => 'myworks', 'order_id' => $jobOrder['JobOrder']['id']));?></li>
		<li><?php echo $this->Html->link(__l('Contact Buyer'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $jobOrder['User']['username'],'job_order_id' => $jobOrder['JobOrder']['id']), array('title' => __l('Contact Buyer')));?></li>
		<li><?php echo $this->Html->link(__l('View related messages'), array('controller'=>'messages','action'=>'index','type' => 'inbox','job_order_id' => $jobOrder['JobOrder']['id']), array('title' => __l('View related messages')));?></li>
		<?php
				if(!empty($this->request->params['named']['type'])):
					 if($this->request->params['named']['type'] == 'myworks'):   // Seller
						 if($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforAcceptance):?>
							 <li><?php  echo $this->Html->link(__l('Accept order'), array('action'=>'update_order','order'=> 'accept','job_order_id' => $jobOrder['JobOrder']['id']), array('class' => 'js-no-pjax accept-order {order_id:"'.$jobOrder['JobOrder']['id'].'"}', 'title' => __l('Accept Order')));?></li>
							  <li><?php echo $this->Html->link(__l('Turn down order (reject)'), array('action'=>'update_order','order'=> 'reject','job_order_id' => $jobOrder['JobOrder']['id']), array('class' => 'js-no-pjax reject-order {order_id:"'.$jobOrder['JobOrder']['id'].'"}', 'title' => __l('Reject Order')));?></li><?php
						 endif;
						 if(empty($jobOrder['JobOrder']['is_under_dispute'])):
							 if($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgress  || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgressOvertime || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Redeliver):
								if($jobOrder['Job']['JobType']['id'] == ConstJobType::Offline):?>
									 <li><?php 
									 $url = Router::url(array('controller' => 'messages', 'action' => 'activities', 'type' => 'myworks', 'order_id' => $jobOrder['JobOrder']['id']) , true);
									 echo $this->Html->link(__l('Complete your work'), $url."#verify-order", array('class' => 'deliever-work', 'title' => __l('Complete Your Work')));?></li><?php 
								else:?>
									 <li><?php 
									 $url = Router::url(array('controller' => 'messages', 'action' => 'activities', 'type' => 'myworks', 'order_id' => $jobOrder['JobOrder']['id']) , true);
									 echo $this->Html->link(__l('Deliver Your Work'), $url.'#deliver-order', array('class' => 'deliever-work', 'title' => __l('Deliver Your Work'), 'escape' => false));?></li><?php
								endif;
							 endif;
						endif;
					 endif;
				 endif;
			 ?>

			 
		</ul>
	</div>
</div>
</div>


</li>
<?php
    endforeach;
else:
?>
	<li class="mspace">
		<div class="thumbnail space dc grayc">
	        <p class="ver-mspace top-space text-16"><?php echo __l('No Orders available');?></p>
        </div>
	</li>
<?php
endif;
?>
</ol>
<?php
if (!empty($jobOrders)) { ?>
<div class="clearfix pull-right mob-clr ver-space mob-dc">
<?php echo $this->element('paging_links'); ?>
</div>
<?php } ?>
</div>
</div>