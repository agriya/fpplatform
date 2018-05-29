<?php /* SVN: $Id: $ */ ?>
<div class="jobOrders view">
<?php if(empty($this->request->params['named']['type'])): ?>
<h2 class="track-order-title"><?php echo __l('Track Order');?></h2>
	<?php
		if(!empty($jobOrder)):
	?>
    <div class="clearfix">
		<dl class="track-order-list clearfix">
            <dt>
			     <?php echo __l('Purchased date').':'; ?>
			</dt>
			<dd>
              	<?php echo $this->Html->cDateTimeHighlight($jobOrder['JobOrder']['created']); ?>
             </dd>
             <dt>
				<?php	echo __l('Order#').':'; ?>
				</dt>
				<dd>
              	<?php echo $this->Html->cInt($jobOrder['JobOrder']['id']); ?>
              	</dd>
              	<dt>
				<?php	echo __l('Usual Delivery').':';?>
				</dt>
				<dd>
					<?php echo $jobOrder['Job']['no_of_days'];
						echo ($jobOrder['Job']['no_of_days'] == '1') ? ' '.__l('day') : ' '.__l('days');?>
				</dd>
				<?php if(($jobOrder['Job']['job_type_id'] == ConstJobType::Offline) && ($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgress || $jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime ||$jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview)):?>
					<dt>
						<?php echo __l('Verification Code').':';?>
					</dt>
					<dd>
						<?php echo $jobOrder['JobOrder']['verification_code'];?>						
						<?php echo $this->Html->link(__l('Print'), array('controller'=> 'job_orders', 'action' => 'track_order', 'type' => 'print', $jobOrder['JobOrder']['id']), array('target' => '_blank', 'title' => __l('Print')));?>
					</dd>
					<?php if($jobOrder['JobOrder']['job_service_location_id'] == ConstServiceLocation::BuyerToSeller):?>
						<dt>
							<?php echo __l('Seller Address').':';?>
						</dt>
						<dd>
							<?php echo $jobOrder['JobOrder']['address'].' '.$jobOrder['JobOrder']['mobile'];?>
						</dd>
					<?php endif;?>
				<?php endif;?>
		</dl>
		</div>
			<h3 class="job-order-status">
			<?php echo $this->Html->link($this->Html->cText($jobOrder['Job']['title']), array('controller' => 'jobs', 'action' => 'view', $jobOrder['Job']['slug']), array('title' => $this->Html->cText($jobOrder['Job']['title'], false),'escape' => false));?>
			<div class="job-price">
				<p class="amt"><?php echo $this->Html->siteCurrencyFormat($jobOrder['Job']['amount']);?></p>
			</div>

		<span class="by-info"><?php echo ' ('.__l('by').':'.' '.$this->Html->link($this->Html->cText($jobOrder['Job']['User']['username']), array('controller'=> 'users', 'action' => 'view', $jobOrder['Job']['User']['username']), array('title' => $this->Html->cText($jobOrder['Job']['User']['username'],false),'escape' => false)).')';?>
                </span>
        	</h3>
		<div class="seller-status">
			<?php $balance_status_class = ($jobOrder['JobOrderStatus']['slug']) ? 'status_'.$jobOrder['JobOrderStatus']['slug'] : '';?>
			<?php echo __l('Status').':';?>
			<span class="<?php echo $balance_status_class;?>">
				<?php $balance_status_class = ($jobOrder['JobOrderStatus']['slug']) ? 'status_'.$jobOrder['JobOrderStatus']['slug'] : '';?>
				<?php
					if($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforAcceptance):  ?>
					<p class="pending"><?php	echo __l('Pending Seller Accept');
						echo $this->Html->link(__l('Cancel Order'), array('action'=>'update_order','order'=> 'cancel','job_order_id' => $jobOrder['JobOrder']['id']), array('class' => 'cancel-order js-delete', 'title' => __l('Cancel Order')));
                        ?>
                        </p>
						<h4><?php echo __l('Your order is waiting for seller acceptance.');?></h4>
                        <?php elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforReview): ?>
						<p class="waiting">
							<?php 
								if(empty($jobOrder['JobOrder']['is_under_dispute'])):
									echo __l('Waiting For Your Review');
									echo $this->Html->link(__l('Review'), array('controller'=>'job_feedbacks','action'=>'add','job_order_id' => $jobOrder['JobOrder']['id']), array('class' => 'review js-delete', 'title' => __l('Review')));
								else:
									echo __l('Under dispute. Continued only after dispute gets closed.');
								endif;
							?>
                        </p>
						<h4><?php echo __l('Your order has been completed and waiting for your review and completion of work.');?></h4>
                        <?php elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::PaymentCleared || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Completed): ?>
							<p class="complete"><?php echo __l('Complete - No action required!'); ?></p>
						<?php
						elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgress): 
							echo __l('Work in progress');		
						elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgressOvertime): 
							echo __l('In progress overtime');		
						elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CancelledDueToOvertime): 
							echo __l('Cancelled due to overtime');		
						elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CancelledByAdmin): 
							echo __l('Cancelled by admin');		
						elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CompletedAndClosedByAdmin): 
							echo __l('Completed and closed by admin');		
						?>
						<?php else: ?>
							<p class="order-status"><?php echo $this->Html->cText($jobOrder['JobOrderStatus']['name']); ?></p>
						<?php endif;?>
			</span>
		</div>
	<div class="option-block">
    		<h5>
    		<?php
    			echo __l('Options').' '.':';
    		?>
    		</h5>
			<div class="contact-seller-<?php echo $jobOrder['Job']['id'];?>">
				<p><?php echo $this->Html->link(__l('Contact Seller'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $jobOrder['Job']['User']['username'],'job_order_id' => $jobOrder['JobOrder']['id']), array('title' => __l('Contact Seller')));?></p>
			</div>
			<p><?php echo $this->Html->link(__l('View related messages'), array('controller'=>'messages','action'=>'index','type' => 'inbox','job_order_id' => $jobOrder['JobOrder']['id']), array('title' => __l('View related messages')));?></p>
		</div>
		<div>
			<?php
				if(!empty($relatedMessages)):
				?>
				<h3 class="found-title"><?php echo __l('Found').' '.count($relatedMessages).' '. __l('files related to this order').':';?></h3>
				<ul class="attachement-list">
				<?php
					foreach($relatedMessages as $relatedMessage):
					if(!empty($relatedMessage['MessageContent']['Attachment'])):
						$attachment = $relatedMessage['MessageContent']['Attachment']['0'];
						if (!empty($relatedMessage['MessageContent']['Attachment']['0'])) :?>
								<li>
								<?php echo __l('File').':';?>
									<span><?php echo $this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $relatedMessage['Message']['hash'], $attachment['id']),array('class'=>'js-no-pjax')); ?></span>
									<?php if(!empty($relatedMessage['MessageContent']['message'])):?>
										<span><?php echo __l('from message').' '. $this->Html->link($relatedMessage['MessageContent']['subject'],array('controller' => 'messages', 'action' => 'view',$relatedMessage['Message']['hash'] ));?></span>
									<?php endif;?>
								</li>
						 <?php
							endif;
						else:?>
							<?php if(!empty($relatedMessage['MessageContent']['message'])):?>
								<li><span><?php echo __l('From message').' '. $this->Html->link($relatedMessage['MessageContent']['subject'],array('controller' => 'messages', 'action' => 'view',$relatedMessage['Message']['hash'] ));?></span></li>
							<?php endif;?>
						<?php endif;
					endforeach;
					?>
				</ul>
				<?php
				endif;
			?>
		</div>

	<?php endif;?>
	
	<?php else:?>
		<div class="clearfix">
    <table class="table table-striped table-hover sep" style="margin:10px 0px 0px 0px;padding:10px;">
		<tr>
			<td><?php echo __l('Purchased Date');?></td>
			<td><?php echo $this->Html->cDateTimeHighlight($jobOrder['JobOrder']['created']); ?></td>
		</tr>
		<tr>
			<td><?php	echo __l('Job name').':'; ?></td>
			<td>	<?php echo $jobOrder['Job']['title']; ?></td>
		</tr>
		<tr>
			<td><?php	echo __l('Order#').':'; ?></td>
			<td>	<?php echo $jobOrder['JobOrder']['id']; ?></td>
		</tr>
		<tr>
			<td><?php echo __l('Usual Delivery').':';?></td>
			<td><?php echo $jobOrder['Job']['no_of_days'];
						echo ($jobOrder['Job']['no_of_days'] == '1') ? ' '.__l('day') : ' '.__l('days');?></td>
		</tr>
		<?php if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgress || $jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime ||$jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview):?>
		<tr>
			<td><?php echo __l('Verification Code');?></td>
			<td><?php echo $jobOrder['JobOrder']['verification_code'];?>		</td>
		</tr>
		<?php if($jobOrder['JobOrder']['job_service_location_id'] == ConstServiceLocation::BuyerToSeller):?>
		<tr>
			<td><?php echo __l('Seller Address');?></td>
			<td><?php echo $jobOrder['JobOrder']['address'].' '.$jobOrder['JobOrder']['mobile'];?></td>
		</tr>
		<?php endif;?>
		<?php endif;?>
		</div>
	<?php endif;?>
</div>
<?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'print'): ?>
	<script>
         window.print();
    </script>
<?php endif; ?>
