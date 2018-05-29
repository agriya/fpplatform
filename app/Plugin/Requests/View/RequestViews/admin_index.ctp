<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>

<div class="userViews index js-response panel-admin">
  <?php if (empty($this->request->params['named']['view_type'])) {?>
  <ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php 
		echo requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps). __l(' Views');
	?></li>
	</ul>
  <?php } ?>
  <?php if(empty($this->request->params['named']['view_type'])) : ?>
  <section class="space clearfix">
  <div class="pull-left hor-space"><?php echo $this->element('paging_counter');?></div>
    <div class="pull-right users-form tab-clr">
        <div class="pull-left mob-clr mob-dc">
          <?php echo $this->Form->create('RequestView', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
              <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
            <div class="submit left-space">
              <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
            </div>
          <?php echo $this->Form->end(); ?>
        </div>
    </div>
  </section>
  <?php endif; ?>
  <?php echo $this->Form->create('RequestView' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <section class="space">
  <div class="sep bot-mspace img-rounded clearfix">
  <table class="table no-mar table-striped table-hover">
    <thead>
    <tr>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
      <th class="dc sep-right textn span1"><?php echo __l('Select'); ?></th>
      <?php endif; ?>
      <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
        <th  class="sep-right textn"><?php echo $this->Paginator->sort('Request.name', requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps), array('class' => 'graydarkerc no-under'));?></th>
		<th  class="sep-right textn"><?php echo $this->Paginator->sort('User.username', __l('Username'), array('class' => 'graydarkerc no-under'));?></th>
        <th  class="sep-right textn"><?php echo $this->Paginator->sort('Ip.ip', __l('IP'), array('class' => 'graydarkerc no-under'));?></th>
	</tr>
    </thead>
    <tbody>
    <?php
if (!empty($requestViews)):
$i = 0;
foreach ($requestViews as $requestView):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
    <tr <?php echo $class; ?>>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
     <td class="dc grayc"><?php echo $this->Form->input('RequestView.'.$requestView['RequestView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$requestView['RequestView']['id'], 'label' => '', 'div' => false, 'class' => 'js-checkbox-list')); ?></td>
      <?php endif; ?>
      <td class="dc grayc">
			 <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
			<ul class="dropdown-menu arrow dl">			
			<li>
			<?php echo $this->Html->link('<i class="icon-remove"></i>' .__l('Delete'), array('action' => 'delete', $requestView['RequestView']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete'),'escape'=> false));?>
			</li>
			</ul>
			</div>
		</td>
		<td class="grayc"><?php echo $this->Html->link($this->Html->cText($requestView['Request']['name']), array('controller'=> 'requests', 'action'=>'view', $requestView['Request']['slug'], 'admin' => false), array('class' => 'grayc', 'escape' => false));?></td>
		 <td class="grayc"><?php echo !empty($requestView['User']['username']) ? $this->Html->link($this->Html->cText($requestView['User']['username']), array('controller'=> 'users', 'action'=>'view', $requestView['User']['username'],  'admin' => false), array('class' => 'grayc', 'escape' => false)) : __l('Guest');?></td>
       	<td class="grayc">
            <?php if(!empty($requestView['Ip']['ip'])): ?>
                    <?php echo  $this->Html->link($requestView['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $requestView['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$requestView['Ip']['ip'], 'escape' => false, 'class' => 'grayc')); ?>
              <p>
              <?php
               if(!empty($requestView['Ip']['Country'])):
                      ?>
                      <span class="flags flag-<?php echo strtolower($requestView['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $requestView['Ip']['Country']['name']; ?>">
                <?php echo $requestView['Ip']['Country']['name']; ?>
              </span>
                      <?php
                    endif;
               if(!empty($requestView['Ip']['City'])):
                    ?>
                    <span>   <?php echo $requestView['Ip']['City']['name']; ?>  </span>
                    <?php endif; ?>
                    </p>
                  <?php else: ?>
              <?php echo __l('n/a'); ?>
            <?php endif; ?>
        </td>
    </tr>
<?php
    endforeach;
?>	
<?php
else:
?>
	<tr>
		<td colspan="8" class="notice dc text-16 grayc"><?php echo __l('No').' '.requestAlternateName(ConstRequestAlternateName::Singular).' '.__l('views available');?></td>
	</tr>
<?php
endif;
?>
</tbody>
    </table>
</div>
  </section>
  <section class="clearfix hor-mspace bot-space">
  <?php
  if (!empty($requestViews)) :
    ?>
  <?php if(empty($this->request->params['named']['view_type'])) : ?>
  <div class="ver-space pull-left"> 
    <?php echo __l('Select:'); ?>
    <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
    <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
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
