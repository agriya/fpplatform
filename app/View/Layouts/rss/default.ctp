<?php
//echo $this->Rss->header();
if (!isset($channel)) :
	$channel = array();
endif;
if (!isset($channel['title'])) :
	$channel['title'] = $title_for_layout;
	$slogan = array(
		'##JOB_PRICE##' => $this->Html->siteJobAmount(),
	);
	$slogan_text = $this->Html->cText(strtr(Configure::read('site.slogan'), $slogan), false);
	$channel['description'] = __l($slogan_text);
	$channel['link'] = Router::url('/', true) ;
endif;
echo $this->Rss->document(
	$this->Rss->channel(
		array(), $channel, $content_for_layout
	)
);
?>