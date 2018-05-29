		<?php $class="";
            if(!empty($this->request->params['plugin']) && $this->request->params['plugin'] != 'extensions') { ?>
			 <div class="container-fluid"> <div class="alert"><?php echo $this->Html->cText(Inflector::humanize(ucfirst($this->request->params['plugin']))).__l(' plugin is currently enabled. You can disable it from ') . ' ' . $this->Html->link(__l('plugins'), array('controller' => 'extensions_plugins'), array('title' => __l('plugins'), 'class' => 'plugin'));  ?>.</div></div>
			<?php } ?>
			<?php 
            if (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && ((!empty($this->request->data['Setting']['setting_category_id'])) && ($this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Jobs || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Wallet || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Withdrawals || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Requests || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Disputes || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Affiliates || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::HighPerformance || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::SocialMarketing))) {
			  $enable_text = 'enabled';
              $disable_text = 'disable';
              if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Wallet) {
                // wallet
                if (!isPluginEnabled('Wallets')) {
                  $enable_text = 'disabled';
                  $disable_text = 'enable';
                }
                $plugin_name = 'Wallet';
              }
              if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Jobs) {
                // Contests
                if(!isPluginEnabled('Jobs')) {
                  $enable_text = 'disabled';
                  $disable_text = 'enable';
                }
                $plugin_name = 'Jobs';
              }
              if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Withdrawals) {
                // withdrawals
                if(!isPluginEnabled('Withdrawals')) {
                  $enable_text = 'disabled';
                  $disable_text = 'enable';
                }
              $plugin_name = 'Withdrawals';
              }
              if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Requests) {
                // withdrawals
                if(!isPluginEnabled('Requests')) {
                  $enable_text = 'disabled';
                  $disable_text = 'enable';
                }
              $plugin_name = 'Requests';
              }
              if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Disputes) {
                // withdrawals
                if(!isPluginEnabled('Disputes')) {
                  $enable_text = 'disabled';
                  $disable_text = 'enable';
                }
              $plugin_name = 'Disputes';
              }
              if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Affiliates) {
                // withdrawals
                if(!isPluginEnabled('Affiliates')) {
                  $enable_text = 'disabled';
                  $disable_text = 'enable';
                }
              $plugin_name = 'Affiliates';
              }
              if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::HighPerformance) {
                // withdrawals
                if(!isPluginEnabled('HighPerformance')) {
                  $enable_text = 'disabled';
                  $disable_text = 'enable';
                }
              $plugin_name = 'HighPerformance';
              }
              if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::SocialMarketing) {
                // withdrawals
                if(!isPluginEnabled('SocialMarketing')) {
                  $enable_text = 'disabled';
                  $disable_text = 'enable';
                }
              $plugin_name = 'SocialMarketing';
              }
			  ?>
			  <div class="container-fluid">
			  <div class="alert alert-info page-info plugins-info">

				<?php echo $this->Html->cText(Inflector::singularize(ucfirst($plugin_name))).__l(' plugin is currently '.$enable_text.'. You can '.$disable_text.' it from ') . ' ' . $this->Html->link(__l('plugins'), array('controller' => 'extensions_plugins'), array('title' => __l('plugins'), 'class' => 'plugin'));  ?>.
			  </div>
			  </div>
			<?php }	?>
		<?php if (($this->request->params['controller'] == 'users' && ($this->request->params['action'] == 'admin_stats' || $this->request->params['action'] == 'admin_demographic_stats'))) {?>
			<div class="container-fluid">
			  <?php  echo $content_for_layout; ?>
			</div>
			<?php } else {?>
			  <article id="user-dashboard">
			   <?php $user_menu = array('users','user_views', 'user_profiles',  'user_logins', 'messages', 'user_comments');
				$properties_menu=array('properties', 'property_views', 'property_favorites','property_flags','collections','property_users','property_feedbacks','property_user_feedbacks','property_user_disputes');
				$requests_menu = array('requests', 'request_views','request_favorites','request_flags');
				$payment_menu = array('payments', 'payment_gateways', 'transactions', 'user_cash_withdrawals','affiliate_cash_withdrawals');
				$partners_menu = array('affiliates', 'affiliate_requests',  'affiliate_cash_withdrawals', 'affiliate_types', 'affiliate_widget_sizes');
				$master_menu = array('currencies', 'email_templates','pages', 'transaction_types', 'translations', 'languages',  'banned_ips', 'cities', 'states', 'countries',  'user_educations', 'genders', 'user_employments', 'property_flag_categories', 'affiliate_widget_sizes', 'ips','cancellation_policies','request_flag_categories','room_types','property_types','holiday_types','bed_types','amenities','user_relationships','user_income_ranges','habits');
				$diagnostics_menu = array('search_logs');
                $currency_conversion_menu = array('currency_conversion_histories');
                $search_log_menu = array('search_logs');
                $devs_menu = array('devs');
				$class = "";
                if(in_array($this->request->params['controller'], $user_menu) && $this->request->params['action'] != 'admin_diagnostics') {
					$class = "icon-user";
				}elseif(in_array($this->request->params['controller'], $properties_menu)) {
					$class = "icon-building";
				}elseif(in_array($this->request->params['controller'], $requests_menu)) {
					$class = "icon-mail-reply-all";
				}elseif(in_array($this->request->params['controller'], $payment_menu)) {
					$class = "icon-usd";
				}  elseif(in_array($this->request->params['controller'], $partners_menu) && isPluginEnabled('Affiliates')) {
					$class = "icon-usd";
				} elseif(in_array($this->request->params['controller'], $master_menu)) {
					$class = "icon-align-justify";
				} elseif(in_array($this->request->params['controller'], $diagnostics_menu)) {
					$class = "diagnostics-title";
				}elseif(in_array($this->request->params['controller'], $currency_conversion_menu)) {
					$class = "icon-align-justify";
				}elseif(in_array($this->request->params['controller'], $search_log_menu)) {
					$class = "search-log-title";
				}elseif(in_array($this->request->params['controller'], $devs_menu)) {
    				$class = "dev-title";
				}elseif($this->request->params['controller'] == 'settings') {
					$class = "icon-cogs";				
				}elseif($this->request->params['controller'] == 'extensions_plugins') {
					$class = "icon-certificate";				
				} elseif($this->request->params['controller'] == 'subscriptions' && $this->request->params['action'] == 'admin_subscription_customise') {
					$class = "customize-subscriptions-title";
				} elseif($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_diagnostics') {
					$class = "diagnostics-title";
				} else {
                    $class = Configure::read('admin_heading_class');
                  }                  
                ?>
			  <div class="container-fluid clearfix">
				<div class="tabbable">
				  <div class="label label-info tab-head show no-round clearfix">
				  	<h4 class="ver-smspace textn whitec text-16 hor-space pull-left"> 
						<?php
						  if (!empty($pluginImage) && !empty($plugin_name)) {
							echo $pluginImage;
						  } else {
						?>
							<i class="<?php echo $class;?> no-bg yop-mspace"></i>
                        <?php }
						  if($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'index' || $this->request->params['controller'] == 'entry_flag_categories' && $this->request->params['action'] == 'index') {
							echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings')));
						  } elseif ($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'admin_edit') {
							if(!empty($setting_categories['SettingCategory'])) {
							  echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings'))) . ' &raquo; ' . $setting_categories['SettingCategory']['name'];
							}
							if(!$this->request->params['isAjax']):
								if(!empty($settings_category['SettingCategory']['name'])): echo $settings_category['SettingCategory']['name']; endif; 
							endif;  

						  } elseif (in_array( $this->request->params['controller'], $diagnostics_menu) || $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_logs') {
							echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics', 'admin' => true), array('title' => __l('Diagnostics'))) . ' &raquo; ' . $this->pageTitle;
						  } else {
							echo $this->Html->cText($this->pageTitle);
						  }?>                          
					</h4>
					<?php if (in_array($this->request->params['controller'], array('job_types', 'settings', 'payment_gateways', 'blocks', 'menus', 'links', 'extensions_themes', 'extensions_plugins'))) { ?>
						<span class="pull-right top-space hor-mspace whitec">
						  <?php echo __l('To reflect changes, you need to') . ' ' . $this->Html->link(__l('clear cache'), array('controller' => 'devs', 'action' => 'clear_cache', '?f=' . $this->request->url), array('title' => __l('clear cache'), 'class' => 'graydarkerc js-confirm js-no-pjax'));  ?>
						</span>
					  <?php } ?>
				  </div>
				</div>
				
			  <div class="admin-center-block clearfix space sep bot-mspace">

				<?php echo $content_for_layout;  ?>
			  </div>
			  </div>
			  </article>
			<?php } ?>