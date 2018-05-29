<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo $this->Html->cText($title_for_layout, false);?></title>
	<?php
		echo $this->Html->meta('icon'), "\n";
		echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
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
	<?php
    echo $this->element('site_tracker', array('cache' => array('config' => 'sec')));
    $response = Cms::dispatchEvent('View.IntegratedGoogleAnalytics.pushScript', $this);
    echo !empty($response->data['content']) ? $response->data['content'] : '';
  ?>
</head>
<body id="authorize">
	<div id="<?php echo $this->Html->getUniquePageId();?>" class="content">
		    <div class="authorize-page">
    			<?php echo $content_for_layout;?>
            </div>
	</div>
    <?php echo $this->element('site_tracker');?>
</body>
</html>
