<?php
    echo $this->requestAction(array('controller' => 'jobs', 'action' => 'index','type' => 'related', 'user' => $user, 'job' => $job), array('return'));
?>