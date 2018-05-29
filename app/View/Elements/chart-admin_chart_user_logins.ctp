<?php
	echo $this->requestAction(array('controller' => 'charts', 'action' => 'chart_user_logins', 'admin' => true), array('named' => array('role_id' => $role_id), 'return'));
?>