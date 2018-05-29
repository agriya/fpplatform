<?php 
if (!empty($jobs)) {
	foreach ($jobs as $job){
		Configure::write('highperformance.jids', Set::merge(Configure::read('highperformance.jids') , $job['Job']['id']));
	}
	$jids = implode(',', Configure::read('highperformance.jids'));
}
?>

<?php 
	$is_job_share_enabled = Configure::read('job.is_job_share_enabled');
	if(!empty($is_job_share_enabled)):
?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<?php endif;?>
<div class="js-lazyload">
<ol class="unstyled project-list clearfix">
<?php
if (!empty($jobs)):

$i = 0;
foreach ($jobs as $job):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li class="span6 ver-space <?php echo ($i == 1)?'no-mar':''; ?>">        
	  <div class="label-default sep-top sep-big sep-primary clearfix">
		<div class="pr job-search">
		<?php $attachment = '';?>
		<?php if(!empty($job['Attachment']['0'])){?>
			<?php echo $this->Html->link($this->Html->showImage('Job', $job['Attachment']['0'], array('dimension' => 'medium_large_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)), 'itemprop' =>'image', 'title' => $this->Html->cText($job['Job']['title'], false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('class' => 'project-img', 'escape' => false));?>
		<?php }else{ ?>
				<?php echo $this->Html->link($this->Html->showImage('Job', $attachment, array('dimension' => 'medium_large_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)), 'title' => $this->Html->cText(__l('I will ').' '.$job['Job']['title'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($job['Job']['amount']), false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('class' => 'project-img', 'escape' => false));?>
		<?php } ?>
		  <div class="arrow-bottom"></div>
		</div>
		<h3 class="ver-mspace text-18 clearfix hor-space">
		<span class="pull-left" title="<?php echo $job['JobType']['name'];?>"><i class="icon-desktop top-space <?php echo ($job['JobType']['name'] == 'Online')?'greenc':'grayc'; ?>"></i></span>
		<?php if (isPluginEnabled('JobFavorites')) { ?>
					<?php
					if($this->Auth->sessionValid()):
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
					?>
			<?php } ?>
		<span class="<?php echo isPluginEnabled('JobFavorites')?'no-mar ':''; ?> span4">
		<?php echo $this->Html->link($this->Html->cText($this->Html->truncate($job['Job']['title'],44)), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']), array('title' => $this->Html->cText($job['Job']['title'], false),'class' => 'js-bootstrap-tooltip htruncate show graydarkerc', 'itemprop' => 'url', 'escape' => false));?>
		</span> 
		
		</h3>

		<div class="left-mspace bot-space clearfix">
			<div class="<?php echo isPluginEnabled('JobFavorites')?'span5':'span6'; ?> no-mar htruncate grayc">
				<?php echo '<span class="pull-left right-smspace">'.__l('by').'</span>'.$this->Html->link($this->Html->cText($job['User']['username']), array('controller'=> 'users', 'action' => 'view', $job['User']['username']), array('class' => 'grayc', 'title' => $this->Html->cText($job['User']['username'],false),'escape' => false));?>
			</div>
		</div>
		<div class="clearfix space">
		  <div class="pull-left"><?php echo $this->Html->siteCurrencyFormat($job['Job']['amount']);?></div>
		  <div class="pull-right">
		  <?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
				<div class="bl-buy-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order', $job['Job']['id']), array('class'=>'js-bootstrap-tooltip textb btn btn-small btn-success','title' => __l('Buy Now')));?>
				</div>
				<div class="al-buy-instr-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order', $job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'js-bootstrap-tooltip textb btn btn-small btn-success','escape' => false));?>
				</div>
				<div class="al-buy-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order', $job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'js-bootstrap-tooltip textb btn btn-small btn-success'));?>
				</div>
				<div class="al-edit-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Edit'), array('controller'=>'jobs','action'=>'edit',$job['Job']['id']), array('title' => __l('Edit'), 'class' => 'btn btn-small btn-success show pull-left textb top-mspace'));?>
				</div>


			<?php } else { ?>
			<?php if($this->Auth->sessionValid()){ ?>
				<?php  if($this->Auth->user('id') != $job['Job']['user_id']) { ?>
					<?php if($job['Job']['job_service_location_id'] == ConstServiceLocation::SellerToBuyer || !empty($job['Job']['is_instruction_requires_attachment']) || !empty($job['Job']['is_instruction_requires_input'])):?>
						<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order', $job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'js-bootstrap-tooltip textb btn btn-small btn-success','escape' => false));?>
					<?php else:?>
						<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order', $job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'js-bootstrap-tooltip textb btn btn-small btn-success'));?>
					<?php endif;?>
				<?php } 
				} else{?>
						<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order', $job['Job']['id']), array('class'=>'js-bootstrap-tooltip textb btn btn-small btn-success','title' => __l('Buy Now')));?>
				<?php } 
			}?>
		  </div>
		</div>
	  </div>
	</li>
<?php
    endforeach; ?>
	<li class="span6 ver-space ">
	<div class="label-default sep-top sep-big sep-primary dc clearfix"> 
	<?php echo $this->Html->link('<span class="show text-18 textb graydarkerc bot-space">'. __l("Your ".jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)." Here").'</span> <span class="textb">'.__l('Post a  '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)).'</span>', array('controller' => 'jobs', 'action' => 'add', 'admin' => false), array('class'=>'empty-list cur no-under greenc', 'escape'=>false, 'title' => __l('Post a '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps))));?>
	</div>
	<div class="label-default sep-bot sep-big sep-secondary dc clearfix empty-mspace"> 
	
	<?php echo $this->Html->link(__l('More '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)), array('controller' => 'jobs', 'action' => 'index', 'admin' => false), array('class'=>'empty-list cur no-under text-18 textb graydarkerc', 'title' => __l('More '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps))));?>
	
	 </div>
</li>
<?php else:
?>
	<?php
		$multiFilter = 0;
		if(!empty($this->request->params['named']['category']) && (!empty($this->request->params['named']['amount']) || !empty($this->request->params['named']['filter'])) && !$multiFilter):
			$multiFilter = 1;
		endif; ?>
	<?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] != 'favorite') && !$multiFilter): ?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.__l('available');?></p></div>
	</li>
	<?php endif;?>
	<?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'favorite') && !$multiFilter):?>
		<?php if(empty($this->request->params['requested'])):?>
			<?php if(empty($job_user['User']['job_favorite_count'])):?>
				<li>
					<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No favorite').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('available');?></p></div>
				</li>
			<?php endif;?>
		<?php endif;?>
	<?php endif;?>
	<?php if(!empty($this->request->params['named']['filter']) && !$multiFilter):?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.$this->request->params['named']['filter'].' '. jobAlternateName(ConstJobAlternateName::Singular) .' '.__l('available');?></p></div>
	</li>
	<?php endif; ?>
	<?php if(!empty($this->request->params['named']['category']) && !$multiFilter):?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('available in '.' '.$this->request->params['named']['category'].' category ');?></p></div>
	</li>
	<?php endif; ?>
	<?php if(!empty($search_result) && !$multiFilter):?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('available for the keyword').'"'.$this->request->params['named']['q'].'"';?></p></div>
	</li>
	<?php endif; ?>
	<?php

	 if(!empty($this->request->params['named']['amount']) && !$multiFilter): ?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('available for the price').' '.'"'.$this->Html->siteCurrencyFormat($this->request->params['named']['amount']).'"';?></p></div>
	</li>
	<?php endif;
	if($multiFilter) : ?>
		<ol class="list">
		<li>
			<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('available');?></p></div>
		</li>
	</ol>
	<?php
	endif;
endif;
?>
</ol>
<?php if(!empty($is_job_share_enabled)):?>
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