<?php
	echo $this->requestAction(array('controller' => 'users', 'action' => 'top_rated','type' => $type, 'admin' => false), array('return'));
?>