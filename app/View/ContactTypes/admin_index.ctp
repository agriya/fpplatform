<?php /* SVN: $Id: $ */ ?>
<div class="contactTypes index js-response">
<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo __l('Contact Types'); ?></li>
	</ul>
<div class="clearfix top-space top-mspace sep-top">
<div class="pull-right">
	<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18 hor-space"></i>'.__l('Add'), array('action' => 'add'), array('class' => 'hor-mspace bluec textb text-13','escape'=>false,'title'=>__l('Add'))); ?>
</div>
<?php echo $this->element('paging_counter');?>

</div>


    <?php echo $this->Form->create('ContactType' , array('class' => 'normal','action' => 'update')); ?>
    <?php  $url=(!empty($this->request->url)?$this->request->url:''); echo $this->Form->input('r', array('type' => 'hidden', 'value' => $url));  ?>
    <div class="overflow-block">
<div class="tab-pane active in no-mar clearfix" id="active-users">
                    <div class="sep bot-mspace img-rounded clearfix">
                      <table class="table no-mar table-striped table-hover">

    <tr>
	    <th class="dc sep-right textn span1"><?php echo __l('Select');?></th>
        <th class="dc sep-right textn span2"><?php echo __l('Actions');?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('created', __l('Created'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dl sep-right textn"><?php echo $this->Paginator->sort('name', __l('Name'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('is_active', __l('Active?'), array('class' => 'graydarkerc no-under'));?></th>
    </tr>
<?php
if (!empty($contactTypes)):
$i = 0;
foreach ($contactTypes as $contactType):
	if($contactType['ContactType']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
		$status_class = 'js-checkbox-inactive';
	endif;
?>
	<tr>
		<td class="dc grayc"><?php echo $this->Form->input('ContactType.'.$contactType['ContactType']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$contactType['ContactType']['id'], 'div' => false, 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?></td>
		<td class="dc grayc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="grayc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide"><?php echo __l('Action'); ?></span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $contactType['ContactType']['id']), array('escape' => false,'class' => 'edit', 'title' => __l('Edit')));?></li>
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $contactType['ContactType']['id']), array('escape' => false,'class' => 'js-confirm', 'title' => __l('Delete')));?></li>
			   </ul>
   	  </span>
		</td>		
		<td class="grayc dc"><?php echo $this->Html->cDateTimeHighlight($contactType['ContactType']['created']);?></td>
		<td class="grayc"><?php echo $this->Html->cText($contactType['ContactType']['name']);?></td>
		<td class="dc grayc"><?php echo $this->Html->cBool($contactType['ContactType']['is_active']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7" class="notice"><?php echo __l('No Contact Types available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>

<?php
if (!empty($contactTypes)):
        ?>
        	<div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                        <?php echo __l('Select:'); ?></span>
						 <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
						<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"}   hor-smspace grayc', 'title' => __l('Active'))); ?>
						<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"}  hor-smspace grayc', 'title' => __l('Inactive'))); ?>
						
                       
                                        
             </div><?php echo $this->Form->input('more_action_id', array('class' => 'span4 js-admin-index-autosubmit', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?></span>
            <?php endif; ?>
         </div>
          <div class="pagination top-space pull-right no-mar mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    echo $this->Form->end();
    ?>
</div>
</div>