<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="jobFavorites index">
<h2><?php echo sprintf(__l('%s Favorites'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps));?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($jobFavorites)):

$i = 0;
foreach ($jobFavorites as $jobFavorite):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $this->Html->cInt($jobFavorite['JobFavorite']['id']);?></p>
		<p><?php echo $this->Html->cDateTime($jobFavorite['JobFavorite']['created']);?></p>
		<p><?php echo $this->Html->cDateTime($jobFavorite['JobFavorite']['modified']);?></p>
		<p><?php echo $this->Html->link($this->Html->cText($jobFavorite['User']['username']), array('controller'=> 'users', 'action' => 'view', $jobFavorite['User']['username']), array('escape' => false));?></p>
		<p><?php echo $this->Html->link($this->Html->cText($jobFavorite['Job']['title']), array('controller'=> 'jobs', 'action' => 'view', $jobFavorite['Job']['slug']), array('escape' => false));?></p>
		<p><?php echo $this->Html->cText($jobFavorite['JobFavorite']['ip']);?></p>
		<div class="actions"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $jobFavorite['JobFavorite']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $jobFavorite['JobFavorite']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16">
				<?php echo __l('No Favorites ').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.__l(' available');?>
			</p>
		</div>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($jobFavorites)) {
    echo $this->element('paging_links');
}
?>
</div>