<div class="lside-tl clearfix">
    <div class="lside-tr">
      <div class="lside-top">
        <h3 class="username-title"><?php echo __l('Revenues');?></h3>
      </div>
    </div>
</div>
<div class="suggest-inner">
    <ol class="list">
    	<?php if (!empty($user)):?>
    		<li><span title='<?php echo __l('Total Revenue');?>'><?php echo __l('Total Revenue:').' ';?></span><?php echo $this->Html->siteCurrencyFormat($user['User']['sales_cleared_amount']);?></li>
    		<li><span title='<?php echo __l('Total amount which are in active status');?>'><?php echo __l('Sales Pipeline Amount:').' ';?></span><?php echo $this->Html->siteCurrencyFormat($user['User']['sales_pipeline_amount']);?></li>
    		<li><span title='<?php echo __l('Total lost amount like cancelled by buyer, cancelled by you, etc');?>'><?php echo __l('Sales lost amount:').' ';?></span><?php echo $this->Html->siteCurrencyFormat($user['User']['sales_lost_amount']);?></li>
    	<?php endif;?>
    </ol>
</div>
<div class="lside-bl">
  <div class="lside-br">
      <div class="lside-bmid"></div>
  </div>
</div>