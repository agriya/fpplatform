<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<h3> <?php echo __l('Related Jobs'); ?> </h3>
<ol class="list jobs-list1">
	<?php
	if (!empty($jobs)):

	$i = 0;
	foreach ($jobs as $job):
	?>
    <li>
    <?php
		echo $this->Html->link($this->Html->cText(__l('I will').' '.$job['Job']['title'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($job['Job']['amount'])), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']), array('title' => __l('I will').' '.$this->Html->cText($job['Job']['title'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($job['Job']['amount']),false),'escape' => false));?>
	</li>
	<?php
		endforeach;
	else:
	?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.__l('available');?></p></div>
	</li>
	<?php
	endif;
	?>
	</ol>