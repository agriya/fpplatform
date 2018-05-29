<?php $credit = 1;
$debit = 1;
if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == ConstTransactionTypes :: AddedToWallet) && !empty($this->request->params['named']['stat'])) {
    $debit = 0;
}
$debit_total_amt = $credit_total_amt = $gateway_total_fee = 0;
if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == ConstTransactionTypes::ReferralAmountPaid || $this->request->params['named']['type'] == ConstTransactionTypes::AcceptCashWithdrawRequest || $this->request->params['named']['type'] == ConstTransactionTypes::PaidDealAmountToCompany) && !empty($this->request->params['named']['stat'])) {
    $credit = 0;

}?>
<?php if(empty($this->request->params['isAjax'])): ?>
   <div class="top-space clearfix ">
    <div class="span no-mar users-form tab-clr pull-right">
        <div class="pull-left mob-clr mob-dc">
          <?php echo $this->Form->create('Transaction' , array('action' => 'admin_index', 'type' => 'post', 'class' => 'normal form-inline  clearfix')); ?>
		  <div class="pull-left no-mar span pull-left">
          <?php
            echo $this->Form->autocomplete('User.username', array('div'=>'right-space input text','label' => false, 'placeholder' => __l('User'), 'acFieldKey' => 'Transaction.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
            echo $this->Form->input('JobOrder.Id', array('div'=>'hor-space hor-space input text', 'label' => false,'placeholder' => __l('Order has high priority than').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).'.'));
            echo $this->Form->autocomplete('Job.title', array('div'=>'hor-space hor-space input text','label' => false, 'placeholder' => jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), 'acFieldKey' => 'Job.id', 'acFields' => array('Job.title'), 'acSearchFieldNames' => array('Job.title'), 'maxlength' => '255'));
         ?>
		 </div>
        <div class="span clearfix date-time-block  no-mar top-smspace pull-left">
            <div class="input date-time select span">
                <div class="js-datetime">
                    <div class="js-cake-date">
                        <?php echo $this->Form->input('from_date', array('label' => __l('From'), 'type' => 'date','empty' => __l('Please Select'), 'div' => false, 'minYear' => date('Y') - 10, 'maxYear' => date('Y'), 'orderYear' => 'asc')); ?>
                    </div>
                </div>
            </div>
            <div class="input date-time select span no-mar">
                <div class="js-datetime">
                    <div class="js-cake-date">
                        <?php echo $this->Form->input('to_date', array('label' => __l('To'), 'type' => 'date','empty' => __l('Please Select'), 'div' => false, 'minYear' => date('Y') - 10, 'maxYear' => date('Y'), 'orderYear' => 'asc')); ?>
                    </div>
				</div>                
				</div>                
				</div>                
				<div class="submit left-space pull-left">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
                <div class="pull-right hor-space top-smspace mob-clr mob-dc tab-clr">
                    <?php echo $this->Html->link('<i class="icon-signout no-pad text-18"></i> <span class="grayc">' . __l('Export') . '</span>', array_merge(array('controller' => 'transactions', 'action' => 'export_filtered', 'csv:all', 'ext' => 'csv',!empty($export_hash)?$export_hash:''),$this->request->params['named']), array('title' => __l('Export This Report In CSV'), 'class' => 'textb bluec text-13 js-no-pjax', 'escape' => false));?>
                </div>
			  <?php echo $this->Form->end(); ?>
			</div>
   
  </div>  
<?php endif;?>
 <div class="clearfix bot-space"><?php echo $this->element('paging_counter'); ?> </div>
<div class="transactions index js-response js-responses clearfix">
	<div class="overflow-block">
    <table class="table table-striped table-hover sep">
       <thead>
	   <tr class="no-mar no-pad">
            <th class="dc sep-right textn span3"><?php echo $this->Paginator->sort('Transaction.created', __l('Date'), array('class' => 'graydarkerc no-under'));?></th>
            <th class="dc sep-right textn"><?php echo $this->Paginator->sort('User.username', __l('User'), array('class' => 'graydarkerc no-under'));?></th>
            <th class="dc sep-right textn"><?php echo $this->Paginator->sort('TransactionType.name', __l('Description'), array('class' => 'graydarkerc no-under'));?></th>
            <?php if(!empty($credit)){ ?>
                <th class="dc sep-right textn"><?php echo $this->Paginator->sort('Transaction.amount', __l('Credit').' ('.Configure::read('site.currency').')', array('class' => 'graydarkerc no-under'));?></th>
            <?php } ?>
            <?php if(!empty($debit)){?>
                <th class="dc sep-right textn"><?php echo $this->Paginator->sort('Transaction.amount', __l('Debit').' ('.Configure::read('site.currency').')', array('class' => 'graydarkerc no-under'));?></th>
            <?php } ?>            
        </tr>
		</thead>
    <?php
    if (!empty($transactions)):
    
    $i = 0;
    foreach ($transactions as $transaction):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
        <tr<?php echo $class;?>>
                <td><?php echo $this->Html->cDateTimeHighlight($transaction['Transaction']['created']);?></td>
                <td class="dl">
                <?php $avatar= !empty($transaction['User']['UserAvatar'])?$transaction['User']['UserAvatar']:'';
				echo $this->Html->showImage('UserAvatar', $avatar , array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($transaction['User']['username'], false)), 'title' => $this->Html->cText($transaction['User']['username'], false)));?>
                <?php echo $this->Html->link($this->Html->cText($transaction['User']['username']), array('controller'=> 'users', 'action'=>'view', $transaction['User']['username'],'admin' => false), array('escape' => false, 'title' => $transaction['User']['username']));?></td>
                <td class="dl">
                    <?//php echo $this->Html->cText($transaction['TransactionType']['name']);?>
                    <?php
                        $class = $transaction['Transaction']['class'];
               			echo $this->Html->transactionDescription($transaction);
                    ?>
                </td>
                <?php if(!empty($credit)) {?>
                    <td class="dr">
                        <?php
                            if($transaction['TransactionType']['is_credit']):
                                echo $this->Html->cCurrency($transaction['Transaction']['amount']);
								$credit_total_amt = $credit_total_amt + $transaction['Transaction']['amount']; 
                            else:
                                echo '--';
                            endif;
                         ?>
                    </td>
                <?php } ?>
                <?php if(!empty($debit)) {?>
                    <td class="dr">
                        <?php
                            if($transaction['TransactionType']['is_credit']):
                                echo '--';
                            else:
							    $debit_total_amt = $debit_total_amt + $transaction['Transaction']['amount'];
                                echo $this->Html->cCurrency($transaction['Transaction']['amount']);
                            endif;
                         ?>
                    </td>
                <?php } ?>                
            </tr>
    <?php
        endforeach;
	?>
	<tr class="total-block">
		<td colspan="3" class="dr"><?php echo __l('Total');?></td>
		 <?php if(!empty($credit)) {?>
		<td class="dr"><?php echo Configure::read('site.currency') . $this->Html->cCurrency($credit_total_amt);?></td>
		 <?php } if(!empty($debit)) {?>
		<td class="dr"><?php echo Configure::read('site.currency') . $this->Html->cCurrency($debit_total_amt);?></td> 
		<?php } ?>
		
		</tr>
		<?php
		else:
		?>
        <tr>
            <td colspan="11" class="notice dc"><?php echo __l('No Transactions available');?></td>
        </tr>
		<?php
		endif;
		?>
    </table>
    </div>
	</div>
    <?php
    if (!empty($transactions)) {
        ?>
            <div class="pull-right">
                <?php echo $this->element('paging_links'); ?>
            </div>
        <?php
    }
    ?>
</div>
