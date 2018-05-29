<?php /* SVN: $Id: admin_index.ctp 4904 2010-05-13 09:31:09Z josephine_065at09 $ */ ?>
<div class="hor-space js-response">
	<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo $pageTitle;?></li>
	</ul>
	<div class="tabbable ver-space sep-top top-mspace">
      <div id="list" class="tab-pane active in no-mar">
        <div class="clearfix">
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending) ? ' active' : null; ?>            
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Pending') . '</dt><dd title="' . $pending . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($pending) . '</dd>  </dl>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Pending), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Pending'), 'escape' => false));?>            
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Success) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Success') . '</dt><dd title="' . $success . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($success) . '</dd>  </dl>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Success), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Success'), 'escape' => false));?>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Failed) ? ' active' : null; ?>
 			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Failed') . '</dt><dd title="' . $failed . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($failed) . '</dd>  </dl>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Failed), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Failed'), 'escape' => false));?>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Approved) ? ' active' : null; ?>
 			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Approved') . '</dt><dd title="' . $approved . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($approved) . '</dd>  </dl>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Approved), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Approved'), 'escape' => false));?>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Rejected) ? ' active' : null; ?>
 			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Rejected') . '</dt><dd title="' . $rejected . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($rejected) . '</dd>  </dl>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Rejected), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Rejected'), 'escape' => false));?>			
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') ? ' active' : null; 
			$count = $approved + $pending + $rejected + $success + $failed;?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('All') . '</dt><dd title="' . $count . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($count) . '</dd>  </dl>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => 'all'), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('All'), 'escape' => false));?>
		</div>
		<div class="clearfix top-space top-mspace">		  
		  <?php echo $this->element('paging_counter'); ?>
		</div>
<?php echo $this->Form->create('AffiliateCashWithdrawal' , array('class' => 'normal form-horizontal','action' => 'update')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="tab-pane active in no-mar" id="active-users">
  <div class="sep bot-mspace img-rounded clearfix">
    <table class="table no-mar table-striped table-hover">
  	  <thead>
	  <tr class="no-mar no-pad">
        <?php if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] != ConstAffiliateCashWithdrawalStatus::Approved && $this->request->params['named']['filter_id'] != ConstAffiliateCashWithdrawalStatus::Success && $this->request->params['named']['filter_id'] != ConstAffiliateCashWithdrawalStatus::Rejected && $this->request->params['named']['filter_id'] != 'all'):?>
		<th class="dc sep-right textn span1"><?php echo __l('Select');?></th>
        <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
        <?php endif; ?>
         <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('User'));?></div></th>
            <th class="dr sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.amount', __l('Amount')).' ('.Configure::read('site.currency').')';?> </div></th>
            <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') { ?>
                <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.name', __l('Status'));?></div></th>
            <?php } ?>
        </tr>
        </thead>
    <tbody>
    <?php
    if (!empty($affiliateCashWithdrawals)):   
    $i = 0;
    foreach ($affiliateCashWithdrawals as $affiliateCashWithdrawal):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
                ?>
            <tr>
            <?php if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] != ConstAffiliateCashWithdrawalStatus::Approved && $this->request->params['named']['filter_id'] != ConstAffiliateCashWithdrawalStatus::Success && $this->request->params['named']['filter_id'] != ConstAffiliateCashWithdrawalStatus::Rejected && $this->request->params['named']['filter_id'] != 'all'):?>
                <td class="dc grayc">
                <?php echo $this->Form->input('AffiliateCashWithdrawal.'.$affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'label' => '', 'div' => false, 'class' => 'js-checkbox-list')); ?>
                </td>
                <td class="dc grayc">
					<div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
						<ul class="dropdown-menu arrow dl">
						<li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('action' => 'delete', $affiliateCashWithdrawal['AffiliateCashWithdrawal']['id']), array('class' => 'js-confirm', 'title' => __l('Delete'), 'escape' => false));?></li>
						</ul>
			          </div>  
					</td>
            <?php endif; ?>
                <td class="dl">
            <?php echo $this->Html->showImage('UserAvatar', $affiliateCashWithdrawal['User']['UserAvatar'], array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($affiliateCashWithdrawal['User']['username'], false)), 'title' => $this->Html->cText($affiliateCashWithdrawal['User']['username'], false)));?>
            <?php echo $this->Html->link($this->Html->cText($affiliateCashWithdrawal['User']['username']), array('controller'=> 'users', 'action'=>'view', $affiliateCashWithdrawal['User']['username'],'admin' => false), array('title'=>$this->Html->cText($affiliateCashWithdrawal['User']['username'],false),'escape' => false));?></td>
            <td class="dr"><?php echo $this->Html->cCurrency($affiliateCashWithdrawal['AffiliateCashWithdrawal']['amount']);?></td>
            <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') { ?>
                <td>
					<?php 
						if($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Pending):
							echo __l('Pending');
						elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Approved):
							echo __l('Approved');
						elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Rejected):
							echo __l('Rejected');
						elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Failed):
							echo __l('Failed');
						elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Success):
							echo __l('Success');
						else:
							echo $this->Html->cText($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['name']);
						endif;
					?>
				</td>
            <?php } ?>
        </tr>
            <?php
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="5" class="notice dc grayc text-16"><?php echo __l('No records available');?></td>
        </tr>
        <?php
    endif;
    ?>
    </tbody>
    </table>
</div>
</div>    
    <?php if (!empty($affiliateCashWithdrawals) && (empty($this->request->params['named']['filter_id']) || (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] != ConstAffiliateCashWithdrawalStatus::Approved && $this->request->params['named']['filter_id'] != ConstAffiliateCashWithdrawalStatus::Success && $this->request->params['named']['filter_id'] != ConstAffiliateCashWithdrawalStatus::Rejected && $this->request->params['named']['filter_id'] != 'all'))):?>
    
  <div class="ver-mspace mob-dc clearfix">
    <div class="top-space pull-left dc mob-clr mob-inline clearfix">
       <div class="pull-left ver-space">
         <?php echo __l('Select:'); ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
        </div>
        <div class="pull-left hor-mspace mob-no-mar">
                <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit span4', 'label' => false,  'empty' => __l('-- More actions --'))); ?>
        </div>
      </div>
      <div class="pull-right top-space">
         <?php echo $this->element('paging_links'); ?>
      </div>
	  <div class="hide">
        <?php echo $this->Form->submit('Submit');  ?>
      </div>
<?php endif;
echo $this->Form->end();
?>
</div> 
</div>
</div>