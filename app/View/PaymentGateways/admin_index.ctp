<?php /* SVN: $Id: admin_index.ctp 2741 2010-08-13 15:30:58Z boopathi_026ac09 $ */ ?>
<div class="paymentGateways index js-response">  
<div class="alert alert-info">
<p>
<?php 
echo __l("As per the information we received from PayPal, websites should never aggregate money from users (i.e., have wallet option) and PayPal suggests that we use Adaptive Payment API with primary receiver set to Seller (not Site) for chargeback responsibility reasons. Violating these instructions may lead to account seizure from PayPal. So, we've used PayPal Adaptive preapproval and chained API. In this workflow, amount will be authorized (not captured) from Buyer once he buys. After the job completed, the job amount will be charged/captured; site fee/commission will also be charged at this time from Seller.");
?>
</p>
<p>
<?php 
echo __l("Caveat of this workflow: Buyer has an option in his PayPal account to cancel preapproval payments. If he does so, this software detects it through PayPal IPN and cancels the payment with 'Voided' status. But, this may give room for unstable jobs. Also, if Buyer doesn't have enough balance in the final settlement (when site tries to charge on job completed state), it may fail.");
?>
</p>
<p>
<?php 
echo __l("However, we understand that some sites have Wallet option through special relationships with PayPal. But, we seriously warn you not to enable Wallet when using PayPal. In this software, Wallet option is provided as a provision to integrate other payment gateways solutions.");
?>
</p>
<p>
<?php 
echo __l("--Agriya");
?>
</p>
</div>
<div class="alert alert-info">
	<?php echo __l('Read the warning carefully and enable appropriate options for your website.');?>
</div>
<section class="space">
  <table class="table table-striped table-bordered table-condensed table-hover no-mar">
    <thead>
    <tr>
      <th rowspan="3" class="dc"><?php echo __l('Actions');?></th>
      <th rowspan="3"><?php echo $this->Paginator->sort('display_name', __l('Display Name'));?></th>
      <th colspan="3" class="dc"><?php echo __l('Settings');?></th>
    </tr>
    <tr>
      <th rowspan="2" class="dc"><?php echo __l('Active');?></th>
      <th colspan="2" class="dc"><?php echo __l('Where to use?');?></th>
    </tr>
    <tr>
      <th class="dc"><?php echo __l('Add to Wallet');?></th>
      <th class="dc"><?php echo __l('Job Order');?></th>      
    </tr>
    </thead>
    <tbody>
    <?php
      if (!empty($paymentGateways)):
      foreach ($paymentGateways as $paymentGateway):
        $status_class = null;
    ?>
    <tr>
      <td class="span1 dc">
		<div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
			<ul class="dropdown-menu arrow dl">
				<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $paymentGateway['PaymentGateway']['id']), array('class' => 'js-edit ','escape'=>false, 'title' => __l('Edit')));?></li>
				<?php echo $this->Layout->adminRowActions($paymentGateway['PaymentGateway']['id']);  ?>
			</ul>
	      </div>
      </td>
      <td class="dl">
      <p><?php echo $this->Html->cText($paymentGateway['PaymentGateway']['name']);?></p>
      <span class="info span no-pad"><i class="icon-exclamation-sign"></i>
	  <?php echo $this->Html->cText($paymentGateway['PaymentGateway']['description']);?>
	  </span>
      </td>
      <td id="payment-id<?php echo $paymentGateway['PaymentGateway']['id']?>" class="dc js-payment-status <?php echo ($paymentGateway['PaymentGateway']['is_active'] == 1) ? 'js-active-gateways' : 'js-deactive-gateways'; ?>"><?php echo $this->Html->link(($paymentGateway['PaymentGateway']['is_active'] == 1) ? '<i class="icon-ok text-16 top-space"></i><span class="hide">Yes</span>' : '<i class="icon-remove text-16 top-space"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstPaymentGateways::Active, 'toggle' => ($paymentGateway['PaymentGateway']['is_active'] == 1) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));?></td>
    <?php
      unset($project_enabled);
      
      unset($wallet_enabled);
	  
	  
      foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting):
      if ($paymentGatewaySetting['name'] == 'is_enable_for_job_order'):
        $project_enabled = $paymentGatewaySetting['test_mode_value'];
      endif;
      if ($paymentGatewaySetting['name'] == 'is_enable_for_add_to_wallet'):
        $wallet_enabled = $paymentGatewaySetting['test_mode_value'];
      endif;	  
      endforeach;
    ?>
    <?php if (!isset($wallet_enabled)) { ?>
        <td class="dc">-</td>
    <?php } else{ ?>
    <td class="dc">
      <?php echo $this->Html->link(($wallet_enabled == 1) ? '<i class="icon-ok text-16 top-space"></i><span class="hide">Yes</span>' : '<i class="icon-remove text-16 top-space"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstPaymentGateways::Wallet, 'toggle' => ($wallet_enabled == 1) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax')); ?>
        </td>
    <?php } ?>
    <td class="dc">
      <?php echo $this->Html->link((!empty($project_enabled)) ? '<i class="icon-ok text-16 top-space"></i><span class="hide">Yes</span>' : '<i class="icon-remove text-16 top-space"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstPaymentGateways::Project, 'toggle' => (!empty($project_enabled)) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax')); ?>
    </td>    
	
    </tr>
    <?php
      endforeach;
      else:
    ?>
    <tr>
    <td colspan="5" class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo sprintf(__l('No %s available'), __l('Payment Gateways'));?></td>
    </tr>
    <?php
      endif;
    ?>
    </tbody>
  </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
  <div class="js-no-pjax pull-right">
    <?php if (!empty($paymentGateways)): ?>
    <?php echo $this->element('paging_links'); ?>
    <?php endif; ?>
  </div>
  </section>
</div>