<?php /* SVN: $Id: $ */ ?>
<div class="hor-space js-response">
	<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps); ?></li>
	</ul>
	<div class="tabbable ver-space sep-top top-mspace">
      <div id="list" class="tab-pane active in no-mar">
        <div class="clearfix">
		    <?php $jobs_variabe = jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps); 
			$class = (!empty($this->request->data['Job']['filter_id']) && $this->request->data['Job']['filter_id'] == ConstMoreAction::Active) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Active').' '. $jobs_variabe . '</dt><dd title="' . $active_jobs . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($active_jobs) . '</dd>  </dl>', array('controller'=>'jobs','action'=>'index','filter_id' => ConstMoreAction::Active), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Active').' '. $jobs_variabe, 'escape' => false));
			$class = (!empty($this->request->data['Job']['filter_id']) && $this->request->data['Job']['filter_id'] == ConstMoreAction::Feature) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Featured').' '. $jobs_variabe . '</dt><dd title="' . $feautured_jobs . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($feautured_jobs) . '</dd>  </dl>', array('controller'=>'jobs','action'=>'index','filter_id' => ConstMoreAction::Feature), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Featured').' '. $jobs_variabe, 'escape' => false));
			$class = (!empty($this->request->data['Job']['filter_id']) && $this->request->data['Job']['filter_id'] == ConstMoreAction::Suspend) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Admin Suspended').' '. $jobs_variabe . '</dt><dd title="' . $suspended_jobs . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($suspended_jobs) . '</dd>  </dl>', array('controller'=>'jobs','action'=>'index','filter_id' => ConstMoreAction::Suspend), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Admin Suspended').' '. $jobs_variabe, 'escape' => false));
			$class = (!empty($this->request->data['Job']['filter_id']) && $this->request->data['Job']['filter_id'] == ConstMoreAction::Inactive) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('User Suspended').' '. $jobs_variabe . '</dt><dd title="' . $user_suspended_jobs . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($user_suspended_jobs) . '</dd>  </dl>', array('controller'=>'jobs','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('User Suspended').' '. $jobs_variabe, 'escape' => false));
			$class = (!empty($this->request->data['Job']['filter_id']) && $this->request->data['Job']['filter_id'] == ConstMoreAction::Flagged) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('System Flagged').' '. $jobs_variabe . '</dt><dd title="' . $system_flagged . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($system_flagged) . '</dd>  </dl>', array('controller'=>'jobs','action'=>'index','filter_id' => ConstMoreAction::Flagged), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('System Flagged').' '. $jobs_variabe, 'escape' => false));
			$class = (!empty($this->request->data['Job']['filter_id']) && $this->request->data['Job']['filter_id'] == ConstMoreAction::Online) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Online').' '. $jobs_variabe . '</dt><dd title="' . $online_jobs . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($online_jobs) . '</dd>  </dl>', array('controller'=>'jobs','action'=>'index','filter_id' => ConstMoreAction::Online), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Online').' '. $jobs_variabe, 'escape' => false));
			$class = (!empty($this->request->data['Job']['filter_id']) && $this->request->data['Job']['filter_id'] == ConstMoreAction::Offline) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Offline').' '. $jobs_variabe . '</dt><dd title="' . $offline_jobs . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($offline_jobs) . '</dd>  </dl>', array('controller'=>'jobs','action'=>'index','filter_id' => ConstMoreAction::Offline), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Offline').' '. $jobs_variabe, 'escape' => false));
			$class = (empty($this->request->data['Job']['filter_id'])) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Total').' '. $jobs_variabe . '</dt><dd title="' . $total_jobs . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($total_jobs) . '</dd>  </dl>', array('controller'=>'jobs','action'=>'index'), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Total').' '. $jobs_variabe, 'escape' => false));?>
		</div>
		<div class="clearfix top-space top-mspace sep-top">
		  <div class="pull-right span10 users-form tab-clr">
			<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('Job', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
				  <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
				<div class="submit left-space">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
			<div class="pull-right top-space top-mspace mob-clr mob-dc tab-clr">
				<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18"></i> <span class="grayc">' . __l('Add') . '</span>', array('controller' => 'jobs', 'action' => 'add','admin'=>false), array('class' => 'hor-mspace bluec textb text-13','title'=>__l('Add'), 'escape' => false)); ?>
				<?php echo $this->Html->link('<i class="icon-remove-sign no-pad text-18"></i> <span class="grayc">' . __l('Purge') . '</span>', array_merge(array('controller' => 'jobs', 'action' => 'purge', 'admin' => true),$this->request->params['named']), array('title' => __l('Delete '.jobAlternateName(ConstJobAlternateName::Plural).' from site'), 'class' => 'textb bluec text-13 js-confirm', 'escape' => false));?>
			</div>
		  </div>
		  <?php echo $this->element('paging_counter'); ?>
		</div>
    <?php   echo $this->Form->create('Job' , array('class' => 'normal ', 'controller' => 'jobs', 'action' => 'update'));
$url=(!empty($this->request->url)?$this->request->url:'');?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $url )); ?>
<div class="tab-pane active in no-mar" id="active-users">
  <div class="sep bot-mspace img-rounded clearfix">
    <table class="table no-mar table-striped table-hover">
  	  <thead>
	  <tr class="no-mar no-pad">
		<th class="dc sep-right textn"><?php echo __l('Select');?></th>
        <th class="dc sep-right textn"><?php echo __l('Actions');?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('created', __l('Created'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dl sep-right textn"><?php echo $this->Paginator->sort('title', __l('Title'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dl sep-right textn"><?php echo $this->Paginator->sort('JobCategory.name', __l('Category'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dl sep-right textn"><?php echo $this->Paginator->sort('User.username', __l('User'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('amount', __l('Amount') . ' (' . $this->Html->cText(Configure::read('site.currency'), false) . ')', array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('no_of_days', __l('No of Days'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('job_view_count', __l('Views'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('job_feedback_count', __l('Feedbacks'), array('class' => 'graydarkerc no-under'));?></th>
		<?php if(isPluginEnabled('JobFavorites')): ?>
	        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('', __l('Favorites'), array('class' => 'graydarkerc no-under'));?></th>
		<?php endif; ?>
		<th class="dc sep-right textn"><?php echo $this->Paginator->sort('job_tag_count', __l('Tags'), array('class' => 'graydarkerc no-under'));?></th>
		<?php if(isPluginEnabled('JobFlags')) : ?>
	        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('job_flag_count', __l('Flags'), array('class' => 'graydarkerc no-under'));?></th>
		<?php endif; ?>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('revenue', __l('Revenue') . ' (' . Configure::read('site.currency') . ')', array('class' => 'graydarkerc no-under'));?></th>
        <th class="dl sep-right textn"><?php echo $this->Paginator->sort('Ip.ip', __l('IP'), array('class' => 'graydarkerc no-under'));?></th>
    </tr>
	</thead>
    <tbody>
<?php
if (!empty($jobs)):
$i = 0;
foreach ($jobs as $job):
	$class = null;
	if ($i++ % 2 == 0):
		$class = ' class="altrow"';
	endif;
	if($job['Job']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
		$status_class = 'js-checkbox-inactive';
	endif;
	if($job['Job']['is_featured']):
		$status_class.= ' js-checkbox-featured';
	else:
		$status_class.= ' js-checkbox-notfeatured';
	endif;
	if($job['Job']['admin_suspend']):
		$status_class.= ' js-checkbox-suspended';
	else:
		$status_class.= ' js-checkbox-unsuspended';
	endif;
	if($job['Job']['is_system_flagged']):
		$status_class.= ' js-checkbox-flagged';
	else:
		$status_class.= ' js-checkbox-unflagged';
	endif;
	if(!empty($job['JobFlag'])):
		$status_class.= ' js-checkbox-user-reported';
	else:
		$status_class.= ' js-checkbox-unreported';
	endif;
	if($job['User']['is_active']):
		$status_class.= ' js-checkbox-activeusers';
	else:
		$status_class.= ' js-checkbox-deactiveusers';
	endif;
	if($job['Job']['is_approved']):
		$status_class.= ' js-checkbox-approved';
		$style_class = 'approved';
	else:
		$style_class = 'dis-approved';
		$status_class.= ' js-checkbox-disapproved';
	endif;



?>
	<tr<?php echo $class;?>>
	    <td class="dc grayc"><?php echo $this->Form->input('Job.'.$job['Job']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$job['Job']['id'], 'label' => '', 'div' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
		<td class="dc grayc">
		  <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
            <ul class="dropdown-menu arrow dl">
			<?php if(empty($job['Job']['is_deleted'])):?>
				<li><?php echo $this->Html->link('<i class="icon-edit"></i>' . __l('Edit'), array('controller' => 'jobs', 'action' => 'edit', $job['Job']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'), 'escape' => false));?></li>
				<li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('controller' => 'jobs', 'action' => 'delete', $job['Job']['id']), array('class' => 'delete js-confirm', 'title' => __l('Disappear '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' from user side'), 'escape' => false));?></li>
				<?php if($job['Job']['is_system_flagged']):?>
				
					<?php if($job['User']['is_active']):?>
						<li>	<?php echo $this->Html->link('<i class="icon-minus-sign"></i>' . __l('Deactivate User'), array('controller' => 'users', 'action' => 'admin_update_status', $job['User']['id'], 'status' => 'deactivate'), array('class' => 'js-confirm deactive-user', 'title' => __l('Deactivate user'), 'escape' => false));?>
					</li>
					<?php else:?>
							<li><?php echo $this->Html->link('<i class="icon-add-sign"></i>' . __l('Activate User'), array('controller' => 'users', 'action' => 'admin_update_status', $job['User']['id'], 'status' => 'activate'), array('class' => 'js-confirm active-user', 'title' => __l('Activate user'), 'escape' => false));?>
							</li>
					<?php endif;?>
					
				<?php endif;?>
			
					<?php if($job['Job']['is_system_flagged']):?>
						<li>	<?php echo $this->Html->link('<i class="icon-flag"></i>' . __l('Clear flag'), array('controller' => 'jobs', 'action' => 'admin_update_status', $job['Job']['id'], 'flag' => 'deactivate'), array('class' => 'js-confirm clear-flag', 'title' => __l('Clear flag'), 'escape' => false));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link('<i class="icon-flag"></i>' . __l('Flag'), array('controller' => 'jobs', 'action' => 'admin_update_status', $job['Job']['id'], 'flag' => 'active'), array('class' => 'js-confirm flag', 'title' => __l('Flag'), 'escape' => false));?>
						</li>
					<?php endif;?>
					<?php if($job['Job']['admin_suspend']):?>
							<li><?php echo $this->Html->link('<i class="icon-eye-open"></i>' . __l('Unsuspend').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'jobs', 'action' => 'admin_update_status', $job['Job']['id'], 'flag' => 'unsuspend'), array('class' => 'js-confirm  unsuspend', 'title' => __l('Unsuspend').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), 'escape' => false));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link('<i class="icon-eye-close"></i>' . __l('Suspend').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'jobs', 'action' => 'admin_update_status', $job['Job']['id'], 'flag' => 'suspend'), array('class' => 'js-confirm suspend', 'title' => __l('Suspend').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), 'escape' => false));?>
					</li>
					<?php endif;?>
				<?php else:?>
					<li><?php echo $this->Html->link('<i class="icon-delete-point"></i>' . __l('Permanent Delete'), array('controller' => 'jobs', 'action' => 'delete', $job['Job']['id']), array('class' => 'delete js-confirm', 'title' => __l('Delete'), 'escape' => false));?></li>
				<?php endif;?>
                <li><?php echo $this->Html->link((( $job['Job']['is_approved']) ? '<i class="icon-remove-sign"></i>' .__l('Disapprove') : '<i class="icon-ok-sign"></i>' .__l('Approve')), array('controller' => 'jobs', 'action' => 'admin_update_status',  $job['Job']['id'],'status' => (( $job['Job']['is_approved']) ? __l('disapproved') : __l('approved'))), array('class' => 'js-confirm', 'title' => __l((( $job['Job']['is_approved']) ? __l('Disapprove') : __l('Approve'))), 'escape' => false));?></li>
               </ul>
          </div>
        </td>
		<td class="dc grayc"><?php echo $this->Html->cDateTimeHighlight($job['Job']['created']);?></td>
		<td class="grayc">
		<?php $attachment = '';?>
		<div class="span6 no-mar">
            <div class="clearfix"> 
			<?php if(!empty($job['Attachment']['0'])){?>
			<?php echo $this->Html->link($this->Html->showImage('Job', $job['Attachment']['0'], array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)), 'title' => $this->Html->cText($job['Job']['title'], false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('escape' => false, 'class' => 'pull-left show'));?>
		<?php }else{ ?>
				<?php echo $this->Html->link($this->Html->showImage('Job', $attachment, array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)), 'title' => $this->Html->cText($job['Job']['title'], false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('escape' => false, 'class' => 'grayc pull-left show'));?>
		<?php } ?>	
		<?php echo $this->Html->link($this->Html->cText($job['Job']['title']), array('controller'=> 'jobs', 'action'=>'view', $job['Job']['slug'] , 'admin' => false), array('title'=>$this->Html->cText($job['Job']['title'],false),'escape' => false, 'class' => 'span5 htruncate grayc js-bootstrap-tooltip'));?>
		</div>
			<div class="clearfix top-smspace">
			<?php if($job['Job']['is_featured']):?>
				<span class="label label-warning pull-left right-smspace"> <?php echo __l('Featured'); ?></span>
			<?php endif;?>
			<?php
			if($job['Job']['admin_suspend']):
				echo '<span class="label label-error pull-left">'.__l('Admin Suspended').'</span>';
			else:
				if(!empty($job['JobFlag'])):
					echo '<span class="label label-important flagged pull-left right-smspace">'.__l('Flagged').'</span>';
				endif;
				if($job['Job']['is_system_flagged']):
					echo '<span class="label label-important system-flagged pull-left right-smspace">'.__l('System Flagged').'</span>';
				endif;
				if(empty($job['Job']['is_active'])):
					echo '<span class="label label-inverse suspended-user pull-left right-smspace">'.__l('User Suspended').'</span>';
				endif;
			endif;
		?>
			</div>
			<div class="clearfix top-smspace">
				<?php if($job['JobType']['name'] == 'Offline'):?>
				  <span class="label label-info"><?php echo $this->Html->cText($job['JobType']['name']); ?></span>
				<?php elseif($job['JobType']['name'] == 'Online'):?>
				  <span class="label label-success"><?php echo $this->Html->cText($job['JobType']['name']); ?></span>
				<?php endif; ?>
			</div>
		  </div>
        </td>
		<td class="dl grayc"><?php echo $this->Html->cText($job['JobCategory']['name']); ?>

        </td>
		<td class="dl grayc"><?php echo $this->Html->link($this->Html->cText($job['User']['username']), array('controller'=> 'users', 'action'=>'view', $job['User']['username'] , 'admin' => false), array('escape' => false, 'class' => 'grayc'));?></td>
		<td class="dr grayc"><?php echo $this->Html->cCurrency($job['Job']['amount']);?></td>
		<td class="dc grayc"><?php echo $this->Html->cInt($job['Job']['no_of_days']);?></td>
         <td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($job['Job']['job_view_count'], false), array('controller' => 'job_views', 'job_id' => $job['Job']['id']), array('class' => 'grayc'));?></td> 
         <td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($job['Job']['job_feedback_count'], false), array('controller' => 'job_feedbacks', 'job_id' => $job['Job']['id']), array('class' => 'grayc'));?></td> 
		 <?php if(isPluginEnabled('JobFavorites')): ?>
			<td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($job['Job']['job_favorite_count'], false), array('controller' => 'job_favorites', 'job_id' => $job['Job']['id']), array('class' => 'grayc'));?></td> 
		<?php endif; ?>
		<td class="dc grayc"><?php echo $this->Html->cInt($job['Job']['job_tag_count']);?></td>
		 <?php if(isPluginEnabled('JobFlags')): ?>
			<td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($job['Job']['job_flag_count'], false), array('controller' => 'job_flags',  'job_id' => $job['Job']['id']), array('class' => 'grayc'));?></td>
		<?php endif; ?>		
		<td class="dr grayc"><?php echo $this->Html->cFloat($job['Job']['revenue']);?></td>
		<td>
          <?php if(!empty($job['Ip']['ip'])): ?>
            <?php echo  $this->Html->link($job['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $job['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$job['Ip']['ip'], 'escape' => false, 'class' => 'grayc')); ?>
      <p>
      <?php
       if(!empty($job['Ip']['Country'])):
              ?>
              <span class="flags flag-<?php echo strtolower($job['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $job['Ip']['Country']['name']; ?>">
        <?php echo $job['Ip']['Country']['name']; ?>
      </span>
              <?php
            endif;
       if(!empty($job['Ip']['City'])):
            ?>
            <span>   <?php echo $job['Ip']['City']['name']; ?>  </span>
            <?php endif; ?>
            </p>
          <?php else: ?>
      <?php echo __l('n/a'); ?>
    <?php endif; ?>
   </td> 
    </tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="22" class="grayc notice text-16 dc"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.__l('available');?></td>
	</tr>
<?php
endif;
?>
<tbody>
</table>
</div>
</div>

<?php
if (!empty($jobs)) :
        ?>
  <div class="ver-mspace mob-dc clearfix">
    <div class="top-space pull-left dc mob-clr mob-inline clearfix">
       <div class="pull-left ver-space">
			<?php echo __l('Select:'); ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"}   hor-smspace grayc', 'title' => __l('Active'))); ?>
			<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"}  hor-smspace grayc', 'title' => __l('Inactive'))); ?>   

			 <?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-suspended","unchecked":"js-checkbox-unsuspended"} hor-smspace grayc', 'title' => __l('Suspended'))); ?>
            <?php echo $this->Html->link(__l('Flagged'), '#', array('class' => 'js-select js-no-pjax  {"checked":"js-checkbox-flagged","unchecked":"js-checkbox-unflagged"} hor-smspace grayc', 'title' => __l('Flagged'))); ?>
			<?php echo $this->Html->link(__l('Featured'), '#', array('class' => 'js-select js-no-pjax  {"checked":"js-checkbox-featured","unchecked":"js-checkbox-notfeatured"} hor-smspace grayc', 'title' => __l('Featured'))); ?>
			<?php echo $this->Html->link(__l('Reported'), '#', array('class' => 'js-select js-no-pjax  {"checked":"js-checkbox-user-reported","unchecked":"js-checkbox-unreported"} hor-smspace grayc', 'title' => __l('Reported'))); ?>
			<?php echo $this->Html->link(__l('Approved'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-approved","unchecked":"js-checkbox-disapproved"}   hor-smspace grayc', 'title' => __l('Approved'))); ?>
			<?php echo $this->Html->link(__l('Disapproved'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-disapproved","unchecked":"js-checkbox-approved"}  hor-smspace grayc', 'title' => __l('Disapproved'))); ?>   
        </div>
        <div class="pull-left hor-mspace mob-no-mar">
                <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit span4', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
      </div>
      <div class=" pull-right top-space">
         <?php echo $this->element('paging_links'); ?>
      </div>
	  <div class="hide">
        <?php echo $this->Form->submit('Submit');  ?>
      </div>
	  </div>

<?php endif;
echo $this->Form->end();
?>
</div>
</div>
</div>
