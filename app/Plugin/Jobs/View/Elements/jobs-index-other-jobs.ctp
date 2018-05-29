<?php
    echo $this->requestAction(array('controller' => 'jobs', 'action' => 'index','type' => 'other', 'user' => $user, 'job' => $job), array('return'));
?>