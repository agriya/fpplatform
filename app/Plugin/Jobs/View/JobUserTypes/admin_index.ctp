<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="jobUserTypes index">
<h2><?php echo __l('Job User Types');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($jobUserTypes)):

$i = 0;
foreach ($jobUserTypes as $jobUserType):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $this->Html->cInt($jobUserType['JobUserType']['id']);?></p>
		<p><?php echo $this->Html->cText($jobUserType['JobUserType']['name']);?></p>
		<div class="actions"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $jobUserType['JobUserType']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $jobUserType['JobUserType']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No Job User Types available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($jobUserTypes)) {
    echo $this->element('paging_links');
}
?>
</div>
