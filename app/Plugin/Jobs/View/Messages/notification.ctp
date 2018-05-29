		<?php  if(empty($type) && empty($this->request->params['isAjax'])) { ?>
		<section class="top-smspace sep-bot ">
			<div class="container clearfix bot-space">
				<h2 class="text-32 pull-left "><?php echo  __l('Activities');?></h2>
			</div>
			</section>
		<?php } ?>
<div class="user_activities js-response <?php  if(empty($type) || empty($this->request->params['isAjax'])) { ?> container <?php } ?>">
	<section class="row ver-space  ver-smspace <?php  if(empty($type) || empty($this->request->params['isAjax'])) { ?>span24  <?php } else { ?> span16 <?php } ?>">	
			<?php if(!empty($messages)) :
				$i = 0; ?>
				<ol class="unstyled activities-list">
				<?php	foreach($messages as $message) : 
					$class = null;
					if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
					}
					?>
					<li class="clearfix ver-space">
						<div class="span4 ver-smspace dr mob-dc text-14 date-info grayc"><?php echo $this->Time->timeAgoInWords($message['Message']['created']);?></div>
						<div class="pull-right mob-clr mob-dc sep pr activity-content  right-mspace">
							<div class="<?php  if(empty($type) || empty($this->request->params['isAjax'])) { ?>span18 <?php } else { ?> span10 <?php } ?> span18-sm no-mar right-arrow">
								<p class="space no-mar"><?php echo $this->Html->cText($message['MessageContent']['subject'].' for');?>
								<?php echo ' '.$this->Html->link($this->Html->cText($message['Job']['title'],false), array('controller'=> 'jobs', 'action' => 'view', $message['Job']['slug']), array('title'=>$this->Html->cText($message['Job']['title'],false), 'escape' => false));?></p>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
				</ol>
			<div class="pull-right">
			<?php
				if ((!empty($messages)&& empty($type)) || empty($this->request->params['isAjax'])) : ?>
				<div class="pull-right"> <?php echo $this->element('paging_links'); ?></div><?php
				endif;
				?>
			</div>
		<?php else: ?>
			<ol class="left-space unstyled <?php echo (empty($type) || empty($this->request->params['isAjax']))?'span23':'span15';?>">
				<li><div class="thumbnail space dc grayc">
				<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('News Feed'));?></p>
				</div></li>
			</ol>
		<?php endif;?>
		<?php if(!empty($type) && !empty($messages)) { ?>
		<section>
		  <div class="pull-left top-space mspace">
		   <?php echo $this->Html->link(__l('See all notifications'), array('controller' => 'messages', 'action' => 'notification'), array( 'title' => __l('See all notifications'),'class'=>'mspace'));  ?>
		  </div>
		  <div class="pull-right">
			<?php echo $this->Html->link(__l('Clear notification'), array('controller' => 'messages', 'action' => 'clear_notifications', 'final_id' => $final_id['Message']['id'], 'admin' => false), array('class' => 'mspace js-no-pjax btn','escape' => false));?>
		  </div>
		</section>
		<?php } ?>
	</section>
</div>
