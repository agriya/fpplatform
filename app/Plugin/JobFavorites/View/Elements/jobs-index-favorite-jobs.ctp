<?php
    echo $this->requestAction(array('controller' => 'jobs', 'action' => 'index','type' => 'favorite','is_page_title'=>$is_page_title, 'username' => $username), array('return'));
?>