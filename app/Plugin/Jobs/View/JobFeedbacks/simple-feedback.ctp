<?php /* SVN: $Id: $ */ ?>
<?php if(empty($this->request->params['isAjax'])): ?>
<div class="tabbable tabs-left bot-mspace" id="ajax-tab-container-review">
	<ul id="Tableft" class="nav nav-tabs no-mar">
		<li class="text-16 span3 no-mar no-bor dc"><?php echo $this->Html->link('<span class="hor-space">'.__l('Yes').'</span><i class="icon-thumbs-up-alt greenc"></i>', array('controller' => 'job_feedbacks', 'action' => 'add', 'job_order_id' => $this->request->params['named']['job_order_id'], 'view_type' => 'simple-feedback','selected' => 'yes', 'job_type_id' => $message['job_type_id']), array('data-target' => '#yes', 'data-toggle' => 'tab', 'title' => __l('Yes'), 'escape' => false, 'class' => 'ver-space js-no-pjax')); ?></li>
		<li class="text-16 span3 no-mar no-bor dc"><?php echo $this->Html->link('<span class="hor-space">'.__l('No').'</span><i class="icon-thumbs-down-alt redc"></i>', array('controller' => 'job_feedbacks', 'action' => 'add', 'job_order_id' => $this->request->params['named']['job_order_id'], 'view_type' => 'simple-feedback','selected' => 'no', 'job_type_id' => $message['job_type_id']), array('data-target' => '#no', 'data-toggle' => 'tab', 'title' => __l('No'), 'escape' => false, 'class' => 'ver-space js-no-pjax js-ajax-form')); ?></li>
	</ul>
	<div class="tab-content bot-mspace" id="TabContent">
		<div class="tab-pane space thumbnail no-shad top-mspace in active" id="yes">
		</div>
		<div class="tab-pane" id="no">
		</div>
	</div>
</div>
<?php endif;?>
<?php if(!empty($this->request->params['isAjax'])): ?>
<?php if($this->request->params['named']['selected'] == 'no'): ?>
	<?php echo $this->element('job-order-manage-tabs', array('job_order_id' => $message['job_order_id'], 'order_status_id' => $message['job_order_status_id'], 'job_type_id' => $message['job_type_id'], 'type' => 'myorders', 'cache' => array('time' => Configure::read('site.element_cache_duration'))), array('plugin' => 'Jobs'));?>
<?php else:?>
<div class="js-responses">
<?php if(!empty($this->request->params['named']['selected'])): ?>
	<section class="space row no-mar">
	<?php echo $this->Form->create('JobFeedback', array('class' => 'form-horizontal normal no-mar'));?>
	<?php
		echo $this->Form->input('is_from_activities', array('type' => 'hidden', 'value' => 1));
		echo $this->Form->input('job_id',array('type'=>'hidden','value' => $message['job_id']));
		echo $this->Form->input('job_order_id',array('type'=>'hidden','value' => $message['job_order_id']));
		echo $this->Form->input('user_id',array('type'=>'hidden','value' => $this->Auth->user('id')));
		echo $this->Form->input('job_order_user_id',array('type'=>'hidden','value' => $message['job_order_user_id']));
		echo $this->Form->input('job_order_user_email',array('type'=>'hidden','value' => $message['job_seller_email']));
		?>
     	<div class="click-info-block yes-info-block">
			<div class="click-info">
			<?php
				$is_satisfied = (!empty($this->request->params['named']['selected']) && $this->request->params['named']['selected'] == 'yes') ? '1' : '0';
				echo $this->Form->input('is_satisfied',array('value' => $is_satisfied, 'type' => 'hidden'));
			?>
			</div>
			<?php
				$thumb_class = (!empty($this->request->params['named']['selected']) && $this->request->params['named']['selected'] == 'yes') ?  'positive-feedback' : 'negative-feedback';
			?>
			<p>
				<?php
					if($thumb_class == "positive-feedback"):
						echo '<i class="icon-thumbs-up-alt"></i>'.__l('You are rating this work, Positive :)');
					else:
						if($message['job_type_id'] == ConstJobType::Offline) :
							$info_mess =  '<i class="icon-thumbs-down-alt"></i>'.__l("You are rating this work, Negative :("); 
							if(isPluginEnabled('Disputes')) :
								$info_mess .= __l("<p>If you are not satisfied with the work and need refund, you can open a \"dispute\".</p>");
							endif;
						else:
							$info_mess =  '<i class="icon-thumbs-down-alt"></i>'.__l("You are rating this work, Negative :( <p>You can also, request for rework, by selecting \"Request Improvement\" tab.</p>");						
							if(isPluginEnabled('Disputes')) :
								$info_mess .= __l("<p>Or, if you are not satisfied with the work and need refund, you can open a \"dispute\".</p>");
							endif;
						endif;
						echo $info_mess;
					endif;
				?>
			</p>
			
			<?php
				
				echo $this->Form->input('feedback',array('label' => __l('Review')));
			?>
			<div class="submit top-mspace mob-clr mob-dc">
				<?php echo $this->Form->submit(__l('Submit'), array('class' => 'js-delete btn  btn-primary textb text-16'));?>
			</div>
			<?php echo $this->Form->end();?>
		</div>
	</section>
<?php endif;?>
	</div>
<?php endif;?>
<?php endif;?>