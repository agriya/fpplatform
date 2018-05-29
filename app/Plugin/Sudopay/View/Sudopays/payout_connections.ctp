<?php /* SVN: $Id: $ */ ?>
<div class="sudopays index">
<section class="sep-bot top-smspace">
	<div class="container clearfix bot-space">
		<div class="label label-info show text-18 clearfix no-round ver-mspace">
			<div class="span smspace"><?php echo __l('Payment Options / Payout Methods'); ?></div>
			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
	</div>
</section>
<section class="space container">
<?php 
if(isset($this->request->query['error_code'])) { 
	if($this->request->query['error_code'] != 0) { ?>
		<div class="alert alert-error"><?php 
			echo sprintf('%s. %s', $this->request->query['error_message'], __l('Connection not completed. Please try again.')); ?>
		</div><?php 
	} else { ?>
		<div class="alert alert-success"><?php 
			echo __l('Gateway connected successfully. Waiting for notification from payment gateway. Will refresh the page in 60 seconds...'); ?>
			<meta http-equiv="refresh"  content="30;url=<?php echo Router::url(array('controller' => 'sudopays', 'action' => 'payout_connections'), true);?>" />
		</div><?php
	}
} ?>
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
    <div class="span4  pull-left top-space">
		<?php echo $this->Html->image($gateway_details['thumb_url']); ?>
	</div>
	<div class="span12 thumbnail pull-left space">
	<span class="textb pull-left">
	<?php echo $this->Html->cText($gateways['SudopayPaymentGateway']['sudopay_gateway_name']);?></span>
	<span class="grayc pull-left">
	<?php echo $this->Html->cText($gateway_details['connect_instruction']);?></span>
	</div>
    <div class="span4">
		<?php 
			if(in_array($gateways['SudopayPaymentGateway']['sudopay_gateway_id'], $connected_gateways)) { ?>
				<?php echo $this->Html->link('<i class="icon-ok"></i>'.__l('Connected'), array('controller' => 'sudopays', 'action' => 'delete_account', $gateways['SudopayPaymentGateway']['sudopay_gateway_id'], $user['User']['id'],'0','payout_connection'), array('class' => 'btn  span3 ver-mspace js-sudopay-disconnect js-bootstrap-tooltip js-no-pjax','escape'=>false, 'title'=> __l('Disconnect')));
			} else {
				$class = '';
				if($this->Auth->user('role_id') != ConstUserTypes::Admin){ $class=' span5'; }
				echo $this->Html->link(sprintf(__l('Connect my %s account'),$gateways['SudopayPaymentGateway']['sudopay_gateway_name']), array('controller' => 'sudopays', 'action' => 'add_account', $gateways['SudopayPaymentGateway']['sudopay_gateway_id'], $user['User']['id'],'0','payout_connection'), array('class' => 'btn btn-primary ver-mspace js-no-pjax'.$class));
			}
		?>
	</div>
	</div>
<?php
  endforeach;

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
