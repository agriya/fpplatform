<?php 
Configure::write('highperformance.jid', $job['Job']['id']);
$jid = Configure::read('highperformance.jid');
$class = "job-affix-nonregister";
		if ($this->Auth->sessionValid()) {
			if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
				$class = "job-affix-user";
			} else {
				$class = "job-affix-admin";
			}
		}
?>
<div class="pr clearfix js-job-view" data-job-id="<?php echo $job['Job']['id']; ?>">
<?php /* SVN: $Id: $ */ ?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
      <section class="row view-banner-block no-mar">

        <div data-spy="affix" data-offset-top="100" class="row-fluid trans-bg pa mob-ps user-affix hidden-sm affix-top js-affix-header <?php echo $class;?> ">
		<div class="container clearfix pr" itemscope itemtype="http://schema.org/WPHeader">
		    <div class="pa label-featured">
				<?php if($this->Auth->sessionValid() && $this->Auth->user('id') != $job['Job']['user_id']){ ?>	
                <span class="label hor-smspace">
                    <?php 
				  if(isset($share_url) && isPluginEnabled('SocialMarketing')){
					echo $this->Html->link('<i class="icon-share text-12 no-mar whitec pull-left"></i>', $share_url, array('title'=>__l('Share'), 'escape' => false, 'class' => 'js-bootstrap-tooltip', 'target' => '_blank')); 
				  }
				if(isPluginEnabled('JobFlags')):
					echo $this->Html->link('<i class="icon-flag text-12 whitec no-mar pull-right"></i>', array('controller' => 'job_flags', 'action' => 'add', $job['Job']['id']), array('title' => __l('Report').' '.jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps),'escape' => false,'data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class' =>'js-bootstrap-tooltip js-no-pjax','data-placement'=>'left'));
				endif;
				}?>
                </span> 
                <?php if(isset($job['Job']['is_featured']) && $job['Job']['is_featured'] == 1) { ?>
				<span class="label label-info"><?php echo __l('Featured'); ?></span>
		        <?php } ?>
                </div>
				<h2 title="<?php echo $this->HTML->cText($job['Job']['title'],false);?>" class="textb span12 no-mar top-space top-mspace text-32 whitec" itemprop="headline">
                    <?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
						<div class="al-jobunfav-<?php echo $job['Job']['id'];?> hide  pull-left">
							<?php  echo $this->Html->link($this->Html->image('big-heart.gif', array('alt' => Configure::read('site.name'))), array('controller' => 'job_favorites', 'action'=>'delete', $job['Job']['slug']), array('class' => 'text-24 un-like-view no-under pull-left js-like-view top-space', 'title' => __l('Unlike'), 'escape' => false));?>
						</div>
						<div class="al-jobfav-<?php echo $job['Job']['id'];?> hide  pull-left">
							<?php echo $this->Html->link($this->Html->image('big-heart2.gif', array('alt' => Configure::read('site.name'))), array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'text-24 like-view top-space no-under pull-left js-like-view'));?>
						</div>
						<div class="bl-jobfav-<?php echo $job['Job']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'text-24 like no-under pull-left'));?>
						</div>
					<?php 
					} else {
								if (isPluginEnabled('JobFavorites')) { ?>
					<?php
					if($this->Auth->sessionValid()):
						if(!empty($job['JobFavorite'])):
							foreach($job['JobFavorite'] as $favorite):
								if($job['Job']['id'] == $favorite['job_id'] && $favorite['user_id'] == $this->Auth->user('id')):
									 echo $this->Html->link($this->Html->image('big-heart.gif', array('alt' => Configure::read('site.name'))), array('controller' => 'job_favorites', 'action'=>'delete', $job['Job']['slug']), array('class' => 'text-24 like no-under pull-left js-like-view top-space', 'title' => __l('Unlike'), 'escape' => false));
								endif;
							endforeach;
						else:
							echo $this->Html->link($this->Html->image('big-heart2.gif', array('alt' => Configure::read('site.name'))), array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'text-24 like-view top-space no-under pull-left js-like-view'));
						endif;
					else:
						echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'text-24 like no-under pull-left'));
					endif;
					?>
                    <?php } } ?>

                <span class="tshad span22 htruncate"><?php echo $this->HTML->cText($job['Job']['title'],false);?></span>
                </h2>
            <div class="span12 pull-right tab-clr">
<?php if(empty($job['Job']['admin_suspend']) && !empty($job['Job']['is_active'])){?>
<?php if(isPluginEnabled('HighPerformance')&& Configure::read('HtmlCache.is_htmlcache_enabled')) { ?>
	<div class="al-buy-<?php echo $job['Job']['id'];?> hide">
		<?php echo $this->Html->link(__l('Buy').' ('.$this->Html->siteCurrencyFormat($job['Job']['amount'], 'span', 'no-style').')', array('controller'=>'payments','action'=>'order',$job['Job']['id']), array('title' => __l('Buy'), 'class' => 'js-bootstrap-tooltip btn btn-large btn-primary textb text-20 ver-smspace show pull-right mob-clr'));?>
	</div>
	<div class="bl-buy-<?php echo $job['Job']['id'];?> hide">
		<?php echo $this->Html->link(__l('Buy').' ('.Configure::read('site.currency'). $this->Html->cCurrency($job['Job']['amount'], false).')', array('controller' => 'users', 'action' => 'login'), array('class'=>'btn btn-large btn-primary textb text-20 ver-smspace show pull-right mob-clr js-bootstrap-tooltip cboxElement','title' => __l('Buy')));?>
	</div>
	<div class="al-edit-<?php echo $job['Job']['id'];?> hide">
		<?php echo $this->Html->link(__l('Edit'), array('controller' => 'jobs', 'action' => 'edit', $job['Job']['id']), array('class'=>'btn btn-large btn-primary textb text-20 ver-smspace show pull-right mob-clr js-bootstrap-tooltip','title' => __l('Edit')));?>
	</div>
	<div class="al-buy-moreinfo-<?php echo $job['Job']['id'];?> hide">
		<?php echo $this->Html->link(__l('Buy').' ('.Configure::read('site.currency'). $this->Html->cCurrency($job['Job']['amount'], false).')', array('controller'=>'job_orders','action'=>'add','job' => $job['Job']['id']), array('title' => __l('Buy'), 'class' => 'btn btn-large btn-primary textb text-20 ver-smspace show pull-right mob-clr js-bootstrap-tooltip','escape' => false));?>
	</div>
<?php } else { ?>
	<?php if($this->Auth->sessionValid() && ($this->Auth->user('id') != $job['Job']['user_id'])){ ?>
		<?php if($job['Job']['job_service_location_id'] == ConstServiceLocation::SellerToBuyer || !empty($job['Job']['is_instruction_requires_attachment']) || !empty($job['Job']['is_instruction_requires_input'])):?>
			<?php echo $this->Html->link(__l('Buy').' ('.Configure::read('site.currency'). $this->Html->cCurrency($job['Job']['amount'], false).')', array('controller'=>'job_orders','action'=>'add','job' => $job['Job']['id']), array('title' => __l('Buy'), 'class' => 'btn btn-large btn-primary textb text-20 ver-smspace show pull-right mob-clr ','escape' => false));?>
		<?php else:?>
			<?php echo $this->Html->link(__l('Buy').' ('.Configure::read('site.currency'). $this->Html->cCurrency($job['Job']['amount'], false).')', array('controller'=>'payments','action'=>'order',$job['Job']['id']), array('title' => __l('Buy'), 'class' => 'btn btn-large btn-primary textb text-20 ver-smspace show pull-right mob-clr js-bootstrap-tooltip'));?>
		<?php endif;?>
	<?php } else if(!$this->Auth->sessionValid()) {?>
		<?php echo $this->Html->link(__l('Buy').' ('.Configure::read('site.currency'). $this->Html->cCurrency($job['Job']['amount'], false).')', array('controller' => 'users', 'action' => 'login'), array('class'=>'btn btn-large btn-primary textb text-20 ver-smspace show pull-right mob-clr js-bootstrap-tooltip','title' => __l('Buy')));?>
	<?php } else if($this->Auth->user('id') == $job['Job']['user_id']) { 
		echo $this->Html->link(__l('Edit'), array('controller' => 'jobs', 'action' => 'edit', $job['Job']['id']), array('class'=>'btn btn-large btn-primary textb text-20 ver-smspace show pull-right mob-clr js-bootstrap-tooltip','title' => __l('Edit')));
	}?>
<?php }  } ?>
				<div class="js-response">
				  <?php
						echo $this->element('Jobs.job_feedbacks-index', array('view_style' => 'simple-view', 'job_id' => $job['Job']['id'], 'cache' => array('time' => Configure::read('site.site_element_cache_5_min'))));
					?>
				</div>
              </div>
		   </div>
        </div>
		<div class="carousel slide play-control pr no-mar" id="myCarousel">
			<?php if(!empty($job['Job']['youtube_url'])){?>
				<div class="play-btn">
				<?php echo $this->Html->link('', array( 'action' => 'youtube_url_print','job_id'=>$job['Job']['id']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class'=>'js-no-pjax'));?>
					
				</div>
			<?php } ?>
          <div class="carousel slide no-mar">
            <div class="carousel-inner course-block">
			<?php 
				if(!empty($job['Attachment'])) {	
					foreach($job['Attachment'] as $attachment): ?>
					<div class="item">
						<?php echo $this->Html->showImage('Job', $attachment, array('dimension' => 'very_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)), 'title' => $this->Html->cText($job['Job']['title'], false))); ?>
					</div>
				<?php endforeach; 
				} else {
					echo $this->Html->showImage('Job', array(), array('dimension' => 'very_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)), 'title' => $this->Html->cText($job['Job']['title'], false)));
				}
				?>
            </div>
            <a data-slide="prev" href="#myCarousel" class="left carousel-control">&#8249;</a>
			<a data-slide="next" href="#myCarousel" class="right carousel-control">&#8250;</a> </div>
		 </div>
		</section>
      <section class="row ver-mspace ver-space">
        <div class="container pr clearfix">
          <div class="span5 no-mar holder-img pa mob-ps z-top"> 
            <?php  echo $this->Html->getUserAvatarLink($job['User'], 'large_thumb', true, '', 'sep sep-big sep-black');?> 		  
		  </div>
		<?php if(empty($job['Job']['admin_suspend']) && !empty($job['Job']['is_active'])){?>
		<?php if(isPluginEnabled('HighPerformance')&& Configure::read('HtmlCache.is_htmlcache_enabled')) { ?>
			<div class="al-contact-seller-<?php echo $job['Job']['id'];?> hide">
				<?php echo $this->Html->link('<span class="offset5 mob-no-mar ver-space">'.__l('Contact Seller').'</span>', array('controller'=>'messages','action'=>'compose','type' => 'contact','slug' => $job['Job']['slug']), array('class' => 'no-under bluec ver-space span', 'title' => __l('Contact Seller'), 'escape' => false));?>
			</div>
			<div class="bl-contact-seller-<?php echo $job['Job']['id'];?> hide">
				<?php echo $this->Html->link('<span class="offset5 mob-no-mar ver-space">'.__l('Contact Seller').'</span>', array('controller'=>'messages','action'=>'compose','type' => 'contact','slug' => $job['Job']['slug']), array('class'=>"ver-space span no-under bluec js-dialog js-ajax-colorbox {source:'js-dialog-body-login'} cboxElement", 'title' => __l('Contact Seller'), 'escape' => false));?>
			</div>
		<?php } else { ?>
			<?php if($this->Auth->sessionValid() && ($this->Auth->user('id') != $job['Job']['user_id'])){ ?>
				<?php echo $this->Html->link('<span class="offset5 mob-no-mar ver-space">'.__l('Contact Seller').'</span>', array('controller'=>'messages','action'=>'compose','type' => 'contact','slug' => $job['Job']['slug']), array('class' => 'ver-space span no-under bluec js-no-pjax', 'title' => __l('Contact Seller'), 'escape' => false));?>
			<?php } else if(!$this->Auth->sessionValid()) {?>
				<?php echo $this->Html->link('<span class="offset5 mob-no-mar ver-space">'.__l('Contact Seller').'</span>', array('controller' => 'users', 'action' => 'login'), array('class'=>'ver-space span no-under bluec js-no-pjax js-dialog js-ajax-colorbox {source:"js-dialog-body-login"} ','title' => __l('Contact Seller'), 'escape' => false));?>
			<?php } ?>
		<?php } ?>
		<?php } ?>
		</div>
      </section>
      <section class="row hero-unit no-round" itemscope itemtype="http://schema.org/WebPage">
        <div class="container clearfix">
          <div class="span14 no-mar" itemprop="description">
			<p><?php
			if($this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin) && !empty($job['Job']['is_system_flagged'])):
				echo $this->Html->filterSuspiciousWords($job['Job']['description'], $job['Job']['detected_suspicious_words']);
			else:
				echo nl2br($this->Html->cText($job['Job']['description']));
			endif;
			?>  </p>
            <?php if(!empty($job['Job']['flickr_url'])) { ?>
                <a href ="<?php echo $this->Html->makeUrl($job['Job']['flickr_url']); ?>" title="<?php echo __l('Flickr');?>" target = "_blank"><?php echo __l('Flickr');?></a>
           <?php } ?>
          </div>
          <div class="span8 differ-block pull-right" itemprop="review" itemscope itemtype="http://schema.org/Review">
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('User'); ?> </dt>
              <dd class="grayc"><?php echo $this->Html->link(__l($job['User']['username']), array('controller' => 'users', 'action' => 'view',  $job['User']['username'], 'admin' => false), array('class'=> 'ver-space no-under bluec', 'title' => __l($job['User']['username']), 'escape' => false));?></dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Category'); ?> </dt>
              <dd class="grayc"><?php echo $this->Html->link(__l($job['JobCategory']['name']), array('controller'=>'jobs','action'=>'index','category' => $job['JobCategory']['slug']), array('class'=> 'ver-space no-under bluec', 'title' => __l($job['JobCategory']['name']), 'escape' => false));?></dd>
            </dl>
			<dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Tags'); ?> </dt>
              <dd class="grayc"><ul class="no-mar unstyled bluec">
                <?php
						foreach($job['JobTag'] as $tag):
							echo '<li>'. $this->Html->link(__l($tag['name']), array('controller'=>'jobs','action'=>'index','tag' => $tag['slug']), array('title' => __l($this->Html->cText($tag['name'],false)),'class'=> 'ver-space no-under bluec')).'</li>';
						endforeach;
					?>
              </ul></dd>
            </dl>
			<?php if(Configure::read('job.rating_type') == 'percentage'):?>
            <dl class="dl-horizontal no-mar ver-space sep-bot" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
              <dt class="dl left-space textn"><?php echo __l('Positive Rating'); ?></dt>
              <dd class="grayc" itemprop="bestRating"><?php echo $this->Html->displayPercentageRating($job['Job']['job_feedback_count'], $job['Job']['positive_feedback_count']); ?></dd>
            </dl>
            
			<?php else:?>
			<dl class="dl-horizontal no-mar ver-space sep-bot" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
              <dt class="dl left-space textn"><?php echo __l('Positive Rating'); ?></dt>
              <dd class="grayc" itemprop="bestRating"><?php echo $this->Html->cInt($job['Job']['positive_feedback_count']); ?></dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
              <dt class="dl left-space textn"><?php echo __l('Negative Rating'); ?></dt>
              <dd class="grayc" itemprop="worstRating" ><?php  echo $this->Html->cInt($job['Job']['job_feedback_count'] - $job['Job']['positive_feedback_count']); ?></dd>
            </dl>
			<?php endif; ?>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Work Duration'); ?></dt>
              <dd class="grayc"><?php echo $this->Html->cInt($job['Job']['no_of_days']).' ';?> <?php echo ($job['Job']['no_of_days'] == '1') ? __l('Day') : __l('Days');?></dd>
            </dl> 
			<?php if($job['JobType']['id'] == ConstJobType::Offline){?>
			<dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Who needs to travel ?'); ?></dt>
              <dd class="grayc"><?php echo $job['JobServiceLocation']['name']; ?>  </dd>
            </dl>
			<?php }?>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Online/Offline'); ?></dt>
              <dd class="grayc"><?php echo $job['JobType']['name']; ?></dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Posted on'); ?></dt>
              <dd class="grayc"><meta itemprop="datePublished" content="2011-03-25"><?php echo $this->Time->timeAgoInWords($job['Job']['created']); ?></dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot" itemprop="aggregaterating" itemscope itemtype="http://schema.org/AggregateRating">
              <dt class="dl left-space textn"><?php echo __l('Success Rate'); ?></dt>
				<?php
				$total_completed  = $job['Job']['order_success_without_overtime_count']+$job['Job']['order_success_with_overtime_count'];
				$success_rate = ($job['Job']['order_received_count'] > 0)?(($total_completed/$job['Job']['order_received_count'])*100):0 ;
				$on_time_rate = ($total_completed > 0)?(($job['Job']['order_success_without_overtime_count']/$total_completed)*100):0 ;
				$success_rate  = ($success_rate > 100)? 100 : $success_rate;
				$on_time_rate  = ($on_time_rate > 100)? 100 : $on_time_rate;
				?>
              <dd class="grayc" itemprop="ratingValue"> 
			  <?php if($job['Job']['order_received_count']){ ?>
			  <?php echo sprintf('%s/%s', $this->Html->cInt($total_completed),$this->Html->cInt($job['Job']['order_received_count'])); ?>
				  <?php echo $this->Html->image('http://chart.googleapis.com/chart?chf=bg,s,65432100&amp;cht=p&amp;chd=t:'.round($success_rate).','.(100 - round($success_rate)).'&amp;chs=45x45&amp;chco=00FF00|FF0000', array('title' => round($success_rate).'%')); ?> 
			  <?php } else { ?>
				  <?php echo __l('n/a'); ?>
			  <?php } ?>
			  </dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('On Time'); ?></dt>
              <dd class="grayc" >
			  <?php if($job['Job']['order_success_without_overtime_count']){ ?>
				<?php echo sprintf('%s/%s', $this->Html->cInt($job['Job']['order_success_without_overtime_count']),$this->Html->cInt($total_completed)); ?><?php echo $this->Html->image('http://chart.googleapis.com/chart?chf=bg,s,65432100&amp;cht=p&amp;chd=t:'.round($on_time_rate).','.(100 - round($on_time_rate)).'&amp;chs=45x45&amp;chco=00FF00|FF0000', array('title' => round($on_time_rate).'%')); ?>
			  <?php } else { ?>
				  <?php echo __l('n/a'); ?>
			  <?php } ?>
			  </dd>
            </dl>
          </div>
        </div>
      </section>
	  <section class="row ver-space ver-mspace">
        <div class="container bot-space user-block clearfix" itemscope itemtype="http://schema.org/interactionCount">
		<?php if(isPluginEnabled('JobFavorites')) { ?>
          <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space" itemprop="attendees">
            <dt class="pr hor-mspace"><?php echo __l('Favorited');?> </dt>
            <dd class="text-32 pr hor-mspace" title="231"><?php echo $this->Html->cInt($job['Job']['job_favorite_count']);?></dd>
          </dl>
		  <?php } ?>
          <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space" itemprop="attendees">
            <dt class="pr hor-mspace"><?php echo __l('Views');?></dt>
            <dd class="text-32 pr hor-mspace" title="231"><?php echo $this->Html->cInt($job['Job']['job_view_count']);?></dd>
          </dl>
          <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space" itemprop="attendees">
            <dt class="pr hor-mspace"><?php echo __l('Average delivery time');?></dt>
            <dd class="text-32 pr hor-mspace" title="231"><?php echo $this->Html->timeToDays($job['Job']['average_time_taken']); ?></dd>
          </dl>
          <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
            <dt class="pr hor-mspace"><?php echo __l('Works in progress');?></dt>
            <dd class="text-32 pr hor-mspace" title="231"><?php echo $this->Html->cInt($job['Job']['order_active_count']);?></dd>
          </dl>
          <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
            <dt class="pr hor-mspace"><?php echo __l('Latest order on');?></dt>
            <dd class="text-32 htruncate pr hor-mspace"><?php echo (!empty($job['Job']['order_last_accepted_date']) && $job['Job']['order_last_accepted_date'] != '0000-00-00 00:00:00')?$this->Html->cDateTimeHighlight($job['Job']['order_last_accepted_date']):'-';?></dd>
          </dl>
        </div>
      </section>
	  <section class="row no-mar">
        <div class="secondary-bg no-round top-space">
		  <div class="tabbable tab-container container clearfix"  id="ajax-tab-container-job-view">
            <ul id="Tab" class="nav nav-tabs no-bor top-mspace">
              <li class="text-16 span8 no-bor dc no-mar active first-child">
			  <?php echo $this->Html->link('<span class="show ver-space">'.__l('Feedback').'</span>', array('controller' => 'job_feedbacks', 'action' => 'index', 'type' => 'feedbacks', 'view_style' => 'listing-view', 'job_id' => $job['Job']['id'], 'admin' => false), array('escape' => false, 'title'=>__l('Feedback'), 'data-toggle' => 'tab', 'data-target' => '#Feedback', 'class' => 'btn btn-large btn-success js-no-pjax')); ?>
			  </li>
              <li class="text-16 span8 no-bor dc">
				<?php echo $this->Html->link('<span class="show ver-space">'. sprintf(__l('Other %s'), jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)) . '</span>', array('controller' => 'jobs', 'action' => 'index', 'type' => 'other', 'user' => $job['User']['username'], 'job' => $job['Job']['slug'], 'admin' => false), array('escape' => false, 'title'=> sprintf(__l('Other %s'), jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)), 'data-toggle' => 'tab', 'data-target' => '#OtherJobs', 'class' => 'btn btn-large btn-success js-no-pjax')); ?>
			  </li>
			  <?php if(!empty($job['Job']['address'])): ?>
              <li class="text-16 span8 no-bor dc">
			   <?php echo $this->Html->link('<span class="show ver-space">'.__l('Location').'</span>', array('controller' => 'jobs', 'action' => 'job_location',  'job_id' => $job['Job']['id'], 'admin' => false), array('escape' => false, 'title'=>__l('Location'), 'data-toggle' => 'tab', 'data-target' => '#Location', 'class' => 'btn btn-large btn-success js-no-pjax')); ?>
			  </li>
			  <?php endif; ?>
            </ul>
        <div class="container tab-content" id="TabContent">
			<div class="tab-pane in active" id="Feedback">
			<div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
			</div>
            <!-- listing block start -->

            <!-- listing block End -->
          
          <div class="tab-pane in top-space" id="OtherJobs">
		  <div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
          </div>
		  <?php if(!empty($job['Job']['address'])): ?>
          <div class="tab-pane in" id="Location">
		   <div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
          </div>
		  <?php endif; ?>
        </div>
		</div>
        </div>
      </section>
  </div>
<div class="dc hero-unit no-round no-mar">
<?php echo $this->Html->link(__l('Get Started'), array('controller' => 'jobs', 'action' => 'add', 'admin' => false), array('escape' => false, 'title'=>__l('Get Started'), 'class' => 'btn btn-large btn-success textb text-20 text-up')); ?>
</div>
<?php if (Configure::read('widget.job_script')) { ?>
	<div class="dc clearfix ver-space">
		<?php echo Configure::read('widget.job_script'); ?>
	</div>
<?php } ?>
  <div class="gig-view-content-block clearfix">
    <div class="clearfix">
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
</div>
</div>
