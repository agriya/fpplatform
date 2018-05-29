<div class="menus form space">
  <?php echo $this->Form->create('Menu', array('url' => array('controller' => 'menus', 'action' => 'add','admin' => true),'class' => 'form-horizontal')); ?>
  <fieldset>
    <div class="panel-container">
      <div id="add_form" class="tab-pane fade in active">
        <div id="menu-basic">
          <?php
            echo $this->Form->input('title');
            echo $this->Form->input('alias');
          ?>
        </div>
        <div>
          <div class = "pull-left" >
            <?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-primary')); ?>
          </div>
          <div class = "hor-mspace hor-space pull-left" >
            <?php echo $this->Html->link(__l('Cancel'), array('controller' => 'menus', 'action' => 'index'), array('title' => __l('Cancel'),'class' => 'btn btn-warning', 'escape' => false)); ?>
          </div>
        </div>
      </div>
    </div>
  </fieldset>
  <?php echo $this->Form->end(); ?>
</div>