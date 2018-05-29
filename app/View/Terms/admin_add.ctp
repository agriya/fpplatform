<div class="terms form space">
<ul class="breadcrumb">
     <li><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users','action' => 'stats'), array('title' => __l('Dashboard')));?><span class="divider">&raquo</span></li>
  <li><?php echo $this->Html->link(__l('Vocabularies'), array('controller' => 'vocabularies', 'action' => 'index'),array('title' => __l('Vocabularies')));?><span class="divider">&raquo</span></li>
  <li><?php echo $this->Html->link(__l('Terms'), array('action' => 'index', $vocabularyId),array('title' => __l('Terms')));?><span class="divider">&raquo</span></li>
  <li class="active"><?php echo sprintf(__l('Add %s'), __l('Term'));?></li>
  </ul>   
  <?php echo $this->Form->create('Term', array('url' => array('controller' => 'terms', 'action' => 'add', $vocabulary['Vocabulary']['id']))); ?>
  <fieldset>
    <?php
    echo $this->Form->input('Taxonomy.parent_id', array('options' => $parentTree, 'empty' => __l("Please Select")));
    echo $this->Form->input('title');
    echo $this->Form->input('slug');
    ?>
  </fieldset>
  <div class="form-actions">
    <?php echo $this->Form->submit(__l('Save')); ?>
    <div class="cancel-block space">
    <?php echo $this->Html->link(__l('Cancel'), array('action' => 'index', $vocabularyId), array('class'=>'btn')); ?>
    </div>
  </div>
  <?php echo $this->Form->end(); ?>
</div>