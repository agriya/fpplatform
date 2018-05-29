<?php $this->pageTitle = __l('Tools'); ?>
<div class="space">
  <div class="alert alert-info"><?php echo __l('When cron is not working, you may trigger it by clicking below link. For the processes that happen during a cron run, refer the ').$this->Html->link('product manual','http://dev1products.dev.agriya.com/doku.php?id=fpplatformultraplus-install#manual_cron_update_process', array('target'=>'_blank'));?></div>
  <div><?php echo $this->Html->link(sprintf(__l('Manually trigger cron to update %s status'), Configure::read('job.job_alternate_name')), array('controller' => 'job_orders', 'action' => 'update_status'), array('class' => 'btn js-confirm js-no-pjax js-tooltip tools', 'title' => sprintf(__l('You can use this to update %s status. This will be used in the scenario where cron is not working.'), Configure::read('job.job_alternate_name')))); ?></div>
</div>
<div class="space">
  <div><?php echo $this->Html->link(__l('Manually trigger cron to update daily status'), array('controller' => 'crons', 'action' => 'daily', 'admin' => false, '?r=' . $this->request->url), array('class' => 'btn js-confirm js-no-pjax js-tooltip tools', 'title' => __l('You can use this to send the invitation code to private beta subscribed users. This will be used in the scenario where cron is not working.'))); ?></div>
</div>