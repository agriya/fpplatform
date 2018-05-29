<div class="jobFlagCategories form">
<?php echo $this->Form->create('JobFlagCategory', array('class' => 'form-horizontal normal'));?>
	<fieldset>
    	<?php echo $this->Form->input('name', array('label' => __l('Name'))); ?>
    	<?php echo $this->Form->input('is_active',array('label'=>'Active')); ?>
	</fieldset>
<div class="submit-block clearfix">
<?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo $this->Form->end();?>
</div>