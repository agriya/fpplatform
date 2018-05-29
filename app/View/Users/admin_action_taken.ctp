<?php if(isPluginEnabled('Disputes')) { ?>
<div class="hor-mspace textb bot-space grayc"><?php echo __l('Dispute').' ' ?>  </div>
<div class="hor-mspace">
<ul class="left-mspace grayc bot-space js-live-tour-parent">
  <li><?php echo $this->Html->link(__l('Pending Disputes').' ('.$pending_dispute.')' , array('controller' => 'job_order_disputes','action' =>'index','filter_id'=>ConstDisputeStatus::WaitingForAdministratorDecision),array('title' => __l('Pending Disputes').' ('.$pending_dispute.')'));?>
	</li>
</ul>
</div>
<?php } ?>
<?php if(isPluginEnabled('Affiliates')) { ?>
<div class="hor-mspace textb bot-space grayc"><?php echo __l('Affilitate Request').' ' ?>  </div>
<div class="hor-mspace">
<ul class="left-mspace grayc bot-space js-live-tour-parent">
  <li><?php echo $this->Html->link(__l('Pending Request').' ('.$pending_afftilitate_request.')' , array('controller' => 'affiliate_requests','action' =>'index'),array('title' => __l('Pending Request').' ('.$pending_afftilitate_request.')'));?>
 </li>
</ul>
</div>

<div class="hor-mspace textb bot-space grayc"><?php echo __l('Affilitate Withdraw Request').' ' ?>  </div>
<div class="hor-mspace">
<ul class="left-mspace grayc bot-space js-live-tour-parent">
  <li><?php echo $this->Html->link(__l('Pending Withdraw Request').' ('.$pending_afftilitate_withdraw_request . ')' , array('controller' => 'affiliate_cash_withdrawals','action' =>'index','filter_id'=>ConstAffiliateCashWithdrawalStatus::Pending),array('title' => __l('Pending Withdraw Request').' ('.$pending_afftilitate_withdraw_request.')'));?>
</li>
</ul>
</div>
<?php } ?>
<?php if(isPluginEnabled('Withdrawals')) { ?>
<div class="hor-mspace textb bot-space grayc"><?php echo __l('User Cash Withdraw Request').' ' ?>  </div>
<div class="hor-mspace">
<ul class="left-mspace grayc bot-space js-live-tour-parent">
  <li><?php echo $this->Html->link(__l('Pending Withdraw Request').' ('.$pending_usercash_withdraw_request . ')' , array('controller' => 'user_cash_withdrawals','action' =>'index','filter_id'=>ConstWithdrawalStatus::Pending),array('title' => __l('Pending Withdraw Request').' ('.$pending_usercash_withdraw_request .')'));?>
  </li>
</ul>
</div>
<?php } ?>