<?php /* SVN: $Id: admin_add.ctp 2894 2010-09-02 10:01:36Z sakthivel_135at10 $ */ ?>
<div class="projects form space">
  <?php echo $this->Form->create('SecurityQuestion', array('class' => 'form-horizontal')); ?>
  <?php echo $this->Form->input('name', array('label' => __l('Question'))); ?>
  <?php echo $this->Form->input('is_active', array('label' => __l('Active?'))); ?>
  <div>
    <?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-primary'));?>
  </div>
  <?php echo $this->Form->end();?>
</div>