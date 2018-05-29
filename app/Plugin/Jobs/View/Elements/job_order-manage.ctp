<?php
	echo $this->requestAction(array('controller' => 'job_orders', 'action' => 'manage', 'job_order_id' => $order_id), array('return'));	
?>