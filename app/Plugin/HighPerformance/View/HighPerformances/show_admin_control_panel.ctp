<?php 
if(!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'job') {
	echo $this->element('admin_panel_job_view', array('controller' => 'jobs', 'action' => 'index', 'job' =>$job), array('plugin' => 'Jobs'));
} elseif(!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'request') {
	echo $this->element('admin_panel_request_view', array('controller' => 'requests', 'action' => 'index', 'request' =>$request), array('plugin' => 'Requests'));
} else {
	echo $this->element('admin_panel_user_view');
}
?>