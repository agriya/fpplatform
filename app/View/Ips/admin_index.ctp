<?php /* SVN: $Id: $ */ ?>
<div class="ips index">
<ul class="breadcrumb no-round top-mspace ver-space">
  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
  <li class="active graydarkerc"><?php echo __l('IPs');?></li>
</ul>
  <section class="space clearfix">
	<div class="clearfix top-space top-mspace">
		  <div class="pull-right users-form tab-clr">
		  	<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('Ip', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
				  <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
				<div class="submit left-space">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
		  </div>
		  <?php echo $this->element('paging_counter'); ?>
		</div>
	</section>
  <?php
  echo $this->Form->create('Ip', array('class' => 'clearfix js-shift-click js-no-pjax', 'action'=>'update'));
  ?>
  <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <section class="sep bot-mspace img-rounded clearfix">
  <table class="table no-mar table-striped table-hover">
    <thead>
    <tr>
      <th rowspan="2" class="dc sep-right textn span1"><?php echo __l('Select');?></th>
      <th rowspan="2" class="dc sep-right textn"><?php echo __l('Actions');?></th>
      <th rowspan="2" class="dc sep-right textn"><?php echo $this->Paginator->sort('created',__l('Created'), array('class' => 'graydarkerc no-under'));?></th>
      <th rowspan="2" class="sep-right textn"><?php echo $this->Paginator->sort('ip',__l('IP'), array('class' => 'graydarkerc no-under'));?></th>
      <th colspan="5" class="dc sep-right textn"><?php echo __l('Auto detected'); ?></th>
    </tr>
    <tr>
      <th class="sep-right textn"><?php echo $this->Paginator->sort('City.name',__l('City'), array('class' => 'graydarkerc no-under'));?></th>
      <th class="sep-right textn"><?php echo $this->Paginator->sort('State.name',__l('State'), array('class' => 'graydarkerc no-under'));?></th>
      <th class="sep-right textn"><?php echo $this->Paginator->sort('Country.name',__l('Country'), array('class' => 'graydarkerc no-under'));?></th>
      <th class="sep-right textn"><?php echo $this->Paginator->sort('latitude',__l('Latitude'), array('class' => 'graydarkerc no-under'));?></th>
      <th class="sep-right textn"><?php echo $this->Paginator->sort('longitude',__l('Longitude'), array('class' => 'graydarkerc no-under'));?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($ips)):
      foreach ($ips as $ip):
      $status_class = 'js-checkbox-deactiveusers';
    ?>
      <tr>
        <td class="select dc grayc">
        <?php echo $this->Form->input('Ip.'.$ip['Ip']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$ip['Ip']['id'], 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?>
        </td>
        <td class="dc">
        <div class="dropdown">
          <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog grayc text-20 dropdown-toggle js-no-pjax"><span class="hide"><?php echo __l('Action'); ?></span></a>
          <ul class="unstyled dropdown-menu dl arrow clearfix">
          <li>
            <?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), Router::url(array('action'=>'delete',$ip['Ip']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
          </li>
          <?php echo $this->Layout->adminRowActions($ip['Ip']['id']); ?>
          </ul>
        </div>
        </td>
        <td class="dc grayc"><?php echo $this->Html->cDateTime($ip['Ip']['created']);?></td>
        <td class="dl grayc">
        <?php echo  $this->Html->link($ip['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $ip['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax grayc', 'target' => '_blank', 'title' => 'whois '.$ip['Ip']['ip'], 'escape' => false));?>
        <?php if (!empty($ip['Ip']['user_agent'])) { ?>
          <span class="cur js-tooltip pull-right" title="<?php echo $ip['Ip']['user_agent'];?>"><i class="icon-info-sign"></i></span>
        <?php } ?>
        </td>
        <td class="dl grayc"><?php echo $this->Html->cText($ip['City']['name']);?></td>
        <td class="dl grayc"><?php echo $this->Html->cText($ip['State']['name']);?></td>
        <td class="dl grayc"><?php echo $this->Html->cText($ip['Country']['name']);?></td>
        <td class="grayc"><?php echo $this->Html->cFloat($ip['Ip']['latitude']);?></td>
        <td class="grayc"><?php echo $this->Html->cFloat($ip['Ip']['longitude']);?></td>
      </tr>
    <?php
      endforeach;
    else:
    ?>
      <tr>
        <td colspan="11" class="grayc text-16 notice dc"><?php echo sprintf(__l('No %s available'), __l('IPs'));?></td>
      </tr>
    <?php
    endif;
    ?>
    </tbody>
  </table>
  </section>
  <?php
    if (!empty($ips)) :
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
  <?php
  endif;
  echo $this->Form->end();
  ?>
</div>