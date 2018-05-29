<div class="hor-space js-response js-responses">
	<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo __l('Security Questions');?></li>
	</ul>
		<div class="tabbable ver-space sep-top top-mspace">
		  <div id="list" class="tab-pane active in no-mar">
	        <div class="clearfix">
				<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? ' active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Active') . '</dt><dd title="' . $approved . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($approved) . '</dd>  </dl>', array('action'=>'index','filter_id' => ConstMoreAction::Active), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Active'), 'escape' => false));?>
				<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? ' active' : null; ?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Inactive') . '</dt><dd title="' . $pending . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($pending) . '</dd>  </dl>', array('controller'=>'security_questions','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => 
				__l('Inactive'), 'escape' => false));?>
				<?php $class = (empty($this->request->params['named']['filter_id'])) ? ' active' : null; 
				$count = $pending + $approved;?>
				<?php echo $this->Html->link('<dl class="dc list list-big top-mspace users' . $class . ' mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('All') . '</dt><dd title="' . $count . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($count) . '</dd>  </dl>', array('controller'=>'security_questions','action'=>'index'), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('All'), 'escape' => false));?>
			</div>
			<div class="clearfix top-space top-mspace sep-top">
				<div class="pull-right tab-clr">
					<div class="pull-right top-space top-mspace mob-clr mob-dc tab-clr">
						<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18"></i> <span class="grayc">' . __l('Add') . '</span>', array('controller' => 'security_questions', 'action' => 'add'), array('class' => 'hor-mspace bluec textb text-13','title'=>__l('Add'), 'escape' => false)); ?>
					</div>
				</div>
				<?php echo $this->element('paging_counter'); ?>
			</div>
		  </div>
	  </div>
<?php echo $this->Form->create('SecurityQuestion', array('action' => 'update', 'method' => 'post')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="sep bot-mspace img-rounded clearfix">
<table class="table no-mar table-striped table-hover">
    <tr>
      <th class="select span1 dc sep-right textn"><div><?php echo __l('Select'); ?></div> </th>
      <th class="dc sep-right textn"><div><?php echo __l('Actions'); ?></div> </th>
      <th class="dc sep-right textn"><div><?php echo $this->Paginator->sort('created', __l('Created'), array('class' => 'graydarkerc no-under'));?></div></th>
      <th class="d1 sep-right textn"><div><?php echo $this->Paginator->sort('name', __l('Question'), array('class' => 'graydarkerc no-under'));?></th>
	  <th class="dc sep-right textn"><?php echo $this->Paginator->sort('is_active', __l('Active?'), array('class' => 'graydarkerc no-under')); ?></th>
    </tr>
	<?php
if (!empty($questions)):
	foreach ($questions as $question): ?>
      <?php
		if($question['SecurityQuestion']['is_active'] == '1')  :
        $status_class = 'js-checkbox-active';
		$disabled = '';
		else:
          $status_class = 'js-checkbox-inactive';
          $disabled = 'class="disabled"';
          endif;
      ?>
      <tr <?php echo $disabled; ?>>
        <td class="dc grayc"><?php echo $this->Form->input('SecurityQuestion.'.$question['SecurityQuestion']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$question['SecurityQuestion']['id'], 'label' => '', 'div' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
        <td class="span1 dc grayc">
          <div class="dropdown">
            <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog text-20 grayc dropdown-toggle js-no-pjax"><span class="hide"><?php echo __l('Action'); ?></span></a>
            <ul class="unstyled dropdown-menu dl arrow clearfix">
              <li><?php echo $this->Html->link('<i class="icon-edit"></i>' . __l('Edit'), array('action' => 'edit', $question['SecurityQuestion']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'), 'escape' => false));?></li>
              <?php echo $this->Layout->adminRowActions($question['SecurityQuestion']['id']);  ?>
            </ul>
          </div>
        </td>
        <td class="dc grayc"><?php echo $this->Html->cDateTimeHighlight($question['SecurityQuestion']['created']);?></td>
        <td class="grayc"><?php echo $question['SecurityQuestion']['name']; ?></td>
		<td class="dc grayc"><?php echo $this->Html->cBool($question['SecurityQuestion']['is_active']);?></td>
      </tr>
    <?php
    endforeach;
else:
?>
	<tr>
		<td colspan="14" class="grayc notice text-16 dc"><?php echo __l('No Security Questions available');?></td>
	</tr>
<?php
endif;
?>
  </table>
</div>
  <?php if (!empty($questions)) : ?>
  <div class="ver-mspace mob-dc clearfix">
    <div class="top-space pull-left dc mob-clr mob-inline clearfix admin-select-block">
       <div class="pull-left ver-space">
			<?php echo __l('Select:'); ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-select {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-smspace grayc', 'title' => __l('Inactive'))); ?>
			<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-smspace grayc', 'title' => __l('Active'))); ?>
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
<?php endif;
echo $this->Form->end();
?>
</div>
<?php echo $this->Form->end(); ?>
</div>