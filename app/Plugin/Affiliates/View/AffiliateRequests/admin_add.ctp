<?php /* SVN: $Id: $ */ ?>
<div class="affiliateRequests form">
<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(__l('Affiliate Requests'), array('controller' => 'affiliate_requests', 'action' => 'index'), array('class' => 'bluec','title'=>__l('Affiliate Requests'))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Add');?></li>      
	</ul>
<?php echo $this->Form->create('AffiliateRequest', array('class' => 'form-horizontal normal requestform'));?>
	<fieldset>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('site_category_id', array('label' => __l('Site Category')));
		echo $this->Form->input('site_name', array('label' => __l('Site Name')));
		echo $this->Form->input('site_description', array('label' => __l('Site Description')));
		echo $this->Form->input('site_url', array('label' => __l('Site URL')));
		echo $this->Form->input('why_do_you_want_affiliate', array('label' => __l('Why Do You Want an Affiliate?')));
		echo $this->Form->input('is_web_site_marketing', array('label' => __l('Web Site Marketing?')));
		echo $this->Form->input('is_search_engine_marketing', array('label' => __l('Search Engine Marketing?')));
		echo $this->Form->input('is_email_marketing', array('label' => __l('Email Marketing?')));
		echo $this->Form->input('special_promotional_method', array('label' => __l('Special Promotional Method')));
		echo $this->Form->input('special_promotional_description', array('label' => __l('Special Promotional Description')));
		
	?>
	<div class="clearfix bot-mspace"><label class='pull-left'><?php echo __l('Approved?');?></label>
  <?php echo $this->Form->input('is_approved', array('legend' => false, 'type' => 'radio', 'options' => array(ConstAffiliateRequests::Pending => __l('Waiting for Approval'), ConstAffiliateRequests::Accepted  => __l('Approved'), ConstAffiliateRequests::Rejected => __l('Disapproved')), 'div' => 'pull-left input checkbox top-smspace left-space'));
  ?></div>

	</fieldset>
	<div class="submit-block clearfix top-mspace top-space">
		<?php echo $this->Form->submit(__l('Add'), array('class'=>'btn btn-primary'));?>
	</div>
	<?php echo $this->Form->end(); ?>
	
</div>
