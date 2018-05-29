<?php /* SVN: $Id: $ */?>
<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin && !empty($this->request->prefix)) { ?>
<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
	  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
	  <li><?php echo $this->Html->link(__l(jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps)), array('controller' => 'jobs', 'action' => 'index'), array('class' => 'bluec', 'escape' => false, 'title'=> __l(jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps)))); ?> <span class="divider graydarkerc ">/</span></li>	  
	  <li class="active graydarkerc"><?php echo __l('Add ').jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps);?></li>      
	</ul>
<?php } ?>    
<?php if(empty($job_types)){?>
	<div class="space">
		<p class="alert alert-info clearfix container"><?php echo sprintf(__l('Problem in post a %s. %s to contact administrator.'), Configure::read('job.job_alternate_name'), $this->Html->link(__l('Click here'), Router::url('/', true).'contactus', array('escape' => false)));?></p>
	</div>
<?php } else {?>

	<?php if (!empty($is_payout_error) || !empty($this->request->params['named']['step'])) { ?>
		<section class="sep-bot top-smspace">
			<div class="<?php echo empty($this->request->prefix)?'container':'';?> clearfix bot-space">
				<div class="text-32 textb pull-left ver-mspace">
					<div class="span9 "><span class="badge <?php echo empty($this->request->params['named']['step'])?'badge-info':'';?> space span">1</span>&nbsp;<?php echo __l('Payout');?></div>
					<div class="span8 "><span class="badge <?php echo !empty($this->request->params['named']['step'])?'badge-info':'';?> space span">2</span>&nbsp;<?php echo __l('Post a ').' '.jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps);?></div>
				</div>
			</div>
		</section>
	<?php }else{ ?>
	<section class="sep-bot bot-mspace">
		<div class="container ">
			<div class="label label-info show text-18 clearfix no-round ver-mspace">
				<div class="span smspace"><?php echo __l('Seller Control Panel');?></div>
				<?php if(empty($this->request->prefix)){?><?php echo $this->element('selling-cp-settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?><?php }?>
			</div>
			<h2 class="textb text-32 bot-space mob-dc"><?php echo __l('Post a ').' '.jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps);?></h2>
		</div>
	</section>		
	<?php } ?>
<section class="row bot-mspace bot-space">
<div class="<?php echo empty($this->request->prefix)?'container':'';?> top-space clearfix">   
<?php 
	if (!empty($is_payout_error)) { ?>
			<?php if(isset($this->request->query['error_code'])) { ?>
				<?php if($this->request->query['error_code'] != 0){ ?>
					  <div class="alert alert-error">
					  <?php 
						echo sprintf('%s. %s', $this->request->query['error_message'], __l('Connection not completed. Please try again.')); ?>
					 </div>
				<?php } else {
					?>
					<div class="alert alert-success">
					  <?php echo __l('Gateway connected successfully. Waiting for notification from payment gateway. Will refresh the page in 60 seconds...'); ?>
					  <meta http-equiv="refresh"  content="30;url=<?php echo Router::url(array('controller' => 'jobs', 'action' => 'add'), true);?>" />
					 </div>
					<?php
					}
				 }
				$request_id= !empty($request['Request']['id'])?$request['Request']['id']:'';
				echo $this->element('sudopay_user_accounts', array('step' => 1 ,'request' => $request_id, 'user' => $userDetails['User'], 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
	 } else { ?>       
<div class="jobs form js-responses">
	<?php if($this->request->params['controller'] == 'jobs' && $this->request->params['action'] == 'add'){ ?>


	<?php if(!empty($jobs)):
	 echo $this->Form->create('Job', array('class' => 'normal form-horizontal ', 'action' => 'mapping_jobs'));
	?>
         <fieldset class="form-block round-5">
			<div class="alert alert-warning">
				<?php echo __l('Assign a').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('for').' "'.$request['Request']['name']."\"";?>
			</div>
            <div class="clearfix">
                <?php

                        echo $this->Form->input('request_id',array('type'=>'hidden'));
        				echo  $this->element('jobs-index-my-jobs',array('cache' => 30));
        				echo $this->Form->input('r', array('type' => 'hidden', 'value' =>  $this->params['url']));
        		?>
        		 <div class="show space clearfix">
        		<?php
                        echo $this->Form->submit(__l('Assign'),array('class'=>'btn btn-warning'));
        		?>
                </div>
            </div>
            </fieldset>
	 <?php		
       echo $this->Form->end();
     ?>
    <h3> <?php echo __l('OR'); ?> </h3>
    <?php endif; ?>




	<?php if((count($job_types) == 2) || ((count($job_types) < 2) && Configure::read('job.is_enable_online'))) { $class='js-online-jobs';} else {$class='';}
	echo $this->Form->create('Job', array('class' => 'form-horizontal top-space top-mspace normal js-upload js-upload-form {is_required:"true"} js-add-map-dynm '.$class, 'enctype' => 'multipart/form-data')); ?>

	<?php if(!empty($this->request->params['named']['request_id']) || !empty($this->request->data['Job']['request_id'])): ?>
	<fieldset class="form-block round-5">
		<div class="alert alert-warning">
			<?php echo __l('Create a').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('for').' "'.$request['Request']['name']."\"";?>
		</div>
    <?php endif; ?>
<?php }else{ ?>
		<?php echo $this->Form->create('Job', array('class' => 'normal form-horizontal', 'enctype' => 'multipart/form-data')); ?>
		<h2><?php echo __l('What are you willing to do for').' '.$this->Html->siteJobAmount('or').'?';?></h2>
	<?php } ?>
	<?php
		if($this->request->params['controller'] == 'jobs' && $this->request->params['action'] == 'add'): ?>		
		<div class="js-validation-part">
		<div class="<?php echo ((count($job_types) < 2) ? "hide" : '') ;?>">
			<fieldset>
				<legend><?php echo jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Type');?></legend>
				<div class="input radio required">
				<?php echo $this->Form->input('job_type_id', array('class' => 'js-radio-select {"model":"Job"} hor-space', 'legend' => false, 'before' => '<span class="hor-space label-content">'.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps).' '.__l('Type') .'</span>', 'type' => 'radio','options'=>$job_types,'div'=>false)); ?>
				</div>
				<div class="page-information clearfix info">
				<p> <?php echo __l('Online:'); ?> <?php echo $job_type_descriptions['1'];?>   </p>
				<p> <?php echo __l('Offline:'); ?> <?php echo $job_type_descriptions['2'];?>   </p>
				</div>
			</fieldset>
		</div>
        <br />        
		<fieldset>
			<legend><?php echo __l('General');?></legend>
			<div class="jobs-edit-block clearfix">
			<div class="clearfix">
						
							<?php
								if(count($amounts) > 1):
									if(Configure::read('site.currency_symbol_place') == 'left'):
										$currecncy_place = 'before';
									else:
										$currecncy_place = 'after';
									endif;									
									echo $this->Form->input('title',array('class' => 'js-job-title', 'after'=>' '.__l('for'))).$this->Form->input('amount',array('options' => $amounts,'label' => false, $currecncy_place =>'<span class="ver-space inline ">'. Configure::read('site.currency') .'</span>'));
								else: ?>
                             
								<?php
									echo $this->Form->input('title',array('class' => 'js-job-title','after'=>' for '.$this->Html->siteCurrencyFormat(Configure::read('job.price'))));									
                                    ?>
                                 
                                <?php	echo $this->Form->hidden('amount',array('value' => Configure::read('job.price')));
								endif;
							?>
							<span class = 'character-info info'>
						<?php echo __l('You have').' ';?><span id="js-job-title-count"></span><?php echo ' '.__l('characters left');?>
					</span>
						</div>	
					
					</div>
				<?php   echo $this->Form->input('request_id',array('type'=>'hidden')); ?> 	
                <div class="js-category-listing">
				<?php	echo $this->Form->input('job_category_id', array('label' => jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps).' '.__l('Category'), 'info' => __l('Choose a category that best matches your').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('to ensure successful review by our moderators'), 'empty' => __l('Please Select')));
				?>
                <span class="js-select_category hide"> <?php echo json_encode($jobCategoriesClass); ?></span>
                </div>
                <?php
					if($this->Auth->user('role_id') == ConstUserTypes::Admin):
						echo $this->Form->input('user_id');
					endif;
				?>
				<?php
					echo $this->Form->input('description', array('label' => __l('Description'), 'class' => 'js-job-description','info' => '<span class="character-info">'.__l('You have').' '.'
					<span id="js-job-description-title-count"></span>'.' '.__l('characters left').'
				</span>'.__l('Be as descriptive as possible. Provide samples, what is required, what you will and will not do.').'<br/>'.' '.__l('Define the extents of this').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('- how many units, revisions, samples are included')));
				?>
				
				<?php
					echo $this->Form->input('no_of_days', array('label' => __l('No of Days'), 'info' => __l('You should give the number of days between minimum of').' '.Configure::read('job.min_days').' '.__l('day(s) and maximum of').' '.Configure::read('job.max_days').' '.__l('day(s)').'<br />'.__l('The longest time it will take you to complete your work Consider: time to accept the order, timezone differences, the free time you have for this work and correspondence with your buyers Late deliveries are the #1 reason for order cancellations')));
					echo $this->Form->input('tag', array('label' => __l('Tags'), 'info' => __l('Enter keywords that best describe your').' '.__l(jobAlternateName(ConstJobAlternateName::Singular)).__l('.').'  '.__l('Comma separated tags.').'<br/>'.__l('Example').': "'.__l('social').', '.__l('marketing').', '.__l('stickers').', '.__l('promotion').'"'));
					echo $this->Form->input('instruction_to_buyer', array('label' => __l('Instruction to Buyer')));
					echo $this->Form->input('is_instruction_requires_attachment', array('label' => __l('Does the above instruction requires an attachment from buyer?'), 'info' => __l('When this option is checked, the buyer will be prompted with attachment field when ordering the').' '.__l(jobAlternateName(ConstJobAlternateName::Singular)).__l('.')));
					echo $this->Form->input('is_instruction_requires_input', array('label' => __l('Does the above instruction requires an input from buyer?'), 'info' => __l('When this option is checked, the buyer will be prompted with textarea when ordering the').' '.__l(jobAlternateName(ConstJobAlternateName::Singular)).__l('.')));
			?>
            <div id='js-required-class' class="<?php echo (!empty($this->request->data['Job']['job_type_id']) && $this->request->data['Job']['job_type_id'] == ConstJobType::Offline) ? "required" : ""; ?>">
            <?php					
					echo $this->Form->input('address', array('label' => __l('Address'),'id' => 'JobAddress'));
			?>
            </div>
			</fieldset>
            <?php  
				$class = 'hide';
			if(isset($this->request->data['Job']['job_type_id']) && $this->request->data['Job']['job_type_id'] == ConstJobType::Offline)
					$class= 'show';
			?>
			<div class="js-job-service <?php echo $class; ?>">
			<fieldset>
				<legend><?php echo __l('Offline Additional Information');?></legend>				
                    <?php
						echo $this->Form->input('job_service_location_id',array('class' => 'js-service','legend' => false, 'before' => '<span class="label-content show pull-left">'. __l('Who needs to travel?') .'</span><div class="span no-mar"><div class="clearfix span19">', 'type' => 'radio', 'after' => '</div></div>', 'separator' => '</div><div class="clearfix span19">', 'options' => $job_service_locations));
					?>					
				  <?php
					echo $this->Form->input('mobile', array('label' => __l('Mobile')));
				  ?>
                <?php  
				$classes = 'hide';
				if(isset($this->request->data['Job']['job_service_location_id']) && $this->request->data['Job']['job_service_location_id'] == ConstServiceLocation::SellerToBuyer)
					$classes= '';
				?>
                  <div class="js-buyer-seller <?php echo $classes; ?>">
				  <div class="clearfix coverage">
                  <?php
					echo $this->Form->input('job_coverage_radius', array('label' => jobAlternateName(ConstJobAlternateName::Singular ,ConstJobAlternateName::FirstLeterCaps).' '.__l('Coverage Radius'), 'value' =>Configure::read('job.job_coverage_radius_units')));
					echo $this->Form->input('job_coverage_radius_unit_id', array('label' => false, 'div' => 'input select left-mspace','options' => $job_coverage_radius_units));
				  ?>
				  </div>
				  <span class="info"><?php echo __l('The distance from above address,  your service will be covered.')?></span>
                  </div>
                  	</fieldset>
            </div>
                  <?php	
			echo $this->Form->input('latitude', array('id' => 'JobLatitude', 'type' => 'hidden'));
			echo $this->Form->input('longitude', array('id' => 'JobLongitude', 'type' => 'hidden'));
			echo $this->Form->input('zoom_level', array('id' => 'JobZoomLevel', 'type' => 'hidden'));
					
				?>

		
			</div>
			<div class="bot-mspace bot-space">
				<fieldset>
				<legend><?php echo __l('Map');?></legend>	
				<div class="show-map" style="">				
					<div id="js-map-container"></div>
				</div>
				</fieldset>
			</div>
			<fieldset>
				<legend><?php echo __l('Photos &amp; video');?></legend>
			<div class="input file required">
            <label for="AttachmentFilename">
            <?php echo jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps).' '.__l('Images'); ?>
            </label>
            <span class="space hor-mspace">
			  <span class="btn btn-success fileinput-button"> <span>
              <?php  echo __l('Add files...'); 
			  $allowedExt = implode(', ', Configure::read('photo.file.allowedExt'));?>
              </span>
			  <input id="AttachmentFilename" class="fileUpload" type="file" multiple="multiple" name="data[Attachment][filename][]">
			    <?php //echo $this->Form->input('Attachment.filename', array('type' => 'file', 'label' => false, 'div' => false, 'class' => 'fileUpload', 'multiple' => 'multiple')); ?>
              </span>
			</span>
			<p class="info"><?php echo __l("Do not use images already in use by other").' '.jobAlternateName(ConstJobAlternateName::Plural).' '.__l("Image must be descriptive and relevant to your work. Real work sample images sell many times more then others. Never use other seller's images.");?></p><p class="info no-mar"><?php echo sprintf(__l('File type can be %s.'), implode(', ', Configure::read('photo.file.allowedExt')));?></p>
          </div>
          <?php
			echo $this->Form->input('fileType', array('type' => 'hidden', 'id' =>'allowedFileType', 'data-allowed-extensions' => $allowedExt));
			/*if(isPluginEnabled('SocialMarketing')) {
				echo $this->Form->input('success_redirect_url', array('type' => 'hidden', 'id' => 'success_redirect_url', 'value' => Router::url(array('controller' => 'social_marketings', 'action' => 'publish', 'type'=>'facebook', 'from' => 'job', 'publish_action' => 'add', 'admin' => false),true)));
			} else { */
				echo $this->Form->input('success_redirect_url', array('type' => 'hidden', 'id' => 'success_redirect_url', 'value' => Router::url(array('controller' => 'jobs', 'action' => 'index', 'type' => 'manage_jobs', 'from' => 'add_form', 'admin' => false), true)));
//			}
			echo $this->Form->input('current_url', array('type' => 'hidden', 'id' => 'current_url', 'value' => $this->here));
		  ?>
          <!-- The table listing the files available for upload/download -->
          <div class="time-desc datepicker-container clearfix">
            <table role="presentation" class="table table-striped">
              <tbody class="files">
              </tbody>
            </table>
            <!-- The template to display files available for upload -->
            <script id="template-upload" type="text/x-tmpl">
			{% for (var i=0, file; file=o.files[i]; i++) { %}
				<tr class="template-upload fade">
					<td>
						<span class="preview"></span>
					</td>
					<td>
						<p class="name">{%=file.name%}</p>
						{% if (file.error) { %}
							<div><span class="label label-danger">Error</span> {%=file.error%}</div>
						{% } %}
					</td>
					<td>
						<p class="size">{%=o.formatFileSize(file.size)%}</p>
						{% if (!o.files.error) { %}
							<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar bar-success" style="width:0%;"></div></div>
						{% } %}
					</td>
					<td>
						{% if (!o.files.error && !i && !o.options.autoUpload) { %}
							<button class="btn btn-primary start hide">
								<span>Start</span>
							</button>
						{% } %}
						{% if (!i) { %}
							<button class="btn btn-warning cancel js-upload-cancel">
								<span>Cancel</span>
							</button>
						{% } %}
					</td>
				</tr>
			{% } %}
			</script>
			<!-- The template to display files available for download -->
			<script id="template-download" type="text/x-tmpl">
			{% for (var i=0, file; file=o.files[i]; i++) { %}
				<tr class="template-download fade">
					<td>
						<span class="preview">
							{% if (file.thumbnailUrl) { %}
								<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
							{% } %}
						</span>
					</td>
					<td>
						<p class="name">
							{% if (file.url) { %}
								<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
							{% } else { %}
								<span>{%=file.name%}</span>
							{% } %}
						</p>
						{% if (file.error) { %}
							<div><span class="label label-danger">Error</span> {%=file.error%}</div>
						{% } %}
					</td>
					<td>
						<span class="size">{%=o.formatFileSize(file.size)%}</span>
					</td>
					<td>
						{% if (file.deleteUrl) { %}
							<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
								<i class="glyphicon glyphicon-trash"></i>
								<span>Delete</span>
							</button>
						{% } else { %}
							<button class="btn btn-warning cancel js-upload-cancel">
								<span>Cancel</span>
							</button>
						{% } %}
					</td>
				</tr>
			{% } %}
			</script>
          </div>

		  <?php
						echo $this->Form->input('youtube_url', array('label' => __l('Intro Video URL'), 'info' => 'e.g., http://www.youtube.com/watch?v=xxxx;. Don\'t use short URL'));
						echo $this->Form->input('flickr_url', array('label' => __l('Flickr URL')));
					
					if($this->Auth->user('role_id') == ConstUserTypes::Admin):
							echo $this->Form->input('is_featured',  array('label' => __l('Feature')));
						endif;
					?>
			</fieldset>



				<div class="submit-block well no-bor no-round dr clearfix">
					<div class="fileupload-buttonbar submit">
						<button class="btn btn-large btn-warning textb text-20 start" type="submit"><span><?php echo __l('Add'); ?></span></button>
					</div>
				</div>
		<?php if(!empty($this->request->params['named']['request_id']) || !empty($this->request->data['Job']['request_id'])): ?>
		</fieldset>
			<?php endif; ?>
		<?php
		else:
			echo $this->Form->input('r',array('type'=>'hidden','value'=>$this->request->params['url']['url'])); ?>
			<div class="jobs-index-block clearfix">
			 <span class="jobs-wiil"><?php echo __l('Title').' ';?></span>
			 <div class="clearfix jobs-index-right-block">
			<?php
				$amount = explode(',', Configure::read('job.price'));
				
				$amount = array_combine($amount, $amount);
				if(Configure::read('site.currency_symbol_place') == 'left'):
					$currecncy_place = 'before';
				else:
					$currecncy_place = 'after';
				endif;									
				if(count($amount) > 1):
					echo $this->Form->input('title',array('class' => 'js-job-title', 'label' => false,'after'=>__l(' for '))).$this->Form->input('amount',array('options' => $amount,'label' => false, $currecncy_place => Configure::read('site.currency')));
				else:
					echo $this->Form->input('title',array('class' => 'js-job-title', 'label' => false,'after'=> __l(' for ').$this->Html->siteCurrencyFormat(Configure::read('job.price'))));
					echo $this->Form->hidden('amount',array('value' => Configure::read('job.price')));
				endif;
					
			?>
		
            <div class="submit-block clearfix">
				<?php echo $this->Form->submit(__l('Continue'));?>
			</div>
			</div>
				</div>
		<?php endif;?>
    <?php echo $this->Form->end();?>
</div>
<?php } ?>
</div>
</section>
<?php } ?>