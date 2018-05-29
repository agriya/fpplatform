<?php /* SVN: $Id: admin_index.ctp 4904 2010-05-13 09:31:09Z josephine_065at09 $ */ ?>
<div class="userOpenids index js-response">
    <h2><?php echo __l('User Openids');?></h2>
    <?php echo $this->Form->create('UserOpenid' , array('type' => 'get', 'class' => 'normal form-horizontal ','action' => 'index')); ?>
	<div class="filter-section">
		<div>
			<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
		</div>
		<div class="submit-block clearfix">
			<?php echo $this->Form->submit(__l('Search'));?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
    <?php echo $this->element('paging_counter');?> 
	<?php echo $this->Form->create('UserOpenid' , array('class' => 'normal form-horizontal ','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->params['url']['url'])); ?>
   <div class="overflow-block">
    <table class="table table-striped table-hover sep">
        <tr>
            <th><?php echo __l('Select'); ?></th>
            <th class="actions"><?php echo __l('Actions');?></th>
            <th><?php echo $this->Paginator->sort('User.username', __l('Username'));?></th>
            <th><?php echo $this->Paginator->sort('UserOpenid.openid', __l('OpenID'));?></th>
        </tr>
        <?php
        if (!empty($userOpenids)):
            $i = 0;
            foreach ($userOpenids as $userOpenid):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>                  
					<td><?php echo $this->Form->input('UserOpenid.'.$userOpenid['UserOpenid']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userOpenid['UserOpenid']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
				    <td class="actions">	<span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userOpenid['UserOpenid']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
                    <td class="dl"><?php echo $this->Html->link($this->Html->cText($userOpenid['User']['username'],false), array('controller'=> 'users', 'action'=>'view', $userOpenid['User']['username'], 'admin' => false), array('escape' => false));?></td>
                    <td class="dl"><?php echo $this->Html->cText($userOpenid['UserOpenid']['openid']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="4" class="notice"><?php echo __l('No User Openids available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
    </div>
    <?php
    if (!empty($userOpenids)) :
        ?>
        <div class="admin-select-block">
        <div>
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all')); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none')); ?>
        </div>
   
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
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