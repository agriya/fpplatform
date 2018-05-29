<div class="terms form space">
<ul class="breadcrumb">
     <li><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users','action' => 'stats'), array('title' => __l('Dashboard')));?><span class="divider">&raquo</span></li>
  <li><?php echo $this->Html->link(__l('Vocabularies'), array('controller' => 'vocabularies', 'action' => 'index'),array('title' => __l('Vocabularies')));?><span class="divider">&raquo</span></li>
  <li><?php echo $this->Html->link(__l('Terms'), array('action' => 'index',$vocabularyId),array('title' => __l('Terms')));?><span class="divider">&raquo</span></li>
  <li class="active"><?php echo sprintf(__l('Edit %s'), __l('Term'));?></li>
  </ul>  
  <?php echo $this->Form->create('Term', array('url' => array('controller' => 'terms', 'action' => 'edit', $this->request->data['Term']['id'], $vocabularyId))); ?>
  <fieldset>
    <?php
    echo $this->Form->input('id');
    echo $this->Form->input('Taxonomy.parent_id', array('options' => $parentTree, 'empty' =>  __l("Please Select")));
    echo $this->Form->input('title');
    echo $this->Form->input('slug');
    ?>
  </fieldset>
  <div class="clearfix submit-block">
    <?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-primary')); ?>
    <div class="cancel-block space">
    <?php echo $this->Html->link(__l('Cancel'), array('action' => 'index', $vocabularyId), array('class'=>'btn btn-warning')); ?>
    </div>
  </div>
  <?php echo $this->Form->end(); ?>
</div>