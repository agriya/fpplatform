<div class="nodes create space">
  <div class="panel-container">
    <div id="add_form" class="tab-pane fade in active">
      <div>
        <?php foreach ($types AS $type) { ?>
          <div class="type">
            <h3><?php echo $this->Html->link($type['Type']['title'], array('action' => 'add', $type['Type']['alias'])); ?></h3>
            <p><div><?php echo $type['Type']['description']; ?></div></p>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>