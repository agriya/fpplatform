<?php 
if($this->request->params['named']['model'] == 'Job'){
echo $this->Form->input('Job.job_category_id', array('label' => jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps).' '.__l('category'), 'info' => __l('Choose a category that best matches your').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('to ensure successful review by our moderators'), 'empty' => __l('Please Select'))); 
}
else{
echo $this->Form->input('Request.job_category_id', array('label' => __l('Request category'), 'info' => __l('Choose a category that best matches your').' '.__l(' Request to ensure successful review by our moderators'), 'empty' => __l('Please Select'))); 
}
?>