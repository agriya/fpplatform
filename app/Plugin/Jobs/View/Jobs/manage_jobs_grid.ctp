<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php 
	$is_job_share_enabled = Configure::read('job.is_job_share_enabled');
	if(!empty($is_job_share_enabled)):
?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<?php endif;?>
<div class="jobs index js-response js-responses js-lazyload">
<?php 
	$user_job_count = $this->Html->userJobCount($this->Auth->user('id'));										
	if(!empty($user_job_count)):
	?>
	<section class="sep-bot bot-mspace">
	<div class="container ">
		<div class="label label-info show text-18 clearfix no-round ver-mspace">
		<div class="span smspace"><?php echo __l('Seller Control Panel');?></div>
		<?php echo $this->element('selling-cp-settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
		<h2 class="textb text-32 bot-space mob-dc"><?php echo __l('My').' '.jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps);?></h2>
	</div>
	</section>
	<div class="container top-space clearfix">
	<div>
	<?php echo $this->Form->create('Job' , array('class' => 'form-horizontal','action' => 'update'));?>
	<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
	<?php if(!empty($jobs)):?>
				<div class="clearfix my-jobs-block top-space">
					<div class="my-jobs-left-block pull-left">

						<?php echo $this->Form->submit(__l('Suspend'),array('div'=>false, 'class' => 'js-admin-action btn btn-warning no-mar', 'name' => 'data[Job][type_suspend]')); ?>
						<?php echo $this->Form->submit(__l('Activate'),array('div'=>false,'class' => 'js-admin-action btn btn-success', 'name' => 'data[Job][type_activate]')); ?>
						<?php echo $this->Form->submit(__l('Delete'),array('div'=>false,'class' => 'js-admin-action btn btn-danger', 'name' => 'data[Job][type_delete]')); ?>
					</div>
					<div class="select-block my-jobs-right-block pull-right top-space">
						<div class="add-block select-block my-jobs-right-block">
							<?php echo $this->Html->link('<i class="icon-plus-sign"></i>'.__l('Add a').' '.__l(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('controller' => 'jobs', 'action' => 'add'), array('escape'=>false, 'class'=>'add no-under','title' => __l('Add a').' '.__l(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)) )); ?>
						</div>
					</div>  
				</div>
				<div class="clearfix ver-space">
					<div class="my-jobs-left-block pull-left">
						<div class="inbox-option ">
							<span class="select"><?php echo __l('Select:'); ?></span>
							<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select {"checked":"js-checkbox-list"} hor-space grayc', 'title' => __l('All'))); ?>
							<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select  {"unchecked":"js-checkbox-list"}  hor-space grayc', 'title' => __l('None'))); ?>
							<?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'js-select  {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"}  hor-space grayc', 'title' => __l('Suspended'))); ?>
							<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select  {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"}  hor-space grayc', 'title' => __l('Active'))); ?>
						</div>
					</div>
					<div class="inbox-option jobs-inbox-option clearfix pull-right span5 dr">
						<span class="right-space"><?php echo __l('Show').':'; ?></span>
						<?php echo $this->Html->link('<i class="icon-list"></i>'.__l('List'), array('controller'=> 'jobs', 'action'=>'index', 'type' => 'manage_jobs', 'admin' => false), array('title' => __l('List'), 'class' => 'list status_selected grayc no-under hor-smspace','escape' => false));?>
						<?php echo $this->Html->link('<i class="icon-table"></i>'.__l('Grid'), array('controller'=> 'jobs', 'action'=>'index', 'type' => 'manage_jobs', 'view'=> 'grid','admin' => false), array('title' => __l('Grid'), 'class' => 'grid myjob-active no-under hor-smspace','escape' => false));?>
					</div>
				</div>
				<div class="clearfix sep-bot bot-space bot-mspace"><?php echo $this->element('paging_counter');?></div>
			<?php else: ?>
				<div class="clearfix pull-right">
					<div class="my-jobs-left-block top-space">
						<div class="cancel-block">
							<?php echo $this->Html->link('<i class="icon-plus-sign"></i>'.__l('Add New'), array('controller' => 'jobs', 'action' => 'add'), array('escape'=>false, 'class'=>'no-under', 'title' => __l('Add jobs'))); ?>
						</div>
					</div>
				</div>
			<?php endif;?>
	<div class="clearfix overflow-block top-space top-mspace">
<table class="table table-striped table-hover sep jobs-list1">
    <tr>
	    <th class="span sep-right"><?php echo __l('Select');?></th>
        <th class="actions span sep-right"> <?php echo __l('Action');?></th>        
        <th class=" span10 sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('title',__l('Title'),array('class'=>'blackc'));?></div></th>
        <th class="sep-right"><?php echo __l('Status');?></th>
        <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('JobCategory.name',__l('Category'),array('class'=>'blackc'));?></div></th>
        <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('amount',__l('Amount') . ' (' . $this->Html->cText(Configure::read('site.currency'), false) . ')',array('class'=>'blackc'));?></div></th>
        <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('job_view_count',__l('Views'),array('class'=>'blackc'));?></div></th>
        <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('active_sales',__l('Active Sales'),array('class'=>'blackc'));?></div></th>
        <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('complete_sales',__l('Complete Sales'),array('class'=>'blackc'));?></div></th>
        <th><div class="js-pagination"><?php echo $this->Paginator->sort('revenue',__l('Revenue') . ' (' . Configure::read('site.currency') . ')',array('class'=>'blackc'));?></div></th>
    </tr>


	
<?php
if (!empty($jobs)):
$i = 0;
foreach ($jobs as $job):
	$class = null;
	if ($i++ % 2 == 0):
		$class = ' class="altrow"';
	endif;
	if($job['Job']['admin_suspend'] || !$job['Job']['is_active'] || !$job['Job']['is_approved']):
		$status_class = 'js-checkbox-inactive';
		$job_status_class = 'job_inactive';
	elseif(!$job['Job']['admin_suspend'] && $job['Job']['is_active'] && $job['Job']['is_approved']):
		$status_class = 'js-checkbox-active';
		$job_status_class = 'job_active';
	else:
		$status_class = 'js-checkbox-inactive';
		$job_status_class = 'job_inactive';
	endif;	
	
	
?>
	<tr<?php echo $class;?>>
	    <td class="dc"><?php echo $this->Form->input('Job.'.$job['Job']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$job['Job']['id'], 'label' => '','div'=>false,  'class' => $status_class.' js-checkbox-list')); ?></td>
		<td> 
			<?php if(!$job['Job']['admin_suspend']):?>
			<div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
					<ul class="dropdown-menu arrow dl">
						<li><?php echo $this->Html->link('<i class="icon-edit text-16"></i>'.__l('Edit'), array('controller'=>'jobs', 'action'=>'edit', $job['Job']['id']), array('escape'=>false,'title' => __l('Edit')));?></li>
					</ul>
				 </div>

			
		<?php endif;?>
        </td>
		<td class="span5">        
		<?php $attachment = '';?>
		<div class="clearfix">
					<span class="pull-left top-smspace" title="<?php echo $job['JobType']['name']; ?>">
						<i class="icon-desktop top-space right-mspace <?php echo ($job['JobType']['id'] == ConstJobType::Online)?'greenc':'grayc'; ?>"></i>
					</span>
					<div class="pull-left right-space">
				<?php $attachment = '';?>
				<?php if(!empty($job['Attachment']['0'])){?>
					<?php echo $this->Html->link($this->Html->showImage('Job', $job['Attachment']['0'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)),'class'=>'',  'title' => $this->Html->cText($job['Job']['title'], false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('escape' => false));?>
				<?php }else{ ?>
						<?php echo $this->Html->link($this->Html->showImage('Job', $attachment, array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)),'class'=>'',  'title' => $this->Html->cText($job['Job']['title'], false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('escape' => false));?>
				<?php } ?>
				</div>
					<div class="left-smspace span4  clearfix textb">
					<?php 
						echo $this->Html->link($this->Html->cText($job['Job']['title'],false), array('controller'=> 'jobs', 'action'=>'view', $job['Job']['slug'] , 	'admin' => false), array('class'=>'clearfix span3 no-mar htruncate graydarkerc js-bootstrap-tooltip','title'=>$this->Html->cText($job['Job']['title'],false),'escape' => false));?>
						<div class="clearfix">
						<?php if(!empty ($job['JobServiceLocation']['name']) && $job['Job']['job_type_id'] != ConstJobType::Online): ?>
							<span class="job-service-location-<?php echo $job['Job']['job_service_location_id']; ?>">
							<?php if($job['Job']['job_service_location_id'] == ConstServiceLocation::BuyerToSeller) { ?>
							<span class="label label-success hor-space"><?php echo $job['JobServiceLocation']['name']; ?> </span>
							<?php } else{ ?>
							<span class="label label-important  hor-space"><?php echo $job['JobServiceLocation']['name']; ?> </span>
							<?php } ?>
							</span>
						 <?php  endif; ?>
					</div>
					
				 </div>

                </div>
            </td>
        <td> 		
        
        	<?php 
							if($job['Job']['admin_suspend']):
								echo __l('Suspended by admin');
							elseif($job['Job']['is_active'] && $job['Job']['is_approved']):
								echo __l('Approved and active');
							elseif(!$job['Job']['is_active'] && !$job['Job']['is_approved']):
								echo __l('Suspended by you');
							elseif(!$job['Job']['is_approved']):
								echo __l('Waiting for admin approval');
							else:
								echo __l('Suspended by you');
							endif;
						?>        	
        </td>                
        <td><?php echo $this->Html->cText($job['JobCategory']['name']); ?></td>
		<td><?php echo $this->Html->cCurrency($job['Job']['amount']);?></td>
		<td><?php echo $this->Html->cInt($job['Job']['job_view_count']);?></td>
		<td>
		<?php echo $this->Html->link($this->Html->cInt($job['Job']['active_sale_count'], false), array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'active', 'slug' => $job['Job']['slug'],'admin' => false), array('title' => __l('Active Sales'))); ?>		
		<td>
		<?php echo $this->Html->link($this->Html->cInt($job['Job']['complete_sale_count'], false), array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'completed', 'slug' => $job['Job']['slug'],'admin' => false), array('title' => __l('Completed Sales'))); ?>
		</td>
        <td><?php echo $this->Html->cFloat($job['Job']['revenue']);?></td>
          
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="22">
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16">
		<?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.__l('available');?>
  		 </div>
		</td>
	</tr>
<?php
endif;
?>
</table>    </div>
	
<div class="<?php if(!empty($this->request->params['isAjax'])) { ?> js-pagination <?php } ?>js-scrollto pull-right bot-mspace">
	<?php
	if (!empty($jobs)) {
		echo $this->element('paging_links');
	}

	?>
	</div>
	<?php echo $this->Form->end();?>
	</div>
	<?php else:?>
	<div>
	
		
			  
				<h3 class="manage-jobs-title"><?php echo __l('Hey newbie! Time to create your first').' '.jobAlternateName(ConstJobAlternateName::Singular).'! ';?><span><?php echo __l('It is so darn easy!');?></span></h3>
		
			 <ul class="jobs-list-info clearfix">
				<li class="step1"><p><?php echo __l('Come up with cool ideas for things you are willing to do for').' ';?><?php echo $this->Html->siteJobAmount('or');?></p></li>
				<li class="step2"><p><?php echo __l('Create a').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('for your idea(s)');?></p></li>
				<li class="step3"><p><?php echo __l('Promote your new').' '.jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps).' '.__l('in your social networks');?></p></li>
				<li class="step4"><p><?php echo __l('Make lots of').' ';?><?php echo Configure::read('site.name');?>!!!</p></li>
			  </ul>
			  <div class="clearfix">
				<div class="shopping-list clearfix">
					<div class="cancel-block clearfix">
						<?php echo $this->Html->link(__l('Create First').' '.jobAlternateName(ConstJobAlternateName::Singular), array('controller' => 'jobs', 'action' => 'add'), array('title' => __l('Create First').' '.jobAlternateName(ConstJobAlternateName::Singular))); ?>
					</div>
				</div>
		</div>
		<?php if(isPluginEnabled('Requests')) { ?>
		<div class="need-info-block">
			<h3 class="need-idea"><?php echo __l('Need Ideas?');?></h3>
			<p class="requests-info"><?php echo __l('Here are some wishes and requests made by our buyers:');?></p>
			<div class="requests-index-block">
				<?php
					echo $this->element('Requests.requests-index', array('cache' => array('time' => Configure::read('site.element_cache_duration'))));
				?>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php endif;?>
	</div>
	<?php 
		if(!empty($is_job_share_enabled)):
	?>
	<div id="fb-root"></div>
	<script type="text/javascript">
	  window.fbAsyncInit = function() {
		FB.init({appId: '<?php echo Configure::read('facebook.app_id');?>', status: true, cookie: true,
				 xfbml: true});
	  };
	  (function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol +
		  '//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
	  }());
	</script>
	<?php endif;?>
</div>