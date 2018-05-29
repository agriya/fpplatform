<?php if(isset($this->request->params['named']['slug']) && ($this->request->params['named']['slug'] == 'affiliate')){
  $topSpaceClass = 'top-mspace';
} else {

  $topSpaceClass = '';
} 
$bgcolorClass = '';
$thumbnailClass = 'thumbnail';
$spaceClass = 'space';
  ?>
<?php $this->Layout->setNode($node); ?>
<?php
$hide_class = '';
if($this->Layout->node('slug') != 'home-banner'):
	$hide_class = 'show';
endif;
if (isset($this->request->params['named']['is_home'])):
	if (!empty($this->request->params['named']['is_home'])):
		$hide_class = 'show';
	else:
		$hide_class = 'hide';
	endif;
endif;
?>
<div id="node-<?php echo $this->Layout->node('id'); ?>" class="<?php echo $hide_class;  if(!$this->request->params['isAjax']) {?> container <?php } ?> bot-space node node-type-<?php echo $this->Layout->node('type').' '.$bgcolorClass; ?>">
  <?php $node_arr = array('home-banner')?>
  <?php if (!in_array($this->Layout->node('slug'),$node_arr)) { ?>
      <?php if($this->request->params['named']['slug'] != 'affiliate') { ?>
	  <h2 class="<?php echo $spaceClass; ?> clearfix"><?php echo $this->Layout->node('title'); ?></h2>
	  <?php } ?>
      <?php if( $this->Layout->node('slug') != "private_beta" and  $this->Layout->node('slug') != "pre_launch") { ?>
        <div class="<?php echo $thumbnailClass.' '.$spaceClass.' '.$topSpaceClass; ?> clearfix">
      <?php } ?>
     
  <?php } ?>
  <?php
    echo $this->Layout->nodeInfo();
	$response = Cms::dispatchEvent('View.Project.onProjectAddFormLoad', $this, array('content' => array('count' => '', 'url' =>'')));
	$url = $response->data['content']['url'];
    $display_code = $this->Layout->nodeBody();

    echo strtr($display_code,array(
      '##BROWSE_URL##' => Router::url(array('controller' => 'projects', 'action' => 'discover', 'admin' => false), false),
      '##ADD_URL##' => Router::url($url, false),
      '##BANNER_IMAGE_URL##' => Router::url(array('controller' => 'img', 'action' => 'banner-image.jpg'), false),
    ));
  ?>
  <?php if (!in_array($this->Layout->node('slug'),$node_arr)) { ?>
    <?php if ( $this->Layout->node('slug') != "private_beta" and $this->Layout->node('slug') != "pre_launch") {?>
        </div>
    <?php } ?>
   
  <?php } ?>
</div>
<?php if (!empty($types_for_layout[$this->Layout->node('type')])): ?>
  <div id="comments" class="node-comments">
  <?php
    $type = $types_for_layout[$this->Layout->node('type')];
    if ($type['Type']['comment_status'] > 0 && $this->Layout->node('comment_status') > 0) {
      echo $this->element('comments', array('cache' => array('config' => 'sec')));
    }
    if ($type['Type']['comment_status'] == 2 && $this->Layout->node('comment_status') == 2) {
      echo $this->element('comments_form', array('cache' => array('config' => 'sec')));
    }
  ?>
  </div>
<?php endif; ?>