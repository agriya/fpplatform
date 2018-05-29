<div class="space">
  <h3><?php echo __l('Summary Statistics'); ?></h3>
  <div>
    <?php  echo $this->element('chart-admin_chart_projects_stats', array('cache' => array('config' => 'site_element_cache_15_min'))); ?>
  </div>
  <h3><?php echo __l('Price Point Statistics'); ?></h3>
  <div>
    <?php echo $this->element('chart-admin_chart_price_points', array('cache' => array('config' => 'site_element_cache_15_min'))); ?>
  </div>
</div>