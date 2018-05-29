<?php /* SVN: $Id: $ */ ?>
<div class="ReceivedMoney index">
<h2><?php echo __l('Received Money');?></h2>
<?php echo $this->element('paging_counter');?>
<table class="table table-striped table-hover sep">
    <tr>       
        <th><?php echo $this->Paginator->sort(__l('Sent On'),'created');?></th>        
        <th><?php echo $this->Paginator->sort('amount');?></th>
    </tr>
<?php
if (!empty($sendMoneys)):

$i = 0;
foreach ($sendMoneys as $sendMoney):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>				
		<td><?php echo $this->Html->cDateTimeHighlight($sendMoney['SendMoney']['created']);?></td>		
		<td><?php echo $this->Html->cCurrency($sendMoney['SendMoney']['amount']);?></td>		
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="8"><div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No Received Money available');?></p></div>
		</td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($sendMoneys)) {
    echo $this->element('paging_links');
}
?>
</div>
