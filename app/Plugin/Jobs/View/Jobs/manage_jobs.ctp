<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php 
	$user_job_count = $this->Html->userJobCount($this->Auth->user('id'));		
	$is_job_share_enabled = Configure::read('job.is_job_share_enabled');
	if(!empty($is_job_share_enabled)):
?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<?php endif;?>
<div class="jobs index <?php if($user_job_count) { echo 'js-response js-responses'; } ?> js-lazyload">
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
<?php 								
	if(!empty($user_job_count)):
	?>
	<div>
		<?php echo $this->Form->create('Job' , array('class' => 'normal form-horizontal ','action' => 'update'));?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));?>
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
							<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select  {"unchecked":"js-checkbox-list"} hor-space grayc', 'title' => __l('None'))); ?>
							<?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'js-select  {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-space grayc', 'title' => __l('Suspended'))); ?>
							<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select  {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-space grayc', 'title' => __l('Active'))); ?>
						</div>
					</div>
					<div class="inbox-option jobs-inbox-option clearfix pull-right span5 dr">
						<span class="right-space"><?php echo __l('Show').':'; ?></span>
						<?php echo $this->Html->link('<i class="icon-list"></i>'.__l('List'), array('controller'=> 'jobs', 'action'=>'index', 'type' => 'manage_jobs', 'admin' => false), array('title' => __l('List'), 'class' => 'list status_selected myjob-active no-under hor-smspace','escape' => false));?>
						<?php echo $this->Html->link('<i class="icon-table"></i>'.__l('Grid'), array('controller'=> 'jobs', 'action'=>'index', 'type' => 'manage_jobs', 'view'=> 'grid','admin' => false), array('title' => __l('Grid'), 'class' => 'grid grayc no-under hor-smspace','escape' => false));?>
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

			<ol class="list jobs-list1 unstyled" start="<?php echo $this->Paginator->counter(array(
		'format' => '%start%'
	));?>">
	<?php
	if (!empty($jobs)):

	$i = 0;
	foreach ($jobs as $job):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow clearfix"';
		}
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
		<li class="clearfix sep-bot ver-space">
			<div class="hor-space pull-left">
				<div class="clearfix dc hor-space">
				<?php if($job['Job']['admin_suspend']):?>
				<span class="<?php echo $job['Job']['admin_suspend']?'job-suspended':'';?>">&nbsp;</span>		
				<?php endif;?>
				<?php 			
				if(empty($job['Job']['admin_suspend'])):			
				echo $this->Form->input('Job.'.$job['Job']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$job['Job']['id'], 'label' => '', 'div'=>false, 'class' => $status_class.' js-checkbox-list')); 			
				endif;
				?>
				</div>
				<div class="dropdown inline top-mspace"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-16 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
					<ul class="dropdown-menu arrow dl">

					<?php if(isPluginEnabled('SocialMarketing')) { ?>
					<li>
						<?php echo $this->Html->link('<i class="icon-share-alt"></i>'.__l('Share'), array('controller'=>'social_marketings','action'=>'publish', $job['Job']['id'],'type'=>'facebook', 'publish_action' => 'add', 'publish_name' => 'Job'), array( 'title' => __l('Share'),'escape'=>false)); ?>

					</li>
					<?php }?>
		
					<?php if(!$job['Job']['admin_suspend']):?>

					<li>	<?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('controller'=>'jobs', 'action'=>'edit', $job['Job']['id']), array('title' => __l('Edit'),'escape'=>false));?></li>
		
					<?php endif;?>
					</ul>
				 </div>
			</div>
			<div class="span pull-left">     
                
				<?php $attachment = '';?>
				<?php if(!empty($job['Attachment']['0'])){?>
					<p class="pr">
                    <?php echo $this->Html->link($this->Html->showImage('Job', $job['Attachment']['0'], array('dimension' => 'large_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)),'class'=>'sep sep-big sep-black',  'title' => $this->Html->cText($job['Job']['title'], false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('escape' => false));?></p>
				<?php }else{ ?>
						<p><?php echo $this->Html->link($this->Html->showImage('Job', $attachment, array('dimension' => 'large_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)),'class'=>'sep sep-big sep-black',  'title' => $this->Html->cText($job['Job']['title'], false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('escape' => false));?></p>
				<?php } ?>				
			</div>

			<div class="pull-left left-space clearfix">                
				<h3 class="text-18 no-mar clearfix">
					<span class="pull-left top-smspace" title="<?php echo $job['JobType']['name']; ?>">
						<i class="icon-desktop top-space right-mspace <?php echo ($job['JobType']['id'] == ConstJobType::Online)?'greenc':'grayc'; ?>"></i>
					</span>
					<?php echo $this->Html->link($this->Html->cText($this->Html->truncate($job['Job']['title'], 54)), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']), array('class' => 'span14 no-mar htruncate graydarkerc','title' => $this->Html->cText($job['Job']['title'], false),'escape' => false));?>
				</h3>
				<div class="clearfix textb top-space"><?php echo __l('Category:');?> <?php echo $this->Html->link(__l($job['JobCategory']['name']), array('controller'=>'jobs','action'=>'index','category' => $job['JobCategory']['slug']), array('title' => __l($this->Html->cText($job['JobCategory']['name'],false))));?> 
				
				<?php if(!empty ($job['JobServiceLocation']['name']) && $job['Job']['job_type_id'] != ConstJobType::Online): ?>
					<?php if($job['Job']['job_service_location_id'] == ConstServiceLocation::BuyerToSeller) { ?>
					<span class="label label-success"><?php echo $job['JobServiceLocation']['name']; ?> </span>
					<?php } else{ ?>
					<span class="label label-important"><?php echo $job['JobServiceLocation']['name']; ?> </span>
					<?php } ?>
				<?php  endif; ?>
				</div>
				<div class="top-space clearfix"><p class="span12 htruncate"><?php echo $this->Html->cText($job['Job']['description']);?></p></div>
				<div class="clearfix">
					<span class="joborder-status-info <?php echo $job_status_class;?>">	</span>				
					<span class="textb left-smspace">  
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
					</span>
					

				</div>

				<div class="active-sales-block top-space">
					
					<?php $active_sales=($job['Job']['active_sale_count']) ? ' '.$job['Job']['active_sale_count'] : ' 0';?>
					<?php echo $this->Html->link(' <dl class="dc list list-big top-mspace users mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Active Sales').'</dt><dd title="'.$active_sales.'" class="text-32 graydarkerc pr hor-mspace">'.$active_sales.'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'active', 'slug' => $job['Job']['slug'],'admin' => false), array('escape' => false, 'title' => __l('Active Sales'))); ?>

					<?php $completed_sales=($job['Job']['complete_sale_count']) ? ' '.$job['Job']['complete_sale_count'] : ' 0';?>
					<?php echo $this->Html->link(' <dl class="dc list list-big top-mspace users mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">'.__l('Completed Sales').'</dt><dd title="'.$completed_sales.'" class="text-32 graydarkerc pr hor-mspace">'.$completed_sales.'</dd></dl>', array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'completed', 'slug' => $job['Job']['slug'],'admin' => false), array('escape' => false, 'title' => __l('Completed Sales'))); ?>

					<?php $viewed_count=($job['Job']['job_view_count']) ? $job['Job']['job_view_count'] : '0';?>

					<dl class="dc list list-big top-mspace users mob-clr mob-sep-none ">
						<dt class="pr hor-mspace graydarkerc"><?php echo __l('Viewed');?></dt>
						<dd title="<?php echo $viewed_count;?>" class="text-32 graydarkerc pr hor-mspace"><?php echo $viewed_count;?></dd>
					</dl>

					<?php $revenue=($job['Job']['revenue']) ? $this->Html->siteCurrencyFormatWithoutSup($job['Job']['revenue']) : $this->Html->siteCurrencyFormatWithoutSup('0');?>

					<dl class="dc list list-big top-mspace users mob-clr mob-sep-none ">
						<dt class="pr hor-mspace graydarkerc"><?php echo __l('Revenue');?></dt>
						<dd title="<?php echo $revenue;?>" class="text-32 graydarkerc pr hor-mspace"><?php echo $revenue;?></dd>
					</dl>
				</div>
				<div>
				<?php
						if(empty($job['Job']['admin_suspend']) && !empty($job['Job']['is_active']) && !empty($is_job_share_enabled)):
					?>
						<?php
							// Twitter
							$tw_url = Router::url(array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']), true);
							$tw_url = urlencode_rfc3986($tw_url);
							$tw_message = $job['User']['username'].':'.' '.$job['Job']['title'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($job['Job']['amount'], false);
							//$tw_message = urlencode_rfc3986($tw_message);
							// Facebook
							$fb_status = Router::url(array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']), true);
							$fb_status = urlencode_rfc3986($fb_status);
						?>
						<ul class="share-list">
							<li class="email"><?php echo $this->Html->link(__l('email'), 'mailto:?subject='.__l('Cool! I found someone that will').' '.$job['Job']['title'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($job['Job']['amount'], false).'&amp;body='.__l('Hi, Check it out: ').Router::url(array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'])), array('target' => 'blank', 'title' => __l('mail'), 'class' => 'quick'));?></li>
							<li class="facebook"><fb:like href="<?php echo $fb_status;?>" layout="button_count" show_faces="false" width="50" height="40" action="like" colorscheme="light"></fb:like></li>	
							<li class="twitter"><a href="http://twitter.com/share?url=<?php echo $tw_url;?>&amp;text=<?php echo $tw_message;?>&amp;via=<?php echo Configure::read('twitter.site_username');?>&amp;lang=en&amp;count=none" class="twitter-share-button"><?php echo __l('Tweet!');?></a></li>
													
						</ul>
					<?php endif;?>	
				</div>
			</div> 
			<div class="clearfix"> <?php echo $this->Html->siteCurrencyFormat($job['Job']['amount']);?></div>

		</li>
	<?php
		endforeach;
	else:
	?>
		<li>
			<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.__l('available');?></p></div>
		</li>
	<?php
	endif;
	?>
	</ol>
<?php
if (!empty($jobs)) { ?>
<div class="clearfix pull-right mob-clr ver-space mob-dc">
<?php echo $this->element('paging_links'); ?>
</div>
<?php } ?>
	<?php echo $this->Form->end();?>
	</div>
	<?php else:?>
	<div>
	
		
			  
				<h3 class="manage-jobs-title"><?php echo __l('Hey newbie! Time to create your first').' '.jobAlternateName(ConstJobAlternateName::Singular).'! ';?><span><?php echo __l('It is so darn easy!');?></span></h3>
		
			 <ul class="jobs-list-info clearfix">
				<li class="step1"><p><?php echo __l('Come up with cool ideas for things you are willing to do for ');?><?php echo $this->Html->siteJobAmount('or');?></p></li>
				<li class="step2"><p><?php echo __l('Create a').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('for your idea(s)');?></p></li>
				<li class="step3"><p><?php echo __l('Promote your new').' '.jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps).' '.__l('in your social networks');?></p></li>
				<li class="step4"><p><?php echo __l('Make lots of ').' ';?><?php echo Configure::read('site.name');?>!!!</p></li>
			  </ul>
			  <div class="clearfix">
				<div class="shopping-list clearfix">
					<div class="cancel-block clearfix">
						<?php echo $this->Html->link(__l('Create First').' '.jobAlternateName(ConstJobAlternateName::Singular), array('controller' => 'jobs', 'action' => 'add'), array('class' => 'btn btn-success text-14', 'title' => __l('Create First').' '.jobAlternateName(ConstJobAlternateName::Singular))); ?>
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