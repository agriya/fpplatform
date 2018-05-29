<div class="clearfix">
		    <?php echo $this->Html->link('<dl class="dc list list-big top-mspace users mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Page') . '</dt><dd title="' . $content_type . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($content_type) . '</dd>  </dl>', array('controller'=>'nodes','action'=>'index','content_filter_id' => constContentType::Page), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Page'), 'escape' => false));
			echo $this->Html->link('<dl class="dc list list-big top-mspace users mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Publish') . '</dt><dd title="' . $publish . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($publish) . '</dd>  </dl>', array('controller'=>'nodes','action'=>'index','content_filter_id' => !empty($this->request->params['named']['content_filter_id'])?$this->request->params['named']['content_filter_id']:'', 'filter_id' => ConstMoreAction::Publish), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Publish'), 'escape' => false));
			echo $this->Html->link('<dl class="dc list list-big top-mspace users mob-clr mob-sep-none "><dt class="pr hor-mspace graydarkerc">' . __l('Unpublish') . '</dt><dd title="' . $unpublish . '" class="text-32 graydarkerc pr hor-mspace">' . $this->Html->cInt($unpublish) . '</dd>  </dl>', array('controller'=>'nodes','action'=>'index','content_filter_id' => !empty($this->request->params['named']['content_filter_id'])?$this->request->params['named']['content_filter_id']:'', 'filter_id' => ConstMoreAction::Unpublish), array('class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Unpublish'), 'escape' => false));?>
		</div>
		<div class="clearfix top-space top-mspace sep-top">
		  <div class="pull-right span10 users-form tab-clr">
			<div class="pull-left mob-clr mob-dc">
			  <?php echo $this->Form->create('Node', array('type' => 'get', 'class' => 'normal form-search no-mar ', 'action'=>'index')); ?>
				  <?php echo $this->Form->input('q', array('label' => false, 'div' => 'input text ver-smspace', 'placeholder' => "keyword")); ?>
				<div class="submit left-space">
				  <?php echo $this->Form->submit(__l('Search'), array('class' => 'btn btn-primary', 'div' => false));?>
				</div>
			  <?php echo $this->Form->end(); ?>
			</div>
			<div class="pull-left top-space top-mspace mob-clr mob-dc tab-clr">
				<?php echo $this->Html->link('<i class="icon-plus-sign no-pad text-18"></i> <span class="grayc">' . __l('Add') . '</span>', array('controller' => 'nodes', 'action' => 'add','page'), array('class' => 'hor-mspace bluec textb text-13','title'=>__l('Add'), 'escape' => false)); ?>
			</div>
		  </div>
		  <?php echo $this->element('paging_counter'); ?>
		</div>