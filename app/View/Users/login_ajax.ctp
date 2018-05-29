<div class="users form js-login-response ajax-login-block">
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
	<?php
	    echo $this->Form->create('User', array('action' => 'login', 'id' => 'AjaxUserLoginForm', 'class' => 'normal form-horizontal  js-ajax-login'));
		echo $this->Form->input(Configure::read('user.using_to_login'), array('id' => 'AjaxUserUserName'));
	    echo $this->Form->input('passwd', array('label' => __l('Password'), 'id' => 'AjaxUserPasswd'));
        ?>

		<?php
		echo $this->Form->input('User.is_remember', array('type' => 'checkbox', 'id' => 'AjaxUserIsRemember',  'label' => __l('Remember me on this computer.')));?>
	  	<div class="fromleft"> 	
		<?php echo $this->Html->link(__l('Forgot your password?') , array('controller' => 'users', 'action' => 'forgot_password', 'admin'=>false),array('title' => __l('Forgot your password?')));
	?>
	<?php if(!(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin')):	?>
	<?php 
			echo $this->Html->link(__l('Register'), array('controller' => 'users', 'action' => 'register', 'admin' => false), array('class'=>'js-no-pjax','data-toggle'=>'modal','data-target'=>'#js-ajax-modal','title' => __l('Register')));
			?>
			<?php
		endif;
        $f = (!empty($_GET['f'])) ? $_GET['f'] : (!empty($this->request->data['User']['f']) ? $this->request->data['User']['f'] : ((!empty($this->request->params['url']['url']) && $this->request->params['url']['url'] != 'admin/users/login' && $this->request->params['url']['url'] != 'users/login') ? $this->request->params['url']['url'] : ''));
		if(!empty($f)) :
            echo $this->Form->input('f', array('type' => 'hidden', 'id' => 'AjaxUserF', 'value' => $f));
        endif;
        ?>
        	</div>
        	
			<div class="clearfix submit-block">
				<?php echo $this->Form->submit(__l('Submit'));?>	
			</div> 
			<?php echo $this->Form->end();?>
   
</div>