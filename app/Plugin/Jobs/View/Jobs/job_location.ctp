<div class="gigs-view-map-left-block bot-space">
	<div class="gigs-view-map-info top-space">
		<div class="clearfix top-space map-address-info">
		<?php if(!empty($job['Job']['address'])): ?>
			<div class='hide'> <span id='js-view-lat'><?php echo $job['Job']['latitude'];?></span> <span id='js-view-log'><?php echo $job['Job']['longitude'];?></span> <span id='js-view-zoom'><?php echo !empty($job['Job']['zoom_level']) ? $job['Job']['zoom_level'] : '10';?></span> <span id='js-view-radius'><?php echo $job['Job']['job_coverage_radius'];?></span> <span id='js-view-radius-units'><?php echo $job['Job']['job_coverage_radius_unit_id'];?></span> </div>
			<a name="map_location"></a>
			<address>
				<?php echo $this->HTML->cText($job['Job']['address'],false);?>
			</address>
			<address>
			<?php if(!empty($job['Job']['mobile'])): ?>
				<?php if(Configure::read('job.is_show_mobile_for_offline_jobs') == 1):?>
					<?php echo __l("Seller contact number:"); ?>
					<?php echo $job['Job']['mobile'];?>
				<?php else:?>
					<?php
						$is_purchased = $this->Html->isPurchasedUser($job['Job']['id'], $this->Auth->user('id'));
						if(!empty($is_purchased)):
					?>
						<h3> <?php echo __l("Seller contact number:"); ?></h3>
						<?php echo $job['Job']['mobile'];?>
				<?php endif;?>
			<?php endif;?>
		<?php endif;?>
		</address>
		</div>
		<?php $map_zoom_level = !empty($job['Job']['map_zoom_level']) ? $job['Job']['zoom_level'] : '10';?>
		<?php if(Configure::read('site.map_type') == 'static'):?>
			<a href="http://maps.google.com/maps?q=<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'view', 'type' => 'job',  $job['User']['username'],'ext' => 'kml'),true).'&amp;z='.$map_zoom_level?>" title="<?php echo $job['Job']['title'] ?>" target="_blank"> <?php echo $this->Html->image($this->Html->formGooglemap($job['Job'],'1000x200'),array('width'=>'1000px','height'=>'200px'));?> </a>
		<?php else:?>
			<div class="js-add-map">
				<div class="show-map" style="">
				  <div id="js-map-view-container"></div>
				</div>
			</div>
			<a href="http://maps.google.com/maps?q=<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'view', 'type' => 'job', $job['User']['username'],'ext' => 'kml'),true).'&amp;z='.$map_zoom_level?>" title="<?php echo $job['Job']['title'] ?>" target="_blank"> <?php echo __l('View KML');?> </a>
		<?php endif; ?>
	<?php endif; ?>
	</div>
</div>