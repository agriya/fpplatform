<h2><?php echo __l('Awesome!'); ?></h2>
<h3><?php echo __l('You are being redirected to the payment page...'); ?></h3>
<div class="progress"></div>
<div class="hide">
	<?php $this->Gateway->$action($gateway_options);?>
</div>
