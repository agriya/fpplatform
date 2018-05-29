<div class="pull-right dropdown mob-clr"> <a href="#" title="Setting" class="dropdown-toggle btn btn-warning span1 space no-shad" data-toggle="dropdown"><i class="icon-cog whitec no-pad no-mar text-20"></i> <span class="hide">Settings</span></a>
	<ul class="unstyled dropdown-menu arrow arrow-right dl clearfix text-14">
		<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'dashboard')? 'active' : null; ?>
			<li class="<?php echo $class;?> dashboard"><?php echo $this->Html->link('<i class="icon-dashboard"></i>'.__l('Dashboard'), array('controller' => 'users', 'action' => 'dashboard'), array('title' => __l('Dashboard'), 'escape' => false));?></li>
        <?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'user_profiles' && $this->request->params['action'] == 'edit')? 'active' : null; ?>
			<li class="<?php echo $class;?> editprofile"><?php echo $this->Html->link('<i class="icon-cog"></i>'.__l('Account Settings'), array('controller' => 'user_profiles', 'action' => 'edit'), array('title' => __l('Account Settings'), 'escape' => false));?></li>		
		<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'user_notifications' && $this->request->params['action'] == 'edit')? 'active' : null; ?>
		  <li class="<?php echo $class;?>"><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Email Settings'), array('controller' => 'user_notifications', 'action' => 'edit'), array('title' => __l('Email Settings'),'escape'=>false, 'class' => 'grayc'));?></li>
		  <?php if (isPluginEnabled('SocialMarketing')){?>
		  <?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'social_marketings' && $this->request->params['action'] == 'myconnections')? 'active' : null; ?>
		  <li class="<?php echo $class;?>"><?php echo $this->Html->link('<i class="icon-share"></i>'.__l('Social'), array('controller' => 'social_marketings', 'action' => 'myconnections'), array('title' => __l('Social'),'escape'=>false));?></li>
		  <?php }?>
		   <?php if (isPluginEnabled('Sudopay')){?>
		   <?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'sudopays' && $this->request->params['action'] == 'payout_connection' )? 'active' : null; ?>
		   <li class="<?php echo $class;?>"><?php echo $this->Html->link('<i class="icon-money"></i>'.__l('Payment Options'), array('controller' => 'sudopays', 'action' => 'payout_connections'), array('title' => __l('Payment Options'),'escape'=>false));?></li>
		   <?php }?>
			<?php if (!$this->Auth->user('is_openid_register') && !$this->Auth->user('is_yahoo_register') && !$this->Auth->user('is_google_register') && !$this->Auth->user('is_facebook_register') && !$this->Auth->user('is_twitter_register')): ?>
			<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'change_password')? 'active' : null; ?>
			<li class="<?php echo $class;?>"><?php echo $this->Html->link('<i class="icon-lock"></i>'.__l('Change Password'), array('controller' => 'users', 'action' => 'change_password'), array('title' => __l('Change Password'), 'class' => 'grayc', 'escape'=>false));?></li>
			<?php endif; ?>
		  	<?php if (isPluginEnabled('Wallets')):?>
		  <?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'wallets' && $this->request->params['action'] == 'add_to_wallet')? 'active' : null; ?>
		  <li class="<?php echo $class;?>"><?php echo $this->Html->link('<i class="icon-save"></i>'.__l('Add Amount to Wallet'), array('controller' => 'wallets', 'action' => 'add_to_wallet'), array('title' => __l('Add Amount to Wallet'),'escape'=>false, 'class' => 'grayc'));?></li>
			<?php endif;?>
			<?php if (isPluginEnabled('Wallets') && isPluginEnabled('Withdrawals')):?>
		  <?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'user_cash_withdrawals' && $this->request->params['action'] == 'index')? 'active' : null; ?>
		  <li class="<?php echo $class;?>"><?php echo $this->Html->link('<i class="icon-briefcase"></i>'.__l('Cash Withdrawal'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'), array('title' => __l('Cash Withdrawal'),'escape'=>false, 'class' => 'grayc'));?></li>
		  <?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'money_transfer_accounts' && $this->request->params['action'] == 'index')? 'active' : null; ?>
		  <li class="<?php echo $class;?>"><?php echo $this->Html->link('<i class="icon-credit-card"></i>'.__l('Money Transfer Accounts'), array('controller' => 'money_transfer_accounts', 'action' => 'index'), array('title' => __l('Money Transfer Accounts'),'escape'=>false, 'class' => 'grayc'));?></li>
			<?php endif;?>
	</ul>
</div>
