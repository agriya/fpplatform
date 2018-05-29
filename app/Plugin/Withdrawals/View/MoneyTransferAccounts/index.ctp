<section class="sep-bot top-smspace">
	<div class="container clearfix bot-space">
		<div class="label label-info show text-18 clearfix no-round ver-mspace">
			<div class="span smspace"><?php echo __l('Money Transfer Accounts'); ?></div>
			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
	</div>
</section>
<div class="container">
  <?php echo $this->element('money_transfer_accounts-add'); ?>
  <div class="moneyTransferAccounts clearfix index">
    <section class="space clearfix">
      <div class="pull-left hor-space">
        <?php echo $this->element('paging_counter');?>
      </div>
    </section>
    <section class="space">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <tr>
          <th class="dc"><?php echo __l('Action');?></th>
          <th class="dl"><?php echo __l('Account');?></th>
          <th class="dc"><?php echo $this->Paginator->sort('is_default', __l('Primary'), array('class' => 'graydarkerc no-under'));?></th>
        </tr>
        <?php
          if (!empty($moneyTransferAccounts)):
            $i = 0;
            foreach ($moneyTransferAccounts as $moneyTransferAccount):
              $class = null;
              if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
              }
        ?>
        <tr <?php echo $class;?>>
          <td class="span2 dc">
            <div class="dropdown">
              <a href="javascript:void(0);" title="Actions" data-toggle="dropdown" class="icon-cog grayc cur text-20 dropdown-toggle js-no-pjax"><span class="hide"><?php echo __l('Action'); ?></span></a>
              <ul class="unstyled dropdown-menu dl arrow clearfix">
                <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'money_transfer_accounts', 'action' => 'delete', $moneyTransferAccount['MoneyTransferAccount']['id']), array('class' => 'js-confirm delete ', 'escape'=>false,'title' => __l('Delete')));?></li>
                <?php if(!empty($moneyTransferAccount['MoneyTransferAccount']['is_default'])):?>
                  <li><?php echo $this->Html->link('<i class="icon-check"></i>'.__l('Make as primary'), array('controller' => 'money_transfer_accounts', 'action' => 'update_status', $moneyTransferAccount['MoneyTransferAccount']['id']), array('class' => 'widthdraw','escape'=>false , 'title' => 'Make as primary')); ?></li>
                <?php endif;?>
              </ul>
            </div>
          </td>
          <td class="dl"><?php echo nl2br($this->Html->cText($moneyTransferAccount['MoneyTransferAccount']['account']));?></td>
          <td class="dc"><?php echo $this->Html->cBool($moneyTransferAccount['MoneyTransferAccount']['is_default']);?></td>
        </tr>
        <?php
            endforeach;
          else:
        ?>
        <tr>
          <td colspan="3" class="errorc space">
		   <div class="space dc grayc">
    		<p class="ver-mspace top-space text-16">
			<?php echo sprintf(__l('No %s available'), __l('Money Transfer Accounts'));?>
		   </p>
	      </div>
		 </td>
        </tr>
        <?php
          endif;
        ?>
      </table>
    </section>
    <section class="clearfix hor-mspace bot-space">
      <?php if (!empty($moneyTransferAccounts)):?>
        <div class="pull-right">
          <?php echo $this->element('paging_links'); ?>
        </div>
      <?php endif;?>
    </section>
  </div>
</div>