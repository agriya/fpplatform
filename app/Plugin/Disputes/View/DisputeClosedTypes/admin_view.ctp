<?php /* SVN: $Id: $ */ ?>
<div class="disputeClosedTypes view">
<h2><?php echo __l('Dispute Closed Type');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($disputeClosedType['DisputeClosedType']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Name');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($disputeClosedType['DisputeClosedType']['name']);?></dd>
	</dl>
</div>

