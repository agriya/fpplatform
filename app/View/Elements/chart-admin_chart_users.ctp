<?php
	if(!isPluginEnabled('Contests')){
		echo $this->requestAction(array('controller' => 'charts', 'action' => 'chart_users', 'admin' => true), array('named' =>array('is_ajax_load' => 1, 'role_id' => $role_id),'return'));
	} else  {
		echo $this->requestAction(array('controller' => 'charts', 'action' => 'chart_users', 'admin' => true), array('named' =>array('role_id' => $role_id),'return'));
	}
?>