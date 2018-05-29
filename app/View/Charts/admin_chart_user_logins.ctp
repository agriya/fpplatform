<?php
$chart_title = __l('User Login');
$chart_y_title = __l('Users');
$page_title = __l('User');
$role_id = $this->request->data['Chart']['role_id'];
$arrow = '<i class="pull-right grayc icon-chevron-down"></i>';
if (isset($this->request->params['named']['is_ajax_load'])) {
$arrow = '<i class="pull-right grayc icon-chevron-up"></i>';
}
?>
<section class="thumbnail no-pad top-mspace bot-mspace sep">
            <div class="no-mar no-bor clearfix box-head space sep-bot">
               <h5 class="pull-left"><i class="icon-bar-chart pinkc no-bg"></i> <?php echo __l('Login').' - '.$page_title; ?> </h5>
              <div class="pull-right"> <a href="#collapseThree" data-parent="#accordion2" data-toggle="collapse" class=" js-toggle-icon pull-right blackc accordion-toggle"><?php echo $arrow; ?></a>
			  <div class="navbar pull-right no-mar">
                <ul class="nav no-mar pull-right">
                  <li class=""> <span id="setting5" class="dropdown-toggle cur no-under" data-toggle="dropdown"><i class="icon-wrench grayc"></i></span>
                    <ul aria-labelledby="setting5" class="dropdown-menu">
                       <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-user-login"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/charts/chart_user_logins/select_range_id:lastDays/is_ajax_load:1";?>"><?php echo __l('Last 7 days'); ?></a> </li>
					  <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-user-login"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/charts/chart_user_logins/select_range_id:lastWeeks/is_ajax_load:1";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
					  <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-user-login"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/charts/chart_user_logins/select_range_id:lastMonths/is_ajax_load:1";?>"><?php echo __l('Last 3 months'); ?></a> </li>
					  <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-user-login"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/charts/chart_user_logins/select_range_id:lastYears/is_ajax_load:1";?>"><?php echo __l('Last 3 years'); ?></a> </li>

                    </ul>
                  </li>
                </ul>
              </div>
              </div>
            </div>
            <div id="collapseThree" class="row-fluid accordion-body collapse">
			  <section class="span11">
                <div class="space dc"> <div class="js-load-line-graph grid_left chart-half-section {'data_container':'user_login_line_data<?php echo $role_id; ?>', 'chart_container':'user_login_line_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
        <div class="dashboard-tl">
          <div class="dashboard-tr">
            <div class="dashboard-tc"></div>
          </div>
        </div>
        <div class="dashboard-cl">
          <div class="dashboard-cr">
            <div class="dashboard-cc clearfix">
              <div id="user_login_line_chart<?php echo $role_id; ?>" class="grid_left admin-dashboard-chart"></div>
              <div class="hide">
                <table id="user_login_line_data<?php echo $role_id; ?>" class="list">
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
        </div>
        <div class="dashboard-bl">
          <div class="dashboard-br">
            <div class="dashboard-bc"></div>
          </div>
        </div>
      </div> </div>
              </section>
              <section class="span11 sep-left">
                <div class="space dc"> 
 <?php if(!empty($chart_pie_data)): ?>
      <div class="js-load-pie-chart grid_left chart-half-section {'data_container':'user_login_pie_data<?php echo $role_id; ?>', 'chart_container':'user_login_pie_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
        <div class="dashboard-tl">
          <div class="dashboard-tr">
            <div class="dashboard-tc"></div>
          </div>
        </div>
        <div class="dashboard-cl">
          <div class="dashboard-cr">
            <div class="dashboard-cc clearfix">
              <div id="user_login_pie_chart<?php echo $role_id; ?>" class="grid_left admin-dashboard-chart"></div>
              <div class="hide">
                <table id="user_login_pie_data<?php echo $role_id; ?>" class="list">
                  <tbody>
 <?php foreach($chart_pie_data as $display_name => $val): ?>
                    <tr>
                      <th><?php echo $display_name; ?></th>
                      <td><?php echo $val; ?></td>
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
 <?php endif; ?> </div>
              </section>
            </div>
          </section>