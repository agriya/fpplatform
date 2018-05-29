<?php /* SVN: $Id: admin_add.ctp 6621 2010-06-02 13:42:00Z sreedevi_140ac10 $ */ ?>
<div class="languages form">
<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(__l('Languages'), array('controller' => 'languages', 'action' => 'index'), array('class' => 'bluec','title'=>__l('Languages'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo __l('Add'); ?></li>
	</ul>
<div class="clearfix top-space top-mspace sep-top ">
	<?php echo $this->Form->create('Language', array('class' => 'normal form-horizontal '));?>
	<?php
		echo $this->Form->input('name',array('label' => __l('Name')));
		echo $this->Form->input('iso2',array('label' => __l('Iso2')));
		echo $this->Form->input('iso3',array('label' => __l('Iso3')));
		echo $this->Form->input('is_active', array('label' => __l('Active')));
	?>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-primary'));?>
		<div class="cancel-block">
			<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'languages', 'action' => 'index'), array('class' => 'btn btn-warning', 'title' => __l('Cancel'), 'escape' => false));?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?> 
    </div>
</div>