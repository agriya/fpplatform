<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="states index js-response">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">States       </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<div class="clearfix">
				<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Active') . '</dt><dd title="' . $active . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($active) . '</dd>  </dl>', array('controller'=>'states','action'=>'index','filter_id' => ConstMoreAction::Active), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Active'), 'escape' => false));?>
            <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? ' active' : null; ?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Inactive') . '</dt><dd title="' . $inactive . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($inactive) . '</dd>  </dl>', array('controller'=>'states','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Inactive'), 'escape' => false));?>
            <?php $class = (empty($this->request->params['named']['filter_id'])) ? ' active' : null; 
			$count = $active + $inactive;?>
			<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Total') . '</dt><dd title="' . $count . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($count) . '</dd>  </dl>', array('controller'=>'states','action'=>'index'), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Total'), 'escape' => false));?>
				</div><section class="space clearfix">
	<div class="clearfix top-space top-mspace sep-top">
		  <div class="pull-right users-form tab-clr">
		  	<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('State', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
				  <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
				<div class="submit left-space">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
            <div class="pull-right top-space top-mspace mob-clr mob-dc tab-clr">
				<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18"></i> <span class="grayc">' . __l('Add') . '</span>', array('controller' => 'states', 'action' => 'add'), array('class' => 'hor-mspace bluec textb text-13','title'=>__l('Add'), 'escape' => false)); ?>				
			</div>
		  </div>
		  <?php echo $this->element('paging_counter'); ?>
		</div>
	</section> 
					
			</div>			
 <?php  echo $this->Form->create('State' , array('action' => 'update','class'=>'normal'));?>
 <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
   <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
                <th class="dc sep-right span2 textn"><?php echo __l('Select'); ?></th>
                <th class="dc sep-right span2 textn"><?php echo __l('Actions');?></th>
                <th class="dl graydarkc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort( 'Country.name',__l('Country'), array('class' => 'graydarkerc no-under'));?></div></th>
                <th class="dl graydarkc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort( 'name',__l('Name'), array('class' => 'graydarkerc no-under'));?></div></th>
                <th class="dl graydarkc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort( 'code',__l('Code'), array('class' => 'graydarkerc no-under'));?></div></th>
                <th class="dc graydarkc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort( 'adm1code',__l('Adm1code'), array('class' => 'graydarkerc no-under'));?></div></th>
            </tr>
            <?php
                if (!empty($states)):
                $i = 0;
                    foreach ($states as $state):
                        $class = null;
                        $active_class = '';
                        if ($i++ % 2 == 0) :
                            $class = 'altrow';
                        endif;
                        if($state['State']['is_approved'])  :
                            $status_class = 'js-checkbox-active';
                        else:
                          $active_class = ' disable';
                            $status_class = 'js-checkbox-inactive';
                        endif;
                        ?>
                         <tr class="<?php echo $class.' '. $active_class;?>">
                            <td class="select dc">
                                <?php
                                    echo $this->Form->input('State.'.$state['State']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$state['State']['id'],'label' => "" , 'class' => $status_class.' js-checkbox-list'));
                                ?>
                            </td>
                            <td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide"><?php echo __l('Action'); ?></span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
								<?php if($state['State']['is_approved']):?>
        			<li><?php echo $this->Html->link('<i class="icon-thumbs-down"></i>'.__l('Inactive'), array('action' => 'update_status', $state['State']['id'],'disapprove'), array('escape' => false,'class' => 'edit js-confirm', 'title' => __l('Inactive')));?></li>
					<?php else: ?>
					<li><?php echo $this->Html->link('<i class="icon-thumbs-up"></i>'.__l('Active'), array('action' => 'update_status', $state['State']['id'],'approve'), array('escape' => false,'class' => 'delete js-confirm', 'title' => __l('Active')));?></li>
						<?php endif; ?>
					<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $state['State']['id']), array('escape' => false,'class' => 'edit js-confirm', 'title' => __l('Edit')));?></li>
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $state['State']['id']), array('escape' => false,'class' => 'delete js-confirm', 'title' => __l('Delete')));?></li>
			   </ul>
							 </span>
                            </td>
                            <td class="dl"><?php echo $this->Html->cText($state['Country']['name']);?></td>
                            <td class="dl"><?php echo $this->Html->cText($state['State']['name']);?></td>
                            <td class="dc"><?php echo $this->Html->cText($state['State']['code']);?></td>
                            <td class="dc"><?php echo $this->Html->cText($state['State']['adm1code']);?></td>
                        </tr>
                        <?php
                    endforeach;
            else:
                ?>
                <tr>
                    <td colspan="6"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No States available');?></p></div></td>
                </tr>
                <?php
            endif;
            ?>
        </table>
        <?php
         if (!empty($states)) : ?>
		 <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                        <?php echo __l('Select:'); ?></span>
                        <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
						<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select js-no-pjax  {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-smspace grayc', 'title' => __l('Active'))); ?>
						<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-select js-no-pjax  {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-smspace grayc', 'title' => __l('Inactive'))); ?>
                                          
             </div><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?></span>
            <?php endif; ?>
         </div>
          <div class="pagination pull-right no-mar mob-clr dc">
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