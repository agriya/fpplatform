<div class="top-seller">
	<ol class="list">
		<?php
		if (!empty($users)):
		$i = 0;
		foreach ($users as $user):
			//pr($user);
			if(empty($user['User']['positive_feedback_count'])) {
				break;
			}
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
        
          <?php if(Configure::read('job.rating_type') == 'percentage'):?>
		  <li class="clearfix">
          			<p><span><?php echo $this->Html->link($this->Html->cText($user['User']['username']), array('controller'=> 'users', 'action' => 'view', $user['User']['username']), array('title' => $this->Html->cText($user['User']['username'],false),'escape' => false));?></span></p>
					<dl class="ratings-feedback clearfix">
						<dt class="rating" title = "<?php echo __l('Positive Rating'); ?>"><?php echo __l('Positive Rating:');?></dt>
    					<dd title = "<?php echo $this->Html->displayPercentageRating($user['User']['job_feedback_count'], $user['User']['positive_feedback_count']);?>" class="positive-feedback">
    						<?php echo $this->Html->displayPercentageRating($user['User']['job_feedback_count'], $user['User']['positive_feedback_count']); ?>
    					</dd>
    				</dl>
			</li>
    		<?php else:?>
            <li class="clearfix">
				<p><span><?php echo $this->Html->link($this->Html->cText($user['User']['username']), array('controller'=> 'users', 'action' => 'view', $user['User']['username']), array('title' => $this->Html->cText($user['User']['username'],false),'escape' => false));?></span></p>
				<dl class="ratings-feedback clearfix">
					<dt class="positive-feedback" title ="<?php echo __l('Positive Rating');?>"><?php echo __l('Positive Rating:');?></dt>
					<dd title = "<?php echo $user['User']['positive_feedback_count'];?>"><?php echo $user['User']['positive_feedback_count'];?></dd>
					<dt class="negative-feedback" title ="<?php echo __l('Negative Rating');?>"><?php echo __l('Negative Rating:');?></dt>
					<dd title = "<?php echo $user['User']['job_feedback_count'] - $user['User']['positive_feedback_count']; ?>" >
					<?php echo $user['User']['job_feedback_count'] - $user['User']['positive_feedback_count'];?></dd>
				</dl>	
			</li>
            <?php endif;?>
		<?php
			endforeach;
		else:
		?>
			<li>
				<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No top seller available');?></p></div>
			</li>
			<?php
		endif;
		?>
	</ol>
</div>