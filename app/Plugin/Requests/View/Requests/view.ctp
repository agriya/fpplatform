<?php 
if (!empty($request)) {
	Configure::write('highperformance.rid', $request['Request']['id']);
	$rid = Configure::read('highperformance.rid');
}?>
<div class="bot-space pr clearfix js-request-view" data-request-id="<?php echo $request['Request']['id']; ?>">
<?php /* SVN: $Id: $ */ ?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
      <section class="row request-view-banner-block no-mar pr">
        <div data-spy="affix" data-offset-top="100" class="row-fluid trans-bg mob-ps user-affix affix-top hidden-sm ">
          <div class="container clearfix" itemscope itemtype="http://schema.org/WPHeader">
          
            <div class="span15">
			<?php if($this->Auth->sessionValid() && $this->Auth->user('id') != $request['Request']['user_id']) { ?>
                <span class="label hor-smspace">
                    <?php if(isPluginEnabled('SocialMarketing') && isset($share_url)){ 	
                        echo $this->Html->link('<i class="icon-share text-12 no-mar whitec left-space"></i>', $share_url, array('title'=>__l('Share'), 'escape' => false, 'class' => 'js-bootstrap-tooltip', 'target' => '_blank')); 
					}
                    ?>
                    <?php
				if(isPluginEnabled('RequestFlags')) {
					echo $this->Html->link('<i class="icon-flag text-12 no-mar whitec hor-space"></i>', array('controller' => 'request_flags', 'action' => 'add', $request['Request']['id']), array('title' => __l('Report').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps),'escape' => false,'data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class' =>'js-bootstrap-tooltip no-under report-jobs js-no-pjax'));
				}
			} ?>
                </span>                 
				<h2 title="<?php echo $this->Html->cText($request['Request']['name'],false);?>" class="textb tshad no-mar text-32 whitec" itemprop="headline">
				 <?php 
				   if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
						<div class="al-requnfav-<?php echo $request['Request']['id'];?> hide  pull-left">
							<?php  echo $this->Html->link($this->Html->image('big-heart.gif', array('alt' => Configure::read('site.name'))), array('controller' => 'request_favorites', 'action'=>'delete', $request['Request']['slug']), array('class' => 'pull-left text-24 no-under delete js-like-view un-like-view top-space', 'title' => __l('Unlike'), 'escape' => false));?>
						</div>
						<div class="al-reqfav-<?php echo $request['Request']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'pull-left text-24 no-under js-like-view like-view top-space'));?>
						</div>
						<div class="bl-reqfav-<?php echo $request['Request']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'pull-left text-24 no-under like-view top-space top-smspace ver-smspace'));?>
						</div>
					<?php 
					} else { 
                    if (isPluginEnabled('RequestFavorites')) { ?>
					<?php
					if($this->Auth->sessionValid()):
						if(!empty($request['RequestFavorite'])):
							foreach($request['RequestFavorite'] as $favorite):
								if($request['Request']['id'] == $favorite['request_id']):
									 echo $this->Html->link($this->Html->image('big-heart.gif', array('alt' => Configure::read('site.name'))), array('controller' => 'request_favorites', 'action'=>'delete', $request['Request']['slug']), array('class' => 'pull-left text-24 no-under delete js-like-view un-like-view top-space', 'title' => __l('Unlike'), 'escape' => false));
								endif;
							endforeach;
						else:
							echo $this->Html->link($this->Html->image('big-heart.gif', array('alt' => Configure::read('site.name'))), array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'pull-left text-24 no-under js-like-view like-view top-space'));
						endif;
					else:
						echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'pull-left text-24 no-under like-view top-space top-smspace ver-smspace'));
					endif;
					?>
                    <?php } } ?>
                <span class="span20 htruncate pull-left"><?php echo $this->Html->cText($request['Request']['name']);?></span>
                </h2>
			</div>
			<div class="span9 pull-right tab-clr"> 
			<?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  {
				$class = "al-apply-post-" . $request['Request']['id'];
				echo $this->Html->link('Apply/Post a'.' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' ('. $this->Html->siteCurrencyFormat($request['Request']['amount'], 'span', 'no-style') .')', array('controller' => 'jobs', 'action' => 'add', 'request_id' => $request['Request']['id']), array('escape'=>false, 'class'=>'btn btn-large btn-primary textb text-20 ver-smspace pull-right mob-clr hide '."al-apply-post-" . $request['Request']['id'], 'title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)));
				echo $this->Html->link(__l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps) , 'class' => 'btn btn-large btn-primary textb text-20 ver-smspace pull-right mob-clr hide '."bl-apply-post-" . $request['Request']['id'],'escape' => false));
				echo $this->Html->link(__l('Edit'),	array('controller' => 'requests', 'action' => 'edit',$request['Request']['id']), array('escape'=>false, 'class'=>'btn btn-large btn-primary textb text-20 ver-smspace pull-right mob-clr hide '."al-edit-request-" . $request['Request']['id'], 'title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)));
			} else {
				if($this->Auth->sessionValid() && ($this->Auth->user('id') != $request['Request']['user_id'])){ ?>
					<?php echo $this->Html->link('Apply/Post a'.
					' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' ('. $this->Html->siteCurrencyFormat($request['Request']['amount'], 'span', 'no-style') .')',
					array('controller' => 'jobs', 'action' => 'add', 'request_id' => $request['Request']['id']), array('escape'=>false, 'class'=>'btn btn-large btn-primary textb text-20 ver-smspace show pull-right mob-clr', 'title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps))); 
				} else if($this->Auth->sessionValid() && ($this->Auth->user('id') == $request['Request']['user_id'])){
					echo $this->Html->link(__l('Edit'),
					array('controller' => 'requests', 'action' => 'edit',$request['Request']['id']), array('escape'=>false, 'class'=>'btn btn-large btn-primary textb text-20 ver-smspace show pull-right mob-clr', 'title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)));
				} else if(!$this->Auth->sessionValid()) {
					echo $this->Html->link(__l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps) , 'class'=>'btn btn-large btn-primary textb text-20 ver-smspace show pull-right mob-clr','escape' => false));
				}
			}?>
          </div>
		  </div>
        </div>
		</section>
      <section class="row ver-mspace ver-space">
        <div class="container request-user-block clearfix pr">
          <div class="span5 no-mar holder-img pa mob-ps"> 
          <?php  echo $this->Html->getUserAvatarLink($request['User'], 'large_thumb', true);?> 		  
		  </div>
		  	 
	   
	</div>
      </section>
      <section class="row hero-unit no-round" itemscope itemtype="http://schema.org/WebPage">
        <div class="container clearfix">
		  <div class="span14 no-mar" itemprop="description">
		    <?php echo $this->Html->cText($request['Request']['name']); ?>
		  </div>
          <div class="span8 differ-block pull-right" itemprop="review" itemscope itemtype="http://schema.org/Review">
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('User'); ?> </dt>
              <dd class="grayc"><?php echo $this->Html->link(__l($request['User']['username']), array('controller' => 'users', 'action' => 'view',  $request['User']['username'], 'admin' => false), array('class'=> 'ver-space no-under bluec', 'title' => __l($request['User']['username']), 'escape' => false));?></dd>
            </dl>
             <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' Category'); ?> </dt>
              <dd class="grayc"><?php echo $this->Html->link(__l($request['JobCategory']['name']), array('controller'=>'requests','action'=>'index','category' => $request['JobCategory']['slug']), array('class'=> 'ver-space no-under bluec', 'title' => __l($request['JobCategory']['name']), 'escape' => false));?></dd>
            </dl>
            <?php if(Configure::read('job.rating_type') == 'percentage'):?>
            <dl class="dl-horizontal no-mar ver-space sep-bot" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
              <dt class="dl left-space textn"><?php echo __l('Positive Rating'); ?></dt>
              <dd class="grayc" itemprop="bestRating"><?php echo $this->Html->displayPercentageRating($request['User']['job_feedback_count'], $request['User']['positive_feedback_count']); ?></dd>
            </dl>
            
			<?php else:?>
			<dl class="dl-horizontal no-mar ver-space sep-bot" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
              <dt class="dl left-space textn"><?php echo __l('Positive Rating'); ?></dt>
              <dd class="grayc" itemprop="bestRating"><?php echo $this->Html->cInt($request['User']['positive_feedback_count']); ?></dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
              <dt class="dl left-space textn"><?php echo __l('Negative Rating'); ?></dt>
              <dd class="grayc" itemprop="worstRating" ><?php  echo $this->Html->cInt($request['User']['job_feedback_count'] - $request['User']['positive_feedback_count']); ?></dd>
            </dl>
			<?php endif; ?>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Online/Offline'); ?></dt>
              <dd class="grayc"><?php echo $request['JobType']['name']; ?></dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Posted on'); ?></dt>
              <dd class="grayc"><meta itemprop="datePublished" content="2011-03-25"><?php echo $this->Time->timeAgoInWords($request['Request']['created']); ?></dd>
            </dl>
          </div>
        </div>
      </section>
	  <section class="row ver-space ver-mspace">
        <div class="container bot-space user-block clearfix" itemscope itemtype="http://schema.org/interactionCount">
          <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space" itemprop="attendees">
            <dt class="pr hor-mspace"><?php echo jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps);?> </dt>
			<?php $job_count = !empty($request['Request']['job_count']) ? $request['Request']['job_count'] : '0';?>
            <dd class="text-32 pr hor-mspace" title="<?php echo $job_count;?>">
			<?php echo $job_count;?></dd>
          </dl>
          <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space" itemprop="attendees">
            <dt class="pr hor-mspace"><?php echo __l('Views');?></dt>
			<?php $view_count = !empty($request['Request']['request_view_count']) ? $request['Request']['request_view_count'] : '0';?>
            <dd class="text-32 pr hor-mspace" title="<?php echo $view_count;?>"><?php echo $view_count;?></dd>
          </dl>
        </div>
      </section>
	  <section class="row no-mar">
        <div class="secondary-bg no-round top-space">
          <div class="container clearfix" id="ajax-tab-container-request-view">
            <ul id="Tab" class="nav nav-tabs no-bor top-mspace">
              <li class="text-16 span5 no-bor no-mar dc active first-child">
			   <?php echo $this->Html->link('<span class="show ver-space">'.sprintf(__l('Posted / Applied %s'), jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)).'</span>', array('controller' => 'jobs', 'action' => 'index','filter'=>'request-jobs', 'view_type' => 'expanded', 'source' => 'view', 'request_id' => $request['Request']['id'], 'limit' => 5, 'admin' => false), array('escape' => false, 'title'=> sprintf(__l('Posted / Applied %s'), jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)), 'data-toggle' => 'tab', 'data-target' => '#appliedjobs', 'class' => 'js-no-pjax')); ?>
			  </li>
              <li class="text-16 span5 no-bor dc  "> 
			  <?php echo $this->Html->link('<span class="show ver-space">'. sprintf(__l('Related %s'), jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)).'</span>', array('controller' => 'jobs', 'action' => 'index','filter'=>'request-related-jobs', 'request_id' => $request['Request']['id'], 'limit' => 5, 'admin' => false), array('escape' => false, 'title'=> sprintf(__l('Related %s'), jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)), 'data-toggle' => 'tab', 'data-target' => '#relatedjobs', 'class' => 'js-no-pjax')); ?>
			  </li>
              <li class="text-16 span5 no-bor dc  ">
			   <?php echo $this->Html->link('<span class="show ver-space">'. sprintf(__l('Other %s'), requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps)).'</span>', array('action' => 'index', 'view_type'=>'simple_index', 'user_id' => $request['User']['id'], 'limit' => 5, 'view_request_id' => $request['Request']['id'], 'admin' => false), array('escape' => false, 'title'=> sprintf(__l('Other %s'), requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps)), 'data-toggle' => 'tab', 'data-target' => '#otherRequests', 'class' => 'js-no-pjax')); ?>
			  
			  </li>
			  <?php if(!empty($request['Request']['address'])): ?>
			  <li class="text-16 span5 no-bor dc">
			  <?php echo $this->Html->link('<span class="show ver-space">'.__l('Location').'</span>', array('controller' => 'requests', 'action' => 'request_location',  'request_id' => $request['Request']['id'], 'admin' => false), array('escape' => false, 'title'=>__l('Location'), 'data-toggle' => 'tab', 'data-target' => '#Location', 'class' => 'btn btn-large btn-success js-no-pjax')); ?>
			    <?php endif; ?>
            </ul>
          
        <div class="container tab-content top-space top-mspace" id="TabContent">
			<div class="tab-pane active" id="appliedjobs">
				<div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
          </div>
		  <div class="tab-pane bot-space" id="relatedjobs">
		  <div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
          </div>
          <div class="tab-pane " id="otherRequests">
				<div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
          </div>
         <?php if(!empty($request['Request']['address'])): ?>
		 <div class="tab-pane" id="Location">
            <div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
          </div>
		  <?php endif; ?>
        </div>
		</div>
        </div>
      </section>
      </div>
<div class="dc hero-unit no-round no-mar">
<?php echo $this->Html->link(__l('Get Started'), array('controller' => 'requests', 'action' => 'add', 'admin' => false), array('escape' => false, 'title'=>__l('Get Started'), 'class' => 'btn btn-large btn-success textb text-20 text-up')); ?>
</div>
<?php if (Configure::read('widget.request_script')) { ?>
	<div class="dc clearfix ver-space">
		<?php echo Configure::read('widget.request_script'); ?>
	</div>
<?php } ?>
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

