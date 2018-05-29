<div>
<h3><?php echo __l("Stats");?></h3>
<table class="table table-bordered">
<tr>
  <th> <?php echo sprintf(__l('Launched %s'), Configure::read('project.alt_name_for_project_plural_caps'));?> </th>
  <th> <?php echo __l('Total').'('.Configure::read('site.currency').')';?> </th>
  <th> <?php echo __l('Successful').'('.Configure::read('site.currency').')';?> </th>
  <th> <?php echo __l('Unsuccessful').'('.Configure::read('site.currency').')';?> </th>
  <th> <?php echo __l('Live').'('.Configure::read('site.currency').')';?> </th>
  <th> <?php echo sprintf(__l('Live %s'), Configure::read('project.alt_name_for_project_plural_caps'));?> </th>
</tr>
<tr>
  <td> <?php echo $this->Html->cInt($launched_projects);?> </td>
  <td> <?php echo $this->Html->cCurrency($launched_projects_amount[0][0]['launched_projects_amount']);?></td>
  <td> <?php echo $this->Html->cCurrency($successful_projects_amount[0][0]['successful_projects_amount']);?> </td>
  <td> <?php echo $this->Html->cCurrency($unsuccessful_projects_amount[0][0]['unsuccessful_projects_amount']);?> </td>
  <td> <?php echo $this->Html->cCurrency($live_projects_amount[0][0]['live_projects_amount']);?> </td>
  <td> <?php echo $this->Html->cInt($live_projects);?> </td>
</tr>
</table>
</div>
<div>
<h3><?php echo sprintf(__l('Successfully Funded %s'), Configure::read('project.alt_name_for_project_plural_caps'));?></h3>
<table class="table table-bordered">
<tr>
<th> <?php echo sprintf(__l('Successfully Funded %s'), Configure::read('project.alt_name_for_project_plural_caps'));?></th>
<?php foreach($pricePoints as $price):?>
  <th><?php echo $price['price_points'].'('.Configure::read('site.currency').')';?></th>
<?php endforeach;?>
</tr>
<tr>
<td> <?php echo $this->Html->cInt($successful_projects);?> </td>
<?php foreach($pricePoints as $price):?>
  <td><?php echo $this->Html->cCurrency($price['collected_amount']);?></td>
<?php endforeach;?>
</tr>
</table>
<h3><?php echo sprintf(__l('Unsuccessfully Funded %s'), Configure::read('project.alt_name_for_project_plural_caps'));?></h3>
<table class="table table-bordered">
<tr>
<th> <?php echo sprintf(__l('Unsuccessfully Funded %s'), Configure::read('project.alt_name_for_project_plural_caps'));?></th>
<?php foreach($percentage_range as $price):?>
  <th><?php echo $price['percentage_range'].'%';?></th>
<?php endforeach;?>
</tr>
<tr>
<td> <?php echo $this->Html->cInt($unsuccessful_projects);?> </td>
<?php foreach($percentage_range as $price):?>
  <td><?php echo $this->Html->cInt($price['project']);?></td>
<?php endforeach;?>
</tr>
</table>
</div>