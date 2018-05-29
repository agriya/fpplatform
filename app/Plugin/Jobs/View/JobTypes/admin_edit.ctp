<?php /* SVN: $Id: $ */ ?>
<div class="jobTypes form">
<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(sprintf(__l('%s Types'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('action' => 'index'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo sprintf(__l('Edit %s Type'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps));?></li>
	</ul>
	<div class="tabbable ver-space sep-top top-mspace">
      <div id="list" class="tab-pane active in no-mar">
<?php echo $this->Form->create('JobType', array('class' => 'normal form-horizontal '));?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('is_active',  array('label' => __l('Active?')));
	?>
	<div class="submit-block clearfix">
      	<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-primary'));?>
    </div>
	<?php echo $this->Form->end();?>
</div>
</div>
</div>