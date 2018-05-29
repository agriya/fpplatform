<?php
  if(!empty($this->request->params['named']['type'])) {
    $type = $this->request->params['named']['type'];
  } else {
    $type = 'user_messages';
  }
?>
<div class="messages index js-response js-responses">
<div class="row-fluid">
<?php echo $this->Form->create('Message' , array('class' => 'js-shift-click js-no-pjax','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<section class="space">
<table class="table table-striped table-bordered table-condensed table-hover">
  <?php
    if (!empty($messages)) {
      foreach ($messages as $message):
  ?>
  <tr>
    <td>
	  <span class="show text-12 top-smspace">
		<?php 
		  echo $message['MessageContent']['subject'];
		  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created']));
		?> 
		<span class="js-timestamp" title="<?php echo $time_format;?>"><?php echo $message['Message']['created']; ?></span>
  </span></td>
  </tr>
  <?php
      endforeach;
    } else {
  ?>
  <tr>
    <td>
      <div class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo __l('No activities found');?></p>
	</td>
  </tr>
  <?php }  ?>
</table>
</section>
<?php
echo $this->Form->end();
?>
</div>
</div>