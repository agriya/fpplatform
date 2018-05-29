<?php /* SVN: $Id: admin_edit.ctp 2895 2010-09-02 10:58:05Z sakthivel_135at10 $ */ ?>
<div class="paymentGateways form row-fluid space">
  <?php echo $this->Form->create('PaymentGateway');?>
  <ul class="breadcrumb">
  <li><?php echo $this->Html->link(__l('Payment Gateways'), array('action' => 'index'), array('title' => __l('Payment Gateways')));?><span class="divider">&raquo;</span></li>
  <li class="active"><?php echo sprintf(__l('Edit %s'), __l('Payment Gateway'));?></li>  
  </ul>  
  <div>
	<?php
		if(!empty($SudoPayGatewaySettings['sudopay_merchant_id']) && $id == ConstPaymentGateways::SudoPay) {
			echo $this->element('sudopay-info', array('cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
		}		
	?>
  </div>
  <fieldset class="offset1">
    <?php	
    echo $this->Form->input('id');
    if($this->request->data['PaymentGateway']['id'] == ConstPaymentGateways::Wallet){
		$payment_gateway_name= 'Wallet';
	} else {
		$payment_gateway_name= 'Sudopay';
	}
    if ($this->request->data['PaymentGateway']['id'] != ConstPaymentGateways::Wallet && $this->request->data['PaymentGateway']['id'] == ConstPaymentGateways::SudoPay):
      echo $this->Form->input('is_test_mode', array('label' => __l('Test Mode?')));
    endif;
    foreach($paymentGatewaySettings as $paymentGatewaySetting) {
      $options['type'] = $paymentGatewaySetting['PaymentGatewaySetting']['type'];
      if($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_job_order'):
      $options['label'] = sprintf(__l('Enable for %s order'), Configure::read('job.job_alternate_name'));      
      elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_add_to_wallet'):
      $options['label'] = __l('Enable for add to wallet');
	  elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_signup_fee'):
      $options['label'] = __l('Enable for sign up fee');
      endif;
      $options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
      $options['div'] = array('id' => "setting-{$paymentGatewaySetting['PaymentGatewaySetting']['name']}");
      if($options['type'] == 'checkbox' && !empty($options['value'])):
      $options['checked'] = 'checked';
      else:
      $options['checked'] = '';
      endif;
      if($options['type'] == 'select'):
      $selectOptions = explode(',', $paymentGatewaySetting['PaymentGatewaySetting']['options']);
      $paymentGatewaySetting['PaymentGatewaySetting']['options'] = array();
      if(!empty($selectOptions)):
        foreach($selectOptions as $key => $value):
        if(!empty($value)):
          $paymentGatewaySetting['PaymentGatewaySetting']['options'][trim($value)] = trim($value);
        endif;
        endforeach;
      endif;
      $options['options'] = $paymentGatewaySetting['PaymentGatewaySetting']['options'];
      endif;
      if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['description']) && empty($options['after'])):
      $FindReplace = array(
            '##CURRENT_PAYMENT##' => $payment_gateway_name,
            
        );
		  $help = strtr($paymentGatewaySetting['PaymentGatewaySetting']['description'], $FindReplace);

        $options['help'] = "{$help}";            
      else:
      $options['help'] = '';
      endif;
      if ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_signup_fee' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_job_order' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_add_to_wallet'):
      echo $this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options);
      endif;
    }
    if ($paymentGatewaySettings && $this->request->data['PaymentGateway']['id'] != ConstPaymentGateways::Wallet) {
    ?>

    <?php
    $j = $i = $z = $n = $x= 0;
    foreach($paymentGatewaySettings as $paymentGatewaySetting) {
      $options['type'] = $paymentGatewaySetting['PaymentGatewaySetting']['type'];
      $options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
      $options['div'] = array('id' => "setting-{$paymentGatewaySetting['PaymentGatewaySetting']['name']}");
      if($options['type'] == 'checkbox' && $options['value']):
      $options['checked'] = 'checked';
      endif;
      if($options['type'] == 'select'):
            $selectOptions = explode(',', $paymentGatewaySetting['PaymentGatewaySetting']['options']);
            $paymentGatewaySetting['PaymentGatewaySetting']['options'] = array();
            if(!empty($selectOptions)):
              foreach($selectOptions as $key => $value):
                if(!empty($value)):
                  $paymentGatewaySetting['PaymentGatewaySetting']['options'][trim($value)] = trim($value);
                endif;
              endforeach;
            endif;
            $options['options'] = $paymentGatewaySetting['PaymentGatewaySetting']['options'];
          endif;
      $options['label'] = false;
      if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['description']) && empty($options['after'])):
        $FindReplace = array(
            '##CURRENT_PAYMENT##' => $payment_gateway_name,
            
        );
		  $help = strtr($paymentGatewaySetting['PaymentGatewaySetting']['description'], $FindReplace);

        $options['help'] = "{$help}";       
      else:
      $options['help'] = '';
      endif;
    ?>
      </fieldset>
      <?php if($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_merchant_id' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_website_id' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_secret_string' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_api_key'): ?>
	  <?php if($x == 0):?>
        <fieldset class="fields-block round-5">
		<div class="clearfix">
        <div class="input text clearfix">
        
          <div class="offset6 span5 dc hor-space pull-left">
          <span class="text-16"><?php echo __l('Live Mode Credential'); ?></span>
          </div>
		  <div class="span5 hor-space offset5 pull-left  ">
         <span class="text-16"><?php echo __l('Test Mode Credential'); ?></span>
          </div>
		  </div>
      <?php endif;?>

	 

		<div class="input text clearfix">
          <label class="span4 pull-left"><?php echo Inflector::humanize($paymentGatewaySetting['PaymentGatewaySetting']['name']); ?></label>
          <div class="offset1 span8 hor-space pull-left">
          <?php
            $options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['live_mode_value'];
            echo $this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.live_mode_value", $options);
          ?>
          </div>
		  <div class="offset1 span5 hor-space pull-left">
          <?php
            $options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
            echo $this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options);
          ?>
          </div>
        </div>
	  <?php if($x == 2):?>
        </fieldset>
      <?php endif;?>
      <?php $x++;?>
	  <?php endif; ?>
  <?php
      }
  }
  ?>
 <div class="offset4 clearfix">
  <?php echo $this->Form->submit(__l('Update'),array("class"=>"btn btn-primary"));?>
  <?php echo $this->Form->end();?>
  </div>
</div>