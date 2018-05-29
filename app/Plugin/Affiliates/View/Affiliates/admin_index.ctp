<?php /* SVN: $Id: $ */ ?>
<div class="affiliates index js-response">
 <div class="pull-right space">
    <?php echo $this->Html->link('<i class="icon-cog text-16"></i> '.__l('Affiliate  Requests'), array('controller' => 'affiliate_requests', 'action' => 'index'), array('class' => 'blackc','escape'=>false, 'title' => __l('Affiliate  Requests')));?>
	<?php if(isPluginEnabled('Withdrawals')) : ?>
    <?php echo $this->Html->link('<i class="icon-briefcase text-16"></i> '.__l('Affiliate Cash Withdrawal Requests'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'), array('class' => 'blackc','escape'=>false, 'title' => __l('Affiliate Cash Withdrawal Requests')));?>
	<?php endif; ?>
    <?php echo $this->Html->link('<i class="icon-certificate text-16"></i> '.__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 20), array('class' => 'blackc','escape'=>false, 'title' => __l('Settings')));?>
  </div>

<?php echo $this->element('admin_affiliate_stat', array('cache' => array('time' => Configure::read('site.site_element_cache_10_min')))); ?>
<h2><?php echo __l('Commission History');?></h2>
<div class="clearfix">
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Pending) ? ' active' : null; ?>
	<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Pending') . '</dt><dd title="' . $pending . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($pending) . '</dd>  </dl>', array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Pending), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Pending'), 'escape' => false));?>
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Canceled) ? ' active' : null; ?>
	<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Canceled') . '</dt><dd title="' . $canceled . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($canceled) . '</dd>  </dl>', array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Canceled), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Canceled'), 'escape' => false));?>
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::PipeLine) ? ' active' : null; ?>
	<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Pipeline') . '</dt><dd title="' . $pipeline . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($pipeline) . '</dd>  </dl>', array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::PipeLine), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Pipeline'), 'escape' => false));?>
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Completed) ? ' active' : null; ?>
	<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Completed') . '</dt><dd title="' . $completed . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($completed) . '</dd>  </dl>', array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Completed), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Completed'), 'escape' => false));?>
	<?php $class = (empty($this->request->params['named']['filter_id'])) ? ' active' : null; ?>
	<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('All') . '</dt><dd title="' . $all . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($all) . '</dd>  </dl>', array('controller'=>'affiliates','action'=>'index'), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('All'), 'escape' => false));?>
</div>
<div class="clearfix bot-space"><?php echo $this->element('paging_counter');?></div>
<table class="table table-striped table-hover sep">
<thead>
    <tr class="no-mar no-pad">
        <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Created'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateUser.username', __l('Affiliate User'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateType.name', __l('Type'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateStatus.name', __l('Status'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dr sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('commission_amount', __l('Commission'). ' ('. Configure::read('site.currency').')', array('class' => 'graydarkerc no-under'));?></div></th>
    </tr>
    </thead>
<?php
if (!empty($affiliates)):

$i = 0;
foreach ($affiliates as $affiliate):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
        <td class="dc grayc"> <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['created']);?></td>
		<td class="grayc"><?php echo $this->Html->link($this->Html->cText($affiliate['AffiliateUser']['username']), array('controller'=> 'users', 'action'=>'view', $affiliate['AffiliateUser']['username'], 'admin' => false), array('class'=>'grayc', 'escape' => false));?></td>
        <td class="grayc"> <?php echo $this->Html->cText($affiliate['AffiliateType']['name']);?> </td>
		
		<td class="grayc">
           <?php echo $this->Html->cText($affiliate['AffiliateStatus']['name']);   ?>
           <?php  if($affiliate['AffiliateStatus']['id'] == ConstAffiliateStatus::PipeLine): ?>
                   <?php echo '['.__l('Since').': '.$this->Html->cDateTimeHighlight($affiliate['Affiliate']['commission_holding_start_date']). ']';?>
           <?php endif; ?>
        </td>
		<td class="dr grayc"><?php echo $this->Html->cFloat($affiliate['Affiliate']['commission_amount']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="11" class="notice grayc text-16 dc"><?php echo __l('No commission history available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($affiliates)) {?>
	<div class="pull-right">
		<?php echo $this->element('paging_links'); ?>
	</div>
<?php } ?>
</div>
