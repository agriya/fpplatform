<?php
    echo $this->requestAction(array('controller' => 'job_feedbacks', 'action' => 'index','type' => 'feedbacks','view_style' => $view_style, 'job_id' => $job_id), array('return'));
?>