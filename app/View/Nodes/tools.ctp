<?php $this->pageTitle = __l('Tools'); ?>
<div class="page-tools">
    <h2><?php echo __l('Tools');?></h2>
    <ul class="admin-sub-links side2-list">
    	<li><?php echo $this->Html->link(__l('Manually trigger cron'), array('controller' => 'job_orders', 'action' => 'update_status'),array('title' => __l('You can use this to update various status.This will be used in the scenario where cron is not working.'))); ?></li>
    </ul>
</div>
 