<?php 
if (!empty($user)) {
	Configure::write('highperformance.uid', $user['User']['id']);
	$uid = Configure::read('highperformance.uid');
}
?>
<?php /* SVN: $Id: view.ctp 4973 2010-05-15 13:14:27Z aravindan_111act10 $ */ ?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
      <section class="row bot-mspace bot-space js-user-view" data-user-id="<?php echo $user['User']['id']; ?>">
        <div class="sep-bot bot-mspace">
          <h2 class="container text-32 bot-space mob-dc"><?php echo $this->Html->cText($user['User']['username']); ?></h2>
        </div>
        <div class="container clearfix">
          <div class="pull-left span5 top-space mob-dc no-mar"> 
          <?php  echo $this->Html->getUserAvatarLink($user['User'], 'large_thumb', true, '', 'sep sep-big sep-black');?> 
            <dl class="top-mspace clearfix">
              <dt class="bot-space span textn right-mspace grayc"><?php echo ('Joined on'); ?> </dt>
              <dd class="bot-space span no-mar graydarkerc"><?php echo $this->Html->cDate($user['User']['created']); ?></dd>
            </dl>
			<?php if(Configure::read('job.rating_type') == 'percentage'):?>
			<div class="text-20 tab-clr clearfix">
            <span class="inline"><span class="right-mspace"><i class="icon-thumbs-up-alt no-pad grayc"></i></span><span class="right-mspace"><?php echo $this->html->displayPercentageRating($user['User']['job_feedback_count'], $user['User']['positive_feedback_count']); ?></span></span>
            </div>
			<?php else:?>
			<div class="text-24 tab-clr clearfix">
			<span class="inline"><span class="right-mspace"><i class="icon-thumbs-up-alt no-pad grayc"></i></span><span class="right-mspace"><?php echo $this->html->cInt($user['User']['positive_feedback_count']); ?></span></span>
            <span class="inline"><span class="right-mspace"><i class="icon-thumbs-down-alt no-pad grayc"></i></span><span class="right-mspace"><?php echo $this->html->cInt($user['User']['job_feedback_count'] - $user['User']['positive_feedback_count']); ?></span></span>
			</div>
			<?php endif;?>
          </div>
          <div class="user-block span19 span20-sm pull-right">
            <div class="clearfix">
              <h3  class="clearfix text-24 mob-dc no-mar"><?php echo __l('As Seller');?></h3>
              <div class="clearfix">
                <dl class="list list-big dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo __l('Job Posted');?></dt>
                  <dd title="<?php echo $user['User']['active_job_count']; ?>" class="text-30 pr"><?php echo $this->Html->cText($user['User']['active_job_count'], false); ?></dd>
                </dl>
                <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo __l('Success Rate');?></dt>
				  <?php
					 $total_completed = $success_rate = $on_time_rate  =0;
					if(!empty($user['User']['order_success_without_overtime_count']) || !empty($user['User']['order_success_with_overtime_count'])) {
						$total_completed  = $user['User']['order_success_without_overtime_count']+$user['User']['order_success_with_overtime_count'];
					}
					if(!empty($user['User']['order_received_count'])) {
						$success_rate = ($total_completed/$user['User']['order_received_count'])*100 ;
						$success_rate  = ($success_rate > 100)? 100 : $success_rate;
					}
					if(!empty($user['User']['order_success_without_overtime_count'])) {
						$on_time_rate = ($user['User']['order_success_without_overtime_count']/$total_completed)*100 ;
						$on_time_rate  = ($on_time_rate > 100)? 100 : $on_time_rate;
					}
				?>
                  <dd title="<?php echo sprintf('%s/%s', $this->Html->cInt($total_completed , false),$this->Html->cInt($user['User']['order_received_count'], false)); ?>" class="text-30 pr"><?php echo sprintf('%s/%s', $this->Html->cInt($total_completed, false),$this->Html->cInt($user['User']['order_received_count'], false)); ?></dd>
                </dl>
                <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo __l('On Time');?></dt>
                  <dd title="<?php echo sprintf('%s/%s', $this->Html->cInt($user['User']['order_success_without_overtime_count'], false),$this->Html->cInt($total_completed, false)); ?>" class="text-30 pr"><?php echo sprintf('%s/%s', $this->Html->cInt($user['User']['order_success_without_overtime_count'], false),$this->Html->cInt($total_completed, false)); ?></dd>
                </dl>
                <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo __l('Works in progress');?></dt>
                  <dd title="<?php echo $this->Html->cInt($user['User']['order_active_count'], false);?>" class="text-30 pr"><?php echo $this->Html->cInt($user['User']['order_active_count'], false);?></dd>
                </dl>
                <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo __l('Latest order on');?></dt>
				  <?php if(!empty($user['User']['order_last_accepted_date']) && $user['User']['order_last_accepted_date'] != '0000-00-00 00:00:00'){
							$latest_order= $this->Html->cDateTimeHighlight($user['User']['order_last_accepted_date']);
							$latest_order_title = $user['User']['order_last_accepted_date'];
					  }else{
							$latest_order=  '-';
							$latest_order_title = '-';
					  }
				  ?>
                  <dd title="<?php echo $latest_order_title;?>" class="text-30 pr"><?php echo $latest_order ;?></dd>
                </dl>
              </div>
            </div>
            <div class="clearfix">
              <h3 class="no-mar mob-dc text-24"><?php echo __l('As Buyer');?></h3>
              <div class="clearfix">
                <dl class="list list-big dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo __l('Orders');?></dt>
                  <dd class="text-30 pr hor-mspace" title="<?php echo sprintf('%s', $this->Html->cInt($user['User']['buyer_order_purchase_count'], false));?>"><?php echo sprintf('%s', $this->Html->cInt($user['User']['buyer_order_purchase_count'], false));?></dd>
                </dl>
				<?php if (isPluginEnabled('Requests')) { ?>
                <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps);?></dt>
                  <dd class="text-30 pr hor-mspace" title="<?php echo sprintf('%s', $this->Html->cInt($user['User']['request_count'], false));?>"><?php echo sprintf('%s', $this->Html->cInt($user['User']['request_count'], false));?></dd>
                </dl>
				<?php } ?>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="row no-mar">
        <div class="secondary-bg no-round top-space">
          <div class="container clearfix"  id="ajax-tab-container-job-view">
            <ul class="nav nav-tabs no-bor top-mspace" id="Tab">
				<?php if(isPluginEnabled('Jobs')) { ?>
		            <li class="text-16 span8 no-bor dc no-mar active">
					<?php echo $this->Html->link('<span class="show ver-space">'.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.'('.$this->Html->cInt($user['User']['active_job_count']).')</span>', array('controller' => 'jobs', 'action' => 'index','type' => 'user_jobs','is_page_title'=>'no', 'username' => $user['User']['username'], 'admin' => false), array('escape' => false, 'title'=>__l(jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)), 'data-toggle' => 'tab', 'data-target' => '#jobs-list', 'class' => 'js-no-pjax')); ?>
					</li>
				<?php } ?>
				<?php if(isPluginEnabled('Requests')) { ?>
		            <li class="text-16 span8 no-bor dc">
					<?php echo $this->Html->link('<span class="show ver-space">'.requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps).' '.'('.$this->Html->cInt($user['User']['request_count']).')</span>', array('controller' => 'requests', 'action' => 'index','type' => 'request','is_page_title'=>'no', 'username' => $user['User']['username'], 'admin' => false), array('escape' => false, 'title'=>__l(requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps)), 'data-toggle' => 'tab', 'data-target' => '#request-list', 'class' => 'js-no-pjax')); ?>
					
					</li>
				<?php } ?>
				<?php if(isPluginEnabled('Jobs') && isPluginEnabled('JobFavorites')) { ?>
					<li class="text-16 span8 no-bor dc">
					<?php echo $this->Html->link('<span class="show ver-space">'.__l('Favourite').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.'('.$this->Html->cInt($user['User']['job_favorite_count']).')</span>', array('controller' => 'jobs', 'action' => 'index','type' => 'favorite','is_page_title'=>'no', 'username' => $user['User']['username'], 'admin' => false), array('escape' => false, 'title'=>__l('Favourite').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps), 'data-toggle' => 'tab', 'data-target' => '#favorite-list', 'class' => 'js-no-pjax')); ?>
				<?php } ?>
            </ul>
         
        <div id="TabContent" class="container  tab-content">
          <div id="jobs-list" class="tab-pane active">
             <div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
          </div>
          <div id="request-list" class="tab-pane">
		  <div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
          </div>
          <div id="favorite-list" class="tab-pane">
		  <div class="offset10 span2 dc space"><?php echo $this->Html->image('ajax-loader.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?></div>
          </div>
        </div>
		 </div>
        </div>
      </section>
      <?php if (Configure::read('widget.user_script')) { ?>
      <div class="dc clearfix ver-space">
      <?php echo Configure::read('widget.user_script'); ?>
      </div>
    <?php } ?>
<div class="users view user-view-blocks">
<div class="location-block clearfix">
	<?php 
		$is_job_share_enabled = Configure::read('job.is_job_share_enabled');
		if(!empty($is_job_share_enabled)):
	?>
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