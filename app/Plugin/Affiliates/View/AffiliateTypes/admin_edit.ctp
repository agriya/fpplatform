<?php /* SVN: $Id: $ */ ?>
<div class="affiliateTypes form ">
<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(__l('Affiliate Types'), array('controller' => 'affiliate_types', 'action' => 'index'), array('class' => 'bluec','title'=>__l('Affiliate Types'))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Edit');?></li>      
	</ul>
<table class="table table-striped table-hover sep">
	<thead>
	<tr> 
    	        <th class="dl  sep-right textn"><?php echo __l('Name');?></th>
                <th class="dl  sep-right textn"><?php echo __l('Commission');?></th>
                <th class="dl  sep-right textn"><?php echo __l('Commission Type');?></th>
                <th class="dl  sep-right textn"><?php echo __l('Active?');?></th>
    </tr>
	</thead>
<?php echo $this->Form->create('AffiliateType', array('class' => 'form-horizontal normal ', 'action' => 'edit'));?>
	
    
	<?php
		$types = count($this->request->data['AffiliateType']);
		for($i=0; $i<$types; $i++){
	?>
    <tr> 
    <?php 
			echo $this->Form->input('AffiliateType.'.$i.'.id', array('label' => false)); ?>
<td> <?php			echo $this->Form->input('AffiliateType.'.$i.'.name', array('label' => false)); ?> </td>
<td> <?php			echo $this->Form->input('AffiliateType.'.$i.'.commission', array('label' => false));
			$options = $affiliateCommissionTypes;
			if($this->request->data['AffiliateType'][$i]['id'] == 1)
				unset($options[1]); ?> </td>
<td> <?php			echo $this->Form->input('AffiliateType.'.$i.'.affiliate_commission_type_id', array('options' => $options, 'label' => false)); ?> </td>
<td> <?php			echo $this->Form->input('AffiliateType.'.$i.'.is_active', array('label' => '')); ?> </td>
    </tr> 
    <?php 
		}	
	?>
	
<tr> 
	<td colspan="4" class="dr">	
		<?php echo $this->Form->submit(__l('Update'), array('class'=>'btn btn-primary'));?>
    </td>
</tr>        
	
	<?php echo $this->Form->end(); ?>
</table>    
</div>
