<div class="blocks index space">
  <div class="alert alert-warning">
    <i class="icon-warning-sign"></i>
    <?php echo __l('Warning! Please edit with caution.'); ?>
  </div>
  <section class="clearfix">
    <div class="pull-left"><?php echo $this->element('paging_counter');?></div>
  </section>
  <section class="space">
    <table class="table table-striped table-bordered table-condensed table-hover no-mar">
      <thead>
        <tr>
          <th><div><?php echo $this->Paginator->sort('title', __l('Title')); ?></div></th>
          <th><div><?php echo $this->Paginator->sort('Region.title', __l('Region')); ?></div></th>
          <th class="dc"><div><?php echo $this->Paginator->sort('status', __l('Status')); ?></div></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (!empty($blocks)):
          foreach ($blocks AS $block) {
          ?>
          <tr>
            <td>
              <?php echo $this->Html->cText($block['Block']['title']);?>
            </td>
            <td>
              <?php echo $block['Region']['title'];?>
            </td>
            <td class="dc">
              <?php echo $this->Html->link($this->Layout->status($block['Block']['status']), array('controller' => 'blocks', 'action' => 'update_status', $block['Block']['id'], 'status' => ($block['Block']['status'] == 1) ? 'inactive' : 'active'), array('class' => 'js-confirm js-no-pjax', 'title' => $block['Block']['title'], 'escape' => false));?>
            </td>
          </tr>
        <?php }
        else: ?>
          <tr>
            <td colspan="5" class="grayc text-16 notice dc">
              <?php echo sprintf(__l('No %s available'), __l('Blocks'));?>
            </td>
          </tr>
        <?php
        endif;
        ?>
      </tbody>
    </table>
  </section>
</div>