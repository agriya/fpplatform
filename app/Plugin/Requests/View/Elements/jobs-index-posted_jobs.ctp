<?php
	echo $this->requestAction(array('controller' => 'jobs', 'action' => 'index','filter'=>'request-jobs', 'view_type' => 'expanded', 'request_id' => $request_id), array('return'));
?>
