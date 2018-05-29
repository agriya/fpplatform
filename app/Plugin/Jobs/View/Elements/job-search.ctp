 <?php echo $this->Form->create('Job', array('type' => 'get', 'class' => 'job-search-form clearfix js-search-map', 'action'=>'index', 'id' => 'jobsearch')); ?>
 <div class="clearfix search-input-block">
 <div class="search-text-block">
 <?php echo $this->Form->input('location', array('label' => __l('Search Location:'), 'id' => 'address'));?>
 <?php
//  echo $this->Form->input('q', array('label' => __l('Start searching...'), 'id' => 'Qsearch'));?>

 <div class="submit-block clearfix">
 <?php  echo $this->Form->submit(__l('search'));?>
 </div>
  </div>
 </div>
  <div class="search-map-block">
	 <?php
//	 if($this->request->params['controller'] == 'jobs' && $this->request->params['action'] == 'search'): 	
	?>
	 <div class="extra-search-block clearfix">
	 <div class="map-block" id ="js-map-search-container"></div>
	 <div class=" clearfix">
		<?php
			echo $this->Form->input('sw_latitude', array('type' => 'hidden', 'id' =>'sw_latitude'));
			echo $this->Form->input('sw_longitude', array('type' => 'hidden', 'id' =>'sw_longitude'));
			echo $this->Form->input('ne_latitude', array('type' => 'hidden', 'id' =>'ne_latitude'));
			echo $this->Form->input('ne_longitude', array('type' => 'hidden', 'id' =>'ne_longitude'));

			echo $this->Form->input('latitude', array('type' => 'hidden', 'id' =>'job_latitude'));
			echo $this->Form->input('longitude', array('type' => 'hidden', 'id' =>'job_longitude'));
			echo $this->Form->input('zoom_level', array('type' => 'hidden', 'id' =>'job_zoom_level', 'value' =>'1'));
			echo $this->Form->input('job_search', array('type' => 'hidden', 'value' =>'1'));
			echo $this->Form->input('r', array('type' => 'hidden', 'value' =>$this->request->params['controller']));
		  ?>
	 </div>
	</div>
	<?//php endif;?>
</div>
<?php  echo $this->Form->end();  ?>
