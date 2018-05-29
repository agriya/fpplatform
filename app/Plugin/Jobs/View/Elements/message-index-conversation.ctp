<?php
	echo $this->requestAction(array('controller' => 'messages', 'action' => 'index', 'order_id' => $order_id, 'admin' => false), array('return'));
?>