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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<?php echo $this->Html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo $this->Html->cText($title_for_layout, false);?></title>
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
	<link href="<?php echo Router::url('/', true) . 'feeds.rss';?>" type="application/rss+xml" rel="alternate" title="RSS Feeds" target="_blank" />
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
	?>
	    <?php echo $this->Html->css('maintenance.cache.'.Configure::read('site.version'), null, array('inline' => true)); ?>

	<?php
    echo $this->element('site_tracker', array('cache' => array('config' => 'sec')));
    $response = Cms::dispatchEvent('View.IntegratedGoogleAnalytics.pushScript', $this);
    echo !empty($response->data['content']) ? $response->data['content'] : '';
  ?>
<!--
<meta content="<?php echo Configure::read('facebook.app_id');?>" property="og:app_id" />
<meta content="<?php echo Configure::read('facebook.app_id');?>" property="fb:app_id" />
<?php if(!empty($meta_for_layout['job_name'])):?>
<meta property="og:title" content="<?php echo $meta_for_layout['job_name'];?>"/>
<?php else:?>
<meta property="og:title" content="<?php echo Configure::read('site.name'); ?>"/>	
<?php endif;?>
<meta property="og:site_name" content="<?php echo Configure::read('site.name'); ?>"/>
<?php if(!empty($meta_for_layout['job_name'])):?>
<meta property="og:image" content="<?php echo $meta_for_layout['job_image'];?>"/>
<?php else:?>
<meta property="og:image" content="<?php echo Router::url('/', true); ?>img/logo.png"/>	
<?php endif;?>
-->
</head>
 <body class="maintanace">
    <div id="<?php echo $this->Html->getUniquePageId();?>" class="content">
      <?php echo $this->Layout->sessionFlash(); ?>
      <div class="beta-block">
        <section class="thumbnail dc space thumb-alpha">
          <h1 class="ver-mspace top-space"><?php echo $this->Html->link($this->Html->image('logo.png'),  Router::url('/', true) ,array('title' => Configure::read('site.name'),'escape' => false, 'class'=>"brand"));?></h1>
          <?php echo $content_for_layout; ?>
        </section>
      </div>
    </div>
  </body>
</html>