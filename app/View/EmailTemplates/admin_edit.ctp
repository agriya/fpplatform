<div class="js-responses">
	<h2><?php echo $this->Html->cText($this->request->data['EmailTemplate']['name'], false); ?></h2>
	<?php if(!empty($this->request->data['EmailTemplate']['description'])):?>
		<div class="info-details">
			<?php echo $this->Html->cText($this->request->data['EmailTemplate']['description'], false); ?>
		</div>
	<?php endif;?>	
	<?php
	echo $this->Form->create('EmailTemplate', array('id' => 'EmailTemplateAdminEditForm'.$this->request->data['EmailTemplate']['id'], 'class' => 'normal form-horizontal  js-insert js-ajax-form', 'action' => 'edit'));
	echo $this->Form->input('id');
	echo $this->Form->input('from', array('label' => __l('From'),'id' => 'EmailTemplateFrom'.$this->request->data['EmailTemplate']['id'], 'info' => __l('(eg. "displayname &lt;email address>")')));
	echo $this->Form->input('reply_to', array('label' => __l('Reply To'),'id' => 'EmailTemplateReplyTo'.$this->request->data['EmailTemplate']['id'], 'info' => __l('(eg. "displayname &lt;email address>")')));
	echo $this->Form->input('subject', array('label' => __l('Subject'),'class' => 'js-email-subject', 'id' => 'EmailTemplateSubject'.$this->request->data['EmailTemplate']['id']));
	echo $this->Form->input('email_text_content', array('label' => __l('Email Text Content'),'type' =>'textarea', 'class' => 'js-email-content email-content js-editor', 'id' => 'EmailTemplateEmailContent'.$this->request->data['EmailTemplate']['id'], 'info' => $this->Html->cText($this->request->data['EmailTemplate']['email_variables'], false)));
    ?>
      <?php echo $this->Form->input('email_html_content', array('label' => __l('Email HTML Content'),'type' =>'textarea','class' => 'js-email-content email-content js-editor', 'id' => 'EmailTemplateEmailhtmlContent'.$this->request->data['EmailTemplate']['id'] , 'info' => $this->Html->cText($this->request->data['EmailTemplate']['email_variables'], false))); ?>

    <div class="submit-block clearfix">
      	<?php
    	echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-primary'));
    ?>
    </div>
    <?php
    	echo $this->Form->end();
    ?>
</div>