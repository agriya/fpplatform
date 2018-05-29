<div class="clearfix sites-states-block">
    <h2><?php echo __l('Stats'); ?></h2>
      <table class="table table-striped table-bordered table-condensed">
      <thead>
      <tr>
        <th colspan="2">&nbsp;</th>
        <?php foreach($periods as $key => $period){ ?>
        <th class="dr">
          <?php echo $period['display'].' ('.Configure::read('site.currency').')'; ?>
        </th>
        <?php } ?>
      </tr>
      </thead>
      <tbody>
      <?php
      foreach($models as $unique_model){ ?>
        <?php foreach($unique_model as $model => $fields){
          $aliasName = isset($fields['alias']) ? $fields['alias'] : $model;
        ?>

            <?php $element = isset($fields['colspan']) ? 'rowspan ="'.$fields['colspan'].'"' : ''; ?>
            <?php if(!isset($fields['isSub'])) :?>
              <tr>
              <td <?php echo $element;?>>
                <?php echo $fields['display']; ?>
              </td>
            <?php endif;?>
            <?php if(isset($fields['isSub'])) :  ?>
              <td >
                <?php echo $fields['display']; ?>
              </td>
            <?php endif; ?>
            <?php if(!isset($fields['colspan'])) :?>
              <?php foreach($periods as $key => $period){ ?>
                  <td class="dr">
                    <span>
                      <?php
                        if(empty($fields['type'])) {
                          $fields['type'] = 'cInt';
                        }
                        if (!empty($fields['link'])):
                          $fields['link']['stat'] = $key;
                          echo $this->Html->link($this->Html->{$fields['type']}(${$aliasName.$key}), $fields['link'], array('escape' => false, 'title' => __l('Click to View Details')));
                        else:
                          echo $this->Html->{$fields['type']}(${$aliasName.$key});
                        endif;
                      ?>
                    </span>
                  </td>
              <?php } ?>
              </tr>
            <?php endif; ?>

         <?php } ?>
      <?php } ?>

       </tbody>
      </table>

</div>