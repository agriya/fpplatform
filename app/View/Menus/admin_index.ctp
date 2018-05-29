<div class="hor-space js-response js-responses">
	<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo __l('Menus');?></li>
	</ul>
	<div class="alert alert-warning"><i class="icon-warning-sign"></i> <?php echo __l('Warning! Please edit with caution.'); ?></div>
		<div class="tabbable ver-space sep-top top-mspace">
	       <div id="list" class="tab-pane active in no-mar">
			  <div class="pull-right users-form tab-clr">
				  <div class="pull-right top-space top-mspace mob-clr mob-dc tab-clr">
					<?php echo $this->Html->link('<i class="icon-plus-sign"></i>'.__l('Add'), array('action' => 'add'),array('class' => 'hor-mspace bluec textb text-13', 'title' =>  __l('Add'), 'escape' => false));?>
				  </div>
				</div>
				<?php echo $this->element('paging_counter'); ?>
		   </div>
		</div>
  <div class="sep bot-mspace img-rounded clearfix">
    <table class="table no-mar table-striped table-hover">
      <thead>
        <tr>
          <th class="dc sep-right textn"><?php echo __l('Actions'); ?></th>
          <th class="sep-right textn"><div><?php echo $this->Paginator->sort('title', __l('Title'), array('class' => 'graydarkerc no-under')); ?></div></th>
          <th class="dl sep-right textn"><div><?php echo $this->Paginator->sort('alias', __l('Alias'), array('class' => 'graydarkerc no-under')); ?></div></th>
          <th class="dc sep-right textn"><div><?php echo $this->Paginator->sort('link_count', __l('Link Count'), array('class' => 'graydarkerc no-under')); ?></div></th>
        </tr>
      </thead>
      <tbody>
      <?php
        if (!empty($menus)):
          foreach ($menus AS $menu) {
      ?>
            <tr>
              <td class="span1 dc">
                <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
			<ul class="dropdown-menu arrow dl">
			<li>
                      <?php echo $this->Html->link('<i class="icon-hdd"></i>'.__l('View links'), array('controller' => 'links', 'action'=>'index', $menu['Menu']['id']), array('class' => '','escape'=>false, 'title' => __l('View links')));?>
                    </li>
                    <li>
                      <?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('controller' => 'menus', 'action'=>'edit', $menu['Menu']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?>
                    </li>
                    <li>
                      <?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'menus','action'=>'delete', $menu['Menu']['id']), array('class' => 'js-confirm delete ', 'escape'=>false,'title' => __l('Delete')));?>
                    </li>
                    <?php echo $this->Layout->adminRowActions($menu['Menu']['id']); ?>
                  </ul>
                </div>
              </td>
              <td><?php echo $this->Html->link($this->Html->cText($menu['Menu']['title'], false), array('controller' => 'links', 'action' => 'index', $menu['Menu']['id']), array('title' => $this->Html->cText($menu['Menu']['title'], false), 'class' => 'grayc'));?></td>
              <td class="dl"><?php echo $this->Html->cText($menu['Menu']['alias'], false);?></td>
              <td class="dc"><?php echo $menu['Menu']['link_count'];?></td>
            </tr>
      <?php
          }
        else:
      ?>
            <tr>
            <td colspan="5" class="grayc text-16 notice dc"> <?php echo sprintf(__l('No %s available'), __l('Menus'));?></td>
            </tr>
      <?php
        endif;
      ?>
      </tbody>
    </table>
	</div>
</div>