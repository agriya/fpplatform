<?php /* SVN: $Id: $ */ ?>
<div class="jobFeedbacks form clearfix">

<?php echo $this->Form->create('JobFeedback', array('class' => 'form-horizontal normal'));?>

	<div class="massage-view-block clearfix">
	<?php
		echo $this->Form->input('job_id',array('type'=>'hidden','value' => $message['job_id']));
		echo $this->Form->input('job_order_id',array('type'=>'hidden','value' => $message['job_order_id']));
		echo $this->Form->input('user_id',array('type'=>'hidden','value' => $this->Auth->user('id')));
		echo $this->Form->input('job_order_user_id',array('type'=>'hidden','value' => $message['job_order_user_id']));
		echo $this->Form->input('job_order_user_email',array('type'=>'hidden','value' => $message['job_seller_email']));
		?>
      <div class="massage-head">
        <h5 class="message-user-info">
      <?php	echo 'Message from '.$this->Html->link($this->Html->cText($message['job_username'],false), array('controller'=> 'users', 'action' => 'view', $message['job_username']), array('title' => $this->Html->cText($message['job_username'],false),'escape' => false));?>
        </h5>
      <?php
		$replace = array('##REVIEW##' => '', '##NEWORDER##' => '');
		$message_content =  strtr($message['message'],$replace);
		echo nl2br($message_content);
	?>		<?php
		if (!empty($message['attachment'])) :
			?>
			<h4><?php echo count($message['attachment']).' '. __l('attachments');?></h4>
			<ul>
			<?php
			foreach($message['attachment'] as $attachment) :
		?>
			<li>
			<span class="attachement"><?php echo $attachment['filename']; ?></span>
			<span><?php echo bytes_to_higher($attachment['filesize']); ?></span>
			<span><?php echo $this->Html->link(__l('Download') , array( 'controller' => 'messages', 'action' => 'download', $message['message_hash'], $attachment['id']),array('class'=>'js-no-pjax')); ?></span>
			</li>
		<?php
			endforeach;
		?>
		</ul>
		<?php
		endif;
		?>
		<div>
			<p>
				<?php echo __l('Problem With Your Order? ').' '.$this->Html->link(__l('Report it Here...'), array('controller' => 'messages', 'action' => 'activities', 'type' => 'myorders', 'order_id' => $message['job_order_id']));?>
			</p>
		</div>
		</div>

	<div class="jobs-download-block">
		<div class="click-info">
		<?php
			echo $this->Form->input('is_satisfied',array('label' => __l('Satisfied'), 'type'=>'radio','legend'=>__l('Are you satisfied with the work?'),'options'=>array('1'=>__l('Yes'),'0'=>__l('No')),'class' => 'js-feedback-toggle-check' ));
		?>
		</div>
		<div class="js-negative-block <?php echo ($this->request->data['JobFeedback']['is_satisfied'] == 0) ? '' : 'hide'; ?>">
			<p class="negative-block-info"><?php echo __l('Please give your seller a chance to improve his work before submitting a negative review. ').' '.$this->Html->link(__l('Contact Your Seller'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $message['job_seller_username'],'job_order_id' => $message['job_order_id'], 'review' => '1'), array('title' => __l('Contact Your Seller')));?></p>
		</div>
		<?php
			echo $this->Form->input('feedback',array('label' => __l('Review')));
		?>
	<div class="clearfix submit-block">
<?php echo $this->Form->submit(__l('Submit'));?>
</div>
	</div>
</div>
<?php echo $this->Form->end();?>

</div>