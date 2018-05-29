<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>

<div class="userViews index js-response panel-admin">
  <?php if (empty($this->request->params['named']['view_type'])) {?>
  <ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo sprintf(__l('%s Flags'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></li>
	</ul>
  <?php } ?>
  <?php if(empty($this->request->params['named']['view_type'])) : ?>
  <section class="space clearfix">
  <div class="pull-left"><?php echo $this->element('paging_counter');?></div>
    <div class="pull-right users-form tab-clr">
        <div class="pull-left mob-clr mob-dc">
          <?php echo $this->Form->create('JobFlag', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
              <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
            <div class="submit left-space">
              <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
            </div>
          <?php echo $this->Form->end(); ?>
        </div>
    </div>
  </section>
  <?php endif; ?>
  <?php echo $this->Form->create('JobFlag' , array('class' => 'clearfix js-shift-click js-no-pjax','action' => 'update')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <section class="space">
  <table class="table no-mar table-striped table-hover">
    <thead>
    <tr>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
      <th class="select dc"><?php echo __l('Select'); ?></th>
      <?php endif; ?>
      <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
		<th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('Username'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('Job.title', jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('JobFlagCategory.name', __l('Category'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('message', __l('Message'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip', __l('IP'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Posted on'), array('class' => 'graydarkerc no-under'));?></div></th>
    </tr>
    </thead>
    <tbody>
    <?php
      
      if (!empty($jobFlags)):
            $i = 0;
            foreach ($jobFlags as $jobFlag):
          
    ?>
    <tr>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
      <td class="dc grayc"><?php echo $this->Form->input('JobFlag.'.$jobFlag['JobFlag']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$jobFlag['JobFlag']['id'], 'label' => '', 'div' => false, 'class' => 'js-checkbox-list')); ?></td>
      <?php endif; ?>
      <td class="dc grayc">
					<div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
						<ul class="dropdown-menu arrow dl">
						<li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('controller' => 'job_flags', 'action' => 'delete', $jobFlag['JobFlag']['id']), array('class' => 'js-confirm', 'title' => __l('Delete'), 'escape' => false));?></li>
						</ul>
					  </div> 
					</td>
                    <td class="dl grayc">
                        <?php echo $this->Html->getUserAvatar($jobFlag['User'], 'micro_thumb',true, '', 'admin');?>
						<?php echo $this->Html->link($this->Html->cText($jobFlag['User']['username']), array('controller'=> 'users', 'action'=>'view', $jobFlag['User']['username'], 'admin' => false), array('escape' => false, 'class' => 'grayc left-smspace'));?>
                        <span class="label textn top-mspace"><?php echo  $this->Html->link(sprintf(__l('All Job flagged by %s'),$jobFlag['User']['username']), array('controller' => 'job_flags', 'action' => 'index', 'username' => $jobFlag['User']['username']), array('title' => sprintf(__l('Show all jobs flagged by %s '),$jobFlag['User']['username']), 'escape' => false, 'class' => 'grayc'));?></span>
                    </td>
                    <td class="dl grayc">
					<?php if(!empty($jobFlag['Job']['Attachment']['0'])){
						echo $this->Html->link($this->Html->showImage('Job', $jobFlag['Job']['Attachment']['0'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($jobFlag['Job']['title'], false)), 'title' => $this->Html->cText($jobFlag['Job']['title'], false))), array('controller' => 'jobs', 'action' => 'view', $jobFlag['Job']['slug'], 'admin' => false), array('escape' => false, 'class' => 'grayc'));
						}?>
                     <?php echo $this->Html->link($this->Html->cText($jobFlag['Job']['title']), array('controller'=> 'jobs', 'action'=>'view', $jobFlag['Job']['slug'], 'admin' => false), array('escape' => false, 'class' => 'grayc'));?>
                    </td>
                    <td class="dl grayc"><?php echo $this->Html->cText($jobFlag['JobFlagCategory']['name']);?></td>
                    <td class="dl grayc"><?php echo $this->Html->Truncate($jobFlag['JobFlag']['message']);?></td>
                    <td class="dl grayc"><?php if(!empty($jobFlag['Ip']['ip'])): ?>
						<?php echo  $this->Html->link($jobFlag['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $jobFlag['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$jobFlag['Ip']['ip'], 'escape' => false, 'class' => 'grayc')); ?>
					  <p>
					  <?php
					   if(!empty($jobFlag['Ip']['Country'])):
							  ?>
							  <span class="flags flag-<?php echo strtolower($jobFlag['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $jobFlag['Ip']['Country']['name']; ?>">
						<?php echo $jobFlag['Ip']['Country']['name']; ?>
					  </span>
							  <?php
							endif;
					   if(!empty($jobFlag['Ip']['City'])):
							?>
							<span>   <?php echo $jobFlag['Ip']['City']['name']; ?>  </span>
							<?php endif; ?>
							</p>
						  <?php else: ?>
					  <?php echo __l('n/a'); ?>
					<?php endif; ?>
					</td>
                    <td class="dc grayc"><?php echo $this->Html->cDateTimeHighlight($jobFlag['JobFlag']['created']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="9" class="notice text-16 dc grayc"><?php echo __l('No Flags available');?></td>
            </tr>
            <?php
        endif;
        ?>
</tbody>
    </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
  <?php
  if (!empty($jobFlags)) :
    ?>
  <?php if(empty($this->request->params['named']['view_type'])) : ?>
  <div class="ver-space pull-left"> <?php echo __l('Select:'); ?> <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?> </div>
  <div class="admin-checkbox-button pull-left hor-space">
    <div class="input select"> <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?> </div>
  </div>
  <?php endif; ?>
  <div class="hide"> <?php echo $this->Form->submit('Submit');  ?> </div>
  <div class="pull-right"><?php echo $this->element('paging_links'); ?></div>
  </section>
  <?php
endif;
echo $this->Form->end();
?>
</div>