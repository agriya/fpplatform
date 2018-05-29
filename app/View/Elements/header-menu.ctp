<?php if ($this->request->params['action'] != 'show_header') { ?>
	<div id="js-head-menu" class="hide">
<?php } ?>
<ul class="nav no-mar dc">
	<?php if (isPluginEnabled('Requests')): ?>
	<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'requests' && $this->request->params['action'] == 'index')? 'active' : null; ?>
	<li class="dropdown <?php echo $class; ?> selling"> 
		<?php echo $this->Html->link(__l('Selling'), array('controller' => 'requests', 'action' => 'index', 'admin' => false), array('title' => __l('Selling')));?>
	</li>
	<?php endif;?>
	<?php if (isPluginEnabled('Jobs')): ?>
	<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'jobs' && $this->request->params['action'] == 'index')? 'active' : null; ?>
	<li class="dropdown <?php echo $class; ?> request"> 
		<?php echo $this->Html->link(__l('Buying'), array('controller' => 'jobs', 'action' => 'index', 'admin' => false), array('title' => __l('Buying')));?>
	</li>
	<?php endif;?>
	<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'nodes' && $this->request->params['action'] == 'how_it_works')? 'active' : null; ?>
	<li class="dropdown <?php echo $class; ?> how_it_works"> 
		<?php echo $this->Html->link(__l('How it Works'), array('controller' => 'nodes', 'action' => 'how_it_works', 'admin' => false), array('title' => __l('How it Works')));?>
	</li>
</ul>
<div class="pull-right mob-clr dc">
	<ul class="nav nav-right dc no-mar">
	  <li><?php echo $this->Form->create('Job', array('class' => 'form-search bot-mspace sep clearfix mob-inline', 'type' => 'get', 'action' => 'index')); ?>
		  <div class="submit"><i class="icon-search text-16 graylightc"></i></div>
		  <div class="input text searchfield">
			<label for="search-text" class="hide"><?php echo __l('Search');?></label>
			<input type="search" name="q" id="search-text" placeholder="">
		  </div>
		<?php echo $this->Form->end();?>
	  </li>
	  <?php if($this->Auth->sessionValid()){ ?>
		<?php $notification_count = $this->Html->getUserUnReadMessages($this->Auth->user('id'),1);
		$notification_count = !empty($notification_count) ? $notification_count : '';
		$activity_url = Router::url(array('controller' => 'messages','action' => 'notification','type'=> 'notification'), true); ?> <?php $class=(!empty($this->request->params['controller']) && $this->request->params['controller'] == 'messages' && $this->request->params['action'] == 'notification') ? 'active' : ''; ?>
		<li class="dc <?php echo $class; ?> span hor-smspace dropdown notification">
		<a class="pr js-notification js-bottom-tooltip" data-target="#" data-toggle="dropdown" href="<?php echo $activity_url; ?>" title="<?php __l('Activities'); ?>">
		<i class="text-20 header-icon icon-globe no-pad"></i>
		<span class="badge badge-important pa count-label"><?php echo $this->Html->cInt($notification_count, false);?></span></a>
		<div class="dropdown-menu arrow js-notification-list clearfix pull-right">
		  <div class="dc">
		  <?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]') ,'width' => 16, 'height' => 11)); ?></div>
		  </div>
		</li>
		<?php
				$message_count = $this->Html->getUserUnReadMessages($this->Auth->user('id'),0);
				$message_count = !empty($message_count) ? $message_count : '';
			?>
		 <?php $class=(!empty($this->request->params['controller']) && $this->request->params['controller'] == 'messages' && $this->request->params['action'] == 'index') ? 'active' : ''; ?>
		<li class="dc <?php echo $class; ?>">
		  <?php echo $this->Html->link('<i class="text-20 header-icon icon-envelope no-pad"></i><span class="badge badge-info pa count-label js-unread">' . $this->Html->cInt($message_count, false).'</span>', array('controller' => 'messages', 'action' => 'inbox', 'admin' => false), array('title' => __l('Messages'), 'escape' => false, 'class' => 'pr'));?>
			</li>
	 <li class="dropdown"> 
		 <?php $user = $this->Html->getCurrUserInfo($this->Auth->user('id'));  ?>
		 <a data-toggle="dropdown" class="dropdown-toggle" title="<?php echo $user['User']['username'];?>" href="#">
		 <?php  echo $this->Html->getUserAvatarLink($user['User'], 'micro_thumb', false);
		 ?>        
		<span class="caret"></span></a>
		<ul class="dropdown-menu dl pull-right">
			<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'dashboard')? 'active' : null; ?>
			<li class="<?php echo $class;?> dashboard"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'dashboard'), array('title' => __l('Dashboard'), 'escape' => false));?></li>
			<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'user_profiles' && $this->request->params['action'] == 'edit')? 'active' : null; ?>
			<li class="<?php echo $class;?> editprofile"><?php echo $this->Html->link(__l('Account Settings'), array('controller' => 'user_profiles', 'action' => 'edit'), array('title' => __l('Account Settings'), 'escape' => false));?></li>
			<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'jobs' && $this->request->params['action'] == 'manage')? 'active' : null; ?>
			<li class="<?php echo $class;?> sellercp"><?php echo $this->Html->link(__l('Seller CP'), array('controller' => 'jobs', 'action' => 'manage', 'admin' => false), array('title' => __l('Seller Control Panel')));?></li>
			<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'job_orders' && $this->request->params['action'] == 'index')? 'active' : null; ?>
			<li class="<?php echo $class;?> buyercp"><?php echo $this->Html->link(__l('Buyer CP'), array('controller' => 'job_orders', 'action' => 'index', 'type'=>'myorders', 'status'=>'active', 'admin' => false), array('title' => __l('Buyer Control Panel')));?></li>
			<?php if (isPluginEnabled('SocialMarketing')): ?>
				<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'social_marketings' && $this->request->params['action'] == 'import_friends')? 'active' : null; ?>
				<li class="<?php echo $class;?> findfriends"><?php echo $this->Html->link(__l('Find Friends'), array('controller' => 'social_marketings', 'action' => 'import_friends','type' => 'facebook'), array('title' => __l('Find Friends'), 'escape' => false));?></li>
			<?php endif; ?>
			<li class="divider"></li>
			<li><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'js-no-pjax', 'title' => __l('Logout'), 'escape' => false));?></li>
		</ul>
	</li>
	<?php } else {?>
	  <li>
	  <ul class="nav unstyled inner-menu no-mar hide" id="js-before-login-head-menu">
		<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'login')? 'active' : null; ?>
		<li class="<?php echo $class;?> login"><?php echo $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login')));?> </li>
		<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'register')? 'active' : null; ?>
		<li class="<?php echo $class;?> register left-space"><?php echo $this->Html->link(__l('Register'), array('controller' => 'users', 'action' => 'register', 'type' => 'social', 'admin' => false), array('title' => __l('Register')));?></li> 
	  </ul>
	  </li>
	<?php } ?>
	<li class="dropdown">
	<?php
	$languages = $this->Html->getLanguage();
	if (Configure::read('user.is_allow_user_to_switch_language') && !empty($languages) && count($languages)>1 ):
	?>
	<a class="dropdown-toggle js-no-pjax" data-toggle="dropdown" href="#"><?php echo isset($_COOKIE['CakeCookie']['user_language']) ?  strtoupper($_COOKIE['CakeCookie']['user_language']) : strtoupper(Configure::read('site.language')); ?><span class="caret"></span></a>
	<ul class="dropdown-menu dl pull-right">
	<?php foreach($languages as $language_id => $language_name) { ?>
	<li><?php  echo $this->Html->link($language_name, '#', array('title' => $language_name, 'class'=>"js-lang-change" , 'data-lang_id' => $language_id));?></li>
	<?php } ?>
	</ul>
	<?php
	endif;
	?>
  </li>
	</ul>
</div>
<?php
	if ($this->request->params['action'] != 'show_header') {
		$script_url = Router::url(array(
			'controller' => 'users',
			'action' => 'show_header',
			'ext' => 'js',
			'admin' => false
		) , true) . '?u=' . $this->Auth->user('id');
		$js_inline = "(function() {";
		$js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
		$js_inline .= "js.src = \"" . $script_url . "\";";
		$js_inline .= "var s = document.getElementById('js-head-menu'); s.parentNode.insertBefore(js, s);";
		$js_inline .= "})();";
?>
<script type="text/javascript">
//<![CDATA[
function getCookie (c_name) {var c_value = document.cookie;var c_start = c_value.indexOf(" " + c_name + "=");if (c_start == -1) {c_start = c_value.indexOf(c_name + "=");}if (c_start == -1) {c_value = null;} else {c_start = c_value.indexOf("=", c_start) + 1;var c_end = c_value.indexOf(";", c_start);if (c_end == -1) {c_end = c_value.length;}c_value = unescape(c_value.substring(c_start,c_end));}return c_value;}if (getCookie('_gz')) {<?php echo $js_inline; ?>} else {document.getElementById('js-head-menu').className = '';document.getElementById('js-before-login-head-menu').className = 'nav unstyled inner-menu no-mar';}
//]]>
</script>
<?php
	}
?>
<?php if ($this->request->params['action'] != 'show_header') { ?>
	</div>
<?php } ?>
