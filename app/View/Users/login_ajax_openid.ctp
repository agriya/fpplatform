<div class="users form js-login-response ajax-login-block">
    <?php
		  echo $this->Form->create('User', array('action' => 'login','class' => 'normal form-horizontal '));
		//echo $this->Form->input(Configure::read('user.using_to_login'));
	 //   echo $this->Form->input('passwd', array('label' => __l('Password')));
        ?>
       
        <?php
		if(!(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') and Configure::read('openid.is_enabled_openid_connect')): 
	?>
		           
	<?php
			echo $this->Form->input('openid', array('id' => 'openid_identifier','class' => 'bg-openid-input', 'label' => __l('OpenID')));
			echo $this->Form->input('type', array('type' => 'hidden', 'value' => 'openid'));
		endif;
		?>
		<?php
		echo $this->Form->input('User.is_remember', array('type' => 'checkbox', 'label' => __l('Remember me on this computer.')));?>
	  	<div class="fromleft open-id-block"> 	<?php echo $this->Html->link(__l('Forgot your password?') , array('controller' => 'users', 'action' => 'forgot_password', 'admin'=>false),array('title' => __l('Forgot your password?'),'class'=>''));
	?>
	<?php if(!(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin')):	?>
	<?php 
			echo $this->Html->link(__l('Register'), array('controller' => 'users', 'action' => 'register', 'admin' => false), array('class'=>'js-no-pjax','data-toggle'=>'modal','data-target'=>'#js-ajax-modal','title' => __l('Register')));
			echo $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login')));
		endif;
        $f = (!empty($_GET['f'])) ? $_GET['f'] : (!empty($this->request->data['User']['f']) ? $this->request->data['User']['f'] : ((!empty($this->request->params['url']['url']) && $this->request->params['url']['url'] != 'admin/users/login' && $this->request->params['url']['url'] != 'users/login') ? $this->request->params['url']['url'] : ''));
		if(!empty($f)) :
            echo $this->Form->input('f', array('type' => 'hidden', 'value' => $f));
        endif;
        ?>
        	</div>

			<div class="clearfix submit-block">
				<?php echo $this->Form->submit(__l('Submit'));?>	
			</div> 
			<?php echo $this->Form->end();?>
</div>