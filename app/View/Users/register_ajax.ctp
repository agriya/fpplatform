<div class="users form js-login-response  ajax-login-block">
 <div class="clearfix">
	 <div class="openid-block">
        <h5><?php echo __l('Sign In using: '); ?></h5>
		<ul class="list clearfix">
			<?php if(Configure::read('facebook.is_enabled_facebook_connect')):  ?>
			<li class="face-book">				 					
                <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true);  ?>
                <p class="row"><?php echo $this->Html->link(__l('Sign in with Facebook'), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}", 'title' => __l('Sign in with Facebook'))); ?></p>				 
			</li>
            <?php endif; ?>
			<?php if(Configure::read('twitter.is_enabled_twitter_connect')):?>
				<li class="twiiter"><?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true);  ?>                
                <p class="row"><?php echo $this->Html->link(__l('Login with Twitter'), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}", 'title' => __l('Login with Twitter'))); ?></p></li>
			<?php endif;?>
			<?php if (Configure::read('yahoo.is_enabled_yahoo_connect')): ?>
				<li class="yahoo">
                    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true);  ?>
                    <p class="row"><?php echo $this->Html->link(__l('Sign in with Yahoo'), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}", 'title' => __l('Sign in with Yahoo'))); ?></p> 
                </li>
           <?php endif;?>
            <?php if(Configure::read('google.is_enabled_google_connect')):?>           
				<li class="gmail">
                    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'gmail', 'admin' => false), true);  ?>
                    <p class="row"><?php echo $this->Html->link(__l('Sign in with Gmail'), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}", 'title' => __l('Sign in with Gmail'))); ?></p> 
                </li>
          <?php endif;?>
          <?php if(Configure::read('openid.is_enabled_openid_connect')):?>
				<li class="open-id">                
                    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true);  ?>
                    <p class="row"><?php echo $this->Html->link(__l('Sign in with Open ID'), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}", 'title' => __l('Sign in with Open ID'))); ?></p> 
                </li>
        <?php endif;?>
        <?php if(Configure::read('linkedin.is_enabled_linkedin_connect')):?>
                <li class="linked-in">                    
                    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true);  ?>
                    <p class="row"><?php echo $this->Html->link(__l('Sign in with LinkedIn'), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}", 'title' => __l('Sign in with LinkedIn'))); ?></p>
               </li>  
        <?php endif;?>
        <?php if(Configure::read('googleplus.is_enabled_googleplus_connect')):?>
                <li class="google-plus">
                <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true);  ?>
                    <p class="row"><?php echo $this->Html->link(__l('Sign in with Google Plus'), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}", 'title' => __l('Sign in with Google Plus'))); ?></p>                
                </li>
         <?php endif;?>  
		</ul>
	</div>
	</div>
<?php echo $this->Form->create('User', array('id' => 'UserAjaxRegisterForm', 'action' => 'register', 'class' => 'normal form-horizontal  js-ajax-login')); ?>
	<fieldset>
	<?php
		$terms = $this->Html->link(__l('Terms & Policies'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions'), array('target' => '_blank'));	
		echo $this->Form->input('username', array('id' => 'UserAjaxUsername'));
		if(empty($this->request->data['User']['openid_url']) && empty($this->request->data['User']['fb_user_id'])):
			echo $this->Form->input('passwd', array('id' => 'UserAjaxPassword', 'label' => __l('Password')));
		endif;
		if(!empty($this->request->data['User']['is_yahoo_register'])) :
			echo $this->Form->input('is_yahoo_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_yahoo_register']));
		endif;
		if(!empty($this->request->data['User']['is_gmail_register'])) :
			echo $this->Form->input('is_gmail_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_gmail_register']));
		endif;	
		echo $this->Form->input('email', array('id' => 'UserAjaxEmail')); ?>
        <?php
		if(empty($this->request->data['User']['openid_url'])): ?>
        	<div class="input captcha-block clearfix js-captcha-container">
    			<div class="captcha-left">
    	           <?php echo $this->Html->image($this->Html->url(array('controller' => 'users', 'action' => 'show_captcha', 'ajax_register', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?>
    	        </div>
    	        <div class="captcha-right">
        	        <?php echo $this->Html->link(__l('Reload CAPTCHA'), '#', array('class' => 'js-captcha-reload captcha-reload', 'title' => __l('Reload CAPTCHA')));?>
	               <div>
		              <?php echo $this->Html->link(__l('Click to play'), Router::url('/')."flash/securimage/play.swf?audio=". $this->Html->url(array('controller' => 'users', 'action'=>'captcha_play', 'ajax_register'), true) ."&amp;bgColor1=#777&amp;bgColor2=#fff&amp;iconColor=#000&amp;roundedCorner=5&amp;height=19&amp;width=19", array('class' => 'js-captcha-play')); ?>
				   </div>
    	        </div>
            </div>
        	<?php echo $this->Form->input('ajax_captcha', array('label' => __l('Security Code'))); ?>
    		<?php echo $this->Form->input('is_agree_terms_conditions', array('id' => 'UserAjaxIsAgreeTermsConditions', 'label' => __l('I have read, understood &amp; agree to the').' '.$terms)); ?>
            <?php
        endif; ?>
	</fieldset>
	<div class="ajax-login-link">
	<?php
			echo $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login')));
	?>
	</div>
   	<div class="submit-block clearfix">
<?php echo $this->Form->submit(__l('Submit')); ?>
</div>
<?php echo $this->Form->end(); ?>
</div>