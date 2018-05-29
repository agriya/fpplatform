<?php
$jobCount = $job->Job->find('count', array(
    'conditions' => $conditions,
    'recursive' => -1,
));
$page = ceil($jobCount / 8);
for($i = 1; $i <= $page; $i++) {
    $job->request->params['named']['page'] = $i;
	$job->paginate = array(
        'conditions' => $conditions,
        'fields' => array(
            'Job.title',
            'Job.description',
            'Job.slug',
        ),
		'contain' => array(
			'Attachment' => array(
				'fields' => array(
					'Attachment.id',
					'Attachment.filename',
					'Attachment.dir',
					'Attachment.width',
					'Attachment.height'
				) ,
				'limit' => 1,
				'order' => array(
					'Attachment.id' => 'asc'
				)
			)
		) ,
		'order' => array(
			'Job.id' => 'desc'
		) ,
        'recursive' => 0
    );
    $Jobs = $job->paginate();
	if (!empty($Jobs)) :
		foreach($Jobs as $Job) :
			if(!empty($Job['Attachment'])):
				$image_url = getImageUrl('Job',$Job['Attachment']['0'], array('full_url' => true, 'dimension' => 'medium_large_thumb'));
				$job_image = '<img src="'.$image_url.'" alt="'. sprintf(__l('[Image: %s]'), $this->Html->cText($Job['Job']['title'], false)) .'" title="'. $this->Html->cText($Job['Job']['title'], false) .'">';
			endif;
			$job_image = (!empty($job_image)) ? '<p>'.$job_image.'</p>':'';
			echo $this->Rss->item(array() , array(
				'title' =>  $Job['Job']['title'] . ' ' . $this->Html->cText($this->Html->siteCurrencyFormat($Job['Job']['amount']), false),
				'link' => array(
					'controller' => 'jobs',
					'action' => 'view',
					$Job['Job']['slug']
				) ,
				'description' => array(
				'value' => $job_image.'<p>'.$this->Html->cHtml($this->Html->truncate($Job['Job']['description'], 400)) .'</p>',
				'cdata' => true,
				'convertEntities' => false,
				)
			));
		endforeach;
	endif;
}
?>