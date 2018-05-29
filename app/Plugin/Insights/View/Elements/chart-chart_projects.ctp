<?php
if(isPluginEnabled('Pledge')){
  echo $this->requestAction(array('controller' => 'pledge_charts','action' => 'chart_projects', 'admin' => false), array('return'));
  }
  if(isPluginEnabled('Lend')){
  echo $this->requestAction(array('controller' => 'lend_charts','action' => 'chart_projects', 'admin' => false), array('return'));
  }
?>