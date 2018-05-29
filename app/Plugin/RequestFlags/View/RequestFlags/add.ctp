<?php /* SVN: $Id: $ */ ?>
<div class="requestFlags form js-login-response">
<h2><?php echo __l('Flag This').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps);?></h2>
<?php echo $this->Form->create('RequestFlag', array('class' => 'normal form-horizontal  js-ajax-login'));?>
	<?php
		if($this->Auth->user('role_id') == ConstUserTypes::Admin):
           echo $this->Form->input('user_id', array('empty' => __l('Select')));
        endif;	
		echo $this->Form->input('request_id',array('type'=>'hidden'));
		echo $this->Form->input('request_flag_category_id', array('label' => sprintf(__l('%s Flag Category'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps))));
		echo $this->Form->input('message', array('label' => __l('Message'),'class'=>'span9'));
		
	?>
    <div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Add'), array('class'=>'btn btn-primary'));?>
	</div>
    <?php echo $this->Form->end();?>
</div>
