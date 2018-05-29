<?php
	echo $this->requestAction(array('controller' => 'messages', 'action' => 'view', $hash,'is_view'=>$is_view), array('return'));
?>