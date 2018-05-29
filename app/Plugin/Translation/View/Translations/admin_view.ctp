<?php /* SVN: $Id: admin_view.ctp 63884 2011-08-22 09:47:12Z arovindhan_144at11 $ */ ?>
<div class="translations view">
  <dl class="dl-horizontal">
    <dt><?php echo __l('Id');?></dt>
      <dd><?php echo $this->Html->cInt($translation['Translation']['id']);?></dd>
    <dt><?php echo __l('Created');?></dt>
      <dd><?php echo $this->Html->cDateTime($translation['Translation']['created']);?></dd>
    <dt><?php echo __l('Modified');?></dt>
      <dd><?php echo $this->Html->cDateTime($translation['Translation']['modified']);?></dd>
    <dt><?php echo __l('Language');?></dt>
      <dd><?php echo $this->Html->link($this->Html->cText($translation['Language']['name']), array('controller' => 'languages', 'action' => 'view', $translation['Language']['id']), array('escape' => false));?></dd>
    <dt><?php echo __l('Key');?></dt>
      <dd><?php echo $this->Html->cText($translation['Translation']['Name']);?></dd>
    <dt><?php echo __l('Lang Text');?></dt>
      <dd><?php echo $this->Html->cText($translation['Translation']['lang_text']);?></dd>
  </dl>
</div>

