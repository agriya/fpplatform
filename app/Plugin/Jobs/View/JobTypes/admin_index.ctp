<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="contactTypes index js-response">
<div class="clearfix top-space top-mspace">
<?php echo $this->element('paging_counter');?>

</div>
<div class="tab-pane active in no-mar clearfix" id="active-users">
                    <div class="sep bot-mspace img-rounded clearfix">
                      <table class="table no-mar table-striped table-hover">

	<tr>
		<th class="dc sep-right textn span2"><?php echo __l('Actions');?></th>
		<th class="dl sep-right textn"><?php echo $this->Paginator->sort('name', __l('Name'), array('class' => 'graydarkerc no-under')); ?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('job_count', jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('class' => 'graydarkerc no-under')); ?></th>
        <?php if(isPluginEnabled('Requests')) { ?>
		<th class="dc sep-right textn"><?php echo $this->Paginator->sort('request_count', requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps), array('class' => 'graydarkerc no-under')); ?></th>
		<?php } ?>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('job_category_count', __l('Categories'), array('class' => 'graydarkerc no-under')); ?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('is_active', __l('Active?'), array('class' => 'graydarkerc no-under')); ?></th> 
	</tr>

<?php
if (!empty($jobTypes)):
foreach ($jobTypes as $jobType):?>


<tr>
		<td class="dc grayc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="grayc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide"><?php echo __l('Action'); ?></span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('controller' => 'job_types', 'action' => 'edit', $jobType['JobType']['id']), array('escape' => false,'class' => 'edit', 'title' => __l('Edit')));?></li>
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'job_types', 'action' => 'delete', $jobType['JobType']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
   	  </span>
		</td>		
		<td class="dl grayc"><p><?php echo $this->Html->cText($jobType['JobType']['name']);?></p></td>
		<td class="dc grayc"><p><?php echo $this->Html->link($this->Html->cInt($jobType['JobType']['job_count']), array('controller' =>'jobs', 'action' => 'index', 'job_type_id' => $jobType['JobType']['id'], 'filter_id' => ConstMoreAction::Active, 'admin' => true), array('escape' => false, 'class' => 'grayc') );?></p></td>
		<?php if(isPluginEnabled('Requests')) { ?>
        <td class="dc grayc"><p><?php echo $this->Html->link($this->Html->cInt($jobType['JobType']['request_count']), array('controller' =>'requests', 'action' => 'index', 'job_type_id' => $jobType['JobType']['id'], 'filter_id' => ConstMoreAction::Active, 'admin' => true ), array('escape' => false, 'class' => 'grayc'));?></p></td>
		<?php } ?>
        <td class="dc grayc"><p><?php echo $this->Html->link($this->Html->cInt(!empty($jobType['JobType']['job_category_count'])?$jobType['JobType']['job_category_count']:'0'), array('controller' =>'job_categories', 'action' => 'index', 'job_type_id' => $jobType['JobType']['id'], 'filter_id' => ConstMoreAction::Active, 'admin' => true), array('escape' => false, 'class' => 'grayc'));?></p></td>
        <td class="dc grayc"><?php echo $this->Html->cBool($jobType['JobType']['is_active']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan='6' class="notice"><?php echo __l('No Job Types available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>

<?php
    if (!empty($jobTypes)) :
        ?>
          <div class="pagination pull-right no-mar mob-clr dc">
            <?php $this->element('paging_links'); ?>
        </div>
        
        <?php
		 endif;
    echo $this->Form->end();
    ?>
</div>