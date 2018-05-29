<?php if (!empty($types_for_layout[$this->Layout->node('type')])): ?>
  <div>
    <?php
      $type = $types_for_layout[$this->Layout->node('type')];
      if ($type['Type']['format_show_author'] || $type['Type']['format_show_date']) {
        __l('Posted');
      }
      if ($type['Type']['format_show_author']) {
        echo ' ' . __l('by') . ' ';
        if ($this->Layout->node('User.website') != null) {
          $author = $this->Html->link($this->Layout->node('User.name'), $this->Layout->node('User.website'));
        } else {
          $author = $this->Layout->node('User.name');
        }
        echo $this->Html->tag('span', $author, array(
          'class' => 'author',
        ));
      }
      if ($type['Type']['format_show_date']) {
        echo ' ' . __l('on') . ' ';
        echo $this->Html->tag('span', $this->Html->cDateTimeHighlight($this->Layout->node('created')), array('class' => 'date'));
      }
    ?>
  </div>
<?php endif; ?>