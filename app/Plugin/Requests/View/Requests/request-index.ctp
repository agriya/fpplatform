<?php 
if (!empty($requests)) {
	foreach ($requests as $request){
		Configure::write('highperformance.rids', Set::merge(Configure::read('highperformance.rids') , $request['Request']['id']));
	}
}
$rids = implode(',', Configure::read('highperformance.rids'));
?>
<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>

<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<div class="needs-block">
<div class="jobs index js-response js-responses js-jobs-scroll-here js-lazyload">
<div class="js-request-responses">
<div class="clearfix">
<?php echo $this->element('paging_counter');?>
</div>
<ol class="unstyled <?php echo !empty($requests)?'discussion-list':''; ?> ver-space clearfix">
<?php
if (!empty($requests)):

$i = 0;
foreach ($requests as $request):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li class="ver-space sep-bot no-mar clearfix"> 
		<?php echo $this->Html->link($this->Html->showImage('UserAvatar', $request['User']['UserAvatar'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($request['User']['username'], false)), 'class' => 'img-rounded', 'title' => $this->Html->cText($request['User']['username'], false)), false), array('controller'=> 'users', 'action' => 'view', $request['User']['username']), array('class' => 'show pull-left left-space user-thumb', 'title' => $this->Html->cText($request['User']['username'],false),'escape' => false));?>
	  <div class="pull-left left-space clearfix">
		<h3 class="text-18 no-mar clearfix">
		<span class="pull-left" title="<?php echo $request['JobType']['name']; ?>">
		<i class="icon-desktop top-space right-mspace <?php echo ($request['Request']['job_type_id'] == ConstJobType::Online)?'greenc':'grayc'; ?>"></i>
		</span>
		<?php echo $this->Html->link($request['Request']['name'], array('controller' => 'requests', 'action' => 'view', $request['Request']['slug']), array('class' => 'span14 no-mar htruncate graydarkerc', 'title' => $this->Html->cText($request['Request']['name'], false),'escape' => false));?>
		</h3>
		<p> 
		<?php echo $this->Html->link($this->Html->cText($request['User']['username']), array('controller'=> 'users', 'action' => 'view', $request['User']['username']), array('class' => 'graydarkerc no-under bot-space right-mspace', 'title' => $this->Html->cText($request['User']['username'],false),'escape' => false));?>
		<span class="grayc"><?php echo $this->Time->timeAgoInWords($request['Request']['created']); ?></span> 
		</p>
	  </div>
	  <div class="span7  tab-clr clearfix">
		<div class="pull-right mob-inline">
		  <p class="pull-left right-space"><?php echo $this->Html->siteCurrencyFormat($request['Request']['amount']);?></p>
			<?php if(isPluginEnabled('HighPerformance')&& Configure::read('HtmlCache.is_htmlcache_enabled')) { ?>
				<div class="al-apply-post-<?php echo $request['Request']['id'];?> hide pull-left">
					<?php echo $this->Html->link(__l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'jobs', 'action' => 'add', 'request_id' => $request['Request']['id']), array('title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps) , 'class' => 'btn btn-small btn-success show pull-left textb top-mspace','escape' => false));?>
				</div>
				<div class="bl-apply-post-<?php echo $request['Request']['id'];?> hide pull-left">
					<?php echo $this->Html->link(__l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps) , 'class' => 'btn btn-small btn-success show pull-left textb top-mspace','escape' => false));?>
				</div>
			<?php }  else { ?>
				<?php if(isPluginEnabled('Jobs')) { ?>
					<?php if($request['User']['username'] != $this->Auth->user('username')) :?>
							<?php echo $this->Html->link(__l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'jobs', 'action' => 'add', 'request_id' => $request['Request']['id']), array('title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps) , 'class' => 'btn btn-small btn-success show pull-left textb top-mspace','escape' => false));?>
					<?php endif; ?>      
				<?php }?>
			<?php }?>
		  </div>
	  </div>
	</li>
<?php
    endforeach;
else:
	 ?>


		<li class="dc">
			<div class="grayc notice text-16 dc">
			<p class="grayc notice text-16 dc"><?php echo __l('No').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.__l(' available');?></p></div>

		</li>
	<?php
endif;
?>
</ol>
<div class="js-pagination pull-right">
<?php
if (!empty($requests)) {
	echo $this->element('paging_links');
}
?>
</div>

<?php if(isPluginEnabled('SocialMarketing')):?>
<div id="fb-root"></div>
	<script type="text/javascript">
	  window.fbAsyncInit = function() {
		FB.init({appId: '<?php echo Configure::read('facebook.app_id');?>', status: true, cookie: true,
				 xfbml: true});
	  };
	  (function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol +
		  '//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
	  }());
	</script>
<?php endif;?>
</div>
</div>
</div>
