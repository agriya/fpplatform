<div>
<ul class="list-menu clearfix">
		<?php $class = ($this->request->params['controller'] == 'jobs' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add') && empty($this->request->params['named']['type'])) ? ' class="active"' : null; ?>
		<li <?php echo $class;?>>
			<?php echo $this->Html->link(__l(Configure::read('job.index_title_name')), array('controller' => 'jobs', 'action' => 'index'), array('class' => 'menu-link', 'title' =>Configure::read('job.index_title_name')));?>
			<span class="post">
				<?php echo $this->Html->link(__l('Post'), array('controller' => 'jobs', 'action' => 'add'), array('title' => __l('Post a').' '.jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps)));?>
			</span>
		</li>
		<?php $class = ($this->request->params['controller'] == 'requests' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add') && empty($this->request->params['named']['type'])) ? ' class="active"' : null; ?>
		<li <?php echo $class;?>>
			<?php echo $this->Html->link(__l(Configure::read('request.index_title_name')), array('controller' => 'requests', 'action' => 'index'), array('class' => 'menu-link', 'title' => Configure::read('request.index_title_name')));?>
			<span class="post2">
				<?php echo $this->Html->link(__l('Post'), array('controller' => 'requests', 'action' => 'add'), array('title' => __l('Post a').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) ));?>
			</span>
		</li>
	</ul>
</div>