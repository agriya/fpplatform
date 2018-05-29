<?php
    echo $this->requestAction(array('controller' => 'jobs', 'action' => 'index','type' => 'user_jobs_listing', 'username' => $this->Auth->user('username'), 'limit' => 5), array('return'));
?>