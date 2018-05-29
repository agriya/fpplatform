<?php /* SVN: $Id: $ */ ?>
<div class="userAddWalletAmounts view">
<h2><?php echo __l('User Add Wallet Amount');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($userAddWalletAmount['UserAddWalletAmount']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($userAddWalletAmount['UserAddWalletAmount']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($userAddWalletAmount['UserAddWalletAmount']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('User');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->link($this->Html->cText($userAddWalletAmount['User']['username']), array('controller' => 'users', 'action' => 'view', $userAddWalletAmount['User']['username']), array('escape' => false));?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Amount');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cCurrency($userAddWalletAmount['UserAddWalletAmount']['amount']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Pay Key');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($userAddWalletAmount['UserAddWalletAmount']['pay_key']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Payment Gateway');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->link($this->Html->cText($userAddWalletAmount['PaymentGateway']['name']), array('controller' => 'payment_gateways', 'action' => 'view', $userAddWalletAmount['PaymentGateway']['id']), array('escape' => false));?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Is Success');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cBool($userAddWalletAmount['UserAddWalletAmount']['is_success']);?></dd>
	</dl>
</div>

