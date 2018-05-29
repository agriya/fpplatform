<div class="clearfix map-address-info gigs-view-map-left-block"> 
          <div class="gigs-view-map-info">
                
					<div class='hide'> <span id='js-view-lat'><?php echo $request['Request']['latitude'];?></span>
					<span id='js-view-log'><?php echo $request['Request']['longitude'];?></span>
					<span id='js-view-zoom'><?php echo !empty($request['Request']['zoom_level']) ? $request['Request']['zoom_level'] : '10';?></span>
				</div>
					<a name="map_location"></a>
					<address>
						<?php echo $request['Request']['address'];?>
					</address>
					<address>
					<?php if(!empty($request['Request']['mobile'])): ?>
						<?php if(Configure::read('job.is_show_mobile_for_offline_jobs') == 1):?>
							<?php echo __l("Seller contact number:"); ?>
							<?php echo $request['Request']['mobile'];?>
						<?php else:?>
							<?php
								$is_purchased = $this->Html->isPurchasedUser($request['Request']['id'], $this->Auth->user('id'));
								if(!empty($is_purchased)):
							?>
								<h3> <?php echo __l("Seller contact number:"); ?></h3>
								<?php echo $request['Request']['mobile'];?>
						<?php endif;?>
					<?php endif;?>
                <?php endif;?>
				</address>
              <?php
				$map_zoom_level = !empty($request['Request']['map_zoom_level']) ? $request['Request']['zoom_level'] : '10';
				if(Configure::read('site.map_type') == 'static'):?>
              <a href="http://maps.google.com/maps?q=<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'view', 'type' => 'request' ,$request['User']['username'],'ext' => 'kml'),true).'&amp;z='.$map_zoom_level?>" title="<?php echo $request['Request']['name'] ?>" target="_blank"> <?php echo $this->Html->image($this->Html->formGooglemap($request['Request'],'1000x200'),array('width'=>'1000px','height'=>'200px'));?> </a>
              <?php else:?>
              <div class="js-add-map">
                <div class="show-map" style="">
                  <div id="js-map-view-container"></div>
                </div>
              </div>
              <a href="http://maps.google.com/maps?q=<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'view', 'type' => 'request' ,$request['Request']['username'],'ext' => 'kml'),true).'&amp;z='.$map_zoom_level?>" title="<?php echo $request['Request']['name'] ?>" target="_blank"> <?php echo __l('View KML');?> </a>
              <?php
				endif;
			?>
            
               </div>
        
        </div>
			