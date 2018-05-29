    <div class="row-fluid ver-space ver-mspace">
	    <article id="accordion2" class="span18 accordion tab-clr">
          <section class="no-pad top-mspace bot-mspace js-metrics">
		    <?php echo $this->element('admin-charts-stats'); ?>
          </section>
        </article>
	<aside class="span6 tab-clr">
    <section class="no-pad top-mspace bot-mspace">
            <div class="label label-info tab-head show no-round clearfix">
              <h5 class="pull-left ver-smspace whitec textn text-16"><i class="icon-time hor-smspace text-16"></i><span><?php echo __l('Timings'); ?></span></h5>
            </div>
            <section class="space sep">
              <div class="hor-mspace">
                <ul class="left-mspace grayc">
                  <li><span class="inline"><?php echo __l('Current time: '); ?> <?php echo $this->Html->cDateTime(strftime(Configure::read('site.datetime.format'))); ?></span></li>
                  <li><?php echo __l('Last login: '); ?> <?php echo $this->Html->cDateTime($this->Auth->user('last_logged_in_time')); ?></li>
                </ul>
              </div>
            </section>
          </section>

		      <section class="no-pad top-mspace bot-mspace">
            <div class="label label-success tab-head show no-round clearfix">
              <h5 class="pull-left ver-smspace whitec textn text-16"><i class="icon-warning-sign no-bg hor-smspace"></i><span><?php echo __l('Action to Be Taken'); ?></span></h5>
            </div>
            <section class="space sep" >
              <div class="hor-mspace">
                <?php echo $this->element('admin_action_taken'); ?>
              </div>
            </section>
          </section>
          <section class="no-pad top-mspace">
            <?php echo $this->element('users-admin_recent_users'); ?>
          </section>
          <section class="no-pad top-mspace">
            <div class="label label-warning tab-head show no-round clearfix">
              <h5 class="pull-left whitec textn ver-smspace text-16"><i class="icon-user hor-smspace text-16"></i> <span><?php echo Configure::read('site.name'); ?></span></h5>
            </div>
            <section class="space sep ">
              <div class="hor-mspace textb bot-space grayc"><?php echo __l('Version').' ' ?>  <?php echo Configure::read('site.version'); ?></div>
              <div class="hor-mspace">
                <ul class="left-mspace grayc bot-space js-live-tour-parent">
                  <li><?php echo $this->Html->link('Product Support', 'http://customers.agriya.com/', array('class' => 'js-no-pjax grayc', 'target' => '_blank', 'title' => 'Product Support')); ?></li>
                  <li><?php echo $this->Html->link('Product Manual', 'http://dev1products.dev.agriya.com/doku.php?id=fpplatform-v2-0' ,array('class' => 'js-no-pjax grayc', 'target' => '_blank','title' => 'Product Manual')); ?></li>
                  <li><?php echo $this->Html->link('Cssilize', 'http://www.cssilize.com/', array('class' => 'js-no-pjax grayc', 'target' => '_blank', 'title' => 'Cssilize')); ?> <?php echo 'PSD to XHTML Conversion and ' . Configure::read('site.name') . ' theming'; ?></li>
                  <li><?php echo $this->Html->link('Agriya Blog', 'http://blogs.agriya.com/' ,array('class' => 'js-no-pjax grayc', 'target' => '_blank','title' => 'Agriya Blog')); ?> <?php echo __l('Follow Agriya news'); ?></li>
                </ul>
				<a href="#" class="btn btn-primary mspace js-live-tour js-no-pjax"><?php echo __l('Live Tour'); ?></a>
              </div>
            </section>
          </section>
        </aside>
      </div>