<div class="nodes index">
  <h2><?php echo $title_for_layout; ?></h2>
  <div>
    <ul class="unstyled">
      <li>
        <?php
          echo $this->Html->link(__l('Translate in a new language'), array(
            'controller' => 'languages',
            'action'=>'select',
            'nodes',
            'translate',
            $node['Node']['id'],
          ));
        ?>
      </li>
    </ul>
  </div>
  <?php if (count($translations) > 0) { ?>
    <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-condensed">
      <?php
        $tableHeaders =  $this->Html->tableHeaders(array(
          '',
          __l('Title'),
          __l('Locale'),
          __l('Actions'),
        ));
        echo $tableHeaders;
        $rows = array();
        foreach ($translations AS $translation) {
          $actions  = $this->Html->link(__l('Edit'), array('action' => 'translate', $id, 'locale' => $translation[$runtimeModelAlias]['locale']));
          $actions .= ' ' . $this->Html->link(__l('Delete'), array('action' => 'delete_translation', $translation[$runtimeModelAlias]['locale'], $id), null, __l('Are you sure?'));
          $rows[] = array(
            '',
            $translation[$runtimeModelAlias]['content'],
            $translation[$runtimeModelAlias]['locale'],
            $actions,
          );
        }
        echo $this->Html->tableCells($rows);
        echo $tableHeaders;
      ?>
    </table>
  <?php
    } else {
      echo '<p>' . __l('No translations available.') . '</p>';
    }
  ?>
</div>