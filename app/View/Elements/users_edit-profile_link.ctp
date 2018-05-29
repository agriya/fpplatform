	<p class="user-profile-info"><?php echo $this->Auth->user('username').', '.__l(' your public profile page is here').':';?>  
	<?php 
		$profile_url= Router::url(array('controller' => 'users', 'action' => 'view', $this->Auth->user('username')), true);
		echo $this->Html->link($profile_url, array('controller' => 'users', 'action' => 'view', $this->Auth->user('username')),array('target' => '_blank', 'title' => $this->Auth->user('username')));?>
		<?php
			if($this->Auth->user('is_openid_register')):
				$reg_type_class='open-id';
			 endif;
			if($this->Auth->user('fb_user_id')):
				$reg_type_class='facebook';
			 endif;
			 if($this->Auth->user('twitter_user_id')):
				$reg_type_class='twitter';
			 endif;
			?>
		<?php if(!empty($reg_type_class)): ?>
			<span class="<?php echo $reg_type_class; ?>">
				<?php echo __l('This account is associated with your '.$reg_type_class.' profile'); ?>
			</span>
		 <?php endif; ?>
	</p>
		<div class="clearfix user-profile-cancel-block">
		<?php if(!$this->Auth->user('fb_user_id') && !$this->Auth->user('twitter_user_id') && !$this->Auth->user('is_openid_register')):?>
				<?php $class = ($this->request->params['controller'] == 'user_profiles') ? 'active' : null; ?>
			<div class="cancel-block <?php echo $class ; ?>">	<?php echo $this->Html->link(__l('Settings'), array('controller' => 'user_profiles', 'action' => 'edit', 'admin' => false), array('title' => __l('Settings')));?></div>
				<?php $class = ($this->request->params['controller'] == 'users') ? 'active' : null; ?>
			  <?php
			  if(($this->Auth->user('role_id')!= ConstUserTypes::Admin) && (!$this->Auth->user('is_openid_register'))   && (!$this->Auth->user('fb_user_id'))  && (!$this->Auth->user('twitter_user_id'))  && (!$this->Auth->user('is_gmail_register'))  && (!$this->Auth->user('is_yahoo_register')) ) : ?>
            <div class="cancel-block <?php echo $class ; ?>"><?php echo $this->Html->link(__l('Change Password'), array('controller' => 'users', 'action' => 'change_password'), array('title' => __l('Change password')));?></div> <?php endif; ?>
		<?php endif;?>
		<?php if($this->Auth->user('role_id') != ConstUserTypes::Admin): ?>
			<?php $class = ($this->request->params['controller'] == 'user_notifications') ? 'active' : null; ?>
			<div class="cancel-block <?php echo $class ; ?>"><?php echo $this->Html->link(__l('Manage Email settings'), array('controller' => 'user_notifications', 'action' => 'edit', 'admin' => false), array('title' => __l('Manage email notifications')));?></div>
		<?php endif;?>
		<?php   
			$is_wallet_enabled = $this->Html->isWalletEnabled();
			if(!empty($is_wallet_enabled) $$ isPluginEnabled('Wallets')):				
		?>
			<?php $class = ($this->request->params['controller'] == 'wallets' && $this->request->params['action'] == 'add_to_wallet') ? 'active' : null; ?>
			<div class="cancel-block <?php echo $class ; ?>"><?php echo $this->Html->link(__l('Add Amount to Wallet'), array('controller' => 'wallets', 'action' => 'add_to_wallet', 'admin' => false), array('title' => __l('Add Amount to Wallet')));?></div>
		<?php endif;?>
		</div>
