<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="disputeStatuses index">
<h2><?php echo __l('Dispute Statuses');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($disputeStatuses)):

$i = 0;
foreach ($disputeStatuses as $disputeStatus):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $this->Html->cInt($disputeStatus['DisputeStatus']['id']);?></p>
		<p><?php echo $this->Html->cDateTime($disputeStatus['DisputeStatus']['created']);?></p>
		<p><?php echo $this->Html->cDateTime($disputeStatus['DisputeStatus']['modified']);?></p>
		<p><?php echo $this->Html->cText($disputeStatus['DisputeStatus']['name']);?></p>
		<div class="actions"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $disputeStatus['DisputeStatus']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $disputeStatus['DisputeStatus']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No Dispute Statuses available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($disputeStatuses)) {
    echo $this->element('paging_links');
}
?>
</div>
