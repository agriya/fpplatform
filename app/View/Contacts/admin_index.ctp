<?php /* SVN: $Id: $ */ ?>
<div class="contacts index js-response">
<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo __l('Contacts'); ?></li>
</ul>
<div class="clearfix top-space top-mspace sep-top">
<?php echo $this->element('paging_counter');?>
</div>
<div class="overflow-block">
   <?php
            echo $this->Form->create('Contact', array('action' => 'update','class'=>'normal')); ?>
            <?php $url=(!empty($this->request->params['url']['url'])?$this->request->params['url']['url']:'');
				echo $this->Form->input('r', array('type' => 'hidden', 'value' => $url)); ?>

<table class="table table-striped table-hover sep">
    <tr>
      <th class="actions"><?php echo __l('Select');?></th>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort('created', __l('Created'));?></th>
        <th><?php echo $this->Paginator->sort('user_id', __l('User'));?></th>
        <th><?php echo $this->Paginator->sort('first_name', __l('First Name'));?></th>
        <th><?php echo $this->Paginator->sort('email', __l('Email'));?></th>
        <th><?php echo $this->Paginator->sort('subject', __l('Subject'));?></th>
        <th><?php echo $this->Paginator->sort('message', __l('Message'));?></th>
        <th><?php echo $this->Paginator->sort('telephone', __l('Telephone'));?></th>
        <th><?php echo $this->Paginator->sort('ip', __l('IP'));?></th>
    </tr>
<?php
if (!empty($contacts)):
$i = 0;
foreach ($contacts as $contact):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
    <td><?php
         echo $this->Form->input('Contact.'.$contact['Contact']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$contact['Contact']['id'],'label' => false , 'class' => 'js-checkbox-list'));
       ?></td>
		<td class="actions"><span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $contact['Contact']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
		<span><?php echo $this->Html->link(__l('Reply'), array('controller' => 'users','action' => 'send_mail', 'contact' => $contact['Contact']['id']), array('class' => 'reply js-reply', 'title' => __l('Reply')));?></span>
        </td>
        <td><?php echo $this->Html->cDateTimeHighlight($contact['Contact']['created']);?></td>
		<td><?php echo $this->Html->link($this->Html->cText($contact['User']['username']), array('controller'=> 'users', 'action' => 'view', $contact['User']['username'], 'admin' => false), array('escape' => false)); ?></td>
		<td><?php echo $this->Html->cText($contact['Contact']['first_name']);?></td>
		<td><?php echo $this->Html->cText($contact['Contact']['email']);?></td>
		<td>
		<?php
			if(!empty($contact['Contact']['subject'])):
				echo $this->Html->cText($contact['Contact']['subject']);
			else:
				echo $this->Html->cText($contact['ContactType']['name']);
			endif;
		?>
		</td>
		<td><?php echo $this->Html->truncate($contact['Contact']['message']);?></td>
		<td><?php echo !empty($contact['Contact']['telephone']) ? $this->Html->cText($contact['Contact']['telephone']) : '';?></td>
		<td>
					<?php echo $this->Html->cText($contact['Contact']['ip']);?>
                    <?php echo $this->Html->link(__l('whois'), array('controller' => 'users', 'action' => 'whois', $contact['Contact']['ip'], 'admin' => false), array('target' => '_blank', 'title' => __l('whois'), 'escape' => false));?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="12" class="notice"><?php echo __l('No Contacts available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
  <?php
         if (!empty($contacts)) :
        ?>
        <div class="admin-select-block">
        <div>
            <?php echo __l('Select').':'; ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
			  </div>
        
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => '--'.__l('More actions').'--')); ?>
        </div>
        </div>
        <div class="pull-right">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit('Submit');  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>