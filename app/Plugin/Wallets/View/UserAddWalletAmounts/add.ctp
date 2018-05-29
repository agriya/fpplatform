<?php /* SVN: $Id: $ */ ?>
<div class="userAddWalletAmounts form">
<?php echo $this->Form->create('UserAddWalletAmount', array('class' => 'normal form-horizontal '));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('User Add Wallet Amounts'), array('action' => 'index'));?> &raquo; <?php echo __l('Add User Add Wallet Amount');?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('amount');
		echo $this->Form->input('pay_key');
		echo $this->Form->input('payment_gateway_id');
		echo $this->Form->input('is_success');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
