<?php /* SVN: $Id: $ */ ?>
<div class="paymentGateways view">
<h2><?php echo __l('Payment Gateway');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($paymentGateway['PaymentGateway']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($paymentGateway['PaymentGateway']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($paymentGateway['PaymentGateway']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Name');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($paymentGateway['PaymentGateway']['name']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Description');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($paymentGateway['PaymentGateway']['description']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Gateway Fees');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cFloat($paymentGateway['PaymentGateway']['gateway_fees']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Transaction Count');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($paymentGateway['PaymentGateway']['transaction_count']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Payment Gateway Setting Count');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($paymentGateway['PaymentGateway']['payment_gateway_setting_count']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Is Test Mode');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cBool($paymentGateway['PaymentGateway']['is_test_mode']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Is Auto Approved');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cBool($paymentGateway['PaymentGateway']['is_auto_approved']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Is Active');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cBool($paymentGateway['PaymentGateway']['is_active']);?></dd>
	</dl>
</div>

