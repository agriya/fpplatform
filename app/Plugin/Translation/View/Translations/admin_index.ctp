<?php /* SVN: $Id: admin_index.ctp 71528 2011-11-15 16:48:55Z anandam_023ac09 $ */ ?>
<div class="translations index">
<?php
if (empty($translations)): ?>
<div class="errorc space"><i class="icon-warning-sign errorc"></i>
  <?php echo __l('Sorry, in order to translate, default English strings should be extracted and available. Please contact support.');?>
</div>
<?php endif; ?>
<div class="pull-right ver-space">
	<span class="hor-mspace"><a class="bluec" title="<?php echo __l('Make New Translation'); ?>" href="<?php echo Router::url('/', true); ?>admin/translations/add"><i class="icon-plus-sign no-pad text-18"></i> <?php echo __l('Make New Translation'); ?></a></span>
	<span class="hor-mspace"><a class="bluec" title="<?php echo __l('Add New Text'); ?>" href="<?php echo Router::url('/', false); ?>admin/translations/add_text"><i class="icon-plus-sign no-pad text-18"></i> <?php echo __l('Add New Text'); ?></a></span>
</div>
<section class="space">
<table class="table table-striped table-hover sep">
  <tr>
    <th class="dc sep-right textn span1"><?php echo __l('Actions');?></th>
    <th class="dl sep-right textn"><?php echo __l('Language');?></th>
    <th class="dc sep-right textn"><?php echo __l('Verified');?></th>
    <th class="dc sep-right textn"><?php echo __l('Not Verified');?></th>
  </tr>
<?php
if (!empty($translations)):
foreach ($translations as $language_id => $translation):
?>
  <tr>
    <td class="dc grayc">
    <div class="dropdown inline">
           <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog grayc text-20 dropdown-toggle js-no-pjax"><span class="hide"><?php echo __l('Action'); ?></span></a>
            <ul class="unstyled dropdown-menu dl arrow clearfix">
             <li>
      <?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'manage', 'language_id' => $language_id), array('class' => 'js-edit', 'title' => __l('Edit'), 'escape' => false));?>
      </li>
      <?php if($language_id != '42'):?>
        <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete Translation'), array('action' => 'index', 'remove_language_id' => $language_id), array('class' => 'js-confirm', 'title' => __l('Delete Translation'), 'escape' => false));?></li>
      <?php endif;?>
      <?php echo $this->Layout->adminRowActions($language_id);  ?>
      </ul>
      </div>
    </td>
    <td class="dl"><?php echo $this->Html->cText($translation['name']);?></td>
    <td class="dc grayc"><?php
      if($translation['verified']){
        echo $this->Html->link($translation['verified'], array('action' => 'manage', 'filter' => 'verified', 'language_id' => $language_id), array('class' => 'grayc'));
      } else {
        echo $this->Html->cInt($translation['verified']);
      }
      ?>
    </td>
    <td class="dc grayc"><?php
      if($translation['not_verified']){
        echo $this->Html->link($translation['not_verified'], array('action' => 'manage', 'filter' => 'unverified', 'language_id' => $language_id), array('class' => 'grayc'));
      } else {
        echo $this->Html->cInt($translation['not_verified']);
      }
      ;?></td>
  </tr>
<?php
  endforeach;
else:
?>
  <tr>
    <td colspan="7" class="grayc text-16 notice dc"> <?php echo sprintf(__l('No %s available'), __l('Translations'));?></td>
  </tr>
<?php
endif;
?>
</table>
</section>
</div>