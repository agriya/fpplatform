<?php
	echo $this->requestAction(array('controller' => 'job_order_disputes', 'action' => 'resolve', 'order_id' => $order_id,'admin'=>false), array('return'));
?>