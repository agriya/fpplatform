<section class="hor-space row-fluid js-cache-load-admin-user-activities">
 <?php $i=0; ?>
          		 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#registration','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#a47ae2'}"><?php echo $user_reg_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph1c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_user_reg;?>"><?php echo $total_user_reg;?> </div>
								<div class="text-12 pull-right <?php if ($user_reg_data_per>0) {?> greenc <?php } else if($user_reg_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $user_reg_data_per;?>%</span>
									<?php if (!empty($user_reg_data_per)) {?>
										<i class="<?php if ($user_reg_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('User Registration'); ?>"><?php echo __l('User Registration'); ?></div>
						</div>
					</div>
				 </div>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#login','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#4986e7'}"><?php echo $user_log_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph2c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_user_login;?>"><?php echo $total_user_login;?> </div>
								<div class="text-12 pull-right <?php if ($user_log_data_per>0) {?> greenc <?php } else if($user_log_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $user_log_data_per;?>%</span>
									<?php if (!empty($user_log_data_per)) {?>
										<i class="<?php if ($user_log_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>

							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('User Logins'); ?>"><?php echo __l('User Logins'); ?></div>
						</div>
					</div>
				 </div>
				 <?php if (isPluginEnabled('UserFavourites')) {?>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#login','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#f691b2'}"><?php echo $user_follow_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph3c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_user_follow;?>"><?php echo $total_user_follow;?> </div>
								<div class="text-12 pull-right <?php if ($user_follow_data_per>0) {?> greenc <?php } else if($user_follow_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $user_follow_data_per;?>%</span>
									<?php if (!empty($user_follow_data_per)) {?>
										<i class="<?php if ($user_follow_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('User Followers'); ?>"><?php echo __l('User Followers'); ?></div>
						</div>
					</div>
				 </div>
				 <?php }?>
				 <?php if (isPluginEnabled('Jobs')) { ?>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#jobs','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#cd74e6'}"><?php echo $jobs_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph4c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_jobs;?>"><?php echo $total_jobs;?> </div>
								<div class="text-12 pull-right <?php if ($jobs_data_per>0) {?> greenc <?php } else if($jobs_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $jobs_data_per;?>%</span>
									<?php if (!empty($jobs_data_per)) {?>
										<i class="<?php if ($jobs_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps); ?>"><?php echo jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				 <?php if (isPluginEnabled('Jobs')) { ?>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#job_orders','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#ff7537'}"><?php echo $job_order_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph5c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_job_order;?>"><?php echo $total_job_order;?> </div>
								<div class="text-12 pull-right <?php if ($job_order_data_per>0) {?> greenc <?php } else if($job_order_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $job_order_data_per;?>%</span>
									<?php if (!empty($job_order_data_per)) {?>
										<i class="<?php if ($job_order_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo sprintf(__l('%s Orders'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?>"><?php echo sprintf(__l('%s Orders'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#job_feedbacks','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#d06b64'}"><?php echo $job_feedbacks_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph6c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_job_feedbacks;?>"><?php echo $total_job_feedbacks;?> </div>
								<div class="text-12 pull-right <?php if ($job_feedbacks_data_per>0) {?> greenc <?php } else if($job_feedbacks_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $job_feedbacks_data_per;?>%</span>
									<?php if (!empty($job_feedbacks_data_per)) {?>
										<i class="<?php if ($job_feedbacks_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo sprintf(__l('%s Feedbacks'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?>"><?php echo sprintf(__l('%s Feedbacks'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></div>
						</div>
					</div>
				 </div>
				 <?php if (isPluginEnabled('Requests')) { ?>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#requests','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#cd74e6'}"><?php echo $requests_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph4c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_requests;?>"><?php echo $total_requests;?> </div>
								<div class="text-12 pull-right <?php if ($requests_data_per>0) {?> greenc <?php } else if($requests_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $requests_data_per;?>%</span>
									<?php if (!empty($requests_data_per)) {?>
										<i class="<?php if ($requests_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps); ?>"><?php echo requestAlternateName(ConstRequestAlternateName::Plural,ConstRequestAlternateName::FirstLeterCaps); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				 <?php if (isPluginEnabled('RequestFavorites')) { ?>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#request_favorites','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#ac725e'}"><?php echo $request_favorites_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph9c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_request_favorites;?>"><?php echo $total_request_favorites;?> </div>
								<div class="text-12 pull-right <?php if ($request_favorites_data_per>0) {?> greenc <?php } else if($request_favorites_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $request_favorites_data_per;?>%</span>
									<?php if (!empty($request_favorites_data_per)) {?>
										<i class="<?php if ($request_favorites_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo sprintf(__l('%s Favorites'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)); ?>"><?php echo sprintf(__l('%s Favorites'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				 <?php if (isPluginEnabled('JobFavorites')) { ?>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#job_favorites','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#9fe1e7'}"><?php echo $job_favorites_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph10c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_job_favorites;?>"><?php echo $total_job_favorites;?> </div>
								<div class="text-12 pull-right <?php if ($job_favorites_data_per>0) {?> greenc <?php } else if($job_favorites_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $job_favorites_data_per;?>%</span>
									<?php if (!empty($job_favorites_data_per)) {?>
										<i class="<?php if ($job_favorites_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo sprintf(__l('%s Favorites'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?>"><?php echo sprintf(__l('%s Favorites'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></div>
						</div>
					</div>
				 </div>
				 <?php }?>
				 <?php if (isPluginEnabled('JobFlags')) { ?>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#jobflag','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#b99aff'}"><?php echo $job_flag_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph11c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_job_flag;?>"><?php echo $total_job_flag;?> </div>
								<div class="text-12 pull-right <?php if ($job_flag_data_per>0) {?> greenc <?php } else if($job_flag_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $job_flag_data_per;?>%</span>
									<?php if (!empty($job_flag_data_per)) {?>
										<i class="<?php if ($job_flag_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>

							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo sprintf(__l('%s Flags'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?>"><?php echo sprintf(__l('%s Flags'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></div>
						</div>
					</div>
				 </div>
				 <?php }?>
				 <?php if (isPluginEnabled('RequestFlags')) { ?>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#requestflag','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#b99aff'}"><?php echo $request_flag_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph11c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_request_flag;?>"><?php echo $total_request_flag;?> </div>
								<div class="text-12 pull-right <?php if ($request_flag_data_per>0) {?> greenc <?php } else if($request_flag_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $request_flag_data_per;?>%</span>
									<?php if (!empty($request_flag_data_per)) {?>
										<i class="<?php if ($request_flag_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>

							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo sprintf(__l('%s Flags'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)); ?>"><?php echo sprintf(__l('%s Flags'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				  <?php if (isPluginEnabled('UserFlags')) { ?>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#userflag','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#b99aff'}"><?php echo $user_flag_data;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph11c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_user_flag;?>"><?php echo $total_user_flag;?> </div>
								<div class="text-12 pull-right <?php if ($user_flag_data_per>0) {?> greenc <?php } else if($user_flag_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $user_flag_data_per;?>%</span>
									<?php if (!empty($user_flag_data_per)) {?>
										<i class="<?php if ($user_flag_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>

							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('User Flags'); ?>"><?php echo __l('User Flags'); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				 <div class="span7 thumbnail mob-bot-mspace <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#revenue','admin'=>true),array('escape'=> false,'class'=>'js-no-pjax'));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span6" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#ffad46'}"><?php echo $revenue;?></span>
						</div>
						<div class="span18">
							<div class="span">
								<div class="text-24 pull-left graph12c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_revenue;?>"><?php echo $total_revenue;?></div>
								<div class="text-12 pull-right <?php if ($rev_per>0) {?> greenc <?php } else if($rev_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $rev_per;?>%</span>
									<?php if (!empty($rev_per)) {?>
										<i class="<?php if ($rev_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
                            <div class="span24 htruncate js-tooltip" title="<?php echo __l('Revenue').' ('.Configure::read('site.currency').')'; ?>"><?php echo __l('Revenue').' ('.Configure::read('site.currency').')'; ?></div>
						</div>
					</div>
				 </div>
          </section>