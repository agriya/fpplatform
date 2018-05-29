<?php /* SVN: $Id: $ */ ?>
<div class="affiliateTypes index">
<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Affiliate Types');?></li>      
	</ul>
<div class="clearfix top-space top-mspace ">		 
  <?php echo $this->element('paging_counter'); ?>
</div>
 <div class="overflow-block">
<table class="table table-striped table-hover sep">
    <tr>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort('name', __l('Name'));?></th>
        <th><?php echo $this->Paginator->sort('commission', __l('Commission'));?></th>
        <th><?php echo __l('Commission Type');?></th>
        <th><?php echo $this->Paginator->sort('is_active', __l('Active?'));?></th>
    </tr>
<?php
if (!empty($affiliateTypes)):

$i = 0;
foreach ($affiliateTypes as $affiliateType):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	if($affiliateType['AffiliateType']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
		$status_class = 'js-checkbox-inactive';
	endif;
	}
?>
	<tr<?php echo $class;?>>
		<td class="dc grayc">
		  <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
            <ul class="dropdown-menu arrow dl">			
			<li><?php echo $this->Html->link('<i class="icon-edit"></i>' . __l('Edit'), array('action' => 'edit', $affiliateType['AffiliateType']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'), 'escape' => false));?></li>           
		  </ul>
          </div>
        </td>        
		<td><?php echo $this->Html->cText($affiliateType['AffiliateType']['name']);?></td>
		<td><?php echo $this->Html->cCurrency($affiliateType['AffiliateType']['commission']);?></td>
		<td><?php echo $this->Html->cText( $affiliateType['AffiliateCommissionType']['description'] . ' ('.$affiliateType['AffiliateCommissionType']['name'].')');?></td>
		<td><?php echo $this->Html->cBool($affiliateType['AffiliateType']['is_active']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="5" class="notice"><?php echo __l('No Affiliate Types available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
</div>