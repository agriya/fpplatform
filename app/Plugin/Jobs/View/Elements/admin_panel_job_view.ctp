<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
	<div class="accordion-admin-panel" id="js-admin-panel">
		<div class="clearfix js-admin-panel-head admin-panel-block">
			<div class="admin-panel-inner span4 pa accordion-heading no-mar no-bor clearfix box-head admin-panel-menu">
				<a data-toggle="collapse" data-parent="#accordion-admin-panel" href="#adminPanel" class="btn js-show-panel accordion-toggle span4 js-toggle-icon js-no-pjax blackc no-under clearfix"><i class="pull-right caret"></i><i class="icon-user"></i> <?php echo __l('Admin Panel'); ?></a>
			</div>
			<div class="accordion-body no-round no-bor collapse" id="adminPanel">
				<div id="ajax-tab-container-admin" class="accordion-inner thumbnail clearfix no-bor tab-container admin-panel-inner-block pr">
					<ul class="nav nav-tabs tabs clearfix">
						<li class="tab"><?php echo $this->Html->link(__l('Actions'), '#admin-actions',array('class' => 'js-no-pjax span2', 'title'=>__l('Actions'), 'data-toggle'=>'tab', 'rel' => 'address:/admin_actions')); ?></li>
						<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('%s Orders'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('controller' => 'job_orders', 'action' => 'index', 'job_id'=>$job['Job']['id'],'userview'=>true, 'view_type' => 'user_view',  'admin' => true), array('title' => sprintf(__l('%s Orders'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), 'class' => ' js-no-pjax', 'data-target' => '#admin-orders-views', 'escape' => false)); ?></li>
						<?php if (isPluginEnabled('JobFavorites')) { ?>
						<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('%s Favorites'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('controller' => 'job_favorites', 'action' => 'index','job_id'=>$job['Job']['id'], 'view_type' => 'user_view', 'admin' => true), array('title' => sprintf(__l('%s Favorites'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), 'class' => ' js-no-pjax', 'data-target' => '#admin-job-favorites', 'escape' => false));?></li>
						<?php } ?>
						<?php if (isPluginEnabled('JobFlags')) { ?>
						<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('%s Flags'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('controller' => 'job_flags', 'action' => 'index','job_id'=>$job['Job']['id'], 'view_type' => 'user_view', 'admin' => true), array('title' => sprintf(__l('%s Flags'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), 'class' => ' js-no-pjax', 'data-target' => '#admin-job-flags', 'escape' => false));?></li>
						<?php } ?>
						<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('%s Views'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), array('controller' => 'job_views', 'action' => 'index','job'=>$job['Job']['slug'], 'view_type' => 'user_view', 'admin' => true),array('title' => sprintf(__l('%s Views'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)), 'class' => ' js-no-pjax', 'data-target' => '#admin-job-views', 'escape' => false));?></li>
					</ul>
					<article class="panel-container clearfix pull-left">
					<div class="span24 tab-pane fade in active clearfix" id="admin-actions" style="display: block;">
						<ul class="unstyled clearfix">
						  <?php if(empty($job['Job']['is_deleted'])):?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-edit"></i>' . __l('Edit'), array('action' => 'edit', $job['Job']['id']), array('class' => 'edit js-edit btn blackc js-no-pjax', 'title' => __l('Edit'), 'escape' => false));?></li>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('action' => 'delete', $job['Job']['id']), array('class' => 'delete js-confirm btn blackc js-no-pjax', 'title' => __l('Disappear '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' from user side'), 'escape' => false));?></li>
							<?php if($job['Job']['is_system_flagged']):?>
							
								<?php if($job['User']['is_active']):?>
									<li class="pull-left dc mspace">	<?php echo $this->Html->link('<i class="icon-minus-sign"></i>' . __l('Deactivate User'), array('controller' => 'users', 'action' => 'admin_update_status', 'admin'=>'true', $job['User']['id'], 'status' => 'deactivate'), array('class' => 'js-admin-update-job deactive-user btn blackc js-no-pjax', 'title' => __l('Deactivate user'), 'escape' => false));?>
								</li>
								<?php else:?>
										<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-add-sign"></i>' . __l('Activate User'), array('controller' => 'users', 'action' => 'admin_update_status', 'admin'=>'true', $job['User']['id'], 'status' => 'activate'), array('class' => 'js-admin-update-job active-user btn blackc js-no-pjax', 'title' => __l('Activate user'), 'escape' => false));?>
										</li>
								<?php endif;?>
								
							<?php endif;?>
						
								<?php if($job['Job']['is_system_flagged']):?>
									<li class="pull-left dc mspace">	<?php echo $this->Html->link('<i class="icon-flag"></i>' . __l('Clear flag'), array('action' => 'admin_update_status', 'admin'=>'true', $job['Job']['id'], 'flag' => 'deactivate'), array('class' => 'js-admin-update-job clear-flag btn blackc js-no-pjax', 'title' => __l('Clear flag'), 'escape' => false));?>
									</li>
								<?php else:?>
									<li class="pull-left dc mspace">	<?php echo $this->Html->link('<i class="icon-flag"></i>' . __l('Flag'), array('action' => 'admin_update_status', 'admin'=>'true', $job['Job']['id'], 'flag' => 'active'), array('class' => 'js-admin-update-job flag btn blackc js-no-pjax', 'title' => __l('Flag'), 'escape' => false));?>
									</li>
								<?php endif;?>
								<?php if($job['Job']['admin_suspend']):?>
										<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-eye-open"></i>' . __l('Unsuspend').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('action' => 'admin_update_status', 'admin'=>'true', $job['Job']['id'], 'flag' => 'unsuspend'), array('class' => 'js-admin-update-job  unsuspend btn blackc js-no-pjax', 'title' => __l('Unsuspend').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), 'escape' => false));?>
									</li>
								<?php else:?>
									<li class="pull-left dc mspace">	<?php echo $this->Html->link('<i class="icon-eye-close"></i>' . __l('Suspend').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('action' => 'admin_update_status', 'admin'=>'true', $job['Job']['id'], 'flag' => 'suspend'), array('class' => 'js-admin-update-job suspend btn blackc js-no-pjax', 'title' => __l('Suspend').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), 'escape' => false));?>
								</li>
								<?php endif;?>
							<?php else:?>
								<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-delete-point"></i>' . __l('Permanent Delete'), array('action' => 'delete', $job['Job']['id']), array('class' => 'delete js-delete btn blackc js-no-pjax', 'title' => __l('Delete'), 'escape' => false));?></li>
							<?php endif;?>
						  
							<li class="pull-left dc mspace"><?php echo $this->Html->link((( $job['Job']['is_approved']) ? '<i class="icon-remove-sign"></i>' . __l('Disapprove') : '<i class="icon-ok-sign"></i>' . __l('Approve')), array('action'=>'update_status',  $job['Job']['id'],'status' => (( $job['Job']['is_approved']) ? __l('disapproved') : __l('approved')), 'admin' => true), array('class' => "js-admin-update-job btn blackc js-no-pjax", 'title' => __l((( $job['Job']['is_approved']) ? __l('Disapprove') : __l('Approve'))), 'escape' => false));?></li>
						</ul>
					</div>
					<div class="tab-pane fade in active span23" id="admin-orders-views" style="display: block;"></div>
					<div class="tab-pane fade in active span23" id="admin-job-favorites" style="display: block;"></div>
					<div class="tab-pane fade in active span23" id="admin-job-flags" style="display: block;"></div>
					<div class="tab-pane fade in active span23" id="admin-job-views" style="display: block;"></div>
					</article>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?> 