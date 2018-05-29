<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="js-response">
<ol class="my-job-list clearfix unstyled jobs-list1">
<?php
if (!empty($jobs)):

$i = 0;
foreach ($jobs as $job):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
<?php /* SVN: $Id: $ */ ?>
<li class="clearfix">
<?php
		$options = array($job['Job']['id'] => '');
		echo $this->Form->input('Job.job', array ('type' => 'radio', 'options' => $options, 'value' => $job['Job']['id'] . '#' . $job['Job']['id'],'div'=>'span'));
        ?>
        <div class="span18 htruncate" title="<?php echo $job['Job']['title']; ?>">
        <?php echo $job['Job']['title']; ?>
		</div>
	<div class="clearfix dr">
		<p class='amt'><?php echo $this->Html->siteCurrencyFormat($job['Job']['amount']);?></p>
	</div>
	 <div class="clearfix">
		<span class='job-type-<?php echo $job['Job']['job_type_id']; ?>' title='<?php echo $job['JobType']['name']; ?>'></span>
	</div>
</li>
<?php
    endforeach;
else:
?>
	<li class="warning">
		<p class="hor-space redc"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.__l('available');?></p>
	</li>
<?php
endif;
?>
</ol>
<div class="js-pagination pull-right">
<?php
if (!empty($jobs)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>
