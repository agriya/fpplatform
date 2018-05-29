<?php /* SVN: $Id: view.ctp 4960 2010-05-15 12:02:46Z aravindan_111act10 $ */ ?>
<div class="messages view message-view-block container">
<?php if(empty($is_view)) {?>
<h2  class="container text-32 bot-space mob-dc">
		<?php echo __l('Messages');?>
</h2>

<section class="container clearfix">

<?php echo $this->element('message_message-left_sidebar'); ?>
<?php echo $this->Form->create('Message', array('action' => 'move_to', 'class' => 'normal form-horizontal ')); ?>

<?php
$refresh_folder_type = $folder_type;

if ($folder_type == 'draft') $refresh_folder_type = 'drafts';
if ($folder_type == 'sent') $refresh_folder_type = 'sentmail';
echo $this->Form->hidden('folder_type', array('value' => $folder_type, 'name' => 'data[Message][folder_type]'));
echo $this->Form->hidden('is_starred', array('value' => $is_starred, 'name' => 'data[Message][is_starred]'));
echo $this->Form->hidden('label_slug', array('value' => $label_slug, 'name' => 'data[Message][label_slug]'));

}
?>
<div class="main-content-block js-corner round-5">
<div class="mail-side-two">
	<?php
        echo $this->Form->create('Message', array('action' => 'move_to','class' => 'normal form-horizontal '));
        echo $this->Form->hidden('folder_type', array('value' => $folder_type,'name' => 'data[Message][folder_type]'));
        echo $this->Form->hidden('is_starred', array('value' => $is_starred,'name' => 'data[Message][is_starred]'));
        echo $this->Form->hidden('label_slug', array('value' => $label_slug,'name' => 'data[Message][label_slug]'));
        echo $this->Form->hidden("Message.Id." . $message['Message']['id'], array('value' => '1'));
    ?>
   <div class="high-light-block">
	<?php
		if($this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin)):
			$bad_words = unserialize($message['MessageContent']['detected_suspicious_words']);
			if(!empty($bad_words)):
			echo '<h3>'.__l('System Flag Words: ').'</h3>';
				echo '<ul>';
				foreach($bad_words as $bad_word){
					echo '<li>'.$bad_word.'</li>';
				}
				echo '</ul>';
			endif;
		endif;
	?>
	</div>
    <div class="mail-main-curve sep space mspace clearfix">
   
	<div class="inbox-block clearfix pull-right">
	 <p class="user-status-info user-status-information">
    	<?php
			if($this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin)):
				if($message['MessageContent']['is_system_flagged']):
					echo $this->Html->link(__l('Clear flag'), array('action' => 'update_status', $message['MessageContent']['id'], 'flag' => 'deactivate', 'admin' => true), array('class' => 'clear-flag js-admin-update-job', 'title' => __l('Clear flag')));
				else:
					echo $this->Html->link(__l('Flag'), array('action' => 'update_status', $message['MessageContent']['id'], 'flag' => 'active', 'admin' => true), array('class' => 'flag js-admin-update-job', 'title' => __l('Flag')));
				endif;
				if($message['User']['role_id'] != ConstUserTypes::Admin):
					if($message['User']['is_active']):
						echo $this->Html->link(__l('Deactivate sender'), array('controller' => 'users', 'action' => 'update_status', $message['User']['id'], 'status' => 'deactivate', 'admin' => true), array('class' => 'deactive-user js-admin-update-job', 'title' => __l('Deactivate user')));
					else:
						echo $this->Html->link(__l('Activate sender'), array('controller' => 'users', 'action' => 'update_status', $message['User']['id'], 'status' => 'activate', 'admin' => true), array('class' => 'active-user js-admin-update-job', 'title' => __l('Activate user')));
					endif;
				endif;
			endif;				
		?>
    </p>
			<div class="pull-right no-mar clearfix">
		
			
				
    			<?php
                 //   echo $this->Form->submit(__l('Archive'), array('name' => 'data[Message][Archive]'));
                 //  echo $this->Form->submit(__l('Spam'), array('name' => 'data[Message][ReportSpam]'));
                    echo $this->Form->submit(__l('Delete'), array('class' => 'js-alert-message btn btn-success','name' => 'data[Message][Delete]','div'=>'submit no-mar pull-left'));

                ?>
                
				<?php if(ConstUserTypes::Admin != $message['OtherUser']['role_id'] && empty($message['Message']['is_sender'])): ?>
					<div class="cancel-block span top-space">
					<?php
						echo $this->Html->link(__l('Reply') , array('controller' => 'messages', 'action' => 'compose', $message['Message']['hash'],'reply') , null, null, false);
					?>
					</div>
				<?php endif;?>
			</div>
        </div>
              <div class="mail-body js-corner mail-content-curve-middle  span17">

                    <div class="clearfix">
                    <div class="mail-sender-name">
                <p class="clearfix">
				<?php if (($message['Message']['is_sender'] == 1) || ($message['Message']['is_sender'] == 2)) : ?>
                   <span class="sender-name"> 
					<?php echo __l('From').': ';  ?>		
						<?php
							if(ConstUserTypes::Admin == $message['OtherUser']['role_id']): 
								echo $this->Html->cText($this->Html->truncate($message['User']['username'])); 
							else:
								echo $this->Html->link($this->Html->cText($message['User']['username']), array('controller'=> 'users', 'action' => 'view', $message['User']['username']), array('title' => $this->Html->cText($message['User']['username'],false),'escape' => false));
							endif;
						?>
					</span>
   					<?php
                        else :
                    ?>
                    <span class="sender-name">
					<span class="message-title"><?php echo __l('From').': ';  ?></span>
						<?php 
							if(ConstUserTypes::Admin == $message['OtherUser']['role_id']): 
								echo $this->Html->cText($this->Html->truncate($message['OtherUser']['username'])); 
							else:
								echo $this->Html->link($this->Html->cText($message['OtherUser']['username']), array('controller'=> 'users', 'action' => 'view', $message['OtherUser']['username']), array('title' => $this->Html->cText($message['OtherUser']['username'],false),'escape' => false));
							endif;
						?>
					</span>
					<?php endif; ?>
					</p>
				</div>
                <div class="mail-date-time">
                    <p class="<?php echo $message['Message']['id'] ?> clearfix">
						<span class="js-show-mail-detail-span message-title no-mar">
							<?php echo __l('Date: '); ?>
						</span>
							<?php echo $this->Html->cDateTimeHighlight($message['Message']['created']); ?> (<?php echo $this->Time->timeAgoInWords($message['Message']['created']); ?>)
					</p>
                </div>
                </div>

                <div class="mail-content-curve-middle clearfix">
			   <div class="js-show-mail-detail-div" style="display:none;">
				<?php
                    if ($message['Message']['is_sender'] == 0) : ?>
                    	<p  class="clearfix" ><span class="show-details-left message-title"><?php echo __l('from').': ';  ?></span> <?php echo __l($message['OtherUser']['username']); ?> < <?php echo $message['OtherUser']['email']; ?> ></p>
                    <?php
                    else : ?>
                    	<p  class="clearfix"><span class="show-details-left message-title"><?php echo __l('from').': ';  ?></span> <?php echo __l($message['User']['username']); ?> < <?php echo $message['User']['email']; ?> ></p>
        			<?php
                    endif; ?>
    				<p  class="clearfix"><span class="show-details-left message-title"><?php echo __l('to').': ';  ?></span><?php echo __l($show_detail_to); ?></p>
					<p  class="clearfix"><span class="show-details-left message-title"><?php echo __l('date').': ';  ?></span><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']); echo __l('at') . $this->Html->cDateTimeHighlight($message['Message']['created']); ?> </p>
				</div>
				<?php if(!empty($job['name'])):?>
               	<p  class="clearfix">
					<span class="show-details-left message-title">
						<?php echo jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps).': ';  ?>
					</span>
						<?php echo $this->Html->link($this->Html->cText($job['name']), array('controller' => 'jobs', 'action' => 'view', $job['slug']), array('title' => $this->Html->cText($job['name'],false),'escape' => false));?>
				</p>
				<?php endif;?>
                <?php if(!empty($message['Message']['job_order_id'])):?>
              	<p  class="clearfix sep-bot"><span class="show-details-left message-title"><?php echo __l('Order').': ';  ?></span>
                   	<?php echo $this->Html->cText($message['Message']['job_order_id']); ?>
     			</p>
                <?php endif;?>
				<?php if(!empty($review_url)): ?>
					<p>
						<?php echo "<a href = ".$review_url.">".__l('Click here to review your order')."</a>";?>
					</p>
				<?php endif;?>
				<p class="subject-info textb clearfix"><span class="show-details-left message-title"><?php echo __l('Subject').': ';  ?></span>
					<?php
						if($this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin) && !empty($message['MessageContent']['is_system_flagged'])):
							echo $this->Html->filterSuspiciousWords($this->Html->cText($message['MessageContent']['subject']), $message['MessageContent']['detected_suspicious_words']); 
						else:
							echo $this->Html->cText($message['MessageContent']['subject']); 						
						endif;
					?>
				</p>
				<div class="message-description">
					<?php 
						if($this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin) && !empty($message['MessageContent']['is_system_flagged'])):
							echo $this->Html->filterSuspiciousWords($this->Html->cHtml($message['MessageContent']['message']), $message['MessageContent']['detected_suspicious_words']); 
						else:				
							echo nl2br($this->Html->cHtml($message['MessageContent']['message'])); 
						endif;
					?>
				</div>
				<p class="replay-forward-links clearfix">
				<?php
                 //   echo $this->Html->link(__l("Reply") , array('controller' => 'messages','action' => 'compose',$message['Message']['hash'],'reply') , null, null, false);
                //    echo $this->Html->link(__l("Forward") , array('controller' => 'messages', 'action' => 'compose', $message['Message']['hash'],'forword') , null, null);
                ?>
				</p>
                <div class="download-block">
				<?php
					if(!empty($message['JobOrder']['job_order_status_id']) && $message['JobOrder']['job_order_status_id'] == ConstJobOrderStatus::WaitingforAcceptance && $message['Job']['user_id'] == $message['Message']['user_id']):
						if (!empty($message['JobOrder']['Attachment'])) :?>
							<?php echo '<p>'.__l('Attachment from buyer').':</p>';?>
							<span><?php echo $this->Html->link($message['JobOrder']['Attachment'][0]['filename'], array('controller' => 'job_orders', 'action' => 'download', $message['JobOrder']['Attachment'][0]['id']), array('class'=>'js-no-pjax','title' => __l('Click to download this file').': '.$message['JobOrder']['Attachment'][0]['filename'] )); ?></span>
						<?php endif;?>
						<?php if (!empty($message['JobOrder']['information_from_buyer'])) :?>
							<?php echo '<p>'.__l('Information from buyer').':</p>';?>
							<?php echo '<p>'.$message['JobOrder']['information_from_buyer'].'</p>';?>
						<?php endif;?>
						<?php
					endif;
				?>
                <?php
                if (!empty($message['MessageContent']['Attachment'])) :
					?>
					<h4><?php echo count($message['MessageContent']['Attachment']).' '. __l('attachment(s)');?></h4>
					<ul>
					<?php
                    foreach($message['MessageContent']['Attachment'] as $attachment) :
                ?>
					<li>
                	<span class="attachement"><?php echo $attachment['filename']; ?></span>
                	<span><?php echo bytes_to_higher($attachment['filesize']); ?></span>
                    <span><?php echo $this->Html->link(__l('Download') , array( 'action' => 'download', $message['Message']['hash'], $attachment['id']),array('class'=>'js-no-pjax')); ?></span>
					</li>
                <?php
                    endforeach;
				?>
				</ul>
				<?php
                endif;
                ?>
                </div>
            </div>
       </div>
        <div class="message-block clearfix">
        <div class="message-block-left" >
			<?php
            //echo $this->Form->input('more_action_2', array('type' => 'select','options' => $mail_options,'label' => false,'class' => 'js-apply-message-action2' ));
            ?>
			</div>

        <div class="message-block-right">
        <?php
         //   echo $this->Form->submit(__l('Archive'), array('name' => 'data[Message][Archive]'));
          //  echo $this->Form->submit(__l('Spam'), array( 'name' => 'data[Message][ReportSpam]'));
          //  echo $this->Form->submit(__l('Delete'), array('name' => 'data[Message][Delete]'));
        ?>
        </div>
        </div>
	          
     </div>
	<?php echo $this->Form->end();
?>
</div>
</div>
</div>