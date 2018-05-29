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
						<?php if (isPluginEnabled('RequestFavorites')) { ?>
						<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('%s Favorites'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)), array('controller' => 'request_favorites', 'action' => 'index','request_id'=>$request['Request']['id'], 'view_type' => 'user_view', 'admin' => true), array('title' => sprintf(__l('%s Favorites'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)), 'class' => ' js-no-pjax', 'data-target' => '#admin-request-favorites', 'escape' => false));?></li>
						<?php } ?>
						<?php if (isPluginEnabled('RequestFlags')) { ?>
						<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('%s Flags'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)), array('controller' => 'request_flags', 'action' => 'index','request_id'=>$request['Request']['id'], 'view_type' => 'user_view', 'admin' => true), array('title' =>sprintf(__l('%s Flags'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)), 'class' => ' js-no-pjax', 'data-target' => '#admin-request-flags', 'escape' => false));?></li>
						<?php } ?>	
                        <?php if (isPluginEnabled('Requests')) { ?>                        
						<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('%s Views'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)), array('controller' => 'request_views', 'action' => 'index','request'=>$request['Request']['slug'], 'view_type' => 'user_view', 'admin' => true),array('title' => sprintf(__l('%s Views'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps)), 'class' => ' js-no-pjax', 'data-target' => '#admin-request-views', 'escape' => false));?></li> 
                        <?php } ?>	
					</ul>
					<article class="panel-container clearfix pull-left">
					<div class="span24 tab-pane fade in active clearfix" id="admin-actions" style="display: block;">
						<ul class="unstyled clearfix">
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('controller' => 'requests', 'action'=>'delete', $request['Request']['id']), array('class' => 'js-confirm btn blackc js-no-pjax', 'title' => __l('Delete'), 'escape' => false));?></li>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-edit"></i>' . __l('Edit'), array('controller' => 'requests', 'action'=>'edit', $request['Request']['id']), array('class' => 'edit js-edit btn blackc js-no-pjax', 'title' => __l('Edit'), 'escape' => false));?></li>
							<?php if($request['Request']['is_system_flagged']):?>
							  <?php if($request['User']['is_active']):?>
								<li class="pull-left dc mspace">	<?php echo $this->Html->link('<i class="icon-minus-sign"></i>' . __l('Deactivate User'), array('controller' => 'users', 'action' => 'admin_update_status', $request['User']['id'], 'status' => 'deactivate'), array('class' => 'js-admin-update-job deactive-user btn blackc js-no-pjax', 'title' => __l('Deactivate user'), 'escape' => false));?>
								</li>
							  <?php else:?>
								<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-add-sign"></i>' . __l('Activate User'), array('controller' => 'users', 'action' => 'admin_update_status', $request['User']['id'], 'status' => 'activate'), array('class' => 'js-admin-update-job active-user btn blackc js-no-pjax', 'title' => __l('Activate user'), 'escape' => false));?>
								</li>
							  <?php endif;?>
							<?php endif;?>
							<?php if($request['Request']['is_system_flagged']):?>
								<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-flag"></i>' . __l('Clear flag'), array('controller' => 'requests', 'action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'deactivate'), array('class' => 'js-admin-update-job clear-flag btn blackc js-no-pjax', 'title' => __l('Clear flag'), 'escape' => false));?>
								</li>
							<?php else:?>
								<li class="pull-left dc mspace">	<?php echo $this->Html->link('<i class="icon-flag"></i>' . __l('Flag'), array('controller' => 'requests', 'action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'active'), array('class' => 'js-admin-update-job flag btn blackc js-no-pjax', 'title' => __l('Flag'), 'escape' => false));?>
										</li>
							<?php endif;?>
							<?php if($request['Request']['admin_suspend']):?>
								<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-eye-open"></i>' . __l('Unsuspend').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps), array('controller' => 'requests', 'action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'unsuspend'), array('class' => 'js-admin-update-job  btn blackc js-no-pjax unsuspend', 'title' => __l('Unsuspend').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps), 'escape' => false));?>
								</li>
							<?php else:?>
								<li class="pull-left dc mspace">	<?php echo $this->Html->link('<i class="icon-eye-close"></i>' . __l('Suspend').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps), array('controller' => 'requests', 'action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'suspend'), array('class' => 'js-admin-update-job suspend btn blackc js-no-pjax', 'title' => __l('Suspend').' '.requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps), 'escape' => false));?>
								</li>
							<?php endif;?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link((( $request['Request']['is_approved']) ? '<i class="icon-remove-sign"></i>' . __l('Disapprove') : '<i class="icon-ok-sign"></i>' . __l('Approve')), array('controller' => 'requests', 'action'=>'update_status',  $request['Request']['id'],'status' => (( $request['Request']['is_approved']) ? __l('disapproved') : __l('approved')), 'admin' => true), array('class' => "js-admin-update-job btn blackc js-no-pjax", 'title' => __l((( $request['Request']['is_approved']) ? __l('Disapprove') : __l('Approve'))), 'escape' => false));?></li>
						  
						</ul>
					</div>
					<?php if (isPluginEnabled('RequestFavorites')) { ?>
						<div class="tab-pane fade in active span23" id="admin-request-favorites" style="display: block;"></div>
					<?php } ?>
					<?php if (isPluginEnabled('RequestFlags')) { ?>
						<div class="tab-pane fade in active span23" id="admin-request-flags" style="display: block;"></div>
					<?php } ?>		
                    <?php if (isPluginEnabled('Requests')) { ?>                    
					<div class="tab-pane fade in active span23" id="admin-request-views" style="display: block;"></div>
                    <?php } ?>		
					</article>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?> 