<?php /* SVN: $Id: admin_index.ctp 69757 2011-10-29 12:35:25Z josephine_065at09 $ */ ?>
<?php
  if(!empty($this->request->params['isAjax'])):
    echo $this->element('flash_message');
  endif;
?>
<div class="userCashWithdrawals index js-response space">
  <?php echo $this->Form->create('UserCashWithdrawal' , array('action' => 'pay_to_user')); ?>
  <table class="table no-mar table-striped table-hover">
    <tr>
      <th class="sep-right textn"><div><?php echo $this->Paginator->sort('User.username', __l('User'), array('class' => 'graydarkerc no-under'));?></div></th>
      <th class="dr sep-right textn"><div><?php echo $this->Paginator->sort('UserCashWithdrawal.amount', __l('Amount'), array('class' => 'graydarkerc no-under')).' ('.Configure::read('site.currency').')';?> </div></th>
      <th class="dl sep-right textn"><?php echo __l('Gateway');?></th>
	  <th class="dl sep-right textn"><?php echo __l('Money Transfer Accounts');?></th>
      <th class="dr sep-right textn"><div><?php echo $this->Paginator->sort('User.total_amount_withdrawn', __l('Paid Amount'), array('class' => 'graydarkerc no-under')).' ('.Configure::read('site.currency').')';?></div></th>
    </tr>
    <?php
      $i = 0;
      if (!empty($userCashWithdrawals)):
        foreach ($userCashWithdrawals as $userCashWithdrawal):
          $i++;
    ?>
    <tr>
      <td class="dl">
        <div>
          <?php
            foreach($userCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount):
              if(!empty($moneyTransferAccount['PaymentGateway'])):
          ?>
            <span class="label label-project-status-2 paypal"><?php echo $this->Html->cText($moneyTransferAccount['PaymentGateway']['display_name']);?></span>
          <?php
              endif;
            endforeach;
          ?>
          <?php echo $this->Form->input('UserCashWithdrawal.'.($i-1).'.id', array('type' => 'hidden', 'value' => $userCashWithdrawal['UserCashWithdrawal']['id'], 'label' => false)); ?>
          <?php echo $this->Html->link($this->Html->cText($userCashWithdrawal['User']['username']), array('controller'=> 'users', 'action'=>'view', $userCashWithdrawal['User']['username'],'admin' => false), array('title'=>$this->Html->cText($userCashWithdrawal['User']['username'],false),'escape' => false));?>
        </div>
      </td>
      <td class="dr"><?php echo $this->Html->cCurrency($userCashWithdrawal['UserCashWithdrawal']['amount']);?></td>
      <td class="dl"><?php echo $this->Form->input('UserCashWithdrawal.'.($i-1).'.gateways',array('type' => 'select', 'options' => $userCashWithdrawal['paymentways'], 'label' => false, 'class' => "js-payment-gateway_select {container:'js-info-".($i-1)."-container'}")); ?>
        <div class="<?php echo "js-info-".($i-1)."-container"; ?>">
          <?php echo $this->Form->input('UserCashWithdrawal.'.($i-1).'.info',array('type' => 'textarea', 'label' => false, 'info' => 'Info for Paid')); ?>
        </div>
      </td>
	  <td>
	  <dl>
	  <?php $i=0;
	  foreach($userCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount):?>
	 <?php if(!empty($moneyTransferAccount['is_default'])):?>
	 <dt><?php echo __l('Primary Account:'); ?></dt>
	 <dd><?php echo nl2br($this->Html->cText($moneyTransferAccount['account'])); ?></dd>
	 <?php endif; endforeach; ?>
	<?php foreach($userCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount): ?>
    <?php
        if (!empty($moneyTransferAccount['is_default'])):
            continue;
        endif;
    ?>
	<?php if ($i == 0): ?>
	 <dt><?php echo __l('Other Accounts:'); ?></dt>
	 <?php endif; ?>
	 <dd><?php echo nl2br($this->Html->cText($moneyTransferAccount['account'])); ?></dd>
	  <?php
	  $i++;
	  endforeach; ?>
	  </dl>
	  </td>
      <td class="dr"><?php echo $this->Html->cCurrency($userCashWithdrawal['User']['total_amount_withdrawn']); ?></td>
    </tr>
    <?php
        endforeach;
      else:
    ?>
    <tr>
      <td colspan="8" class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo sprintf(__l('No %s available'), __l('User Cash Withdrawals'));?></td>
    </tr>
    <?php
      endif;
    ?>
  </table>
  <?php echo $this->Form->submit(__l('Proceed'), array('class' => 'btn btn-primary')); ?>
  <?php echo $this->Form->end(); ?>
</div>