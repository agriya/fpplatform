<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php if($job_user['User']['job_count'] > 0){?>
<?php 
	$is_job_share_enabled = Configure::read('job.is_job_share_enabled');
	if(!empty($is_job_share_enabled)):
?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<?php endif;?>
<div class="jobs index js-response js-responses js-lazyload">
<h3 class="jobs-by"><?php echo jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.__l('by').' '.$this->Html->cText($job_user['User']['username']).' '.'('.$this->Html->cInt($job_user['User']['job_count']).')';?></h3>
<ol class="jobs-list clearfix">
<?php
if (!empty($jobs)):

$i = 0;
foreach ($jobs as $job):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
<?php /* SVN: $Id: $ */ ?>
<li>
<div class="clearfix">
<div class="clearfix">
<div class="user-img-block-left">
		<span class="<?php echo $job['Job']['admin_suspend']?'job-suspended':'';?>">&nbsp;</span>		
        <?php echo $this->Html->link($this->Html->showImage('UserAvatar',$job['User']['UserAvatar'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['User']['username'], false)), 'title' => $this->Html->cText($job['User']['username'], false))), array('controller' => 'users', 'action' => 'view',  $job['User']['username'], 'admin' => false), array('escape' => false)); ?>
    </div>
    
    <div class="user-info-block-right">
    	<h3><?php echo $this->Html->cText($job['User']['username']);?>: <?php echo $this->Html->link($this->Html->cText($job['Job']['title']), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']),array('title' => $this->Html->cText($job['Job']['title'], false),'escape' => false));?></h3>
        <p> <?php echo __l('in');?>:  <?php echo $this->Html->link(__l($job['JobCategory']['name']), array('controller'=>'jobs','action'=>'index','category' => $job['JobCategory']['slug']), array('title' => __l($this->Html->cText($job['JobCategory']['name'],false))));?>
        </p>
        			<div class="job-info">
            	<span class="job-type-<?php echo $job['Job']['job_type_id']; ?>" title="<?php echo  $job['JobType']['name'];?>"><?php echo  $job['JobType']['name'];?></span>
                 <?php if(!empty ($job['JobServiceLocation']['name']) && $job['Job']['job_type_id'] != ConstJobType::Online): ?>
                  <span class="job-service-location-<?php echo $job['Job']['job_service_location_id']; ?>"><?php echo $job['JobServiceLocation']['name']; ?></span>
                 <?php  endif; ?>
            </div>
			<p>  <?php echo __l('Work Duration');?>:
			<?php echo $this->Html->cInt($job['Job']['no_of_days']).' ';?>
			<?php echo ($job['Job']['no_of_days'] == '1') ? __l('Day') : __l('Days');?>
			</p>
			
			<div class="jobs-rating-block clearfix">
    			<p>
                    <?php
        				if($this->Auth->sessionValid()):
        					if(!empty($job['JobFavorite'])):
        						foreach($job['JobFavorite'] as $favorite):
        							if($job['Job']['id'] == $favorite['job_id'] && $favorite['user_id'] == $this->Auth->user('id')):
        								echo $this->Html->link(__l('Unlike'), array('controller' => 'job_favorites', 'action' => 'delete', $job['Job']['slug']), array('title' => __l('Unlike'),'escape' => false ,'class' =>'js-like un-like'));
        							endif;
        						endforeach;
        					else:
        						echo $this->Html->link(__l('Like'), array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'js-like like'));
        					endif;
        				else:
        					echo $this->Html->link(__l('Like'), array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'like'));
        				endif;
        			?>
                </p>
                <?php
					if(!empty($is_job_share_enabled)):
						// Twitter
						$tw_url = Router::url(array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']), true);
						$tw_url = urlencode_rfc3986($tw_url);
						$tw_message = $job['User']['username'].':'.' '.$job['Job']['title'].' '.__l('for').' '.$this->Html->siteCurrencyFormat($job['Job']['amount'], false);
						//$tw_message = urlencode_rfc3986($tw_message);
						// Facebook
						$fb_status = Router::url(array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']), true);
						$fb_status = urlencode_rfc3986($fb_status);
					?>
					<ul class="share-list share-list1">
						<li class="email"><?php echo $this->Html->link(__l('Email'), 'mailto:?subject='.__l('Cool! I found someone that will ').$job['Job']['title'].__l(' for '). $this->Html->siteCurrencyFormat($job['Job']['amount'], false).'&amp;body='.__l('Hi, Check it out: ').Router::url(array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'])), array('target' => 'blank', 'title' => __l('mail'), 'class' => 'quick'));?></li>
						<li class="twitter"><a href="http://twitter.com/share?url=<?php echo $tw_url;?>&amp;text=<?php echo $tw_message;?>&amp;lang=en" class="twitter-share-button"><?php echo __l('Tweet!');?></a></li>
						<li class="facebook"><fb:like href="<?php echo $fb_status;?>" layout="button_count" width="50" height="40" action="like"></fb:like></li>
					</ul>
                    <?php if (isPluginEnabled('SocialMarketing')) { ?>
					<div class="share-link">
						<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4be1665734d1eaab"><img src="http://s7.addthis.com/static/btn/sm-share-en.gif" width="83" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4be1665734d1eaab"></script>
					</div>
                    <?php } ?>
				<?php endif;?>
			</div>
			<p class="amount-value"><?php echo $this->Html->callOutImage($job['Job']['amount']);?></p>
        </div>
        <div class="clearfix feed-back-block">
		   <?php if(Configure::read('job.rating_type') == 'percentage'):?>
    				<dl class="ratings-feedback clearfix">
    					<dt class="rating" title = "<?php echo __l('Positive Rating'); ?>"><?php echo __l('Positive Rating:');?></dt>
    					<dd title = "<?php echo $this->Html->displayPercentageRating($job['Job']['job_feedback_count'], $job['Job']['positive_feedback_count']);?>" class="positive-feedback">
    						<?php echo $this->Html->displayPercentageRating($job['Job']['job_feedback_count'], $job['Job']['positive_feedback_count']); ?>
    					</dd>
    				</dl>
    		<?php else:?>
    				<dl class="ratings-feedback clearfix">
	                <dt  class="positive-feedback" title ="<?php echo __l('Positive Rating');?>"><?php echo __l('Positive Rating:');?></dt>
                     <dd> <?php  echo $this->Html->cInt($job['Job']['positive_feedback_count']); ?> </dd>
					<dt class="negative-feedback" title ="<?php echo __l('Negative Rating');?>"><?php echo __l('Negative Rating:');?></dt>
					  <dd><?php  echo $this->Html->cInt($job['Job']['job_feedback_count'] - $job['Job']['positive_feedback_count']); ?></dd>
                	</dl>
    		<?php endif;?>


    		<dl class="ratings-feedback clearfix">
    			<dt class="total-views" title="<?php echo __l('Total Views');?>"><?php echo __l('Total Views');?></dt>
                <?php $view_count = !empty($job['Job']['job_view_count']) ? $job['Job']['job_view_count'] : '0';?>
    			<dd> <?php echo $this->Html->cInt($view_count);?>
    			</dd>
    	    </dl>
        <div class="order-now">
		<?php if($this->Auth->sessionValid() && ($this->Auth->user('id') != $job['Job']['user_id'])): ?>
					<div class="jobOrders form clearfix">
						<div class="cancel-block">
						<?php if($job['Job']['job_service_location_id'] == ConstServiceLocation::SellerToBuyer || !empty($job['Job']['is_instruction_requires_attachment']) || !empty($job['Job']['is_instruction_requires_input'])):?>
							<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'job_orders','action'=>'add','job' => $job['Job']['id']), array('title' => __l('Buy Now'),'data-toggle'=>'modal','data-target'=>'#js-ajax-modal', 'class' => 'js-no-pjax'));?>
						<?php else:?>
							<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order',$job['Job']['id']), array('title' => __l('Buy Now'), 'data-toggle'=>'modal','data-target'=>'#js-ajax-modal', 'class' => 'js-no-pjax'));?>
						<?php endif;?>				
						</div>
					</div>
            		<?php elseif($this->Auth->sessionValid() && ($this->Auth->user('id') == $job['Job']['user_id'])): ?>
            			<div class="clearfix">
            			   <div class="cancel-block">
            					<?php echo $this->Html->link(__l('Edit'), array('controller'=>'jobs', 'action'=>'edit', $job['Job']['id']), array('title' => __l('Edit')));?>
            				</div>
            			</div>
            		<?php else:?>
            		    <div class="cancel-block suggest-cancel-block">
            				<?php echo $this->Html->link(__l('Buy Now'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Buy Now')));?>
            			</div>
            		<?php endif; ?>
		      </div>
        </div>
        </div>
     <div class="clearfix jobs-view-block">
	 
            <div class="jobs-view-block-left">
            <?php echo $this->Html->cText($job['Job']['description']);?>
			
			<div class="share-link">
			<?php if(!empty($job['Job']['youtube_url']) || ($job['Job']['flickr_url'])):?>
				<ul>
					<?php if($job['Job']['youtube_url']):?>
						<li><a href = " <?php echo 'http://'.$job['Job']['youtube_url'];?>" title="<?php echo __l('More on YouTube');?>" target = "_blank"><?php echo __l('More on YouTube');?></li>
					<?php endif;?>
					<?php if($job['Job']['flickr_url']):?>
						<li><a href = "<?php echo 'http://'.$job['Job']['flickr_url'];?>" title="<?php echo __l('More on Flickr');?>" target = "_blank"><?php echo __l('More on Flickr');?></li>
					<?php endif;?>
				</ul>
			<?php endif;?>
	     	</div>
	
          </div>
		
			<div class="jobs-view-block-right">
				<div class="jobs-view-img-block">
				<ul class="jobs-links">
					<?php
						foreach($job['JobTag'] as $tag):
							echo '<li>'. $this->Html->link(__l($tag['name']), array('controller'=>'jobs','action'=>'index','tag' => $tag['slug']), array('title' => __l($this->Html->cText($tag['name'],false)))).'</li>';
						endforeach;
					?>
				</ul>
				<div>
					<ul>
						<?php if(!empty($job['Attachment']['0'])):
							if($job['Job']['is_featured']):?>
								<span class="<?php echo ($job['Job']['is_featured']) ? 'featured' : ''; ?>">&nbsp;</span>		
							<?php endif;?>						
							<li><?php echo $this->Html->showImage('Job', $job['Attachment']['0'], array('dimension' => 'medium_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)), 'title' => $this->Html->cText($job['Job']['title'], false)));?></li>
						<?php endif; ?>
					</ul>
				</div>
             </div>
			</div>
        
</div>
</div>
</li>
<?php
    endforeach;
else:
?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.__l('available');?></p></div>
	</li>
<?php
endif;
?>
</ol>
<div class="<?php if(!empty($this->request->params['isAjax'])) { ?> js-pagination <?php } ?>">
<?php
if (!empty($jobs)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>
<?php } ?>