<?php
  $width = 620;
  if (!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {
    $parent = '#accordion-admin-dashboard';
    $width = 620;
  }
?>
<div class="js-cache-load-admin-charts-transaction">
<div class="js-overview-transaction">
  <div class="accordion-group">
    <div class="accordion-heading " >
      <div class="no-mar no-bor clearfix box-head bootstro" data-bootstro-step="11" data-bootstro-content="<?php echo __l("User registration rate, Site revenue, Projects posted rate, Projects Fund rate in selected period. By default it shows only last 7 days details. To see the last 4 weeks, last 3 months, last 3 years details please select your desired period in the above setting icon. Also display the complete details of site revenue / project funded. By default it shows only last 7 days details. To see the last 7 days, last 4 weeks, last 3 months, last 3 years details please select the desired period in the above setting icon.");?>" data-bootstro-placement='bottom' data-bootstro-width="600px"  >
        <h5>
          <span class="space pull-left">
            <i class="icon-bar-chart no-bg"></i>
            <?php echo __l('Revenue'); ?>
          </span>
		  </h5>
		   <div class="span3 pull-right">
          <a class="accordion-toggle js-toggle-icon js-checking js-no-pjax grayc no-under clearfix pull-right" href="#overview" data-parent="#accordion-admin-dashboard" data-toggle="collapse">
            <i class="icon-chevron-down"></i>
          </a>
          <div class="dropdown pull-right top-mspace">
            <a class="dropdown-toggle js-no-pjax js-overview grayc no-under" data-toggle="dropdown" href="#">
              <i class="icon-wrench"></i>
            </a>
            <ul class="dropdown-menu pull-right arrow arrow-right">
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link-char js-no-pjaxt {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/chart_transactions/select_range_id:lastDays/";?>"><?php echo __l('Last 7 days'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>> <a class='js-link-chart js-no-pjax {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/insights/chart_transactions/select_range_id:lastWeeks/";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>> <a class='js-link-chart js-no-pjax {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/insights/chart_transactions/select_range_id:lastMonths/";?>"><?php echo __l('Last 3 months'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>> <a class='js-link-chart js-no-pjax {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/chart_transactions/select_range_id:lastYears/";?>"><?php echo __l('Last 3 years'); ?></a> </li>
            </ul>
			</div>
			</div>
		</div>
    </div>
    <div id="overview" class="accordion-body in collapse over-hide">
      <div class="accordion-inner" id="revenue">
        <?php
          $div_class = "js-load-line-graph ";
        ?>
        <div class="row-fluid ver-space ">
          <section class="span12">
            <div class="<?php echo $div_class;?> space dc {'chart_type':'LineChart', 'data_container':'transactions_line_data', 'chart_container':'transactions_line_chart', 'chart_title':'<?php echo __l('Transactions') ;?>', 'chart_y_title': '<?php echo __l('Value');?>'}">
              <div id="transactions_line_chart" class="admin-dashboard-chart"></div>
			  <div class="hide">
              <table id="transactions_line_data" class="table table-striped table-bordered table-condensed">
                <thead>
                  <tr>
                    <th>Period</th>
                    <?php foreach($chart_transactions_periods as $_period): ?>
                      <th><?php echo $_period['display']; ?></th>
                    <?php endforeach; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($chart_transactions_data as $display_name => $chart_data): ?>
                    <tr>
                      <th><?php echo $display_name; ?></th>
                      <?php foreach($chart_data as $val): ?>
                        <td><?php echo $val; ?></td>
                      <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
			</div>
          </section>
          <section class="span12 sep">
            <div class="<?php echo $div_class;?> space dc {'chart_width':'<?php echo $width; ?>', 'chart_type':'LineChart', 'data_container':'job_order_line_data', 'chart_container':'job_order_line_chart', 'chart_title':'<?php echo sprintf(__l('%s Orders'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)) ;?>', 'chart_y_title': '<?php echo sprintf(__l('%s Ordered'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?>'}">
              <div id="job_order_line_chart" class="admin-dashboard-chart"></div>
			  <div class="hide">
              <table id="job_order_line_data" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <tr>
                    <th>Period</th>
                    <?php foreach($chart_job_order_periods as $_period): ?>
                      <th><?php echo $_period['display']; ?></th>
                    <?php endforeach; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($chart_job_order_data as $display_name => $chart_data): ?>
                    <tr>
                      <th><?php echo $display_name; ?></th>
                      <?php foreach($chart_data as $val): ?>
                        <td><?php echo $val; ?></td>
                      <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>