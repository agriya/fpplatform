<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="jobServiceLocations index">
<h2><?php echo __l('Job Service Locations');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($jobServiceLocations)):

$i = 0;
foreach ($jobServiceLocations as $jobServiceLocation):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $this->Html->cInt($jobServiceLocation['JobServiceLocation']['id']);?></p>
		<p><?php echo $this->Html->cText($jobServiceLocation['JobServiceLocation']['name']);?></p>
		<p><?php echo $this->Html->cInt($jobServiceLocation['JobServiceLocation']['job_count']);?></p>
		<p><?php echo $this->Html->cText($jobServiceLocation['JobServiceLocation']['description']);?></p>
		<div class="actions"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $jobServiceLocation['JobServiceLocation']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $jobServiceLocation['JobServiceLocation']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No Job Service Locations available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($jobServiceLocations)) {
    echo $this->element('paging_links');
}
?>
</div>
