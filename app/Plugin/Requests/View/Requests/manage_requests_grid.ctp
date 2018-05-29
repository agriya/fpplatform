<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="needs-block">
<div class="jobs index js-response js-responses js-jobs-scroll-here js-lazyload">
<h2><?php echo __l($this->pageTitle);?></h2>
<?php echo $this->Form->create('Request' , array('class' => 'normal form-horizontal ','action' => 'update'));?>
	<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->params['url']['url'])); ?>
	<?php if(!empty($requests)):?>
	<div class="clearfix my-jobs-block">
		<div class="my-jobs-left-block">
		<div class="cancel-block">
			<?php echo $this->Html->link(__l('Add'), array('controller' => 'requests', 'action' => 'add'), array('title' => __l('Add requests'))); ?>
		</div>
		<?php echo $this->Form->submit(__l('Suspend'),array('class' => 'js-admin-action', 'name' => 'data[Request][type_suspend]')); ?>
		<?php echo $this->Form->submit(__l('Activate'),array('class' => 'js-admin-action', 'name' => 'data[Request][type_activate]')); ?>
		<?php echo $this->Form->submit(__l('Delete'),array('class' => 'js-admin-action', 'name' => 'data[Request][type_delete]')); ?>
		</div>
	<div class="select-block my-jobs-right-block">
		<div class="inbox-option">
			<span class="select"><?php echo __l('Select:'); ?></span>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'js-admin-select-pending', 'title' => __l('Suspended'))); ?>
			<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-admin-select-approved', 'title' => __l('Active'))); ?>
		</div>
	</div>
    <div class="select-block my-jobs-right-block">
    <div class="inbox-option clearfix">
		<span class="select"><?php echo __l('Show').':'; ?></span>
		<ul class="filter-list">
    		<li> 
            	<?php echo $this->Html->link(__l('List'), array('controller'=> 'requests', 'action'=>'index', 'type' => 'manage_requests', 'admin' => false), array('title' => __l('List'), 'class' => 'list','escape' => false));?>
            </li>
			<li> 
				<?php echo $this->Html->link(__l('Grid'), array('controller'=> 'requests', 'action'=>'index', 'type' => 'manage_requests', 'view'=> 'grid','admin' => false), array('title' => __l('Grid'), 'class' => 'grid status_selected','escape' => false));?>
            </li>
	   </ul>
	</div>
</div>
	</div>
    
	<?php echo $this->element('paging_counter');?>
	<?php else: ?>
	<div class="clearfix">
		<div class="my-jobs-left-block">
			<div class="cancel-block">
				<?php echo $this->Html->link(__l('Add New'), array('controller' => 'requests', 'action' => 'add'), array('title' => __l('Add Requests'))); ?>
			</div>
		</div>
	</div>
	<?php endif;?>
<table class="table table-striped table-hover sep">
	<tr>
    	<th><?php echo __l('Select');?></th>
        <?php if(Configure::read('request.is_admin_request_user__edit_option')==1): ?>
        <th><div><?php echo __l('Action'); ?></div></th>
        <?php endif; ?>
		<th><div class="js-pagination"><?php echo $this->Paginator->sort('name', requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps)); ?></div></th>
         <th><?php echo __l('Status');?></th>
        <th><div class="js-pagination"><?php echo $this->Paginator->sort('type_id'__l('Type')); ?></div></th>        
		<th><div class="js-pagination"><?php echo $this->Paginator->sort('JobCategory.name', __l('Category')); ?></div></th>
		<th><div class="js-pagination"><?php echo $this->Paginator->sort('amount', __l('Amount')); ?></div></th>
        <th><div class="js-pagination"><?php echo $this->Paginator->sort('request_view_count', __l('Views')); ?></div></th>
        <th><div class="js-pagination"><?php echo $this->Paginator->sort('request_view_count', jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)); ?></div></th>
        <th><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Posted On'));?></div></th>
	</tr>
<?php
if (!empty($requests)):

$i = 0;
foreach ($requests as $request):
	$class = null;
	if ($i++ % 2 == 0):
		$class = ' class="altrow"';
	endif;
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
	<tr<?php echo $class;?>>
    	 <td>		 
		 <?php 
		 if(empty($request['Request']['admin_suspend']) && $request['Request']['is_approved']):
			 echo $this->Form->input('Request.'.$request['Request']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$request['Request']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); 
		 endif; 
			 ?></td>
         <?php if(Configure::read('request.is_admin_request_user__edit_option')==1): ?>
          <td><div class="clearfix cancel-block1">
			                    <div class="cancel-block">
                 	            <?php echo $this->Html->link(__l('Edit'), array('controller' => 'requests', 'action'=>'edit', $request['Request']['id']), array('title' => __l('Edit')));?>
			                  </div>
                            </div></td>
          <?php endif; ?>
		<td><p><?php echo $this->Html->link($this->Html->cText($request['Request']['name']), array('controller' => 'requests', 'action' => 'view', $request['Request']['slug']), array('title' => $this->Html->cText($request['Request']['name'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($request['Request']['amount']), false),'escape' => false));?>  </p></td>
        <td> 			<?php 
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
        </td> 
		<td>
		<p>
				<?php
					echo $this->Html->cText($request['JobType']['name']);
				?>
			</p>
				</td>
		<td>
		<p>
				<?php
					echo $this->Html->cText($request['JobCategory']['name']);
				?>
			</p>
				</td>
		<td><?php echo $this->Html->siteCurrencyFormat($request['Request']['amount']);?></td>
                
        <td>
		<?php echo $this->Html->cInt($request['Request']['request_view_count']);?></td>
        <td>
		<?php echo $this->Html->cInt($request['Request']['job_count']);?></td>
        <td><?php echo $this->Html->cDateTimeHighlight($request['Request']['created']);?></td>        
      </tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan='8'><div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.__l('available');?></p></div></td>
	</tr>
<?php
endif;
?>
</table>

	<div class="js-pagination js-scrollto">
	<?php
	if (!empty($requests)) {
		echo $this->element('paging_links');
	}

	?>
	</div>
	<?php echo $this->Form->end();?>
	</div>
</div>	

