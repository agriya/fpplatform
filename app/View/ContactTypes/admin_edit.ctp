<?php /* SVN: $Id: $ */ ?>
<div class="contactTypes form">
<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(__l('Contact Types'), array('controller' => 'contact_types', 'action' => 'index'), array('class' => 'bluec','title'=>__l('Contact Types'))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Edit');?></li>      
	</ul>
<?php echo $this->Form->create('ContactType', array('class' => 'normal form-horizontal '));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name',  array('label' => __l('Name')));
		echo $this->Form->input('is_active',  array('label' => __l('Active')));
	?>
	</fieldset>
	<div class="submit-block clearfix">
<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo $this->Form->end();?>
</div>
