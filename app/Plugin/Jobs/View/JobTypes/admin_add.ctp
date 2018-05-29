<?php /* SVN: $Id: $ */ ?>
<div class="jobTypes form">
<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(__l('Job Types'), array('action' => 'index'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc">Add Job Type</li>
	</ul>
	<div class="tabbable ver-space sep-top top-mspace">
      <div id="list" class="tab-pane active in no-mar">
<?php echo $this->Form->create('JobType', array('class' => 'normal form-horizontal '));?>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('job_count');
	?>
	<div class="submit-block clearfix">
      	<?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-primary'));?>
    </div>
<?php echo $this->Form->end();?>
</div>
</div>
</div>