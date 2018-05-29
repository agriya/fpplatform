<?php /* SVN: $Id: index.ctp 69483 2011-10-22 12:41:35Z sakthivel_135at10 $ */ ?>
<div class="clearfix">
<section class="sep-bot top-smspace">
	<div class="container clearfix bot-space">
		<div class="label label-info show text-18 clearfix no-round ver-mspace">
			<div class="span smspace"><?php echo __l('Withdraw Fund Request'); ?></div>
			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
	</div>
</section>
  <div class="container">
    <div class="userCashWithdrawals index js-response js-withdrawal_responses js-responses">
      <?php if(!empty($moneyTransferAccounts)) : ?>
        <div class="clearfix">
          <span class="pull-right space">
            <?php
              echo $this->Html->link('<i class="icon-briefcase"></i>' . __l(' Money Transfer Accounts'), array('controller' => 'money_transfer_accounts', 'action'=>'index'), array('class' => 'blackc pay', 'escape'=>false, 'title' => __l('Money Transfer Accounts')));
            ?>
          </span>
        </div>
        <?php echo $this->element('withdrawals-add'); ?>
      <?php else: ?>
        <div class="alert alert-info">
          <?php echo $this->Html->link(__l('Your money transfer account is empty, so click here to update money transfer account.'), array('controller' => 'money_transfer_accounts', 'action'=>'index'), array('title' => __l('Money Transfer Accounts'))); ?>
        </div>
      <?php endif;?>
      <section class="space clearfix">
        <div class="pull-left hor-space">
          <?php echo $this->element('paging_counter');?>
        </div>
      </section>
      <section class="space">
        <table class="table table-striped table-bordered table-condensed table-hover">
          <tr>
            <th class="dc"><div class="js-filter js-no-pjax"><?php echo $this->Paginator->sort('UserCashWithdrawal.created', __l('Requested On'));?></div></th>
            <th class="dr"><div class="js-filter js-no-pjax"><?php echo $this->Paginator->sort('UserCashWithdrawal.amount', __l('Amount').' ('.Configure::read('site.currency').')');?></div></th>
            <th class="dl"><div class="js-filter js-no-pjax"><?php echo $this->Paginator->sort('WithdrawalStatus.name', __l('Status'));?></div></th>
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
            <td class="dc"><?php echo $this->Html->cDateTime($userCashWithdrawal['UserCashWithdrawal']['created']);?></td>
            <td class="dr"><?php echo $this->Html->cCurrency($userCashWithdrawal['UserCashWithdrawal']['amount']);?></td>
            <td class="dl"><?php echo $this->Html->cText($userCashWithdrawal['WithdrawalStatus']['name']);?></td>
          </tr>
          <?php
              endforeach;
            else:
          ?>
          <tr>
            <td colspan="3" class="errorc space">
			 <div class="space dc grayc">
        	  <p class="ver-mspace top-space text-16">
			   <?php echo sprintf(__l('No %s available'), __l('User Cash Withdrawals'));?>
			 </p>
			</div>
			</td>
          </tr>
          <?php
            endif;
          ?>
        </table>
      </section>
      <section class="clearfix hor-mspace bot-space">
        <?php if (!empty($userCashWithdrawals)):?>
          <div class="pull-right  js-no-pjax">
            <?php echo $this->element('paging_links'); ?>
          </div>
        <?php endif;?>
      </section>
    </div>
  </div>
</div>