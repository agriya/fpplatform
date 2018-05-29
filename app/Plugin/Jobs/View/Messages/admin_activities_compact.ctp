<p>
  <?php
    if (!empty($messages)) {
      foreach ($messages as $message):
  ?>
  <span class="show text-12 top-smspace">
		<?php 
		  echo $message['MessageContent']['subject'];
		  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created']));
		?> 
		<span class="js-timestamp" title="<?php echo $time_format;?>"><?php echo $message['Message']['created']; ?></span>
  </span>
  <?php
      endforeach;
    } else {
  ?>
  	<div class="thumbnail space dc grayc">
		<p class="ver-mspace top-space text-16"><?php echo __l('No activities found');?></p>
     </div>
  <?php }  ?>
</p>