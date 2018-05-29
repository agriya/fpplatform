

<div class="contactTypes index js-response">
<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo __l('Languages'); ?></li>
	</ul>
<div class="clearfix top-space top-mspace sep-top ">

	
	<?php 
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Active) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace graydarkerc">'.__l('Active').'</dt>
						<dd title="'.$approved.'" class="text-32 graydarkerc pr hor-mspace">'.$this->Html->cInt($approved ,false).'</dd>                  	
					</dl>'
					, array('action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Active')));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Inactive) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace graydarkerc">'.__l('Inactive').'</dt>
						<dd title="'.$pending.'" class="text-32 graydarkerc pr hor-mspace">'.$this->Html->cInt($pending ,false).'</dd>                  	
					</dl>'
					, array('action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Inactive')));
				$class = (empty($this->request->params['named']['filter_id'])) ? 'active' : null;
                $count = $pending + $approved;
				echo $this->Html->link( '
					<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace graydarkerc">'.__l('Total').'</dt>
						<dd title="'.$count.'" class="text-32 graydarkerc pr hor-mspace">'.$this->Html->cInt($pending + $approved,false).'</dd>                  	
					</dl>'
					, array('action'=>'index'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Total')));
				
				?>
		</div>
		
		<div class="clearfix sep-top ver-space">
		<?php echo $this->element('paging_counter');?>
		<div class="pull-right users-form tab-clr">
			<div class="pull-left mob-clr mob-dc users-form">
			<?php echo $this->Form->create('Language', array('type' => 'get', 'class' => 'normal form-search no-mar', 'action'=>'index')); ?>
            <?php echo $this->Form->input('q', array('label' => false,'placeholder'=>'keyword')); ?>
      
			<?php echo $this->Form->submit(__l('Search'),array('class'=>'btn btn-primary'));?>
			<?php echo $this->Form->end(); ?></div>
			<div class="pull-left top-space  mob-clr mob-dc tab-clr">
			<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18 hor-space"></i>'.__l('Add'), array('action' => 'add'), array('class' => 'hor-mspace bluec textb text-13','escape'=>false,'title'=>__l('Add'))); ?>
		
		</div>
		</div></div>
	
    <?php echo $this->Form->create('Language' , array('class' => 'normal','action' => 'update')); ?>
    <?php  $url=(!empty($this->request->params['url']['url'])?$this->request->params['url']['url']:''); echo $this->Form->input('r', array('type' => 'hidden', 'value' => $url));  ?>
      <div class="tab-pane active in no-mar clearfix" id="active-users">
                    <div class="sep bot-mspace img-rounded clearfix">
                      <table class="table no-mar table-striped table-hover">

        <tr>
            <th class="dc sep-right textn span1"><?php echo __l('Select'); ?></th>
			<th class="dc sep-right textn span2"><?php echo __l('Actions');?></th>
            <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('name', __l('Name'), array('class' => 'graydarkerc no-under'));?></div></th>
            <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('iso2', __l('ISO2'), array('class' => 'graydarkerc no-under'));?></div></th>
            <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('iso3', __l('ISO3'), array('class' => 'graydarkerc no-under'));?></div></th>
            <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('is_active', __l('Active?'), array('class' => 'graydarkerc no-under')); ?></div></th>
        </tr>
        <?php
        if (!empty($languages)):
            foreach ($languages as $language):
            		if($language['Language']['is_active']):
						$status_class = 'js-checkbox-active';
					else:
						$status_class = 'js-checkbox-inactive';
					endif;
                ?>
                <tr<?php echo $class;?>>
                    <td><?php echo $this->Form->input('Language.'.$language['Language']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$language['Language']['id'], 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?></td>
					<td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="grayc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide"><?php echo __l('Action'); ?></span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $language['Language']['id']), array('escape' => false,'class' => 'edit', 'title' => __l('Edit')));?></li>
			   </ul>
   	  </span>
		</td>
                    <td class="dl grayc"><?php echo $this->Html->cText($language['Language']['name']);?></td>
                    <td class="dc grayc"><?php echo $this->Html->cText($language['Language']['iso2']);?></td>
                    <td class="dc grayc"><?php echo $this->Html->cText($language['Language']['iso3']);?></td>
					<td class="dc grayc"><?php echo $this->Html->cBool($language['Language']['is_active']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="6" class="notice"><?php echo __l('No Languages available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
    </div>
    <?php
    if (!empty($languages)) :
        ?>
        <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                        <?php echo __l('Select:'); ?></span>
                        <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
						<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-smspace grayc', 'title' => __l('Active'))); ?>
						<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-select {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-smspace grayc', 'title' => __l('Inactive'))); ?>
			 </div><?php echo $this->Form->input('more_action_id', array('class' => 'span4 js-admin-index-autosubmit span4', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?></span>
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