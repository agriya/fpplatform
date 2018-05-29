<?php /* SVN: $Id: $ */ ?>
<section class="sep-bot top-smspace">
	<div class="container clearfix bot-space">
		<div class="label label-info show text-18 clearfix no-round ver-mspace">
			<div class="span smspace"><?php echo __l('Add Amount to Wallet'); ?></div>
			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
	</div>
</section>
<section class="row bot-mspace bot-space">
	<div class="container clearfix bot-space">
	<?php
		if(isset($this->request->data['UserAddWalletAmount']['wallet']) && $this->request->data['UserAddWalletAmount']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && !empty($sudopay_gateway_settings) && $sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
			echo $this->element('sudopay_button', array('data' => $sudopay_data, 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
		} else {
	  ?>
		<div class="payments order add-wallet  js-responses js-main-order-block top-mspace">
			<div class="alert alert-info"><i class="icon-info-sign"></i>
				<?php echo __l('Your Current Available Balance:').' '. $this->Html->siteCurrencyFormat($user_info['User']['available_wallet_amount']);?>
			</div>
				<?php 
				
				echo $this->Form->create('Wallet', array('action' => 'add_to_wallet', 'id' => 'PaymentOrderForm', 'class' => 'normal form-horizontal submit-form'));
				echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Auth->user('id')));
				if (!Configure::read('wallet.max_wallet_amount')):
					$max_amount = 'No limit';
				else:
					$max_amount = Configure::read('site.currency').$this->Html->cCurrency(Configure::read('wallet.max_wallet_amount'));
				endif; ?>
				<div class="input text required">
				<?php 				
					echo $this->Form->input('UserAddWalletAmount.amount', array('type' => 'text', 'label' => __l('Amount'), 'after' => Configure::read('site.currency') . '<span class="info clearfix"><span class="span top-smspace"><i class="icon-info-sign"></i></span><span class="span no-mar">' . sprintf(__l('Minimum Amount: %s <br/> Maximum Amount: %s'),Configure::read('site.currency').$this->Html->cCurrency(Configure::read('wallet.min_wallet_amount')), $max_amount) . '</span></span>'));
				?>
				</div>
				 <div class="clearfix states-block payment-states-block">
				<div class="js-paypal-main <?php echo (!empty($this->request->data['User']['payment_gateway_id']) && $this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) ? "" : ''?> ">
				<fieldset class="form-block">
					<legend><?php echo __l('Select Payment Type');?></legend>
					<?php echo $this->element('payment-get_gateways', array('model'=>'UserAddWalletAmount','type'=>'is_enable_for_add_to_wallet','is_enable_wallet'=>0, 'cache' => array('config' => 'sec')));?>
				</fieldset>
			   
				</div>
				</div>
				<?php echo $this->Form->end();?>		
		</div>
		<?php } ?>
	</div>
</section>