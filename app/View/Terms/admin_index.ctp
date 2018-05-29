<div class="terms index space">
<ul class="breadcrumb">
     <li><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users','action' => 'stats'), array('title' => __l('Dashboard')));?><span class="divider">&raquo</span></li>
  <li><?php echo $this->Html->link(__l('Vocabularies'), array('action' => 'index'), array('title' => __l('Vocabularies')));?><span class="divider">&raquo</span></li>
  <li class="active"><?php echo __l('Terms');?></li>
</ul>
  <div class="alert alert-warning"><i class="icon-warning-sign"></i> <?php echo __l('Warning! Please edit with caution.'); ?></div>
<section class="space">
<table class="table table-striped table-bordered table-condensed table-hover no-mar">
  <tr>
    <th class="dc"><?php echo __l('Actions'); ?></th>
    <th><?php echo __l('Title'); ?></th>
    <th><?php echo __l('Slug'); ?></th>
  </tr>
  <?php
    if (!empty($termsTree)):
    foreach ($termsTree AS $id => $title) {
  ?>
    <tr>
    <td class="span1 dc">
		<div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
			<ul class="dropdown-menu arrow dl">
		      <li><?php echo $this->Html->link('<i class="icon-arrow-up"></i>'.__l('Move Up'), array('controller' => 'terms', 'action' => 'moveup', $id, $vocabulary['Vocabulary']['id']), array('class' => 'js-confirm', 'title' => __l('Move Up'),'escape' => false));?></li>
		      <li><?php echo $this->Html->link('<i class="icon-arrow-down"></i>'.__l('Move Down'), array('controller' => 'terms', 'action' => 'movedown', $id, $vocabulary['Vocabulary']['id']), array('class' => 'js-confirm', 'title' => __l('Move Down'),'escape' => false));?></li>
		      <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('controller' => 'terms', 'action' => 'edit', $id, $vocabulary['Vocabulary']['id']), array('title' => __l('Edit'), 'escape' => false));?></li>
		      <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'terms', 'action' => 'delete', $id, $vocabulary['Vocabulary']['id']), array('class' => 'js-confirm', 'title' => __l('Delete'),'escape' => false));?></li>
		      <?php echo $this->Layout->adminRowActions($id);  ?>
			</ul>
		</div>
    </td>
    <td><?php echo $this->Html->cText($title);?></td>
    <td><?php echo $this->Html->cText($terms[$id]['slug']);?></td>
    </tr>
  <?php
    }
    else:
  ?>
  <tr>
    <td colspan="5" class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo sprintf(__l('No %s available'), __l('Terms'));?></td>
  </tr>
  <?php
    endif;
  ?>
  </table>
  </section>
</div>