<?php /* SVN: $Id: $ */ ?>
<div class="jobServiceLocations view">
<h2><?php echo __l('Job Service Location');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($jobServiceLocation['JobServiceLocation']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Name');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($jobServiceLocation['JobServiceLocation']['name']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Job Count');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($jobServiceLocation['JobServiceLocation']['job_count']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Description');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($jobServiceLocation['JobServiceLocation']['description']);?></dd>
	</dl>
</div>

