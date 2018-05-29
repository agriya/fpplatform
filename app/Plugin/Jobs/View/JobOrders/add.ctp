<div class="js-responses">
<section class="sep-bot top-smspace bot-mspace" >
	<div class="container clearfix">
		<h2><?php echo __l('Step 1/2');?></h2>
	</div>
</section>
<section class="top-mspace">
<div class="container">
	<div class="clearfix bot-mspace">
		<div class="span pull-left">
			<?php if(!empty($itemDetail['Attachment']['0'])){?>
				<p><?php echo $this->Html->link($this->Html->showImage('Job', $itemDetail['Attachment']['0'], array('dimension' => 'large_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($itemDetail['Job']['title'], false)),'class'=>'sep sep-big sep-black', 'title' => $this->Html->cText($itemDetail['Job']['title'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($itemDetail['Job']['amount']), false))), array('controller'=> 'jobs', 'action' => 'view', $itemDetail['Job']['slug']), array('class'=>'blackc', 'title' => $this->Html->cText($itemDetail['Job']['title'], false),'escape' => false));?></p>
			<?php }else{ ?>
				<p><?php $this->Html->showImage('Job', '', array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($itemDetail['Job']['title'], false)),'class'=>'sep sep-big sep-black', 'title' => $this->Html->cText($itemDetail['Job']['title'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($itemDetail['Job']['amount']), false)));?></p>
			<?php } ?>
			<div class="ratings-feedback clearfix dc">
						<?php if(Configure::read('job.rating_type') == 'percentage'):?>
						 <span class="inline"><span class="right-mspace"><i class="icon-thumbs-up-alt no-pad grayc"></i></span><span class="right-mspace"><?php echo $this->html->displayPercentageRating($itemDetail['Job']['job_feedback_count'], $itemDetail['Job']['positive_feedback_count']); ?></span></span>
							
						<?php else:?>
							<span class="inline"><span class="right-mspace"><i class="icon-thumbs-up-alt no-pad grayc"></i></span><span class="right-mspace"><?php echo $this->html->cInt($itemDetail['Job']['positive_feedback_count']); ?></span></span>
							<span class="inline"><span class="right-mspace"><i class="icon-thumbs-down-alt no-pad grayc"></i></span><span class="right-mspace"><?php echo $this->html->cInt($itemDetail['Job']['job_feedback_count'] - $itemDetail['Job']['positive_feedback_count']); ?></span></span>
						<?php endif;?>
				</div>
		</div>
		<div class="pull-left  left-space clearfix">
		<div class="clearfix span14 bot-mspace">
			<h3 class="text-18 no-mar clearfix ">
			<span class="pull-left top-smspace" title="<?php echo $itemDetail['JobType']['name']; ?>">
				<i class="icon-desktop top-space right-mspace <?php echo ($itemDetail['JobType']['id'] == ConstJobType::Online)?'greenc':'grayc'; ?>"></i>
			</span>
			<?php echo $this->Html->link($this->Html->cText($itemDetail['Job']['title'], false), array('controller'=> 'jobs', 'action' => 'view', $itemDetail['Job']['slug']), array('class'=>'blackc', 'title' => $this->Html->cText($itemDetail['Job']['title'], false),'escape' => false));?>
			</h3>
			</div>
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
			<p class="top-space span5 htruncate" title="<?php echo $this->Html->cText($itemDetail['Job']['description'],false);?>"><?php echo $this->Html->cText($itemDetail['Job']['description']);?></p>
			<div class="clearfix">

				
			</div>
		</div>		
		<div class="pull-right ">				
				<div class="job-price">
					<p class="amt"><?php echo $this->Html->siteCurrencyFormat($itemDetail['Job']['amount']);?></p>
				</div>
			</div>
	</div>
	<?php if(!empty($itemDetail)):?>
	<?php
		echo $this->Form->create('JobOrder', array('controller' => 'job_orders', 'action'=> 'add', 'class' => 'normal form-horizontal js-dynm-add-map ', 'enctype' => 'multipart/form-data'));
		echo $this->Form->input('job_id', array('type' => 'hidden', 'value' => (!empty($this->request->params['named']['job']))?$this->request->params['named']['job']:''));
		echo $this->Form->input('id', array('type' => 'hidden', 'value' => !empty($this->request->params['named']['order_id'])?$this->request->params['named']['order_id']:''));

		if(!empty($itemDetail['Job']['is_instruction_requires_attachment']) || !empty($itemDetail['Job']['is_instruction_requires_input'])): ?>
			<fieldset class="form-block round-5">
				<?php if(!empty($itemDetail['Job']['instruction_to_buyer'])): ?>
					<p class="alert alert-warning">
						<b><?php echo __l('Instruction from seller');?></b>
						<?php echo $this->Html->cText($itemDetail['Job']['instruction_to_buyer']); ?>
					</p>
				<?php endif; ?> 
				<legend class="round-5"><?php echo __l('Prerequirements');?></legend>
				<div class="required">
					<?php
					if(!empty($itemDetail['Job']['is_instruction_requires_attachment'])): 
						echo $this->Form->input('Attachment.filename', array('type' => 'file','label' => __l('Attachment')));
						if(!empty($userProfile['Attachment'][0])){
							echo "<span class=\"info\">".__l('Previously attached').' "'.$userProfile['Attachment'][0]['filename']."\". (Attaching again will replace the existing one)"."</span>";
						}
					endif;
					?>
				</div>
				<?php
				if(!empty($itemDetail['Job']['is_instruction_requires_input'])): 
					echo $this->Form->input('information_from_buyer', array('label' => __l('Note'), 'class' => 'span17'));
				endif;
				?>
			</fieldset>
		<?php endif;?>
		<?php if($itemDetail['Job']['job_type_id'] == ConstJobType::Offline && $itemDetail['Job']['job_service_location_id'] == ConstServiceLocation::SellerToBuyer):?>
			<fieldset class="form-block round-5">
				<div class="alert alert-info"><?php echo __l('You need to enter your contact information for this type of order, so seller can know your exact location for doing this').' '.jobAlternateName(ConstJobAlternateName::Singular);?></div>
				<legend class="round-5"><?php echo __l('Contact information');?></legend>
				<div class="option-block clearfix">
					<?php
					echo $this->Form->input('address', array('id' => 'JobAddress_colbx', 'label' => __l('Address')));
					echo $this->Form->input('mobile', array('label' => __l('Mobile')));
					echo $this->Form->input('latitude', array('id' => 'JobLatitude_colbx', 'type' => 'hidden'));
					echo $this->Form->input('longitude', array('id' => 'JobLongitude_colbx', 'type' => 'hidden'));
					echo $this->Form->input('zoom_level', array('id' => 'JobZoomLevel_colbx', 'type' => 'hidden'));
					?>
					<div class="show-map" style="display:block;">
						<div id="js-colorbox-map-container"></div>
					</div>
				</div>
			</fieldset>
		<?php endif;?>
		<div class="well no-bor no-shad clearfix">
			<?php echo $this->Form->submit(__l('Continue'),array('class'=>'js-no-pjax btn btn-warning textb btn-large text-20','div'=>'submit pull-right no-mar'));?>
		</div>
		<?php echo $this->Form->end();?>
	<?php endif;?>
	</div>
</section>
</div>