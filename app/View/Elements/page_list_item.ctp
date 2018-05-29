<div class="actions-handle">
    <span class="row-check"><?php echo $this->Form->checkbox('id.' . $data['Page']['id']) ?></span>
    <?php
        $this->Tree->addItemAttribute('id', 'page-' . $data['Page']['id']);
        $this->Tree->addItemAttribute('class', 'level-' . $depth);
        if (ListHelper::isOdd()) {
            $this->Tree->addItemAttribute('class', 'odd');
        }
        
        // Draft status        
        if ($data['Page']['draft']) {
            echo '<small class="draft-status">(', __l('Draft'), ')</small> ';
        }
    
        echo $this->Html->link($data['Page']['title'], array('action' => 'edit', $data['Page']['id']), array('title' => 'Edit this page.')); 
    ?>
    <span class="row-actions"><?php echo $this->Html->link(__l('View'), array('controller' => 'pages', 'action' => 'view', $data['Page']['url']), array('class' => '', 'rel' => 'permalink', 'title' => 'View this page.')); ?></span>
    <span class="cleaner"></span>
</div>