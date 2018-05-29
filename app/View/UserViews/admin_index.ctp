<?php /* SVN: $Id: admin_index.ctp 4904 2010-05-13 09:31:09Z josephine_065at09 $ */ ?>
<div class="hor-space js-response">
	<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc"><?php echo __l('User Views');?></li>
	</ul>
	<div class="tabbable ver-space sep-top top-mspace">
      <div id="list" class="tab-pane active in no-mar">
		<div class="clearfix top-space top-mspace">
		  <div class="pull-right users-form tab-clr">
		  	<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('UserView', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
				  <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
				<div class="submit left-space">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
		  </div>
		 <?php echo $this->element('paging_counter'); ?>
		</div>
<?php   echo $this->Form->create('UserView' , array('class' => 'normal ','action' => 'update'));
$url=(!empty($this->request->url)?$this->request->url:'');?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $url )); ?>
<div class="tab-pane active in no-mar" id="active-users">
  <div class="sep bot-mspace img-rounded clearfix">
    <table class="table no-mar table-striped table-hover">
  	  <thead>
	  <tr class="no-mar no-pad">
		<th class="dc sep-right textn span1"><?php echo __l('Select');?></th>
        <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
        <th class="dc sep-right textn"><?php echo $this->Paginator->sort('UserView.created', __l('Viewed Time'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dl sep-right textn"><?php echo $this->Paginator->sort('User.username', __l('Username'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dl sep-right textn"><?php echo $this->Paginator->sort('ViewingUser.username', __l('Viewed User'), array('class' => 'graydarkerc no-under'));?></th>
        <th class="dl sep-right textn"><?php echo $this->Paginator->sort('Ip.ip', __l('IP'), array('class' => 'graydarkerc no-under'));?></th>
        </tr>
        </thead>
    <tbody><?php
          if (!empty($userViews)):
            foreach ($userViews as $userView):
                ?>
                <tr>
                    <td class="dc grayc"><?php echo $this->Form->input('UserView.'.$userView['UserView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userView['UserView']['id'], 'label' => '', 'div' => false, 'class' => 'js-checkbox-list')); ?></td>
                    <td class="dc grayc">
					<div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
						<ul class="dropdown-menu arrow dl">
						<li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('action' => 'delete', $userView['UserView']['id']), array('class' => 'js-confirm', 'title' => __l('Delete'), 'escape' => false));?></li>
						</ul>
			          </div>  
					</td>
                    <td class="dc grayc"><?php echo $this->Html->cDateTimeHighlight($userView['UserView']['created']);?></td>
                    <td class="dl grayc">
					<?php echo $this->Html->getUserAvatar($userView['User'], 'micro_thumb',true, '', 'admin');?>
                    <?php echo $this->Html->link($this->Html->cText($userView['User']['username']), array('controller'=> 'users', 'action'=>'view', $userView['User']['username'], 'admin' => false),  array('title' => __l($userView['User']['username']),'escape' => false, 'class' => 'grayc hor-space'));?></td>
                    <td class="dl grayc">
					<?php echo $this->Html->getUserAvatar($userView['ViewingUser'], 'micro_thumb',true, '', 'admin');?>
                    <?php echo !empty($userView['ViewingUser']['username']) ? $this->Html->link($this->Html->cText($userView['ViewingUser']['username']), array('controller'=> 'users', 'action'=>'view', $userView['ViewingUser']['username'], 'admin' => false), array('title' => __l($userView['User']['username']),'escape' => false, 'class' => 'grayc hor-space')) : '<span class="pull-left left-mspace">' . __l('Guest') . '</span>';?></td>
					<td class="grayc">
					<?php if(!empty($userView['Ip']['ip'])): ?>
							<?php echo  $this->Html->link($userView['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $userView['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$userView['Ip']['ip'], 'escape' => false, 'class' => 'grayc')); ?>
					  <p>
					  <?php
					   if(!empty($userView['Ip']['Country'])):
							  ?>
							  <span class="flags flag-<?php echo strtolower($userView['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $userView['Ip']['Country']['name']; ?>">
						<?php echo $userView['Ip']['Country']['name']; ?>
					  </span>
							  <?php
							endif;
					   if(!empty($userView['Ip']['City'])):
							?>
							<span>   <?php echo $userView['Ip']['City']['name']; ?>  </span>
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
                <td colspan="7" class="grayc notice text-16 dc"><?php echo __l('No User Views available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </tbody>
    </table>
</div>
</div>
    <?php
    if (!empty($userViews)) :
        ?>
  <div class="ver-mspace mob-dc clearfix">
    <div class="top-space pull-left dc mob-clr mob-inline clearfix">
       <div class="pull-left ver-space">
         <?php echo __l('Select:'); ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
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