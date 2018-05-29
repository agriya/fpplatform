<div class="label label-info tab-head show no-round clearfix">
  <h5 class="pull-left ver-smspace textn whitec text-16"><i class="icon-bar-chart hor-smspace text-16"></i><span> Overview</span></h5>
  <div class="pull-right ver-smspace"> 
    <a href="#collapseOne" data-parent="#accordion2" id="js-drop-down" data-toggle="collapse" class="pull-right whitec accordion-toggle"><i class="icon-angle-down text-16 textb"></i></a>
	<div class="dropdown pull-right"> 
	  <a href="#" data-toggle="dropdown" class="dropdown-toggle pull-left top-smspace whitec no-under"> <i class="ver-smspace hor-space icon-wrench"></i> </a>
	  <ul class="dropdown-menu dl arrow arrow-right">
		  <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-metrics"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/charts/chart_metrics/select_range_id:lastDays";?>"><?php echo __l('Last 7 days'); ?></a> </li>
		  <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-metrics"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/charts/chart_metrics/select_range_id:lastWeeks";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
		  <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-metrics"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/charts/chart_metrics/select_range_id:lastMonths";?>"><?php echo __l('Last 3 months'); ?></a> </li>
		  <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-metrics"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/charts/chart_metrics/select_range_id:lastYears";?>"><?php echo __l('Last 3 years'); ?></a> </li>
	  </ul>
    </div>
  </div>
</div>
<div id="collapseOne" class="row-fluid  accordion-body collapse in">
  <div class="sep ver-space">
	<div class="row-fluid ver-space">
	  <?php
	  $select_range_id = (!empty($this->request->params['named']['select_range_id']))?$this->request->params['named']['select_range_id']:'lastDays';
	  if (isPluginEnabled('IntegratedGoogleAnalytics') && Configure::read('google_analytics.access_token')): ?>
		<?php  echo $this->element('chart-admin_chart_google_analytics', array('select_range_id' => $select_range_id, 'from' => 'chart_metrics', 'cache' => array('config' => 'site_element_cache_5_hours'))); ?>
	  <?php endif; ?>
	  <section class="clearfix">
	    <div class=" js-cache-load js-cache-load-admin-charts {'data_url':'admin/charts/user_engagement/select_range_id:<?php echo $select_range_id;?>/from:chart_metrics', 'data_load':'js-cache-load-admin-charts-user-engagement'}">
	    <?php  echo $this->element('chart-admin_chart_engagement', array('select_range_id' => $select_range_id, 'from' => 'chart_metrics', 'cache' => array('config' => 'site_element_cache_5_hours'))); ?>
		</div>
	  <div class="pull-left offset2 mob-clr tab-no-mar desk-no-mar js-cache-load js-cache-load-admin-charts {'data_url':'admin/charts/user_activities/select_range_id:<?php echo $select_range_id;?>/from:chart_metrics', 'data_load':'js-cache-load-admin-user-activities'}">
	    <?php echo $this->element('chart-admin_user_activities', array('select_range_id' => $select_range_id, 'from' => 'chart_metrics', 'cache' => array('config' => 'site_element_cache_5_hours')));?>
	  </div>
	  </section>
	</div>
  </div>
</div>