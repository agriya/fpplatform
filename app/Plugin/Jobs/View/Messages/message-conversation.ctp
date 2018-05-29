<ol class="unstyled activities-list">
	<?php
    if (!empty($messages)) :
        foreach($messages as $message):
	?>
		<?php if(!empty($message['Message']['job_order_status_id'])):?>
		
			<!-- DISPUTE -->
			<?php if(!empty($message['Message']['job_order_dispute_id']) && ($message['Message']['job_order_status_id'] == ConstJobOrderStatus::DisputeOpened || $message['Message']['job_order_status_id'] == ConstJobOrderStatus::DisputeClosed)):?>
			<?php
				$avatar_positioning_class = "avatar_middle_container";
				$user_type_container_class = "activities_system_container";
			?>
			<li class="clearfix ver-space">
            <div class="span4 ver-smspace dr mob-dc text-16 date-info grayc">
			<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
			</div>
            <div class="pull-right mob-clr mob-dc sep pr activity-content">
              <div class="span18 no-mar right-arrow space">
                <div class="span4 no-mar top-space">
				<?php if($message['Message']['job_order_status_id'] == ConstJobOrderStatus::DisputeOpened):?>
						<?php $status_message =  __l('Dispute - Opened');?>
					<?php elseif($message['Message']['job_order_status_id'] == ConstJobOrderStatus::DisputeClosed):?>
						<?php $status_message = __l('Dispute - Closed');?>					
					<?php else:?>
						<?php $status_message = __l('Dispute');?>					
					<?php endif;?>
					<span title="<?php echo $status_message; ?>" class="in-progress dc span3 hor-mspace bot-space mob-no-mar">
					<?php echo $status_message; ?>
					</span>
				</div>
				<?php if($message['Message']['user_id'] == $message['JobOrder']['owner_user_id']): // if message is to seller, then, requester is buyer //
						$avatar_positioning_class = "avatar_right_container";
						$user_type_container_class = "activities_buyer_container";
						$avatar = $message['JobOrder']['User'];						
						elseif($message['Message']['user_id'] == $message['JobOrder']['user_id']): // if message is to buyer, then, requester is seller //
							$avatar_positioning_class = "avatar_left_container";
							$user_type_container_class = "activities_seller_container";
							$avatar = $message['Job']['User'];
						endif; ?>

                <div class="span14 no-mar top-space grayc">
				<?php echo $this->Html->link($this->Html->showImage('UserAvatar', $avatar['UserAvatar'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($avatar['username'], false)), 'class' => 'img-rounded', 'title' => $this->Html->cText($avatar['username'], false)), false), array('controller'=> 'users', 'action' => 'view', $avatar['username']), array('class' => 'show pull-left mob-inline right-space user-thumb', 'title' => $this->Html->cText($avatar['username'],false),'escape' => false));?>
					<?php echo $this->Html->link($this->Html->cText($avatar['username'], false), array('controller'=> 'users', 'action' => 'view', $avatar['username']), array('class' => 'graydarkerc', 'title' => $this->Html->cText($avatar['username'],false),'escape' => false));?>
                  <p><?php echo $this->Html->cText($message['MessageContent']['subject'], false);?></p>
                </div>
              </div>
            </div>
          </li>
			<?php endif;?>
			
			<!-- DISPUTE CONVERSATION -->
			<?php if(!empty($message['Message']['job_order_dispute_id']) && ($message['Message']['job_order_status_id'] == ConstJobOrderStatus::DisputeConversation || $message['Message']['job_order_status_id'] == ConstJobOrderStatus::DisputeAdminAction || $message['Message']['job_order_status_id'] == ConstJobOrderStatus::AdminDisputeConversation)):?>
			<?php
				if($message['Message']['job_order_status_id'] == ConstJobOrderStatus::DisputeConversation):
					$status_message = __l('Dispute - Converstation');
					if($message['Message']['user_id'] == $message['JobOrder']['owner_user_id']): // if message is to seller, then, requester is buyer //
						$avatar_positioning_class = "avatar_right_container";
						$user_type_container_class = "activities_buyer_container";
						$avatar = $message['JobOrder']['User'];						
					elseif($message['Message']['user_id'] == $message['JobOrder']['user_id']): // if message is to buyer, then, requester is seller //
						$avatar_positioning_class = "avatar_left_container";
						$user_type_container_class = "activities_seller_container";
						$avatar = $message['Job']['User'];
					endif;
				elseif($message['Message']['job_order_status_id'] == ConstJobOrderStatus::DisputeAdminAction):
					$avatar_positioning_class = "avatar_middle_container";
					$user_type_container_class = "activities_system_container";
					$status_message = __l('Dispute - Waiting for Administrator Decision');
				elseif($message['Message']['job_order_status_id'] == ConstJobOrderStatus::AdminDisputeConversation):
					$status_message = __l('Dispute - Converstation');
					$avatar_positioning_class = "avatar_right_container";
					$user_type_container_class = "activities_buyer_container";
					$avatar = $message['OtherUser'];
				endif;
			?>
			<li class="clearfix ver-space">
            <div class="span4 ver-smspace dr mob-dc text-16 date-info grayc">
			<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
			</div>
            <div class="pull-right mob-clr mob-dc sep pr activity-content">
              <div class="span18 no-mar right-arrow space">
                <div class="span4 no-mar top-space">
					<span title="<?php echo $status_message; ?>" class="in-progress dc span3 hor-mspace bot-space mob-no-mar">
					<?php echo $status_message; ?>
					</span>
				</div>
				<div class="span14 no-mar top-space grayc grayc">
                  <p class="clearfix">
					<?php echo $this->Html->link($this->Html->showImage('UserAvatar', $avatar['UserAvatar'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($avatar['username'], false)), 'class' => 'img-rounded', 'title' => $this->Html->cText($avatar['username'], false)), false), array('controller'=> 'users', 'action' => 'view', $avatar['username']), array('class' => 'show pull-left mob-inline right-space user-thumb', 'title' => $this->Html->cText($avatar['username'],false),'escape' => false));?>
					<?php echo $this->Html->link($this->Html->cText($avatar['username'], false), array('controller'=> 'users', 'action' => 'view', $avatar['username']), array('class' => 'graydarkerc', 'title' => $this->Html->cText($avatar['username'],false),'escape' => false));?>
				  <span class="hor-space"><?php echo $this->Html->cText($message['MessageContent']['message'], false);?></span></p>
                </div>
              </div>
            </div>
          </li>
			<?php endif;?>
			
			<!-- WORK DELIVERED/REVIEWED -->
			<?php if(!empty($message['Message']['job_order_status_id']) && ($message['Message']['job_order_status_id'] == ConstJobOrderStatus::WorkDelivered || $message['Message']['job_order_status_id'] == ConstJobOrderStatus::WorkReviewed)):?>
				<?php
					if($message['Message']['job_order_status_id'] == ConstJobOrderStatus::WorkDelivered):
						$avatar_positioning_class = "avatar_left_container";
						$user_type_container_class = "activities_seller_container";
						$avatar = $message['Job']['User'];
					elseif($message['Message']['job_order_status_id'] == ConstJobOrderStatus::WorkReviewed):
						$avatar_positioning_class = "avatar_right_container";
						$user_type_container_class = "activities_buyer_container";
						$avatar = $message['JobOrder']['User'];
					endif;
				?>
				<li class="clearfix ver-space">
            <div class="span4 ver-smspace dr mob-dc text-16 date-info grayc"><?php echo $this->Time->timeAgoInWords($message['Message']['created']);?></div>
            <div class="pull-right mob-clr mob-dc sep pr activity-content">
              <div class="span18 no-mar right-arrow space">
                <div class="span4 no-mar top-space">
					<?php if($message['Message']['job_order_status_id'] == ConstJobOrderStatus::WorkReviewed):?>
							<?php $status_message = __l('Feedback');?>
						<?php else:?>
							<?php $status_message = __l('Conversation');?>
					<?php endif;?>						
				<span title="<?php echo $status_message;?>" class="conversation dc span3 hor-mspace bot-space mob-no-mar"><?php echo $status_message;?></span></div>
				<div class="span14 no-mar top-space grayc grayc">
                  <p class="clearfix">
					<?php echo $this->Html->link($this->Html->showImage('UserAvatar', $avatar['UserAvatar'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($avatar['username'], false)), 'class' => 'img-rounded', 'title' => $this->Html->cText($avatar['username'], false)), false), array('controller'=> 'users', 'action' => 'view', $avatar['username']), array('class' => 'show pull-left mob-inline right-space user-thumb', 'title' => $this->Html->cText($avatar['username'],false),'escape' => false));?>
					<?php echo $this->Html->link($this->Html->cText($avatar['username'], false), array('controller'=> 'users', 'action' => 'view', $avatar['username']), array('class' => 'graydarkerc', 'title' => $this->Html->cText($avatar['username'],false),'escape' => false));?>
				  <span class="hor-space"><?php echo $this->Html->cText($message['MessageContent']['message'], false);?></span></p>
				  <ul class="attachement-list unstyled">
					<?php
						$attachment = !empty($message['MessageContent']['Attachment']['0']) ? $message['MessageContent']['Attachment']['0'] : '';
						if (!empty($message['MessageContent']['Attachment']['0'])) :
							echo "<li>".'<i class="icon-download-alt greenc"></i>'.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']),array('class'=>'js-no-pjax bluec'))."</li>";
						endif;
					?>
				</ul>
                </div>

				<?php if($message['Message']['job_order_status_id'] == ConstJobOrderStatus::WorkReviewed && !empty($message['JobOrder']['JobFeedback'])):?>
					<?php $rating_class = ($message['JobOrder']['JobFeedback']['is_satisfied']) ? 'positive-feedback' : 'negative-feedback';?>
					(<span class="feedback-list <?php echo $rating_class;?>"><?php echo ($message['JobOrder']['JobFeedback']['is_satisfied']) ? __l('Rated Positive') : __l('Rated Negative');?></span>)
				<?php endif;?>
				
              </div>
				
            </div>
          </li>
			<?php endif;?>
			<!-- ORDER STATUS CHANGED -->
			<?php if($message['Message']['job_order_status_id'] != ConstJobOrderStatus::SenderNotification && $message['Message']['job_order_status_id'] != ConstJobOrderStatus::MutualCancelRequest && $message['Message']['job_order_status_id'] != ConstJobOrderStatus::MutualCancelRejected && $message['Message']['job_order_status_id'] != ConstJobOrderStatus::RedeliverRequest && $message['Message']['job_order_status_id'] != ConstJobOrderStatus::RedeliverRequestCancel && $message['Message']['job_order_status_id'] != ConstJobOrderStatus::RedeliverRejected && $message['Message']['job_order_status_id'] != ConstJobOrderStatus::WorkDelivered  && $message['Message']['job_order_status_id'] != ConstJobOrderStatus::WorkReviewed && empty($message['Message']['job_order_dispute_id'])):?>
				<?php
					$avatar_positioning_class = '';
					$avatar = array();
					// Avatar positioning //
						$avatar_positioning_class = "avatar_middle_container";
						$user_type_container_class = "activities_system_container";
						if($message['Message']['job_order_status_id'] == ConstJobOrderStatus::CancelledByAdmin || $message['Message']['job_order_status_id'] == ConstJobOrderStatus::CompletedAndClosedByAdmin):
							$user_type_container_class = "activities_administrator_container";
							$avatar_positioning_class = "avatar_admin_container";
						endif;
					// Eop //
				
				?>
				<li class="clearfix ver-space">
				<div class="span4 ver-smspace dr mob-dc text-16 date-info grayc">
					<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
				</div>
				<div class="pull-right mob-clr mob-dc sep pr activity-content">
				  <div class="span18 no-mar right-arrow space">
					<div class="span4 no-mar top-space"><span title="<?php echo $message['JobOrderStatus']['name'];?>" class="<?php echo $message['JobOrderStatus']['slug'];?> dc span3 hor-mspace bot-space mob-no-mar htruncate-ml2"><?php echo $message['JobOrderStatus']['name'];?></span></div>
					<div class="span14 no-mar top-space grayc">
					  <p><?php echo $this->Html->conversationDescription($message);?></p>
					</div>
				  </div>
				</div>
				</li>
			<?php endif;?>
			
			<!-- MUTUAL/REDELIVER REQUEST -->
			<?php if(($message['Message']['job_order_status_id'] == ConstJobOrderStatus::MutualCancelRequest || $message['Message']['job_order_status_id'] == ConstJobOrderStatus::RedeliverRequest || $message['Message']['job_order_status_id'] == ConstJobOrderStatus::RedeliverRejected || $message['Message']['job_order_status_id'] == ConstJobOrderStatus::RedeliverRequestCancel || $message['Message']['job_order_status_id'] == ConstJobOrderStatus::MutualCancelRejected) && empty($message['Message']['job_order_dispute_id'])):?>
			<?php
				$avatar_positioning_class = '';
				$mut_cancel_class = 'activities-mutual_cancel_request';				
				$avatar = array();
				$avatar_positioning_class = "avatar_middle_container";
				$user_type_container_class = "activities_system_container";				
				if($message['Message']['job_order_status_id'] == ConstJobOrderStatus::MutualCancelRequest):
					$status_name = __l('Mutual cancel requested');
				elseif($message['Message']['job_order_status_id'] == ConstJobOrderStatus::MutualCancelRejected):
					$status_name = __l('Mutual cancel request - rejected');
				endif;
				if($message['Message']['job_order_status_id'] == ConstJobOrderStatus::RedeliverRejected):
					$status_name = __l('Redeliver request - rejected');
					$mut_cancel_class = 'activities-mutual_cancel_rejected';
				elseif($message['Message']['job_order_status_id'] == ConstJobOrderStatus::RedeliverRequest):				
					$status_name = __l('Redeliver requested');
				elseif($message['Message']['job_order_status_id'] == ConstJobOrderStatus::RedeliverRequestCancel):
					$status_name = __l('Redeliver request - cancelled');
				endif;
			?>		
			<li class="clearfix ver-space">
            <div class="span4 ver-smspace dr mob-dc text-16 date-info grayc"><?php echo $this->Time->timeAgoInWords($message['Message']['created']);?></div>
            <div class="pull-right mob-clr mob-dc sep pr activity-content">
              <div class="span18 no-mar right-arrow space">
                <div class="span4 no-mar top-space"><span title="In progress" class="in-progress dc span3 hor-mspace bot-space mob-no-mar"><?php echo $status_name;?></span></div>
                <div class="span14 no-mar top-space grayc">
                  <p><?php echo $this->Html->cText($message['MessageContent']['subject'], false);?></p>
                </div>
              </div>
            </div>
          </li>
			<?php endif;?>
		<?php else:?>
		
		<!-- NORMAL CONVERSATION -->
		<?php
			$avatar_positioning_class = '';
			$avatar = array();
			if($message['Message']['user_id'] == $message['JobOrder']['owner_user_id']): // if message is to seller, then, requester is buyer //
				$avatar_positioning_class = "avatar_right_container";
				$user_type_container_class = "activities_buyer_container";
				$avatar = $message['JobOrder']['User'];
				$status_name = __l('Mutual cancel request');
			elseif($message['Message']['user_id'] == $message['JobOrder']['user_id']): // if message is to buyer, then, requester is seller //
				$avatar_positioning_class = "avatar_left_container";
				$user_type_container_class = "activities_seller_container";
				$avatar = $message['Job']['User'];
				$status_name = __l('Mutual cancel request');
			endif;
		?>
		<li class="clearfix ver-space">
            <div class="span4 ver-smspace dr mob-dc text-16 date-info grayc">
			<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
			</div>
            <div class="pull-right mob-clr mob-dc sep pr activity-content">
              <div class="span18 no-mar right-arrow space">
                <div class="span4 no-mar top-space"><span title="<?php echo __l('Conversation')?>" class="conversation dc span3 hor-mspace bot-space mob-no-mar"><?php echo __l('Conversation')?></span></div>
                <div class="span14 no-mar top-space grayc grayc">
                  <p class="clearfix">
					<?php echo $this->Html->link($this->Html->showImage('UserAvatar', $avatar['UserAvatar'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($avatar['username'], false)), 'class' => 'img-rounded', 'title' => $this->Html->cText($avatar['username'], false)), false), array('controller'=> 'users', 'action' => 'view', $avatar['username']), array('class' => 'show pull-left mob-inline right-space user-thumb', 'title' => $this->Html->cText($avatar['username'],false),'escape' => false));?>
					<?php echo $this->Html->link($this->Html->cText($avatar['username'], false), array('controller'=> 'users', 'action' => 'view', $avatar['username']), array('class' => 'graydarkerc', 'title' => $this->Html->cText($avatar['username'],false),'escape' => false));?>
				  <span class="hor-space"><?php echo $this->Html->cText($message['MessageContent']['message'], false);?></span></p>
				  <ul class="unstyled clearfix">
					<?php
						$attachment = $message['MessageContent']['Attachment']['0'];
						if (!empty($message['MessageContent']['Attachment']['0'])) :
							echo "<li>".'<i class="icon-download-alt greenc"></i>'.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']),array('class'=>'js-no-pjax bluec'))."</li>";
						endif;
					?>
					</ul>
                </div>
              </div>
            </div>
          </li>
		<?php endif;?>
        <?php
        endforeach;
    endif;
    ?>
</ol>