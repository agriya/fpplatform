<?php 
	echo $this->requestAction(array('controller' => 'sudopays', 'action' => 'user_accounts','user' => $user, 'request' => $request), array('return')); 
?>