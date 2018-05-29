<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php $rids ='';
Configure::write('highperformance.uids', $this->Auth->user('id'));
if (!empty($requests)) {
	foreach ($requests as $request){
		Configure::write('highperformance.rids', Set::merge(Configure::read('highperformance.rids') , $request['Request']['id']));
	}
	$rids = implode(',', Configure::read('highperformance.rids'));
}?>
<div class="needs-block">
<div class="jobs index js-response js-responses js-jobs-scroll-here js-lazyload">
<section class="sep-bot bot-mspace">
	<div class="container ">
		<div class="label label-info show text-18 clearfix no-round ver-mspace">
		<div class="span smspace"><?php echo __l('Buyer Control Panel');?></div>
		<?php echo $this->element('buying-cp-settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
		<h2 class="textb text-32 bot-space mob-dc"><?php echo __l($this->pageTitle);?></h2>
	</div>
</section>

<div class="container top-space clearfix">
	<?php echo $this->Form->create('Request' , array('class' => 'normal form-horizontal ','action' => 'update'));?>
	<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => !empty($this->request->url)?$this->request->url:'')); ?>
	<?php if(!empty($requests)):?>
	<div class="clearfix my-jobs-block top-space">
		<div class="my-jobs-left-block pull-left">
			<?php echo $this->Form->submit(__l('Suspend'),array('div'=>false, 'class' => 'js-admin-action btn btn-warning no-mar', 'name' => 'data[Request][type_suspend]')); ?>
			<?php echo $this->Form->submit(__l('Activate'),array('div'=>false,'class' => 'js-admin-action btn btn-success', 'name' => 'data[Request][type_activate]')); ?>
			<?php echo $this->Form->submit(__l('Delete'),array('div'=>false,'class' => 'js-admin-action btn btn-danger', 'name' => 'data[Request][type_delete]')); ?>
		</div>
		<div class="select-block my-jobs-right-block pull-right top-space">
			<div class="add-block select-block my-jobs-right-block">
				<?php echo $this->Html->link('<i class="icon-plus-sign"></i>'.__l('Add a').' '.__l(requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)), array('controller' => 'requests', 'action' => 'add'), array('escape'=>false, 'class'=>'add no-under','title' => __l('Add a').' '.__l(requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)) )); ?>
			</div>
		</div>
   </div>
	<div class="clearfix">
		<div class="clearfix ver-space">
			<div class="my-jobs-left-block pull-left">
				<div class="inbox-option ">
					<span class="select"><?php echo __l('Select:'); ?></span>
					<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select {"checked":"js-checkbox-list"} hor-space grayc', 'title' => __l('All'))); ?>
					<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select  {"unchecked":"js-checkbox-list"} hor-space grayc', 'title' => __l('None'))); ?>
					<?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'js-select  {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-space grayc', 'title' => __l('Suspended'))); ?>
					<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select  {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-space grayc', 'title' => __l('Active'))); ?>
				</div>
			</div>
			<div class="inbox-option jobs-inbox-option clearfix pull-right span8 dr">
				<?php
				$expanded_class = 'grayc';
				$collapsed_class = '';
				if(!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'expand'):
					$expanded_class = '';
					$collapsed_class = 'grayc';
				endif;
				?>
				<span class="right-space"><?php echo __l('Show').':'; ?></span>
				<?php echo $this->Html->link('<i class="icon-list"></i>'.__l('Expanded'), array('controller'=> 'requests', 'action'=>'index', 'type' => 'manage_requests', 'admin' => false, 'view_type'=> 'expand'), array('title' => __l('Expanded'), 'class' => $expanded_class.' list no-under hor-smspace','escape' => false));?>
				<?php echo $this->Html->link('<i class="icon-table"></i>'.__l('Collapsed'), array('controller'=> 'requests', 'action'=>'index', 'type' => 'manage_requests','admin' => false), array('title' => __l('Collapsed'), 'class' => $collapsed_class.' no-under hor-smspace','escape' => false));?>
			</div>
		</div>
		<div class="clearfix sep-bot bot-space bot-mspace"><?php echo $this->element('paging_counter');?></div>
	</div>
	<?php else: ?>
	<div class="clearfix pull-right">
		<div class="my-jobs-left-block">
			<div class="cancel-block">
				<?php echo $this->Html->link('<i class="icon-plus-sign"></i>'.__l('Add New'), array('controller' => 'requests', 'action' => 'add'), array('escape'=>false, 'class'=>'no-under','title' => __l('Add').' '.requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps))); ?>
			</div>
		</div>
	</div>
	<?php endif;?> 
	
<ol class="list jobs-list1 request-list unstyled" start="<?php echo $this->Paginator->counter(array(
		'format' => '%start%'
	));?>">
<?php
if (!empty($requests)):

$i = 0;
foreach ($requests as $request):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
		if($request['Request']['admin_suspend'] || !$request['Request']['is_active'] || !$request['Request']['is_approved']):
			$status_class = 'js-checkbox-inactive';
			$job_status_class = 'job_inactive';
		elseif(!$request['Request']['admin_suspend'] && $request['Request']['is_active'] && $request['Request']['is_approved']):
			$status_class = 'js-checkbox-active';
			$job_status_class = 'job_active';
		else:
			$status_class = 'js-checkbox-inactive';
			$job_status_class = 'job_inactive';
		endif;
?>
	<li class="clearfix sep-bot ver-space">
		<div class="clearfix manage-request-information-block pull-left">
			<div class="left-mspace">
				<?php if($request['Request']['admin_suspend'] || !$request['Request']['is_approved']):?>
					<span class="<?php echo $request['Request']['admin_suspend']?'job-suspended hor-mspace hor-space':'hor-mspace hor-space';?>">&nbsp;</span>		
				<?php endif;?>
				<?php 			
				if(empty($request['Request']['admin_suspend']) && $request['Request']['is_approved']):			
					echo $this->Form->input('Request.'.$request['Request']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$request['Request']['id'], 'label' => '', 'div'=>false, 'class' => $status_class.' js-checkbox-list')); 			
				endif;
				?>			
			</div>	
			<div class="dropdown inline top-mspace"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-16 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
					<ul class="dropdown-menu arrow dl">

					 <?php if(Configure::read('request.is_admin_request_user__edit_option')==1): ?>

                 	     <li> <?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('controller' => 'requests', 'action'=>'edit', $request['Request']['id']), array('class'=>'edit','title' => __l('Edit'),'escape'=>false));?></li>

                       <?php endif; ?>
					</ul>
				 </div>
		</div>
		<div class="pull-left left-space clearfix">
				<h3 class="text-18 no-mar clearfix">
					<span class="pull-left" title="<?php echo $request['JobType']['name']; ?>">
						<i class="icon-desktop top-space right-mspace <?php echo ($request['JobType']['id'] == ConstJobType::Online)?'greenc':'grayc'; ?>"></i>
					</span>
				
					<?php echo $this->Html->link($this->Html->cText($this->Html->truncate($request['Request']['name'],35)), array('controller' => 'requests', 'action' => 'view', $request['Request']['slug']), array('class' => 'span14 no-mar htruncate graydarkerc','title' => $this->Html->cText($request['Request']['name'], false),'escape' => false));?>
				</h3>
				<div class="clearfix  top-space">
				<span class="pull-left right-space"><?php echo __l('Created ');?> <?php echo ' '.$this->Time->timeAgoInWords($request['Request']['created']); ?></span>
				<span class="clearfix "><?php echo __l('Category: ');?> <?php echo $this->Html->cText($request['JobCategory']['name']); ?></span>
				</div>
				
				

				<div class="clearfix">
					<span class="joborder-status-info <?php echo $job_status_class;?>">	</span>				
					<span class="textb left-smspace">  
					<?php 
							if($request['Request']['admin_suspend']):
								echo __l('Suspended by admin');
							elseif($request['Request']['is_active'] && $request['Request']['is_approved']):
								echo __l('Approved and active');
							elseif(!$request['Request']['is_active'] && !$request['Request']['is_approved']):
								echo __l('Suspended by you');
							elseif(!$request['Request']['is_approved']):
								echo __l('Waiting for admin approval');
							else:
								echo __l('Suspended by you');
							endif;
						?>		
					</span>
					

				</div>
		</div>
		<div class="active-sales-block top-space">
					
			<?php $job_count = !empty($request['Request']['job_count']) ? $request['Request']['job_count'] : '0';
				?>

			<dl class="dc list list-big top-mspace users mob-clr mob-sep-none ">
				<dt class="pr hor-mspace graydarkerc"><?php echo  __l('Total').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps);?></dt>
				<dd title="<?php echo $job_count;?>" class="text-32 graydarkerc pr hor-mspace"><?php echo $job_count;?></dd>
			</dl>

			<?php $view_count = !empty($request['Request']['request_view_count']) ? $request['Request']['request_view_count'] : '0';
			 ?>

			<dl class="dc list list-big top-mspace users mob-clr mob-sep-none ">
				<dt class="pr hor-mspace graydarkerc"><?php echo __l('Total Views');?></dt>
				<dd title="<?php echo $view_count;?>" class="text-32 graydarkerc pr hor-mspace"><?php echo $view_count;?></dd>
			</dl>
		</div>
		<div class="job-price pull-right">
					<p class="amt"><?php echo $this->Html->siteCurrencyFormat($request['Request']['amount']);?></p>
				</div>
		<div class="offset2 top-space pull-left clearfix">
		<?php if(!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'expand'):?>
				<?php echo $this->element('jobs-index-posted_jobs', array('request_id' => $request['Request']['id'], 'cache' => array('time' => Configure::read('site.element_cache_duration')))); ?>
		<?php endif;?>
		</div>
	</li>
						
<?php
    endforeach;
else:
	 ?>
		
		<li>
			<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.__l('available');?></p></div>
		</li>
	<?php
endif;
?>
</ol>
<?php
if (!empty($requests)) { ?>
<div class="clearfix pull-right mob-clr ver-space mob-dc">
<?php echo $this->element('paging_links'); ?>
</div>
<?php } ?>
<?php echo $this->Form->end();?>
</div>	
</div>
</div>