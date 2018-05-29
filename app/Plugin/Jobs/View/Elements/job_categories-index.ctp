<?php
	if(!empty($this->request->params['named']['category'])):
		echo $this->requestAction(array('controller' => 'job_categories', 'action' => 'index','category' => $this->request->params['named']['category'], 'type' => $type, 'display' => $display), array('return'));
	else:
		echo $this->requestAction(array('controller' => 'job_categories', 'action' => 'index', 'type' => $type, 'display' => $display), array('return'));
	endif
	
?>