<?php /* SVN: $Id: $ */ ?>
<div class="requestViews form">
<?php echo $this->Form->create('RequestView', array('class' => 'normal form-horizontal '));?>
	<h2><?php echo __l('Edit').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps).' '.__l('views');?></h2>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('request_id', array('label' => requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps)));
		echo $this->Form->input('user_id');
		echo $this->Form->input('ip');
		echo $this->Form->input('host');
	?>
<?php echo $this->Form->end(__l('Update'));?>
</div>
