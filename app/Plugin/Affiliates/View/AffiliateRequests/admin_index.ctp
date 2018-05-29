<?php /* SVN: $Id: $ */ ?>
<div class="affiliateRequests index">
<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Affiliate Requests');?></li>      
	</ul>
<div class="clearfix top-space top-mspace ">
		  <div class="pull-right span9 users-form tab-clr dr">
			<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('AffiliateRequest', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
				<div class="input text required ver-smspace">
				  <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
				</div>
				<div class="submit left-space">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
			<div class="pull-right top-space top-mspace mob-clr mob-dc tab-clr">
				<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18"></i> <span class="grayc">' . __l('Add') . '</span>', array('controller' => 'affiliate_requests', 'action' => 'add'), array('class' => 'hor-mspace bluec textb text-13','title'=>__l('Add'), 'escape' => false)); ?>
				
			</div>
		  </div>
		  <?php echo $this->element('paging_counter'); ?>
</div>



<?php echo $this->Form->create('AffiliateRequest' , array('class' => ' normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
 <div class="overflow-block">
<table class="table table-striped table-hover sep">
<thead>
    <tr class="no-mar no-pad">
        <th class="dc sep-right textn"><?php echo __l('Select');?></th>
        <th class="actions dc sep-right textn"><?php echo __l('Actions');?></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('User'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('site_name', __l('Site'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('site_url', __l('Site URL'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('site_category_id', __l('Site Category'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('why_do_you_want_affiliate', __l('Why Do You Want Affiliate'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('is_web_site_marketing', __l('Website Marketing?'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('is_search_engine_marketing', __l('Search Engine Marketing?'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('is_email_marketing', __l('Email Marketing'), array('class' => 'graydarkerc no-under'));?></div></th>
         <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('special_promotional_method', __l('Promotional Method'), array('class' => 'graydarkerc no-under'));?></div></th>
        <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('is_approved', __l('Approved?'), array('class' => 'graydarkerc no-under'));?></div></th>
    </tr>
    </thead>
<?php
if (!empty($affiliateRequests)):

$i = 0;
foreach ($affiliateRequests as $affiliateRequest):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	if ($affiliateRequest['AffiliateRequest']['is_approved'] == ConstAffiliateRequests::Pending):
		$status_class = 'js-checkbox-pending';
	elseif ($affiliateRequest['AffiliateRequest']['is_approved'] == ConstAffiliateRequests::Accepted):
		$status_class = 'js-checkbox-accepted';
	elseif ($affiliateRequest['AffiliateRequest']['is_approved'] == ConstAffiliateRequests::Rejected):
		$status_class = 'js-checkbox-rejected';
	endif;
?>
	<tr<?php echo $class;?>>
         <td class="jobs-list1 dc"><?php echo $this->Form->input('AffiliateRequest.'.$affiliateRequest['AffiliateRequest']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$affiliateRequest['AffiliateRequest']['id'], 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?></td>
		<td class="actions">
		
		 <div class="dropdown inline"> <span class="grayc dropdown-toggle" data-toggle="dropdown" title="Actions"><i class="icon-cog text-18 hor-space cur"></i> <span class="hide"><?php echo __l('Action'); ?></span> </span>
            <ul class="dropdown-menu arrow dl">
			
			<li><?php echo $this->Html->link('<i class="icon-edit"></i>' . __l('Edit'), array('action'=>'edit', $affiliateRequest['AffiliateRequest']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'), 'escape' => false));?></li>
			<li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('action'=>'delete', $affiliateRequest['AffiliateRequest']['id']), array('class' => 'js-confirm', 'title' => __l('Delete'), 'escape' => false));?></li>
            
		  </ul>
          </div>
		</td>
		<td><?php echo $this->Html->link($this->Html->cText($affiliateRequest['User']['username']), array('controller'=> 'users', 'action'=>'view', $affiliateRequest['User']['username'], 'admin' => false), array('class'=>'grayc', 'escape' => false));?></td>
		<td class="grayc"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['site_name']);?></td>
		<td class="grayc"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['site_url']);?></td>
		<td class="grayc"><?php echo $this->Html->cText($affiliateRequest['SiteCategory']['name']);?></td>
		<td class="grayc"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['why_do_you_want_affiliate']);?></td>
		<td class="grayc"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_web_site_marketing']);?></td>
		<td class="grayc"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_search_engine_marketing']);?></td>
		<td class="grayc"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_email_marketing']);?></td>
        <td class="grayc"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['special_promotional_method']);?></td>
		<td class="grayc"><?php if($affiliateRequest['AffiliateRequest']['is_approved'] == 0){
					echo __l('Waiting for Approval');
				  } else if($affiliateRequest['AffiliateRequest']['is_approved'] == ConstAffiliateRequests::Accepted){
				  	echo __l('Approved');
				  } else if($affiliateRequest['AffiliateRequest']['is_approved'] == ConstAffiliateRequests::Rejected){
				  	echo __l('Rejected');
				  }
		?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="16" class="notice text-16 grayc dc"><?php echo __l('No Affiliate Requests available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
    if (!empty($affiliateRequests)) :
        ?>
        <div class="ver-mspace mob-dc clearfix">
    <div class="top-space pull-left dc mob-clr mob-inline clearfix">
       <div class="pull-left ver-space">
         <?php echo __l('Select:'); ?>
        <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Waiting for approve'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-pending","unchecked":"js-checkbox-accepted, js-checkbox-rejected"}   hor-smspace grayc', 'title' => __l('Waiting for approve'))); ?>
			<?php echo $this->Html->link(__l('Approved'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-accepted","unchecked":"js-checkbox-rejected"}   hor-smspace grayc', 'title' => __l('Approved'))); ?>
			<?php echo $this->Html->link(__l('Disapproved'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-rejected","unchecked":"js-checkbox-accepted"}  hor-smspace grayc', 'title' => __l('Disapproved'))); ?>  
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















