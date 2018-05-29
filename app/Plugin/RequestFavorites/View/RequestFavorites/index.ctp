<?php /* SVN: $Id: $ */ ?>
<div class="requestFavorites index">
<h2><?php echo sprintf(__l('%s Favorites'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps));?></h2>
<?php echo $this->element('paging_counter');?>
<table class="table table-striped table-hover sep">
    <tr>
        <th><?php echo $this->Paginator->sort('id');?></th>
        <th><?php echo $this->Paginator->sort('created');?></th>
        <th><?php echo $this->Paginator->sort('modified');?></th>
        <th><?php echo $this->Paginator->sort('user_id');?></th>
        <th><?php echo $this->Paginator->sort('request_id');?></th>
        <th><?php echo $this->Paginator->sort('ip');?></th>
    </tr>
<?php
if (!empty($requestFavorites)):

$i = 0;
foreach ($requestFavorites as $requestFavorite):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php echo $this->Html->cInt($requestFavorite['RequestFavorite']['id']);?></td>
		<td><?php echo $this->Html->cDateTime($requestFavorite['RequestFavorite']['created']);?></td>
		<td><?php echo $this->Html->cDateTime($requestFavorite['RequestFavorite']['modified']);?></td>
		<td><?php echo $this->Html->link($this->Html->cText($requestFavorite['User']['username']), array('controller'=> 'users', 'action'=>'view', $requestFavorite['User']['username']), array('escape' => false));?></td>
		<td><?php echo $this->Html->link($this->Html->cText($requestFavorite['Request']['name']), array('controller'=> 'requests', 'action'=>'view', $requestFavorite['Request']['slug']), array('escape' => false));?></td>
		<td><?php echo $this->Html->cText($requestFavorite['RequestFavorite']['ip']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="8"><div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.__l('Favorites available');?></p></div>
		</td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($requestFavorites)) {
    echo $this->element('paging_links');
}
?>
</div>
