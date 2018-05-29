<?php /* SVN: $Id: $ */ ?>
<div class="revisions index">
<h2><?php echo __l('Revisions');?></h2>
<?php echo $this->element('paging_counter');?>
<div class="overflow-block">
<table class="table table-striped table-hover sep">
    <tr>
        <th><?php echo $this->Paginator->sort('id');?></th>
        <th><?php echo $this->Paginator->sort('type');?></th>
        <th><?php echo $this->Paginator->sort('node_id');?></th>
        <th><?php echo $this->Paginator->sort('content');?></th>
        <th><?php echo $this->Paginator->sort('revision_number');?></th>
        <th><?php echo $this->Paginator->sort('user_id');?></th>
        <th><?php echo $this->Paginator->sort('created');?></th>
    </tr>
<?php
if (!empty($revisions)):

$i = 0;
foreach ($revisions as $revision):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php echo $this->Html->cInt($revision['Revision']['id']);?></td>
		<td><?php echo $this->Html->cText($revision['Revision']['type']);?></td>
		<td><?php echo $this->Html->cInt($revision['Revision']['node_id']);?></td>
		<td><?php echo $this->Html->cText($revision['Revision']['content']);?></td>
		<td><?php echo $this->Html->cInt($revision['Revision']['revision_number']);?></td>
		<td><?php echo $this->Html->cInt($revision['Revision']['user_id']);?></td>
		<td><?php echo $this->Html->cDateTime($revision['Revision']['created']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="8" class="notice"><?php echo __l('No Revisions available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($revisions)) {
    echo $this->element('paging_links');
}
?>
</div>
