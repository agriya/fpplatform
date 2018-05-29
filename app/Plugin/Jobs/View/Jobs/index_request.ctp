<?php 
$jids='';
if (!empty($jobs)) {
	foreach ($jobs as $job){
		Configure::write('highperformance.jids', Set::merge(Configure::read('highperformance.jids') , $job['Job']['id']));
	}
}
$jids = implode(',', Configure::read('highperformance.jids'));
?>
<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php 
	$is_job_share_enabled = Configure::read('job.is_job_share_enabled');
	if(empty($this->request->params['requested']) && !empty($is_job_share_enabled)):
?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<?php endif;?>
<div class="container jobs index js-response js-responses js-jobs-scroll-here js-lazyload">
<?php
        $named = $this->request->params['named'];
        if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'favorite')):?>
	<?php if(!empty($this->request->params['requested'])):?>
		<?php if(!empty($job_user['User']['job_favorite_count'])):?>
			<h3 class="jobs-title"><?php echo $job_user['User']['username'].' '. __l('favorite').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.'('.$job_user['User']['job_favorite_count'].')';?></h3>
		<?php endif;?>
	<?php else:?>
		<?php if(!empty($job_user['User']['job_favorite_count'])):?>
			<h2 class="jobs-title"><?php echo $job_user['User']['username'].' '. __l('favorite').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.'('.$job_user['User']['job_favorite_count'].')';?></h2>
		<?php else:?>
			<h2 class="jobs-title"><?php echo $job_user['User']['username'].' '. __l(' favorite').' '.jobAlternateName(ConstJobAlternateName::Singular).' ';?></h2>
		<?php endif;?>
	<?php endif;?>
<?php endif;?>		
<?php if(!empty($this->request->params['named']['q'])):?>
	<h2 class="jobs-title"><?php echo __l('Search Results for').' "'.$this->Html->cText($this->request->params['named']['q']).'"';?></h2>
<?php endif; ?>
<?php 
	if(!empty($this->request->params['named']['q'])):
		echo $this->element('paging_counter');
	endif;
	$this->request->params['named'] = $named;
?>
<ol class="unstyled discussion-list ver-space clearfix">
<?php
if (!empty($jobs)):

$i = 0;

foreach ($jobs as $job):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	$attachment='';
?>
	<li class="ver-space sep-bot no-mar clearfix">
			<?php if(!empty($job['Attachment']['0'])){?>
				<?php echo $this->Html->link($this->Html->showImage('Job', $job['Attachment']['0'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)),'class'=>'img-rounded', 'title' => $this->Html->cText($job['Job']['title'].' for '. $this->Html->siteCurrencyFormat($job['Job']['amount']), false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('class' => 'show pull-left left-space user-thumb','escape' => false));?>
		<?php }else{ ?>
				<?php echo $this->Html->link($this->Html->showImage('Job', $attachment, array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)),'class'=>'img-rounded', 'title' => $this->Html->cText($job['Job']['title'].' for '.$this->Html->siteCurrencyFormat($job['Job']['amount']), false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('class' => 'show pull-left left-space user-thumb', 'escape' => false));?>
		<?php } ?>
            <div class="pull-left left-space clearfix">    
			<div class="clearfix">
                 <div class="text-18 no-mar clearfix pull-left hor-smspace"><span class="pull-left" title="<?php echo $job['JobType']['name'];?>"><i class="icon-desktop top-space <?php echo ($job['JobType']['name'] == 'Online')?'greenc':'grayc'; ?>"></i></span>
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
					<?php 
					} else {  if (isPluginEnabled('JobFavorites')) { ?>
					<?php
					if($this->Auth->sessionValid()):
						if(!empty($job['JobFavorite'])):
							foreach($job['JobFavorite'] as $favorite):
								if($job['Job']['id'] == $favorite['job_id'] && $favorite['user_id'] == $this->Auth->user('id')):
									 echo $this->Html->link('<i class="icon-heart redc no-pad"></i>', array('controller' => 'job_favorites', 'action'=>'delete', $job['Job']['slug']), array('class' => 'like text-13 no-under pull-left js-like', 'title' => __l('Unlike'), 'escape' => false));
								endif;
							endforeach;
						else:
							echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'like text-13 no-under pull-left js-like'));
						endif;
					else:
						echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'like text-13 no-under pull-left'));
					endif;
					?>
				    <?php } } ?>
					</div>
					 <h3 class="text-18 no-mar clearfix pull-left">
				 <?php echo $this->Html->link($this->Html->cText($job['Job']['title'], false), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']), array('title' => $this->Html->cText($job['Job']['title'],false),'escape' => false, 'class' => 'span13 span13-sm no-mar htruncate graydarkerc'));?></h3>
				</div>
                 <p>
                   <span class="grayc left-space"><?php echo __l('by');?> 
						<?php echo $this->Html->link($job['User']['username'], array('controller'=>'users','action'=>'view',$job['User']['username']), array('class' => 'graydarkerc no-under bot-space hor-smspace', 'title' => $this->Html->cText($job['User']['username'],false)));?>
				   </span>
				   <span class="grayc left-mspace"><?php echo __l('Category:');?> 
				<?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'related')){ ?>
            			<?php echo $this->Html->link(__l($job['JobCategory']['name']), array('controller'=>'jobs','action'=>'index','category' => $job['JobCategory']['slug']), array('class' => 'graydarkerc no-under bot-space left-smspace', 'title' => __l($this->Html->cText($job['JobCategory']['name'],false))));?>
               <?php }else{ ?>         
						<?php echo $this->Html->link(__l($this->Html->truncate($job['JobCategory']['name'],60)), array('controller'=>'jobs','action'=>'index','category' => $job['JobCategory']['slug']), array('class' => 'graydarkerc no-under bot-space left-smspace', 'title' => __l($this->Html->cText($job['JobCategory']['name'],false))));?>
               <?php } ?> 
			   </span>
                 </p>
            </div>            
			<div class="span7 tab-clr clearfix pull-right">
                <?php if(isset($request_choosen) && !empty($request_choosen[$job['Job']['id']])){ ?>
                    <div class="span1" title="<?php echo __l('Bought this'); ?>"><i class="icon-shopping-cart text-32 textb grayc"></i></div>
                <?php } ?>
                <div class="pull-right mob-inline">
                    <p class="pull-left right-space"><?php echo $this->Html->siteCurrencyFormat($job['Job']['amount']);?></p>
				<?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
				<div class="bl-buy-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Buy Now'), array('controller' => 'users', 'action' => 'login'), array('class'=>'btn btn-small btn-success show pull-left textb top-mspace','title' => __l('Buy Now')));?>
				</div>
				<div class="al-buy-instr-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'job_orders','action'=>'add','job' => $job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'btn btn-small btn-success show pull-left textb top-mspace','escape' => false));?>
				</div>
				<div class="al-buy-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order',$job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'btn btn-small btn-success show pull-left textb top-mspace'));?>
				</div>
				<div class="al-edit-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Edit'), array('controller'=>'jobs','action'=>'edit',$job['Job']['id']), array('title' => __l('Edit'), 'class' => 'btn btn-small btn-success show pull-left textb top-mspace'));?>
				</div>


			<?php } else { ?>
			<?php if($this->Auth->sessionValid()){ ?>
				<?php  if($this->Auth->user('id') != $job['Job']['user_id']) { ?>
					<?php if($job['Job']['job_service_location_id'] == ConstServiceLocation::SellerToBuyer || !empty($job['Job']['is_instruction_requires_attachment']) || !empty($job['Job']['is_instruction_requires_input'])):?>
						<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'job_orders','action'=>'add','job' => $job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'btn btn-small btn-success show pull-left textb top-mspace','escape' => false));?>
					<?php else:?>
						<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order',$job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'btn btn-small btn-success show pull-left textb top-mspace'));?>
					<?php endif;?>
				<?php } 
				} else{?>
						<?php echo $this->Html->link(__l('Buy Now'), array('controller' => 'users', 'action' => 'login'), array('class'=>'btn btn-small btn-success show pull-left textb top-mspace','title' => __l('Buy Now')));?>
				<?php } 
			}?>
                </div>            
            </div>
    
	</li>
<?php
    endforeach;
else:
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
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('available for the price').' "'.$this->Html->siteCurrencyFormat($this->request->params['named']['amount']).'"';?></p></div>
	</li>
	<?php endif; 
	if($multiFilter) : ?>

		<ol class="dc">
		<li class="dc">
			<p class="grayc notice text-16 dc"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l('available');?></p>

		</li>
	</ol>
	<?php
	endif;
endif;
?>
</ol>
<div class="<?php if(isset($isajax) && $isajax==1) { ?> js-pagination <?php } ?> pull-right mspace">
<?php
if (!empty($jobs)) {
	echo $this->element('paging_links');
}
?>
</div>
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
