<?php
	echo $this->requestAction(array('controller' => 'job_order_disputes', 'action' => 'add','order_id' => $order_id), array('return'));
?>