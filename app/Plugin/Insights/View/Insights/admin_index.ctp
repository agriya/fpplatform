 <div class="space accordion" id="accordion-admin-dashboard1">
	<div class="js-cache-load js-cache-load-admin-charts {'data_url':'admin/insights/chart_transactions', 'data_load':'js-cache-load-admin-charts-transaction'}">
		 <?php echo $this->element('chart-admin_chart_transactions', array('cache' => array('config' => 'site_element_cache_5_hours'), 'role_id'=> ConstUserTypes::User)); ?>
	 </div>
 </div>
 <div class="space accordion" id="accordion-admin-dashboard2">
	<div class="js-cache-load js-cache-load-admin-charts {'data_url':'admin/insights/chart_users', 'data_load':'js-cache-load-admin-charts-users'}">
		<?php echo $this->element('chart-admin_chart_users', array('cache' => array('config' => 'site_element_cache_5_hours'), 'role_id' => ConstUserTypes::User)); ?>
	</div>
</div>
  
<div class="space accordion" id="accordion-admin-dashboard3">
	<div class="js-cache-load js-cache-load-admin-charts {'data_url':'admin/insights/user_activities_insights', 'data_load':'js-cache-load-admin-charts-user-activities'}">
		<?php echo $this->element('chart-admin_chart_user_activities', array('cache' => array('config' => 'site_element_cache_5_hours'), 'role_id' => ConstUserTypes::User)); ?>
	</div>

</div>