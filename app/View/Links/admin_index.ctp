<div class="links index space">
  <ul class="breadcrumb">
    <li><?php echo $this->Html->link(__l('Links'), array('action' => 'index'), array('title' => __l('Links')));?><span class="divider">/</span></li>
    <li class="active"><?php echo __l('Add');?></li>
  </ul>
  <div class="alert alert-warning"><i class="icon-warning-sign"></i> <?php echo __l('Warning! Please edit with caution.'); ?></div>
  		<div class="tabbable ver-space sep-top top-mspace">
	       <div id="list" class="tab-pane active in no-mar">
			  <div class="pull-right users-form tab-clr">
				  <div class="pull-right top-space top-mspace mob-clr mob-dc tab-clr">
					<?php echo $this->Html->link('<i class="icon-plus-sign"></i>'.__l('Add'), array('action' => 'add', $menu['Menu']['id']),array('class' => 'hor-mspace bluec textb text-13', 'title' =>  __l('Add'), 'escape' => false));?>
				  </div>
				</div>
		   </div>
		</div>
  <?php echo $this->Form->create('Link', array('url' => array('controller' => 'links','action' => 'update'))); ?>
  <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <div class="sep bot-mspace img-rounded clearfix">
    <table class="table no-mar table-striped table-hover">
      <tr>
        <th class="dc sep-right textn"><?php echo __l('Select'); ?></th>
        <th class="dc sep-right textn"><?php echo __l('Actions'); ?></th>
        <th class="sep-right textn"><?php echo __l('Title'); ?></th>
        <th class="dc sep-right textn"><?php echo __l('Publish?'); ?></th>
      </tr>
    <?php
      if (!empty($linksTree)):
        foreach ($linksTree AS $linkId => $linkTitle) {
			if($linksStatus[$linkId] ):
						$status_class = 'js-checkbox-publish';
					else:
						$status_class = 'js-checkbox-unpublish';
					endif;
    ?>
      <tr>
        <td class="span1 dc"><?php echo $this->Form->input('Link. ' . $linkId . '.id', array('type' => 'checkbox', 'id' => "admin_checkbox_" . $linkId, 'div' => false, 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?></td>
        <td class="span1 dc">
          <div class="dropdown">
            <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog grayc text-20 dropdown-toggle js-no-pjax"><span class="hide"><?php echo __l('Action'); ?></span></a>
            <ul class="unstyled dropdown-menu dl arrow clearfix">
              <li>
                <?php echo $this->Html->link('<i class="icon-arrow-up"></i>'.__l('Move Up'), array('controller' => 'links', 'action'=>'moveup', $linkId), array('class' => 'js-confirm move-up', 'escape' => false, 'title' => __l('Move Up')));?>
              </li>
              <li>
                <?php echo $this->Html->link('<i class="icon-arrow-down"></i>'.__l('Move Down'), array('controller' => 'links', 'action'=>'movedown', $linkId), array('class' => 'js-confirm move-down', 'escape' => false, 'title' => __l('Move Down')));?>
              </li>
              <li>
                <?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('controller' => 'links', 'action'=>'edit', $linkId), array('escape' => false, 'title' => __l('Edit')));?>
              </li>
              <li>
                <?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'links', 'action'=>'delete', $linkId), array('class' => 'js-confirm', 'escape' => false, 'title' => __l('Delete')));?>
              </li>
              <?php echo $this->Layout->adminRowActions($linkId); ?>
            </ul>
          </div>
        </td>
        <td><?php echo $this->Html->cText($linkTitle);?></td>
        <td class="span1 dc"><?php echo $this->Html->link($this->Layout->status($linksStatus[$linkId]), array('controller' => 'links', 'action' => 'update_status', $linkId, 'status' => ($linksStatus[$linkId] == 1) ? 'inactive': 'active', 'menu_id' => $menu['Menu']['id']), array('class' => 'no-under grayc', 'title' => $this->Html->cText($linkTitle, false), 'escape' => false));?></td>
      </tr>
    <?php
        }
      else:
    ?>
      <tr>
        <td colspan="5" class="grayc text-16 notice dc"> <?php echo sprintf(__l('No %s available'), __l('Links'));?></td>
      </tr>
    <?php
      endif;
    ?>
    </table>
  </div>
   <div class="ver-mspace mob-dc clearfix">
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
    <div class="hide">
      <?php echo $this->Form->submit('Submit');  ?>
    </div>
  <?php
  echo $this->Form->end();
  ?>
</div>