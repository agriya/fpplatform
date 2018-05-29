<?php
if(!empty($type) && $type == 'chart' )
	{	echo $this->requestAction(array('controller' => 'users', 'action' => 'selling_panel_chart','user_id' => $user_id, 'admin' => false), array('return')); }
else 
	{ echo $this->requestAction(array('controller' => 'users', 'action' => 'selling_panel','user_id' => $this->Auth->user('id'), 'admin' => false), array('return')); }
?>