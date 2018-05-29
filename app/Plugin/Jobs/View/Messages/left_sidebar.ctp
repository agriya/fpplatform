 <div class="clearfix">
<div class="pull-left">
<ul class="unstyled no-mar ver-space">
<?php if ($inbox == 0): ?>
			<li class="span pull-left <?php echo (((isset($folder_type)) and ($folder_type == 'inbox')) ? 'active' : 'inactive'); ?>">
				<?php echo $this->Html->link(__l('Inbox') , array('controller' => 'messages', 'action' => 'inbox'),array('title'=>__l('Inbox'))); ?>
			</li>
<?php else: ?>
			<li class=" span pull-left <?php echo (((isset($folder_type)) and ($folder_type == 'inbox')) ? 'active' : 'inactive'); ?>">
				<?php echo $this->Html->link(__l('Inbox (<span class="js-unread no-mar no-pad">' . $inbox . '</span>)') , array('controller' => 'messages', 'action' => 'inbox'),array('title'=>__l('Inbox'),'escape'=>false)); ?>
			</li>
<?php endif; ?>
			<li class=" span pull-left <?php echo (((isset($folder_type)) and ($folder_type == 'sent')) ? 'active' : 'inactive'); ?>">
				<?php echo $this->Html->link(__l('Sent Mail') , array('controller' => 'messages', 'action' => 'sentmail'),array('title'=>__l('Sent Mail'))); ?>
			</li>
<?php if ($draft == 0) :  ?>
			<li class="span pull-left starred js-message-starred {'star_count':'<?php echo $stared;?>'} <?php echo (isset($folder_type) and $folder_type == 'all' and isset($is_starred) and $is_starred == 1) ? 'active' : 'inactive'; ?>">
				<?php echo $this->Html->link(__l('Starred (' . $stared . ')') , array('controller' => 'messages', 'action' => 'starred'),array('title'=>__l('Starred (' . $stared . ')'))); ?><em class="starred"></em>
			</li>
<?php else : ?>
			<li class="span pull-left starred js-message-starred {'star_count':'<?php echo $stared;?>'} <?php echo (isset($folder_type) and $folder_type == 'all' and isset($is_starred) and $is_starred == 1) ? 'active' : 'inactive'; ?>">
				<?php echo $this->Html->link(__l('Starred (' . $stared . ')') , array('controller' => 'messages', 'action' => 'starred'),array('title'=>__l('Starred'))); ?><em class="starred"></em>
			</li>
<?php endif; ?>
		</ul>
		</div>
<div class="compose-button no-mar ver-space pull-right">
    <?php $class = (((isset($compose)) and ($compose == 'compose')) ? 'compose-mail compose-active' : 'compose-mail compose-inactive'); ?>
    <?php echo $this->Html->link(__l('Compose Message') , array('controller' => 'messages', 'action' => 'compose'), array('class' => 'btn btn-success '. $class, 'title'=>__l('Compose Message'))); ?>
</div>
</div>