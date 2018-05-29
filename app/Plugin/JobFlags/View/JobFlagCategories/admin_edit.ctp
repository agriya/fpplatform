<?php /* SVN: $Id: admin_edit.ctp 620 2009-07-14 14:04:22Z boopathi_23ag08 $ */ ?>
<div class="jobFlagCategories form">
<?php echo $this->Form->create('JobFlagCategory', array('class' => 'form-horizontal normal'));?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => __l('Name')));
    	echo $this->Form->input('is_active',array('label'=>'Active')); 
	?>
    <div class="submit-block clearfix">
    <?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-primary'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>