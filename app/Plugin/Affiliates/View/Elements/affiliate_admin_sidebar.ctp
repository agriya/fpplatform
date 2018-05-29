<h4><?php echo __l('Affiliates');?></h4>
<ul class="admin-sub-links">
	<?php $class = ($this->request->params['controller'] == 'affiliates') ? ' class="active"' : null; ?>
		<li <?php echo $class;?>><?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'),array('title' => __l('Affiliates'))); ?></li>
</ul>