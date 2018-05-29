<?php
	echo $this->requestAction(array('controller' => 'job_feedbacks', 'action' => 'add', 'job_order_id' => $order_id, 'view_type' => 'simple-feedback'), array('return'));
?>