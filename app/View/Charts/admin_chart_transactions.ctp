<div class="clearfix js-responses admin-chart-block js-cache-load-admin-charts-transactions">
<?php
	$arrow = '<i class="pull-right icon-chevron-down"></i>';
	if (isset($this->request->params['named']['is_ajax_load'])) {
	 $arrow = '<i class="pull-right icon-chevron-up"></i>';
	}
?>
  <div class="page-title-info clearfix box-head bootstro" data-bootstro-step="12" data-bootstro-content="<?php echo __l("A page view is an instance of a page being loaded by a browser. The Page views metric is the total number of pages viewed; repeated views of a single page are also counted. Visitors is number of user visit the site. Bounces represents the percentage of visitors who enter the site and 'bounce' (leave the site) rather than continue viewing other pages within the site. Also it shows the graphical representation of the already existing user's visit and new user visit rate. Recent Activity shows the last 3 site activities. To see the list of all activities please click 'More' button. User engagment shows current status site users. An overview of site activities such as registrations, logins, posts, funfs, revenue and performance comparison with previous period");?>" data-bootstro-placement='bottom' data-bootstro-width="600px" >
    <h2 class="chart-dashboard-title ribbon-title clearfix"> <?php echo __l('Overview'); ?> <span class="js-chart-showhide  {'chart_block':'admin-dashboard-transactions', 'dataloading':'div.js-cache-load-admin-charts-transactions',  'dataurl':'admin/contest_charts/chart_transactions/is_ajax_load:1'}"><?php echo $arrow; ?>&nbsp;</span> </h2>
  </div>
  <div class="admin-center-block clearfix  <?php echo (empty($this->request->params['isAjax']))? 'hide' : ''; ?>" id="admin-dashboard-transactions">
    <div class="clearfix"> <?php echo $this->Form->create('Chart' , array('class' => 'language-form', 'action' => 'chart_transactions')); ?> <?php echo $this->Form->input('select_range_id', array('class' => 'js-chart-autosubmit', 'label' => __l('Select Range'))); ?>
      <div class="hide"> <?php echo $this->Form->submit('Submit');  ?> </div>
<?php echo $this->Form->end(); ?> </div>
    <div class="js-load-line-graph chart-half-section {'data_container':'transactions_line_data', 'chart_container':'transactions_line_chart', 'chart_title':'<?php echo __l('Transactions') ;?>', 'chart_y_title': '<?php echo __l('Value');?>'}">
      <div class="dashboard-tl">
        <div class="dashboard-tr">
          <div class="dashboard-tc"> </div>
        </div>
      </div>
      <div class="dashboard-cl">
        <div class="dashboard-cr">
          <div class="dashboard-cc clearfix">
            <div id="transactions_line_chart" class="admin-dashboard-chart"></div>
            <div class="hide">
              <table id="transactions_line_data" class="list">
                <thead>
                  <tr>
                    <th><?php echo __l('Period'); ?></th>
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
        </div>
      </div>
      <div class="dashboard-bl">
        <div class="dashboard-br">
          <div class="dashboard-bc"> </div>
        </div>
      </div>
    </div>
    <div class="js-load-line-graph grid_left chart-half-section {'data_container':'contest_line_data', 'chart_container':'contest_line_chart', 'chart_title':'<?php echo __l('Contests') ;?>', 'chart_y_title': '<?php echo __l('Contests');?>'}">
      <div class="dashboard-tl">
        <div class="dashboard-tr">
          <div class="dashboard-tc"></div>
        </div>
      </div>
      <div class="dashboard-cl">
        <div class="dashboard-cr">
          <div class="dashboard-cc clearfix">
            <div id="contest_line_chart" class="<?php echo $class; ?>"></div>
            <div class="hide">
              <table id="contest_line_data" class="list">
                <thead>
                  <tr>
                    <th><?php echo __l('Period'); ?></th>
<?php foreach($chart_contest_status_periods as $_period): ?>
                    <th><?php echo $_period['display']; ?></th>
<?php endforeach; ?>
                  </tr>
                </thead>
                <tbody>
<?php foreach($chart_contest_status_data as $display_name => $chart_data): ?>
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
        </div>
      </div>
      <div class="dashboard-bl">
        <div class="dashboard-br">
          <div class="dashboard-bc"></div>
        </div>
      </div>
    </div>
    <div class="js-load-line-graph grid_left chart-half-section {'data_container':'entries_line_data', 'chart_container':'entries_line_chart', 'chart_title':'<?php echo __l('Entries') ;?>', 'chart_y_title': '<?php echo __l('Contests');?>'}">
      <div class="dashboard-tl">
        <div class="dashboard-tr">
          <div class="dashboard-tc"></div>
        </div>
      </div>
      <div class="dashboard-cl">
        <div class="dashboard-cr">
          <div class="dashboard-cc clearfix">
            <div id="entries_line_chart" class="<?php echo $class; ?>"></div>
            <div class="hide">
              <table id="entries_line_data" class="list">
                <thead>
                  <tr> <?php echo __l('Period'); ?>
<?php foreach($chart_contest_user_status_periods as $_period): ?>
                    <th><?php echo $_period['display']; ?></th>
<?php endforeach; ?>
                  </tr>
                </thead>
                <tbody>
<?php foreach($chart_contest_user_status_data as $display_name => $chart_data): ?>
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
        </div>
      </div>
      <div class="dashboard-bl">
        <div class="dashboard-br">
          <div class="dashboard-bc"></div>
        </div>
      </div>
    </div>
  </div>
</div>