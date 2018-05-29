<div class="clearfix">
<?php
	$subscriptionInfo[ConstBrandType::TransparentBranding] = __l('Payment will have to be handled through transparent API calls. Your users will not see SudoPay branding.');
    $subscriptionInfo[ConstBrandType::VisibleBranding] = __l('Payment will have to be handled through SudoPay payment button. Your users will visit sudopay.com and see SudoPay branding.');
    $subscriptionInfo[ConstBrandType::AnyBranding] = __l('Payment can either be handled through transparent API calls or SudoPay payment button. If using transparent API calls, your users will not see SudoPay branding.');
?>
	<div class="span hor-space pull-left clearfix well">
        <div class="clearfix top-space">
            <?php echo $this->Html->link( __l('Sync with SudoPay'), array('controller' => 'sudopays', 'action' => 'synchronize', 'admin' => true), array('escape' => false, 'class' => 'btn btn-primary', 'title' => __l('Sync with SudoPay'))); ?>
            <span class="js-bootstrap-tooltip space" title="<?php echo __l('This will fetch latest configurations (subscription plan & gateways) from sudopay.com.'); ?>"><i class="icon-question-sign"></i></span>
        </div>
	<?php if ($gateway_settings['is_payment_via_api'] != ConstBrandType::VisibleBranding) { ?>
		<div id="setting-sudopay_website_id_1" class="input text">
		<dl class="clearfix dl-horizontal">
		<dt class="span7 no-mar"><label class="span3 pull-left"><?php echo __l("Subscription Plan"); ?></label></dt>
		<dd>
			<div class="span7 pull-left">
				<div id="setting-sudopay_website_id_2" class="input text">
					<?php echo $gateway_settings['sudopay_subscription_plan']; ?>
				</div>
			</div>
		</dd>
		<dt class="span7 no-mar"><label class="span3 pull-left"><?php echo __l("Branding"); ?></label></dt>
		<dd>
			<div class="span7 pull-left">
				<div id="setting-sudopay_website_id_3" class="input text">
                    <?php
						$branding = "";
                        if ($gateway_settings['is_payment_via_api'] == ConstBrandType::TransparentBranding) {
                            $branding = 'Transparent';
                        } elseif ($gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
                            $branding = 'Visible';
                        } elseif ($gateway_settings['is_payment_via_api'] == ConstBrandType::AnyBranding) {
                            $branding = 'Any';
                        }
                    ?>
					<?php echo $branding; ?>&nbsp  <?php if(!empty($subscriptionInfo[$gateway_settings['is_payment_via_api']])) {  ?> <i class="icon-info-sign js-bootstrap-tooltip" title = "<?php echo  $subscriptionInfo[$gateway_settings['is_payment_via_api']]; ?>"></i> <?php } ?>
				</div>
			</div>
		</dd>
		<dt class="span7 no-mar"><label class="span3 pull-left"><?php echo __l("Enabled Gateways"); ?></label></dt>
		<?php
			foreach($supported_gateways as $gateways) {
				$gateway_datails = unserialize($gateways['SudopayPaymentGateway']['sudopay_gateway_details']);
				?>
				<dt class="span7 dl no-mar top-space">
					<div class="span clearfix no-mar">
						<div class="hor-space">
						  <span class="show show"><?php echo $gateways['SudopayPaymentGateway']['sudopay_gateway_name']; ?></span>
							<span class="show top-smspace">
								<span class="span no-mar">
									<?php echo $this->Html->image($gateway_datails['thumb_url']); ?>
								</span>
						   </span>
						 </div>
					 </div>
				</dt>
				<dd class="span17 no-mar top-space">
					<div class="span clearfix no-mar">
						<div class="row no-mar">
							<span class="span show textb"><?php echo __l("Supported Actions"); ?></span>
							<?php
								$used_gateway_actions = array_diff($used_gateway_actions, $gateway_datails['supported_features'][0]['actions']);
								$action_arr = array();
								foreach($gateway_datails['supported_features'][0]['actions'] as $actions) {
									$action_arr[] = $actions;
                                }
                                echo implode(', ', $action_arr);
                             ?>
						</div>
					 </div>
					 <div class="span clearfix no-mar">
						<div class="row no-mar">
							<span class="span show textb"><?php echo __l("Supported Currencies"); ?></span>
							<?php
								$currency_arr = array();
								foreach($gateway_datails['supported_features'][0]['currencies'] as $currencies) {
									$currency_arr[] = $currencies;
                                }
                                echo implode(', ', $currency_arr);
                            ?>
						</div>
					 </div>
				</dd>
		<?php
			}
		?>
		</dl>
		</div>
		<?php
		if (!empty($used_gateway_actions)) {
		$missed_gateway_actions = implode('","', $used_gateway_actions);
		?>
		<div class="alert alert-danger clearfix ver-mspace">
			<?php
				echo sprintf(__l('We have used "%s" in %s. So enable payment gateways with supporting "%s" actions in SudoPay.'), $missed_gateway_actions, Configure::read('site.name'), $missed_gateway_actions);
			?>
		</div>

		<?php
		}

	} else { ?>
		<?php
		if (!empty($used_gateway_actions)) {
		$missed_gateway_actions = implode('","', $used_gateway_actions);
	?>
		<div class="alert alert-danger clearfix ver-mspace">
			<?php
				echo __l('Your current plan is not support for API calling. So we can\'t able to get your plan details and enabled payment gateways list from SudoPay.');
			?>
		</div>
		<div class="alert alert-info clearfix">
			<?php
				echo sprintf(__l('We have used "%s" in %s. So you please manually check whether your SudoPay payment gateway plan supports the mentioned actions'), $missed_gateway_actions, Configure::read('site.name'));
			?>
		</div>

	<?php
		} } ?>
	</div>
</div>