<?php /* SVN: $Id: $ */ ?>
<div class="jobViews index">
<h2><?php echo sprintf(__l('%s Views'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps));?></h2>
<?php echo $this->element('paging_counter');?>
<table class="table table-striped table-hover sep">
    <tr>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort('id');?></th>
        <th><?php echo $this->Paginator->sort('created');?></th>
        <th><?php echo $this->Paginator->sort('modified');?></th>
        <th><?php echo $this->Paginator->sort('job_id');?></th>
        <th><?php echo $this->Paginator->sort('user_id');?></th>
        <th><?php echo $this->Paginator->sort('ip');?></th>
    </tr>
<?php
if (!empty($jobViews)):

$i = 0;
foreach ($jobViews as $jobView):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions"><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $jobView['JobView']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $jobView['JobView']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
		<td><?php echo $this->Html->cInt($jobView['JobView']['id']);?></td>
		<td><?php echo $this->Html->cDateTime($jobView['JobView']['created']);?></td>
		<td><?php echo $this->Html->cDateTime($jobView['JobView']['modified']);?></td>
		<td><?php echo $this->Html->link($this->Html->cText($jobView['Job']['title']), array('controller'=> 'jobs', 'action'=>'view', $jobView['Job']['slug']), array('escape' => false));?></td>
		<td><?php echo $this->Html->link($this->Html->cText($jobView['User']['username']), array('controller'=> 'users', 'action'=>'view', $jobView['User']['username']), array('escape' => false));?></td>
		<td><?php echo $this->Html->cText($jobView['IP']['ip']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7"><div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s Views available'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></p></div></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($jobViews)) {
    echo $this->element('paging_links');
}
?>
</div>
