<?php /* SVN: $Id: $ */ ?>
<?php
if(!empty($this->request->params['isAjax'])):
		echo $this->element('flash_message');
endif;
?>
<div class="payments order js-main-order-block js-responses container  top-space">
	<?php if(!empty($this->request->params['named']['order_id'])):?>
		<h2><?php echo __l('Step 2/2');?></h2>
	<?php endif;?>
	<div class="clearfix row-fluid">
		<div class="clearfix span23 bot-space">
			<div class="clearfix span5">
			<?php if(!empty($itemDetail['Attachment']['0'])){?>
				<?php echo $this->Html->link($this->Html->showImage('Job', $itemDetail['Attachment']['0'], array('dimension' => 'large_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($itemDetail['Job']['title'], false)),'class'=>'sep sep-big sep-black', 'title' => $this->Html->cText($itemDetail['Job']['title'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($itemDetail['Job']['amount']), false))), array('controller'=> 'jobs', 'action' => 'view', $itemDetail['Job']['slug']), array('class'=>'blackc', 'title' => $this->Html->cText($itemDetail['Job']['title'], false),'escape' => false));?>
			<?php }else{ ?>
				<?php $this->Html->showImage('Job', '', array('dimension' => 'large_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($itemDetail['Job']['title'], false)),'class'=>'sep sep-big sep-black', 'title' => $this->Html->cText($itemDetail['Job']['title'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($itemDetail['Job']['amount']), false)));?>
			<?php } ?>
			</div>
		<div class="span14">
			<h3 class="text-18 no-mar clearfix">
			<span class="pull-left top-smspace" title="<?php echo $itemDetail['JobType']['name']; ?>">
				<i class="icon-desktop top-space right-mspace <?php echo ($itemDetail['JobType']['id'] == ConstJobType::Online)?'greenc':'grayc'; ?>"></i>
			</span>
			<?php echo $this->Html->link($this->Html->cText($itemDetail['Job']['title'], false), array('controller'=> 'jobs', 'action' => 'view', $itemDetail['Job']['slug']), array('class'=>'blackc', 'title' => $this->Html->cText($itemDetail['Job']['title'], false),'escape' => false));?>
			</h3>
			<div class="clearfix textb top-space">
				<p><span><?php echo ' ('.__l('by').' '.$this->Html->link($this->Html->cText($itemDetail['User']['username']), array('controller'=> 'users', 'action' => 'view', $itemDetail['User']['username']), array('title' => $this->Html->cText($itemDetail['User']['username'],false),'escape' => false));?><?php echo ' '.__l('on');?></span><?php echo ' '.$this->Time->timeAgoInWords($itemDetail['Job']['created']).') '; ?>
				<?php if(($itemDetail['Job']['is_featured'])) { ?><span class="label label-info">Featured</span> <?php } ?></p>
				<?php if(!empty ($itemDetail['JobServiceLocation']['name']) && $itemDetail['Job']['job_type_id'] != ConstJobType::Online): ?>
					<?php if($itemDetail['Job']['job_service_location_id'] == ConstServiceLocation::BuyerToSeller) { ?>
						<span class="label label-success"><?php echo $itemDetail['JobServiceLocation']['name']; ?> </span>
					<?php } else{ ?>
						<span class="label label-important"><?php echo $itemDetail['JobServiceLocation']['name']; ?> </span>
					<?php } ?>
				<?php  endif; ?>
			</div>
			<p class="top-space"><?php echo $this->Html->truncate($itemDetail['Job']['description'],36);?></p>
			<div class="clearfix">

				<div class="ratings-feedback clearfix">
						<?php if(Configure::read('job.rating_type') == 'percentage'):?>
							<span class="inline"><span class="right-mspace"><i class="icon-thumbs-up-alt no-pad grayc"></i></span><span class="right-mspace"><?php echo $this->Html->displayPercentageRating($itemDetail['Job']['job_feedback_count'], $itemDetail['Job']['positive_feedback_count']); ?></span></span>
						<?php else:?>
							<span class="inline"><span class="right-mspace"><i class="icon-thumbs-up-alt no-pad grayc"></i></span><span class="right-mspace"><?php echo $this->html->cInt($itemDetail['Job']['positive_feedback_count']); ?></span></span>
							<span class="inline"><span class="right-mspace"><i class="icon-thumbs-down-alt no-pad grayc"></i></span><span class="right-mspace"><?php echo $this->html->cInt($itemDetail['Job']['job_feedback_count'] - $itemDetail['Job']['positive_feedback_count']); ?></span></span>
							
						<?php endif;?>


					<span class="total-views textb" title="<?php echo __l('Total Views');?>"><?php echo __l('Total Views');?></span>
					<span><?php echo $this->Html->cInt($itemDetail['Job']['job_view_count']);?></span>
				</div>
			</div>
		</div>		
		</div>
		<div class="pull-right">				
			<div class="job-price">
				<p class="amt"><?php echo $this->Html->siteCurrencyFormat($itemDetail['Job']['amount']);?></p>
			</div>
		</div>
	</div>
			<?php 
			echo $this->Form->create('Payment', array('action' => 'order', 'id' => 'PaymentOrderForm', 'class' => 'normal form-horizontal submit-form'));
            ?>
            <?php
        	echo $this->Form->input('item_id', array('type' => 'hidden'));
			if(!empty($this->request->params['named']['order_id'])):
				echo $this->Form->input('order_id', array('type' => 'hidden', 'value' => $this->request->params['named']['order_id']));
			endif;
			echo $this->Form->input('payment_type', array('type' => 'hidden', 'id' => 'js-payment-type'));
			echo $this->Form->input('type', array('type' => 'hidden'));	?>
			<?php
				if (isset($this->request->data['Payment']['wallet']) && $this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && !empty($sudopay_gateway_settings) && $sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
						echo $this->element('sudopay_button', array('data' => $sudopay_data, 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
				} else{
				 ?>
					<div class="clearfix states-block payment-states-block">
					<div class="js-paypal-main">
						<!-- USING CONNECT -->
					 <div class="clearfix paypal-block round-3">
						<fieldset class="fields-block grid_left suffix_2">
						<legend><?php echo __l('Select Payment Type'); ?></legend>
						<?php  echo $this->element('payment-get_gateways', array('model' => 'Payment','type' => 'is_enable_for_job_order', 'foreign_id' => $itemDetail['Job']['user_id'], 'is_enable_wallet' => 1, 'cache' => array('cache' => array('config' => 'sec'))));?>
						</fieldset>
						</div>
					</div>
					</div>
			<? } ?>
			
			<?php echo $this->Form->end();?>				
</div>