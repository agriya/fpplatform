<div id="<?php echo $authorize_name;?>-authorizecontainer">
    <div id="theme" class="clearfix">
		<span class="site-logo"><?php echo Configure::read('site.name'); ?></span>
		<span class="openid-to"><?php echo __l('to'); ?></span>
		<span class="openid-logo"><?php echo $authorize_name; ?></span>        
    </div>
        <div class="message-content">
            <h2><?php echo sprintf(__l('Redirecting you to authorize %s'), $authorize_name); ?>
                <?php echo $this->Html->image('loading.gif'); ?>
            </h2>
            <p>
                <?php echo sprintf(__l('If your browser doesn\'t redirect you please %s to continue.'), $this->Html->link(__l('click here'), $this->Html->url($redirect_url, false), array('escape' => false))); ?>
            </p>
        </div>
</div>
<meta http-equiv="refresh"  content="5;url=<?php echo $redirect_url; ?>" />
