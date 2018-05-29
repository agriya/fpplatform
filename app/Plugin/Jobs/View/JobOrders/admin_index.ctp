<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>

<div class="userViews index js-response panel-admin">
  <?php if (empty($this->request->params['named']['view_type'])) {?>
  <ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo sprintf(__l('%s Orders'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></li>
	</ul>
  <?php } ?>
  <?php if(empty($this->request->params['named']['view_type'])) : ?>
  <section class="space clearfix">
  <div class="pull-left"><?php echo $this->element('paging_counter');?></div>
    <div class="pull-right span users-form tab-clr">
		  	<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('JobOrder', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
			  <?php echo $this->Form->input('filter_id',array('empty' => __l('Please Select'), 'label' => false, 'class' => 'span3')); ?>
			  <?php echo $this->Form->autocomplete('User.username', array('label' => false, 'placeholder' => 'User', 'div' => false, 'acFieldKey' => 'JobOrder.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));	?>

			  <?php echo $this->Form->autocomplete('Job.title', array('label' => false, 'placeholder' => jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), 'div' => false, 'acFieldKey' => 'JobOrder.job_id', 'acFields' => array('Job.title'), 'acSearchFieldNames' => array('Job.title'), 'maxlength' => '255')); ?>
			  <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
				<div class="submit left-space">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
		  </div>
  </section>
  <?php endif; ?>
  <?php echo $this->Form->create('JobOrder' , array('class' => 'clearfix js-shift-click js-no-pjax','action' => 'update')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <section class="space">
  <table class="table no-mar table-striped table-hover">
    <thead>
    <tr>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
      <th class="select dc"><?php echo __l('Select'); ?></th>
      <?php endif; ?>
      <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
        <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('id', __l('Order #'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Created'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('User'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('Job.title', __l('Title'), array('class' => 'graydarkerc no-under')); ?></div></th>
		<th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('JobOrderStatus.name', __l('Status'), array('class' => 'graydarkerc no-under')); ?></div></th>
		<th class="dr sep-right textn"><?php echo __l('Amount'); ?><?php echo ' ('.Configure::read('site.currency').')';?></th>
		<th class="dr sep-right textn alert-success graydarkerc"><?php echo __l('Commission Amount'); ?><?php echo ' ('.Configure::read('site.currency').')';?></th>
		<th class="dr sep-right textn"><?php echo __l('Paid Amount'); ?><?php echo ' ('.Configure::read('site.currency').')';?></th>
	</tr>
    </thead>
    <tbody>
    <?php
if (!empty($jobOrders)):
foreach ($jobOrders as $jobOrder):
	$hide_commission_paid = 0;
	$hid_cancel_order = 0;
	$status_class = '';
	if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforAcceptance) {
		$status_class = 'js-checkbox-waitingforacceptance'; }
	else if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgress) {
		$status_class = 'js-checkbox-inprogress'; }
	else if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforReview) {
		$status_class = 'js-checkbox-waitingforreview'; }
	else if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Completed) {
		$status_class = 'js-checkbox-completed';  }
	else if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Rejected) {
		$status_class = 'js-checkbox-rejected'; }
	else if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Cancelled) {
		$status_class = 'js-checkbox-cancelled'; }
	else if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::PaymentCleared) {
		$status_class = 'js-checkbox-paymentcleared'; }
	else if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Expired) {
		$status_class = 'js-checkbox-expired'; }
	else if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::InProgressOvertime) {
		$status_class = 'js-checkbox-inprogressovertime'; }
	else if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::CancelledDueToOvertime) {
		$status_class = 'js-checkbox-cancelledduetoovertime'; }
	else if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::CancelledByAdmin) {
		$status_class = 'js-checkbox-cancellebyadmin'; }
	else if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::CompletedAndClosedByAdmin) {
		$status_class = 'js-checkbox-completedandclosedbyadmin'; }
	$status_class .= ' js-admin-checkbox';

	if($jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Rejected || $jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Cancelled || $jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::Expired || $jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::CancelledDueToOvertime  || $jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::CancelledByAdmin || $jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::CompletedAndClosedByAdmin || $jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::MutualCancelled || 
	$jobOrder['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::PaymentPending){
		$hide_commission_paid = 1;
		$hid_cancel_order = 1;
	}
?>
    <tr>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
     <td class="dc grayc"><?php echo $this->Form->input('JobOrder.'.$jobOrder['JobOrder']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$jobOrder['JobOrder']['id'], 'div' => false, 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?></td>
      <?php endif; ?>
      <td class="dc grayc">
			 <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
			<ul class="dropdown-menu arrow dl">
			<?php if(empty($hid_cancel_order) && $jobOrder['JobOrder']['job_order_status_id'] != ConstJobOrderStatus::PaymentCleared):?>
				<li><?php echo $this->Html->link('<i class="icon-remove-sign"></i>' . __l('Cancel and refund'), array('controller' => array('job_orders'), 'action' => 'delete', $jobOrder['JobOrder']['id']), array('class' => 'js-no-pjax js-confirm', 'title' => __l('Cancel and refund'), 'escape' => false));?></li>
			<?php endif;?>
			<li>
			<?php echo $this->Html->link('<i class="icon-link"></i>' . __l('View activities'), array('controller' => 'messages', 'action' => 'activities', 'type' => 'admin_order_view','order_id' => $jobOrder['JobOrder']['id']), array('escape' => false));?>
			</li>
			</ul>
			</div>
		</td>
		<td class="dc grayc"><?php echo $this->Html->cInt($jobOrder['JobOrder']['id']);?></td>
		<td class="dc grayc"><?php echo $this->Html->cDateTimeHighlight($jobOrder['JobOrder']['created']);?></td>
		<td class="dl grayc"><?php echo $this->Html->link($this->Html->cText($jobOrder['User']['username']), array('controller'=> 'users', 'action' => 'view', $jobOrder['User']['username'], 'admin' => false), array('escape' => false, 'class' => 'grayc'));?></td>
		<td class="dl grayc"><?php echo $this->Html->link($this->Html->cText($jobOrder['Job']['title']), array('controller'=> 'jobs', 'action' => 'view', $jobOrder['Job']['slug'], 'admin' => false), array('escape' => false, 'class' => 'grayc'));?></td>
		<td class="dl grayc">
			<?php
			    echo $jobOrder['JobOrderStatus']['name'];				
			?>
		</td>
		<td class="dr grayc"><?php echo $this->Html->cCurrency($jobOrder['JobOrder']['amount']);?></td>
		<td class="dr grayc alert-success">
			<?php //if(empty($hide_commission_paid)):?>
				<?php echo $this->Html->cCurrency($jobOrder['JobOrder']['commission_amount']);?>
			<?php //else:?>
				<?php //echo '-';?>
			<?php //endif;?>
		</td>
		<td class="dr grayc">
			<?php if(empty($$hid_cancel_order)):?>
				<?php echo $this->Html->cCurrency($jobOrder['JobOrder']['amount'] - $jobOrder['JobOrder']['commission_amount']);?>
			<?php else:?>
				<?php echo '-';?>
			<?php endif;?>
		</td>
 </tr>
<?php
    endforeach;
?>
	<?php if(!empty($totalAmount)):?>
    <?php if(empty($this->request->params['named']['view_type'])) { 
        $colspan = 'colspan ="7"';
    } else {
        $colspan = 'colspan ="6"';
    }
    ?>
	<tr>
		<td <?php echo $colspan;?>><?php echo __l('Total');?></td>
		<td class="dr grayc"><?php echo $this->Html->cCurrency($totalAmount['total_amount']);?></td>
		<td class="dr grayc alert-success">
			<?php //if(empty($hide_commission_paid)):?>
				<?php echo $this->Html->cCurrency($totalAmount['commission_amount']);?>
			<?php //else:?>
				<?php //echo '-';?>
			<?php //endif;?>
		</td>
		<td class="dr grayc">
			<?php if(empty($$hid_cancel_order)):?>
				<?php echo $this->Html->cCurrency($totalAmount['paid_amount']);?>
			<?php else:?>
				<?php echo '-';?>
			<?php endif;?>
		</td>
	</tr>
	<?php endif;?>
<?php
else:
?>
	<tr>
		<td colspan='11' class="notice"><?php echo __l('No Orders available');?></td>
	</tr>
<?php
endif;
?>
</tbody>
    </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
  <?php
  if (!empty($jobOrders)) :
    ?>
  <?php if(empty($this->request->params['named']['view_type'])) : ?>
  <div class="ver-space pull-left"> 
    <?php echo __l('Select:'); ?>
    <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
    <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
 </div>
  <div class="admin-checkbox-button pull-left hor-space">
    <div class="input select"> <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?> </div>
  </div>
  <?php endif; ?>
  <div class="hide"> <?php echo $this->Form->submit('Submit');  ?> </div>
  <div class="pull-right"><?php echo $this->element('paging_links'); ?></div>
  </section>
  <?php
endif;
echo $this->Form->end();
?>
</div>
