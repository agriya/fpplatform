<?php 
$jids ='';
Configure::write('highperformance.uids', $this->Auth->user('id'));
if (!empty($jobs)) {
	foreach ($jobs as $job){
		Configure::write('highperformance.jids', Set::merge(Configure::read('highperformance.jids') , $job['Job']['id']));
	}
	$jids = implode(',', Configure::read('highperformance.jids'));
}
$is_job_share_enabled = Configure::read('job.is_job_share_enabled');
if(empty($this->request->params['requested']) && !empty($is_job_share_enabled)): ?>
  <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script><?php 
endif;?>
<div class="jobs index js-response js-jobs-scroll-here js-lazyload">
<?php 
  if ((Configure::read('site.launch_mode') == 'Pre-launch' && $this->Auth->user('role_id') != ConstUserTypes::Admin) || (Configure::read('site.launch_mode') == 'Private Beta' && !$this->Auth->user('id'))) {
	echo $this->element('subscription-add', array('cache' => array('config' => 'sec')), array('plugin' => 'LaunchModes'));
} else { 
?>
  <div class="js-search-responses job-list-block">
  <?php         
    $named = $this->request->params['named'];
	if(empty($this->request->params['named']['is_page_title'])) { ?>
	<?php 
		if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'user_jobs')) : ?>
			<section class="top-smspace sep-bot ">
				<div class="container clearfix bot-space">
					<h2 class="text-32 pull-left"><?php echo jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.'('.$this->Html->cInt($job_user['User']['job_count']).')';?></h2>
				</div>
			</section>
				<?php
		elseif(!empty($this->request->params['named']['q'])):?>
			<section class="top-smspace sep-bot ">
				<div class="container clearfix bot-space">
					<h2 class="text-32 pull-left no-mar right-space mob-dc mob-clr mob-text-32"><?php echo __l('Search Results for').' "'.$this->Html->cText($this->request->params['named']['q']).'"';?></h2>
				</div>
			</section>
			<div class="container">
				<h3 class="pull-left no-mar right-space mob-dc mob-clr mob-text-32"><?php echo jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps); ?></h3>
			</div>
			<?php 
		else : ?> 
			<section class="top-smspace sep-bot ">
				<div class="container clearfix bot-space">
					<h2 class="text-32 pull-left no-mar right-space mob-dc mob-clr mob-text-32"><?php echo $this->pageTitle; ?></h2>
					<?php if(empty($this->request->params['named'])) { ?>
					<span class="pull-left text-16 top-space top-mspace"><?php echo __l('for') . ' ' . $this->Html->siteJobAmount('and', 'no-style');?></span>
					<?php } ?>
		
					<div class="category-block pull-right mob-clr mob-dc clearfix">
					<div class="dropdown pull-left mob-inline mob-ver-space"> 
					<a href="#" title="Categories" class="dropdown-toggle btn btn-warning no-shad pull-left mob-clr" data-toggle="dropdown"> <span class="hor-smspace">Categories</span> <i class="icon-chevron-sign-down text-18"></i></a>
					  <ul class="unstyled dropdown-menu arrow arrow-right dl clearfix">
						<?php 
							$span_size = 'span6';
							if(Configure::read('job.is_enable_online') && Configure::read('job.is_enable_offline')) {
								$span_size = 'span12';
							}
						?>
						<li class="<?php echo $span_size; ?>"><?php 
							if(Configure::read('job.is_enable_online')) {
								echo $this->element('job_categories-index', array('type' => ConstJobType::Online, 'display' => 'jobs', 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); 
							}	
							if(Configure::read('job.is_enable_offline')) {
								echo $this->element('job_categories-index', array('type' => ConstJobType::Offline, 'display' => 'jobs', 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); 
							}
							?>
						</li>
					  </ul>
				   </div>
				   <?php echo $this->element('job-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
				   </div>
				</div>
			</section><?php 
		endif; ?>
		
	<div class="clearfix">
	  <div class="container clearfix">
<?php if(empty($this->request->params['named']['q'])) { ?>
	  <div class="label-default"><div class="space text-24 textb pull-left"><?php echo sprintf(__l('Your %s Here'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps));?></div>
	  <div class="dr"><?php echo $this->Html->link(sprintf(__l('Post a %s'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('controller' => 'jobs', 'action' => 'add', 'admin' => false), array('escape' => false, 'title'=>sprintf(__l('Post a %s'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), 'class' => 'btn btn-small  btn-primary text-16 textb mspace ')); ?></div></div>
	  <?php } ?>
	  <?php
		if (!empty($jobs) && !empty($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'user_jobs' && $this->request->params['named']['type'] != 'favorite'){
			echo $this->element('paging_counter');
	}
	  ?>
	  </div>
	</div><?php 
    } ?>
	<section class="row bot-mspace bot-space">
	  <div class="container clearfix" itemscope itemtype="http://schema.org/WebPageElement">
		<ol class="unstyled project-list ver-space clearfix">
		<?php
		if (!empty($jobs)){
   		  $i = 0;
		  foreach ($jobs as $job){
		    $class = null;
  		    if ($i++ % 2 == 0) {
       		  $class = ' class="altrow"';
			}
			?>
			<li class="span6 ver-space <?php echo ($i == 1 || $i == 5)?'no-mar':''; ?>"><?php 
			  if(isset($job['Job']['is_featured']) && $job['Job']['is_featured'] == 1) { ?>
				<span class="label featured label-warning pa z-top show no-round"><?php echo __l('Featured'); ?></span>
			  <?php } ?>
			  <div class="label-default sep-top sep-big sep-primary clearfix">
				<div class="pr job-search " >
				  <?php $attachment = '';
				  if(!empty($job['Attachment']['0'])){
					echo $this->Html->link($this->Html->showImage('Job', $job['Attachment']['0'], array('dimension' => 'medium_large_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)), 'itemprop' =>'image', 'title' => $this->Html->cText($job['Job']['title'], false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('class' => 'project-img', 'escape' => false));?> <?php 
				  } else { 
					echo $this->Html->link($this->Html->showImage('Job', $attachment, array('dimension' => 'medium_large_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)), 'title' => $this->Html->cText(__l('I will ').' '.$job['Job']['title'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($job['Job']['amount']), false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('class' => 'project-img', 'escape' => false));?><?php 
				  } ?>
				  <div class="arrow-bottom"></div>
				</div>
				<div class="clearfix">
				  <div class="ver-space text-18 clearfix pull-left hor-smspace">
					<span class="pull-left" title="<?php echo $job['JobType']['name'];?>"><i class="icon-desktop top-space <?php echo ($job['JobType']['name'] == 'Online')?'greenc':'grayc'; ?>"></i></span>
					<?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
					  <div class="al-jobunfav-<?php echo $job['Job']['id'];?> hide  pull-left">
						<?php echo $this->Html->link('<i class="icon-heart redc no-pad"></i>', array('controller' => 'job_favorites', 'action'=>'delete', $job['Job']['slug']), array('class' => 'pull-left text-13 no-under delete js-like un-like', 'title' => __l('Unlike'), 'escape' => false));?>
					  </div>
					  <div class="al-jobfav-<?php echo $job['Job']['id'];?> hide  pull-left">
						<?php echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'pull-left text-13 no-under js-like like'));?>
					  </div>
					  <div class="bl-jobfav-<?php echo $job['Job']['id'];?> hide  pull-left">
						<?php echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'pull-left text-13 no-under like'));?>
					  </div>
					<?php } else { 
					  if (isPluginEnabled('JobFavorites')) {
						if($this->Auth->sessionValid()) :
						  if(!empty($job['JobFavorite'])):
							foreach($job['JobFavorite'] as $favorite):
							  if($job['Job']['id'] == $favorite['job_id'] && $favorite['user_id'] == $this->Auth->user('id')):
								echo $this->Html->link('<i class="icon-heart redc no-pad"></i>', array('controller' => 'job_favorites', 'action'=>'delete', $job['Job']['slug']), array('class' => 'pull-left text-13 no-under delete js-like un-like', 'title' => __l('Unlike'), 'escape' => false));
							  endif;
							endforeach;
						  else:
							echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'pull-left text-13 no-under js-like like'));
						  endif;
						else:
						  echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'pull-left text-13 no-under like'));
						endif; 
					  }
					}?>
					</div>
					<h3 class="ver-mspace text-18 clearfix pull-left">
					  <span class="<?php echo isPluginEnabled('JobFavorites')?'span4':'span5'; ?> no-mar htruncate"><?php 
						echo $this->Html->link($this->Html->cText($this->Html->truncate($job['Job']['title'],44)), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']), array('title' => $this->Html->cText($job['Job']['title'], false),'class' => 'graydarkerc', 'itemprop' => 'url', 'escape' => false));?>
					  </span> 
					</h3>
				  </div>
				  <div class="left-mspace bot-space clearfix">
					<div class="<?php echo isPluginEnabled('JobFavorites')?'span4':'span5'; ?> no-mar htruncate grayc"><?php 
					  echo '<span class="pull-left right-smspace">'.__l('by').'</span>'.$this->Html->link($this->Html->cText($job['User']['username']), array('controller'=> 'users', 'action' => 'view', $job['User']['username']), array('class' => 'grayc', 'title' => $this->Html->cText($job['User']['username'],false),'escape' => false));?>
					</div>
				  </div>
				  <div class="clearfix space">
					<div class="pull-left"><?php echo $this->Html->siteCurrencyFormat($job['Job']['amount']);?></div>
					<div class="pull-right"><?php 
					  if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
						<div class="bl-buy-<?php echo $job['Job']['id'];?> hide  pull-left">
						  <?php echo $this->Html->link(__l('Buy Now'), array('controller' => 'users', 'action' => 'login'), array('class'=>'textb btn btn-small btn-success','title' => __l('Buy Now')));?>
						</div>
						<div class="al-buy-instr-<?php echo $job['Job']['id'];?> hide  pull-left">
						  <?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'job_orders','action'=>'add','job' => $job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'textb btn btn-small btn-success','escape' => false));?>
						</div>
						<div class="al-buy-<?php echo $job['Job']['id'];?> hide  pull-left">
						  <?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order',$job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'textb btn btn-small btn-success'));?>
						</div>
						<div class="al-edit-<?php echo $job['Job']['id'];?> hide  pull-left">
						  <?php echo $this->Html->link(__l('Edit'), array('controller'=>'jobs','action'=>'edit',$job['Job']['id']), array('title' => __l('Edit'), 'class' => 'textb btn btn-small btn-success'));?>
						</div><?php 
					  } else { 
						if($this->Auth->sessionValid()) { 
						  if($this->Auth->user('id') != $job['Job']['user_id']) { ?>
							<?php if($job['Job']['job_service_location_id'] == ConstServiceLocation::SellerToBuyer || !empty($job['Job']['is_instruction_requires_attachment']) || !empty($job['Job']['is_instruction_requires_input'])):?>
							  <?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'job_orders','action'=>'add','job' => $job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'textb btn btn-small btn-success','escape' => false));?>
						  <?php else:?>
							<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order',$job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'textb btn btn-small btn-success'));?>
						  <?php endif;
						}
					  } else {
						echo $this->Html->link(__l('Buy Now'), array('controller' => 'users', 'action' => 'login'), array('class'=>'textb btn btn-small btn-success','title' => __l('Buy Now')));
					  } 
					} ?>
				  </div>
				</div>
			  </div>
			</li>
<?php }
	  } else {
?>
	<?php
		$multiFilter = 0;
		$none_filter = 0;
		if((!empty($this->request->params['named']['category']) || !empty($this->request->params['named']['q'])) && (!empty($this->request->params['named']['amount']) || !empty($this->request->params['named']['filter'])) && !$multiFilter):
			$multiFilter = 1;
		endif; ?>
	<?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] != 'favorite') && !$multiFilter):
	$none_filter = 1; ?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.__l('available');?></p>
        </div>
	</li>
	<?php endif;?>
	<?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'favorite') && !$multiFilter):
	 $none_filter = 1; ?>		
				<li>
					<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No favorite').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('available');?></p></div>
				</li>			
	<?php endif;?>
	<?php if(!empty($this->request->params['named']['filter']) && !$multiFilter): 
	 $none_filter = 1; ?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.$this->request->params['named']['filter'].' '. jobAlternateName(ConstJobAlternateName::Singular) .' '.__l('available');?></p></div>
	</li>
	<?php endif; ?>
	<?php if(!empty($this->request->params['named']['category']) && !$multiFilter):  $none_filter = 1;
	?>
	<li>
		<p class="grayc notice text-16 dc"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('available in '.' '.$this->request->params['named']['category'].' category');?></p>
	</li>
	<?php endif; ?>
	<?php if(!empty($this->request->params['named']['q']) && !$multiFilter): 
	$none_filter = 1;
	?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('available for the keyword').' "'.$this->Html->cText($this->request->params['named']['q']).'"';?></p></div>
	</li>
	<?php endif; ?>
	<?php

	 if(!empty($this->request->params['named']['amount']) && !$multiFilter):
	  $none_filter = 1; ?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('available for the price').'"'.$this->Html->siteCurrencyFormat($this->request->params['named']['amount']).'"';?></p></div>
	</li>
	<?php endif;
	if($multiFilter) : 
	 $none_filter = 1; ?>
		<ol class="list unstyled">
		<li>
			<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('available');?></p></div>
		</li>
	</ol>
	<?php
	endif;
	if(!$none_filter) :?>

		<ol class="dc unstyled">
		<li class="dc">
            <div class="thumbnail space dc grayc">
			<p class="grayc notice text-16 dc"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('available');?></p>
            </div>
		</li>
	</ol>
	<?php
	endif;
	  }
?>
</ol>
<div class="clearfix pull-right mob-clr ver-space mob-dc">
<?php
if (!empty($jobs)) {
	echo $this->element('paging_links');
}
?>
</div>

<?php
if (!empty($this->request->params['named']['q']) && isPluginEnabled('Requests')) {
	echo $this->element('request-search', array('q' => $this->request->params['named']['q']));
}
?>
</div>
</section>
<?php if(empty($this->request->params['requested']) && !empty($is_job_share_enabled)):?>
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
<?php } ?>
</div>
