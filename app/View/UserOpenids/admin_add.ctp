<?php /* SVN: $Id: admin_add.ctp 4507 2010-05-03 13:34:54Z josephine_065at09 $ */ ?>
<div class="userOpenids form">
<?php echo $this->Form->create('UserOpenid', array('class' => 'normal form-horizontal '));?>
	<h2><?php echo __l('Add User Openid');?></h2>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('openid');
		echo $this->Form->input('verify',array('type' => 'checkbox'));
	?>
	<div class="clearfix submit-block">
		<?php echo $this->Form->submit(__l('Add'));?>
	</div>
 
    <div class="submit-block clearfix">
    <?php
    echo $this->Form->submit(__l('Add'));
?>
</div>
<?php
	echo $this->Form->end();
?>
</div>
