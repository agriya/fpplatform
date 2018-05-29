<div class="vocabularies form space">
  <?php echo $this->Form->create('Vocabulary', array('class' => 'form-horizontal'));?>
  
  <ul class="breadcrumb no-round top-mspace ver-space">
   <li><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users','action' => 'stats'), array('title' => __l('Dashboard')));?><span class="divider">&raquo</span></li>
  <li class="left-space"><?php echo $this->Html->link(__l('Vocabularies'), array('action' => 'index'), array('title' => __l('Vocabularies'), 'class' => 'bluec'));?><span class="divider">/</span></li>
  <li class="active"><?php echo sprintf(__l('Add %s'), __l('Vocabulary'));?></li>
  </ul>
  <div class="top-space ver-space">
    <?php
    echo $this->Form->input('title');
    echo $this->Form->input('alias');
    echo $this->Form->input('Type.Type');
    ?>
  <div class="form-actions">
    <?php echo $this->Form->submit(__l('Save'), array('class' => 'btn btn-primary')); ?>
    <?php echo $this->Html->link(__l('Cancel'), array('action' => 'index'), array('class'=>'btn btn-warning')); ?>
  </div>
  <?php echo $this->Form->end(); ?>
</div>
</div>