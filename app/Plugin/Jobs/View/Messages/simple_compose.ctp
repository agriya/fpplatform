<div class="messages index message-compose-block js-responses">
<?php
if(!empty($this->request->params['isAjax'])):
		echo $this->element('flash_message');
endif;
?>
<?php //echo '<pre>'; print_r($this->request->data); exit;?>
<?php echo $this->Form->create('Message', array('action' => 'simple_compose', 'class' => 'compose normal form-horizontal js-ajax-form', 'enctype' => 'multipart/form-data')); ?>
	<div class="compose-box">
		<?php
			echo $this->Form->input('job_order_dispute_id', array('type' => 'hidden'));
			echo $this->Form->input('to_user_id', array('type' => 'hidden'));
			echo $this->Form->input('to_username', array('type' => 'hidden'));
			echo $this->Form->input('to_useremail', array('type' => 'hidden'));
			echo $this->Form->input('type', array('type' => 'hidden'));
			if(!empty($this->request->data['Message']['job_id'])):
				echo $this->Form->input('job_id', array('type' => 'hidden'));
			endif;
			if(!empty($this->request->data['Message']['job_order_id'])):
				echo $this->Form->input('job_order_id', array('type' => 'hidden'));
			endif;
		?>
		<div class="input required message-lable-info">
			<label class="pull-left">	
			<?php
				echo __l('Message');
			?>
			</label>
			<?php echo $this->Form->input('message', array('type' => 'textarea', 'label' => false)); ?>
		</div>

		<div class="compose-block clearfix">
			<div class="message-block-right clearfix" >
				<?php echo $this->Form->submit(__l('Send'), array('class' => 'btn btn-primary')); ?>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>