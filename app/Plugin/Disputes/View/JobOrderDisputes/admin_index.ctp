<?php /* SVN: $Id: $ */ ?>
<div class="jobOrderDisputes index">
	<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo sprintf(__l('%s Order Disputes'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></li>
	</ul>
<div class="tabbable ver-space sep-top top-mspace">
<div id="list" class="tab-pane active in no-mar">
<div class="clearfix">
	    <?php foreach($status_count as $status):?>
		<div>
		<?php $class = ((!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == $status['id']) || (empty($status['id']) && empty($this->request->params['named']['filter_id']))) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l($status['dispaly']) . '</dt><dd title="' . $this->Html->cInt($status['count'], false) . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($status['count'], false) . '</dd>  </dl>', array('controller'=>'job_order_disputes','action'=>'index','filter_id' => $status['id']), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l($status['dispaly']), 'escape' => false));?>
			</div>
		<?php endforeach; ?>
</div>
<div class="clearfix top-space top-mspace sep-top">
  <div class="pull-left"><?php echo $this->element('paging_counter');?></div>
    <div class="pull-right span users-form tab-clr">
        <div class="pull-left mob-clr mob-dc">
          <?php echo $this->Form->create('JobOrderDispute', array('type' => 'get', 'class' => 'form-inline normal', 'action'=>'index')); ?>
          <?php echo $this->Form->input('filter_id',array('empty' => __l('Please Select'), 'label' => false, 'class' => 'span3')); ?>
            <?php echo $this->Form->input('dispute_type_id',array('empty' => __l('Please Select'), 'label' => false, 'div' => false, 'class' => 'span3')); ?>
          <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
            <div class="submit left-space">
              <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
            </div>
          <?php echo $this->Form->end(); ?>
        </div>
  </div>
</div>
</div>
</div>
<div class="sep bot-mspace img-rounded clearfix">
<table class="table no-mar table-striped table-hover">
<thead>
    <tr class="no-mar no-pad">
        <th class="dc sep-right textn"><?php echo __l('Actions');?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('created', __l('Created'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('user_id', __l('User'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('job_id', jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('job_order_id', __l('Order #'), array('class' => 'graydarkerc no-under'));?></th>
		<th class="dc sep-right textn"><?php echo $this->Paginator->sort('job_order_status_id', sprintf(__l('%s Order Status'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('job_user_type_id', sprintf(__l('%s User Type'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('dispute_type_id', __l('Dispute Type'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('reason', __l('Reason'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('dispute_status_id', __l('Dispute Status'), array('class' => 'graydarkerc no-under'));?></th>
		<th class="dc sep-right textn"><?php echo $this->Paginator->sort('resolved_date', __l('Resolved'), array('class' => 'graydarkerc no-under'));?></th>
		<th class="dc sep-right textn"><?php echo $this->Paginator->sort('favour_user_type_id', __l('Favor user type'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('last_replied_date', __l('Last Replied Date'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('dispute_converstation_count', __l('Dispute Conversations'), array('class' => 'graydarkerc no-under'));?></th>
    </tr>
    </thead>
<?php
if (!empty($jobOrderDisputes)):

$i = 0;
foreach ($jobOrderDisputes as $jobOrderDispute):
	$class = null;
	if(in_array($jobOrderDispute['JobOrder']['job_order_status_id'], array(ConstJobOrderStatus::Cancelled, ConstJobOrderStatus::Rejected, ConstJobOrderStatus::Expired, ConstJobOrderStatus::CancelledDueToOvertime, ConstJobOrderStatus::CancelledByAdmin, ConstJobOrderStatus::CancelledByAdmin))){
		$class = ' class="errorrow"';
	}elseif ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="dc grayc">
			<div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action');?></span> </span>
	            <ul class="dropdown-menu arrow dl">
					<li><?php echo $this->Html->link(__l('View activities'), array('controller' => 'messages', 'action' => 'activities', 'type' => 'admin_order_view', 'order_id' => $jobOrderDispute['JobOrder']['id']),array('title' => __l('View activities'),'class' =>'edit js-edit', 'escape' => false));?>
					</li>
				</ul>
			</div>
		</td>
		<td class="dc grayc"><?php echo $this->Html->cDateTimeHighlight($jobOrderDispute['JobOrderDispute']['created']);?></td>
		<td class="dl grayc"><?php echo $this->Html->link($this->Html->cText($jobOrderDispute['User']['username']), array('controller'=> 'users', 'action'=>'view', $jobOrderDispute['User']['username'], 'admin' => false), array('class' => 'grayc', 'escape' => false));?></td>
		<td class="dl grayc"><?php echo $this->Html->link($this->Html->cText($jobOrderDispute['Job']['title']), array('controller'=> 'jobs', 'action'=>'view', $jobOrderDispute['Job']['slug'], 'admin' => false), array('class' => 'grayc', 'escape' => false));?></td>
		<td class="dc grayc"><?php echo $this->Html->cInt($jobOrderDispute['JobOrder']['id']);?></td>
		<td class="dl grayc"><?php echo $this->Html->cText($jobOrderDispute['JobOrder']['JobOrderStatus']['name']);?></td>
		<td class="dl grayc"><?php echo $this->Html->cText($jobOrderDispute['JobUserType']['name']);?></td>
		<td class="dl grayc"><?php echo $this->Html->cText($jobOrderDispute['DisputeType']['name']);?></td>
		<td class="dl grayc"><?php echo $this->Html->cText($jobOrderDispute['JobOrderDispute']['reason']);?></td>
		<td class="dl grayc"><?php echo $this->Html->cText($jobOrderDispute['DisputeStatus']['name']);?></td>
		<td class="dc grayc"><?php echo !empty($jobOrderDispute['JobOrderDispute']['resolved_date']) ? $this->Html->cDateTimeHighlight($jobOrderDispute['JobOrderDispute']['resolved_date']) : __l('Not yet');?></td>
		<td class="dl grayc"><?php echo !empty($jobOrderDispute['FavourJobUserType']['name']) ? $this->Html->cText($jobOrderDispute['FavourJobUserType']['name']) : '-';?></td>
		<td class="dc grayc"><?php echo !empty($jobOrderDispute['JobOrderDispute']['last_replied_date']) ? $this->Html->cDateTimeHighlight($jobOrderDispute['JobOrderDispute']['last_replied_date']) : '-';?></td>
		<td class="dc grayc"><?php echo $this->Html->cInt($jobOrderDispute['JobOrderDispute']['dispute_converstation_count']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="14" class="notice"><?php echo sprintf(__l('No %s Order Disputes available'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($jobOrderDisputes)) { ?>
    <div class="pull-right">
	<?php echo $this->element('paging_links'); ?>
	</div>
<?php }
?>
</div>
