<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="contactTypes index js-response">
<div class="clearfix top-space top-mspace sep-top ">

	<div class="clearfix">
				<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Active') . '</dt><dd title="' . $approved . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($approved ,false) . '</dd>  </dl>', array('action'=>'index','filter_id' => ConstMoreAction::Active), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Active'), 'escape' => false));?>
            <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Inactive') . '</dt><dd title="' . $pending . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($pending) . '</dd>  </dl>', array('action'=>'index','filter_id' => ConstMoreAction::Inactive), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Inactive'), 'escape' => false));?>
            <?php $class = (empty($this->request->params['named']['filter_id'])) ? ' active' : null; 
			$count = $approved + $pending;?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Total') . '</dt><dd title="' . $count . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($count) . '</dd>  </dl>', array('action'=>'index'), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Total'), 'escape' => false));?>
				</div>

		</div>
		
		<div class="clearfix sep-top">
		<?php echo $this->element('paging_counter');?>
		<div class="pull-right span10 users-form tab-clr">
			
			<div class="pull-right top-space  mob-clr mob-dc tab-clr">
			<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18 hor-space"></i>'.__l('Add'), array('action' => 'add'), array('class' => 'hor-mspace bluec textb text-13','escape'=>false,'title'=>__l('Add'))); ?>
		
		</div>
		</div></div>
   
  <?php echo $this->Form->create('RequestFlagCategory' , array('class' => 'normal','action' => 'update')); ?>
 <?php  $url=(!empty($this->request->url)?$this->request->url:''); echo $this->Form->input('r', array('type' => 'hidden', 'value' => $url));  ?>
 <div class="tab-pane active in no-mar clearfix" id="active-users">
                    <div class="sep bot-mspace img-rounded clearfix">
                      <table class="table no-mar table-striped table-hover">
                      <thead>
	<tr class="no-mar no-pad">
       <th class="dc sep-right textn span1"><?php echo __l('Select');?></th>
        <th class="dc sep-right textn span2"><?php echo __l('Actions');?></th>

            <th class="sep-right textn"><?php echo $this->Paginator->sort('name', __l('Name'), array('class' => 'graydarkerc no-under'));?></th>
            <th class="dc sep-right textn"><?php echo $this->Paginator->sort('request_flag_count', requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps).' '.__l('Flags'), array('class' => 'graydarkerc no-under'));?></th>
			<th class="dc sep-right textn"><?php echo $this->Paginator->sort('is_active', __l('Active?'), array('class' => 'graydarkerc no-under')); ?></th>
        </tr>
        </thead>
<?php
if (!empty($requestFlagCategories)):

$i = 0;
foreach ($requestFlagCategories as $requestFlagCategory):
	  if($requestFlagCategory['RequestFlagCategory']['is_active']):
            $status_class = 'js-checkbox-active';
       else:
       		$status_class = 'js-checkbox-inactive';
      	endif;
 ?>
  <tr>
                    <td class="dc grayc"><?php echo $this->Form->input('RequestFlagCategory.'.$requestFlagCategory['RequestFlagCategory']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$requestFlagCategory['RequestFlagCategory']['id'], 'label' => '', 'div' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
                   <td class="dc grayc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="grayc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide"><?php echo __l('Action'); ?></span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('controller' => 'request_flag_categories', 'action' => 'edit', $requestFlagCategory['RequestFlagCategory']['id']), array('escape' => false,'class' => 'edit', 'title' => __l('Edit')));?></li>
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'request_flag_categories', 'action' => 'delete', $requestFlagCategory['RequestFlagCategory']['id']), array('escape' => false,'class' => 'js-confirm', 'title' => __l('Delete')));?></li>
			   </ul>
   	  </span>
		</td>
                    <td><?php echo $this->Html->cText($requestFlagCategory['RequestFlagCategory']['name']);?></td>
                    <td class="dc grayc">
						<?php
							if(!empty($requestFlagCategory['RequestFlag'])):
								echo $this->Html->link($this->Html->cInt(count($requestFlagCategory['RequestFlagCategory']), false), array('controller' => 'request_flags', 'action' => 'index', 'request_flag_category_id ' => $requestFlagCategory['RequestFlagCategory']['id']));
							else:
								echo '0';
							endif;
						?>
					</td>
					<td class="dc grayc"><?php echo $this->Html->cBool($requestFlagCategory['RequestFlagCategory']['is_active']);?></td>
</tr>
  
  
  
    <?php
            endforeach;
        else:
            ?>
            <tr>
          <td colspan="5" class="notice text-16 grayc dc"><?php echo __l('No').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.__l('Flag Categories available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
</div>
  <?php
    if (!empty($requestFlagCategories)):
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
          <div class="pagination pull-right no-mar mob-clr dc top-space">
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
