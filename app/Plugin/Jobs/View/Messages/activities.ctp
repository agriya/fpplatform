<div>
	<?php
		echo $this->element('Jobs.jobs-simple-view', array('slug' => $orders['Job']['slug'], 'order_id' => $orders['JobOrder']['id'], 'cache' => array('time' => Configure::read('site.element_cache_duration'))));
	?>
      <section class="row hero-unit no-round">
        <div class="container clearfix">
          <div class="span13 no-mar">
             <?php
					echo nl2br($this->Html->cText($orders['Job']['description']));
					
				?>
          </div>
          <div class="span10 differ-block pull-right">
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Made On');?></dt>
              <dd class="grayc"><?php echo $this->Html->cDateTimeHighlight($orders['JobOrder']['created']);?></dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Accepted');?>?</dt>
              <dd class="grayc"><?php echo (!empty($orders['JobOrder']['accepted_date']) &&  $orders['JobOrder']['accepted_date'] != "0000-00-00 00:00:00") ? __l('Yes').' '.__l('on').' '.$this->Html->cDateTimeHighlight($orders['JobOrder']['accepted_date']): __l('No');?></dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt title="Hit Inprogress Overtime" class="dl left-space textn"><?php echo __l('Hit Inprogress Overtime (Delayed delivery)');?></dt>
              <dd class="grayc"><?php echo (!empty($orders['JobOrder']['is_meet_inprogress_overtime'])) ? __l('Yes'): __l('No');?></dd>
            </dl>
			<?php
			if(ConstJobType::Offline ==  $orders['Job']['job_type_id'] && !empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myorders' && !empty($orders['JobOrder']['verification_code'])) { ?>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Verification Code');?>?</dt>
              <dd class="grayc"><?php echo $this->Html->cText($orders['JobOrder']['verification_code']); ?></dd>
            </dl>
			<?php } ?>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Delivered');?>?</dt>
              <dd class="grayc"><?php echo !empty($orders['JobOrder']['delivered_date']) ? __l('Yes').' '.__l('on').' '.$this->Html->cDateTimeHighlight($orders['JobOrder']['delivered_date']): __l('No');?></dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Completed');?>?</dt>
              <dd class="grayc"><?php echo (!empty($orders['JobOrder']['completed_date']) &&  $orders['JobOrder']['completed_date'] != "0000-00-00 00:00:00") ? __l('Yes').' '.__l('on').' '.$this->Html->cDateTimeHighlight($orders['JobOrder']['completed_date']): __l('No');?></dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Current Status');?></dt>
              <dd class="grayc"><?php echo $orders['JobOrderStatus']['name'];?></dd>
            </dl>
          </div>
        </div>
      </section>
	        <section class="container">
        <h3 class="bot-space mob-dc mob-text-32"><?php echo __l('Activities');?></h3>
				<!-- Displaying Order Prerequirments (if any) -->
		
        <ol class="unstyled activities-list">
		<?php if(!empty($orders['JobOrder']['information_from_buyer']) || !empty($orders['Attachment'][0])):?>
          <li class="clearfix ver-space">
            <div class="span4 ver-smspace dr mob-dc text-16 date-info grayc"><?php echo $this->Time->timeAgoInWords($orders['JobOrder']['created']);?></div>
            <div class="pull-right mob-clr mob-dc sep pr activity-content">
              <div class="span18 no-mar right-arrow space">
                <div class="span4 no-mar top-space">
				<span title="<?php echo __l('Order Pre-Requirements'); ?>" class="pre-requirements dc span4 hor-mspace bot-space mob-no-mar htruncate-ml2"><?php echo __l('Order Pre-Requirements'); ?></span>
				</div>
                <div class="span13 no-mar top-space grayc hor-mspace">
                  <!-- Display for seller -->			
						<?php if(!empty($orders['JobOrder']['information_from_buyer'])):?>
						<p>
							<?php echo __l('Information from buyer');?>
								<span class="stats-val"><?php echo "\"".$this->Html->cText($orders['JobOrder']['information_from_buyer'], false)."\"";?></span>
						</p>
						<?php endif;?>
						<?php if(!empty($orders['Attachment'][0])):?>
						<p>
						<span class="graydarkerc right-space"><?php echo __l('note:'); ?></span>
							<?php echo __l('File from buyer');?>
								<?php echo $this->Html->link('<i class="icon-download-alt no-pad"></i> <span class="bluec">'.$orders['Attachment'][0]['filename'].'</span>' , array('controller' => 'job_orders', 'action' => 'download', $orders['Attachment'][0]['id'], 'admin' => false),array('class' => 'left-space js-no-pjax', 'title' => __l('Click to download this file').': '.$orders['Attachment'][0]['filename'], 'escape' => false)); ?>
						</p>
						<?php endif;?>
                </div>
              </div>
            </div>
          </li>
			<?php endif;?>
			<?php 
				echo $this->element('message-index-conversation', array('order_id' => $orders['JobOrder']['id'],'admin'=>false, 'cache' => array('time' => Configure::read('site.element_cache_duration'))));
			?>
        </ol>
      </section>
     <section class="row no-mar">
	 <?php if($orders['JobOrderStatus']['id'] != ConstJobOrderStatus::PaymentCleared && $orders['JobOrderStatus']['id'] != ConstJobOrderStatus::CompletedAndClosedByAdmin && $orders['JobOrderStatus']['id'] != ConstJobOrderStatus::CancelledByAdmin && $orders['JobOrderStatus']['id'] != ConstJobOrderStatus::Cancelled && $orders['JobOrderStatus']['id'] != ConstJobOrderStatus::Rejected && $orders['JobOrderStatus']['id'] != ConstJobOrderStatus::MutualCancelled && $orders['JobOrderStatus']['id'] != ConstJobOrderStatus::Expired){?>
		<?php if((!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'admin_order_view' && $orders['JobOrderStatus']['id'] != ConstJobOrderStatus::Completed) || ($orders['JobOrderStatus']['id'] == ConstJobOrderStatus::Completed && $this->request->params['named']['type'] == 'myworks')){?>
        <div class="clerfix container">
		<h3 class="bot-space mob-dc mob-text-32 mob-clr"><?php echo __l('Response/Actions');?></h3>
		<div class="ver-space top-mspace mob-clr mob-dc">
			<?php $is_show_manage_bar = 1;?>
			<?php if(empty($orders['JobOrder']['is_under_dispute'])){ // check job order have any dispute post or not?> 
				<?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myworks'){ // Seller?>
					<?php
						 if($orders['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforAcceptance){
							 echo $this->Html->link(__l('Accept order'), array('controller'=>'job_orders', 'action'=>'update_order','order'=> 'accept','job_order_id' => $orders['JobOrder']['id'], 'view_type' => 'activities'), array('class' => 'accept-order js-delete btn btn-danger', 'title' => __l('Accept Order')));
							 echo $this->Html->link(__l('Turn down order (reject)'), array('controller'=>'job_orders', 'action'=>'update_order','order'=> 'reject','job_order_id' => $orders['JobOrder']['id']), array('class' => 'reject-order js-delete btn btn-danger offset1', 'title' => __l('Reject Order')));
					}
					?>		
				<?php } else{	// Buyer ?>	
					<?php 
						if($orders['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforAcceptance){
							echo $this->Html->link(__l('Cancel Order'), array('controller'=>'job_orders','action'=>'update_order','order'=> 'cancel','job_order_id' => $orders['JobOrder']['id']), array('class' => 'cancel-order js-delete btn btn-danger', 'title' => __l('Cancel Order')));
					} elseif($orders['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::PaymentPending){
							echo $this->Html->link(__l('Complete Purchase'), array('controller'=>'job_orders','action'=>'add','job' => $orders['Job']['id'],'order_id' => $orders['JobOrder']['id']), array('title' => __l('Complete Purchase'),'data-toggle'=>'modal','data-target'=>'#js-ajax-modal', 'class' => 'js-no-pjax btn btn-danger'));
					} elseif($orders['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgressOvertime){
							 echo $this->Html->link(__l('Cancel Late Order'), array('controller'=>'job_orders','action'=>'update_order','order'=> 'cancel','job_order_id' => $orders['JobOrder']['id']), array('class' => 'cancel-order js-alert-message js-delete btn btn-danger', 'title' => __l('Cancel Order')));
					} elseif($orders['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforReview){
							echo $this->element('Jobs.job-feedback-add', array('order_id' => $orders['JobOrder']['id'], 'type' => 'deliver','cache' => array('time' => Configure::read('site.element_cache_duration'))));
							$is_show_manage_bar = 0;
						 }	
					?>
				<?php } ?>
			<?php } else{?>
				<div class="alert alert-info"><?php	echo __l('Under dispute. Actions can be continued only after dispute gets closed.');?></div>
				<?php
					// dispute compose or response 
					echo $this->element('message-dispute-response', array('order_id' => $orders['JobOrder']['id'], 'type' => $this->request->params['named']['type'], 'cache' => array('time' => Configure::read('site.element_cache_duration'))));
				?>				
					<?php echo $this->element('job-order-dispute-resolve', array('order_id' => $orders['JobOrder']['id'], 'type' => $this->request->params['named']['type'], 'cache' => array('time' => Configure::read('site.element_cache_duration'))));?>				
			<?php }?>
		</div>
		</div>
       
			<?php if(!empty($is_show_manage_bar) && ($orders['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::WaitingforAcceptance)){?>
					<?php echo $this->element('job-order-manage-tabs', array('job_order_id' => $orders['JobOrder']['id'], 'order_status_id' => $orders['JobOrder']['job_order_status_id'], 'job_type_id' => $orders['Job']['job_type_id'], 'is_redeliver_request' => $orders['JobOrder']['is_redeliver_request'], 'is_under_dispute' => $orders['JobOrder']['is_under_dispute'], 'type' => $this->request->params['named']['type'], 'cache' => array('time' => Configure::read('site.element_cache_duration'))));?>
			<?php }?>
       

		<?php } else{?>
			<?php if(!empty($orders['JobOrder']['is_under_dispute'])){ // check job order have any dispute post or not?> 
				<div class="alert alert-info"><?php	echo __l('Under dispute. Actions can be continued only after dispute gets closed.');?></div>
				<?php
					// dispute compose or response 
					echo $this->element('message-dispute-response', array('order_id' => $orders['JobOrder']['id'], 'type' => $this->request->params['named']['type'], 'cache' => array('time' => Configure::read('site.element_cache_duration'))));
				?>
   	            <div>
					<?php echo $this->element('job-order-dispute-resolve', array('order_id' => $orders['JobOrder']['id'], 'type' => $this->request->params['named']['type'], 'cache' => array('time' => Configure::read('site.element_cache_duration'))));?>
				</div>
			<?php } ?>
		<?php } ?>
	<?php } ?>

      </section>
</div>