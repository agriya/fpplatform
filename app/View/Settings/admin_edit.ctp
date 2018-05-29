<div class="js-response js-responses js-clone">
<?php if (!empty($setting_categories['SettingCategory']['description'])):?>
	<div class="alert alert-info clearfix"><?php 
	if(stristr($setting_categories['SettingCategory']['description'], '##PAYMENT_SETTINGS_URL##') === FALSE) {
		echo $setting_categories['SettingCategory']['description'];
	} else {
		echo $category_description = str_replace('##PAYMENT_SETTINGS_URL##',Router::url('/', true).'admin/payment_gateways',$setting_categories['SettingCategory']['description']);
	}	
	
	?> 
    </div>
<?php endif;?>

<?php 
	if (!empty($settings)):
		if(!empty($this->request->data['Setting']['setting_category_id'])) {
			echo $this->Form->create('Setting', array('url'=>array('controller'=>'settings','action' => 'edit',$this->request->data['Setting']['setting_category_id']), 'class' => 'form-horizontal setting-add-form add-live-form'));
		} else {
			echo $this->Form->create('Setting', array('action' => 'edit', 'class' => 'form-horizontal setting-add-form add-live-form'));
	    }
		echo $this->Form->input('setting_category_id', array('label' => __l('Setting Category'),'type' => 'hidden'));
		if (!empty($plugin_name)) {
				echo $this->Form->input('plugin_name', array('label' => __l('Plugin Name'),'type' => 'hidden', 'value'=>$plugin_name));
			}
		// hack to delete the thumb folder in img directory
		$inputDisplay = 0;
		$is_changed = $prev_cat_id = 0;
    	foreach ($settings as $skey=>$setting):
				if($setting['Setting']['name'] == 'site.language'):
					$empty_language = 0;
					$get_language_options = $this->Html->getLanguage();
					if(!empty($get_language_options)):
						$options['options'] = $get_language_options;
					else:
						$empty_language = 1;
					endif;
				endif;
				$field_name = explode('.', $setting['Setting']['name']);
				if(isset($field_name[2]) && ($field_name[2] == 'is_not_allow_resize_beyond_original_size' || $field_name[2] == 'is_handle_aspect')){
					continue;
				}                
                if ($setting['Setting']['id'] == 332) {
                        $find_Replace = array(
                            '##TEST_CONNECTION##' => $this->Html->link(__l('Test Connection'), array('controller' => 'high_performances', 'action' => 'check_s3_connection', '?f=' . $this->request->url))
                        );
                        $setting['Setting']['description'] = strtr($setting['Setting']['description'], $find_Replace);
                    }
				$options['type'] = $setting['Setting']['type'];
				$options['value'] = $setting['Setting']['value'];
				$options['div'] = array('id' => "setting-{$setting['Setting']['name']}");
				if($options['type'] == 'checkbox' && $options['value']):
					$options['checked'] = 'checked';
				endif;
				if($options['type'] == 'select'):
					$selectOptions = explode(',', $setting['Setting']['options']);
					$setting['Setting']['options'] = array();
					if(!empty($selectOptions)):
						foreach($selectOptions as $key => $value):
							if(!empty($value)):
								$setting['Setting']['options'][trim($value)] = trim($value);
							endif;
						endforeach;
					endif;
					$options['options'] = $setting['Setting']['options'];
				elseif ($options['type'] == 'radio'):
						$selectOptions = explode(',', $setting['Setting']['options']);
						$setting['Setting']['options'] = array();
						$options['legend'] = false;
						if (!empty($selectOptions)):
							foreach ($selectOptions as $key => $value):
								if (!empty($value)):
									$setting['Setting']['options'][trim($value)] = trim($value);
								endif;
							endforeach;
						endif;
						$options['options'] = $setting['Setting']['options'];
				endif;	
				?>
				<?php
					if(empty($prev_cat_id)){
						$prev_cat_id = $setting['SettingCategory']['id'];
						$is_changed = 1;
					} else {
						$is_changed = 0;
						if($setting_categories['SettingCategory']['id'] != 46 && $setting['SettingCategory']['id'] != $prev_cat_id ){ ?>
							</fieldset>
						<?php
							$is_changed = 1;
							$prev_cat_id  = $setting['SettingCategory']['id'];	
						}				
					}
				?>
				<?php
					if(!empty($is_changed)):
						 if($setting_categories['SettingCategory']['id'] != 12) :
						 //if($skey!=0){ echo '</div></div>';}
					?>
                    
					<div class="clearfix  row-fluid">                    
					<div class="<?php echo (in_array( $setting['SettingCategory']['id'], array(81,82,83,84,88))) ? 'span24' : '' ;?>">
					<fieldset  class="form-block check-align">
						<?php if (!empty($setting['SettingCategory']['name'])){ ?><legend> <span id="<?php echo str_replace(' ','',$setting['SettingCategory']['name']); ?>"> <?php echo $setting['SettingCategory']['name']; ?></span></legend><?php } ?>
                        <?php if($setting['SettingCategory']['name'] == 'Commission'): ?>
					<div class="dr clearfix no-pad">
						<?php echo $this->Html->link('<i class="icon-cog text-16"></i> <span>'.__l('Commission Settings').'</span>', array('controller' =>'affiliate_types', 'action' => 'edit'), array('title' => __l('Here you can update and modify affiliate types'),'escape'=>false, 'class' => 'blackc')); ?>
					</div>
				<?php endif; ?>
					<?php if (!empty($setting['SettingCategory']['description']) && $setting_categories['SettingCategory']['id'] != 46):?>
						<div class="alert alert-info clearfix"><?php						
							$findReplace = array(
								'##TRANSLATIONADD##' => $this->Html->link(Router::url('/', true).'admin/translations/add', Router::url('/', true).'/admin/translations/add', array('title' => __l('Translations add'))),
                                '##CATPCHA_CONF##' => $this->Html->link($captcha_conf_link . '#CAPTCHA',$captcha_conf_link . '#CAPTCHA'),
								'##APPLICATION_KEY##' => $this->Html->link($appliation_key_link . '#SolveMedia',$appliation_key_link . '#SolveMedia'),
								'##DEMO_URL##' => $this->Html->link('http://dev1products.dev.agriya.com/doku.php?id=fpplatformultraplus-install#how_to','http://dev1products.dev.agriya.com/doku.php?id=fpplatformultraplus-install#how_to', array('target' => '_blank')),
							);
													
						 $setting['SettingCategory']['description'] = strtr($setting['SettingCategory']['description'], $findReplace);
						 echo $setting['SettingCategory']['description'];
						
						
						?> </div>
					<?php endif;?>
	
				<?php	
					endif;
					endif;
				?>
				<?php if(!empty($is_changed)): ?>
				
               
					<?php if ($setting['SettingCategory']['id'] == 27) { ?>
                        <div class="span10 well pull-right">
                        <h4><?php echo __l('Configuration steps:');?></h4> <br>
                        <?php echo __l('1. Sign in using your google account in <a target="blank" href="https://developers.google.com/speed/pagespeed/service">https://developers.google.com/speed/pagespeed/service</a>.'); ?><br/>
                        <?php echo __l('2. Click sign up now button and answer simple questions. Google will enable PageSpeed service within 2 hours.'); ?><br/>
                        <?php echo __l('3. You have to configure this service in this link <a target="blank" href="https://code.google.com/apis/console">https://code.google.com/apis/console</a>, please follow the steps mentioned in this link <a target="blank" href="https://developers.google.com/speed/pagespeed/service/setup">https://developers.google.com/speed/pagespeed/service/setup</a>'); ?>
                           </div> 
					<?php } elseif ($setting['SettingCategory']['id'] == 26) { ?>
					<div class="span10 well pull-right">
						<h4><?php echo __l('Configuration steps:'); ?></h4><br>
						<?php echo __l('1. Create a CloudFlare account, configure the domain and change DNS.'); ?><br>
						<?php echo __l('2. To create token please refer '); ?> <a target="blank" href="http://blog.cloudflare.com/2-factor-authentication-now-available">http://blog.cloudflare.com/2-factor-authentication-now-available</a><br>
						<?php echo __l('3. Create three page rules like /, /project/*, /user/* in this link'); ?> <a target="blank" href="https://www.cloudflare.com/page-rules?z=<?php echo $_SERVER["SERVER_NAME"]; ?>">https://www.cloudflare.com/page-rules?z=<?php echo $_SERVER["SERVER_NAME"]; ?></a><?php echo __l('. Note: Please select \'Cache Everything\' option for \'Custom Caching\' setting.'); ?><br>
						<?php echo __l('4. Update your CloudFlare Email and Token and enable CloudFlare option here.'); ?><br>
						<?php echo __l('5. Minimum cache timing for free users will be 30 minutes. Only enterprise users can reduce upto 30 seconds.'); ?>
						</div>
					<?php } elseif ($setting['SettingCategory']['id'] == 29) { ?>
					<div class="span10 well pull-right">
						<h4><?php echo __l('Configuration steps:');?></h4> <br>
						<?php echo __l('You can configure SMTP server by any one of the followings Amazon SES, Sendgrid, Mandrill, Gmail and your own host SMTP settings'); ?><br>
						<?php echo __l('1. Amazon SES: To get your security credentials, login with amazon and go to <a target="blank" href="https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials">https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials</a> . To create your smtp username password go to <a target="blank" href="https://console.aws.amazon.com/ses/home#smtp-settings">https://console.aws.amazon.com/ses/home#smtp-settings</a>'); ?><br>
						<?php echo __l('2. Sendgrid: To get your security credentials, refer <a target="blank" href="http://sendgrid.com/docs/Integrate/index.html">http://sendgrid.com/docs/Integrate/index.html</a>'); ?><br>
						<?php echo __l('3. Mandrill:  To get your security credentials, login with Mandrill and go to <a target="blank" href="https://mandrillapp.com/settings">https://mandrillapp.com/settings</a>'); ?><br>
						<?php echo __l('4. Gmail: To use gmail please refer <a target="blank" href="http://gmailsmtpsettings.com/gmail-smtp-settings">http://gmailsmtpsettings.com/gmail-smtp-settings</a>'); ?>
						</div>
					<?php } elseif ($setting['SettingCategory']['id'] == 28) { ?>
					<div class="span10 well pull-right">
						<h4><?php echo __l('Configuration steps:');?></h4> <br>
						<?php echo __l('1. Amazon CloudFront: To setup Amazon CloudFront CDN please follow the step mentioned in this <a target="blank" href="http://aws.amazon.com/console/#cf">http://aws.amazon.com/console/#cf</a> and watch this screencast <a href="http://d36cz9buwru1tt.cloudfront.net/videos/console/cloudfront_console_4.html" target="blank">http://d36cz9buwru1tt.cloudfront.net/videos/console/cloudfront_console_4.html</a>'); ?><br>
						<?php echo __l('2. CloudFlare: To setup CloudFlare please follow the step mentioned in this link <a href="https://support.cloudflare.com/entries/22054357-How-do-I-do-CNAME-setup-" target="blank">https://support.cloudflare.com/entries/22054357-How-do-I-do-CNAME-setup-</a>'); ?><br>
						</div>
					<?php } elseif ($setting['SettingCategory']['id'] == 47) { ?>
					<div class="span10 well pull-right">
						<h4><?php echo __l('Configuration steps:'); ?></h4><br>
                        <?php echo __l('1. To get your security credentials, login with amazon and go to <a target="blank" href="https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials">https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials</a><br>2. To create bucket name go to <a target="blank" href="https://console.aws.amazon.com/s3/home">https://console.aws.amazon.com/s3/home</a> and click s3 link.'); ?>
						</div>
					<?php } ?>
				
				<?php if(in_array($setting['SettingCategory']['id'], array(27,26,29,28,47))){ ?>
						<div class=" clearfix span13">
					<?php } else { ?>
						<div >
					<?php } ?>
				<?php endif;?>
				
<?php				if(in_array( $setting['Setting']['id'], array(122, 224, 176, 179, 185,288, 184, 335) ) ) : ?>
                        <h3>
                           <?php echo (in_array($setting['Setting']['id'], array(122, 176) ) )? __l('Application Info') : ''; ?>
                           <?php echo (in_array($setting['Setting']['id'], array('224', 179) ) )? __l('Credentials') : ''; ?>
                           <?php echo (in_array($setting['Setting']['id'], array('237', 185, 184) ) )? __l('Other Info') : ''; ?>
                        </h3>
						<?php if(in_array( $setting['Setting']['id'], array(224, 179))):?>
                            <div class="alert alert-info clearfix">
                                <?php 
                                    if($setting['Setting']['id'] == 224) : 
                                        echo __l('Here you can update Facebook credentials . Click \'Update Facebook Credentials\' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.');
                                    elseif($setting['Setting']['id'] == 179) :
                                        echo __l('Here you can update Twitter credentials like Access key and Accss Token. Click \'Update Twitter Credentials\' link below and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.');
                                    endif;
                                ?>
                            </div>
                        <?php endif;?>             
						<?php 
							if($setting['Setting']['id'] == 224) : ?>
							
							<div class="clearfix credentials-info-block">
							<div class="credentials-left">
						      	<div class="credentials-right pull-right">
        							<?php	echo $this->Html->link(__l('<span><i class="icon-facebook-sign googlec space text-16"></i>Update Facebook Credentials</span>'), array('controller' => 'settings', 'action' => 'update_credentials', 'type' => 'facebook'), array('escape'=>false,'class' => 'btn tp-credential js-tooltip', 'title' => __l('Here you can update Facebook credentials . Click this link and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.')));
                                    ?>
                                </div>
                            </div>
                            <div class="credentials-right-block">
                            <?php
                            elseif($setting['Setting']['id'] == 179) :
                            ?>
                            <div class="clearfix credentials-info-block">
                            <div class="credentials-left">
						      	<div class="credentials-right pull-right">
                                    <?php
                                    	echo $this->Html->link(__l('<span><i class="icon-twitter-sign googlec space text-16"></i>Update Twitter Credentials</span>'), array('controller' => 'settings', 'action' => 'update_credentials', 'type' => 'twitter'), array('escape'=>false,'class' => 'btn tp-credential js-tooltip', 'title' => __l('Here you can update Twitter credentials like Access key and Accss Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.')));
                                    ?>
                                </div>
                             </div>
                             <div class="credentials-right-block">
                             <?php
                            elseif($setting['Setting']['id'] == 288) :
                            ?>
                            <div class="clearfix credentials-info-block">
                            <div class="credentials-left">
						      	<div class="credentials-right pull-right">
                                    <?php echo $this->Html->link(__l('<span><i class="icon-google-sign googlec space text-16"></i>Update Google Analytics Credentials</span>'), array('controller' => 'settings', 'action' => 'update_credentials', 'type' => 'google'), array('class' => 'btn tp-credential js-tooltip', 'escape' => false, 'title' => __l('Here you can update Google Analytics credentials like Access Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and Consumer secret before you click this link.'))); ?>
                                </div>
                             </div>
							<?php  elseif($setting['Setting']['id'] == 335) : ?>
							<div class="clearfix bot-space">
								<?php echo $this->Html->link(__l('<span>Copy static contents to S3</span>'), array('controller' => 'high_performances', 'action' => 'copy_static_contents', '?f=' . $this->request->url), array('class' => 'js-connect js-confirm js-tooltip js-no-pjax btn', 'escape' => false, 'title' => __l('Clicking this button will copy static contents such as CSS, JavaScript, images files in <code>webroot</code> folder of this server to Amazon S3 and will enable them to be delivered from there.'))); ?>
							</div>
							
                            <?php							
                        	endif;
						?>
<?php 				endif; ?>                        
                
				<?php
					if($setting['Setting']['name'] == 'site.is_ssl_for_deal_buy_enabled' && !($ssl_enable)){
						$options['disabled'] = 'disabled';
					}
				?>
				<?php
				if($setting['Setting']['name'] == 'affiliate.commission_on_every_deal_purchase'):
				?>
					<div class="add-block affiliate-links">
					<?php
					echo $this->Html->link(__l('Commission Settings'), array('controller' =>'affiliate_types', 'action' => 'edit'), array('class' => 'affiliate-settings', 'title' => __l('Here you can update and modify affiliate types')));
					?>
					</div>
				<?php
				endif;
				?>
	
				<?php
					if($setting['Setting']['name'] == 'twitter.site_user_access_key' || $setting['Setting']['name'] == 'twitter.site_user_access_token' || $setting['Setting']['name'] == 'facebook.fb_access_token' || $setting['Setting']['name'] == 'facebook.fb_user_id' || $setting['Setting']['name'] == 'foursquare.site_user_fs_id' || $setting['Setting']['name'] == 'foursquare.site_user_access_token'):
					$options['readonly'] = TRUE;
					$options['class'] = 'disabled';		
					endif;				
					if($setting['Setting']['name'] == 'site.language'):
						$options['options'] = $this->Html->getLanguage();				
					endif;
					if($setting['Setting']['name'] == 'site.timezone_offset'):
						$options['options'] = $timezoneOptions;				
					endif;
					if($setting['Setting']['name'] == 'site.city'):
						$options['options'] = $cityOptions;
					endif;
					if($setting['Setting']['name'] == 'site.currency_id'):
						$options['options'] = $this->Html->getCurrencies();	
					endif;									
					$options['label'] = $setting['Setting']['label'];
									
					// if ($setting['Setting']['name'] == 'user.referral_deal_buy_time' || $setting['Setting']['name'] == 'user.referral_cookie_expire_time'):
					if(in_array($setting['Setting']['name'], array('user.referral_deal_buy_time', 'user.referral_cookie_expire_time', 'affiliate.referral_cookie_expire_time'))):
						$options['after'] = __l('hrs') . '<span class="info">' . $setting['Setting']['description'] . '</span>';
					endif;
					if( in_array( $setting['Setting']['name'], array('wallet.min_wallet_amount', 'wallet.max_wallet_amount', 'user.minimum_withdrawal_amount', 'user.maximum_withdrawal_amount', 'Project.urgent_fee', 'Project.featured_fee', 'affiliate.payment_threshold_for_threshold_limit_reach', 'Project.hidden_bid_fee', 'Project.private_project_fee', 'Project.job_listing_fee'))):
						$options['after'] = Configure::read('site.currency'). '<span class="info">' . $setting['Setting']['description'] . '</span>';
					endif;
					
					$findReplace = array(
								'##SITE_NAME##' => Configure::read('site.name'),
								'##MASTER_CURRENCY##' => $this->Html->link(Router::url('/', true).'admin/currencies', Router::url('/', true).'/admin/currencies', array('title' => __l('Currencies'))),
								'##USER_LOGIN##' => $this->Html->link(Router::url('/', true).'admin/user_logins', Router::url('/', true).'/admin/user_logins', array('title' => __l('User Logins'))),															
								'##REGISTER##' => $this->Html->link('registration', '#', array('title' => __l('registration'))),
					);
					$findReplace = array(
					'##ANALYTICS_IMAGE##' => Router::url('/', true).'img/google_analytics_example.gif',
				);	
                $findReplace = array(
					'##SITE_NAME##' => Configure::read('site.name'),
				);                
					$setting['Setting']['description'] = strtr($setting['Setting']['description'], $findReplace);
					if (!empty($setting['Setting']['description']) && empty($options['after'])):
						$options['help'] = "<i class='icon-info-sign'></i>"."{$setting['Setting']['description']}";
					endif;					
					//default account
					if($is_module){
						if(!in_array($setting['Setting']['id'], array(ConstModuleEnableFields::Affiliate, ConstModuleEnableFields::Friends) )){
							$options['class'] = 'js-disabled-inputs';
						}
						else{
							$options['class'] = 'js-disabled-inputs-active';						
						}
					}
					$is_submodule=empty($is_submodule)?'':$is_submodule;
					if($is_submodule){
						if(in_array($setting['Setting']['setting_category_id'], array(ConstSettingsSubCategory::Commission) )){
							if(!in_array($setting['Setting']['id'], array(ConstModuleEnableFields::Commission) )){
								$options['class'] = 'js-disabled-inputs';
							}
							else{
								$options['class'] = 'js-disabled-inputs-active';						
							}
							if(!$active_submodule && !in_array($setting['Setting']['id'], array(ConstModuleEnableFields::Commission) )){
								$options['disabled'] = 'disabled';
							}
						}	
					}
					if(in_array($setting['Setting']['name'], array('facebook.like_box_title','facebook.feeds_code_title','twitter.tweets_around_city_title'))): 
					if($setting['Setting']['name'] == 'facebook.like_box_title')
					{
						$count = 1;
					} 
					elseif($setting['Setting']['name'] == 'facebook.feeds_code_title')
					{
						$count = 2;
					}
					elseif($setting['Setting']['name'] == 'twitter.tweets_around_city_title')
					{
						$count = 3;
					}
					?>
					<fieldset  class="form-block">
					<h3><?php echo __l('Widget #'). $count;?></h3>
                    <?php
					endif;
					echo $this->Form->input("Setting.{$setting['Setting']['id']}.name", $options);
					if(in_array($setting['Setting']['name'], array('facebook.like_box','facebook.feeds_code','twitter.tweets_around_city'))): ?>
                    </fieldset>
                    <?php
					endif;
							   
					$inputDisplay = ($inputDisplay == 2) ? 0 : $inputDisplay;
					unset($options);
					if(in_array($setting['Setting']['id'], array(171) ) ) {
					?>
                        </div>
                        </div>
					<?php
					}
		endforeach;
		?> 
        </fieldset>
		</div></div>
		<?php
			if (!empty($beyondOriginals)) {
				echo $this->Form->input('not_allow_beyond_original', array('label' => __l('Not Allow Beyond Original'),'type' => 'select', 'multiple' => 'multiple', 'options' => $beyondOriginals));
			}
			if (!empty($aspects)) {
				echo $this->Form->input('allow_handle_aspect', array('label' => __l('Allow Handle Aspect'),'type' => 'select', 'multiple' => 'multiple', 'options' => $aspects));
			}
		?>
		<div class="clearfix">
			<?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-primary')); ?>
		</div>
	<?php echo $this->Form->end(); ?>
	<?php else: ?>
		<div class="errorc space text-16 notice dc"> <?php echo sprintf(__l('No %s available'), __l('Settings')); ?></div>
	<?php endif; ?>
</div>
