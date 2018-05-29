<div class="clearfix">
  <div class="clearfix">
<table class="table table-striped table-bordered table-condensed table-hover">
    <tr>
      <td class="dr"><?php echo __l('Needed Amount');?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($project_stats['needed_amount']);?></td>
    </tr>
    <tr>
      <td class="dr"><?php echo __l('Collected Amount');?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($project_stats['collected_amount']);?></td>
    </tr>
    <tr>
      <td class="dr"><?php echo __l('Fund Count');?></td>
      <td class="dr"><?php echo $project_stats['fund_count'];?></td>
    </tr>
    <tr>
      <td class="dr"><?php echo __l('Site Commission');?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($project_stats['site_commission']);?></td>
    </tr>
  </table>
</div>
 <?php
    $div_class = "js-load-pie-chart ";
  ?>
  <div class="<?php echo $div_class;?> chart-half-section {'chart_type':'PieChart', 'data_container':'user_pie_fund_data<?php echo $user_type_id; ?>', 'chart_container':'user_pie_fund_chart<?php echo $user_type_id; ?>', 'chart_title':'<?php echo sprintf(__l('%s Fund'), Configure::read('project.alt_name_for_project_plural_caps'));?>', 'chart_y_title': '<?php echo sprintf(__l('%s Fund'), Configure::read('project.alt_name_for_project_plural_caps'));?>'}">
  <div class="dashboard-tl">
           <div class="dashboard-tr">
             <div class="dashboard-tc">
             </div>
         </div>
      </div>
     <div class="dashboard-cl">
       <div class="dashboard-cr">
       <div class="dashboard-cc clearfix">
    <div id="user_pie_fund_chart<?php echo $user_type_id; ?>" class="admin-dashboard-fund-chart"></div>
    <div class="hide">
      <table id="user_pie_fund_data<?php echo $user_type_id; ?>" class="list">
        <tbody>
          <tr>
             <th><?php echo __l('Needed Amount') ?></th>
             <td>
				<?php
					if($project_stats['needed_amount'] > $project_stats['collected_amount']) {
						echo (100 - (($project_stats['collected_amount']/$project_stats['needed_amount'])*100));
					} else {
						echo 0;
					}
				?></td>
          </tr>
          <tr>
             <th><?php echo __l('Collected Amount') ?></th>
             <td>
				<?php
					echo ($project_stats['collected_amount']/$project_stats['needed_amount'])*100;
				?>
			</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
    </div>
    </div>
    <div class="dashboard-bl">
       <div class="dashboard-br">
         <div class="dashboard-bc">
         </div>
       </div>
     </div>
  </div>
<?php if($project_stats['collected_amount'] > 0) { ?>
  <div class="clearfix">
  <?php echo $this->element('chart-user_demographics', array('cache' => array('config' => 'site_element_cache_15_min', 'key' => $this->Auth->user('id')), 'chart_y_title' => __l('Funded Users'), 'user_type_id' => 1)); ?>
  </div>
<?php } ?>
</div>