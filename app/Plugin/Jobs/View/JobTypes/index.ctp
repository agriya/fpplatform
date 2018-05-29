<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="jobTypes index">
<ul class="side2-list">
  
<?php
if (!empty($jobTypes)):
$i = 0;
foreach ($jobTypes as $jobType):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	if(!empty($this->request->params['named']['display']) && $this->request->params['named']['display'] == 'requests') {
        $count = $jobType['JobType']['request_count'];
        $url = array('controller' => 'requests', 'action' => 'index');
    } elseif(!empty($this->request->params['named']['display']) && $this->request->params['named']['display'] == 'jobs') {
        $count = $jobType['JobType']['job_count'];
        $url = array('controller' => 'jobs', 'action' => 'index');
    }

?>
     <?php $class = ($this->request->params['controller'] == 'job_types' && !empty($this->request->params['named']['job_type_id']) && $this->request->params['named']['job_type_id'] == __l('recent')) ? ' class="active"' : null; ?>
    <li<?php echo $class;?>>
        <?php echo $this->Html->link(sprintf('%s (%s)', $jobType['JobType']['name'], $count), array_merge($url, array('job_type_id' => $jobType['JobType']['id'])), array('title' => $jobType['JobType']['name'])); ?>
        <ul class="side2-list">
            <?php foreach ($jobType['JobCategory'] as $jobCategory) :
                $class = null;
                if ($i++ % 2 == 0) {
                	$class = ' class="altrow"';
                }
                if(!empty($this->request->params['named']['display']) && $this->request->params['named']['display'] == 'requests') {
                    $count = $jobCategory['request_count'];
                    $url = array('controller' => 'requests', 'action' => 'index');
                } elseif(!empty($this->request->params['named']['display']) && $this->request->params['named']['display'] == 'jobs') {
                    $count = $jobCategory['job_count'];
                    $url = array('controller' => 'jobs', 'action' => 'index');
                }

                ?>
                  <?php $class = ($this->request->params['controller'] == 'job_categories' && !empty($this->request->params['named']['category']) && $this->request->params['named']['category'] == __l('recent')) ? ' class="active"' : null; ?>
                <li<?php echo $class;?>>
                    <?php echo $this->Html->link(sprintf('%s (%s)', $jobCategory['name'], $this->Html->cInt($count)),  array_merge($url, array('category' => $jobCategory['slug'])), array('title' => $jobCategory['name'], 'escape' => false));?>
                </li>
            <?php endforeach; ?>
        </ul>
    </li>
<?php endforeach; endif; ?>
</ul>
<?php
if (!empty($jobTypes)) {
    echo $this->element('paging_links');
}
?>
</div>







































