<?php /* SVN: $Id: index.ctp 4216 2010-04-21 12:14:26Z siva_063at09 $ */ ?>
<div class="userMessagePreferences index">
<h2><?php echo __l('User Message Preferences');?></h2>
<?php echo $this->element('paging_counter');?>
<table class="table table-striped table-hover sep">
    <tr>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort('id');?></th>
        <th><?php echo $this->Paginator->sort('created');?></th>
        <th><?php echo $this->Paginator->sort('modified');?></th>
        <th><?php echo $this->Paginator->sort('user_id');?></th>
        <th><?php echo $this->Paginator->sort('is_allow_send');?></th>
    </tr>
<?php
if (!empty($userMessagePreferences)):

$i = 0;
foreach ($userMessagePreferences as $userMessagePreference):
	$class = null;
	if ($i++ % 2 == 0) :
		$class = ' class="altrow"';
    endif;
?>
	<tr<?php echo $class;?>>
		<td class="actions"><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $userMessagePreference['UserMessagePreference']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userMessagePreference['UserMessagePreference']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
		<td><?php echo $this->Html->cInt($userMessagePreference['UserMessagePreference']['id']);?></td>
		<td><?php echo $this->Html->cDateTime($userMessagePreference['UserMessagePreference']['created']);?></td>
		<td><?php echo $this->Html->cDateTime($userMessagePreference['UserMessagePreference']['modified']);?></td>
		<td><?php echo $this->Html->link($this->Html->cText($userMessagePreference['User']['username']), array('controller'=> 'users', 'action'=>'view', $userMessagePreference['User']['username']), array('escape' => false));?></td>
		<td><?php echo $this->Html->cInt($userMessagePreference['UserMessagePreference']['is_allow_send']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="6"><div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No User Message Preferences available');?></p></div></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($userMessagePreferences)) :
    echo $this->element('paging_links');
endif;
?>
</div>
