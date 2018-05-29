<div class="pull-right dropdown"> <a href="#" title="Setting" class="dropdown-toggle btn btn-warning span1 space no-shad" data-toggle="dropdown"><i class="icon-cog whitec no-pad text-20"></i> <span class="hide">Settings</span></a>
	<ul class="unstyled dropdown-menu arrow arrow-right dl clearfix text-14">
		<?php $class=($this->request->params['controller'] == 'jobs' && $this->request->params['action'] == 'add')? 'active':'';?>
		<li class="<?php echo $class;?>"><?php echo $this->Html->link(__l('Post a').' '.__l(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('controller' => 'jobs', 'action' => 'add'), array('title' => __l('Post a').' '.__l(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), 'class' => 'post-menu')); ?></li>

		<?php $class=($this->request->params['controller'] == 'jobs' && ($this->request->params['action'] == 'index' || (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type']=='manage'|| $this->request->params['named']['type']=='manage_jobs'))))? 'active':'';?>
		<li class="<?php echo $class;?>"><?php echo $this->Html->link(__l('My').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'jobs', 'action' => 'manage'), array('title' => __l('My').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps))); ?></li>

		<?php $class=($this->request->params['controller'] == 'job_orders' && ($this->request->params['action'] == 'index'&& (!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='myworks')))? 'active':'';?>
		<li class="<?php echo $class;?>"><?php echo $this->Html->link(__l('My Todo'), array('controller' => 'job_orders', 'action' => 'index', 'type' => 'myworks'), array('title' => __l('My Todo'))); ?></li>

		<?php $class=($this->request->params['controller'] == 'job_orders' && ($this->request->params['action'] == 'index'&& (!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='gain')))? 'active':'';?>
		<li class="<?php echo $class;?>"><?php echo $this->Html->link(__l('Sales Balance'), array('controller' => 'job_orders', 'action' => 'index', 'type' => 'gain'), array('title' => __l('Sales Balance'))); ?></li>

		<?php if(isPluginEnabled('RequestFavorites')) { ?>
		<?php $class=($this->request->params['controller'] == 'requests' && ($this->request->params['action'] == 'index'|| (!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='favorite')))? 'active':'';?>
		<li class="<?php echo $class;?>"><?php echo $this->Html->link(__l(requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps)).' '.__l('I Like'), array('controller' => 'requests', 'action' => 'index', 'type' => 'favorite'), array('title' => __l(requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps)).' '.__l('I Like'))); ?></li>
		<?php } ?>
	</ul>
</div>
			