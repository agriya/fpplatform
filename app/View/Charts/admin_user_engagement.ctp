<div class="js-response js-cache-load-admin-charts-user-engagement space sep-bot bot-mspace clearfix span24">
 	<h4 class="block-space span5 hor-mspace pull-left textb desk-no-mar"><?php echo __l('Users Engagement'); ?></h4>
	<div class="left-space span18 pull-left mob-clr left-mspace">
	  <section class="span24 pull-left">
		<div class="row span24 show">
		<?php 
			$span_size = 5;
			if(!isPluginEnabled('Requests')) :
			$span_size = 7;
			endif;
		?>
		  <div class="span<?php echo $span_size; ?> dc space pr">
			 <div class="center-box easy-pie-chart percentage easyPieChart" data-color="#D23435" data-percent="<?php echo $this->Html->cFloat(($idle_users/$total_users) * 100, false); ?>" data-size="90">
					<span class="percent"><?php echo $this->Html->cInt($idle_users, false); ?></span>
			</div>
			<h5><?php echo __l('Idle'); ?></h5>
		  </div>
		  <div class="span<?php echo $span_size; ?> dc space pr">
			<div class="center-box easy-pie-chart percentage easyPieChart" data-color="#9ABB30" data-percent="<?php echo $this->Html->cFloat(($job_users/$total_users) * 100, false); ?>" data-size="90">
					<span class="percent"><?php echo $this->Html->cInt($job_users, false); ?></span>
			</div>
			<h5><?php echo sprintf(__l('%s Posted'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></h5>
		  </div>
		  <?php if(isPluginEnabled('Requests')): ?>
		  <div class="span<?php echo $span_size; ?> dc space pr">
			<div class="center-box easy-pie-chart percentage easyPieChart" data-color="#3C84BF" data-percent="<?php echo $this->Html->cFloat(($request_posted_users/$total_users) * 100, false); ?>" data-size="90">
					<span class="percent"><?php echo $this->Html->cInt($request_posted_users, false); ?></span>
			</div>
			<h5><?php echo sprintf(__l('%s Posted'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)); ?></h5>
		  </div>
		<?php endif; ?>
		  <div class="span<?php echo $span_size; ?> dc space pr">
			<div class="center-box easy-pie-chart percentage easyPieChart" data-color="#CE59DE" data-percent="<?php echo $this->Html->cFloat(($engaged_users/$total_users) * 100, false); ?>" data-size="90">
					<span class="percent"><?php echo $this->Html->cInt($engaged_users, false); ?></span>
			</div>
			<h5><?php echo __l('Engaged'); ?></h5>
		  </div>
		</div>
	  </section>
	</div>
</div>