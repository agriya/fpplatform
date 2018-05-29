<?php $thirdParty = true;
if(!empty($this->request->params['named']['order_id']) && !empty($this->request->params['named']['payment_id'])) { 
  $thirdParty = false;
} ?>
<div class="sep-bot bot-mspace"><h2  class="container text-32 bot-space mob-dc"><?php echo __l('Login');?></h2></div>
<div class="container clearfix">
  <?php if(!Configure::read('site.maintenance_mode') && $thirdParty): ?>
	  <section class="clearfix img-rounded">
		<article class="users-login">
		  <div class="span12">
			<?php if (Configure::read('facebook.is_enabled_facebook_connect')): ?>
			  <div class="ver-space">
				<div class="row ver-space sep-bot">
				  <div class="span5 login-block pr">
					<?php if (isPluginEnabled('SocialMarketing')) { ?>
					  <span class="js-facepile-loader loader pull-left offset1 pa space"></span>
					  <span id="js-facepile-section" class="{'fb_app_id':'<?php echo Configure::read('facebook.app_id'); ?>'} sfont"></span>
					<?php } ?>
				  </div>
				  <div class="span7 pull-right login-twtface">
					<?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true); ?>
					<p class="row"><?php echo $this->Html->link($this->Html->image('facebook.png', array('alt' => __l('Login with Facebook'))), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
				  </div>
				</div>
			  </div>
			<?php endif; ?>
			<?php if (Configure::read('twitter.is_enabled_twitter_connect')): ?>
			  <?php if (Configure::read('facebook.is_enabled_facebook_connect')): ?>
				<h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
			  <?php endif; ?>
			  <div class="row page-header space no-border ver-mspace">
				<div class="span7 offset3 bot-space">
				  <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true); ?>
				  <p class="row"><?php echo $this->Html->link($this->Html->image('twitter.png', array('alt' => __l('Login with Twitter'))), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
				</div>
			  </div>
			<?php endif;?>
			<?php if(Configure::read('linkedin.is_enabled_linkedin_connect')):?>
			  <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect'))): ?>
				<h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
			  <?php endif;?>
			  <div class="row page-header space no-border ver-mspace">
				<div class="span7 offset3 bot-space">
				  <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true); ?>
				  <p class="row"><?php echo $this->Html->link($this->Html->image('login-linkedin.png', array('alt' => __l('Login with LinkedIn'))), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
				</div>
			  </div>
			<?php endif; ?>
			<?php if (Configure::read('yahoo.is_enabled_yahoo_connect')): ?>
			  <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect'))): ?>
				<h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
			  <?php endif; ?>
			  <div class="row page-header space no-border ver-mspace">
				<div class="span7 offset3 bot-space">
				  <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true); ?>
				  <p class="row"><?php echo $this->Html->link($this->Html->image('login-yahoo.png', array('alt' => __l('Login with Yahoo!'))), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
				</div>
			  </div>
			<?php endif;?>
			<?php if(Configure::read('google.is_enabled_google_connect')):?>
			  <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect'))): ?>
				<h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
			  <?php endif;?>
			  <div class="row page-header space no-border ver-mspace">
				<div class="span7 offset3 bot-space">
				  <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'google', 'admin' => false), true); ?>
				  <p class="row"><?php echo $this->Html->link($this->Html->image('login-google.png', array('alt' => __l('Login with Google'))), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
				</div>
			  </div>
			<?php endif;?>
			<?php if(Configure::read('googleplus.is_enabled_googleplus_connect')):?>
			  <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect') ||  Configure::read('google.is_enabled_google_connect'))): ?>
				<h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
			  <?php endif;?>
			  <div class="row page-header space no-border ver-mspace">
				<div class="span7 offset3 bot-space">
				  <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true); ?>
				  <p class="row"><?php echo $this->Html->link($this->Html->image('login-googleplus.png', array('alt' => __l('Login with GooglePlus'))), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
				</div>
			  </div>
			<?php endif;?>
			<?php if(Configure::read('openid.is_enabled_openid_connect')):?>
			  <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect') ||  Configure::read('google.is_enabled_google_connect') || Configure::read('googleplus.is_enabled_googleplus_connect'))): ?>
				<h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
			  <?php endif;?>
			  <div class="row page-header space no-border ver-mspace">
				<div class="span7 offset3 bot-space">
				  <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
				  <p class="row"><?php echo $this->Html->link($this->Html->image('login-openid.png', array('alt' => __l('Login with OpenId'))), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
				</div>
			  </div>
			<?php endif;?>
		  </div>
		</article>
		<?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect') ||  Configure::read('google.is_enabled_google_connect') || Configure::read('googleplus.is_enabled_googleplus_connect') || Configure::read('openid.is_enabled_openid_connect'))) {
		  $login_block_class = 'sep-left pull-right span11';?>
		  <h4 class="span ver-space top-mspace pr"><span class="or-ver pa textb"><?php echo __l('Or');?></span></h4>
		<?php } else {
		  $login_block_class = 'span';
		}?>
		<aside class="login-block  mob-clr">
		  <div class="<?php echo $login_block_class; ?>">
	  <?php else:?>
		<h2 class="ver-space dl"><?php echo __l('Login');?></h2>
	  <?php endif;?>
	  <?php echo $this->Form->create('User', array('action' => 'login','class' => 'form-horizontal ver-space form-login'));
	  echo $this->Form->input(Configure::read('user.using_to_login'), array('class' => 'span6'));
	  echo $this->Form->input('passwd', array('label' => __l('Password'), 'class' => 'span6'));?>
	  <?php echo $this->Form->input('User.is_remember', array('type' => 'checkbox', 'label' => __l('Remember me on this computer.')));?>
	  <p class="info">
		<?php echo $this->Html->link(__l('Forgot your password?') , array('controller' => 'users', 'action' => 'forgot_password', 'admin' => false),array('title' => __l('Forgot your password?'),'class' => 'js-no-pjax')); ?>
		<?php if (!(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') && empty($this->request->params['requested'])):  ?> | <?php echo $this->Html->link(__l('Register'), array('controller' => 'users', 'action' => 'register', 'type' => 'social', 'admin' => false), array('title' => __l('Register')));?><?php endif; ?>
		<?php $f = (!empty($_GET['f'])) ? $_GET['f'] : ((!empty($this->request->data['User']['f'])) ? $this->request->data['User']['f'] : (($this->request->params['controller'] != 'users' && ($this->request->params['action'] != 'login' && $this->request->params['action'] != 'admin_login')) ? $this->request->url : ''));
		if(!$thirdParty)
		  $f = 'payments/order/'.$this->request->params['named']['payment_id'].'/order_id:'.$this->request->params['named']['order_id'];
	    if (!empty($f)):
		  echo $this->Form->input('f', array('type' => 'hidden', 'value' => $f));
		endif; ?>
	  </p>
	  <div class="top-space">
		<?php echo $this->Form->submit(__l('Login'), array('class' => 'btn  btn-primary textb text-16')); ?>
	  </div>
	  <?php echo $this->Form->end(); ?>
	  <?php if(!Configure::read('site.maintenance_mode')):?>
		</div>
		</aside>
	    </section>
	  <?php endif;?>
	  <div id="fb-root"></div>
</div>