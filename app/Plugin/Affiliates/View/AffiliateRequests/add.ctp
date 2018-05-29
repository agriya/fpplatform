<?php /* SVN: $Id: $ */ ?>
<div class="js-responses">
<div class="affiliateRequests form">
	<h2><?php echo __l('Request Affiliate'); ?></h2>    
<?php 
	if($status == 'pending'):
?>
	 <div class="alert alert-success"><?php echo __l('Your request will be confirmed after admin approval.'); ?> </div>
<?php 
	elseif($status == 'rejected' && empty($this->request->params['named']['status'])):
?>
	 <div class="alert alert-error"><?php echo sprintf(__l('Sorry, admin declined your request. If you want submit once again please').' %s', $this->Html->link(__l('Click Here'), array('controller' => 'affiliates', 'action' => 'index', 'status' =>'add'), array('class' => '', 'title' => __l('Click Here')))); ?> </div>
<?php 
	elseif($status == 'add' || (!empty($this->request->params['named']['status']) &&  $this->request->params['named']['status'] == 'add')):
?>
<div class="user-add-form-block">
    <div class="alert"><?php echo __l('This request will be confirmed after admin approval.'); ?> </div>
		<?php echo $this->Form->create('AffiliateRequest', array('class' => 'form-horizontal normal'));?>
			<?php
				echo $this->Form->input('user_id', array('type' => 'hidden'));
				echo $this->Form->input('site_category_id', array('label' => __l('Site Category'), 'options' => $siteCategories));
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
            <div class="submit-block well no-bor no-round dr clearfix">
			  <div class="submit mob-mspace">
        <?php echo $this->Form->submit(__l('Request'), array('class' => 'btn btn-large btn-warning textb text-20')); ?>
        </div>
    </div>
			
			<?php echo $this->Form->end();?>
</div>
<?php 		
	endif;
?>
</div>
</div>