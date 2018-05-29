<?php /* SVN: $Id: $ */ ?>
<div class="sudopays index">
<section class="space">
<div class="clearfix">
<h3><?php echo __l('Payment Options / Payout Methods');?></h3>
<p><?php echo __l('When you receive a payment, we call that payment to you a "payout". Our secure payment system supports below payout methods, which can be setup here.');?></p>
<?php if(isPluginEnabled('Wallets')) { ?>
<p><?php echo __l('Note that if you haven\'t setup your payment methods or buyer pays through any of non-connected payment methods, the amount will be credited to your wallet.');?></p>
<?php } else { ?>
<p><?php echo __l('Note that buyers will be provided with the payment options, based on below setup only.');?></p>
<?php } ?>
</div>
<div class="row bot-space thumbnail">
<?php
if (!empty($supported_gateways)):
foreach ($supported_gateways as $gateways):
$gateway_details = unserialize($gateways['SudopayPaymentGateway']['sudopay_gateway_details']);
?>
 <div class="span24 pull-left ver-space mspace clearfix">
    <div class="span4  pull-left dc space">
		<?php echo $this->Html->image($gateway_details['thumb_url']); ?>
	</div>
	<div class="span12 thumbnail pull-left space">
	<span class="textb pull-left">
	<?php echo $this->Html->cText($gateways['SudopayPaymentGateway']['name']);?></span>
	<span class="grayc pull-left">
	<?php echo $this->Html->cText($gateway_details['connect_instruction']);?></span>
	</div>
    <div class="span4 dc space">
		<?php 
		if(in_array($gateways['SudopayPaymentGateway']['sudopay_gateway_id'], $connected_gateways)) { ?>
				<?php echo $this->Html->link('<i class="icon-ok"></i>'.__l('Connected'), array('controller' => 'sudopays', 'action' => 'delete_account', $gateways['SudopayPaymentGateway']['sudopay_gateway_id'], $user['id'],$request), array('class' => 'btn  span3 ver-mspace js-sudopay-disconnect js-bootstrap-tooltip js-no-pjax ','escape'=>false, 'title'=> __l('Disconnect')));
			} else {
				$class = '';
				if($this->Auth->user('role_id') != ConstUserTypes::Admin){ $class=' span5'; }
				echo $this->Html->link(sprintf(__l('Connect my %s account'),$gateways['SudopayPaymentGateway']['sudopay_gateway_name']), array('controller' => 'sudopays', 'action' => 'add_account', $gateways['SudopayPaymentGateway']['sudopay_gateway_id'],  $user['id'],$request), array('class' => 'btn btn-primary ver-mspace js-no-pjax '.$class));
			}
		?>
	</div>
	</div>
<?php
  endforeach;?>
  <div class="pull-right span2">
	<?php if(!empty($request))
	{
		echo $this->Html->link(__l('Skip') . ' >>', array('controller' => 'jobs', 'action' => 'add', 'request_id' => $request, 'step' => 'skip'), array('class' => 'blackc','title'=>__l('Skip'))); 
	} else {
		echo $this->Html->link(__l('Skip') . ' >>', array('controller' => 'jobs', 'action' => 'add', 'step' => 'skip'), array('class' => 'blackc','title'=>__l('Skip'))); 
	}
	if(!count($connected_gateways) && !isPluginEnabled('Wallets')) : ?>
	  <i class="icon-info-sign js-bootstrap-tooltip" title="<?php echo sprintf(__l('If you skip, %s will be saved in suspend mode. You should update payout settings in your accounts page to enable it.'),jobAlternateName(ConstJobAlternateName::Singular));?>"></i><?php
	endif; ?>
	  </div>
<?php
else:
?>
<div>
    <span colspan="6" class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo sprintf(__l('No %s available'), __l('Gateways'));?></span>
  </div>
<?php
endif;
?>
  </div>
</section>
</div>
