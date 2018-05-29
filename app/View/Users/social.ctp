	<div class="sep-bot bot-mspace"><h2  class="container text-32 bot-space mob-dc"><?php echo __l('Register');?></h2></div>
<div class="top-space container">
      <div class="row">
         
<?php if(!Configure::read('site.maintenance_mode')):?>
	<div class="sep-bot">
		<h3 class="dc bot-space"><?php echo __l('Quick Sign Up');?></h3>
	</div>
<section class="clearfix users-login">
  <article class="span15 prefix_5">
  <?php if (Configure::read('facebook.is_enabled_facebook_connect')): ?>
  <div class="ver-space">
  <div class="row ver-space sep-bot dc">
    <div class="span6 login-block pr">
    <?php if (isPluginEnabled('SocialMarketing')) { ?>
    <span class="js-facepile-loader loader pull-left offset1 pa space"></span>
    <span id="js-facepile-section" class="{'fb_app_id':'<?php echo Configure::read('facebook.app_id'); ?>'} sfont"></span>
    <?php } ?>
    &nbsp;
    </div>
    <div class="span7 pull-right login-twtface space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true); ?>
    <?php echo $this->Html->link($this->Html->image('facebook.png', array('alt' => __l('Login with Facebook'),'class'=>'img')), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?>
    </div>
  </div>
  </div>
  <?php endif; ?>
 
   <?php if(Configure::read('twitter.is_enabled_twitter_connect')):?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace sep-bot ">
  <div class="span7 offset3 bot-space">
   <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true); ?>
    <p class="row"><?php echo $this->Html->link($this->Html->image('twitter.png', array('alt' => __l('Login with Twitter'),'class'=>'img')), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
  </div>
  </div>
  <?php endif; ?>

  <?php if(Configure::read('linkedin.is_enabled_linkedin_connect')):?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace sep-bot">
  <div class="span7 offset3 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true); ?>
    <p class="row"><?php echo $this->Html->link($this->Html->image('login-linkedin.png', array('alt' => __l('Login with LinkedIn'),'class'=>'img')), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
  </div>
  </div>
  <?php endif; ?>
  <?php if (Configure::read('yahoo.is_enabled_yahoo_connect')): ?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace mspace sep-bot">
  <div class="span7 offset3 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true); ?>
    <p class="row"><?php echo $this->Html->link($this->Html->image('login-yahoo.png', array('alt' => __l('Login with Yahoo!'),'class'=>'img')), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
  </div>
  </div>
  <?php endif;?>
  <?php if(Configure::read('google.is_enabled_google_connect')):?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace mspace sep-bot">
  <div class="span7 offset3 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'google', 'admin' => false), true); ?>
    <p class="row"><?php echo $this->Html->link($this->Html->image('login-google.png', array('alt' => __l('Login with Google'),'class'=>'img')), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
  </div>
  </div>
  <?php endif;?>
  <?php if(Configure::read('googleplus.is_enabled_googleplus_connect')):?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace mspace sep-bot">
  <div class="span7 offset3 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true); ?>
    <div class="bot-space row"><?php echo $this->Html->link($this->Html->image('login-googleplus.png', array('alt' => __l('Login with GooglePlus'),'class'=>'img')), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></div>
  </div>
  </div>
  <?php endif;?>
  <?php if(Configure::read('openid.is_enabled_openid_connect')):?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace mspace sep-bot">
  <div class="span7 offset3 ">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
    <p class="row"><?php echo $this->Html->link($this->Html->image('login-openid.png', array('alt' => __l('Login with OpenId'),'class'=>'img')), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
  </div>
  </div>
   <?php endif;?>
    <div class="clearfix ver-space">
			<div class="dc grid_9 ">
				<p><span class="show"><?php echo __l('Sign up with a social network to follow your friends ') ?></span> <p>
				<p><span class="show"><?php echo __l('By signing up you agree to the  '); ?>
				<?php echo $this->Html->link(__l('Terms & Conditions'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions'), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => 'js-no-pjax', 'title' => __l('Terms & Conditions'), 'escape' => false)); ?>
				</span></p>
				<p><span class="show"><?php echo __l("If you don't want to sign up with a social network,") . ' ' .$this->Html->link(__l('click here') . '.', array('controller' => 'users', 'action' => 'register', 'manual'), array('title' => __l('Click here'), 'class' => 'js-no-pjax')); ?></span></p>
				<p><?php echo __l('Already have an account?') . ' ' . $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login'))); ?></p>
			</div>
		</div>
  </article>
  
  
  <?php endif;?>
</section>
		<div id="fb-root"></div>
   </div>
</div>
