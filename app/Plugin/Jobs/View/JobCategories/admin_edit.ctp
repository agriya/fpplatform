<?php /* SVN: $Id: $ */ ?>
<div class="jobCategories form">
<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
    <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
    <li><?php echo $this->Html->link(__l(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps). ' Categories'), array('controller' => 'job_categories', 'action' => 'index'), array('class' => 'bluec', 'escape' => false,'title'=> __l(jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps). ' Categories'))); ?> <span class="divider graydarkerc ">/</span></li>	  
    <li class="active graydarkerc"><?php echo __l('Edit ');?></li>      
</ul>
<?php echo $this->Form->create('JobCategory', array('class' => 'normal form-horizontal '));?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => __l('Name')));
		echo $this->Form->input('job_type_id', array('label' => __l('Job Type'), 'options' => $job_types));
		echo $this->Form->input('is_active', array('label' => __l('Active')));
	?>
	<div class="submit-block clearfix">
      	<?php
    	echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-primary'));
    ?>
    </div>
    <?php
    	echo $this->Form->end();
    ?>
</div>