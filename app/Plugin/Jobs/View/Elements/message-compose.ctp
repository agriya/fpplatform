<?php
	if(!empty($type) && $type == 'deliver'):
		echo $this->requestAction(array('controller' => 'messages', 'action' => 'compose', 'job_order_id' => $order_id, 'order' => 'deliver', 'view_type' => 'simple-deliver'), array('return'));
	else:
		echo 'yet to come';
	endif;
?>