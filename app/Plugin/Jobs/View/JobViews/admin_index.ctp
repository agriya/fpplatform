<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>

<div class="userViews index js-response panel-admin">
  <?php if (empty($this->request->params['named']['view_type'])) {?>
  <ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo sprintf(__l('%s Views'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)); ?></li>
	</ul>
  <?php } ?>
  <?php if(empty($this->request->params['named']['view_type'])) : ?>
  <section class="space clearfix">
  <div class="pull-left"><?php echo $this->element('paging_counter');?></div>
    <div class="pull-right users-form tab-clr">
        <div class="pull-left mob-clr mob-dc">
          <?php echo $this->Form->create('JobView', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
              <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
            <div class="submit left-space">
              <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
            </div>
          <?php echo $this->Form->end(); ?>
        </div>
    </div>
  </section>
  <?php endif; ?>
  <?php echo $this->Form->create('JobView' , array('class' => 'clearfix js-shift-click js-no-pjax','action' => 'update')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <section class="space">
  <table class="table no-mar table-striped table-hover">
    <thead>
    <tr>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
      <th class="select dc"><?php echo __l('Select'); ?></th>
      <?php endif; ?>
      <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
		<th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Created'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('Job.title', jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('User'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip', __l('IP'), array('class' => 'graydarkerc no-under'));?></div></th>
    </tr>
    </thead>
    <tbody>
    <?php
      
      if (!empty($jobViews)):
      $i = 0;
        foreach ($jobViews as $jobView):
          
    ?>
    <tr>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
      <td class="dc grayc"><?php echo $this->Form->input('JobView.'.$jobView['JobView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$jobView['JobView']['id'], 'label' => '', 'div' => false, 'class' => 'js-checkbox-list')); ?></td>
      <?php endif; ?>
      <td class="dc grayc">
		<div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php __l('Action'); ?></span> </span>
			<ul class="dropdown-menu arrow dl">
			<li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('controller' => 'job_views', 'action' => 'delete', $jobView['JobView']['id']), array('class' => 'js-confirm', 'title' => __l('Delete'), 'escape' => false));?></li>
			</ul>
		  </div>
		</td>
		<td class="dc grayc"><?php echo $this->Html->cDateTimeHighlight($jobView['JobView']['created']);?></td>
		<td class="dl grayc"><?php echo $this->Html->link($this->Html->cText($jobView['Job']['title']), array('controller'=> 'jobs', 'action'=>'view', $jobView['Job']['slug'], 'admin' => false), array('escape' => false, 'class' => 'grayc'));?></td>
		<td class="dl grayc"><?php echo !empty($jobView['User']['username']) ? $this->Html->link($this->Html->cText($jobView['User']['username']), array('controller'=> 'users', 'action'=>'view', $jobView['User']['username'],  'admin' => false), array('escape' => false, 'class' => 'grayc')) : __l('Guest');?></td>
		<td class="dl">
		<?php if(!empty($jobView['Ip']['ip'])): ?>
				<?php echo  $this->Html->link($jobView['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $jobView['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$jobView['Ip']['ip'], 'escape' => false, 'class' => 'grayc')); ?>
		  <p>
		  <?php
		   if(!empty($jobView['Ip']['Country'])):
				  ?>
				  <span class="flags flag-<?php echo strtolower($jobView['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $jobView['Ip']['Country']['name']; ?>">
			<?php echo $jobView['Ip']['Country']['name']; ?>
		  </span>
				  <?php
				endif;
		   if(!empty($jobView['Ip']['City'])):
				?>
				<span>   <?php echo $jobView['Ip']['City']['name']; ?>  </span>
				<?php endif; ?>
				</p>
			  <?php else: ?>
		  <?php echo __l('n/a'); ?>
		  <?php endif; ?>
		</td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="7" class="grayc notice text-16 dc"><?php echo __l('No Views available');?></td>
            </tr>
            <?php
        endif;
        ?>
	</tbody>
    </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
  <?php
  if (!empty($jobViews)) :
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