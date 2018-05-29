<?php /* SVN: $Id: $ */ ?>
<?php if(empty($job_types)){?>
	<div class="space">
		<p class="alert alert-info clearfix container"><?php echo sprintf(__l('Problem in edit a %s. %s to contact administrator.'), Configure::read('request.request_alternate_name'), $this->Html->link(__l('Click here'), Router::url('/', true).'contactus', array('escape' => false)));?></p>
	</div>
<?php } else {?>
<?php
	$is_job_share_enabled = Configure::read('job.is_job_share_enabled');
	if(empty($this->request->params['requested']) && !empty($is_job_share_enabled)):
?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<?php endif;?>
<section class="sep-bot top-smspace">
	<div class="container clearfix bot-space">
		<h2 class="text-32 pull-left">
		<?php echo sprintf(__l('Edit %s'), requestAlternateName(ConstRequestAlternateName::Singular, ConstRequestAlternateName::FirstLeterCaps)); ?>
		</h2>
	</div>
</section>
<section class="row bot-mspace bot-space"> 
<div class="container top-space clearfix">  
<div class="list">
<div class="requests form  clearfix">
<?php if(empty($request_filters)){?>
	<?php echo $this->Form->create('Request', array('class' => 'normal form-horizontal  js-add-map'));?>	
			<?php
				echo $this->Form->input('id');
			?>	
			<div class="<?php echo ((count($job_types) < 2) ? "hide" : '') ;?>">
			<fieldset>
				<legend><?php echo __l('Job Type');?></legend>
			<?php
				echo $this->Form->input('job_type_id', array('class' => 'js-type-select-change {"model":"Request"}', 'options' => $job_types, 'legend' =>false, 'before' => '<span class="label-content">'. __l('Job Type') .'</span>', 'type' => 'radio')); 
			?>
			</fieldset>
			</div>
			<br />
			<fieldset>
			<legend><?php echo __l('General');?></legend>
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
				<div class="clearfix">			
                <?php
				if(count($amount) > 1): ?>
				<div class="input select">
				<label> <?php echo __l('Amount'); ?></label>
					<?php	echo $this->Form->input('amount', array('options' => $amount, 'label' => false,'div'=>false, $currecncy_place => '<span class="currency-code">'.Configure::read('site.currency').'</span>')); ?>
				</div>
				<?php else:
					echo $this->Form->input('amount', $this->Html->siteCurrencyFormat(Configure::read('job.price')));									
					echo $this->Form->hidden('amount', array('value' => Configure::read('job.price')));
				endif;
			?>
			</div>
			<div id='js-required-class' class="<?php echo (!empty($this->request->data['Request']['job_type_id']) && $this->request->data['Request']['job_type_id'] == ConstJobType::Offline) ? "required" : ""; ?>">
           <?php 
		   if(Configure::read('job.is_enable_offline') && Configure::read('job.is_enable_online')){
			$inf =  __l('Optional when').' '.jobAlternateName(ConstRequestAlternateName::Singular).' '.__l('type selected is \'online\'.');
		   }
		   else if(Configure::read('job.is_enable_online') && !Configure::read('job.is_enable_offline')){
			$inf =  __l('Optional');
		   }
		   else{
			$inf =  "";
		   }
				echo $this->Form->input('address', array('id' => 'JobAddress', 'label' => __l('Address'), 'info' =>$inf ));
			?>
			</div>
			</fieldset>
			<?php
				echo $this->Form->input('latitude', array('id' => 'JobLatitude', 'type' => 'hidden'));
				echo $this->Form->input('longitude', array('id' => 'JobLongitude', 'type' => 'hidden'));
				echo $this->Form->input('zoom_level', array('id' => 'JobZoomLevel', 'type' => 'hidden'));
		    ?>      
            <div class="bot-mspace bot-space">
		    <fieldset>
        		<legend><?php echo __l('Map');?></legend>
        	<div class="show-map" style="">
        		<div id="js-map-container"></div>
        	</div>
            </fieldset>
            </div>
            <div class="submit-block well no-bor no-round dr clearfix">
			  <div class="submit mob-mspace">
			  <?php
				echo $this->Form->submit((__l('Update')), array('name' => "data[Request][continue]", 'class' => 'btn btn-large btn-warning textb text-20' ));
			  ?>
			  </div>
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
			<div class="submit mob-mspace">
			<?php
			echo $this->Form->submit(__l('Post'), array('name' => "data[Request][post]", 'class' => 'btn btn-large btn-warning textb text-20' ));
			?>
			</div>
		</div>
		</div>
	<?php echo $this->Form->end();?>
<?php }?>
</div>
</div>
</div>
</section>
<?php } ?>