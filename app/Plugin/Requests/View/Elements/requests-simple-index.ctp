<?php
	echo $this->requestAction(array('controller' => 'requests', 'action' => 'index','view_type'=>'simple_index', 'user_id' => $user_id, 'limit' => 5, 'view_request_id' => $view_request_id), array('return'));
?>
