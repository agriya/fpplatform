<?php 
//pr($this->request->params['named']);
$is_buyer = $is_buyer_redeliver = $is_buyer_redeliver_cancel = $is_buyer_mutual_cancel = false;
$is_seller = $is_seller_redeliver = $is_seller_mutual_cancel = false;
if($order['JobOrder']['user_id'] == $this->Auth->user('id')){
	if($order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview && !($order['JobOrder']['is_redeliver_request']) && $order['Job']['job_type_id'] != ConstJobType::Offline){
		$is_buyer = $is_buyer_redeliver = true;
	}
	elseif($order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview && $order['JobOrder']['is_redeliver_request']){
		$is_buyer = $is_buyer_redeliver_cancel = true;
	}
	else{
		unset($reports[0]);
		$this->request->data['JobOrder']['report_id'] = 1;
	}
	if(!$order['JobOrder']['is_buyer_request_for_cancel'] && ($order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgress  || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Redeliver || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview )  ){
		$is_buyer = $is_buyer_mutual_cancel = true;
	}
	else{
		$is_buyer = true;
		unset($reports[1]);
		$this->request->data['JobOrder']['report_id'] = 0;
	}
}
elseif($order['JobOrder']['owner_user_id'] == $this->Auth->user('id')){
	if($order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview && $order['JobOrder']['is_redeliver_request']){
		$is_seller = $is_seller_redeliver = true;
	}	
	else{
		unset($reports[0]);
		$this->request->data['JobOrder']['report_id'] = 1;
	}
	if(!$order['JobOrder']['is_seller_request_for_cancel']  && ($order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgress  || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Redeliver || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview )){
		$is_seller = $is_seller_mutual_cancel = true;
	}
	else{
		$is_seller = true;
		unset($reports[1]);			
	}		
	if($order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Completed || $order['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::PaymentCleared){
		$is_seller = true;
	}
}
	if($is_buyer || $is_seller){ 
?>
<div>
<div>
	<?php if(!empty($this->request->params['named']['selected']) && $this->request->params['named']['selected'] != "dispute"):?>
	<div class="clearfix">
	<?php 
		echo $this->Form->create('JobOrder', array('action' => 'manage', 'class' => 'normal form-horizontal')); 
		echo $this->Form->input('id', array('type' => 'hidden'));
		if(!empty($this->request->params['named']['selected'])){
			if($this->request->params['named']['selected'] == "mutual_cancel"){
				$report_selected_id = 1;
			}elseif($this->request->params['named']['selected'] == "redeliver"){
				$report_selected_id = 0;			
			}elseif($this->request->params['named']['selected'] == "dispute"){
				$report_selected_id = 2;			
			}
		
		}
		//echo $this->Form->input('report_id', array('type' => 'radio', 'options' => $reports, 'legend' => false, 'class' => 'js-reports', 'value' => $this->request->data['JobOrder']['report_id']));
		echo $this->Form->input('report_id', array('value' => $report_selected_id, 'type' => 'hidden'));	
		?>
			<?php if($this->request->params['named']['selected'] == "mutual_cancel"):?>
				<?php if(($is_buyer_mutual_cancel || $is_seller_mutual_cancel) && (empty($order['JobOrder']['cancel_initiator_user_id']))){?>
				<div class="alert alert-info clearfix js-mutual_cancel mspace">
					<?php
						echo "<p>".__l("Mutual Cancel: Both sides agrees to drop the order. Payment is returned to buyer's account.")."</p>";
					?>
				</div>
				<?php } ?>
			<?php endif;?>
			<?php if($this->request->params['named']['selected'] == "redeliver"):?>
				<?php if($is_buyer_redeliver){?>
				  <div class="alert alert-info clearfix js-redeliver">
					<?php
						echo "<p>".__l("Request improvement: The seller will have to redeliver the work.")."</p>";
					?>
				</div>
				<?php } ?>
			<?php endif;?>
			<div class="js-hide-on-dispute">
			<?php
				if(($is_buyer_mutual_cancel || $is_seller_mutual_cancel) && (empty($order['JobOrder']['cancel_initiator_user_id']))){
					echo $this->Form->input('message', array('type' => 'textarea','class'=>'span20-sm'));
				} elseif( !empty($is_buyer_mutual_cancel)  && (!empty($order['JobOrder']['cancel_initiator_user_id'])) && ($order['JobOrder']['is_seller_request_for_cancel']) && (empty($order['JobOrder']['is_buyer_request_for_cancel']))){
					echo $this->Form->input('message', array('type' => 'textarea','class'=>'span20-sm'));
				} elseif ( !empty($is_seller_mutual_cancel)  && (!empty($order['JobOrder']['cancel_initiator_user_id'])) && ($order['JobOrder']['is_buyer_request_for_cancel']) && empty($order['JobOrder']['is_seller_request_for_cancel'])){	
					echo $this->Form->input('message', array('type' => 'textarea','class'=>'span20-sm'));
				} elseif (((count($reports) == 1 && array_keys($reports) == 2) || count($reports) > 1) && ($this->request->params['named']['selected'] != 'mutual_cancel')){
					echo $this->Form->input('message', array('type' => 'textarea','class'=>'span20-sm'));
				}
			?>
			</div>
			<?php if($this->request->params['named']['selected'] == "redeliver"):?>
				<div class="submit clearfix js-redeliver">
					<?php 	
							if($is_buyer_redeliver){
								 echo $this->Form->submit(__l('Request Redeliver'), array('name' => 'data[JobOrder][redeliver]','class'=>'btn btn-warning'));
							}
							if($is_buyer_redeliver_cancel){
								echo $this->Form->submit(__l('Cancel redeliver request'), array('name' => 'data[JobOrder][redeliver_cancel]','class'=>'btn btn-warning'));
							}
							if($is_seller_redeliver){
								 echo $this->Form->submit(__l('Accept redeliver request'), array('name' => 'data[JobOrder][accept_redeliver]','class'=>'btn btn-warning'));
								echo $this->Form->submit(__l('Reject redeliver request'), array('name' => 'data[JobOrder][reject_redeliver]','class'=>'btn btn-warning'));
							}
					?>
				 </div>
			<?php endif;?>
				<?php if($this->request->params['named']['selected'] == "mutual_cancel"):?>
					<?php 
						if(($is_buyer_mutual_cancel || $is_seller_mutual_cancel) && (empty($order['JobOrder']['cancel_initiator_user_id']))){?>
						<div class="submit clearfix js-mutual_cancel"><?php
							 echo $this->Form->submit(__l('Request Mutual Cancel'), array('name' => 'data[JobOrder][mutual_cancel]','class'=>'btn btn-warning', 'div'=> false));?>
						</div>
						<?php }
						elseif( !empty($is_buyer_mutual_cancel)  && (!empty($order['JobOrder']['cancel_initiator_user_id'])) && ($order['JobOrder']['is_seller_request_for_cancel']) && (empty($order['JobOrder']['is_buyer_request_for_cancel']))){?>
						<div class="submit clearfix js-mutual_cancel"><?php
							echo $this->Form->submit(__l('Accept Mutual Cancel'), array('name' => 'data[JobOrder][accept_mutual_cancel]','class'=>'btn btn-warning', 'div'=> false));
							echo $this->Form->submit(__l('Reject Mutual Cancel'), array('name' => 'data[JobOrder][reject_mutual_cancel]','class'=>'btn btn-warning', 'div'=> false));?>
						</div><?php
						}			 
						elseif( !empty($is_seller_mutual_cancel)  && (!empty($order['JobOrder']['cancel_initiator_user_id'])) && ($order['JobOrder']['is_buyer_request_for_cancel']) && empty($order['JobOrder']['is_seller_request_for_cancel'])){	?>
						<div class="submit clearfix js-mutual_cancel"><?php
							echo $this->Form->submit(__l('Accept Mutual Cancel'), array('name' => 'data[JobOrder][accept_mutual_cancel]','class'=>'btn btn-warning', 'div'=> false));
							echo $this->Form->submit(__l('Reject Mutual Cancel'), array('name' => 'data[JobOrder][reject_mutual_cancel]','class'=>'btn btn-warning', 'div'=> false));?>
						</div><?php
						}elseif(!empty($order['JobOrder']['cancel_initiator_user_id'])){ ?>
							<div class="alert top-mspace"><?php 	echo __l('Waiting for other user decision.'); ?> </div>
						<?php }
					?>
				<?php endif;?>
		<?php 
			echo $this->Form->end();    	
		?>	
	</div>
	<?php endif;?>
	<?php if(!empty($this->request->params['named']['selected']) && $this->request->params['named']['selected'] == "dispute"):?>
		<div class="alert alert-info clearfix js-dispute-container hide">
		<?php
			echo "<p>".__l('If you have a disagreement or argument about your order or not satisfied about the work you recieved and looking for claim your amount or require anyother support based on below show cases, you can open a dispute.
							<br/>Note: Your posted dispute will be mointered by administrator and favor for the buyer/seller will made by administrator alone.')."</p>";
		?>
		</div>
		<div class="js-dispute-container bot-mspace">
			<?php echo $this->element('job-order-dispute-add', array('order_id' => $order['JobOrder']['id'], 'cache' => array('time' => Configure::read('site.element_cache_duration'))));?>
		</div>
	<?php endif;?>
</div>
</div>
<?php 
	}
?>