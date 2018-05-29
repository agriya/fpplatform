<?php /* SVN: $Id: index.ctp 1721 2010-04-17 11:06:44Z preethi_083at09 $ */ ?>
<div class="userCashWithdrawals index js-response js-withdrawal_responses js-responses">
<?php if(!empty($moneyTransferAccounts)) { ?>
        <?php echo $this->element('../affiliate_cash_withdrawals/add', array('cache' => array('time' => Configure::read('site.element_cache')))); ?>
<?php }
else
{ ?>
<div class="alert alert-info"><b><?php echo $this->Html->link(__l('Your money transfer account is empty, so click here to update your money transfer account.'), array('controller' => 'money_transfer_accounts', 'action'=>'index'), array('title' => sprintf(__l('Edit %s'), __l('Money Transfer Account')))); ?></b></div>
<?php
}
?>
<?php echo $this->element('paging_counter');?>
  <div class="overflow-block">
<table class="table table-striped table-hover sep">
    <tr>
		<th><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.created', __l('Requested On'));?></div></th>
        <th class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.amount', __l('Amount').' ('.Configure::read('site.currency').')');?></div></th>
<th><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateCashWithdrawalStatus.name', __l('Status'));?></div></th>
    </tr>
<?php
if (!empty($userCashWithdrawals)):
$i = 0;
foreach ($userCashWithdrawals as $userCashWithdrawal):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php echo $this->Html->cDateTime($userCashWithdrawal['AffiliateCashWithdrawal']['created']);?></td>
    	<td class="dr"><?php echo $this->Html->siteCurrencyFormat($this->Html->cCurrency($userCashWithdrawal['AffiliateCashWithdrawal']['amount']));?></td>
		<td>
		<?php 
			if($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Pending):
				echo __l('Pending');
			elseif($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Approved):
				echo __l('Approved');
			elseif($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Rejected):
				echo __l('Rejected');
			elseif($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Failed):
				echo __l('Failed');
			elseif($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Success):
				echo __l('Success');
				if(!empty($userCashWithdrawal['AffiliateCashWithdrawal']['commission_amount'])):
				echo "<p>".($this->Html->siteCurrencyFormat($this->Html->cCurrency($userCashWithdrawal['AffiliateCashWithdrawal']['amount'] - $userCashWithdrawal['AffiliateCashWithdrawal']['commission_amount']))).' = ['.$this->Html->siteCurrencyFormat($this->Html->cCurrency($userCashWithdrawal['AffiliateCashWithdrawal']['amount'])).' - '.$this->Html->siteCurrencyFormat($this->Html->cCurrency($userCashWithdrawal['AffiliateCashWithdrawal']['commission_amount'])).']'."</p>";				
				endif;
			else:
				echo $this->Html->cText($userCashWithdrawal['AffiliateCashWithdrawalStatus']['name']);
			endif;
		?>
		</td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="8">
			<div class="thumbnail space dc grayc">
				<p class="ver-mspace top-space text-16"><?php echo __l('No withdraw requests available');?></p>
			</div>
		</td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($userCashWithdrawals)) { ?>
      <div class="pull-right"> <?php echo $this->element('paging_links'); ?> </div> 
<?php } ?>
</div>
