<?php
	echo $this->requestAction(array('controller' => 'messages', 'action' => 'simple_compose', 'order_id' => $order_id, 'type' => $type,'admin'=>false), array('return'));
?>