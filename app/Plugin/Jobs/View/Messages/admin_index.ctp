<div class="hor-space js-response js-responses">
	<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc">User Messages</li>
	</ul>
	<div class="tabbable ver-space sep-top top-mspace">
      <div id="list" class="tab-pane active in no-mar">
		<div class="clearfix top-space top-mspace">
		  <div class="pull-right span users-form tab-clr">
		  	<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('Message', array('type' => 'post', 'class' => 'normal form-search no-mar ', 'action'=>'index')); 
				  echo $this->Form->autocomplete('Message.username', array('label' => false, 'placeholder' => __l('From'), 'div' => 'input text ver-smspace', 'acFieldKey' => 'Message.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
				  echo $this->Form->autocomplete('Message.other_username', array('label' => false, 'class' => 'left-smspace', 'placeholder' =>  __l('To'), 'div' => 'input text ver-smspace', 'acFieldKey' => 'Message.other_user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
				  echo $this->Form->autocomplete('Job.title', array('label' => false, 'class' => 'left-smspace', 'placeholder' => jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps), 'div' => 'input text ver-smspace', 'acFieldKey' => 'Job.id', 'acFields' => array('Job.title'), 'acSearchFieldNames' => array('Job.title'), 'maxlength' => '255'));
				  echo $this->Form->input('JobOrder.Id', array('label' => false, 'class' => 'left-smspace', 'placeholder' => __l('Order#'), 'div' => 'input text ver-smspace'));?>
				<div class="submit left-smspace">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
		  </div>
		  <?php echo $this->element('paging_counter'); ?>
		</div>
<?php   echo $this->Form->create('Message' , array('class' => 'normal ','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="tab-pane active in no-mar" id="active-users">
  <div class="sep bot-mspace img-rounded clearfix">
    <table class="table no-mar table-striped table-hover">
  	  <thead>
	  <tr class="no-mar no-pad">
		<th class="dc sep-right textn span1"><?php echo __l('Select');?></th>
        <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
	<th class="sep-right textn"><?php echo __l('Subject'); ?></th>
	<th class="sep-right textn"><?php echo jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps); ?></th>	
	<th class="dc sep-right textn"><?php echo __l('Order'); ?></th>	
	<th class="sep-right textn"><?php echo __l('From'); ?></th>
	<th class="sep-right textn"><?php echo __l('To'); ?></th>
	<th class="dc sep-right textn"><?php echo __l('Date'); ?></th>
</tr>
 </thead>
    <tbody>
<?php
if (!empty($messages)) :
$i = 0;
foreach($messages as $message):
   // if empty subject, showing with (no suject) as subject as like in gmail
    if (!$message['MessageContent']['subject']) :
		$message['MessageContent']['subject'] = '(no subject)';
    endif;
	
	$message_class = "checkbox-message ";
	
	$is_read_class = "";
	
    if ($message['Message']['is_read']) :
        $message_class .= "js-checkbox-active";
    else :
        $message_class .= "js-checkbox-inactive";
        $is_read_class .= "unread-message-bold";
        $row_class=$row_class.' unread-row';
    endif;
	
	$row_three_class='w-three';
	 if (!empty($message['MessageContent']['Attachment'])):
			$row_three_class.=' has-attachment';
	endif;
	if($message['MessageContent']['is_system_flagged']):
		$message_class.= ' js-checkbox-flagged';
	else:
		$message_class.= ' js-checkbox-unflagged';
	endif;
	if($message['User']['is_active']):
		$message_class.= ' js-checkbox-activeusers';
	else:
		$message_class.= ' js-checkbox-deactiveusers';
	endif;
	
		$view_url=array('controller' => 'messages','action' => 'view',$message['Message']['hash'], 'admin' => false);
?>
    <tr>

		<td class="dc grayc">
				<?php echo $this->Form->input('Message.'.$message['Message']['id'], array('type' => 'checkbox', 'id' => 'admin_checkbox_'.$message['Message']['id'], 'label' => '', 'div' => false,  'class' => $message_class.' js-checkbox-list'));?>
		</td>
		
		<td class="dc grayc">
		<div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
						<ul class="dropdown-menu arrow dl">
						<li><?php 
				if($message['MessageContent']['is_system_flagged']):
					echo $this->Html->link('<i class="icon-flag"></i>' . __l('Clear flag'), array('action' => 'admin_update_status', $message['MessageContent']['id'], 'flag' => 'deactivate'), array('class' => 'js-confirm clear-flag', 'title' => __l('Clear flag'), 'escape' => false));
				else:
					echo $this->Html->link('<i class="icon-flag"></i>' . __l('Flag'), array('action' => 'admin_update_status', $message['MessageContent']['id'], 'flag' => 'active'), array('class' => 'js-confirm flag', 'title' => __l('Flag'), 'escape' => false));
				endif;?>
				</li>
				<?php if($message['User']['role_id'] != ConstUserTypes::Admin):
					if($message['User']['is_active']):
						echo '<li>'.$this->Html->link('<i class="icon-minus-sign"></i>' . __l('Deactivate sender'), array('controller' => 'users', 'action' => 'admin_update_status', $message['User']['id'], 'status' => 'deactivate'), array('class' => 'js-confirm deactive-user', 'title' => __l('Deactivate sender'), 'escape' => false)).'</li>';
					else:
						echo '<li>'.$this->Html->link('<i class="icon-add-sign"></i>' . __l('Activate sender'), array('controller' => 'users', 'action' => 'admin_update_status', $message['User']['id'], 'status' => 'activate'), array('class' => 'js-confirm active-user', 'title' => __l('Activate sender'), 'escape' => false)).'</li>';
					endif;			
				endif;
			?>
						</ul>
			          </div>
		</td>
		
        <td  class="dl">   
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
					<?php
                endif;
			?>
			<?php 
				echo $this->Html->link($message['MessageContent']['subject'] ,$view_url, array('class' => 'grayc js-no-pjax htruncate span7 js-bootstrap-tooltip', 'title' => $message['MessageContent']['subject']));?>
			<?php
				if($message['MessageContent']['is_system_flagged']):
				  echo '<div class="hor-space"><span class="label label-warning" title="' . __l('System Flagged') . '">' . __l('Flagged') . '</span></div>';
				endif;

				?>
        </td>
		
		<td class="dl grayc">
			<?php
				if(!empty($message['Job']['title'])):
					echo $this->Html->link($this->Html->cText($this->Html->truncate($message['Job']['title'])), array('controller' => 'jobs', 'action' => 'view', $message['Job']['slug'], 'admin' => false), array('title' => $message['Job']['title'], 'escape' => false, 'class' => 'grayc js-bootstrap-tooltip span5 htruncate'));
				else:
					echo '-';
				endif;
			?>
		</td>	
		
		<td class="dc grayc">
			<?php
				if(!empty($message['JobOrder']['id'])):
					echo '#'.$this->Html->cText($message['JobOrder']['id'], false);
				else:
					echo '-';
				endif;
			?>
		</td>		
		
        <td  class="dl grayc <?php  echo $is_read_class;?>">
				<span class="user-name-block c1">
					<?php echo $this->Html->link($this->Html->cText($message['User']['username']), array('controller' => 'users', 'action' => 'view', $message['User']['username'], 'admin' => false), array('title' => $message['User']['username'], 'escape' => false, 'class' => 'grayc'));?>
				</span>
                <div class="clear"></div>
            </td>
            <td  class="dl grayc <?php  echo $is_read_class;?>">
				<span class="user-name-block c1">
					<?php echo $this->Html->link($this->Html->cText($message['OtherUser']['username']), array('controller' => 'users', 'action' => 'view', $message['OtherUser']['username'], 'admin' => false), array('title' => $message['OtherUser']['username'], 'escape' => false, 'class' => 'grayc'));?>
				</span>
                <div class="clear"></div>
            </td>

        <td class="dc grayc <?php echo $is_read_class;?>"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']);?></td>
    </tr>
<?php
    endforeach;
else :
?>
<tr>
    <td colspan="8" class="grayc notice text-16 dc"><?php echo __l('No messages available') ?></td>
</tr>
<?php
endif;
?>
 </tbody>
    </table>
</div>
</div>
    <?php
    if (!empty($messages)) :
        ?>
        <div class="ver-mspace mob-dc clearfix">
    <div class="top-space pull-left dc mob-clr mob-inline clearfix">
       <div class="pull-left ver-space">
         <?php echo __l('Select:'); ?>
         	<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Flagged'), '#', array('class' => 'js-select js-no-pjax  {"checked":"js-checkbox-flagged","unchecked":"js-checkbox-unflagged"} hor-smspace grayc', 'title' => __l('Flagged'))); ?>
			<?php echo $this->Html->link(__l('Unflagged'), '#', array('class' => 'js-select js-no-pjax  {"checked":"js-checkbox-unflagged","unchecked":"js-checkbox-flagged"} hor-smspace grayc', 'title' => __l('Unflagged'))); ?>
			<?php echo $this->Html->link(__l('Active users'), '#', array('class' => 'js-select js-no-pjax  {"checked":"js-checkbox-activeusers","unchecked":"js-checkbox-deactiveusers"} hor-smspace grayc', 'title' => __l('Active users'))); ?>
			<?php echo $this->Html->link(__l('Inactive users'), '#', array('class' => 'js-select js-no-pjax  {"checked":"js-checkbox-deactiveusers","unchecked":"js-checkbox-activeusers"} hor-smspace grayc', 'title' => __l('Inactive users'))); ?>

        </div>
        <div class="pull-left hor-mspace mob-no-mar">
                <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit span4', 'label' => false,  'empty' => __l('-- More actions --'))); ?>
        </div>
      </div>
      <div class="pull-right top-space">
         <?php echo $this->element('paging_links'); ?>
      </div>
	  <div class="hide">
        <?php echo $this->Form->submit('Submit');  ?>
      </div>
	  </div>
<?php endif;
echo $this->Form->end();
?>
</div>
</div>
</div>