<?php
	echo $this->requestAction(array('controller' => 'job_orders', 'action' => 'verify_work', 'job_order_id' => $order_id), array('return'));
?>