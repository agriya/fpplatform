<?php /* SVN: $Id: $ */ ?>
<div class="jobOrderDisputes js-responses">
<?php
	if(empty($is_under_dispute)){
		if(!empty($disputeTypes)){
	?>
	<?php echo $this->Form->create('JobOrderDispute', array('class' => 'form-horizontal normal'));?>
			<?php
				echo $this->Form->input('user_id', array('type' => 'hidden'));
				echo $this->Form->input('job_id', array('type' => 'hidden'));
				echo $this->Form->input('job_order_id', array('type' => 'hidden'));
				echo $this->Form->input('job_user_type_id', array('type' => 'hidden'));
				echo $this->Form->input('dispute_type_id', array('options' => $disputeTypes));
				echo $this->Form->input('reason');
			?>
        <div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Submit Dispute'), array('class' => "btn btn-warning"));?>
		</div>
			<?php echo $this->Form->end();?>
	<?php 
	}else{?>
		<div class="alert alert-info top-mspace  clearfix">
			<h5><?php echo __l("Dispute is possible only for the following cases."); ?></h5>
				<?php
				echo "<ol class='graydarkerc'>";
				foreach($AlldisputeTypes as $AlldisputeType){
					echo "<li>".$AlldisputeType."</li>";
				}
				echo "</ol>";
				echo '<span class="show grayc left-mspace left-space">'.__l("Currently, Your order hasn't met those cases.").'</span>';
			?>
			
		</div>
	<?php
	}
}else{
?>
	<div class="alert-info clearfix">
		<?php
			echo __l("Current dispute for this order hasn't been closed yet. Only one dispute at a time for an order is possible.");
		?>
	</div>
<?php
}
?>
</div>
