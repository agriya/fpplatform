<div class="messages index message-compose-block js-responses">
<?php
if(!empty($this->request->params['isAjax'])):
		echo $this->element('flash_message');
endif;
?>
<?php //echo '<pre>'; print_r($this->request->data); exit;?>
<?php echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'compose normal form-horizontal js-ajax-form', 'enctype' => 'multipart/form-data')); ?>
<?php
// Delivery
if((!empty($this->request->params['named']['order']) == 'deliver' || (!empty($this->request->data['Message']['contact_type']) && $this->request->data['Message']['contact_type'] == 'deliver')) && ($this->request->data['Message']['contact_type'] != 'contact')): ?>
	<div class="page-information clearfix">
		<p><?php	echo __l('Buyer: '). $this->Html->link($this->request->data['Message']['to_username'], array('controller' => 'user', 'action' => 'view', $this->request->data['Message']['to_username'])); ?></p>
		<p class="ordered-date"><?php	echo __l('Ordered Date: '). $this->Html->cDateTime($this->request->data['Message']['ordered_date']); ?></p>
		<p><?php	echo __l('On time Delivery: ');?>
		<?php if($this->request->data['Message']['on_time_delivery'] == 'Yes'):?>
			<span class="yes">
				<?php echo $this->request->data['Message']['on_time_delivery']; ?>
			</span>
		<?php elseif($this->request->data['Message']['on_time_delivery'] == 'No'):?>
			<span class="no">
				<?php echo $this->request->data['Message']['on_time_delivery']; ?>
			</span>
		<?php endif;?>
		</p>
	</div>
	
<?php endif; ?>
<div>
<?php if(!empty($this->request->params['named']['order']) == 'deliver' || (!empty($this->request->data['Message']['contact_type']) && $this->request->data['Message']['contact_type'] == 'deliver')): ?>
<div class="page-information">
			<div class="alert alert-info"><?php echo __l('Tip: ');?><?php echo __l('It is a good idea to provide proof of your completed work');?></div>
		</div>
			<?php  endif;
				echo $this->Form->input('is_from_activities', array('type' => 'hidden', 'value' => 1));
				echo $this->Form->input('parent_message_id', array('type' => 'hidden'));
				echo $this->Form->input('type', array('type' => 'hidden'));
					if(!empty($this->request->data['Message']['to_username'])):
						echo $this->Form->input('to_username', array('type' => 'hidden', 'id' => 'message-to'));
						echo $this->Form->input('to', array('type' => 'hidden', 'id' => 'message-to-name', 'value' => $this->request->data['Message']['to_username']));
					else:
						echo $this->Form->input('to', array('type' => 'hidden', 'id' => 'message-to'));
					endif;
					if(!empty($this->request->data['Message']['contact_type']) && ($this->request->data['Message']['contact_type'] == 'deliver')):
							echo $this->Form->input('subject', array('id' => 'MessSubject', 'type' => 'hidden', 'label' => __l('Subject')));
						else:
							echo $this->Form->input('subject', array('id' => 'MessSubject', 'label' => __l('Subject')));
					endif;
					if(!empty($this->request->data['Message']['job_id'])):
						echo $this->Form->input('job_id', array('type' => 'hidden'));
					endif;
					if(!empty($this->request->data['Message']['job_slug'])):
						echo $this->Form->input('job_slug', array('type' => 'hidden'));
					endif;
					if(!empty($this->request->data['Message']['job_name'])):
						echo $this->Form->input('job_name', array('type' => 'hidden'));
					endif;
					if(!empty($this->request->data['Message']['job_order_id'])):
						echo $this->Form->input('job_order_id', array('type' => 'hidden'));
					endif;
					if((!empty($this->request->params['named']['review']) && ($this->request->params['named']['review'] == '1')) || (!empty($this->request->data['Message']['job_is_from_review']) || (!empty($this->request->data['Message']['is_review'])))):
						echo $this->Form->input('job_is_from_review', array('type' => 'hidden', 'value' =>  1));
					endif;
					echo $this->Form->input('on_time_delivery', array('type' => 'hidden'));
					echo $this->Form->input('ordered_date', array('type' => 'hidden'));
					echo $this->Form->input('job_amount', array('type' => 'hidden'));
					echo $this->Form->input('contact_type', array('type' => 'hidden'));
            ?>
			<div class="input required message-lable-info">
				<label class="pull-left">	
				<?php
					if(!empty($this->request->params['named']['order']) == 'deliver'):
						echo __l('Message to buyer');
					else:
						echo __l('Message');
					endif;
				?>
				</label>
				<?php echo $this->Form->input('message', array('type' => 'textarea', 'label' => false)); ?>
			</div>
			<div class="input file">
			<span class="message-lable-info label-content">
			<?php
				echo __l('Attachment');
			?>
			</span>
            
				<?php echo $this->Form->input('Attachment.filename', array('type' => 'file','size' => '33', 'label' => '','class' =>'browse-field', 'div' => false)); ?>
			</div>

<div class="compose-block clearfix">

	<?php if(!empty($this->request->data['Message']['contact_type']) && ($this->request->data['Message']['contact_type'] == 'deliver')):?>
		<?php echo $this->Form->submit(__l('Notify Buyer'), array('class' => 'js-delete btn btn-primary')); ?>
	<?php else:?>
		<?php echo $this->Form->submit(__l('Send')); ?>
	<?php endif;?>

</div>
</div>
<?php echo $this->Form->end(); ?>
</div>