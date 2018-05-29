<?php /* SVN: $Id: admin_index.ctp 127 2010-04-07 12:37:03Z senthilkumar_017ac09 $ */ ?>
<div class="hor-space js-response">
	<div class="alert alert-warning"><?php echo __l('Warning! Please edit with caution.'); ?></div>
    <div class="alert alert-info"><?php echo __l('Terminologies used in this CMS are synonymous with Drupal'); ?></div>
	<div class="tabbable ver-space sep-top top-mspace">
      <div id="list" class="tab-pane active in no-mar">
        <?php echo $this->element('admin/nodes_filter'); ?>


<?php   echo $this->Form->create('Node' , array('class' => 'normal ','action' => 'update'));
$url=(!empty($this->request->url)?$this->request->url:'');?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $url )); ?>
<div class="tab-pane active in no-mar" id="active-users">
  <div class="sep bot-mspace img-rounded clearfix">
    <table class="table no-mar table-striped table-hover">
  	  <thead>
	  <tr class="no-mar no-pad">
		<th class="dc sep-right textn span1"><?php echo __l('Select');?></th>
        <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
        <th class="sep-right textn"><?php echo $this->Paginator->sort('title', __l('Title'), array('class' => 'graydarkerc no-under')); ?></th>
          <th class="sep-right textn"><div><?php echo $this->Paginator->sort('type', __l('Type'), array('class' => 'graydarkerc no-under')); ?></div></th>
          <th class="dc sep-right textn"><div><?php echo $this->Paginator->sort('status', __l('Publish?'), array('class' => 'graydarkerc no-under')); ?></div></th>
        </tr>
      <?php
        if (!empty($nodes)):
          $rows = array();
          foreach ($nodes AS $node) {
			  if($node['Node']['status']):
						$status_class = 'js-checkbox-publish';
					else:
						$status_class = 'js-checkbox-unpublish';
					endif;
      ?>
            <tr>
              <td class="dc grayc"><?php echo $this->Form->input('Node.' . $node['Node']['id'] . '.id', array('type' => 'checkbox', 'id' => 'admin_checkbox_' . $node['Node']['id'], 'label' => '', 'div' => false,'class' => $status_class.' js-checkbox-list')); ?></td>
              <td class="dc grayc">
                <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
                  <ul class="unstyled dropdown-menu dl arrow clearfix">
                    <li>
                      <?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('controller' => 'nodes', 'action' => 'edit', $node['Node']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?>
                    </li>
                    <li>
                      <?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'nodes', 'action' => 'delete', $node['Node']['id']), array('class' => 'js-confirm', 'escape'=>false,'title' => __l('Delete')));?>
                    </li>
                    <?php echo $this->Layout->adminRowActions($node['Node']['id']);  ?>
                  </ul>
                </div>
              </td>
              <td class="grayc"><?php echo $this->Html->link($node['Node']['title'], array('controller' => 'nodes', 'action' => 'view', 'type' => $node['Node']['type'], 'slug' => $node['Node']['slug'], 'admin' => false), array('title' => $node['Node']['title'], 'class' => 'grayc'));?></td>
              <td class="grayc"><?php echo $node['Node']['type'];?></td>
              <td class="dc <?php echo (!empty($node['Node']['status'])) ? 'admin-status-1' : 'admin-status-0'; ?>">
                <?php
                    $publish = ($node['Node']['status'] == 1) ? __l('Unpublish') : __l('Publish');
                    echo $this->Html->link($this->Layout->status($node['Node']['status']) . '<span class="hide">' . $publish.'</span>', array('controller' => 'nodes', 'action' => 'update_status', $node['Node']['id'], 'status' => ($node['Node']['status'] == 1) ? 'inactive' : 'active'), array('class' => 'js-confirm js-no-pjax blackc', 'title' => $publish, 'escape' => false));?>
              </td>
            </tr>
      <?php
          }
        else:
      ?>
            <tr>
            <td colspan="5" class="grayc text-16 notice dc"> <?php echo sprintf(__l('No %s available'), __l('Nodes'));?></td>
            </tr>
      <?php
        endif;
      ?>
     <tbody>
</table>
</div>
</div>
  <div class="ver-mspace mob-dc clearfix">
    <div class="top-space pull-left dc mob-clr mob-inline clearfix">
       <div class="pull-left ver-space">
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Publish'), '#', array('class' => 'js-select {"checked":"js-checkbox-publish","unchecked":"js-checkbox-unpublish"} hor-smspace grayc', 'title' => __l('Publish'))); ?>
			<?php echo $this->Html->link(__l('Unpublish'), '#', array('class' => 'js-select {"checked":"js-checkbox-unpublish","unchecked":"js-checkbox-publish"} hor-smspace grayc', 'title' => __l('Unpublish'))); ?>
        </div>
        <div class="pull-left hor-mspace mob-no-mar">
                <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit span4', 'label' => false,  'empty' => __l('-- More actions --'))); ?>
        </div>
      </div>
      <div class="pull-right top-space">
         <?php echo $this->element('paging_links'); ?>
      </div>
	  <div class="hide">
        <?php echo $this->Form->submit('Submit');  ?>
      </div>
	  </div>
<?php echo $this->Form->end();
?>
</div>
</div>
</div>
