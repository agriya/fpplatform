<div class="userOpenids form main-content-block round-5 js-corner">
<h2><?php echo __l('Add New OpenID'); ?></h2>
<?php echo $this->Form->create('UserOpenid', array('class' => 'normal form-horizontal '));?>
	<fieldset>
	<?php 
		if($this->Auth->user('role_id') == ConstUserTypes::Admin):
			echo $this->Form->input('user_id');
		endif;
	?>		
	<?php
		echo $this->Form->input('openid', array('id' => "openid_identifier", 'class' => 'bg-openid-input', 'label' => __l('OpenID')));
	?>
	<?php 
		if($this->Auth->user('role_id') == ConstUserTypes::Admin):
			echo $this->Form->input('verify',array('type' => 'checkbox'));
		endif;
	?>		
	</fieldset>

    <div class="submit-block clearfix">
    <?php
    echo $this->Form->submit(__l('Change password'));
?>
</div>
<?php
	echo $this->Form->end();
?>
</div>
<script type="text/javascript" id="__openidselector" src="https://www.idselector.com/widget/button/1"></script>