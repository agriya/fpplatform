<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php if(!empty($this->request['named']['view_style']) && $this->request['named']['view_style'] == 'simple-view'){?>
<div class="pull-right right-space clearfix ">
	<ul class="unstyled ver-space top-smspace medium-thumb mob-clr clearfix tab-clr">
	<?php 
		$i = 0;
		if (!empty($jobFeedbacks)){
			foreach ($jobFeedbacks as $jobFeedback): 
				if($i <= 3) { 
				$i++; ?>
				<li class="pull-left user-thumb">
				<?php echo $this->Html->link($this->Html->showImage('UserAvatar', $jobFeedback['User']['UserAvatar'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($jobFeedback['User']['username'], false)), 'title' => $this->Html->cText($jobFeedback['User']['username'], false))), array('controller' => 'users', 'action' => 'view',  $jobFeedback['User']['username'], 'admin' => false), array('escape' => false)); ?>
				</li>
		<?php } ?>
		<?php endforeach; 
			}
			if($i != 3)	{
				for(; $i < 3; $i++) {
					?>
					<li class="pull-left user-thumb">
						<?php echo $this->Html->showImage('UserAvatar', array(), array('dimension' => 'medium_thumb', 'alt' => __l('[Image: User]'), 'title' => '')); ?>
					</li>
					<?php
				}
			}	
		?>
	<li class="pull-left dc">
	<a href="#Feedback" class="ver-space top-smspace whitec show text-11 js-no-pjax" title="<?php echo __l('more');?>"><?php echo __l('more');?></a>
	</li>
	</ul>
</div>
<?php } else { ?>
<div class="jobFeedbacks index job-feedbacks-block container clearfix js-response">
<?php //echo $this->element('paging_counter');?>
<section class="bot-space row no-mar" itemscope itemtype="http://schema.org/Organization">
<ol class="unstyled discussion-list top-space clearfix" itemprop="reviews" itemscope itemtype="http://schema.org/Review" >
<?php
if (!empty($jobFeedbacks)):
$i = 0;
foreach ($jobFeedbacks as $jobFeedback):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow';
	}else{
		$class = ' class="';
	}
	$class.= ($jobFeedback['JobFeedback']['is_satisfied']) ? ' positive-feedback"' : ' negative-feedback"';
?>
                <li class="space sep-bot">
                  <p class="top-space ver-mspace" itemprop="description"><sup class="text-20 right-space right-mspace"><i class="icon-quote-left graylightc"></i></sup><em class="text-16" ><?php echo $this->Html->cText($jobFeedback['JobFeedback']['feedback']);?></em> <sub class="text-20 left-space left-mspace"> 
				  <i class="icon-quote-right graylightc"></i>
				  </sub></p>
                  <div class="clearfix ver-space">
                    <div class="pull-left right-space"><i class="<?php echo ($jobFeedback['JobFeedback']['is_satisfied'])?'icon-thumbs-up-alt':'icon-thumbs-down-alt';?> text-30 grayc"></i></div>
                    <div class="pull-left right-space clearfix"> 
                        <?php echo $this->Html->getUserAvatarLink($jobFeedback['User'], 'small_thumb', true, 'user-thumb','img-rounded');?>					
                    </div>
                    <div class="hor-space clearfix">
                      <p class="pull-left right-space" > <a href="#" title="<?php echo $this->Html->cText($jobFeedback['User']['username'],false); ?>" class="graydarkerc no-under show bot-space" itemprop="author"><?php echo $this->Html->cText($jobFeedback['User']['username'],false); ?></a> <span class="grayc"><?php echo $this->Time->timeAgoInWords($jobFeedback['JobFeedback']['created']); ?></span> </p>
                    </div>
                  </div>
                </li>
<?php
    endforeach;
	else: ?>
		<li class="dc">
			<div class="thumbnail space dc grayc">
				<p class="ver-mspace top-space text-16"><?php echo __l('No Feedbacks available');?></p>
			</div>
		</li>
<?php endif; ?>
</ol>
</section>
	<div class="<?php if(!empty($this->request->params['isAjax'])) { ?> js-pagination <?php } ?>pull-right bot-mspace">
		<?php
		if (!empty($jobFeedbacks)) {
			echo $this->element('paging_links');
		}
		?>
	</div>
</div>
<?php } ?>