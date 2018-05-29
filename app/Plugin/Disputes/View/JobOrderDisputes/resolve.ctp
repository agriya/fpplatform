<?php /* SVN: $Id: $ */ ?>

<div class="user-info-block-right1 clearfix ">
	<?php if($this->Auth->user('role_id') != ConstUserTypes::Admin):?>
		<?php if($dispute['DisputeStatus']['id'] != ConstDisputeStatus::WaitingForAdministratorDecision):?>
			<div class="page-information clearfix">	
				<p>
					<?php
						if($this->Auth->user('id') == $dispute['Job']['user_id']):
							$other_user = $this->Html->link($this->Html->cText($dispute['JobOrder']['User']['username']), array('controller'=> 'users', 'action'=>'view', $dispute['JobOrder']['User']['username']), array('escape' => false));
						else:
							$other_user = $this->Html->link($this->Html->cText($dispute['Job']['User']['username']), array('controller'=> 'users', 'action'=>'view', $dispute['Job']['User']['username']), array('escape' => false));
						endif;
					?>
					<?php echo __l("Auto Dispute Action:").' '.__l("If").' '.$other_user.' '.__l("makes a reply/opens a dispute, you need to make a reply within").' '."<b>".Configure::read('dispute.days_left_for_disputed_user_to_reply').__l('days')."</b>".' '.__l("in order to avoid making decision in favor of").' '.$other_user.__l(", after that it'll").' '.$other_user.' '.__l("turn to make a response until the same alloted days for him to avoid dispute be closed in favor of you.");?>
				</p>
				<p>
					<?php echo __l('Administrator Decision:').' '.__l('The administrator decision will takes place when the total converstation count for the dispute reaches').' '.Configure::read('dispute.discussion_threshold_for_admin_decision');?>
				</p>
			</div>
		<?php endif;?>
	<?php endif;?>

      <h3><?php echo __l('Dispute Information');?></h3>
	  <div class="clearfix">
		<div class="job-stats-left-block span12 pull-left omega alpha">
			<p class="job-stats-bar-block clearfix"><?php echo __l('Dispute ID').': '.'#';?><span class="stats-val"><?php echo $this->Html->cInt($dispute['JobOrderDispute']['id']); ?></span></p>
			<p><?php echo __l('Disputer').': ';?><span class="stats-val"><?php echo $this->Html->link($this->Html->cText($dispute['User']['username']), array('controller'=> 'users', 'action'=>'view', $dispute['User']['username']), array('escape' => false));?>
					<?php echo '('.ucfirst($dispute['JobUserType']['name']).')';?></span></p>	
			<p><?php echo __l('Dispute Status').': ';?><span class="stats-val"><?php echo $dispute['DisputeStatus']['name'];?>					
					<?php 
						if($dispute['DisputeStatus']['id'] == ConstDisputeStatus::Open):
							echo ' ('.__l("Waiting for response from the other user").')';
						elseif($dispute['DisputeStatus']['id'] == ConstDisputeStatus::UnderDiscussion):
							echo '('.__l("Converstation Underway").')';
						endif
					?></span></p>
			<p><?php echo __l('Last Replied').': ';?><span class="stats-val"><?php echo !empty($dispute['JobOrderDispute']['last_replied_date']) ? $this->Html->cDateTime($dispute['JobOrderDispute']['last_replied_date']) : __l('Not yet');?></span></p>
		</div>
		<div class="job-stats-right-block  span12 omega alpha">
		    <p><?php echo __l('Disputed On').': ';?><span class="stats-val"><?php echo $this->Html->cDateTime($dispute['JobOrderDispute']['created']);?></span></p>	
			<p><?php echo __l('Disputed').': ';?><span class="stats-val"><?php $disputed_user = ($dispute['User']['username'] == $dispute['Job']['User']['username']) ? $dispute['JobOrder']['User']['username']: $dispute['Job']['User']['username'];?>
					<?php echo $this->Html->link($this->Html->cText($disputed_user), array('controller'=> 'users', 'action'=>'view', $disputed_user), array('escape' => false));?>
					<?php echo ($dispute['JobOrderDispute']['job_user_type_id'] == ConstJobUserType::Seller) ? '('.__l("Buyer").')' : '('.__l("Seller").')';?></span>
		   </p>
		   <p><?php echo __l('Dispute Reason').': ';?><span class="stats-val"><?php echo $dispute['DisputeType']['name'];?></span></p>
		   <p><?php echo __l('Reason').': ';?><span class="stats-val"><?php echo $this->Html->cText($dispute['JobOrderDispute']['reason']);?></span></p>
		</div>
	  </div>
	</div>
<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin):?>
<div>
	<h3><?php echo __l('Dispute Actions');?></h3>
	<?php echo $this->Form->create('JobOrderDispute', array('action' => 'resolve', 'class' => 'form-horizontal normal'));?>
	<?php echo $this->Form->input('job_order_id', array('type' => 'hidden', 'value' => $dispute['JobOrderDispute']['job_order_id']));?>
		<div class="alert alert-info">
			<?php foreach($dispute_close_types as $dispute_close_type):?>
				<div class="space clearfix">
				<span class="pull-left"><?php echo $this->Form->submit($dispute_close_type['DisputeClosedType']['name'].' ['.$dispute_close_type['DisputeClosedType']['resolve_type'].']', array('name' => 'data[JobOrderDispute][close_type_'.$dispute_close_type['DisputeClosedType']['id'].']','class'=>'btn btn-primary','div'=>false));?></span>
				
				<div class="page-information clearfix">
					<span class="hor-space"><?php echo $dispute_close_type['DisputeClosedType']['reason'];?></span>
					<?php if($dispute_close_type['DisputeClosedType']['id'] == 7 || $dispute_close_type['DisputeClosedType']['id'] == 8 || $dispute_close_type['DisputeClosedType']['id'] == 9):?>
					<span>	<?php echo '('.__l("This action will be automatically be taken, if the disputer didn't reply in").' '.Configure::read('dispute.days_left_for_disputed_user_to_reply').__l('days').')';?></span>
					<?php endif;?>
				</div>
				</div>
			<?php endforeach;?>
		</div>
	<?php echo $this->Form->end();?>		
</div>
<?php endif;?>
