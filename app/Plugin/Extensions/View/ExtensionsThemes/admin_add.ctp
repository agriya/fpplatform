<div class="extensions-themes space">
  <?php
    echo $this->Form->create('Theme', array(
      'url' => array(
        'controller' => 'extensions_themes',
        'action' => 'add',
      ),
      'type' => 'file',
	  'class'=> 'form-horizontal'
	  ));
  ?>
    <ul class="breadcrumb">
    <li><?php echo $this->Html->link(__l('Themes'), array('action' => 'index'),array('title' => __l('Themes')));?><span class="divider">&raquo</span></li>
    <li class="active"><?php echo __l('Upload Theme');?></li>
  </ul>

  <div class="panel-container">
    <div id="add_form" class="tab-pane fade in active">

  <?php
    echo $this->Form->input('Theme.file', array('label' => __l('Upload'), 'type' => 'file',));
  ?>
  </div>
  </div>
  <div class="clearfix">

    <div class="form-actions">
    <?php echo $this->Form->submit(__l('Upload'), array('class' => 'btn btn-primary')); ?>
    <?php echo $this->Html->link(__l('Cancel'), array('action' => 'index'), array('class'=>'btn btn-warning')); ?>
  </div>


  </div>
    <?php echo $this->Form->end();?>
</div>
