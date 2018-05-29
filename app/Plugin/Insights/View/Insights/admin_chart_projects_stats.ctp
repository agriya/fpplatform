<div class="clearfix">
<table class="table table-striped table-bordered table-condensed">
   <thead>
    <tr>
      <th class="dc" colspan="2"></th>
      <th class="dr"><?php echo __l('Min');?></th>
      <th class="dr"><?php echo __l('Max');?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="dr" rowspan="3"><?php echo __l('Offered');?></td>
      <td class="dr"><?php echo __l('Needed Amount').' ('.Configure::read('site.currency').')';?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($projects_stats['needed_amount']['min']);?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($projects_stats['needed_amount']['max']);?></td>
    </tr>
    <tr>
      <td class="dr"><?php echo __l('Collected Amount').' ('.Configure::read('site.currency').')';?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($projects_stats['collected_amount']['min']);?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($projects_stats['collected_amount']['max']);?></td>
    </tr>
     <tr>
      <td class="dr"><?php echo __l('Site Commission').' ('.Configure::read('site.currency').')';?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($projects_stats['commission_amount']['min']);?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($projects_stats['commission_amount']['max']);?></td>
    </tr>
   </tbody>
  </table>
</div>