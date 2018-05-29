<?php if (!isset($this->request->params['named']['page'])): ?>
  <h2><?php echo __l('Contents'); ?></h2>
<?php endif; ?>
<div class="nodes js-response">
  <ul id="nodes-for-links" class="unstyled">
    <?php foreach ($nodes AS $node) { ?>
	  <?php if (!empty($this->request->params['named']['from'])): ?>
		<?php $url = Router::url(array('admin' => false, 'controller' => 'nodes', 'action' => 'view', 'type' => $node['Node']['type'], 'slug' => $node['Node']['slug']), true); ?>
	    <li> <?php echo $this->Html->link($node['Node']['title'], '#', array('class' => 'js-node-links', 'rel' => 'controller:nodes/action:view/type:' . $node['Node']['type'] . '/slug:' . $node['Node']['slug'])); ?> </li>
	<?php else: ?>
	    <li> <?php echo $this->Html->link($node['Node']['title'], '#', array('class' => 'js-node-links', 'rel' => 'controller:nodes/action:view/type:' . $node['Node']['type'] . '/slug:' . $node['Node']['slug'])); ?> </li>
	<?php endif; ?>
    <?php } ?>
  </ul>
  <div class="js-no-pjax pull-right">
    <?php echo $this->element('paging_links'); ?>
  </div>
</div>