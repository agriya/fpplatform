<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<section class="top-smspace sep-bot">
<div class="affiliates container clearfix bot-space">
  <h2 class="container text-32 mob-dc"><?php echo __l('Affiliate');?></h2>
</div>
</section>
<section class="top-smspace sep-bot">
<?php if($user['User']['is_affiliate_user']): ?>
<div class="affiliates container clearfix bot-space">
    <div class="top-mspace">
	<?php if(isPluginEnabled('Withdrawals')):?>
	<div class="pull-right">
				<?php echo $this->Html->link('<i class="icon-share-sign text-18"></i>'.__l('Affiliate Cash Withdrawal Requests'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'),array('title' => __l('Affiliate Cash Withdrawal Requests'),'escape'=>false)); ?>
	</div>
	<?php endif; ?>
    
<?php // TODO need to include
//echo $this->element('Affiliates.user_affiliate_stat', array('cache' => array('config' => 'site_element_cache_10_min', 'key' => $this->Auth->user('id')))); ?>
        	<p>
            <?php echo __l('Share your below unique link for referral purposes'); ?>
            	</p>
                <input type="text" class="refer-box" readonly="readonly" value="<?php echo Router::url(array('controller' => 'users', 'action' => 'refer',  'r' =>$this->Auth->user('username')), true);?>" onclick="this.select()"/>

        	<p><?php echo __l('Share your below unique link by appending to end of site URL for referral'); ?>
            </p>
                <input type="text" class="refer-box" readonly="readonly" value="<?php echo  '/r:'.$this->Auth->user('username');?>" onclick="this.select()"/>
   </div>
  <?php echo $this->element('affiliate_stat', array('cache' => array('time' => Configure::read('site.site_element_cache_10_min')))); ?>
<h2><?php echo __l('Commission History');?></h2>
<?php echo $this->element('paging_counter');?>
<table class="table table-striped table-hover sep">
    <tr>
        <th><?php echo $this->Paginator->sort('created', __l('Created'));?></th>
        <th><?php echo __l('User').'/'. __l(jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps));?></th>
        <th><?php echo $this->Paginator->sort('AffiliateType.name', __l('Type'));?></th>
        <th><?php echo $this->Paginator->sort('AffiliateStatus.name', __l('Status'));?></th>
        <th><?php echo $this->Paginator->sort('commission_amount', __l('Commission')). ' ('. Configure::read('site.currency').')';?></th>
    </tr>
<?php
if (!empty($affiliates)):

$i = 0;
foreach ($affiliates as $affiliate):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr <?php echo $class;?>>
		<td> <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['created']);?></td>
        <td> 
        	<?php 
				if($affiliate['Affiliate']['class'] == 'User'){
			?>	
					<?php echo $this->Html->link($this->Html->cText($affiliate['User']['username']), array('controller'=> 'users', 'action' => 'view', $affiliate['User']['username']), array('escape' => false));?>
			<?php
			   } else{
			?>	
					<?php echo $this->Html->link($this->Html->cText($affiliate['JobOrder']['Job']['title']), array('controller'=> 'jobs', 'action' => 'view', $affiliate['JobOrder']['Job']['slug']), array('escape' => false));?>
					(<?php echo $this->Html->link($this->Html->cText($affiliate['JobOrder']['User']['username']), array('controller'=> 'users', 'action' => 'view', $affiliate['JobOrder']['User']['username'], 'admin' => false), array('escape' => false));?>)
		<?php   } ?>
		</td>
		<td><?php echo $this->Html->cText($affiliate['AffiliateType']['name']);?></td>
		<td>
           <?php echo $this->Html->cText($affiliate['AffiliateStatus']['name']);   ?>
           <?php  if($affiliate['AffiliateStatus']['id'] == ConstAffiliateStatus::PipeLine): ?>
                   <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['commission_holding_start_date']);?>
           <?php endif; ?>
        </td>

		<td><?php echo $this->Html->cFloat($affiliate['Affiliate']['commission_amount']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
<tr>
	<td colspan="6">
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No commission history available');?></p>
		</div>
	</td>
</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($affiliates)) {
    echo $this->element('paging_links');
}
?>
</div>
<?php else: ?>
<div class="affiliates container clearfix bot-space">

	<?php echo $this->element('pages-terms_and_policies', array('cache' => array('config' => 'sec'), 'Plugin' => false, 'slug' => $slug)); ?>
	<?php 	
	if($this->Auth->sessionValid()):
		echo $this->element('affiliate_request-add', array('cache' => array('time' => Configure::read('site.site_element_cache_1_min'), 'key' => $this->Auth->user('id'))));
    endif;    ?>
	</div>
<?php endif; ?>
</section>
