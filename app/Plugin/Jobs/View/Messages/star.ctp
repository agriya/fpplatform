 <?php
          if ($message['Message']['is_starred']) {
            echo $this->Html->link('<i class="icon-star ass text-20 pull-left"></i>', array('controller' => 'messages', 'action' => 'star', $message['Message']['id'],'unstar') , array('class' => 'cur js-star pr js-no-pjax', 'escape' => false));
          } else {
            echo $this->Html->link('<i class="grayc icon-star-empty text-20 pull-left"></i>', array('controller' => 'messages', 'action' => 'star', $message['Message']['id'],'star') , array('class' => 'cur js-star pr js-no-pjax ', 'escape' => false));
          }
          ?>