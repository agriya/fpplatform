<?php
  $class = "admin-dashboard-chart";
  $class_edu = "admin-dashboard-edu-chart";
  $width =520;
  if($user_type_id == ConstUserTypes::User){
    $class = "user-dashboard-chart";
    $class_edu = "user-dashboard-edu-chart";
    $width = 620;
  }
?>
<div class="page-header no-mar"><h4><?php echo __l('Demographics'); ?></h4></div>
<div class="row-fluid ver-space">
  <?php if(!empty($chart_pie_education_data)): ?>
    <?php
      $div_class = "js-load-pie-chart ";
    ?>
    <section class="span12">
      <div class="<?php echo $div_class;?> space dc chart-half-section{'chart_width':'<?php echo $width; ?>', 'chart_type':'PieChart', 'data_container':'user_pie_education_data<?php echo $user_type_id; ?>', 'chart_container':'user_pie_education_chart<?php echo $user_type_id; ?>', 'chart_title':'<?php echo __l('Education');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
        <div id="user_pie_education_chart<?php echo $user_type_id; ?>" class="<?php echo $class_edu; ?>"></div>
          <div class="hide">
            <table id="user_pie_education_data<?php echo $user_type_id; ?>" class="list">
              <tbody>
                <?php foreach($chart_pie_education_data as $display_name => $val): ?>
                  <tr>
                    <th><?php echo $display_name; ?></th>
                    <td><?php echo $val; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
      </div>
    </section>
  <?php endif; ?>
  <?php if(!empty($chart_pie_relationship_data)): ?>
    <section class="span12 sep">
      <div class="<?php echo $div_class;?> space dc chart-half-section {'chart_width':'<?php echo $width; ?>', 'chart_type':'PieChart','data_container':'user_pie_relationship_data<?php echo $user_type_id; ?>', 'chart_container':'user_pie_relationship_chart<?php echo $user_type_id; ?>', 'chart_title':'<?php echo __l('Relationship');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
        <div id="user_pie_relationship_chart<?php echo $user_type_id; ?>" class="<?php echo $class_edu; ?>"></div>
          <div class="hide">
            <table id="user_pie_relationship_data<?php echo $user_type_id; ?>" class="list">
              <tbody>
                <?php foreach($chart_pie_relationship_data as $display_name => $val): ?>
                  <tr>
                    <th><?php echo $display_name; ?></th>
                    <td><?php echo $val; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
      </div>
    </section>
  <?php endif; ?>
</div>
<div class="row-fluid ver-space">
  <?php if(!empty($chart_pie_employment_data)): ?>
    <section class="span12">
      <div class="<?php echo $div_class;?> space dc chart-half-section {'chart_width':'<?php echo $width; ?>', 'chart_type':'PieChart','data_container':'user_pie_employment_data<?php echo $user_type_id; ?>', 'chart_container':'user_pie_employment_chart<?php echo $user_type_id; ?>', 'chart_title':'<?php echo __l('Employment');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
        <div id="user_pie_employment_chart<?php echo $user_type_id; ?>" class="<?php echo $class_edu; ?>"></div>
          <div class="hide">
            <table id="user_pie_employment_data<?php echo $user_type_id; ?>" class="list">
              <tbody>
                <?php foreach($chart_pie_employment_data as $display_name => $val): ?>
                  <tr>
                    <th><?php echo $display_name; ?></th>
                    <td><?php echo $val; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
      </div>
    </section>
  <?php endif; ?>
  <?php if(!empty($chart_pie_income_data)): ?>
    <section class="span12 sep">
      <div class="<?php echo $div_class;?> space dc chart-half-section {'chart_width':'<?php echo $width; ?>', 'chart_type':'PieChart', 'data_container':'user_pie_income_data<?php echo $user_type_id; ?>', 'chart_container':'user_pie_income_chart<?php echo $user_type_id; ?>', 'chart_title':'<?php echo __l('Income');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
        <div id="user_pie_income_chart<?php echo $user_type_id; ?>" class="<?php echo $class_edu; ?>"></div>
          <div class="hide">
            <table id="user_pie_income_data<?php echo $user_type_id; ?>" class="list">
              <tbody>
                <?php foreach($chart_pie_income_data as $display_name => $val): ?>
                  <tr>
                    <th><?php echo $display_name; ?></th>
                    <td><?php echo $val; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
      </div>
    </section>
  <?php endif; ?>
</div>
<div class="row-fluid ver-space">
  <?php if(!empty($chart_pie_gender_data)): ?>
    <section class="span12">
      <div class="<?php echo $div_class;?> space dc chart-half-section {'chart_width':'<?php echo $width; ?>','chart_type':'PieChart', 'data_container':'user_pie_gender_data<?php echo $user_type_id; ?>', 'chart_container':'user_pie_gender_chart<?php echo $user_type_id; ?>', 'chart_title':'<?php echo __l('Gender');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
        <div id="user_pie_gender_chart<?php echo $user_type_id; ?>" class="<?php echo $class; ?>"></div>
          <div class="hide">
            <table id="user_pie_gender_data<?php echo $user_type_id; ?>" class="list">
              <tbody>
                <?php foreach($chart_pie_gender_data as $display_name => $val): ?>
                  <tr>
                    <th><?php echo $display_name; ?></th>
                    <td><?php echo $val; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
      </div>
    </section>
  <?php endif; ?>
  <?php if(!empty($chart_pie_age_data)): ?>
    <section class="span12 sep">
      <div class="<?php echo $div_class;?> space dc chart-half-section {'chart_type':'PieChart', 'data_container':'user_pie_age_data<?php echo $user_type_id; ?>', 'chart_container':'user_pie_age_chart<?php echo $user_type_id; ?>', 'chart_title':'<?php echo __l('Age');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
        <div id="user_pie_age_chart<?php echo $user_type_id; ?>" class="<?php echo $class; ?>"></div>
          <div class="hide">
            <table id="user_pie_age_data<?php echo $user_type_id; ?>" class="list">
              <tbody>
                <?php foreach($chart_pie_age_data as $display_name => $val): ?>
                  <tr>
                    <th><?php echo $display_name; ?></th>
                    <td><?php echo $val; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
      </div>
    </section>
  <?php endif; ?>
</div>