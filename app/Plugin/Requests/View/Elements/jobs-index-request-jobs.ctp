<?php
    echo $this->requestAction(array('controller' => 'requests', 'action' => 'index','type' => 'request','is_page_title'=>$is_page_title, 'username' => $username), array('return'));
?>