<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(__l(requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps)), array('controller' => 'requests', 'action' => 'index'), array('class' => 'bluec','title'=>__l(requestAlternateName(ConstRequestAlternateName::Plural, ConstRequestAlternateName::FirstLeterCaps)))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Edit '). requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps) ;?></li>      
	</ul>
<?php if(empty($job_types)){?>
	<div class="space">
		<p class="alert alert-info clearfix container"><?php echo sprintf(__l('Problem in edit a %s. %s to contact administrator.'), Configure::read('request.request_alternate_name'), $this->Html->link(__l('Click here'), Router::url('/', true).'contactus', array('escape' => false)));?></p>
	</div>
<?php } else {?>
<div class="list">
<div class="requests form  clearfix">
<?php if(empty($request_filters)){?>
	<?php echo $this->Form->create('Request', array('class' => 'normal form-horizontal  js-add-map'));?>	
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('user_id');
			?>	
			<div class="<?php echo ((count($job_types) < 2) ? "hide" : '') ;?>">
			<?php
				echo $this->Form->input('job_type_id', array('class' => 'js-type-select-change {"model":"Request"}', 'options' =>$job_types, 'legend' =>false, 'before' => '<span class="label-content">'. __l('Job Type') .'</span>', 'type' => 'radio')); 
			?>
			</div>
            <div class="js-category-listing">
            <?php	
				echo $this->Form->input('job_category_id', array('label' =>requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps).' '.__l(' Category'), 'info' => __l('Choose a category that best matches your Request to ensure successful review by our moderators'), 'empty' => __l('Please Select')));
			?>
            <span class="js-select_category hide"> <?php echo json_encode($jobCategoriesClass); ?></span>
            </div>
            <?php 	
				$amount = explode(',', Configure::read('job.price'));
				$amount = array_combine($amount, $amount);
				if(Configure::read('site.currency_symbol_place') == 'left'):
					$currecncy_place = 'before';
				else:
					$currecncy_place = 'after';
				endif;					
				echo $this->Form->input('name', array('label' => __l('I am looking for someone who will'), 'class' => 'js-related-jobs'));
				?>		
                <?php
				if(count($amount) > 1):
					echo $this->Form->input('amount', array('options' => $amount, 'label' => __l('Amount').' ('.Configure::read('site.currency').')'));
				else:
					echo $this->Form->input('amount', $this->Html->siteCurrencyFormat(Configure::read('job.price')));									
					echo $this->Form->hidden('amount', array('value' => Configure::read('job.price')));
				endif;
			?>
			<div id='js-required-class' class="<?php echo (!empty($this->request->data['Request']['job_type_id']) && $this->request->data['Request']['job_type_id'] == ConstJobType::Offline) ? "required" : ""; ?>">
           <?php 
				echo $this->Form->input('address', array('id' => 'JobAddress', 'label' => __l('Address'), 'info' => __l('Optional when').' '.jobAlternateName(ConstRequestAlternateName::Singular).' '.__l('type selected is \'online\'.')));
			?>
			</div>
			<?php
				echo $this->Form->input('latitude', array('id' => 'JobLatitude', 'type' => 'hidden'));
				echo $this->Form->input('longitude', array('id' => 'JobLongitude', 'type' => 'hidden'));
				echo $this->Form->input('zoom_level', array('id' => 'JobZoomLevel', 'type' => 'hidden'));
		    ?>      
			<fieldset>
				<legend><?php echo __l('Map'); ?></legend>
			<div class="show-map bot-space" style="">				
				<div id="js-map-container"></div>
			</div>   
			</fieldset>   
			<div class="submit-block well no-bor no-round dr clearfix">
			<?php
				echo $this->Form->submit((__l('Update')), array('name' => "data[Request][continue]", 'class' => 'btn btn-large btn-warning textb text-20 start' ));
			?>
			</div>
	<?php echo $this->Form->end();?>
<?php }else{?>
		<?php echo $this->Form->create('Request', array('class' => 'normal form-horizontal '));?>
		<div class="js-related-jobs-load">
			<h3> <?php echo sprintf(__l('Related %s'), jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps)); ?> </h3>
			<?php
		    echo $this->requestAction(array('controller' => 'jobs', 'action' => 'index','job_category_id' => $this->request->data['Request']['job_category_id'], 'job_type_id' => $this->request->data['Request']['job_type_id'], 'view' => 'request'), array('return'));
			echo $this->Form->input('job_category_id', array('type' => 'hidden'));
            echo $this->Form->input('job_type_id', array('type' => 'hidden')); 
			echo $this->Form->input('name', array('type' => 'hidden'));
			echo $this->Form->hidden('amount', array('type' => 'hidden'));
			echo $this->Form->input('address', array('type' => 'hidden'));
		   	echo $this->Form->input('latitude', array('type' => 'hidden'));
			echo $this->Form->input('longitude', array('type' => 'hidden'));
			echo $this->Form->input('zoom_level', array('type' => 'hidden'));
		    ?>
			
		
		<div>
			<?php echo __l('(OR)')?>
				<p><div class="page-information clearfix"><?php echo __l('If the above  related').' '.requestAlternateName(ConstRequestAlternateName::Singular). ' '.__l('does not match your exact').' '.requestAlternateName(ConstRequestAlternateName::Singular). ' '.__l('.You can click continue below to create a new one');?></div></p>
		</div>
		<div class="submit-block well no-bor no-round dr clearfix">
		<?php
			echo $this->Form->submit(__l('Post'), array('name' => "data[Request][post]", 'class' => 'btn btn-large btn-warning textb text-20 start'));
		?>
		</div>
		</div>
	<?php echo $this->Form->end();?>
<?php }?>
</div>
</div>
<?php } ?>