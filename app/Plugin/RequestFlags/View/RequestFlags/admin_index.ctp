<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>

<div class="userViews index js-response panel-admin">
  <?php if (empty($this->request->params['named']['view_type'])) {?>
  <ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo sprintf(__l('%s Flags'), requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps));?></li>
	</ul>
  <?php } ?>
  <?php if(empty($this->request->params['named']['view_type'])) : ?>
  <section class="space clearfix">
  <div class="pull-left"><?php echo $this->element('paging_counter');?></div>
   <div class="pull-right users-form tab-clr">
		  	<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('RequestFlag', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
				  <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
				<div class="submit left-space">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
		  </div>
  </section>
  <?php endif; ?>
  <?php echo $this->Form->create('RequestFlag' , array('class' => 'clearfix js-shift-click js-no-pjax','action' => 'update')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <section class="space">
  <table class="table no-mar table-striped table-hover">
    <thead>
    <tr>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
      <th class="select dc"><?php echo __l('Select'); ?></th>
      <?php endif; ?>
      <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
		<th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('Username'), array('class' => 'graydarkerc no-under'));?></div></th>
            <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('Request.name', requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps), array('class' => 'graydarkerc no-under'));?></div></th>
            <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('RequestFlagCategory.name', __l('Category'), array('class' => 'graydarkerc no-under'));?></div></th>
            <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('message', __l('Message'), array('class' => 'graydarkerc no-under'));?></div></th>
            <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip', __l('IP'), array('class' => 'graydarkerc no-under'));?></div></th>
            <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Posted on'), array('class' => 'graydarkerc no-under'));?></div></th>
    </tr>
    </thead>
    <tbody>
    <?php
     if (!empty($requestFlags)):
        foreach ($requestFlags as $requestFlag):
    ?>
    <tr>
      <?php if(empty($this->request->params['named']['view_type'])) : ?>
     <td class="dc grayc"><?php echo $this->Form->input('RequestFlag.'.$requestFlag['RequestFlag']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$requestFlag['RequestFlag']['id'], 'label' => '', 'div' => false, 'class' => 'js-checkbox-list')); ?></td>
      <?php endif; ?>
      <td class="dc grayc">
					  <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="<?php echo __l('Action'); ?>"><i class="icon-cog text-18 hor-space cur"></i>    <span class="hide"><?php echo __l('Action'); ?></span> </span>
						<ul class="dropdown-menu arrow dl">
						<li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('controller' => 'request_flags', 'action' => 'delete', $requestFlag['RequestFlag']['id']), array('class' => 'js-confirm', 'title' => __l('Delete'), 'escape' => false));?></li>
						</ul>
					  </div>
					</td>
				    <td class="dl grayc">
                        <?php echo $this->Html->link($this->Html->cText($requestFlag['User']['username']), array('controller'=> 'users', 'action'=>'view', $requestFlag['User']['username'], 'admin' => false), array('escape' => false, 'class' => 'grayc'));?>
                        <span class="label textn"><?php echo  $this->Html->link(sprintf(__l('All').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.  __l('flagged by %s'),$requestFlag['User']['username']), array('controller' => 'request_flags', 'action' => 'index', 'username' => $requestFlag['User']['username']), array('title' => sprintf(__l('Show all').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.  __l('flagged by %s '),$requestFlag['User']['username']), 'class' => 'textb whitec', 'escape' => false));?></span>
                    </td>
                    <td class="dl grayc">					

                     <?php echo $this->Html->link($this->Html->cText($requestFlag['Request']['name']), array('controller'=> 'request', 'action'=>'view', $requestFlag['Request']['slug'], 'admin' => false), array('escape' => false, 'class' => 'grayc'));?>
                    </td>
                    <td class="dl grayc"><?php echo $this->Html->cText($requestFlag['RequestFlagCategory']['name']);?></td>
                    <td class="dl grayc"><?php echo $this->Html->Truncate($requestFlag['RequestFlag']['message']);?></td>
                    <td class="grayc">
					<?php if(!empty($requestFlag['Ip']['ip'])): ?>
							<?php echo  $this->Html->link($requestFlag['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $requestFlag['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$requestFlag['Ip']['ip'], 'escape' => false, 'class' => 'grayc')); ?>
					  <p>
					  <?php
					   if(!empty($requestFlag['Ip']['Country'])):
							  ?>
							  <span class="flags flag-<?php echo strtolower($requestFlag['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $requestFlag['Ip']['Country']['name']; ?>">
						<?php echo $requestFlag['Ip']['Country']['name']; ?>
					  </span>
							  <?php
							endif;
					   if(!empty($requestFlag['Ip']['City'])):
							?>
							<span>   <?php echo $requestFlag['Ip']['City']['name']; ?>  </span>
							<?php endif; ?>
							</p>
						  <?php else: ?>
					  <?php echo __l('n/a'); ?>
					<?php endif; ?>
					</td>
                    <td class="dl grayc"><?php echo $this->Html->cDateTimeHighlight($requestFlag['RequestFlag']['created']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="9" class="notice dc text-16 dc grayc">
				<?php echo __l('No').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.__l('Flags available');?>
				</td>
            </tr>
            <?php
        endif;
        ?>
    </tbody>
    </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
  <?php
  if (!empty($requestFlags)) :
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