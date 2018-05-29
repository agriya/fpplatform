<div class="messages index message-compose-block">
<?php //pr($this->request->params['isAjax']); ?>
<?php if((!empty($this->request->params['named']['order']) == 'deliver' || (!empty($this->request->data['Message']['contact_type']) && $this->request->data['Message']['contact_type'] == 'deliver')) && ($this->request->data['Message']['contact_type'] != 'contact')): ?>
	<h3 class="compose-title"><?php echo __l('Submit your complete work on').' '. jobAlternateName(ConstJobAlternateName::Singular).'<br/>'; ?></h3>
	<h2 class="compose-title">
	<?php 
		if(!empty($this->request->data['Message']['job_name'])):
			echo $this->Html->link($this->Html->cText(__l('I will ').' '.$this->request->data['Message']['job_name'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($this->request->data['Message']['job_amount'])), array('controller' => 'jobs', 'action' => 'view', $this->request->data['Message']['job_slug']), array('title' => $this->Html->cText(__l('I will ').' '.$this->request->data['Message']['job_name'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($this->request->data['Message']['job_amount']), false),'escape' => false));			
		endif;
	?>
	</h2>
	<?php else:?>
	<?php if(!$this->request->params['isAjax']) :?>
	<section class="top-smspace sep-bot ">
	<div class="container clearfix bot-space">
		<h2 class="text-32 pull-left "><?php echo __l('Compose');?></h2>
	</div>
	</section>
	<?php endif;?>	
<?php endif;?>
<section class="clearfix <?php echo (!$this->request->params['isAjax'])?'container':'';?>">
<?php echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'compose normal form-horizontal submit-form', 'enctype' => 'multipart/form-data')); ?>
<?php
if((!empty($this->request->params['named']['type']) == 'contact') || !empty($this->request->data['Message']['contact_type']) || (!empty($compose_message['type']) && ($compose_message['type']  == 'reply'))){
?>

<div class="mail-content-curve-middle top-space">
<?php if(!$this->request->params['isAjax']) :?>
<div class="send-iteam-block dr">
<?php
	echo $this->Html->link(__l('Inbox') , array('controller' => 'messages','action' => 'inbox'), array('class'=>'btn btn-success')); ?>
	<?php
	echo $this->Html->link(__l('Sent items') , array('controller' => 'messages','action' => 'sentmail'), array('class'=>'btn btn-warning'));
    ?>
</div>
<?php endif;?>
			<div class="input  message-lable-info">
				<label class="pull-left">	
				 <?php echo __l('From: '); ?>
				</label>
				<div class="ver-smspace"> <?php echo $this->Html->link($this->Html->cText($this->Auth->user('username')), array('controller'=> 'users', 'action' => 'view', $this->Auth->user('username')), array('title' => $this->Html->cText($this->Auth->user('username'),false),'escape' => false));?></div>
			</div>
			<div class="input  message-lable-info">
				<label class="pull-left">	
				 <?php echo __l('To: '); ?>
				</label>
				<div class="ver-smspace"> <?php echo $this->Html->link($this->Html->cText($this->request->data['Message']['to_username']), array('controller'=> 'users', 'action' => 'view', $this->request->data['Message']['to_username']), array('title' => $this->Html->cText($this->request->data['Message']['to_username'],false),'escape' => false));?>
				</div>			
				</div>


    <?php
	if(!empty($this->request->data['Message']['job_name'])):
     ?>
	 <div class="input  message-lable-info">
				<label class="pull-left">	
				<?php echo jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps).': ';  ?>
				</label>
				<div class="ver-smspace"><?php echo $this->Html->link($this->Html->cText($this->request->data['Message']['job_name']), array('controller' => 'jobs', 'action' => 'view',  $this->request->data['Message']['job_slug']), array('title' => $this->Html->cText($this->request->data['Message']['job_name'],false),'escape' => false));?>
				</div>			
				</div>

 <?php	endif;  ?>
 <?php if(!empty($this->request->params['named']['job_order_id']) || !empty($this->request->data['Message']['job_order_id'])):?>
 <div class="input  message-lable-info">
				<label class="pull-left">	
				 <?php echo __l('Order#: '); ?>
				</label>
				<div class="ver-smspace">  <?php if(!empty($this->request->params['named']['job_order_id'])){
				echo $this->request->params['named']['job_order_id'];
					}elseif(!empty($this->request->data['Message']['job_order_id'])){
						echo $this->request->data['Message']['job_order_id'];	
					}
				 ?></div>
			</div>

	<?php endif;?>
	</div>
<?php }
// Delivery
if((!empty($this->request->params['named']['order']) == 'deliver' || (!empty($this->request->data['Message']['contact_type']) && $this->request->data['Message']['contact_type'] == 'deliver')) && ($this->request->data['Message']['contact_type'] != 'contact')): ?>
	<div class="buyer-block clearfix">
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
<div class="compose-box top-mspace clearfix">
<?php if(!empty($this->request->params['named']['order']) == 'deliver' || (!empty($this->request->data['Message']['contact_type']) && $this->request->data['Message']['contact_type'] == 'deliver')): ?>
<div class="tips-block">
			<h3><?php echo __l('Tip: ');?></h3>
			<p><?php echo __l('It is a good idea to provide proof of your completed work');?></p>
		</div>
			<?php  endif; ?>
			
			<div class="top-mspace">
		 <?php 
		 if(empty($this->request->data['Message']['to_username'])){ 
				echo $this->Form->autocomplete('to', array('type' => 'text', 'id' => 'message-to', 'acFieldKey' => 'User.id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
			}
				echo $this->Form->input('parent_message_id', array('type' => 'hidden'));
				echo $this->Form->input('type', array('type' => 'hidden'));
			//	if(!empty($this->request->params['named']['order']) == 'deliver'):
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
			//	endif;
				/*if(!empty($this->request->params['named']['type']) == 'contact'){
					echo $this->Form->input('to', array('type' => 'hidden', 'id' => 'message-to', 'value' => $contact['to_username']));
					echo $this->Form->input('job_id', array('type' => 'hidden','value' => $contact['job_id']));
					echo $this->Form->input('r', array('type' => 'hidden','value' => $this->request->params['named']['type']));
					echo $this->Form->input('subject', array('id' => 'MessSubject'));			
				}else{
					echo $this->Form->input('to', array('type' => 'hidden', 'id' => 'message-to', 'value' => $contact['to_username']));
					echo $this->Form->input('job_id', array('type' => 'hidden','value' => $job_id));
					echo $this->Form->input('subject', array('id' => 'MessSubject'));		
				}*/
            ?>
			</div>

			<div class="input required message-lable-info js-textarea ">
				<label class="pull-left">	
				<?php
					if(!empty($this->request->params['named']['order']) == 'deliver'):
						echo __l('Message to buyer');
					else:
						echo __l('Message');
					endif;
				?>
				</label>
				<?php echo $this->Form->input('message', array('type' => 'textarea', 'div' => false, 'label' => false), array('class'=>'span7 ')); ?>
			</div>
			<div class="input file">
			<span class="message-lable-info label-content">
			<?php
				echo __l('Attachment');
			?>
			</span>
            
				<?php echo $this->Form->input('Attachment.filename', array('type' => 'file', 'label' => '', 'div' => false, 'size' => '33', 'class' => 'multi file attachment browse-field js-file-type')); ?>
			</div>


<div class="submit-block clearfix" >
	<?php if(!empty($this->request->data['Message']['contact_type']) && ($this->request->data['Message']['contact_type'] == 'deliver')):?>
		<?php echo $this->Form->submit(__l('Notify Buyer')); ?>
	<?php else:?>
		<?php echo $this->Form->submit(__l('Send'), array('class'=>'btn btn-primary', 'div' => 'submit pull-left')); ?>
	<?php endif;?>
	<div class="cancel-block pull-left space">
    <?php echo $this->Html->link(__l('Cancel'), array('controller' => 'messages', 'action' => 'inbox') , array('title' => __l('Cancel'))); ?>
    </div>
</div>

</div>
<?php echo $this->Form->end(); ?>
</section>
</div>
