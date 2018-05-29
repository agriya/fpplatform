<div class="js-user-activities js-cache-load-admin-charts-user-activities">
  <div class="accordion-group">
    <?php
       $chart_title = __l('User Login');
      $chart_y_title = __l('Users');
      $role_id = $this->request->data['Chart']['role_id'];
      $collapse_class = 'in';
      if ($this->request->params['isAjax']) {
        $collapse_class ="in";
      }
    ?>
    <div class="accordion-heading">
      <div class="no-mar no-bor clearfix box-head">
        <h5>
          <span class="space pull-left">
            <i class="icon-bar-chart no-bg"></i>
            <?php echo __l('Activities')  ?>
          </span>
		 </h5>
		 <div class="span3 pull-right">
          <a class="accordion-toggle js-toggle-icon js-no-pjax grayc no-under  pull-right" href="#userfollower" data-parent="#accordion-admin-dashboard" data-toggle="collapse">
            <i class="icon-chevron-down"></i>
          </a>
          <div class="dropdown pull-right top-mspace">
            <a class="dropdown-toggle js-no-pjax js-overview grayc no-under" data-toggle="dropdown" href="#">
              <i class="icon-wrench"></i>
            </a>
            <ul class="dropdown-menu pull-right arrow arrow-right">
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-user-activities"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastDays";?>"><?php echo __l('Last 7 days'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-user-activities"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastWeeks";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-user-activities"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastMonths";?>"><?php echo __l('Last 3 months'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-user-activities"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastYears";?>"><?php echo __l('Last 3 years'); ?></a> </li>
            </ul>
          </div>
		 </div>
      </div>
    </div>
    <div id="userfollower" class="accordion-body collapse over-hide <?php echo $collapse_class;?>">
	<div class="row-fluid admin-insights-block">
      <div class="accordion-inner clearfix no-pad">

	   <?php
          $div_class = "js-load-line-graph ";
        ?>
          <section id="login" class="span12 sep admin-insights">
            <div class="<?php echo $div_class;?> space dc {'chart_type':'LineChart', 'data_container':'user_login_line_data<?php echo $role_id; ?>', 'chart_container':'user_login_line_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="user_login_line_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                <table id="user_login_line_data<?php echo $role_id; ?>" class="table table-striped table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __l('Period'); ?></th>
                      <?php foreach($chart_periods as $_period): ?>
                        <th><?php echo $_period['display']; ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($chart_data as $display_name => $chart_data): ?>
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
          </section>
		  <?php $div_class = "js-load-column-chart";
		  $chart_title = jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps);
		  $chart_y_title = jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps);; ?>
         <section id="jobs" class="span12 sep admin-insights">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'jobs_data', 'chart_container':'jobs_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="jobs_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="jobs_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($jobs_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
    	<?php $chart_title = sprintf(__l('%s Feedbacks'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps));
		  $chart_y_title = sprintf(__l('%s Feedbacks'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?>
		  <section id="job_feedbacks" class="span12 sep admin-insights">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'job_feedbacks_data', 'chart_container':'job_feedbacks_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="job_feedbacks_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="job_feedbacks_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($job_feedbacks_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php if(isPluginEnabled('JobFlags')){ ?>
		  <?php $chart_title = sprintf(__l('%s Flags'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps));
		  $chart_y_title = sprintf(__l('%s Flags'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?>
          <section id="jobflag" class="span12 sep admin-insights">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'job_flag_data', 'chart_container':'job_flag_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="job_flag_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="job_flag_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($job_flag_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
		<?php $chart_title = sprintf(__l('%s Orders'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps));
		  $chart_y_title = sprintf(__l('%s Orders'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?>
		  <section id="job_orders" class="span12 sep admin-insights">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'job_order_data', 'chart_container':'job_order_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="job_order_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="job_order_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($job_order_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php if(isPluginEnabled('JobFavorites')){ ?>
         <?php $chart_title = sprintf(__l('%s Favorites'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps));
		  $chart_y_title = sprintf(__l('%s Favorites'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?>
          <section id="job_favorites" class="span12 sep admin-insights">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'job_favorites_data', 'chart_container':'job_favorites_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="job_favorites_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="job_favorites_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($job_favorites_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
		  <?php if(isPluginEnabled('Requests')){ ?>
		  <?php $chart_title = requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps);
		  $chart_y_title = requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps); ?>
          <section id="requests" class="span12 sep admin-insights">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'requests_data', 'chart_container':'requests_data<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="requests_data<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="requests_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($requests_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php if(isPluginEnabled('RequestFavorites')){ ?>
		  <?php $chart_title = sprintf(__l('%s Favorites'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps));
		  $chart_y_title = sprintf(__l('%s Favorites'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)); ?>
		  <section id="request_favorites" class="span12 sep admin-insights">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'request_favorites_data', 'chart_container':'request_favorites_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="request_favorites_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="request_favorites_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($request_favorites_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
		  <?php if(isPluginEnabled('RequestFlags')){ ?>
		  <?php $chart_title = sprintf(__l('%s Flags'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps));
		  $chart_y_title = sprintf(__l('%s Flags'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)); ?>
		  <section id="requestflag" class="span12 sep admin-insights">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'request_flag_data', 'chart_container':'request_flag_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="request_flag_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="request_flag_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($request_flag_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
		  <?php } ?>
	  </div>
	  </div>
    </div>
  </div>
