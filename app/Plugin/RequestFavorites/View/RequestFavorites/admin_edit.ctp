<?php /* SVN: $Id: $ */ ?>
<div class="requestFavorites form">
<?php echo $this->Form->create('RequestFavorite', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(sprintf(__l('%s Favorites'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)), array('action' => 'index'));?> &raquo; <?php echo __l('Edit Request Favorite');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('request_id');
		echo $this->Form->input('ip');
		echo $this->Form->input('host');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>
