<?php
	echo $this->requestAction(array('controller' => 'insights','action' => 'user_activities_insights', 'admin' => true, 'role_id'=> $role_id), array('return'));
?>
