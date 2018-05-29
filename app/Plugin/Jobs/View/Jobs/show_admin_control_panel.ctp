<?php
	echo $this->element('admin_panel_job_view', array('controller' => 'jobs', 'action' => 'index', 'job' =>$job), array('plugin' => 'Jobs'));
?>