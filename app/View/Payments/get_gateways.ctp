<div class="hor-space bot-mspace payment-gateways payment-type ver-space">
	<?php 
		$templates = array();
		$gateway_groups = array();
		$payment_gateways = array();
		$i = 1;
		foreach($gateway_types As $key => $gateway_type) {
			$gateway_groups[$key]['id'] = $key;
			$gateway_groups[$key]['name'] = $gateway_type;
			$gateway_groups[$key]['display_name'] = $gateway_type;
			if($key == ConstPaymentGateways::Wallet) {
				$gateway_groups[$key]['thumb_url'] = Router::url('/img/wallet-icon.png', true);
			}
			$payment_gateways[$key] = $gateway_groups[$key];
			$payment_gateways[$key]['group_id'] = $key;
			$payment_gateways[$key]['payment_id'] = $key;
			$i++;
		}
		if (isPluginEnabled('Sudopay') && !empty($gateway_types[ConstPaymentGateways::SudoPay])):
			$gateways_response = Cms::dispatchEvent('View.Payment.GetGatewayList', $this, array(
				'foreign_id' => $foreign_id,
				'payment_type_id' => $transaction_type
			));
			$gatewayGroups = array();
			$groups = !empty($gateways_response->gatewayGroups) ? $gateways_response->gatewayGroups : '';	
			$gateways = !empty($gateways_response->gateways) ? $gateways_response->gateways : '';	
			if ($response['is_payment_via_api'] != ConstBrandType::VisibleBranding) {
				unset($gateway_groups[ConstPaymentGateways::SudoPay]);
				if(!empty($groups)) {
					if(!empty($gatewaygroup_ids) && !isPluginEnabled('Wallets')){						
						foreach($groups As $group) {
						  	if(in_array($group['id'], $gatewaygroup_ids)){
						  		$gatewayGroups[$group['id']] = $group;
						  	}
						}
						$gateway_groups = $gatewayGroups + $gateway_groups;
					} else {
						foreach($groups As $group) {
							$gatewayGroups[$group['id']] = $group;
						}
						$gateway_groups = $gatewayGroups + $gateway_groups;
					}
				}
				$gateway_array = array();
				$payment_gateway_arrays = array();
				unset($payment_gateways[ConstPaymentGateways::SudoPay]);
				unset($gateway_types[ConstPaymentGateways::SudoPay]);
				// Code copied from croudfunding
				if(!empty($gateways)) {
					foreach($gateways as $gateway) {
						if(!empty($gateway_ids) && !isPluginEnabled('Wallets')){
							if(!in_array($gateway['id'], $gateway_ids)){
								continue;							}
						}
						$payment_gateway_arrays[$i]['id'] = $gateway['id'];
						$payment_gateway_arrays[$i]['payment_id'] = 'sp_' . $gateway['id'];
						$payment_gateway_arrays[$i]['sp_' . $gateway['id']] = implode($gateway['_form_fields']['_extends_tpl'], ",");
						$payment_gateway_arrays[$i]['display_name'] = $gateway['display_name'];
						$payment_gateway_arrays[$i]['thumb_url'] = $gateway['thumb_url'];
						$payment_gateway_arrays[$i]['group_id'] = $gateway['group_id'];
						$templates['sp_' . $gateway['id']] = implode($gateway['_form_fields']['_extends_tpl'], ",");
						$gateway_array['sp_' . $gateway['id']] = '<div class="pull-left"><img src="'. $gateway['thumb_url'] .'" alt="'.$gateway['display_name'].'"/><span class="show">'.$gateway['display_name'].'</span></div>'; //for image
						$gateway_instructions['sp_' . $gateway['id']] = (!empty($gateway['instruction_for_manual'])) ? urldecode($gateway['instruction_for_manual']): '';
						$gateway_form['sp_' . $gateway['id']] = (!empty($gateway['_form_fields']['_fields'])) ? array_keys((array)$gateway['_form_fields']['_fields']): '';
						$i++;
					}
					$gateway_types = $gateway_array + $gateway_types;
					$payment_gateways =  $payment_gateway_arrays + $payment_gateways;
				}
			}
		endif;
	?>
	<?php if(!empty($gateway_groups)) { 
		$default_gateway_id = '';
		foreach($payment_gateways As $key => $value) {
			$default_gateway_id = $value['payment_id'];
			break;
		}
		$selected_payment_gateway_id = (!empty($this->request->params['named']['return_data'][$model]['sudopay_gateway_id']) ? 'sp_' . $this->request->params['named']['return_data'][$model]['sudopay_gateway_id'] : $default_gateway_id);
	?>
	<div id="paymentgateways-tab-container" class="">
		<ul class="nav nav-tabs no-mar">
			<?php foreach($gateway_groups As $gateway_group) { ?>
			<li><a href="#paymentGateway-<?php echo $gateway_group['id']; ?>" class="js-no-pjax clearfix" data-toggle="tab"><div class="pull-left <?php echo empty($gateway_group['thumb_url'])?'ver-space':''; ?>">
			<?php if(!empty($gateway_group['thumb_url'])){?>
				<img src="<?php echo $gateway_group['thumb_url']; ?>" alt="<?php echo $gateway_group['display_name']; ?>" />
			<?php } ?>
			<span class="show <?php echo empty($gateway_group['thumb_url'])?'ver-space':''; ?>"><?php echo $gateway_group['display_name']; ?></span></div></a></li>
			<?php } ?>
		</ul>
		<div class="sep-right sep-left sep-bot tab-round tab-content" id="myTabContent2">
			<?php foreach($gateway_groups As $gateway_group) { ?>
			<div class="tab-pane space " id="paymentGateway-<?php echo $gateway_group['id']; ?>">
				<?php 
				foreach($payment_gateways AS $payment_gateway) {
					$checked = '';
					if ($payment_gateway['payment_id'] == $selected_payment_gateway_id) {
						$checked = 'checked';
					}
					if($payment_gateway['group_id'] == $gateway_group['id']) {
						if ($payment_gateway['payment_id'] == ConstPaymentGateways::Wallet) {
							$option_value = '<span class="pull-left">' . $this->Html->image('wallet-icon.png', array('width' => '145', 'height' => '40', 'alt' => __l('Wallet'))) . '<span class="show">' . $payment_gateway['display_name'] . '</span></span>';							
						} else {
							if ($payment_gateway['group_id'] == 4922):
								$option_value = '<span class="pull-left"><span class="show">' . __l('Credit & Debit Cards') . '</span></span>';
							else:
								$option_value = '<span class="pull-left">';
								$class='top-space';
								if(!empty($gateway_group['thumb_url'])){
									$option_value .= '<img src="'. $payment_gateway['thumb_url'] .'" alt="'.$payment_gateway['display_name'].'"/>';
									$class = '';
								}
								$option_value .= '<span class="show '.$class.'">'.$payment_gateway['display_name'].'</span></span>';
							endif;
						}
						$options = array($payment_gateway['payment_id'] => $option_value);
						if ($payment_gateway['group_id'] == 4922):
							echo '<div class="hide">';
								echo $this->Form->input($model.'.payment_gateway_id', array('id' => 'PaymentGatewayId', 'legend' => false, 'type' => 'radio', 'label'=> true, 'div' => 'span mspace', 'options' => $options, 'sudopay_form_fields_tpl' => $templates, 'class' => 'js-payment-type js-no-pjax', 'checked' => $checked));
							echo '</div>';
							echo '<div class="alert alert-info ver-mspace space">' . __l(' Please enter your credit card details below.') . '</div>';
						else:
							echo $this->Form->input($model.'.payment_gateway_id', array('id' => 'PaymentGatewayId', 'legend' => false, 'type' => 'radio', 'label'=> true, 'div' => 'span mspace', 'options' => $options, 'sudopay_form_fields_tpl' => $templates, 'class' => 'js-payment-type js-no-pjax', 'checked' => $checked));
						endif;
					}
				}
				?>	
			</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
<?php
	if (!empty($gateway_instructions) && $response['is_payment_via_api'] != ConstBrandType::VisibleBranding) {
		foreach($gateway_instructions as $key => $instructions) {
			if(!empty($gateway_instructions[$key])) {
?>
<div class="js-instruction js-instruction_<?php echo $key; ?> alert alert-info hide">
	<?php echo nl2br($this->Html->cText($gateway_instructions[$key])); ?>
</div>
<?php
			}
		}
	}
?>
<?php if (!empty($gateways_response->form_fields_tpls)) { ?>
	<div class="js-form top-mspace top-space">
		<?php foreach($gateways_response->form_fields_tpls as $key => $value) { ?>
			<div class="js-gatway_form_tpl hide" id="form_tpl_<?php echo $key; ?>">
				<?php
					foreach($value['_fields'] as $field_name => $required) {
						$return_data = !empty($this->request->params['named']['return_data']['Sudopay'][$field_name]) ? $this->request->params['named']['return_data']['Sudopay'][$field_name] : '';
						$field_options = array();
						$field_name = trim($field_name);
						$type = 'text';
						$options = array();
						$value = $return_data;
						if ($field_name == 'payment_note') {
							$type = 'textarea';
						}
						if ($field_name == 'buyer_country') {
							$type = 'select';
							$options = $countries;
							$value = (!empty($user_profile['Country']['iso_alpha2'])) ? $user_profile['Country']['iso_alpha2'] : $return_data;
						}
						if ($field_name == 'buyer_email') {
							$value = (!empty($user_profile['User']['email'])) ? $user_profile['User']['email'] : $return_data;
						}
						if ($field_name == 'buyer_address') {
							$value = (!empty($user_profile['UserProfile']['address'])) ? $user_profile['UserProfile']['address'] : $return_data;
						}
						if ($field_name == 'buyer_city') {
							$value = (!empty($user_profile['City']['name'])) ? $user_profile['City']['name'] : $return_data;
						}
						if ($field_name == 'buyer_state') {
							$value = (!empty($user_profile['State']['name'])) ? $user_profile['State']['name'] : $return_data;
						}
						
						$before = $after = '';
						if (!empty($required)) {
							$cc_section = '';
							$class = '';
							if ($field_name == 'credit_card_number') {
								$after .= '<div class="cc-type"></div><div class="cc-default"></div>';
								$cc_section = ' cc-section';
							}
							if ($field_name == 'credit_card_name_on_card') {
								$class = ' valign';
							}
							$before .= '<div class="required' . $cc_section . $class .'">';
							$after .= '</div>';
						}
						$field_options = array(
							'id' => 'Sudopay' . Inflector::camelize($field_name),
							'legend' => false,
							'type' => $type,
							'value' => $value,
							'before' => $before,
							'after' => $after
						);
						if (!empty($options)) {
							$field_options['options'] = $options;
						}
						if ($field_name == 'credit_card_number' || $field_name == 'credit_card_code') {
							$field_options['autocomplete'] = 'off';
						}
						if ($field_name == 'credit_card_expire') {
							$field_options['placeholder'] = 'MM/YYYY';
						}
						if ($field_name == 'buyer_country') {
							$field_options['empty'] = __l('Please Select');
						}
						echo $this->Form->input('Sudopay.' . $field_name , $field_options);
					}
				?>
			</div>
		<?php } ?>
	</div>
<?php } ?>
<div class="submit-block form-payment-panel clearfix">
	<div class="submit">
		<div class= "js-wallet-connection hide">
			<p class="top-space bot-sp textb sfont available-balance js-user-available-balance {'balance':'<?php echo $logged_in_user['User']['available_wallet_amount']; ?>'}"><?php echo __l('Your available balance:').' '. $this->Html->siteCurrencyFormat($this->Html->cCurrency($logged_in_user['User']['available_wallet_amount'], false));?></p>
			<?php
				echo $this->Form->submit(__l('Pay with Wallet'), array('name' => 'data['.$model.'][wallet]', 'class' => '{"balance":"' . $logged_in_user['User']['available_wallet_amount'] . '"}  btn btn btn-primary wallet-button ' . ' js-update-order-field js-no-pjax', 'div' => false));
			?>
		</div>
		<div class= "js-normal-sudopay hide">
			<?php
				echo $this->Form->submit(__l('Pay Now'), array('name' => 'data['.$model.'][wallet]', 'class' => 'js-update-order-field js-no-pjax btn btn btn-primary', 'id' => 'sudopay_button'));
		?>
		</div>
	</div>   
</div>
</div>