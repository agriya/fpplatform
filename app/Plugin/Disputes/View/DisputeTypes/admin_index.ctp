<?php /* SVN: $Id: $ */ ?>
<div class="disputeTypes index">
<h2><?php echo __l('Dispute Types');?></h2>
<div class="add-block">
	<?php echo $this->Html->link(__l('Add'), array('controller' => 'dispute_types', 'action' => 'add'), array('class' => 'add','title'=>__l('Add'))); ?>
</div>
<?php echo $this->element('paging_counter');?>
<div class="overflow-block">
<table class="table table-striped table-hover sep">
    <tr>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort('created');?></th>
        <th><?php echo $this->Paginator->sort('name');?></th>
        <th><?php echo $this->Paginator->sort('job_user_type_id');?></th>
        <th><?php echo $this->Paginator->sort(__l('Active?'), 'active')?></th>
    </tr>
<?php
if (!empty($disputeTypes)):

$i = 0;
foreach ($disputeTypes as $disputeType):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<span><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $disputeType['DisputeType']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $disputeType['DisputeType']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
		</td>
		<td><?php echo $this->Html->cDateTimeHighlight($disputeType['DisputeType']['created']);?></td>
        <td><?php echo $this->Html->cText($disputeType['DisputeType']['name']);?></td>
	 	<td><?php echo $this->Html->cText($disputeType['JobUserType']['name']);?> </td>
	    <td><?php echo $this->Html->cBool($disputeType['DisputeType']['is_active']);?></td>  
    </tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="17" class="notice"><?php echo __l('No Dispute Types available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($disputeTypes)) {
    echo $this->element('paging_links');
}
?>
</div>


