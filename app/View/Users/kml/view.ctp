<kml xmlns="http://www.opengis.net/kml/2.2">
  <Document>
    <Placemark>
      <name>
	      <?php echo !empty($user['UserProfile']['full_name'])? $user['UserProfile']['full_name'] : $user['User']['username']; ?>		
		  <?php echo !empty($user['UserProfile']['mobile_phone'])? ' '.$user['UserProfile']['mobile_phone'] :''; ?>		
	  </name>
      <description>
        <![CDATA[
          <address>
          	<?php 
                $address = (!empty($user['UserProfile']['contact_address'])) ? $user['UserProfile']['contact_address'] : ' ';                
				echo $address; 
			?>
          </address>
          <p>
			<?php if (!empty($user['User']['UserAvatar'])): ?>
				<img title="testingcomp" alt="[Image: <?php echo (!empty($user['UserProfile']['full_name']) ? $user['UserProfile']['full_name'] : $user['User']['username']); ?>]" class="" src="<?php echo Router::url('/',true).$this->Html->getImageUrl('UserAvatar', $user['User']['UserAvatar'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($user['User']['username'], false)), 'title' => (!empty($user['UserProfile']['full_name']) ? $user['UserProfile']['full_name'] : $user['User']['username'])));?>"/>
			<?php endif; ?>
			<?php echo $this->Html->truncate($user['UserProfile']['about_me'],20); ?>
		  </p>
          <?php if($type == 'job' && !empty($user['Job'])): ?>
              <dl>
                  <?php foreach($user['Job'] as $job): ?>
                      <dt>
						<a href="<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'view', $job['slug']),true);?>" title = "<?php echo $job['title'];?>">
							<?php echo  $job['title'];?>
						</a>
					   </dt>
                      <dd><?php echo $this->Html->truncate($job['description'],50); ?></dd>
                  <?php endforeach; ?>
              </dl>          
		  <?php elseif($type == 'request' && !empty($user['Request'])): ?>
              <dl>
                  <?php foreach($user['Request'] as $request): ?>
                      <dt>
						<a href="<?php echo $this->Html->url(array('controller' => 'requests', 'action' => 'view', $request['slug']),true);?>" title = "<?php echo $request['name'];?>">
						<?php echo  $request['name'];?>
						</a>
					   </dt>
                      <dd></dd>
                  <?php endforeach; ?>
              </dl>
          <?php endif; ?>
        ]]>
      </description>
      <Point>
          <coordinates><?php echo $user['UserProfile']['longitude']; ?>,<?php echo $user['UserProfile']['latitude']; ?></coordinates>
      </Point>
    </Placemark>	 
  </Document>
</kml>
