<?php /* SVN: $Id: admin_add.ctp 68881 2011-10-13 09:47:54Z josephine_065at09 $ */ ?>
<div class="translations form space">
<?php echo $this->Form->create('Translation', array('class' => 'form-horizontal', 'action' => 'add'));?>
  <?php
    echo $this->Form->input('from_language', array('value' => __l('English'), 'disabled' => true));
    echo $this->Form->input('language_id', array('label' => __l('To Language')));?>

    <?php
    if(Configure::read('google.translation_api_key')):
      $disabled = false;
    else:
      $disabled = true;
    endif; ?>
    <div class="clearfix">
      <div class="span10">
        <div class="clearfix">
          <?php
          echo $this->Form->submit('Manual Translate', array('name' => 'data[Translation][manualTranslate]', 'class' => 'btn btn-primary'));
          ?>
        </div>
         <span class="grayc info"><i class="grayc icon-info-sign"></i><?php echo __l('It will only populate site labels for selected new language. You need to manually enter all the equivalent translated labels.');?>
          </span>

      </div>
      <div class="span12">
        <div class="clearfix">
        <?php echo $this->Form->submit('Google Translate', array('name' => 'data[Translation][googleTranslate]', 'disabled' => $disabled, 'class' => 'btn btn-primary'));  ?>
        </div>
        <span class="info grayc"><i class="grayc icon-info-sign"></i> <?php echo __l('It will automatically translate site labels into selected language with Google. You may then edit necessary labels.');?> </span>
         <?php if(!Configure::read('google.translation_api_key')): ?>
          <div class="alert alert-info">
            <?php echo __l('Google Translate service is currently a paid service and you\'d need API key to use it.');?> <?php echo __l('Please enter Google Translate API key in ');echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'plugin_settings', 'Translation'), array('title' => __l('Settings'))). __l(' page');?>
          </div>
        <?php endif; ?>
      </div>
  </div>
<?php echo $this->Form->end();?>
</div>

