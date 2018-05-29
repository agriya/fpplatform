<?php /* SVN: $Id: $ */ ?>
<div class="requestFlagCategories form">
<?php echo $this->Form->create('RequestFlagCategory', array('class' => 'normal form-horizontal '));?>
	
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