<?php /* SVN: $Id: $ */ ?>
<div class="jobFavorites form">
<?php echo $this->Form->create('JobFavorite', array('class' => 'form-horizontal normal'));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(sprintf(__l('%s Favorites'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('action' => 'index'));?> &raquo; <?php echo __l('Add Job Favorite');?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('job_id');
		echo $this->Form->input('ip');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>