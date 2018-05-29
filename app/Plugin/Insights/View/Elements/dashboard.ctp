<div class="block1-inner js-admin-stats-block" id="dashboard-accordion">
  <?php echo $this->element('chart-chart_transactions', array('cache' => array('config' => 'site_element_cache_15_min', 'key' => $this->Auth->user('id'))), array('plugin' => 'Insights')); ?>
  <?php echo $this->element('chart-chart_projects', array('cache' => array('config' => 'site_element_cache_15_min', 'key' => $this->Auth->user('id'))), array('plugin' => 'Insights')); ?>
  <?php echo $this->element('chart-chart_demographics', array('cache' => array('config' => 'site_element_cache_15_min', 'key' => $this->Auth->user('id'))), array('plugin' => 'Insights')); ?>
</div>