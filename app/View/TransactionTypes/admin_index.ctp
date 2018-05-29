<?php /* SVN: $Id: $ */ ?>
<div class="transactionTypes index">
<div class="contactTypes index js-response">
<div class="clearfix top-space top-mspace sep-top">
<div class="pull-right">
	<?php //echo $this->Html->link('<i class="icon-plus-sign no-pad text-18 hor-space"></i>'.__l('Add'), array('action' => 'add'), array('class' => 'hor-mspace bluec textb text-13','escape'=>false,'title'=>__l('Add'))); ?>
</div>
<?php echo $this->element('paging_counter');?>

</div>
 <div class="tab-pane active in no-mar clearfix" id="active-users">
                    <div class="sep bot-mspace img-rounded clearfix">
                      <table class="table no-mar table-striped table-hover">

    <tr>
        <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
        <th class="sep-right textn"><?php echo $this->Paginator->sort('name', __l('Name'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('is_credit', __l('Credit'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="sep-right textn"><?php echo $this->Paginator->sort('message', __l('Message'), array('class' => 'graydarkerc no-under'));?></th>
    </tr>
<?php
if (!empty($transactionTypes)):

$i = 0;
foreach ($transactionTypes as $transactionType):
?>
	<tr>
		<td class="dc grayc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="grayc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide"><?php echo __l('Action'); ?></span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $transactionType['TransactionType']['id']), array('escape' => false,'class' => 'edit', 'title' => __l('Edit')));?></li>
			   </ul>
   	  </span>
		</td>
		<td class="grayc"><?php echo $this->Html->cText($transactionType['TransactionType']['name']);?></td>
		<td class="dc grayc"><?php echo $this->Html->cBool($transactionType['TransactionType']['is_credit']);?></td>
		<td class="grayc"><?php echo $this->Html->cText($transactionType['TransactionType']['message']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7" class="notice"><?php echo __l('No Transaction Types available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
 <div class="pagination pull-right no-mar mob-clr dc top-space">
<?php
if (!empty($transactionTypes)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>
