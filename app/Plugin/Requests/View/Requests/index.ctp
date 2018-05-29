<?php 
$rids = '';
if (!empty($requests)) {
	foreach ($requests as $request){
		Configure::write('highperformance.rids', Set::merge(Configure::read('highperformance.rids') , $request['Request']['id']));
	}
	$rids = implode(',', Configure::read('highperformance.rids'));
}
if(empty($this->request->params['requested'])):
?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<?php endif;?>
<div class="jobs index js-response js-responses js-jobs-scroll-here js-lazyload  clearfix">

	<section class="sep-bot ">
	<div class="container ">
		<?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'favorite')) : ?>
		<div class="label label-info show text-18 clearfix no-round ver-mspace">
			<div class="span smspace"><?php echo __l('Seller Control Panel');?></div>
			<?php echo $this->element('selling-cp-settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
		<?php endif;?>
		<h2 class="textb text-32 bot-space mob-dc">
		<?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'favorite')):?>
		<?php echo  __l('Favorite').' '.requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps).' '.'('.$this->Html->cInt($request_user['User']['request_favorite_count']).')';?>
		<?php elseif(empty($this->request->params['named']['type'])): ?>
		<?php echo requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps);?>
		<?php endif; ?>
		</h2>
	
	</div>
	</section>    
  <section class="row bot-mspace bot-space ">
<div class="container">

<?php if(empty($this->request->params['named']['q'])) { ?>
	  <div class="label-default"><div class="space text-24 textb pull-left"><?php echo sprintf(__l('Your %s Here'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps));?></div>
	  <div class="dr"><?php echo $this->Html->link(sprintf(__l('Post a %s'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)), array('controller' => 'requests', 'action' => 'add', 'admin' => false), array('escape' => false, 'title'=>sprintf(__l('Post a %s'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)), 'class' => 'btn btn-small  btn-primary text-16 textb mspace ')); ?></div></div>
	  <?php } ?>

<div class="js-request-responses request-list-block">
<?php
if (!empty($this->request->params['named']['type']) && (!$this->request->params['named']['type'] == 'favorite')):
	echo $this->element('paging_counter');
endif;
?>
<?php  if (!empty($this->request->params['named']['type']) && !$this->request->params['named']['type'] == 'favorite'): ?> 
<div class="clearfix">
<div class="select-block my-jobs-right-block">
    <div class="inbox-option js-pagination clearfix">
		<span class="select"><?php echo __l('Filter').':'; ?></span>
		<ul class="filter-list">
    		<?php
                $amount_filter = isset($this->request->params['named']['amount']) ? $this->request->params['named']['amount'] : 0;
                unset($this->request->params['named']['amount']);
                $jobtype_filter = isset($this->request->params['named']['job_type_id']) ? $this->request->params['named']['job_type_id'] : 0;
                unset($this->request->params['named']['job_type_id']);
            ?>
    		<?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'recent') ? ' status_selected' : null; ?>
    		<li class="<?php echo $class ?>"><?php echo $this->Html->link(__l('Recent'), array_merge($this->request->params['named'], array('controller'=>'requests','action'=>'index','filter' => 'recent')), array('class' => $class,'title' => __l('Recent')));?></li>
    		<?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'popular') ? ' status_selected' : null; ?>
            <li class="<?php echo $class ?>"><?php echo $this->Html->link(__l('Popular'), array_merge($this->request->params['named'], array('controller'=>'requests','action'=>'index','filter' => 'popular')) , array('class' => $class,'title' => __l('Popular')));?></li>
            <?php $class = (!empty($amount_filter)) ? ' status_selected' : null;
			$total_amount_filter = count($amounts) ;?>
            <li class="<?php echo $class ?> <?php echo ($total_amount_filter > 1)? 'filter-amount' :'' ?>"><span>
					<?php if($total_amount_filter > 1){
							echo __l('Amount');
						  } else{
								foreach($amounts as $amount){
								echo $this->Html->link(__l('Filter by').' '.$this->Html->cText($this->Html->siteCurrencyFormat($amount), false), array_merge($this->request->params['named'], array('controller'=>'requests', 'action'=>'index', 'amount' => $amount)), array('class' => $class ,'title' => __l('Filter by').' '.$this->Html->cText($this->Html->siteCurrencyFormat($amount), false)));
								}
						  }?>
					</span>
                <ul>
        		<?php
                    unset($this->request->params['named']['filter']);
        			if($total_amount_filter > 1):
        				foreach($amounts as $amount){
                            ?>
                            <li>
                                <?php
            					if(!empty($amount)):
            						$class = (!empty($amount_filter) && $amount_filter == $amount) ? ' status_selected' : null;
            						echo $this->Html->link(__l('Filter by').' '.$this->Html->cText($this->Html->siteCurrencyFormat($amount), false), array_merge($this->request->params['named'], array('controller'=>'requests', 'action'=>'index', 'amount' => $amount)), array('class' => $class ,'title' => __l('Filter by').' '.$this->Html->cText($this->Html->siteCurrencyFormat($amount), false)));
            					endif;
            					?>
        					</li>
        					<?php
        				}
        			endif;
        		?>
        		</ul>
    		</li>
    		<?php $class = (!empty($jobtype_filter)) ? ' status_selected' : null;
			$total_jobtype_filter = count($jobTypes) ;?>
            <li class="<?php echo $class ?> <?php echo ($total_jobtype_filter > 1)? 'filter-amount' :'' ?>"><span>
					<?php if($total_jobtype_filter > 1){
							echo __l('JobType');
						  } else{
								foreach($jobTypes as $jobType){
								echo $this->Html->link($this->Html->cText($jobtype_filter, false), array_merge($this->request->params['named'], array('controller'=>'requests', 'action'=>'index', 'job_type_id' => $jobtype_filter)), array('class' => $class ,'title' => __l('Filter by')));
								}
						  }?>
					</span>
                <ul>
        		<?php
                    unset($this->request->params['named']['filter']);
        			if($total_jobtype_filter > 1):
        				foreach($jobTypes as $key => $value){
                            ?>
                            <li>
                                <?php
            					if(!empty($key)):
            						$class = (!empty($jobtype_filter) && $jobtype_filter == $key) ? ' status_selected' : null;
            						echo $this->Html->link($this->Html->cText($value, false), array_merge($this->request->params['named'], array('controller'=>'requests', 'action'=>'index', 'job_type_id' => $key)), array('class' => $class ,'title' => $value));
            					endif;
            					?>
        					</li>
        					<?php
        				}
        			endif;
        		?>
        		</ul>
    		</li>
           </ul>
	</div>
	<div class="add-block clearfix">
		<span><?php echo $this->Html->link(__l('Post a').' '.requestAlternateName('',ConstJobAlternateName::FirstLeterCaps), array('controller' => 'requests', 'action' => 'add'), array('title' => __l('Post a').' '.requestAlternateName('',ConstJobAlternateName::FirstLeterCaps), 'class' => 'add')); ?></span>
	</div>
</div>
</div>
<?PHP endif; ?> 
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
		<li class="ver-space sep-bot clearfix">        		
		    <?php echo $this->Html->getUserAvatarLink($request['User'], 'small_thumb', true, 'show pull-left left-space user-thumb','img-rounded');?>
			<div class="pull-left left-space clearfix">
			<div class="clearfix">
			<div class="text-18 no-mar clearfix pull-left hor-smspace">
				<span class="pull-left " title="<?php echo $request['JobType']['name'];?>"><i class="icon-desktop top-space <?php echo ($request['JobType']['name'] == 'Online')?'greenc':'grayc'; ?>"></i></span>
				   <?php 
				   if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
						<div class="al-requnfav-<?php echo $request['Request']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart redc no-pad"></i>', array('controller' => 'request_favorites', 'action'=>'delete', $request['Request']['slug']), array('class' => 'like text-13 no-under pull-left js-like', 'title' => __l('Unlike'), 'escape' => false));?>
						</div>
						<div class="al-reqfav-<?php echo $request['Request']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'like text-13 no-under pull-left js-like'));?>
						</div>
						<div class="bl-reqfav-<?php echo $request['Request']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false , 'class' => 'like text-13 no-under pull-left'));?>
						</div>
					<?php 
					} else { 
								if (isPluginEnabled('RequestFavorites')) { ?>
					<?php
					if($this->Auth->sessionValid()):
						if(!empty($request['RequestFavorite'])):
							foreach($request['RequestFavorite'] as $favorite):
								if($request['Request']['id'] == $favorite['request_id']):
									 echo $this->Html->link('<i class="icon-heart redc no-pad"></i>', array('controller' => 'request_favorites', 'action'=>'delete', $request['Request']['slug']), array('class' => 'like text-13 no-under pull-left js-like', 'title' => __l('Unlike'), 'escape' => false));
								endif;
							endforeach;
						else:
							echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'like text-13 no-under pull-left js-like'));
						endif;
					else:
						echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false , 'class' => 'like text-13 no-under pull-left'));

					endif;
					?>
				    <?php } } ?>
				</div><h3 class="text-18  span13 htruncate no-mar clearfix pull-left">
				<?php echo $this->Html->link($this->Html->cText($request['Request']['name'], false), array('controller' => 'requests', 'action' => 'view', $request['Request']['slug']), array('title' => $this->Html->cText($request['Request']['name'], false),'class' => ' no-mar  graydarkerc', 'escape' => false));?>
			</h3>
			</div>
            <p>
	            <span class="grayc left-space"><?php echo __l('by');?> 
						<?php echo $this->Html->link($request['User']['username'], array('controller'=>'users','action'=>'view',$request['User']['username']), array('class' => 'graydarkerc no-under bot-space hor-smspace', 'title' => $this->Html->cText($request['User']['username'],false)));?>
				   </span>
				   <span class="grayc left-mspace"><?php echo __l('Category:');?> 
				<?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'related')){ ?>
            			<?php echo $this->Html->link(__l($request['JobCategory']['name']), array('controller' => 'requests', 'action' => 'index', 'category' => $request['JobCategory']['slug']), array('class' => 'graydarkerc no-under bot-space left-smspace', 'title' => __l($this->Html->cText($request['JobCategory']['name'],false))));?>
               <?php }else{ ?>         
						<?php echo $this->Html->link(__l($this->Html->truncate($request['JobCategory']['name'],60)), array('controller' => 'requests', 'action' => 'index','category' => $request['JobCategory']['slug']), array('class' => 'graydarkerc no-under bot-space left-smspace', 'title' => __l($this->Html->cText($request['JobCategory']['name'],false))));?>
               <?php } ?> 
			   </span>
             </p>
             </div>
		
               <div class="span7 tab-clr clearfix pull-right">
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
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16">
			<?php 
				if(!empty($this->request->params['named']['q'])) { 
					echo __l('No').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.__l('available for the keyword').' "'.$this->Html->cText($this->request->params['named']['q']).'"';
					} else {
						echo __l('No').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.__l(' available');
					} ?>
			</p>
		  </div>
		</li>
	<?php
endif;
?>
</ol>
<div class="clearfix pull-right mob-clr ver-space mob-dc">
<?php
if (!empty($requests)) {
	echo $this->element('paging_links');
}
?>
</div>

<?php if(empty($this->request->params['requested'])):?>
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
</section>
</div>
