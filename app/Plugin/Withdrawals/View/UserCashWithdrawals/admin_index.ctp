<?php /* SVN: $Id: admin_index.ctp 69575 2011-10-25 05:50:05Z sakthivel_135at10 $ */ ?>
<div class="row-fluid">
<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('User Cash Withdrawals');?></li>      
	</ul>
	<div class="clearfix">
	  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending) ? ' active' : null; ?>
	   <?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Pending') . '</dt><dd title="' . $pending . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($pending) . '</dd>  </dl>', array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Pending), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Pending'), 'escape' => false));?>
	  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Rejected) ? ' active' : null; ?>
	   <?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Rejected') . '</dt><dd title="' . $rejected . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($rejected) . '</dd>  </dl>', array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Rejected), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Rejected'), 'escape' => false));?>
	  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Success) ? ' active' : null; ?>
	   <?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Success') . '</dt><dd title="' . $success . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($success) . '</dd>  </dl>', array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Success), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Success'), 'escape' => false));?>
      <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') ? ' active' : null; ?>
	   <?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('All') . '</dt><dd title="' . ($approved + $pending + $rejected + $success) . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($approved + $pending + $rejected + $success) . '</dd>  </dl>', array('controller'=>'user_cash_withdrawals','action'=>'index'), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('All'), 'escape' => false));?>
	</div>
  <?php if($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Approved): ?>
    <div class="alert alert-info">
      <?php echo __l('Following withdrawal request has been submitted to payment gateway API, These are waiting for IPN from the payment gateway API. Either it will move to Success or Failed'); ?>
    </div>
  <?php endif; ?>
  <section class="space clearfix">
    <div class="pull-left hor-space">
      <?php echo $this->element('paging_counter');?>
    </div>
  </section>
  <?php echo $this->Form->create('UserCashWithdrawal' , array('action' => 'update', 'class' => 'js-shift-click js-no-pjax')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <section class="space">
    <table class="table no-mar table-striped table-hover">
      <thead>
        <tr>
          <?php if(isset($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending)):?>
            <th class="dc sep-right textn"><?php echo __l('Select'); ?></th>
          <?php endif;?>
          <th class="dc sep-right textn"><?php echo __l('Actions'); ?></th>
          <th class="dl sep-right textn"><div><?php echo $this->Paginator->sort('User.username', __l('User'), array('class' => 'graydarkerc no-under'));?></div></th>
          <th class="dr sep-right textn"><div><?php echo $this->Paginator->sort('UserCashWithdrawal.amount', __l('Amount'), array('class' => 'graydarkerc no-under')).' ('.Configure::read('site.currency').')';?> </div></th>
          <?php if(empty($this->request->params['named']['filter_id'])) { ?>
            <th><div><?php echo $this->Paginator->sort('WithdrawalStatus.name', __l('Status'), array('class' => 'graydarkerc no-under'));?></div></th>
          <?php } ?>
          <th class="dc sep-right textn"><div><?php echo $this->Paginator->sort('UserCashWithdrawal.created', __l('Withdraw Requested Date'), array('class' => 'graydarkerc no-under'));?> </div></th>
        </tr>
      </thead>
      <tbody>
        <?php
          if (!empty($userCashWithdrawals)):
            foreach ($userCashWithdrawals as $userCashWithdrawal):
        ?>
        <tr>
          <?php if(isset($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending)):?>
            <td class="select dc">
              <?php echo $this->Form->input('UserCashWithdrawal.'.$userCashWithdrawal['UserCashWithdrawal']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userCashWithdrawal['UserCashWithdrawal']['id'], 'label' => '', 'class' => 'js-checkbox-list ' )); ?>
            </td>
          <?php endif;?>
          <td class="span1 dc">
            <div class="dropdown">
              <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog cur grayc text-20 dropdown-toggle js-no-pjax"><span class="hide"><?php echo __l('Action'); ?></span></a>
              <ul class="unstyled dropdown-menu dl arrow clearfix">
                <li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('action' => 'delete', $userCashWithdrawal['UserCashWithdrawal']['id']), array('class' => 'js-confirm ', 'escape' => false, 'title' => __l('Delete')));?></li>
                <?php if($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Approved): ?>
                  <li><?php echo $this->Html->link('<i class="icon-hdd"></i> ' . __l('Move to success'), array('action' => 'move_to', $userCashWithdrawal['UserCashWithdrawal']['id'], 'type' => 'success'), array('escape' => false, 'title' => __l('Move to success')));?></li>
                  <li><?php echo $this->Html->link('<i class="icon-remove-sign"></i> ' . __l('Move to failed'), array('action' => 'move_to', $userCashWithdrawal['UserCashWithdrawal']['id'], 'type' => 'failed'), array('class' => '', 'escape' => false, 'title' => __l('Move to failed')));?></li>
                <?php endif;?>
                <?php echo $this->Layout->adminRowActions($userCashWithdrawal['UserCashWithdrawal']['id']);  ?>
              </ul>
            </div>
          </td>
          <td class="dl">
            <?php echo $this->Html->showImage('UserAvatar', $userCashWithdrawal['User']['UserAvatar'], array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($userCashWithdrawal['User']['username'], false)), 'title' => $this->Html->cText($userCashWithdrawal['User']['username'], false)));?>
            <?php echo $this->Html->link($this->Html->cText($userCashWithdrawal['User']['username']), array('controller'=> 'users', 'action'=>'view', $userCashWithdrawal['User']['username'],'admin' => false), array('title'=>$this->Html->cText($userCashWithdrawal['User']['username'],false),'escape' => false));?>
            <?php
			  if($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending):
					foreach($userCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount):
					if(!empty($moneyTransferAccount['is_default'])):
				?>
				<?php
					endif;
				  endforeach;
			  endif;
            ?>
          </td>
          <td class="dr">
			<?php echo $this->Html->cCurrency($userCashWithdrawal['UserCashWithdrawal']['amount']);?>
			<?php if(!empty($userCashWithdrawal['UserCashWithdrawal']['remark'])): ?>
			<span class="js-tooltip" title="<?php echo $this->Html->cText($userCashWithdrawal['UserCashWithdrawal']['remark'], false); ?>"><i class="icon-question-sign"></i></span>
			<?php endif; ?>
		  </td>
          <?php if(empty($this->request->params['named']['filter_id'])) { ?>
            <td><?php echo $this->Html->cText($userCashWithdrawal['WithdrawalStatus']['name']);?></td>
          <?php } ?>
          <td class="dc"><?php echo $this->Html->cDate($userCashWithdrawal['UserCashWithdrawal']['created']);?></td>
        </tr>
        <?php
            endforeach;
          else:
        ?>
        <tr>
          <td colspan="6" class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo sprintf(__l('No %s available'), __l('User Cash Withdrawals'));?></td>
        </tr>
        <?php
          endif;
        ?>
      </tbody>
    </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
    <?php if (!empty($userCashWithdrawals)) { ?>
      <?php if(isset($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending)):?>
		<div class="top-space pull-left dc mob-clr mob-inline clearfix admin-select-block">
		   <div class="pull-left ver-space">
				<?php echo __l('Select:'); ?>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
			</div>
			<div class="pull-left hor-mspace mob-no-mar">
		        <?php echo $this->Form->input('more_action_id', array('class' => 'span js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
			</div>
        </div>
        <div class="hide">
          <?php echo $this->Form->submit('Submit');  ?>
        </div>
      <?php endif; ?>
      <div class="pull-right top-space"><?php echo $this->element('paging_links'); ?></div>
    <?php } ?>
  </section>
  <?php echo $this->Form->end(); ?>
</div>