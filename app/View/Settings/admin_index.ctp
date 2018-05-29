<ul class="unstyled clearfix row-fluid">
	<?php 
        $replaceArray = array(
    '##PAYMENT_SETTINGS_URL##' => Router::url(array('controller' => 'payment_gateways', 'action' => 'index', 'admin'=>true))
  );
    foreach ($setting_categories as $setting_category): ?>
		<li class="span12 no-mar bot-space">
    <div class="well mspace">
      <h5><?php echo $this->Html->link($this->Html->cText($setting_category['SettingCategory']['name'], false), array('controller' => 'settings', 'action' => 'edit', $setting_category['SettingCategory']['id']), array('title' => $setting_category['SettingCategory']['name'], 'escape' => false)); ?></h5>
      <div class="htruncate-ml2 sfont textn js-tooltip" title="<?php echo $this->Html->cText(strtr($setting_category['SettingCategory']['description'], $replaceArray), false); ?>"><?php echo strtr($setting_category['SettingCategory']['description'], $replaceArray); ?></div>
    </div>
  </li>
	<?php endforeach; ?>
</ul>