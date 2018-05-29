<div class="accordion-group js-user-transaction">
  <div class="accordion-heading clearfix">
  <h4> <a class="accordion-toggle js-toggle-icon js-no-pjax" href="#user-dashboard-overview" data-parent="#dashboard-accordion" data-toggle="collapse"><?php echo __l('Overview'); ?><i class="icon-minus pull-right"></i></a></h4>
  </div>
 <div class="accordion-body in collapse" id="user-dashboard-overview">
   <div class="accordion-inner">
     <div class="row">
    <div class="pull-right span-view">
    <div class="btn-group">
      <button class="btn dropdown-toggle js-no-pjax js-overview" data-toggle="dropdown">
      <?php echo __l('Select Range')?>
      <span class="caret"></span>
      </button>
        <ul class="dropdown-menu pull-right arrow arrow-right">
        <li> <a class='js-link-chart js-no-pjax {"data_load":"js-user-transaction"}' title="Last 7 days"  href="<?php echo Router::url('/', true)."Insights/chart_user_transactions/select_range_id:lastDays/";?>">Last 7 days</a> </li>
        <li> <a class='js-link-chart js-no-pjax {"data_load":"js-user-transaction"}' title="Last 4 weeks" href="<?php echo Router::url('/', true)."Insights/chart_user_transactions/select_range_id:lastWeeks/";?>">Last 4 weeks</a> </li>
        <li> <a class='js-link-chart js-no-pjax {"data_load":"js-user-transaction"}' title="Last 3 months" href="<?php echo Router::url('/', true)."Insights/chart_user_transactions/select_range_id:lastMonths/";?>">Last 3 months</a> </li>
        <li> <a class='js-link-chart js-no-pjax {"data_load":"js-user-transaction"}' title="Last 3 years"  href="<?php echo Router::url('/', true)."Insights/chart_user_transactions/select_range_id:lastYears/";?>">Last 3 years</a> </li>
        </ul>
     </div>
    </div>
    </div>
  <?php
    $div_class = "js-load-line-graph ";
  ?>
  <div class="row">
  <div class="<?php echo $div_class;?> span11 chart-half-section {'chart_width':'620', 'chart_type':'LineChart','data_container':'transactions_line_data', 'chart_container':'transactions_line_chart', 'chart_title':'<?php echo __l('Transactions') ;?>', 'chart_y_title': '<?php echo __l('Value');?>'}">
     <div class="dashboard-tl">
       <div class="dashboard-tr">
         <div class="dashboard-tc">
         </div>
     </div>
   </div>
   <div class="dashboard-cl">
     <div class="dashboard-cr">
     <div class="dashboard-cc clearfix">

    <div id="transactions_line_chart" class="user-dashboard-chart"></div>
      <div class="hide">
      <table id="transactions_line_data" class="list">
      <thead>
        <tr>
           <th>Peried</th>
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

  </div>
<?php
    $div_class = "js-load-column-chart";
  ?>
    <div class="<?php echo $div_class;?>  span11 chart-half-section {'chart_width':'620', 'chart_type':'ColumnChart','data_container':'total_orders_column_data', 'chart_container':'total_orders_column_chart', 'chart_title':'<?php echo __l('Total Orders') ;?>', 'chart_y_title': '<?php echo __l('Orders');?>'}">
    <div class="dashboard-tl">
       <div class="dashboard-tr">
         <div class="dashboard-tc">
         </div>
       </div>
     </div>
     <div class="dashboard-cl">
       <div class="dashboard-cr">
      <div class="dashboard-cc clearfix">
      <div id="total_orders_column_chart" class="user-dashboard-chart"></div>
      <div class="hide">
      <table id="total_orders_column_data" class="list">
        <tbody>
          <?php foreach($chart_project_funds_data as $key => $_data): ?>
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
    </div>


  </div>
  </div>
  </div>
  </div>
  </div>