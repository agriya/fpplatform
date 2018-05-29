<?php /* SVN: $Id: admin_index.ctp 1711 2010-05-04 11:12:13Z vinothraja_091at09 $ */ ?>
<div class="hor-space js-response">
	<ul class="breadcrumb no-round top-mspace ver-space">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li class="active graydarkerc">Banned Ips</li>
	</ul>
	<div class="tabbable ver-space sep-top top-mspace">
      <div id="list" class="tab-pane active in no-mar">
		<div class="clearfix">
		  <div class="pull-right span users-form tab-clr">
		  	<div class="pull-right top-space top-mspace mob-clr mob-dc tab-clr">
				<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18"></i> <span class="grayc">' . __l('Add') . '</span>', array('controller' => 'banned_ips', 'action' => 'add'), array('class' => 'bluec textb text-13','title'=>__l('Add'), 'escape' => false)); ?>
			</div>
		  </div>
		  <?php echo $this->element('paging_counter'); ?>
		</div>
<?php   echo $this->Form->create('BannedIp' , array('class' => 'normal ','action' => 'update'));
$url=(!empty($this->request->url)?$this->request->url:'');?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $url )); ?>
<div class="tab-pane active in no-mar" id="active-users">
  <div class="sep bot-mspace img-rounded clearfix">
    <table class="table no-mar table-striped table-hover">
  	  <thead>
	  <tr class="no-mar no-pad">
		<th class="dc sep-right textn span1"><?php echo __l('Select');?></th>
        <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
        <th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort( 'address',__l('Victims'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort( 'reason',__l('Reason'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dl sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort( 'redirect',__l('Redirect to'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort('thetime',__l('Date Set'), array('class' => 'graydarkerc no-under'));?></div></th>
		<th class="dc sep-right textn"><div class="js-pagination"><?php echo $this->Paginator->sort( 'timespan',__l('Expiry Date'), array('class' => 'graydarkerc no-under'));?></div></th>
	  </tr></thead><tbody>
			<?php
			if (!empty($bannedIps)):
				$i = 0;
				foreach ($bannedIps as $bannedIp):
					?>
					<tr>
                        <td class="dc grayc">
							<div class="action-content"><div class="actions"><span></span></div></div>
							<?php echo $this->Form->input('BannedIp.'.$bannedIp['BannedIp']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$bannedIp['BannedIp']['id'], 'label' => '', 'class' => 'js-checkbox-list')); ?>
						</td>
                        <td class="dc grayc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="grayc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide"><?php echo __l('Action'); ?></span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
                                    <li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $bannedIp['BannedIp']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
                               </ul>
                            </span>
                        </td>						
						<td class="dc grayc">
							<?php
								if ($bannedIp['BannedIp']['referer_url']) :
									echo $bannedIp['BannedIp']['referer_url'];
								else:
									echo long2ip($bannedIp['BannedIp']['address']);
									if ($bannedIp['BannedIp']['range']) :
										echo ' - '.long2ip($bannedIp['BannedIp']['range']);
									endif;
								endif;
							?>
						</td>
						<td class="dl"><?php echo $this->Html->cText($bannedIp['BannedIp']['reason']);?></td>
						<td class="dl"><?php echo $this->Html->cText($bannedIp['BannedIp']['redirect']);?></td>
						<td class="dc"><?php echo _formatDate('M d, Y h:i A', $bannedIp['BannedIp']['thetime']); ?></td>
						<td class="dc"><?php echo ($bannedIp['BannedIp']['timespan'] > 0) ? _formatDate('M d, Y h:i A', $bannedIp['BannedIp']['thetime']) : __l('Never');?></td>
					</tr>
			<?php
				endforeach;
			else:
			?>
				<tr>
					<td colspan="7" class="grayc text-16 notice dc"><?php echo __l('No Banned IPs available');?></td>
				</tr>
			<?php
			endif;
			?>
		</tbody>
    </table>
</div>
<div>
    <?php
    if (!empty($bannedIps)) :
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
<?php endif;
echo $this->Form->end();
?>
</div> 
</div>
</div>