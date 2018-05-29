<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>

<div class="userViews index js-response panel-admin">
  <?php if (empty($this->request->params['named']['view_type'])) {?>
  <ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo sprintf(__l('%s Feedbacks'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></li>
	</ul>
  <?php } ?>
  <?php if(empty($this->request->params['named']['view_type'])) : ?>
  <section class="space clearfix">
  <div class="pull-left"><?php echo $this->element('paging_counter');?></div>
    <div class="pull-right users-form tab-clr">
        <div class="pull-left mob-clr mob-dc">
          <?php echo $this->Form->create('JobFeedback', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
              <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
            <div class="submit left-space">
              <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
            </div>
          <?php echo $this->Form->end(); ?>
        </div>
    </div>
  </section>
  <?php endif; ?>
  <?php echo $this->Form->create('JobFeedback' , array('class' => 'clearfix js-shift-click js-no-pjax','action' => 'update')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <section class="space">
  <table class="table no-mar table-striped table-hover">
    <thead>
    <tr>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
      <th class="select dc"><?php echo __l('Select'); ?></th>
      <?php endif; ?>
      <th class="dc sep-right textn"><?php echo __l('Actions');?></th>
        <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Created'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('Job.title', jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('User'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('feedback', __l('Feedback'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip', __l('IP'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('is_satisfied', __l('Satisfied?'), array('class' => 'graydarkerc no-under')); ?></div></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($jobFeedbacks)):

    $i = 0;
    foreach ($jobFeedbacks as $jobFeedback):
        if($jobFeedback['JobFeedback']['is_satisfied']):
            $status_class = 'js-checkbox-active';
        else:
            $status_class = 'js-checkbox-inactive';
        endif;
    ?>
    <tr>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
     <td class="dc grayc"><?php echo $this->Form->input('JobFeedback.'.$jobFeedback['JobFeedback']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$jobFeedback['JobFeedback']['id'], 'label' => '', 'div' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
      <?php endif; ?>
      <td class="dc grayc">
		  <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
			<ul class="dropdown-menu arrow dl">
			<li><?php echo $this->Html->link('<i class="icon-edit"></i>' . __l('Edit'), array('controller' => 'job_feedbacks', 'action' => 'edit', $jobFeedback['JobFeedback']['id']), array('class' => 'delete js-edit', 'title' => __l('Edit'), 'escape' => false));?></li>
			<li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('controller' => 'job_feedbacks', 'action' => 'delete', $jobFeedback['JobFeedback']['id']), array('class' => 'js-confirm', 'title' => __l('Delete'), 'escape' => false));?></li>
			</ul>
		  </div>
		</td>
		<td class="dl grayc"><?php echo $this->Html->cDateTimeHighlight($jobFeedback['JobFeedback']['created']);?></td>
		<td class="dl grayc"><?php echo $this->Html->link($this->Html->cText($jobFeedback['Job']['title']), array('controller'=> 'jobs', 'action'=>'view', $jobFeedback['Job']['slug'], 'admin' => false), array('escape' => false, 'class' => 'grayc'));?></td>
		<td class="dl grayc"><?php echo $this->Html->link($this->Html->cText($jobFeedback['User']['username']), array('controller'=> 'users', 'action'=>'view', $jobFeedback['User']['username'], 'admin' => false), array('escape' => false, 'class' => 'grayc'));?></td>
		<td class="dl grayc"><?php echo $this->Html->cText($jobFeedback['JobFeedback']['feedback']);?></td>
		<td>
		<?php if(!empty($jobFeedback['Ip']['ip'])): ?>
				<?php echo  $this->Html->link($jobFeedback['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $jobFeedback['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$jobFeedback['Ip']['ip'], 'escape' => false, 'class' => 'grayc')); ?>
		  <p>
		  <?php
		   if(!empty($jobFeedback['Ip']['Country'])):
				  ?>
				  <span class="flags flag-<?php echo strtolower($jobFeedback['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $jobFeedback['Ip']['Country']['name']; ?>">
			<?php echo $jobFeedback['Ip']['Country']['name']; ?>
		  </span>
				  <?php
				endif;
		   if(!empty($jobFeedback['Ip']['City'])):
				?>
				<span>   <?php echo $jobFeedback['Ip']['City']['name']; ?>  </span>
				<?php endif; ?>
				</p>
			  <?php else: ?>
		  <?php echo __l('n/a'); ?>
		<?php endif; ?>
		</td>
		<td class="dc grayc"><?php echo $this->Html->cBool($jobFeedback['JobFeedback']['is_satisfied']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="9" class="notice grayc text-16 dc"><?php echo __l('No Feedbacks available');?></td>
	</tr>
<?php
endif;
?>
</tbody>
    </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
  <?php
  if (!empty($jobFeedbacks)) :
    ?>
  <?php if(empty($this->request->params['named']['view_type'])) : ?>
  <div class="ver-space pull-left"> 
    <?php echo __l('Select:'); ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>

			<?php echo $this->Html->link(__l('Satisfied'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"}   hor-smspace grayc', 'title' => __l('Satisfied'))); ?>
			<?php echo $this->Html->link(__l('Unsatisfied'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"}  hor-smspace grayc', 'title' => __l('Unsatisfied'))); ?>   
 </div>
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