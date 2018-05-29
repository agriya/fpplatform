<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php if($this->request->params['named']['type'] == ConstJobType::Online) : ?>
	<div class="span6 no-mar sep-right">
<?php else: ?>
	<div class="span6 no-mar">
<?php endif; ?>
	<h3 class="grayc hor-space text-16">
		<?php
		if(!empty($this->request->params['named']['display']) && $this->request->params['named']['display'] == 'requests'):
			$url = array('controller' => 'requests', 'action' => 'index');
		else:
			$url = array('controller' => 'jobs', 'action' => 'index');	
		endif;
		if(empty($this->request->params['named']['display']) || $this->request->params['named']['display'] != 'home') {
			if($this->request->params['named']['type'] == ConstJobType::Online && Configure::read('job.is_enable_online')){
				echo $this->Html->link(sprintf(__l('Online').' (%s)', $this->Html->cInt($online)), array_merge($url, array('job_type_id' => ConstJobType::Online)), array('title' => sprintf(__l('Online %s'), jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps)), 'escape' => false));
			} else if($this->request->params['named']['type'] == ConstJobType::Offline && Configure::read('job.is_enable_offline')) {
				echo $this->Html->link(sprintf(__l('Offline').' (%s)', $this->Html->cInt($offline)), array_merge($url, array('job_type_id' => ConstJobType::Offline)), array('title' => sprintf(__l('Offline %s'), jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps)), 'escape' => false));
			}
		} else {
			if($this->request->params['named']['type'] == ConstJobType::Online && Configure::read('job.is_enable_online')){
				echo $this->Html->link(__l('Online'), array_merge($url, array('job_type_id' => ConstJobType::Online)), array('title' => sprintf(__l('Online %s'), jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps)), 'escape' => false));
			} else if($this->request->params['named']['type'] == ConstJobType::Offline && Configure::read('job.is_enable_offline')) {
				echo $this->Html->link(__l('Offline'), array_merge($url, array('job_type_id' => ConstJobType::Offline)), array('title' => sprintf(__l('Offline %s'), jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps)), 'escape' => false));
			}
		}
	?>
	</h3>
	<ul class="unstyled clearfix">
	<?php
	if (!empty($jobCategories)):
	$i = 0;
	foreach ($jobCategories as $jobCategory) {
		$class = null;
	?>
	<?php $class = ($this->request->params['controller'] == 'job_categories' && !empty($this->request->params['named']['category']) && $this->request->params['named']['category'] == $jobCategory['JobCategory']['slug']) ? 'active' : null; ?>
	 <?php if($this->request->params['named']['display'] == 'requests'){
		$cat_count = $jobCategory['JobCategory']['request_count'];
	 }elseif($this->request->params['named']['display'] == 'jobs') {
		$cat_count = $jobCategory['JobCategory']['job_count'];
	 } 
		if(empty($this->request->params['named']['display']) || $this->request->params['named']['display'] != 'home') { ?>	
			 <li class="<?php echo $class; ?>"><?php echo $this->Html->link($jobCategory['JobCategory']['name'] . ' ('. $this->Html->cInt($cat_count).')',  array_merge($url, array('category' => $jobCategory['JobCategory']['slug'])), array('escape' => false,'title' => __l($jobCategory['JobCategory']['name'])));?>  </li>
			<?php
		} else { ?>
			 <li class="<?php echo $class; ?>"><?php echo $this->Html->link($jobCategory['JobCategory']['name'],  array_merge($url, array('category' => $jobCategory['JobCategory']['slug'])), array('escape' => false,'title' => __l($jobCategory['JobCategory']['name'])));?>  </li>
			<?php
		}	
	 } 
	  else:
		?>
			<li>
				<div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16">
					<?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('Categories available');?></p>
				</div>
			</li>
		<?php
		endif;
		?>
	</ul>
  </div>