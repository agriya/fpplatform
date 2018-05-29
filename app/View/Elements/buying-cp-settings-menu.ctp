<div class="pull-right dropdown"> <a href="#" title="Setting" class="dropdown-toggle btn btn-warning span1 space no-shad" data-toggle="dropdown"><i class="icon-cog whitec no-pad text-20"></i> <span class="hide">Settings</span></a>
	<ul class="unstyled dropdown-menu arrow arrow-right dl clearfix text-14">
		<?php if(isPluginEnabled('Requests')) { ?>
			<?php $class=($this->request->params['controller'] == 'requests' && $this->request->params['action'] == 'add')? 'active':'';?>
			 <li class="<?php echo $class;?>"><?php echo $this->Html->link(__l('Post a').' '.requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps), array('controller' => 'requests', 'action' => 'add'), array('title' =>__l('Post a').' '.requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps))); ?></li>
			
			<?php } ?>
			<?php $class=($this->request->params['controller'] == 'job_orders' && ($this->request->params['action'] == 'index'&& (!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='myorders')))? 'active':'';?>

			<li class="<?php echo $class;?>"><?php echo $this->Html->link(__l('My Shopping'), array('controller' => 'job_orders', 'action' => 'index', 'type' => 'myorders', 'status' => 'active'), array('title' => __l('My Shopping'))); ?></li>

			<?php $class=($this->request->params['controller'] == 'job_orders' && ($this->request->params['action'] == 'index'&& (!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='history')))? 'active':'';?>

			<li class="<?php echo $class;?>"><?php echo $this->Html->link(__l('Order History'), array('controller' => 'job_orders', 'action' => 'index', 'type' => 'history'), array('title' => __l('Order History'))); ?></li>

			<?php if(isPluginEnabled('Requests')) { ?>

			<?php $class=($this->request->params['controller'] == 'requests' && ($this->request->params['action'] == 'index' || (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type']=='manage'|| $this->request->params['named']['type']=='manage_requests'))))? 'active':'';?>

			<li class="<?php echo $class;?>"><?php echo $this->Html->link(__l('My').' '.requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps), array('controller'=> 'requests', 'action'=>'index', 'type' => 'manage_requests', 'admin' => false, 'view_type'=> 'expand'), array('title' => __l('My').' '.requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps))); ?></li>
			<?php } ?>
			<?php if(isPluginEnabled('JobFavorites')) { ?>
			<?php $class=($this->request->params['controller'] == 'jobs' && ($this->request->params['action'] == 'index'|| (!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='favorite')))? 'active':'';?>

			<li class="<?php echo $class;?>"><?php echo $this->Html->link(__l(jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)).' '.__l('I Like'), array('controller' => 'jobs', 'action' => 'index', 'type' => 'favorite'), array('title' => __l(jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)).' '.__l('I Like'))); ?></li>
			<?php } ?>
	</ul>
</div>