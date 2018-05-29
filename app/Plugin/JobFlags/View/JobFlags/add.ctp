<?php /* SVN: $Id: add.ctp 619 2009-07-14 13:25:33Z boopathi_23ag08 $ */ ?>
<div class="jobFlags form js-login-response">
<h2><?php echo __l('Flag This').' '.jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps);?></h2>
<?php echo $this->Form->create('JobFlag', array('class' => 'normal form-horizontal'));?>
	<?php
		if($this->Auth->user('role_id') == ConstUserTypes::Admin):
           echo $this->Form->input('user_id', array('empty' => __l('Select')));
        endif;
			 echo $this->Form->input('Job.id',array('type'=>'hidden'));
		echo $this->Form->input('job_flag_category_id', array('label' => __l('Category')));
		echo $this->Form->input('message', array('label' => __l('Message'),'class'=>'span9'));
    ?>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Add'), array('class'=>'btn btn-primary'));?>
	</div>
    <?php echo $this->Form->end();?>
</div>