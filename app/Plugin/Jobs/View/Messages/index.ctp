<div class="js-response">
<?php //echo $this->element('mail-search');?>
<div class="sep-bot bot-mspace">
<h2  class="container text-32 bot-space mob-dc">
		<?php echo __l('Messages');?>
</h2>
</div>

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

?>

<?php if(!empty($this->request->params['named']['job_order_id'])):?>
<div class="bot-space">
	<?php
		echo __l('Showing only correspondence with order').' #'.$this->request->params['named']['job_order_id'].' - '.$this->Html->link(__l('Show all'), array('controller'=> 'messages', 'action' => 'inbox', 'admin' => false), array('escape' => false));
	?>
</div>
<?php endif; ?>


<ol class="unstyled no-pad nomar <?php echo !empty($messages)?'sep-bot':'' ?>">
      <?php
                    if (!empty($messages)) {
                    $i = 0;
                    foreach($messages as $message){
                       // if empty subject, showing with (no suject) as subject as like in gmail
                        if (!$message['MessageContent']['subject']) :
                    		$message['MessageContent']['subject'] = '(no subject)';
                        endif;
						$current_star="";
                    	if ($i++ % 2 == 0) :
                    		$row_class = 'row';
                    	else :
                    		$row_class = 'altrow';
                        endif;
						          $row_three_class = '';
                    	$message_class = "checkbox-message ";
                    	$is_read_class = "";
                    	
                        if ($message['Message']['is_read']) :
                            $message_class .= " checkbox-read ";
							 $is_read_class .= "com-bg grayc";
                        else :
                            $message_class .= " checkbox-unread ";
                            $row_class=$row_class.' unread-row';
                        endif;

                        if (($message['Message']['user_id'] == $this->Auth->user('id') and (!empty($message['Message']['is_starred_by_user']) and $message['Message']['is_starred_by_user']) ==1) or ($message['Message']['other_user_id'] == $this->Auth->user('id') and (!empty($message['Message']['is_starred_by_user']) and  $message['Message']['is_starred_by_otheruser'] ==1))):
                            $message_class .= " checkbox-starred ";                      
                        else:
                            $message_class .= " checkbox-unstarred ";
                        endif;
                    	$row_class_new='class=" js-show-message js-no-pjax span19 clearfix  {\'message_id\':\''. $message['Message']['id'] .'\',\'is_read\':\''. $message['Message']['is_read'] .'\',\'is_auto\':\''. $message['Message']['is_auto'] .'\'}"';
						$row_class='class=" clearfix ver-space mes-head no-bor cur '.$is_read_class. '"';

						if (!empty($message['MessageContent']['Attachment'])):
							$row_three_class.=' has-attachment';
						endif;
                    	$row_three_class='w-three';
                    	 if (!empty($message['MessageContent']['Attachment'])):
                    			$row_three_class.=' has-attachment';
                    	endif;
                    if ($folder_type == 'draft'):
                    	$view_url=array('controller' => 'messages','action' => 'compose',$message['Message']['id'],'draft');
                    else:
                    	$view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id']);
                    endif;
					$is_starred_class = "star";
					if ($message['Message']['is_starred']):
						$is_starred_class = "";
					endif;
                    ?>
           <li class ="sep-top">
      <section <?php echo $row_class; ?>>
        <div class="span1 over-hide no-mar">
        <?php
          if ($message['Message']['is_starred']) {
            echo $this->Html->link('<i class="icon-star ass text-20 pull-left"></i>', array('controller' => 'messages', 'action' => 'star', $message['Message']['id']) , array('class' => 'cur js-star pr js-no-pjax', 'escape' => false));
          } else {
            echo $this->Html->link('<i class="grayc icon-star-empty text-20 pull-left"></i>', array('controller' => 'messages', 'action' => 'star', $message['Message']['id'],$is_starred_class) , array('class' => 'cur js-star pr js-no-pjax ', 'escape' => false));
          }
          ?>
        <a href="#"><span class="hide">Star</span></a></div>
        <div class="user-name-block c1 span4">
		<?php
		if ($message['Message']['is_sender'] == 1) : ?>
			<span class="pull-left"><?php echo $this->Html->getUserAvatar($message['OtherUser'], 'micro_thumb'); ?></span>
			<span class="pull-left span2 htruncate">
			<span title="<?php echo $this->Html->cText($message['OtherUser']['username'], false); ?>">
			<?php echo  __l('To: ').$this->Html->cText($this->Html->truncate($message['OtherUser']['username']), false); ?>
			</span>
			</span>
		<?php  elseif ($message['Message']['is_sender'] == 2) :
			echo $this->Html->link(__l('Me   : ') , $view_url);
		else: ?>
			<span class="pull-left"><?php echo $this->Html->getUserAvatar($message['OtherUser'], 'micro_thumb'); ?></span>
			<span class="pull-left span2 htruncate">
				<span title="<?php echo $this->Html->cText($message['OtherUser']['username'], false); ?>">
					<?php echo $this->Html->cText($this->Html->truncate($message['OtherUser']['username']), false);?>
			</span>
			</span>
		<?php  endif;
		?>
        </div>
        <div <?php echo $row_class_new; ?>>
        <div class="span6 htruncate">
		 <?php 
		   if (!empty($message['Label'])):
				?>
				<ul class="message-label-list">
					<?php foreach($message['Label'] as $label): ?>
						<li>
							<?php echo $this->Html->cText($this->Html->truncate($label['name']), false);?>
						</li>
					<?php
					endforeach;
				?>
				</ul>
			<?php endif; ?>			 
        <?php
            echo $this->Html->cText($message['MessageContent']['subject'], false);
		?>
        </div>
        <div class="span8 htruncate">
		<span class=""><?php echo $this->Html->cText($message['MessageContent']['message'], false);?></span></div>
        <div class="dr span4 over-hide">
        <?php
        $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created']));
        ?>
        <span class="hor-space js-timestamp" title ="<?php echo $time_format;?>">
         <?php echo $this->Time->timeAgoInWords($message['Message']['created']);?></span></div>
        </div>
      </section>
      <section class="hide js-no-pjax js-message-view<?php echo $message['Message']['id']; ?>">
			<?php echo $this->element('message_message-view',array('hash'=>$message['Message']['hash'],'is_view'=>'1')); ?>
      </section>
      <section class="com-bg">
        <div class="hide js-conversation-<?php echo $message['Message']['id'];?>"></div>
      </section>
      </li>
          <?php
        }
      } else { ?>
        <li>
        <div class="thumbnail space dc grayc">
        <p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('Messages'));?></p>
        <p class="bot-space"><?php echo sprintf(__l('Your %s will appear here'), __l('messages')); ?></p>
        </div>
      </li>
      <?php
      }?>
    </ol>
<div class="refresh-block clearfix bot-space">  
             <div class="clearfix ">                
                <?php
                if (!empty($messages)) : ?>
                   <div class="pull-right"> <?php echo $this->element('paging_links'); ?></div><?php
                endif;
                ?>
            		
            <div class="refersh-block">
            <?php
            if (!empty($label_slug) && $label_slug != 'null') :
                echo $this->Html->link(__l('Refresh') , array('controller' => 'messages',
                        'action' => 'label',
                        $label_slug
                        ),array('class' => 'refresh js-no-pjax', 'title' => __l('Refresh')));
             elseif (!empty($is_starred)) :
                echo $this->Html->link(__l('Refresh') , array('controller' => 'messages',
                        'action' => 'starred'
                        ),array('class' => 'refresh js-no-pjax', 'title' => __l('Refresh')));
             else:
			 if($refresh_folder_type=='inbox' && (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'])) {
				if($this->request->params['named']['type']=='discussion'){ 
					 echo $this->Html->link(__l('Refresh') , array('controller' => 'messages',
                        'action' => 'index', 'type'=>'dicussion'
                        ),array('class' => 'refresh js-no-pjax', 'title' => __l('Refresh')));
				} else if($this->request->params['named']['type'] == 'activities') {
					echo $this->Html->link(__l('Refresh') , array('controller' => 'messages',
                        'action' => 'index', 'type'=>'activities'
                        ),array('class' => 'refresh js-no-pjax', 'title' => __l('Refresh')));

				} else {
					if(!empty($this->request->params['named']['job_order_id'])){
						echo $this->Html->link(__l('Refresh') , array('controller' => 'messages', 'action' => 'index', 'type'=>$refresh_folder_type, 'job_order_id' => $this->request->params['named']['job_order_id']
                        ),array('class' => 'refresh js-no-pjax', 'title' => __l('Refresh')));
					}
					else{
						echo $this->Html->link(__l('Refresh') , array('controller' => 'messages', 'action' => 'index', 'type'=>$refresh_folder_type),array('class' => 'refresh js-no-pjax', 'title' => __l('Refresh')));
					}
				}
			 } else {
                echo $this->Html->link(__l('Refresh') , array('controller' => 'messages',
                        'action' => $refresh_folder_type
                        ),array('class' => 'refresh js-no-pjax', 'title' => __l('Refresh')));
			 }
            endif;
            ?>
</div>
</div>
</div>

<?php echo $this->Form->end();?>
</section>
</div>