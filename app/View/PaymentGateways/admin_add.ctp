<?php /* SVN: $Id: $ */ ?>
<div class="paymentGateways form">
<h2><?php echo __l('Add Payment Gateway');?></h2>
<?php echo $this->Form->create('PaymentGateway', array('class' => 'normal form-horizontal '));?>
	<fieldset>
	<?php
		echo $this->Form->input('name', array('label' => __l('Name')));
		echo $this->Form->input('description', array('label' => __l('Description')));
		echo $this->Form->input('gateway_fees', array('label' => __l('Gateway Fees')));
		echo $this->Form->input('is_test_mode', array('label' => __l('Test Mode')));
		echo $this->Form->input('is_active', array('label' => __l('Active')));
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
