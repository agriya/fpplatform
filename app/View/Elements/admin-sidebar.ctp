
<h5 class="hidden-info"><?php echo __l('Admin side links'); ?></h5>
<ul class="side2-list">
     <?php $class = ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_dashboard') ? ' class="active"' : null; ?>
	<li <?php echo $class;?>><?php echo $this->Html->link(__l('Site Stats'), array('controller' => 'users', 'action' => 'dashboard'),array('title' => __l('Site Stats'))); ?></li>
	<?php $class = (($this->request->params['controller'] == 'users' ) && ($this->request->params['action'] != 'admin_dashboard' && $this->request->params['action'] != 'admin_send_mail' && $this->request->params['action'] != 'change_password')) ? ' class="active"' : null; ?>
	<li <?php echo $class;?>>
		<h4><?php echo __l('Users');?></h4>
		<ul class="admin-sub-links">
		     <?php $class = (($this->request->params['controller'] == 'users' || $this->request->params['controller'] == 'user_profiles') && $this->request->params['action'] != 'admin_dashboard' && $this->request->params['action'] != 'admin_send_mail') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Users'), array('controller' => 'users', 'action' => 'index'),array('title' => __l('Users'))); ?></li>
            <?php $class = ($this->request->params['controller'] == 'user_logins') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('User Logins'), array('controller' => 'user_logins', 'action' => 'index'),array('title' => __l('User Logins'))); ?></li>
			<?php $class = (($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_send_mail' && empty($this->request->params['named']['contact']))) ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Send Email to Users'), array('controller' => 'users', 'action' => 'send_mail'),array('title' => __l('Send Email to Users'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'messages') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('User Messages'), array('controller' => 'messages', 'action' => 'index'),array('title' => __l('Messages'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'contacts' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('User Contact Requests'), array('controller' => 'contacts', 'action' => 'index'),array('title' => __l('Contact Requests'))); ?></li>
            <?php if (isPluginEnabled('Withdrawals')) {?>
			<?php $class = ($this->request->params['controller'] == 'user_cash_withdrawals' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('User Cash Withdrawals'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'),array('title' => __l('User Cash Withdrawals'))); ?></li>
            <?php } ?>
    	</ul>
	</li>
    <?php if (isPluginEnabled('Jobs')) {?>
	<li <?php echo $class;?>>
		<h4><?php echo jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps);?></h4>
		<ul class="admin-sub-links">
			<?php $class = ($this->request->params['controller'] == 'jobs') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'jobs', 'action' => 'index'),array('title' => jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'job_orders') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Orders'), array('controller' => 'job_orders', 'action' => 'index'),array('title' => jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Orders'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'job_favorites') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Favorites'), array('controller' => 'job_favorites', 'action' => 'index'),array('title' => jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Favorites'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'job_feedbacks') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Feedbacks'), array('controller' => 'job_feedbacks', 'action' => 'index'),array('title' => jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Feedbacks'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'job_views') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Views'), array('controller' => 'job_views', 'action' => 'index'),array('title' => jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '. __l('Views'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'job_flags') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Flags'), array('controller' => 'job_flags', 'action' => 'index'),array('title' => jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Flags'))); ?></li>
                       </ul>
            </li>
        <?php } ?>
        <?php if (isPluginEnabled('Requests')) { ?>
            <li <?php echo $class;?>>
		<h4><?php echo requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps);?></h4>
        <ul class="admin-sub-links">
			<?php $class = ($this->request->params['controller'] == 'requests') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps), array('controller' => 'requests', 'action' => 'index'),array('title' => requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'request_favorites') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps).' '.__l('Favorites'), array('controller' => 'request_favorites', 'action' => 'index'),array('title' => requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps).' '.__l('Favorites'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'request_views') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps).' '.__l('Views'), array('controller' => 'request_views', 'action' => 'index'), array('title' => requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps).' '.__l('Views'), 'class' => 'admin-sidmenu')); ?></li>
			<?php $class = ($this->request->params['controller'] == 'request_flags') ? ' class="active"' : null; ?>
            <li <?php echo $class;?>><?php echo $this->Html->link(requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps).' '.__l('Flags'), array('controller' => 'request_flags', 'action' => 'index'),array('title' => requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps).' '.__l('Flags'))); ?></li>
		</ul>
	</li>
    <?php } ?>
	<li <?php echo $class;?>>
		<h4><?php echo __l('Transactions');?></h4>
		<ul class="admin-sub-links">
			<?php $class = ($this->request->params['controller'] == 'transactions') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Transactions'), array('controller' => 'transactions', 'action' => 'index'),array('title' => __l('Transactions'))); ?></li>
		</ul>
	</li>
    <?php if (isPluginEnabled('Disputes')) { ?>
	<li <?php echo $class;?>>
		<h4><?php echo __l('Dispute');?></h4>
		<ul class="admin-sub-links">
            <?php $class = ($this->request->params['controller'] == 'dispute_types') ? ' class="active"' : null; ?>
			<!--<li <?php echo $class;?>><?php echo $this->Html->link(__l('Dispute Types'), array('controller' => 'dispute_types', 'action' => 'index'),array('title' => __l('Dispute Types'))); ?></li>-->
			<?php $class = ($this->request->params['controller'] == 'job_order_disputes') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Disputes'), array('controller' => 'job_order_disputes', 'action' => 'index'),array('title' => __l('Disputes'))); ?></li>
		</ul>
	</li>
    <?php } ?>
    <?php if (isPluginEnabled('Affiliates')) { ?>    
    <li <?php echo $class;?>>
		 <?php echo $this->element('Affiliates.affiliate_admin_sidebar');?>
	</li>    
    <?php } ?>
    <li <?php echo $class;?>>
        <h4><?php echo __l('Tools');?></h4>
        <ul class="admin-sub-links">
            <?php $class = ($this->request->params['controller'] == 'nodes' && !empty($this->request->params['pass']['0']) && $this->request->params['pass']['0'] == "tools") ? ' class="active"' : null; ?>
            <li <?php echo $class;?>><?php echo $this->Html->link(__l('Tools'), array('controller' => 'nodes', 'action' => 'display', 'tools', 'admin' => 1), array('title' => __l('Tools'), 'class' => 'admin-sidmenu')); ?></li>
        </ul>
	</li>
	 <li <?php echo $class;?>>
        <h4><?php echo __l('Plugins');?></h4>
        <ul class="admin-sub-links">
            <?php $class = ($this->request->params['controller'] == 'extensions_plugins') ? ' class="active"' : null; ?>
            <li <?php echo $class;?>><?php echo $this->Html->link(__l('Plugins'), array('controller' => 'extensions_plugins', 'action' => 'index', 'admin' => 1), array('title' => __l('Tools'), 'class' => 'admin-sidmenu')); ?></li>
        </ul>
	</li>
	
	<li <?php echo $class;?>>
		<h4><?php echo __l('Masters');?></h4>
		<ul class="admin-sub-links">
			<?php $class = ($this->request->params['controller'] == 'banned_ips') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Banned IPs'), array('controller' => 'banned_ips', 'action' => 'index'),array('title' => __l('Banned IPs'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'contact_types') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Contact Types'), array('controller' => 'contact_types', 'action' => 'index'),array('title' => __l('Contact Types'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'email_templates') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Email Templates'), array('controller' => 'email_templates', 'action' => 'index'),array('title' => __l('Email Templates'))); ?></li>
             <?php if (isPluginEnabled('Jobs')) { ?>
			<?php $class = ($this->request->params['controller'] == 'job_types') ? ' class="active"' : null; ?>
             <li <?php echo $class;?>><?php echo $this->Html->link(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Types'), array('controller' => 'job_types', 'action' => 'index'),array('title' => jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Types'))); ?></li>             
			<?php $class = ($this->request->params['controller'] == 'job_categories') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Categories'), array('controller' => 'job_categories', 'action' => 'index'),array('title' => jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Categories'))); ?></li>            
			<?php $class = ($this->request->params['controller'] == 'job_flag_categories') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Flag Categories'), array('controller' => 'job_flag_categories', 'action' => 'index'),array('title' => jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Flag Categories'))); ?></li>
            <?php } if (isPluginEnabled('Requests')) { ?>
            <?php $class = ($this->request->params['controller'] == 'request_flag_categories') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps).' '.__l('Flag Categories'), array('controller' => 'request_flag_categories', 'action' => 'index'),array('title' => requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps).' '.__l('Flag Categories'))); ?></li>
            <?php } ?>
			<?php $class = ($this->request->params['controller'] == 'languages') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Languages'), array('controller' => 'languages', 'action' => 'index'),array('title' => __l('Languages'))); ?></li>
			<?php $class = (($this->request->params['controller'] == 'nodes' && !empty($this->request->params['pass']['0']) && $this->request->params['pass']['0'] != "tools") || ($this->request->params['controller'] == 'nodes' && empty($this->request->params['pass']['0']))) ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l(' Manage Static Pages'), array('controller' => 'nodes', 'action' => 'index', 'plugin' => NULL),array('title' => __l('Manage Static Pages')));?></li>
			 <?php $class = ($this->request->params['controller'] == 'payment_gateways') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Payment Gateways'), array('controller' => 'payment_gateways', 'action' => 'index'),array('title' => __l('Payment Gateways'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'settings') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'),array('title' => __l('Settings'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'transaction_types') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Transactions Types'), array('controller' => 'transaction_types', 'action' => 'index'),array('title' => __l('Transactions Types'))); ?></li>
            <?php if (isPluginEnabled('Translations')) { ?>
			<?php $class = ($this->request->params['controller'] == 'translations') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Translations'), array('controller' => 'translations', 'action' => 'index'),array('title' => __l('Translations'))); ?></li>
            <?php } ?>
		</ul>
	</li>
	<li <?php echo $class;?>>
		<h4><?php echo __l('Diagnostics (Developer purpose only)');?></h4>
		<ul class="admin-sub-links">
  			<?php $class = ($this->request->params['controller'] == 'devs' && $this->request->params['action'] == 'admin_logs') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Debug & Error Log'), array('controller' => 'devs', 'action' => 'logs'),array('title' => __l('Debug & Error Log'))); ?></li>
			<?php $class = ($this->request->params['controller'] == 'adaptive_transaction_logs') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Adaptive Transaction Log'), array('controller' => 'adaptive_transaction_logs', 'action' => 'index'),array('title' => __l('Adaptive Transaction Log'))); ?></li>
			<!--<?php $class = ($this->request->params['controller'] == 'adaptive_ipn_logs') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Adaptive IPN Log'), array('controller' => 'adaptive_ipn_logs', 'action' => 'index'),array('title' => __l('Adaptive IPN Log'))); ?></li> -->
		</ul>
	</li>
	</ul>
