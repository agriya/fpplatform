<div>
<?php
if(!empty($job['Attachment'])):
 echo $this->Html->showImage('Job', $job['Attachment']['0'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)), 'title' => $this->Html->cText($job['Job']['title'], false)));
 endif;
 echo $this->Html->link($job['Job']['title'].'-'.$this->Html->siteCurrencyFormat($job['Job']['amount']), array('controller' => 'jobs', 'action' => 'v', 'slug' => $job['Job']['slug'], 'view_type' => ConstViewType::NormalView), array('escape' => false, 'target' =>'parent', 'title' => $this->Html->cText($job['Job']['title'], false)));
?> 

</div>



			