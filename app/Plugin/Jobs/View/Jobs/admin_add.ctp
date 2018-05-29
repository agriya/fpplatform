<?php /* SVN: $Id: $ */ ?>
<div class="jobs form">
<h2><?php echo __l('Add').' '.jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps);?></h2>
<?php echo $this->Form->create('Job', array('class' => 'normal form-horizontal '));?>
	<fieldset>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('job_category_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('description');
		echo $this->Form->input('no_of_days');
		echo $this->Form->input('job_view_count');
		echo $this->Form->input('job_feedback_count');
		echo $this->Form->input('job_favorite_count');
		echo $this->Form->input('job_tag_count');
		echo $this->Form->input('is_active',  array('label' => __l('Unsuspended by User') ,'info' => __l('Please tick unsuspended by user, Otherwise it shows inactive or suspend by user. After user activate this').' '.jobAlternateName(ConstJobAlternateName::Plural).'. '.'It will shown in the list of '.jobAlternateName(ConstJobAlternateName::Plural).'.'));
		echo $this->Form->input('admin_suspend',  array('label' => __l('Suspend by Admin') ,'info' => __l('After admin activate this').' '.jobAlternateName(ConstJobAlternateName::Plural).'. '.'It will shown in the list of '.jobAlternateName(ConstJobAlternateName::Plural).'. Otherwise It shows under suspend by admin. User cant activate this'.' '.jobAlternateName(ConstJobAlternateName::Plural).'.'));
		echo $this->Form->input('is_featured',  array('label' => __l('Feature')));
		echo $this->Form->input('JobTag');
	?>
	</fieldset>
	<div class="submit-block clearfix">
      	<?php
    	echo $this->Form->submit(__l('Add'));
    ?>
    </div>
    <?php
    	echo $this->Form->end();
    ?>
</div>