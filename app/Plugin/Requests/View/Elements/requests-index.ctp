<?php
		if(($this->Auth->sessionValid()) &&
			(($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'view')
			|| ($this->request->params['controller'] == 'user_profiles' && $this->request->params['action'] == 'edit')
			|| (!empty($this->request->params['named']['type']) && ($this->request->params['controller'] == 'jobs' && $this->request->params['action'] == 'index' && $this->request->params['named']['type'] == 'manage_jobs' ))
			|| (($this->request->params['controller'] == 'jobs' && $this->request->params['action'] == 'add'))
			|| (($this->request->params['controller'] == 'jobs' && $this->request->params['action'] == 'edit'))
			|| (!empty($this->request->params['named']['type']) && ($this->request->params['controller'] == 'job_orders' && $this->request->params['action'] == 'index' && $this->request->params['named']['type'] == 'myworks'))
			|| (!empty($this->request->params['named']['type']) && ($this->request->params['controller'] == 'job_orders' && $this->request->params['action'] == 'index' && $this->request->params['named']['type'] == 'gain'))
			|| (!empty($this->request->params['named']['type']) && ($this->request->params['controller'] == 'job_orders' && $this->request->params['action'] == 'index' && $this->request->params['named']['type'] == 'balance'))
		)):
		echo $this->requestAction(array('controller' => 'requests', 'action' => 'index','type'=>'seller'), array('return'));
	else:
		echo $this->requestAction(array('controller' => 'requests', 'action' => 'index'), array('return'));
	endif;	
?>
