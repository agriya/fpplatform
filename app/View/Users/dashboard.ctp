    <section class="row bot-mspace bot-space">
        <section class="sep-bot top-smspace">
          <div class="container clearfix bot-space">
		  <div class="label label-info show text-18 clearfix no-round ver-mspace">
			<div class="span smspace dc"><?php echo __l('Dashboard');?></div>
			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		  </div>
          </div>
        </section>
        <!-- User block start -->
        <section class="container ver-space">
          <div class="pull-left span5 ver-space mob-dc no-mar tab-clr">             
                <?php  echo $this->Html->getUserAvatarLink($user['User'], 'large_thumb', true);?>        
		  </div>
		   <div class="user-block ver-space span19 tab-clr">
            <div class="clearfix">
              <h3  class="clearfix text-24 mob-dc no-mar"><?php echo __l('As Seller');?></h3>
              <div class="clearfix">
                <dl class="list list-big dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo sprintf(__l('%s Posted'), jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps));?></dt>
                  <dd title="<?php echo $this->Html->cText($user['User']['active_job_count'], false); ?>" class="text-30 pr">
				  <?php if(!empty($user['User']['active_job_count'])) { echo $this->Html->cText($user['User']['active_job_count'], false); } else { echo '0'; } ?></dd>
                </dl>
                <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo __l('Success Rate');?></dt>
				 <?php
				 $total_completed = $success_rate = $on_time_rate  =0;
				if(!empty($user['User']['order_success_without_overtime_count']) || !empty($user['User']['order_success_with_overtime_count'])) {
					$total_completed  = $user['User']['order_success_without_overtime_count']+$user['User']['order_success_with_overtime_count'];
				}
				if(!empty($user['User']['order_received_count'])) {
					$success_rate = ($total_completed/$user['User']['order_received_count'])*100 ;
					$success_rate  = ($success_rate > 100)? 100 : $success_rate;
				}
				if(!empty($user['User']['order_success_without_overtime_count'])) {
					$on_time_rate = ($user['User']['order_success_without_overtime_count']/$total_completed)*100 ;
					$on_time_rate  = ($on_time_rate > 100)? 100 : $on_time_rate;
				}
			?>
                  <dd title="<?php echo sprintf('%s/%s', $this->Html->cInt($total_completed , false),$this->Html->cInt($user['User']['order_received_count'], false)); ?>" class="text-30 pr"><?php echo sprintf('%s/%s', $this->Html->cInt($total_completed, false),$this->Html->cInt($user['User']['order_received_count'], false)); ?></dd>
                </dl>
                <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo __l('On Time');?></dt>
                  <dd title="<?php echo sprintf('%s/%s', $this->Html->cInt($user['User']['order_success_without_overtime_count'], false),$this->Html->cInt($total_completed, false)); ?>" class="text-30 pr"><?php echo sprintf('%s/%s', $this->Html->cInt($user['User']['order_success_without_overtime_count'], false),$this->Html->cInt($total_completed, false)); ?></dd>
                </dl>
                <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo __l('Works in progress');?></dt>
                  <dd title="<?php echo $this->Html->cInt($user['User']['order_active_count'], false);?>" class="text-30 pr"><?php echo $this->Html->cInt($user['User']['order_active_count'], false);?></dd>
                </dl>
                <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo __l('Latest order on');?></dt>
				  <?php if(!empty($user['User']['order_last_accepted_date']) && $user['User']['order_last_accepted_date'] != '0000-00-00 00:00:00'){
							$latest_order= $this->Html->cDateTimeHighlight($user['User']['order_last_accepted_date']);
					  }else{
							$latest_order=  '-';
					  }
				  ?>
                  <dd class="text-30 pr"><?php echo $latest_order ;?></dd>
                </dl>
              </div>
            </div>
            <div class="clearfix">
              <h3 class="no-mar mob-dc text-24"><?php echo __l('As Buyer');?></h3>
              <div class="clearfix">
                <dl class="list list-big dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo __l('Orders');?></dt>
                  <dd class="text-30 pr hor-mspace" title="<?php echo sprintf('%s', $this->Html->cInt($user['User']['buyer_order_purchase_count'], false));?>"><?php echo sprintf('%s', $this->Html->cInt($user['User']['buyer_order_purchase_count'], false));?></dd>
                </dl>
				<?php if (isPluginEnabled('Requests')) { ?>
                <dl class="list list-big offset1 dc mob-clr mob-no-mar mob-space">
                  <dt class="pr"><?php echo requestAlternateName(ConstRequestAlternateName::Singular,ConstRequestAlternateName::FirstLeterCaps);?></dt>
                  <dd class="text-30 pr hor-mspace" title="<?php echo sprintf('%s', $this->Html->cInt($user['User']['request_count'], false));?>"><?php echo sprintf('%s', $this->Html->cInt($user['User']['request_count'], false));?></dd>
                </dl>
				<?php } ?>
              </div>
            </div>
          </div>
        </section>
        <!-- User block End -->
        <!-- selling and buying block start -->
        <section class="clearfix ver-space">
          <div class="hero-unit no-round top-space">
            <div class="container clearfix">
              <ul id="Tab" class="nav nav-tabs no-bor top-mspace">
                <li class="text-16 span8 no-bor dc no-mar active"><a data-toggle="tab" href="#Selling"><span class="show ver-space">Selling</span></a> </li>
                <li class="text-16 span8 no-bor dc"><a data-toggle="tab" href="#Buying"><span class="show ver-space">Buying</span></a></li>
              </ul>
            </div>
          </div>
          <div class="container  tab-content" id="TabContent">
            <div class="tab-pane clearfix active" id="Selling">
              <div class="span12 no-mar ">
			  	<?php
					echo $this->element('users-selling_panel', array('user_id' => $this->Auth->user('id'),'type'=>null,'cache' => array('time' => Configure::read('site.element_cache_duration'))));
				?>
              </div>
              <div class="clearfix span11 pull-right sep ">
                <div class="clearfix sep-bot">
                  <dl class="list list-big dc mob-clr mob-no-mar mob-space">
                    <dt class="pr"><?php echo __l('Total Earned'); ?></dt>
					<?php if(empty($user['User']['sales_cleared_amount'])) {
						$amount = 0;
					} else {
						$amount = $user['User']['sales_cleared_amount'];
					}?>
                    <dd title="<?php echo $this->Html->cCurrency($amount, false);?>" class="text-32 pr no-mar span5"><?php echo $this->Html->siteCurrencyFormatWithoutSup($amount, false);?></dd>
                  </dl>
                  <p class="span pull-right top-space mob-no-pad top-mspace">
                  <span class="show top-space top-mspace mob-no-pad mob-no-mar mob-dc clearfix">
                  <span class="text-24 right-space tab-clr js-tooltip no-mar span3 htruncate" title="<?php echo __l('Positive Feedbacks'); ?>"><i class="icon-thumbs-up-alt no-pad grayc"></i> <?php echo $this->Html->cText($user['User']['positive_feedback_count'], false); ?></span> 
                  <span class="text-24 no-mar span3 htruncate js-tooltip" title="<?php echo __l('Negative Feedbacks'); ?>"><i class="icon-thumbs-down-alt no-pad grayc"></i> <?php echo $this->Html->cText($user['User']['job_feedback_count'] - $user['User']['positive_feedback_count'], false); ?></span> 
                  </span>
                  </p>
                </div>
                <div class="space mob-dc top-smspace">
				<?php
					echo $this->element('users-selling_panel', array('user_id' => $this->Auth->user('id'),'type'=>'chart','cache' => array('time' => Configure::read('site.element_cache_duration'))));
				?>
				
				</div>
              </div>
            </div>
            <div class="tab-pane" id="Buying">
              <div class="clearfix  ">
                <div class="clearfix project-list span">
                  <dl class="list list-big empty-list dc mob-clr mob-no-mar mob-space">
					<dt class="pr"><?php echo __l('Total Spent'); ?></dt>
                      <dd title="<?php echo $this->Html->cCurrency(!empty($total_purchased[0]['total_amount']) ? $total_purchased[0]['total_amount'] : '0', false);?>" class="text-32 pr no-mar span5">
					<?php echo $this->Html->siteCurrencyFormatWithoutSup(!empty($total_purchased[0]['total_amount']) ? $total_purchased[0]['total_amount'] : '0');?>
					</dd>
                  </dl>
                  <div class="span6 offset1">
                    <ul class="hor-space top-mspace unstyled clearfix grayc tab-no-mar">
					<?php echo  '<li class="bot-space">'.$this->Html->link('<span class="joborder-status-info joborder-status-all"></span>'.__l('All').' '.(!empty($all_count) ? $this->Html->cInt($all_count) : '0'), array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders', 'admin' => false), array('class' => 'grayc', 'escape' => false, 'title' => __l('All'))).'</li>';
					$i=0;
						foreach($moreActions as $key => $value):
						$i++;
							list($slug, $cnt) = $value;
							echo '<li class="bot-space">'.$this->Html->link('<span class="joborder-status-info joborder-status-'.$slug.'"></span>'.$key.' ('.__l($this->Html->cInt($cnt).')'), array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => $slug,'admin' => false), array('title' => __l($key), 'escape' => false, 'class' => 'grayc')).'</li>';
							if($i==6){
								echo '</ul></div><ul class="span5 hor-space top-mspace unstyled clearfix grayc tab-no-mar">';
							}
						endforeach;
						?>
                    </ul>
                  
                  <div class="ver-space mob-dc span6 no-mar js-load-pie-chart dc chart-half-section {'chart_type':'PieChart','chart_width':'100', 'data_container':'buying_pie_chart_data', 'chart_container':'buying_pie_chart', 'chart_title':'', 'chart_y_title': ''}">
				  <div style="width:220px;height:220px;" id="buying_pie_chart"> </div>
				  <div class="hide">
				  <table id="buying_pie_chart_data">
				  <tbody>
					<?php 
							foreach($moreActions as $key => $value):
								list($slug, $cnt) = $value;
								?>
								<tr>
									<th><?php echo $key; ?></th>
									<td><?php echo $cnt; ?></td>
								</tr>
						<?php
							endforeach;
						?>
						
					</tbody>
				  </table>
				  </div>
                </div>
              </div>
            </div>
          </div>
		  </div>
        </section>
        <!-- selling and buying block End -->
      </section>