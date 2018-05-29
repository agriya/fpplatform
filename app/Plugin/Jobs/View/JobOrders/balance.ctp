<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="jobOrders index">

 <section class="sep-bot bot-mspace">
  <div class="container ">
  <div class="label label-info show text-18 clearfix no-round ver-mspace">
	
	<?php if($this->request->params['named']['type'] == 'gain'): ?>
	<div class="span smspace"><?php echo __l('Seller Control Panel');?></div>
	<?php echo $this->element('selling-cp-settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
	<?php elseif($this->request->params['named']['type'] == 'history'): ?>
	<div class="span smspace"><?php echo __l('Buyer Control Panel');?></div>
	<?php echo $this->element('buying-cp-settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
	<?php endif; ?>  
  </div>
   <h2 class="textb text-32 bot-space mob-dc"><?php if($this->request->params['named']['type'] == 'gain'): ?>
		<?php echo __l('My Revenues');?>
	<?php elseif($this->request->params['named']['type'] == 'history'): ?>
		<?php echo __l('Order History');?>
	<?php endif; ?></h2>
		
  </div>
</section>
<div class="container top-space clearfix">
<div class="clearfix bot-space ">
	<div class="grayc">
	<?php echo $this->element('paging_counter');?>
	</div>
</div>
<div class="top-mspace">
		<div class="pull-left bot-mspace">
			<span class="select"><?php echo __l('Select:'); ?></span>
			<?php if($this->request->params['named']['type'] == 'gain'): ?>
				<?php 
					foreach($moreActions as $key => $value){
					$stat_class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == $value)) ? 'status_selected' : null; 
						$links[] =  $this->Html->link(__l($key), array('controller' => 'job_orders', 'action' => 'index','type'=>'gain','status' => $value,'admin' => false), array('class' => $stat_class.' left-space' , 'title' => __l($key)));			
					}
					echo implode(', ',$links);
				?>
			<?php else: ?>
				<?php 
					foreach($moreActions as $key => $value){
						$stat_class = (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == $value)) ? 'status_selected' : null; 
						$links[] =  $this->Html->link(__l($key), array('controller' => 'job_orders', 'action' => 'index','type'=>'history','status' => $value,'admin' => false), array('class' => $stat_class .'  left-space', 'title' => __l($key)));			
					}
					echo implode(', ',$links);
				?>
			<?php endif;?>
		</div>
	</div>
<table class="table table-striped table-hover sep">
	<tr>
		<th><?php echo __l('Date'); ?></th>
		<th class="dc"><?php echo jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps); ?></th>
		<th><?php echo __l('Order'); ?></th>
		<th>
		<?php 
			if(!empty($this->request->params['named']['type'])):
				if($this->request->params['named']['type'] == 'gain'):  
					echo __l('Buyer'); 
				endif;
			endif;
		?>
		</th>
		<th><?php echo __l('Status'); ?></th>
		<th class="dr"><?php echo __l('Gross'); ?></th>
	</tr>
<?php
if (!empty($jobOrders)):

$i = 0;
foreach ($jobOrders as $jobOrder):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	if($jobOrder['JobOrderStatus']['id'] != ConstJobOrderStatus::PaymentPending):
?>
	<tr <?php echo $class;?>>
		<td><?php echo $this->Html->cDateTimeHighlight($jobOrder['JobOrder']['created']);?></td>
		<td class="job"><?php echo $this->Html->link($this->Html->cText($jobOrder['Job']['title']), array('controller'=> 'jobs', 'action' => 'view', $jobOrder['Job']['slug']), array('title' => $this->Html->cText($jobOrder['Job']['title'], false), 'escape' => false,'class'=>'span10 htruncate js-bootstrap-tooltip'));?></td>
		<td><?php echo $this->Html->link('#'.$this->Html->cInt($jobOrder['JobOrder']['id'],false), array('controller'=> 'messages', 'action' => 'activities', 'type' => 'myorders', 'order_id' => $jobOrder['JobOrder']['id']), array('title' => __l('view activities'), 'escape' => false));?></td>
		<td class="job">
		<?php 
			if(!empty($this->request->params['named']['type'])):
				if($this->request->params['named']['type'] == 'gain'):  
					echo $this->Html->link($this->Html->cText($jobOrder['User']['username']), array('controller'=> 'users', 'action' => 'view', $jobOrder['User']['username']), array('title' => $this->Html->cText($jobOrder['User']['username'], false), 'escape' => false,'class'=>'span2 htruncate js-bootstrap-tooltip')); 
				endif;
			endif;
		?>
		</td>
		<?php $balance_status_class = ($jobOrder['JobOrderStatus']['slug']) ? 'status_'.$jobOrder['JobOrderStatus']['slug'] : '';?>
		<td class="status">
			<span class="<?php echo $balance_status_class;?> <?php echo $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Rejected?'redc':'greenc';?>">
				<?php
					if(!empty($this->request->params['named']['type'])):
						if($this->request->params['named']['type'] == 'gain'):
							if($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforAcceptance):				
								echo __l('Pending');
							elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforReview): 
								echo __l('Paid');
							elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgress || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgressOvertime || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Redeliver): 
								echo __l('Order in progress');
							elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Completed || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CompletedAndClosedByAdmin): 
								if(!empty($jobOrder['0']) && $jobOrder['0']['days'] < Configure::read('job.days_after_amount_withdraw')):
									if((Configure::read('job.days_after_amount_withdraw') - $jobOrder['0']['days']) == 1):
										echo __l('Payment due in '.(Configure::read('job.days_after_amount_withdraw') - $jobOrder['0']['days']).' day');
									else:
										echo __l('Payment due in '.(Configure::read('job.days_after_amount_withdraw') - $jobOrder['0']['days']).' days');
									endif;
								else:
									echo __l('Completed');								
								endif;
							elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::PaymentCleared): 
								echo __l('Cleared');
							elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Cancelled || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Rejected || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CancelledDueToOvertime|| $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CancelledByAdmin  || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Expired || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::MutualCancelled): 
								echo __l('Reversed');
							endif;
						elseif($this->request->params['named']['type'] == 'history'):   
							if($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforAcceptance):				
								echo __l('Pending');
							elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgress || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::InProgressOvertime || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::WaitingforReview || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Completed || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::PaymentCleared || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CompletedAndClosedByAdmin || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Redeliver): 
								echo __l('Transferred');
							elseif($jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Cancelled || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Rejected || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CancelledDueToOvertime || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::Expired || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::CancelledByAdmin || $jobOrder['JobOrderStatus']['id'] == ConstJobOrderStatus::MutualCancelled): 
								echo __l('Reversed');
							endif;
						endif; 
					endif; //commission_amount
				?>
			</span>
		</td>
		<td class="dr">
			<?php 
			if(!empty($this->request->params['named']['type'])):
				if($this->request->params['named']['type'] == 'gain'):  	
					echo $this->Html->siteCurrencyFormat($jobOrder['JobOrder']['amount'] - $jobOrder['JobOrder']['commission_amount']);
				elseif($this->request->params['named']['type'] == 'history'):   
					echo $this->Html->siteCurrencyFormat($jobOrder['JobOrder']['amount']);
				endif;
			endif;
			?>
		</td>
	</tr>
<?php
	endif;
    endforeach;
	if($this->request->params['named']['type'] == 'gain'):   
?>

<tr>
	<td colspan='4' class="amount-info">				
	</td>
	<td>
	<p class="clearfix">
    <span class="label label-success"> <?php echo __l('Cleared Amount: '); ?></span>    
	</p>    
    </td>
    <td class="dr"> 
        <span class="amt">  <?php  echo (!empty($balance_amount['cleared_amount']) ? $this->Html->siteCurrencyFormat($balance_amount['cleared_amount']) : $this->Html->siteCurrencyFormat('0'));?>
        </span>
    </td>
</tr>
<tr class="altrow">
	<td colspan='4' class="amount-info">				
	</td>
	<td>	
    <p class="clearfix">
    <span class="label label-warning"><?php echo __l('Pending funds: '); ?></span>   
    </p>
    </td>
    <td class="dr"> 
         <span class="amt">  <?php  echo (!empty($balance_amount['total_amount']) ? $this->Html->siteCurrencyFormat($balance_amount['total_amount']) : $this->Html->siteCurrencyFormat('0'));?>
    </span>
    </td>
</tr>
<tr>
	<td colspan ='6'>
		<div class="alert alert-info">
			<?php echo __l('Above sums is deducted from Service and transaction fees.').'<br/>'.__l('Cleared funds represent the gross amount of money earned by your').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('sales and that is available to you after credit card refund period had passed.');?>
		</div>
		<div class="alert alert-info">
			<?php echo __l('Funds are cleared and added to your account after a safety clearing period of').' '.Configure::read('job.days_after_amount_withdraw').' '.__l('days (from the day you receive them in your balance).');?>
		</div>
	</td>
</tr>
<?php
endif;
else:
?>
	<tr>
		<td colspan="6" class="warning">
		<div class="thumbnail space dc grayc">
	        <p class="ver-mspace top-space text-16"><?php echo __l('No transactions to show');?></p>
        </div>
		</td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($jobOrders)) { ?>
<div class="clearfix pull-right mob-clr ver-space mob-dc">
<?php echo $this->element('paging_links'); ?>
</div>
<?php } ?>
</div>
</div>