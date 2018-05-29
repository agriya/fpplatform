      <section class="row no-mar">
        <div class="banner-block mob-no-mar">
          <div class="container">
            <div class="row banner-contents trans-bg mob-no-pad">
              <div class="space dc blackc" itemscope itemtype="http://schema.org/WPHeader">
                <h2 class="textb" itemprop="headline"> <span class="show text-50"><?php echo __l('We are Agriya'); ?></span> <span class="show text-36"><?php echo __l('Trusted for 14+ years in 173+ countries'); ?></span> </h2>
                <span class="text-24 show ver-space ver-mspace" itemprop="description"><?php echo __l('The best fixed-price platform for marketplace/jobs website. Period.'); ?></span> </div>
            </div>
            <div class="text-18 textb blackc dc ver-mspace ver-space"> 
			<?php echo $this->Html->link(__l('Browse'), array('controller' => 'jobs', 'action' => 'index', 'admin' => false), array('class'=>'text-up btn btn-large btn-primary text-20 mspace', 'title' => __l('Browse')));?>
			<span class="text-24 textb mob-clr"><?php echo __l('OR');?></span> 
			<?php echo $this->Html->link(__l('Get Started'), array('controller' => 'jobs', 'action' => 'add', 'admin' => false), array('escape' => false, 'title'=>__l('Get Started'), 'class' => 'btn btn-large btn-warning text-20 mspace text-up')); ?>
			</div>
          </div>
        </div>
      </section>
      <!-- listing block start -->
      <section class="row ver-mspace ver-space">
        <div class="container clearfix" itemscope itemtype="http://schema.org/WebPageElement">
          	<?php if(isPluginEnabled('Jobs')) { ?>
					<h3 class="text-36 pull-left right-space no-mar" itemprop="headline"><?php echo		jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps);?></h3>
		            <span class="pull-left text-16 top-space top-mspace"><?php echo __l('for') . ' ' . $this->Html->siteJobAmount('and', 'no-style');?></span> 
			<?php }?>
		  <div class="category-block pull-right mob-clr mob-dc clearfix">
			<div class="dropdown pull-left top-space mob-inline mob-ver-space"> 
			<a href="#" title="Categories" class="dropdown-toggle btn btn-warning no-shad pull-left mob-clr" data-toggle="dropdown"> <span class="hor-smspace">Categories</span> <i class="icon-chevron-sign-down text-18"></i></a>
			  <ul class="unstyled dropdown-menu arrow arrow-right dl clearfix">
				<?php 
					$span_size = 'span6';
					if(Configure::read('job.is_enable_online') && Configure::read('job.is_enable_offline')) {
						$span_size = 'span12';
					}
				?>
				<li class="<?php echo $span_size; ?>"><?php 
					if(Configure::read('job.is_enable_online')) {
						echo $this->element('Jobs.job_categories-index', array('type' => ConstJobType::Online, 'display' => 'home', 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); 
					}	
					if(Configure::read('job.is_enable_offline')) {
						echo $this->element('Jobs.job_categories-index', array('type' => ConstJobType::Offline, 'display' => 'home', 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); 
					}
					?>
				</li>
			  </ul>
		   </div>
		 </div>
		</div>
      </section>
	  <section class="row bot-mspace bot-space">
		  <div class="container clearfix" itemscope itemtype="http://schema.org/WebPageElement">
			<?php echo $this->element('Jobs.job-search-index'); ?>
		  </div>
	  </section>
      <!-- listing block End -->
	<?php echo $this->element('agriya_advantages',array('cache' => array('config' => 'sec'))); ?>
      <!-- Get start block start -->
      <div class="dc ver-mspace ver-space">
	  <?php echo $this->Html->link(__l('Get Started'), array('controller' => 'jobs', 'action' => 'add', 'admin' => false), array('escape' => false, 'title'=>__l('Get Started'), 'class' => 'btn btn-large  btn-success text-20 textb mspace text-up')); ?>
	 </div>
      <!-- Get start block end -->