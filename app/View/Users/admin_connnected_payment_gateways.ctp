<div class="clearfix">
<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(__l('Users'), array('controller' => 'users', 'action' => 'index'), array('class' => 'bluec','title'=>__l('Users'))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Connected Payment Gateways');?></li>    
	</ul>
<div class="top-space">
	<table class="table table-hover table-striped sep">
	<thead>
	<tr>
	<th><?php echo __l('User'); ?></th>
	<th><?php echo __l('Payment Gateway'); ?></th>
	</tr>
	</thead>
    	<?php 
		if (!empty($sudopayPaymentGateways)):
		 foreach ($sudopayPaymentGateways as $sudopayPaymentGateway):
		 $gateway_datails = unserialize($sudopayPaymentGateway['SudopayPaymentGateway']['sudopay_gateway_details']);
		  ?>
		 <tr>
		 <td> <?php echo $this->Html->link($this->Html->cText($user['User']['username']), array('controller'=> 'users', 'action' => 'view', $user['User']['username'], 'admin' => false), array('escape' => false, 'class' => 'span4 htruncate grayc'));?>
		 </td>
		 <td ><?php echo $this->Html->image($gateway_datails['thumb_url']); ?><?php echo $sudopayPaymentGateway['SudopayPaymentGateway']['sudopay_gateway_name'];?></td></tr>
			
		<?php endforeach;
		endif;?>
    </table>
</div>
</div>
