<div class="dropdown pull-left left-smspace mob-inline">
  <a href="#" title="Setting" class="dropdown-toggle btn btn-primary no-shad" data-toggle="dropdown">
    <i class="icon-cog whitec no-pad text-20"></i>
  </a>
  <ul class="unstyled dropdown-menu arrow arrow-right dl clearfix">
	<?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'featured') ? ' active' : null; ?>
	<li class="grayc <?php echo $class ?>"><?php echo $this->Html->link(__l('Featured'), array('controller'=>'jobs','action'=>'index','filter' => 'featured'), array('class' => $class, 'title' => __l('Featured')));?></li>
	<?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'recent') ? ' active' : null; ?>
	<li class="grayc <?php echo $class ?>"><?php echo $this->Html->link(__l('Recent'), array('controller'=>'jobs','action'=>'index','filter' => 'recent'), array('class' => $class,'title' => __l('Recent')));?></li>
	<?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'popular') ? ' active' : null; ?>
	<li class="grayc <?php echo $class ?>"><?php echo $this->Html->link(__l('Popular'), array('controller'=>'jobs','action'=>'index','filter' => 'popular') , array('class' => $class,'title' => __l('Popular')));?></li>
	<?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'highest-rated') ? ' active' : null; ?>
	<li class="grayc <?php echo $class ?>"><?php echo $this->Html->link(__l('Highest rated'), array('controller'=>'jobs','action'=>'index','filter' => 'highest-rated'), array('class' => $class,'title' => __l('Highest rated')));?></li>
	<?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'amount') ? ' active' : null; 	
	$total_amount_filter = count($amounts) ;?>
	<li class="dropdown-submenu pull-left <?php echo $class ?> <?php echo ($total_amount_filter > 1)? 'filter-amount' :'' ?>">
				
				<?php if($total_amount_filter > 1){
					echo '<a href="#">' . $this->Html->cText(__l('Amount')) . '</a>' ;
				  } else{
						foreach($amounts as $amount){
							echo $this->Html->link(__l('Filter by').' '.$this->Html->cText($this->Html->siteCurrencyFormat($amount), false), array('controller'=>'jobs', 'action'=>'index', 'amount' => $amount, 'filter' => 'amount'), array('class' => $class ,'title' => __l('Filter by').' '.$this->Html->cText($this->Html->siteCurrencyFormat($amount), false)));
						}
				  }?>	
							
		<ul class="dropdown-menu">
		<?php
			unset($this->request->params['named']['filter']);
			if($total_amount_filter > 1):
				foreach($amounts as $amount){					
					if(!empty($amount)):						
						$class = (!empty($this->request->params['named']['amount']) && $this->request->params['named']['amount'] == $amount) ? ' active' : null;						
					?>
						<li class = "<?php echo $class; ?>">						
							<?php echo $this->Html->link(__l('Filter by').' '.$this->Html->cText($this->Html->siteCurrencyFormat($amount), false), array('controller'=>'jobs', 'action'=>'index', 'amount' => $amount, 'filter' => 'amount'), array('title' => __l('Filter by').' '.$this->Html->cText($this->Html->siteCurrencyFormat($amount), false)));?>
						</li>
					<?php
					endif;
				}
			endif;
		?>
		</ul>
	</li><?php 
	$class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'job-type') ? ' active' : null; 	
	$total_jobtype_filter = count($jobTypes);
	if($total_jobtype_filter > 1) :
	?>
	<li class="dropdown-submenu pull-left <?php echo $class ?> <?php echo ($total_amount_filter > 1)? 'filter-amount' :'' ?>">	
		<?php if($total_jobtype_filter > 1){
			echo '<a href="#">' . $this->Html->cText(sprintf(__l('%s Type'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps))) . '</a>' ;
		  } else{
			foreach($jobTypes as $jobType){
				echo $this->Html->link($this->Html->cText($jobtype_filter, false), array('controller'=>'jobs', 'action'=>'index', 'job_type_id' => $jobtype_filter, 'filter' => 'job-type'), array('class' => $class ,'title' => __l('Filter by')));
			}
		  }
		?>								
		<ul class="dropdown-menu">
		<?php
			unset($this->request->params['named']['filter']);
			if($total_jobtype_filter > 1):
				foreach($jobTypes as $key => $value){				
					if(!empty($key)):						
						$class = (!empty($this->request->params['named']['job_type_id']) && $this->request->params['named']['job_type_id'] == $key) ? ' active' : null;						
					?>
						<li class = "<?php echo $class; ?>">						
							<?php echo $this->Html->link($this->Html->cText($value, false), array('controller'=>'jobs', 'action'=>'index', 'job_type_id' => $key, 'filter' => 'job-type'), array('title' => $value));?>
						</li>
					<?php
					endif;
				}
			endif;
		?>
		</ul>
	</li><?php
	endif; 
	?>
  </ul>
</div>

			