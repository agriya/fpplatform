<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="hor-space js-response js-responses">
	<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps); ?></li>
	</ul>
	<div class="tabbable ver-space sep-top top-mspace">
      <div id="list" class="tab-pane active in no-mar">
        <div class="clearfix">
			<?php $requests_variabe = requestAlternateName(ConstRequestAlternateName::Plural); 
			$class = (!empty($this->request->data['Request']['filter_id']) && $this->request->data['Request']['filter_id'] == ConstMoreAction::Active) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Active').' '. $requests_variabe . '</dt><dd title="' . $active_requests . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($active_requests) . '</dd>  </dl>', array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Active), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Active').' '. $requests_variabe, 'escape' => false));
			$class = (!empty($this->request->data['Request']['filter_id']) && $this->request->data['Request']['filter_id'] == ConstMoreAction::Suspend) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Admin Suspended').' '. $requests_variabe . '</dt><dd title="' . $suspended_requests . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($suspended_requests) . '</dd>  </dl>', array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Suspend), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Admin Suspended').' '. $requests_variabe, 'escape' => false));
			$class = (!empty($this->request->data['Request']['filter_id']) && $this->request->data['Request']['filter_id'] == ConstMoreAction::Inactive) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('User Suspended').' '. $requests_variabe . '</dt><dd title="' . $user_suspended_requests . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($user_suspended_requests) . '</dd>  </dl>', array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('User Suspended').' '. $requests_variabe, 'escape' => false));
			$class = (!empty($this->request->data['Request']['filter_id']) && $this->request->data['Request']['filter_id'] == ConstMoreAction::Flagged) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('System Flagged').' '. $requests_variabe . '</dt><dd title="' . $system_flagged . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($system_flagged) . '</dd>  </dl>', array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Flagged), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('System Flagged').' '. $requests_variabe, 'escape' => false));
			$class = (!empty($this->request->data['Request']['filter_id']) && $this->request->data['Request']['filter_id'] == ConstMoreAction::Online) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Online').' '. $requests_variabe . '</dt><dd title="' . $online_requests . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($online_requests) . '</dd>  </dl>', array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Online), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Online').' '. $requests_variabe, 'escape' => false));
			$class = (!empty($this->request->data['Request']['filter_id']) && $this->request->data['Request']['filter_id'] == ConstMoreAction::Offline) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Offline').' '. $requests_variabe . '</dt><dd title="' . $offline_requests . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($offline_requests) . '</dd>  </dl>', array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Offline), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Offline').' '. $requests_variabe, 'escape' => false));
			$class = (empty($this->request->data['Request']['filter_id'])) ? ' active' : null; 
			echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Total').' '. $requests_variabe . '</dt><dd title="' . $total_requests . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($total_requests) . '</dd>  </dl>', array('controller'=>'requests','action'=>'index'), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Total').' '. $requests_variabe, 'escape' => false));?>
		</div>
		<div class="clearfix top-space top-mspace sep-top">
		  <div class="pull-right span9 users-form tab-clr">
			<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('Request', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
				<div class="input text required ver-smspace">
				  <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
				</div>
				<div class="submit left-space">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
			<div class="pull-right top-space top-mspace mob-clr mob-dc tab-clr">
				<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18"></i> <span class="grayc">' . __l('Add') . '</span>', array('controller' => 'requests', 'action' => 'add'), array('class' => 'hor-mspace bluec textb text-13','title'=>__l('Add'), 'escape' => false)); ?>
			</div>
		  </div>
		  <?php echo $this->element('paging_counter'); ?>
		</div>
<div>
  <?php   echo $this->Form->create('Request' , array('class' => 'normal ','action' => 'update'));?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="tab-pane active in no-mar" id="active-users">
  <div class="sep bot-mspace img-rounded clearfix">
    <table class="table no-mar table-striped table-hover">
  	  <thead>
	  <tr class="no-mar no-pad">
		<th class="dc sep-right textn"><?php echo __l('Select'); ?></th>
		<th class="dc sep-right textn"><?php echo __l('Actions'); ?></th>
		<th class="dc sep-right textn"><?php echo $this->Paginator->sort('User.username', __l('Username'), array('class' => 'graydarkerc no-under'));?></th>
		<th class="dc sep-right textn"><?php echo $this->Paginator->sort('JobType.name', __l('Type'), array('class' => 'graydarkerc no-under')); ?></th>
		<th class="sep-right textn"><?php echo $this->Paginator->sort('JobCategory.name', __l('Category'), array('class' => 'graydarkerc no-under')); ?></th>
		<th class="sep-right textn"><?php echo $this->Paginator->sort('name', requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps), array('class' => 'graydarkerc no-under')); ?></th>
		<th class="dr sep-right textn"><?php echo $this->Paginator->sort('amount', __l('Amount' . ' (' . $this->Html->cText(Configure::read('site.currency'), false) . ')'), array('class' => 'graydarkerc no-under')); ?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('request_view_count', __l('Views'), array('class' => 'graydarkerc no-under')); ?></th>
		<?php if(isPluginEnabled('RequestFlags')): ?>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('request_flag_count', __l('Flags'), array('class' => 'graydarkerc no-under')); ?></th>
		<?php endif; ?>
		<?php if(isPluginEnabled('RequestFavorites')): ?>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('request_favorite_count', __l('Favorite'), array('class' => 'graydarkerc no-under'));?></th>
		<?php endif; ?>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('created', __l('Posted On'), array('class' => 'graydarkerc no-under'));?></th>
 	</tr>
	</thead>
    <tbody>
<?php
if (!empty($requests)):
$i = 0;
foreach ($requests as $request):
	$class = null;
	if ($i++ % 2 == 0):
		$class = ' class="altrow"';
	endif;
	if($request['Request']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
		$status_class = 'js-checkbox-inactive';
	endif;
	if($request['Request']['admin_suspend']):
		$status_class.= ' js-checkbox-suspended';
	else:
		$status_class.= ' js-checkbox-unsuspended';
	endif;
	if($request['Request']['is_system_flagged']):
		$status_class.= ' js-checkbox-flagged';
	else:
		$status_class.= ' js-checkbox-unflagged';
	endif;
	if(!empty($Request['RequestFlag'])):
		$status_class.= ' js-checkbox-user-reported';
	else:
		$status_class.= ' js-checkbox-unreported';
	endif;
	if($request['User']['is_active']):
		$status_class.= ' js-checkbox-activeusers';
	else:
		$status_class.= ' js-checkbox-deactiveusers';
	endif;
	if($request['Request']['is_approved']):
		$status_class = 'js-checkbox-approved';
		$style_class = 'approved';
	else:
		$style_class = 'dis-approved';
		$status_class = 'js-checkbox-disapproved';
	endif;
?>
	<tr<?php echo $class;?>>
		<td class="dc grayc"><?php echo $this->Form->input('Request.'.$request['Request']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$request['Request']['id'], 'label' => '', 'div'=> false, 'class' => $status_class.' js-checkbox-list')); ?></td>
		<td class="dc grayc">
		 <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="<?php echo __l('Action'); ?>"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
            <ul class="dropdown-menu arrow dl">
			  <li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('controller' => 'requests', 'action' => 'delete', $request['Request']['id']), array('class' => 'js-confirm', 'title' => __l('Delete'), 'escape' => false));?></li>
			  <li><?php echo $this->Html->link('<i class="icon-edit"></i>' . __l('Edit'), array('controller' => 'requests', 'action'=>'edit', $request['Request']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'), 'escape' => false));?></li>
            <?php if($request['Request']['is_system_flagged']):?>
					<?php if($request['User']['is_active']):?>
						<li>	<?php echo $this->Html->link('<i class="icon-minus-sign"></i>' . __l('Deactivate User'), array('controller' => 'users', 'action' => 'admin_update_status', $request['User']['id'], 'status' => 'deactivate'), array('class' => 'js-confirm deactive-user', 'title' => __l('Deactivate user'), 'escape' => false));?>
					</li>
					<?php else:?>
							<li><?php echo $this->Html->link('<i class="icon-add-sign"></i>' . __l('Activate User'), array('controller' => 'users', 'action' => 'admin_update_status', $request['User']['id'], 'status' => 'activate'), array('class' => 'js-confirm active-user', 'title' => __l('Activate user'), 'escape' => false));?>
							</li>
					<?php endif;?>
             <?php endif;?>
             <?php if($request['Request']['is_system_flagged']):?>
						<li>	<?php echo $this->Html->link('<i class="icon-flag"></i>' . __l('Clear flag'), array('controller' => 'requests', 'action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'deactivate'), array('class' => 'js-confirm clear-flag', 'title' => __l('Clear flag'), 'escape' => false));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link('<i class="icon-flag"></i>' . __l('Flag'), array('controller' => 'requests', 'action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'active'), array('class' => 'js-confirm flag', 'title' => __l('Flag'), 'escape' => false));?>
						</li>
			 <?php endif;?>
             <?php if($request['Request']['admin_suspend']):?>
							<li><?php echo $this->Html->link('<i class="icon-eye-open"></i>' . __l('Unsuspend').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps), array('controller' => 'requests', 'action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'unsuspend'), array('class' => 'js-confirm  unsuspend', 'title' => __l('Unsuspend').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps), 'escape' => false));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link('<i class="icon-eye-close"></i>' . __l('Suspend').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps), array('controller' => 'requests', 'action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'suspend'), array('class' => 'js-confirm suspend', 'title' => __l('Suspend').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps), 'escape' => false));?>
					</li>
			<?php endif;?>
			<li><?php echo $this->Html->link((( $request['Request']['is_approved']) ? '<i class="icon-remove-sign"></i>' . __l('Disapprove') : '<i class="icon-ok-sign"></i>' . __l('Approve')), array('controller' => 'requests', 'action'=>'admin_update_status',  $request['Request']['id'],'status' => (( $request['Request']['is_approved']) ? __l('disapproved') : __l('approved'))), array('class' => "js-confirm $style_class", 'title' => __l((( $request['Request']['is_approved']) ? __l('Disapprove') : __l('Approve'))), 'escape' => false));?></li>
            </ul>
          </div>       
		</td>
		<td class="grayc"><?php echo $this->Html->link($this->Html->cText($request['User']['username']), array('controller'=> 'users', 'action'=>'view', $request['User']['username'], 'admin' => false), array('escape' => false, 'class' => 'grayc'));?></td>
		<td class="grayc">
		  <?php	echo $this->Html->cText($request['JobType']['name']);?>
		</td>
		<td class="grayc">
			<?php echo $this->Html->cText($request['JobCategory']['name']);	?>
		</td>
		<td class="grayc">
			<?php echo $this->Html->link($this->Html->cText($request['Request']['name']), array('controller' => 'requests', 'action' => 'view', $request['Request']['slug'], 'admin' => false), array('title' => $this->Html->cText($request['Request']['name'], false),'escape' => false, 'class' => 'grayc htruncate-ml2 span hor-space'));?>
		<?php
			if($request['Request']['admin_suspend']):
				echo '<span class="label label-inverse suspended">'.__l('Admin Suspended').'</span>';
			else:
				if(!empty($job['JobFlag'])):
					echo '<span class="label label-info flagged">'.__l('Flagged').'</span>';
				endif;
				if($request['Request']['is_system_flagged']):
					echo '<span class="label label-important system-flagged">'.__l('System Flagged').'</span>';
				endif;
				if(empty($request['Request']['is_active'])):
					echo '<span class="label label-warning suspended-user">'.__l('User Suspended').'</span>';
				endif;
			endif;
		?>
				</td>
		<td class="dr grayc"><?php echo $this->Html->cCurrency($request['Request']['amount']);?></td>
        <td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($request['Request']['request_view_count']), array('controller'=> 'request_views', 'action'=>'index', 'request_id'=>$request['Request']['id'], 'admin' => true), array('escape' => false, 'class' => 'grayc'));?>		</td>
		<?php if(isPluginEnabled('RequestFlags')): ?>
        <td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($request['Request']['request_flag_count']), array('controller'=> 'request_flags', 'action'=>'index', 'request_id'=>$request['Request']['id'], 'admin' => true), array('escape' => false, 'class' => 'grayc'));?>		</td>
		<?php endif; ?>
		<?php if(isPluginEnabled('RequestFavorites')): ?>
        <td class="dc grayc"><?php echo $this->Html->link($this->Html->cInt($request['Request']['request_favorite_count']), array('controller'=> 'request_favorites', 'action'=>'index', 'request_id'=>$request['Request']['id'], 'admin' => true), array('escape' => false, 'class' => 'grayc'));?>		</td>
		<?php endif; ?>
		<td class="dc grayc"><?php echo $this->Html->cDateTimeHighlight($request['Request']['created']);?></td>
    </tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="11" class="notice text-16 dc"><?php echo __l('No').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.__l('available');?></td>
	</tr>
<?php
endif;
?>
<tbody>
</table>
</div>
</div>
<?php
if (!empty($requests)):
?>
  <div class="ver-mspace mob-dc clearfix">
    <div class="top-space pull-left dc mob-clr mob-inline clearfix">
       <div class="pull-left ver-space">
         <?php echo __l('Select:'); ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Approved'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-approved","unchecked":"js-checkbox-disapproved"}   hor-smspace grayc', 'title' => __l('Approved'))); ?>
			<?php echo $this->Html->link(__l('Disapproved'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-disapproved","unchecked":"js-checkbox-approved"}  hor-smspace grayc', 'title' => __l('Disapproved'))); ?>   
		</div>
        <div class="pull-left hor-mspace mob-no-mar">
                <?php echo $this->Form->input('more_action_id', array('class' => 'span4 js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
      </div>
      <div class="pull-right top-space">
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
</div>