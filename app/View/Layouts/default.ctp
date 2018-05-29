<?php
/* SVN FILE: $Id: default.ctp 4995 2010-05-17 10:18:15Z aravindan_111act10 $ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision: 7805 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html>
<html lang="<?php echo isset($_COOKIE['CakeCookie']['user_language']) ?  strtolower($_COOKIE['CakeCookie']['user_language']) : strtolower(Configure::read('site.language')); ?>">
<head>
	<?php echo $this->Html->charset(), "\n";?>
	<title>
		<?php 	
			if(Configure::read('site.slogan') != '') {
				$slogan = array(
					'##JOB_PRICE##' => $this->Html->siteJobAmount(),
				);
				$slogan_text = $this->Html->cText(strtr(Configure::read('site.slogan'), $slogan), false);
			}
			if(Configure::read('site.slogan') != '' && empty($this->request->url)) {
				echo Configure::read('site.name') . " - " . $slogan_text; 
			} else {
				echo Configure::read('site.name');?> | <?php echo $this->Html->cText($title_for_layout, false);
			}	
			
		?>
	</title>
	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
	<![endif]-->
	<?php
		echo $this->Html->meta('icon'), "\n";
		if (!empty($meta_for_layout['keywords'])): echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";  endif;
		if (!empty($meta_for_layout['description'])): echo $this->Html->meta('description', $meta_for_layout['description']), "\n"; endif;
	?>
	<link rel="apple-touch-icon" href="apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png" />
	<link rel="logo" type="images/svg" href="/img/logo.svg"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
	<link href="<?php echo Router::url(array('controller' => 'feeds', 'action' => 'index', 'ext' => 'rss'), true);?>" type="application/rss+xml" rel="alternate" title="RSS Feeds"/>
	<?php echo $this->fetch('seo_paging'); ?>
	<?php
	echo $this->Html->css('default.cache.'.Configure::read('site.version'), null, array('inline' => true));
		$cms = $this->Layout->js();
		$js_inline = 'var cfg = ' . $this->Js->object($cms) . ';';
		$js_inline .= "document.documentElement.className = 'js';";
		$js_inline .= "(function() {";
		$js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
		$js_inline .= "js.src = \"" . $this->Html->assetUrl('default.cache.'.Configure::read('site.version'), array('pathPrefix' => JS_URL, 'ext' => '.js')) . "\";";
		$js_inline .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(js, s);";
		$js_inline .= "})();";
		echo $this->Javascript->codeBlock($js_inline, array('inline' => true));
	// For other than Facebook (facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)), wrap it in comments for XHTML validation...
if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
    echo '<!--', "\n";
endif;
    ?>
<meta property="og:site_name" content="<?php echo Configure::read('site.name'); ?>"/>
<?php if(!empty($meta_for_layout['title'])):?>
<meta property="og:title" content="<?php echo $meta_for_layout['title'];?>"/>
<?php else:?>
<meta property="og:title" content="<?php echo Configure::read('site.name'); ?>"/>	
<?php endif;?>
<?php if(!empty($meta_for_layout['description'])):?>
<meta property="og:description" content="<?php echo $meta_for_layout['description'];?>"/>
<?php else:?>
<meta property="og:description" content="<?php echo Configure::read('site.name'); ?>"/>	
<?php endif;?>
<?php if(!empty($meta_for_layout['image_url'])):?>
<meta property="og:image" content="<?php echo $meta_for_layout['image_url'];?>"/>
<?php else:?>
<meta property="og:image" content="<?php echo Router::url('/', true); ?>img/logo.png"/>	
<?php endif;?>
<?php if(!empty($meta_for_layout['page_url'])):?>
<meta property="og:url" content="<?php echo $meta_for_layout['page_url'];?>"/>
<?php else:?>
<meta property="og:url" content="<?php echo Router::url('/', true); ?>"/>	
<?php endif;?>
<meta content="<?php echo Configure::read('facebook.app_id');?>" property="fb:app_id" />
<?php if (Configure::read('facebook.fb_user_id')): ?>
  <meta property="fb:admins" content="<?php echo Configure::read('facebook.fb_user_id'); ?>"/>
<?php endif; ?>
<?php
    echo $this->element('site_tracker', array('cache' => array('config' => 'sec')));
    $response = Cms::dispatchEvent('View.IntegratedGoogleAnalytics.pushScript', $this);
    echo !empty($response->data['content']) ? $response->data['content'] : '';
  ?>
<?php
if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
    echo '-->', "\n";
endif;
// <--
?>
<?php
	if (env('HTTP_X_PJAX') != 'true') {
		echo $this->fetch('highperformance');
	}
?>
</head>
<body>
	<div id="<?php echo $this->Html->getUniquePageId();?>" class="content container_12">
	<div class="wrapper">
    <?php
	if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
	<div class="alab hide"> <?php //after login admin panel?>
		<div class="well no-mar no-pad adminc container-fluid useradminpannel">
			<div class="no-mar hor-space top-smspace dc clearfix">
				<h1 class="span6 no-pad">
<?php
				echo $this->Html->link((Configure::read('site.name').' '.'<span class="sfont"><small class="sfont textb"> Admin</small></span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false,'class' => 'brand show text-16 textb js-no-pjax', 'title' => (Configure::read('site.name').' '.'Admin')));
?>
				</h1>
				
				<div class="span14 dr no-mar con-height clearfix">
					<span class="grayc"><?php echo __l('You are logged in as Admin'); ?></span>
					<div class="js-alab hide"></div>
				</div>
				<div class="pull-right mob-clr admin-header-right-menu">
					<ul class="unstyled span no-mar">
						<li class="span pull-left">
 <?php
						echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'edit', $this->Auth->user('id')), array('class' => 'js-no-pjax blackc', 'title' => __l('My Account')));
?>
			            </li>
						<li class="span pull-left">
<?php
						echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'blackc js-no-pjax', 'title' => __l('Logout')));
?>
			            </li>
					</ul>
				</div>
          <!-- /.nav-collapse -->
        </div>
        </div>
	</div>
<?php } else { ?>
  	<?php if($this->Auth->sessionValid() && $this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
		<div class="well no-mar no-pad adminc container-fluid useradminpannel">
			<div class="no-mar hor-space top-smspace dc clearfix">
				<h1 class="span6 no-pad">
<?php
				echo $this->Html->link((Configure::read('site.name').' '.'<span class="sfont"><small class="sfont textb"> Admin</small></span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false,'class' => 'brand text-16  show textb js-no-pjax', 'title' => (Configure::read('site.name').' '.'Admin')));
?>
				</h1>
				
				<div class="span14 dr no-mar con-height clearfix">
					<span class="grayc"><?php echo __l('You are logged in as Admin'); ?></span>
					<div class="js-alab">
					<?php if ($this->request->params['controller']=='jobs' && $this->request->params['action']=='view') {
					 echo $this->element('admin_panel_job_view', array('controller' => 'jobs', 'action' => 'index', 'job' => $job)); ?>
					<?php } else if ($this->request->params['controller']=='users' && $this->request->params['action']=='view'){
					 echo $this->element('admin_panel_user_view');
					 } else if ($this->request->params['controller']=='requests' && $this->request->params['action']=='view') {
					 echo $this->element('admin_panel_request_view', array('controller' => 'requests', 'action' => 'index', 'request' => $request)); ?>
					<?php }
					?>
					</div>
				</div>
				<div class="pull-right mob-clr admin-header-right-menu">
					<ul class="unstyled span no-mar">
						<li class="span pull-left">
 <?php
						echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'edit', $this->Auth->user('id')), array('class' => 'js-no-pjax blackc', 'title' => __l('My Account')));
?>
			            </li>
						<li class="span pull-left">
<?php
						echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'blackc js-no-pjax', 'title' => __l('Logout')));
?>
			            </li>
					</ul>
				</div>
          <!-- /.nav-collapse -->
        </div>
        </div>
<?php endif; ?>
<?php } ?>
<header id="header" class="sep-top sep-large sep-primary">
      <div class="navbar no-mar sep-bot">
        <div class="navbar-inner no-pad no-round">
          <div class="container clearfix">
            <h1 class="brand ver-mspace" itemscope="" itemtype="http://schema.org/Organization" >
			<?php echo $this->Html->link($this->Html->image('logo.png', array('alt'=> '[Image: '.Configure::read('site.name').']')),  '/', array('escape' => false, 'itemprop'=>'url', 'title' => Configure::read('site.name')));?></h1>
            <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar mspace"> <i class="icon-align-justify icon-24 blackc"></i></a>
            <div class="nav-collapse clearfix">
              
               <?php echo $this->element('header-menu'); ?>
            </div>
          </div>
        </div>
      </div>
    </header>
		<?php echo $this->Layout->sessionFlash(); ?>
		<section id="pjax-body">
			<?php  
				if (env('HTTP_X_PJAX') == 'true') {
					echo $this->fetch('highperformance'); 
				}
			?>
			<section id="main"  class="clearfix">
				<?php 
						if(($this->request->params['controller'] == 'jobs' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add') && empty($this->request->params['named']['type']))
						|| ($this->request->params['controller'] == 'requests' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add') && empty($this->request->params['named']['type']))):
							 $this->element('home-menu', array('cache' => array('time' => Configure::read('site.element_cache_duration')) ));
						endif;
				?>
				<div class="clearfix">
				<?php
					echo $content_for_layout;
				?>
				</div>
			</section>
		</section>
		<!-- for modal -->
	<div class="modal hide fade" id="js-ajax-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header hide">
    <h3 id="myModalLabel"><?php echo $this->Html->cText($this->pageTitle);?></h3>
  </div>
	<div class="modal-body"></div>
	<div class="modal-footer"><a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a>
	</div>
	</div>	
	<!-- for modal -->
		<div class="footer-push"></div>
		</div>
		<?php if (Configure::read('widget.footer_script')) { ?>
		  <div class="dc clearfix bot-space">
		  <?php echo Configure::read('widget.footer_script'); ?>
		  </div>
	<?php } ?>
    <footer id="footer" class="footer mob-space" itemscope itemtype="http://schema.org/WPFooter">
	<div class="sep-top top-space">	 
    <div class="clearfix top-space blackc container">
	<div class="row">
	<div class="footer-link"><?php echo $this->Layout->menu('footer1'); ?>
	<?php if(isPluginEnabled('Affiliates')):?>
		<?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index', 'admin' => false), array('class' => 'hor-smspace span', 'title' => __l('Affiliates')));?>
	<?php endif; ?>
	  <section class="pull-right mob-clr">
        <ul class="span follow-links unstyled row pull-right">
          <?php
          $facebook_url = $twitter_url = '#';
          if (Configure::read('facebook.username')):
            $facebook_url = Configure::read('facebook.username');
          endif;
          if(Configure::read('twitter.site_username')):
            $twitter_url = 'http://www.twitter.com/'.Configure::read('twitter.site_username');
          endif;
          ?>
          <li class="span facebook pull-left"><?php echo $this->Html->link(__l('Facebook'), $facebook_url, array('title' => __l('Facebook'), 'label' => false,'target' => '_blank', 'class' => 'js-no-pjax show'));?></li>
          <li class="span twitter pull-left"><?php echo $this->Html->link(__l('Twitter'), $twitter_url, array('title' => __l('Twitter'), 'label' => false,'target' => '_blank', 'class' => 'js-no-pjax show'));?></li>
          <li class="span rss pull-left"><?php echo $this->Html->link('RSS', array('controller' => 'feeds', 'action' => 'index', 'ext' => 'rss') , array('class' => 'show js-no-pjax', 'target' => '_blank','title' => __l('RSS feed')));?></li>
        </ul>
     </section>
	</div>
	<section class="span">
	 <div class="row span22 no-mar">
      <p class="span bot-space no-mar"><span itemprop="copyrightYear">&copy; <?php echo date('Y');?> </span><?php echo $this->Html->link(Configure::read('site.name'), '/', array('class' => 'site-name blackc', 'title' => Configure::read('site.name'), 'escape' => false));?>. <?php echo __l('All rights reserved');?>.</p>
      <p class="clearfix span bot-space"><span class="pull-left"><a href="http://fpplatform.dev.agriya.com/" title="<?php echo __l('Powered by FPPlatform'); ?>" target="_blank" class="powered pull-left"><?php echo __l('Powered by FPPlatform');?></a>, </span><span class="pull-left hor-smspace"><?php echo Configure::read('site.version'); ?>, </span><span class="pull-left hor-smspace"><?php echo __l('made in'); ?></span><?php echo $this->Html->link(__l('Agriya Web Development'), 'http://www.agriya.com/', array('target' => '_blank', 'title' => __l('Agriya Web Development'), 'class' => 'company pull-left'));?></p>
      <p id="cssilize"><?php echo $this->Html->link(__l('CSSilized by CSSilize, PSD to XHTML Conversion'), 'http://www.cssilize.com/', array('target' => '_blank', 'title' => __l('CSSilized by CSSilize, PSD to XHTML Conversion')));?></p>
	  </div>
	  </section>
	</div>
    </div>
	</div>
  </footer>
  
</div>
</body>
</html>