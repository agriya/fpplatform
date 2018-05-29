<div class="space mob-dc span10 no-mar js-load-line-graph dc chart-half-section {'chart_type':'LineChart', 'data_container':'selling_line_chart_data', 'chart_container':'selling_line_chart', 'chart_title':'', 'chart_y_title': ''}">
  <div style="width:386px;height:200px" id="selling_line_chart"></div>
  <div class="hide">
    <table id="selling_line_chart_data" class="table table-striped table-hover sep">
	  <thead>
	    <tr>
		  <th colspan='1'>&nbsp;</th>
		  <?php foreach($modelFields as $key => $fields){ ?>
			<th>
			  <?php echo $fields; ?>
			</th>
		  <?php } ?>
		</tr>
	  </thead>
	  <tbody>
		<?php foreach($periods as $key => $period){  ?>
		  <tr>
			<th>
			  <?php echo $period['display'] ; ?>
			</th>
			<?php foreach($models as $unique_model){ ?>
			  <?php foreach($unique_model as $model => $fields){
				  $aliasName = isset($fields['alias']) ? $fields['alias'] : $model;?>
				  <td><?php	echo ${$aliasName.$key}; ?> </td>
			  <?php } ?>
			<?php } ?>
		  </tr>
		<?php } ?>
	  </tbody>
	</table>
  </div>
</div>