<?php /* SVN: $Id: $ */ ?>
<div class="jobFeedbacks form">
    <ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(sprintf(__l('%s Feedbacks'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('controller' => 'job_feedbacks', 'action' => 'index'), array('class' => 'bluec','title'=> sprintf(__l('%s Feedbacks'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Edit');?></li>      
	</ul>
	<?php echo $this->Form->create('JobFeedback', array('class' => 'form-horizontal normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('feedback', array('label' => __l('Name')));
		echo $this->Form->input('is_satisfied', array('label' => __l('Satisfied')));
	?>
	</fieldset>
	<div class="submit-block clearfix">
      	<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-primary')); ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>