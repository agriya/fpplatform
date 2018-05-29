<?php /* SVN: $Id: $ */ ?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
      <section class="row bot-mspace bot-space">
        <div class="sep-bot bot-mspace">
          <h2 class="container text-32 mob-text-32 bot-space mob-dc">
		  <?php
				if($this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin) && !empty($job['Job']['is_system_flagged'])):
					echo $this->Html->filterSuspiciousWords($job['Job']['title'], $job['Job']['detected_suspicious_words']);
				else:
					echo '<span class="grayc pull-left mob-clr">'.__l('Activities').' - '.'</span>'.$this->Html->link($this->Html->cText($job['Job']['title']), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']), array('class' => 'span15 no-mar htruncate graydarkerc mob-clr', 'target' => '_blank', 'title' => $this->Html->cText($job['Job']['title'], false),'escape' => false)).'<span class="grayc pull-left mob-clr">'.' - #'.$this->request->params['named']['order_id'].'</span>';
					$amt=$this->Html->siteCurrencyFormat($job['Job']['amount']);
				 endif;
			   ?>
		</h2>
        </div>
        <div class="container clearfix mob-dc">
          <div class="pull-left mob-inline top-space mob-dc no-mar"> 
		  <?php echo $this->Html->showImage('Job', !empty($job['Attachment'][0])?$job['Attachment'][0]:'', array('dimension' => 'large_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)), 'title' => $this->Html->cText('I will '.$job['Job']['title'].' for '. $this->Html->siteCurrencyFormat($job['Job']['amount']), false)));?> 
		  
		  </div>
          <div class="span7 hor-space clearfix top-mspace">
            <div class="clearfix"> 
			<span title="<?php echo  $job['JobType']['name'];?>">
			<i class="icon-desktop <?php echo ($job['Job']['job_type_id'] == ConstJobType::Online)?'linkc':'grayc'; ?>"></i>
			</span> 
			<?php
				if($this->Auth->sessionValid() && ($this->Auth->user('id') != $job['Job']['user_id']) && isPluginEnabled('SocialMarketing') && isPluginEnabled('JobFlags')):
					echo $this->Html->link('<i class="icon-flag grayc no-pad hor-smspace"></i>'.__l('Report').' '.jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps), array('controller' => 'job_flags', 'action' => 'add', $job['Job']['id']), array('title' => __l('Report').' '.jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps),'escape' => false,'data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class' =>'report-jobs bluec js-no-pjax'));
				endif;
			?>
			</div>

            <dl class="clearfix ver-smspace">
              <dt class="pull-left mob-inline mob-no-pad right-space"><?php echo __l('in');?>: </dt>
              <dd class="mob-inline pull-left no-mar">
			  <?php echo $this->Html->link($job['JobCategory']['name'], array('controller'=>'jobs','action'=>'index','category' => $job['JobCategory']['slug']), array('class' => 'bluec', 'title' => $job['JobCategory']['name']));?>
			  </dd>
            </dl>
            <p><?php echo $this->Html->siteCurrencyFormat($job['Job']['amount']);?></p>
          </div>
          <div class="span10 differ-block pull-right top-space">
            <dl class="dl-horizontal no-mar ver-space sep-bot">
			<?php	
			if(!empty($order['JobOrder']['user_id']) && $this->Auth->user('id') != $order['JobOrder']['user_id']) {?>
			  <dt class="dl left-space textn"><?php echo __l('Buyer name'); ?></dt>
              <dd class="grayc">
						<?php echo $this->Html->link($order['User']['username'], array('controller' => 'users', 'action' => 'view', $order['User']['username'], 'admin' => false), array('class' => 'bluec span2 htruncate inline no-mar'));?>
				<span class="inline">
						(<?php echo $this->Html->link(__l('Contact Buyer'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $order['User']['username'],'job_order_id' => $this->request->params['named']['order_id'], 'admin' => false), array('class' => 'bluec', 'title' => __l('Contact Buyer')));?>)
				</span>
			  </dd>
			  <?php } else  { ?>

			  <dt class="dl left-space textn"><?php echo __l('Seller name'); ?></dt>
              <dd class="grayc">
						<?php echo $this->Html->link($job['User']['username'], array('controller' => 'users', 'action' => 'view', $job['User']['username'], 'admin' => false), array('class' => 'bluec span2 htruncate inline no-mar'));?>
				<span class="inline">
						(<?php echo $this->Html->link(__l('Contact Seller'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $job['User']['username'],'job_order_id' => $this->request->params['named']['order_id'], 'admin' => false), array('class' => 'bluec', 'title' => __l('Contact Seller')));?>)
				</span>
			  </dd>

			  <?php } ?>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Work Duration') ;?></dt>
              <dd class="grayc">
			  <?php echo $this->Html->cInt($job['Job']['no_of_days']).' ';?>
			  <?php echo ($job['Job']['no_of_days'] == '1') ? __l('Day') : __l('Days');?>
			  </dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Online/Offline') ;?></dt>
              <dd class="grayc"><?php echo  $job['JobType']['name'];?></dd>
            </dl>
            <dl class="dl-horizontal no-mar ver-space sep-bot">
              <dt class="dl left-space textn"><?php echo __l('Posted on') ;?></dt>
              <dd class="grayc"><?php echo $this->Time->timeAgoInWords($job['Job']['created']); ?></dd>
            </dl>
          </div>
        </div>
      </section>