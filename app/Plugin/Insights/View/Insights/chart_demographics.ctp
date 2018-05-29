<div class="accordion-group">
   <div class="accordion-heading">
    <h4><a class="accordion-toggle js-toggle-icon js-no-pjax" href="#user-dashboard-demographics" data-parent="#dashboard-accordion" data-toggle="collapse"><?php echo __l('Demographics'); ?><i class="icon-chevron-down pull-right"></i></a></h4>
  </div>
   <div class="accordion-body collapse" id="user-dashboard-demographics">
   <div class="accordion-inner">
     <?php echo $this->element('chart-user_demographics', array('chart_y_title'=> __l('Funded Users'), 'user_type_id' => ConstUserTypes::User)); ?>
  </div>
 </div>
</div>