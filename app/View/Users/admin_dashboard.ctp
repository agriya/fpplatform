<div class="js-response js-responses">
    <div class="js-pagination refresh-block">
    <?php
    echo $this->Html->link(__l('Refresh'), array('controller' => 'users', 'action' => 'admin_dashboard','refresh'),array('class' => 'refresh'));
    ?>
    </div>
	<?php echo $this->element('admin_stats-dashboard', array('cache' => array('time' => '1 hour')));?>
</div>