<footer id="footer" class="footer sep-top top-space mob-space">
	<div class="clearfix top-mspace blackc container-fluid">
		<div class="row">
			<div class="span24">
				<p class="span ver-space">&copy;<?php echo date('Y');?> <?php echo $this->Html->link(Configure::read('site.name'), Router::url('/',true), array('title' => Configure::read('site.name'), 'escape' => false, 'class' => 'site-name textb'));?>.<?php echo __l(' All rights reserved');?>.</p>
				<p class="span ver-space"><span class="pull-left"><a href="<?php echo Router::url('/', true); ?>" title="<?php echo __l('Powered by ') . Configure::read('site.name');?>" target="_blank" class="powered"><?php echo __l('Powered by ') . Configure::read('site.name');?></a></span> <span class="made-in pull-left">, <?php echo __l('made in'); ?></span> <?php echo $this->Html->link(__l('Agriya Web Development'), 'http://www.agriya.com/', array('target' => '_blank', 'title' => __l('Agriya Web Development'), 'class' => 'company'));?> <span class="pull-left"><?php echo Configure::read('site.version');?></span></p>
				<p class="span no-mar ver-space" id="cssilize"><?php echo $this->Html->link(__l('CSSilized by CSSilize, PSD to XHTML Conversion'), 'http://www.cssilize.com/', array('target' => '_blank', 'title' => __l('CSSilized by CSSilize, PSD to XHTML Conversion'), 'class' => 'cssilize'));?></p>
			</div>
		</div>
    </div>
</footer>
