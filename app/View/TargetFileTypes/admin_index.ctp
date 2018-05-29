<?php /* SVN: $Id: admin_index.ctp 4546 2010-05-06 04:47:03Z vinothraja_091at09 $ */ ?>
<div class="targetFileTypes index js-response">
    <h2><?php echo __l('Target File Types');?></h2>
    <div class="add-block">
        <?php echo $this->Html->link(__l('Add'), array('controller' => 'target_file_types', 'action' => 'add'), array('class' => 'add','title' => __l('Add'))); ?>
    </div>
    <?php echo $this->Form->create('TargetFileType', array('type' => 'get', 'class' => 'normal form-horizontal ', 'action'=>'index')); ?>
    <?php echo $this->Form->input('filter_id',array('type'=>'select', 'empty' => __l('Please Select'))); ?>
    <?php echo $this->Form->submit(__l('Search'));?>
    <?php echo $this->Form->end();?>
    <div  class="record-info">
        <div>
            <span><?php echo __l('Approved Records : '); ?></span>
            <?php echo $this->Html->cInt($approved); ?>
        </div>
        <div>
            <span><?php	echo __l('Disapproved Records : '); ?></span>
            <?php echo $this->Html->cInt($pending); ?>
        </div>
        <div>
            <span><?php	echo __l('Total Records : '); ?></span>
            <?php echo $this->Html->cInt($pending + $approved); ?>
        </div>
    </div>
    <?php echo $this->Form->create('TargetFileType' , array('class' => 'normal form-horizontal ','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->params['url']['url'])); ?>
    <?php echo $this->element('paging_counter');?>
    <div class="overflow-block">
    <table class="table table-striped table-hover sep">
        <tr>
            <th><?php echo __l('Select'); ?></th>
            <th class="actions"><?php echo __l('Actions');?></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort('name');?></div></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort('extension');?></div></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Active'), 'is_active');?></div></th>
        </tr>
        <?php
        if (!empty($targetFileTypes)):

            $i = 0;
            foreach ($targetFileTypes as $targetFileType):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                if($targetFileType['TargetFileType']['is_active']):
            		$status_class = 'js-checkbox-active';
            	else:
            		$status_class = 'js-checkbox-inactive';
            	endif;
                ?>
                <tr<?php echo $class;?>>
                    <td><?php echo $this->Form->input('TargetFileType.'.$targetFileType['TargetFileType']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$targetFileType['TargetFileType']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
                    <td class="actions"><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $targetFileType['TargetFileType']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $targetFileType['TargetFileType']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
                    <td><?php echo $this->Html->cText($targetFileType['TargetFileType']['name']);?></td>
                    <td><?php echo $this->Html->cText($targetFileType['TargetFileType']['extension']);?></td>
                    <td><?php echo $this->Html->cBool($targetFileType['TargetFileType']['is_active']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="4" class="notice"><?php echo __l('No Target File Types available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
    </div>
    <?php
    if (!empty($targetFileTypes)) :
        ?>
        <div>
    		<?php echo __l('Select:'); ?>
    		<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
    		<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
    		<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-admin-select-pending','title' => __l('Inactive'))); ?>
    		<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-admin-select-approved','title' => __l('Active'))); ?>
    	</div>
    	<div class="pull-right">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        <div class=hide>
            <?php echo $this->Form->submit('Submit');  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>