<?php /* SVN: $Id: $ */ ?>
<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin && !empty($this->request->prefix)) { ?>
<ul class="breadcrumb no-round top-mspace ver-space bot-mspace">
  <li class="left-space"><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'stats'), array('class' => 'bluec','title'=>__l('DashBoard'))); ?> <span class="divider graydarkerc ">/</span></li>
  <li><?php echo $this->Html->link(__l(jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps)), array('controller' => 'jobs', 'action' => 'index'), array('class' => 'bluec', 'escape' => false, 'title'=> __l(jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps)))); ?> <span class="divider graydarkerc ">/</span></li>	  
  <li class="active graydarkerc"><?php echo __l('Edit ').jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps);?></li>      
</ul>
<?php } ?>    
<?php if(empty($job_types)){ ?>
<div class="space">
  <p class="alert alert-info clearfix container"><?php echo sprintf(__l('Problem in edit a %s. %s to contact administrator.'), Configure::read('job.job_alternate_name'), $this->Html->link(__l('Click here'), Router::url('/', true).'contactus', array('escape' => false)));?></p>
</div>
<?php } else { ?>
<section class="row bot-mspace bot-space">
  <div class="sep-bot bot-mspace">
    <h2 class="<?php echo empty($this->request->prefix)?'container':'';?> textb text-32 bot-space mob-dc"><?php echo __l('Edit').' '.jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps);?></h2>
  </div>
  <div class="<?php echo empty($this->request->prefix)?'container':'';?> top-space clearfix">          
    <div class="jobs form js-responses"><?php 
		$upload_class = (empty($has_active_order))? 'js-upload' : '';
		echo $this->Form->create('Job', array('class' => 'normal form-horizontal top-space top-mspace js-add-map  js-upload-form {is_required:"false"} ' . $upload_class, 'enctype' => 'multipart/form-data')); ?>
	  <div class="js-validation-part bot-mspace"><?php        
			echo $this->Form->input('id'); 
			if(empty($has_active_order)): ?>
	    <div class="<?php echo ((count($job_types) < 2) ? "hide" : '') ;?>">        
		  <fieldset>
		    <legend><?php echo __l(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)).' '.__l('Type');?></legend><?php 
				echo $this->Form->input('job_type_id', array('class' => 'js-radio-select {"model":"Job"}', 'legend' => false, 'before' => '<span class="label-content">'.__l(jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps)).' '.__l('Type') .'</span>', 'type' => 'radio', 'options' => $job_types)); ?>
			<div class="page-information clearfix info">
			  <p> <?php echo __l('Online:'); ?> <?php echo $job_type_descriptions['1'];?></p>
			  <p> <?php echo __l('Offline:'); ?> <?php echo $job_type_descriptions['2'];?></p>
			</div>
		  </fieldset>
		</div>
        <fieldset>
		  <legend><?php echo __l('General');?></legend>
		  <div class="jobs-edit-block clearfix">
		    <div class="clearfix"><?php
					if(Configure::read('site.currency_symbol_place') == 'left'):
						$currecncy_place = 'before';
					else:
						$currecncy_place = 'after';
					endif;	
					if(count($amounts) > 1):
						echo $this->Form->input('title',array('class' => 'js-job-title')).$this->Form->input('amount',array('options' => $amounts,'label' => false,  $currecncy_place => Configure::read('site.currency')));
					else:
						echo $this->Form->input('title',array('class' => 'js-job-title',$this->Html->siteCurrencyFormat($this->request->data['Job']['amount'])));									
						echo $this->Form->hidden('amount');
					endif;
				?>
			  <span class = 'character-info info'>
				<?php echo __l('You have').' ';?><span id="js-job-title-count"></span><?php echo ' '.__l('characters left');?>
			  </span>
			</div>
	      </div>
		  <div class="js-category-listing"><?php	
			echo $this->Form->input('job_category_id', array('label' => jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps).' '.__l('Category'), 'info' => __l('Choose a category that best matches your').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('to ensure successful review by our moderators'), 'empty' => __l('Please Select'))); ?> 
			<span class="js-select_category hide"> <?php echo json_encode($jobCategoriesClass); ?></span>
          </div><?php 
				if($this->Auth->user('role_id') == ConstUserTypes::Admin):
					echo $this->Form->input('user_id');
				endif;
				echo $this->Form->input('description', array('label' => __l('Description'), 'class' => 'js-job-description','info' => '<span class="character-info">'.__l('You have').' '.'
					<span id="js-job-description-title-count"></span>'.' '.__l('characters left').'
				</span>'.__l('Be as descriptive as possible. Provide samples, what is required, what you will and will not do. <br/> Define the extents of this').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l(' - how many units, revisions, samples are included')));
				echo $this->Form->input('no_of_days', array('label' => __l('No of days'), 'info' => __l('You should give the number of days between minimum of').' '.Configure::read('job.min_days').' '.__l('day(s) and maximum of').' '.Configure::read('job.max_days').' '.__l('day(s)').'<br />'.__l('The longest time it will take you to complete your work Consider: time to accept the order, timezone differences, the free time you have for this work and correspondence with your buyers Late deliveries are the #1 reason for order cancellations')));
				echo $this->Form->input('tag', array('label' => __l('Tags'), 'info' => __l('Enter keywords that best describe your').' '.__l(jobAlternateName(ConstJobAlternateName::Singular)).__l('.').'  '.__l('Comma separated tags.').'<br/>'.__l('Example').': "'.__l('social').', '.__l('marketing').', '.__l('stickers').', '.__l('promotion').'"'));
				echo $this->Form->input('instruction_to_buyer', array('label' => __l('Instruction to Buyer')));
				echo $this->Form->input('is_instruction_requires_attachment', array('label' => __l('Does the above instruction requires an attachment from buyer?'), 'info' => __l('When this option is checked, the buyer will be prompted with attachment field when ordering the').' '.__l(jobAlternateName(ConstJobAlternateName::Singular)).__l('.')));
			    echo $this->Form->input('is_instruction_requires_input', array('label' => __l('Does the above instruction requires an input from buyer?'), 'info' => __l('When this option is checked, the buyer will be prompted with textarea when ordering the').' '.__l(jobAlternateName(ConstJobAlternateName::Singular)).__l('.')));
				?>
          <div id='js-required-class' class="<?php echo (!empty($this->request->data['Job']['job_type_id']) && $this->request->data['Job']['job_type_id'] == ConstJobType::Offline) ? "required" : ""; ?>"><?php
				echo $this->Form->input('address', array('label' => __l('Address'), 'id' => 'JobAddress')); ?>
          </div>
        </fieldset>
        	<?php
				$class = 'hide';
				if(isset($this->request->data['Job']['job_type_id']) && $this->request->data['Job']['job_type_id'] == ConstJobType::Offline)
					$class= '';
			?>
		  <div class="js-job-service <?php echo $class; ?>">
		    <fieldset>
			  <legend><?php echo __l('Offline Additional Information');?></legend><?php
				echo $this->Form->input('job_service_location_id',array('class' => 'js-service','legend' => false,  'before' => '<span class="label-content">'. __l('Who needs to travel?') .'</span>', 'type' => 'radio', 'options' => $job_service_locations)); ?>
	            <div class="page-information clearfix">
				  <p><?php echo __l('Buyer:'); ?> <?php echo $job_service_location_desc['1'];?></p>
				  <p><?php echo __l('Seller:'); ?> <?php echo $job_service_location_desc['2'];?></p>
				</div><?php
					echo $this->Form->input('mobile', array('label' => __l('Mobile')));
					$classes = 'hide';
					if(isset($this->request->data['Job']['job_service_location_id']) && $this->request->data['Job']['job_service_location_id'] == ConstServiceLocation::SellerToBuyer)
					$classes= ''; ?>
                <div class="js-buyer-seller <?php echo $classes; ?>">
                  <div class="clearfix coverage"><?php
                    echo $this->Form->input('job_coverage_radius', array('label' => jobAlternateName(ConstJobAlternateName::Singular ,ConstJobAlternateName::FirstLeterCaps).' '.__l('Coverage Radius')));
					echo $this->Form->input('job_coverage_radius_unit_id', array('label' => false,'div'=>'input select hor-space'));
                    ?>
				  </div>
                  <span class="info"><?php echo __l('The distance from above address,  your service will be covered.')?></span>
                </div><?php
                	echo $this->Form->input('latitude', array('type' => 'hidden'));
					echo $this->Form->input('longitude', array('type' => 'hidden'));
					echo $this->Form->input('zoom_level', array('type' => 'hidden'));
				?>
			</fieldset>
          </div>
          <div class="bot-mspace bot-space">
		    <fieldset>
			  <legend><?php echo __l('Map');?></legend>	
			  <div class="show-map" style="">				
			    <div id="js-map-container"></div>
			  </div>
			</fieldset>
		  </div><?php
        	else: ?>
		  <p class="jobs-notice-info"><?php 
			echo __l('The').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('can not be modified because it has open orders. You will be able to edit your').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('once these orders are complete. You can also contact').' '.'<span>'.Configure::read('site.admin_email') .' </span>'.' '.__l('with the information you wish to edit.');?>
		  </p><?php
				echo $this->Form->input('no_of_days', array('label' => __l('No of days')));
	    	endif; ?>
    </div>
    <div class="top-mspace clearfix">
      <fieldset>
		<?php
		if(empty($has_active_order)):
			if(!empty($this->request->data['Attachment'])):
		?>
	    <legend><?php echo __l('Manage Photos &amp; video');?></legend>
        <div class="clearfix attachment-delete-outer-block ">
		  <ul class="unstyled">
			<?php foreach($this->request->data['Attachment'] as $attachment){ ?>
				<li class="span">
				<div class="attachment-delete-block">
	              <span class="delete-photo hide"> <?php echo __l('Delete Photo'); ?></span>

                <?php
				 echo $this->Form->input('OldAttachment.'.$attachment['id'].'.id', array('type' => 'checkbox', 'class'=>'js-job-photo-checkbox','id' => "job_checkbox_".$attachment['id'], 'label' => '','div'=>'input checkbox no-mar pull-left'));
					echo $this->Html->showImage('Job', $attachment, array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($this->request->data['Job']['title'], false)), 'title' => $this->Html->cText($this->request->data['Job']['title'], false)));
                ?>
                </div>
				</li>
			<?php } ?>
		  </ul>
        </div><?php
        endif; ?>
        <div class="input file top-mspace">
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
			<p class="info"><?php echo __l("Do not use images already used in other").' '.jobAlternateName(ConstJobAlternateName::Plural).'.  '.__l("Image must be descriptive and relevant to your work. Real work sample images sell many times more then others. Never use other seller's images");?></p><p class="info no-mar"><?php echo sprintf(__l('File type can be %s.'), implode(', ', Configure::read('photo.file.allowedExt')));?></p>
        </div><?php
			echo $this->Form->input('fileType', array('type' => 'hidden', 'id' =>'allowedFileType', 'data-allowed-extensions' => $allowedExt));
			/*if(isPluginEnabled('SocialMarketing')) {
				echo $this->Form->input('success_redirect_url', array('type' => 'hidden', 'id' => 'success_redirect_url', 'value' => Router::url(array('controller' => 'social_marketings', 'action' => 'publish', 'type'=>'facebook', 'from' => 'job', 'publish_action' => 'add', 'admin' => false),true)));
			} else { */
				echo $this->Form->input('success_redirect_url', array('type' => 'hidden', 'id' => 'success_redirect_url', 'value' => Router::url(array('controller' => 'jobs', 'action' => 'index', 'type' => 'manage_jobs', 'admin' => false), true)));
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
            ?>
            <p class="info"><?php echo __l("");?></p>
			<?php echo $this->Form->input('flickr_url', array('label' => __l('Flickr URL')));
		endif;
		if($this->Auth->user('role_id') == ConstUserTypes::Admin):
			echo $this->Form->input('is_active',  array('label' => __l('Active') ,'info' => __l('Unchecking this option will make this').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('inaccessible to users. Only the').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('owner can view this').' '.jobAlternateName(ConstJobAlternateName::Plural).'.'));
			echo $this->Form->input('is_featured',  array('label' => __l('Feature')));
			echo $this->Form->input('is_approved',  array('label' => __l('Approved?')));
		endif;

	?>
    </fieldset>
</div>
	<div class="fileupload-buttonbar submit-block well no-bor no-round dr clearfix">
		<?php echo $this->Form->submit(__l('Save'), array('id' => 'js-job-add-submit', 'class' => 'btn btn-large btn-warning textb js-fileupload-enable  text-20'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
</div>
</section>
<?php } ?>