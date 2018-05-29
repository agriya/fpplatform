<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="countries index js-response">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Countries       </li>
            </ul> 
<div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">            
   <section class="space clearfix">
	<div class="clearfix top-space top-mspace">
		  <div class="pull-right users-form tab-clr">
		  	<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('Country', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
				  <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
				<div class="submit left-space">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
            <div class="pull-right top-space top-mspace mob-clr mob-dc tab-clr">
				<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18"></i> <span class="grayc">' . __l('Add') . '</span>', array('controller' => 'countries', 'action' => 'add'), array('class' => 'hor-mspace bluec textb text-13','title'=>__l('Add'), 'escape' => false)); ?>				
			</div>
		  </div>
		  <?php echo $this->element('paging_counter'); ?>
		</div>
	</section>         
            
            <?php echo $this->Form->create('Country' , array('action' => 'update','class'=>'normal'));?>
            <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
           <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
      <thead>
        <tr class="no-pad no-mar">
          <th rowspan="2" class="select span1 dc grayc sep-right textn"><?php echo __l('Select');?></th>
          <th rowspan="2" class="dc grayc sep-right textn"><?php echo __l('Actions');?></th>
          <th rowspan="2" class="dl sep-right textn"><div><?php echo $this->Paginator->sort('name', '', array('class' => 'grayc no-under'));?></div></th>
          <th rowspan="2" class="dl sep-right textn"><div><?php echo $this->Paginator->sort('fips_code', '', array('class' => 'grayc no-under'));?></div></th>
          <th rowspan="2" class="dl sep-right textn"><div><?php echo $this->Paginator->sort('iso_alpha2', '', array('class' => 'grayc no-under'));?></div></th>
          <th rowspan="2" class="dl sep-right textn"><div><?php echo $this->Paginator->sort('iso_alpha3', '', array('class' => 'grayc no-under'));?></div></th>
          <th rowspan="2" class="dc sep-right textn"><div><?php echo $this->Paginator->sort('iso_numeric', '', array('class' => 'grayc no-under'));?></div></th>
          <th rowspan="2" class="dl sep-right textn"><div><?php echo $this->Paginator->sort('capital', '', array('class' => 'grayc no-under'));?></div></th>
          <th colspan="2" class="dc graydarkc sep-right textn"><?php echo __l('Currency', '', array('class' => 'grayc no-under'));?></th>
        </tr>
        <tr>
          <th class="dl grayc sep-right textn"><div><?php echo $this->Paginator->sort('currency',__l('Name'), array('class' => 'grayc no-under'));?></div></th>
          <th class="dl grayc sep-right textn"><div><?php echo $this->Paginator->sort('currency_code',__l('Code'), array('class' => 'grayc no-under'));?></div></th>
        </tr>
      </thead>
				<tbody>
                <?php
                if (!empty($countries)):
                    $i = 0;
                    foreach ($countries as $country):
                        $class = null;
                         $active_class = '';
                        if ($i++ % 2 == 0) :
                             $class = 'altrow';
                        endif;
                        ?>
          <tr>
            <td class="select dc">
              <?php echo $this->Form->input('Country.'.$country['Country']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$country['Country']['id'],'label' => '' , 'class' => 'js-checkbox-list')); ?>
            </td>
            <td class="span1 dc">
				<div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
					<ul class="dropdown-menu arrow dl">
	                  <li>
		                <?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array( 'action'=>'edit', $country['Country']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?>
			          </li>
				      <li>
					    <?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), Router::url(array('action'=>'delete',$country['Country']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
						<?php echo $this->Layout->adminRowActions($country['Country']['id']);?>
	                  </li>
		            <?php echo $this->Layout->adminRowActions($country['Country']['id']); ?>
                  </ul>
              </div>
            </td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['name']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['fips_code']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['iso_alpha2']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['iso_alpha3']);?></td>
            <td class="dc"><?php echo $this->Html->cText($country['Country']['iso_numeric']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['capital']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['currencyname']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['currency']);?></td>
          </tr>
                        <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td colspan="19"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Countries available');?></p></div></td>
                    </tr>
                    <?php
                endif;
                ?></tbody>
            </table>
            <?php if (!empty($countries)): ?>
           <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                <?php echo __l('Select:'); ?>
				</span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
				
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