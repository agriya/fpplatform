<div class="contactTypes index js-response">
<ul class="breadcrumb">
  <li><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users','action' => 'stats'), array('title' => __l('Dashboard')));?><span class="divider">&raquo</span></li>
  <li class="active"><?php echo __l('Terms');?></li>
</ul>
<div class="clearfix top-space top-mspace sep-top">
<div class="pull-right">
	<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18 hor-space"></i>'.__l('Add'), array('action' => 'add'), array('class' => 'hor-mspace bluec textb text-13','escape'=>false,'title'=>__l('Add'))); ?>
</div>
<?php echo $this->element('paging_counter');?>
</div>
 <section class="space">
  <table class="table table-striped table-hover sep">
  <thead>
    <tr>
    <th class="dc sep-right textn span1"><?php echo __l('Actions'); ?></th>
    <th class="dl sep-right textn"><div><?php echo $this->Paginator->sort('title', __l('Title'), array('class' => 'graydarkerc no-under')); ?></div></th>
    <th class="dl sep-right textn"><div><?php echo $this->Paginator->sort('alias', __l('Alias'), array('class' => 'graydarkerc no-under')); ?></div></th>
    </tr>
  </thead>
  <tbody>
  <?php
    if (!empty($vocabularies)):
    foreach ($vocabularies AS $vocabulary) {
  ?>
    <tr>
    <td class="grayc dc span1">
      <div class="dropdown">
       <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog grayc text-20 dropdown-toggle"><span class="hide"><?php echo __l('Action'); ?></span></a>
      <ul class="unstyled dropdown-menu dl arrow clearfix">
       <li>
         <?php echo $this->Html->link('<i class="icon-tasks"></i>'.__l('View Terms'), array('controller' => 'terms', 'action' => 'index', $vocabulary['Vocabulary']['id']), array('class' => '','escape'=>false, 'title' => __l('View Terms')));?>
      </li>
      <li>
      <?php echo $this->Html->link('<i class="icon-arrow-up"></i>'.__l('Move Up'), array('controller' => 'vocabularies', 'action' => 'moveup', $vocabulary['Vocabulary']['id']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Move Up')));?>
      </li>
      <li>
            <?php echo $this->Html->link('<i class="icon-arrow-down"></i>'.__l('Move Down'), array('controller' => 'vocabularies', 'action' => 'movedown', $vocabulary['Vocabulary']['id']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Move Down')));?>
      </li>
      <li>
         <?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array( 'action'=>'edit', $vocabulary['Vocabulary']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?>
      </li>
      <li>
            <?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete',$vocabulary['Vocabulary']['id']), array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
      </li>
      <?php echo $this->Layout->adminRowActions($vocabulary['Vocabulary']['id']);  ?>
      </ul>
     </div>
     </td>
    <td class="grayc"><?php echo $this->Html->cText($vocabulary['Vocabulary']['title']);?></td>
    <td class="grayc"><?php echo $this->Html->cText($vocabulary['Vocabulary']['alias']);?></td>
    </tr>
  <?php
    }
    else:
  ?>
  <tr>
    <td colspan="5" class="grayc text-16 notice dc"><?php echo sprintf(__l('No %s available'), __l('Vocabularies'));?></td>
  </tr>
  <?php
    endif;
  ?>
  </tbody>
  </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
  <div class="pull-right">
    <?php echo $this->element('paging_links'); ?>
  </div>
  </section>
</div>