<?php
if((
	($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'dashboard') ||
	($this->request->params['controller'] == 'messages' && $this->request->params['action'] == 'index') ||
	($this->request->params['controller'] == 'affiliates') ||
	($this->request->params['controller'] == 'affiliate_cash_withdrawals') ||
	($this->request->params['controller'] == 'user_notifications' && $this->request->params['action'] == 'edit') ||
	($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'change_password') ||
	($this->request->params['controller'] == 'user_friends' && $this->request->params['action'] == 'import') ||
	($this->request->params['controller'] == 'wallets' && $this->request->params['action'] == 'add_to_wallet')) && $this->Auth->sessionValid() 
):
?>
<div class="lside-tl">
<div class="lside-tr">
  <div class="lside-top">
    <h3 class="username-title"><?php echo $this->Auth->user('username');?></h3>
  </div>
</div>
</div>
	<div class="jobCategories index js-response js-responses">
	<div class="suggest-inner clearfix">
			<ul class="account-list account-list1">
			   <li><?php echo $this->Html->link(__l('Edit Profile'), array('controller' => 'user_profiles', 'action' => 'edit'), array('title' => __l('Edit profile')));?></li>
			   <li><?php echo $this->Html->link(__l('Change Password'), array('controller' => 'users', 'action' => 'change_password'), array('title' => __l('Change password')));?></li>
			   <li><?php echo $this->Html->link(__l('Email settings'), array('controller' => 'user_notifications', 'action' => 'edit'), array('title' => __l('Email settings')));?></li>
               <?php if(isPluginEnabled('SocialMarketing')):?>
                <li><?php  echo $this->Html->link('<i class="icon-share"></i>'.__l('Social'), array('controller' => 'social_marketings', 'action' => 'myconnections'), array('title' => __l('Social'), 'escape'=>false));?></li>
                <?php endif;?>
			</ul>			
		</div>
	</div>
  <div class="lside-bl">
    <div class="lside-br">
    <div class="lside-bmid"></div>
	</div>
  </div>
<?php endif; ?>

<?php
if((isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == 'home') || ($this->request->params['controller'] == 'jobs' && $this->request->params['action'] == 'index' && empty($this->request->params['named']['type']))):
?>
<div class="lside-tl">
<div class="lside-tr">
  <div class="lside-top">
    <h3 class="username-title"><?php echo __l('Top Sellers');?></h3>
  </div>
</div>
</div>
	<div class="jobCategories index js-response js-responses">
	<div class="suggest-inner clearfix">
			<?php
			    echo $this->element('users-top_rated', array('type' => 'top_seller' , 'cache' => array('time' => '1 min')));
			?>
		</div>
	</div>
  <div class="lside-bl">
    <div class="lside-br">
    <div class="lside-bmid"></div>
	</div>
  </div>
<?php endif; ?>
<?php if ($this->request->params['controller'] == 'requests' || $this->request->params['controller'] == 'jobs') :?>
   <div class="main-tl">
                <div class="main-tr">
                <div class="main-top"></div>
              </div>
        	  </div>
              <div class="main-side1 main-side2 clearfix">
<?php endif;?>
<?php
	 if ($this->request->params['controller'] == 'requests') :
	    //echo $this->element('job_types-index', array('display' => 'requests', 'cache' => array('time' => Configure::read('site.element_cache_duration'))));
  	elseif ($this->request->params['controller'] == 'jobs') :
    	//echo $this->element('job_types-index', array('display' => 'jobs', 'cache' => array('time' => Configure::read('site.element_cache_duration'))));
	endif;
?>
<?php if ($this->request->params['controller'] == 'requests' || $this->request->params['controller'] == 'jobs') :?>
	</div>
      <div class="main-bl">
        <div class="main-br">
        <div class="main-bc"></div>
		</div>
      </div>
<?php endif;?>
<?php if(!($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'dashboard')):  
        if(isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == 'home'):?>
		<div class="lside-tl">
			<div class="lside-tr">
			  <div class="lside-top">
				<h3 class="username-title"><?php echo __l('Follow Us On');?></h3>
			  </div>
			</div>
			</div>
				<div class="jobCategories index js-response js-responses">
				<div class="suggest-inner clearfix">
						<ul  class="account-list follow">
						   <li><?php echo $this->Html->link(__l('Twitter'), 'http://twitter.com/'.Configure::read('twitter.site_username'), array('class' =>'twitter', 'title' => __l('Follow me on twitter')));?></li>
						   <li><?php echo $this->Html->link(__l('Facebook'), 'http://facebook.com/'.Configure::read('facebook.username'), array('class' =>'facebook','title' => __l('Follow me on facebook')));?></li>					   
						</ul>			
					</div>
				</div>
			  <div class="lside-bl">
				<div class="lside-br">
				<div class="lside-bmid"></div>
				</div>
			  </div>
		
	<?php endif;?>
<?php endif;?>
<?php
	if(($this->Auth->sessionValid()) &&
		(
			($this->request->params['controller'] == 'requests' && $this->request->params['action'] == 'index' && $this->request->params['named']['type'] == 'manage') || 
			($this->request->params['controller'] == 'job_orders' && $this->request->params['action'] == 'index' && $this->request->params['named']['type'] == 'history') || 
			($this->request->params['controller'] == 'job_orders' && $this->request->params['action'] == 'index' && $this->request->params['named']['type'] == 'myorders') ||
			($this->request->params['controller'] == 'messages' && $this->request->params['action'] == 'activities' && $this->request->params['named']['type'] == 'myorders') ||
			($this->request->params['controller'] == 'job_feedbacks' && $this->request->params['action'] == 'add')
		)
	  ):
?>
<?php if($this->Auth->sessionValid() && ((isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] != 'home') || !isset($this->request->params['pass'][0]))):?>
<div class="lside-tl">
<div class="lside-tr">
  <div class="lside-top">
    <h3 class="username-title"><?php echo __l('Order statuses');?></h3>
  </div>
</div>
</div>

	<div class="jobCategories index js-response js-responses">
		<div class="suggest-inner clearfix">
				<?php
				$buyer_order_statuses =  $this->Html->getBuyerOrderStatuses($this->Auth->user('id'));
				$all_count = $buyer_order_statuses['all_count'];
				$moreActions = $buyer_order_statuses['status'];
			?>	
			<ol class="list">
			<?php 
				$links[] = "<li>".__l('All').' ('.(!empty($all_count) ? $all_count : '0').')'."</li>";
				foreach($moreActions as $key => $value):
					$links[] = "<li>".__l($key)."</li>";
				endforeach;
				echo implode('',$links);
			?>
			</ol>
		</div>
	</div>
  <div class="lside-bl">
    <div class="lside-br">
    <div class="lside-bmid"></div>
	</div>
  </div>
<?php endif;?>
<?php endif;?>