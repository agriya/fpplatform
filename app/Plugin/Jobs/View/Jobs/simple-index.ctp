<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php $jids ='';
Configure::write('highperformance.uids', $this->Auth->user('id'));
if (!empty($jobs)) {
	foreach ($jobs as $job){
		Configure::write('highperformance.jids', Set::merge(Configure::read('highperformance.jids') , $job['Job']['id']));
	}
	$jids = implode(',', Configure::read('highperformance.jids'));
}?>
<div class="jobs index js-response js-responses js-lazyload ">

<?php if($this->request->params['named']['type'] == 'favorite'): ?>
 <section class="sep-bot bot-mspace">
  <div class="container ">
  <?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'favorite') && empty($this->request->params['named']['username'])){ ?>
  <div class="label label-info show text-18 clearfix no-round ver-mspace">

  <div class="span smspace"><?php echo __l('Buyer Control Panel');?></div>
  <?php echo $this->element('buying-cp-settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
  </div>
  <?php } ?>
   <h2 class="textb text-32 bot-space mob-dc"><?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'related')){ ?>
		<?php echo __l('Related').' '.jobAlternateName(ConstJobAlternateName::Plural);?>
	<?php } ?>
	<?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'favorite') && empty($this->request->params['named']['username'])) { ?>
		<?php echo __l('Favorite').' '.jobAlternateName(ConstJobAlternateName::Plural);?>
	<?php } ?>
	</h2>
		
  </div>
</section>
<?php endif;?>
<div class="container">
<?php if((!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'related' || $this->request->params['named']['type'] == 'user_jobs' || $this->request->params['named']['type'] == 'favorite' || $this->request->params['named']['type'] == 'other'))) {?>
<?php if($this->request->params['named']['type'] == 'related'): ?>
<div class="jobs-feedback-right-block">
<?php endif; ?>
<h3>
	
</h3>

<ol class="unstyled discussion-list ver-space clearfix" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($jobs)):

$i = 0;
foreach ($jobs as $job):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li class="ver-space sep-bot clearfix">
		
		<?php $attachment = '';?>
		<?php if(!empty($job['Attachment']['0'])){?>
				<?php echo $this->Html->link($this->Html->showImage('Job', $job['Attachment']['0'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)),'class'=>'img-rounded', 'title' => $this->Html->cText($job['Job']['title'].' for '. $this->Html->siteCurrencyFormat($job['Job']['amount']), false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('class' => 'show pull-left left-space user-thumb','escape' => false));?>
		<?php }else{ ?>
				<?php echo $this->Html->link($this->Html->showImage('Job', $attachment, array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($job['Job']['title'], false)),'class'=>'img-rounded', 'title' => $this->Html->cText($job['Job']['title'].' for '.$this->Html->siteCurrencyFormat($job['Job']['amount']), false))), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug'], 'admin' => false), array('class' => 'show pull-left left-space user-thumb', 'escape' => false));?>
		<?php } ?>
	<div class="pull-left left-space clearfix">
	<div class="clearfix">
				<div class="text-18 no-mar clearfix pull-left hor-smspace">
					<span class="pull-left" title="<?php echo $job['JobType']['name']; ?>">
						<i class="icon-desktop top-space <?php echo ($job['JobType']['id'] == ConstJobType::Online)?'greenc':'grayc'; ?>"></i>
					</span>
					<?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
						<div class="al-jobunfav-<?php echo $job['Job']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart redc no-pad"></i>', array('controller' => 'job_favorites', 'action'=>'delete', $job['Job']['slug']), array('class' => 'pull-left text-13 no-under delete js-like un-like', 'title' => __l('Unlike'), 'escape' => false));?>
						</div>
						<div class="al-jobfav-<?php echo $job['Job']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'pull-left text-13 no-under js-like like'));?>
						</div>
						<div class="bl-jobfav-<?php echo $job['Job']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'pull-left text-13 no-under like'));?>
						</div>
					<?php 
					} else { 

					 if (isPluginEnabled('JobFavorites')) { ?>
					<?php
					if($this->Auth->sessionValid()):
						if(!empty($job['JobFavorite'])):
							foreach($job['JobFavorite'] as $favorite):
								if($job['Job']['id'] == $favorite['job_id'] && $favorite['user_id'] == $this->Auth->user('id')):
									 echo $this->Html->link('<i class="icon-heart redc no-pad"></i>', array('controller' => 'job_favorites', 'action'=>'delete', $job['Job']['slug']), array('class' => 'like text-13 no-under pull-left js-like', 'title' => __l('Unlike'), 'escape' => false));
								endif;
							endforeach;
						else:
							echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'like text-13 no-under pull-left js-like'));
						endif;
					else:
						echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $job['Job']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'like text-13 no-under pull-left'));
					endif;
					?>
				    <?php } } ?>
					</div>
					 <h3 class="text-18 no-mar clearfix pull-left">
            			<?php echo $this->Html->link($this->Html->cText($job['Job']['title'], false), array('controller' => 'jobs', 'action' => 'view', $job['Job']['slug']), array('class' => 'span13 span13-sm no-mar htruncate graydarkerc','title' => $this->Html->cText($job['Job']['title'],false),'escape' => false));?>
				      
				</h3>
				</div>
				<p>
				<span class="grayc left-space"><?php echo __l('by');?> 
						<?php echo $this->Html->link($job['User']['username'], array('controller'=>'users','action'=>'view',$job['User']['username']), array('class' => 'graydarkerc no-under bot-space hor-smspace', 'title' => $this->Html->cText($job['User']['username'],false)));?>
				</span>
				<span class="grayc left-mspace"><?php echo __l('Category:');?> 
				<?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'related')){ ?>
            			<?php echo $this->Html->link(__l($job['JobCategory']['name']), array('controller'=>'jobs','action'=>'index','category' => $job['JobCategory']['slug']), array('class' => 'graydarkerc no-under bot-space left-smspace', 'title' => __l($this->Html->cText($job['JobCategory']['name'],false))));?>
               <?php }else{ ?>         
						<?php echo $this->Html->link(__l($this->Html->truncate($job['JobCategory']['name'],60)), array('controller'=>'jobs','action'=>'index','category' => $job['JobCategory']['slug']), array('class' => 'graydarkerc no-under bot-space left-smspace', 'title' => __l($this->Html->cText($job['JobCategory']['name'],false))));?>
               <?php } ?> 
			   </span>
			   </p>
         </div>
		 <div class="span7 tab-clr clearfix pull-right">	
			 <div class="pull-right mob-inline">
			<p class="pull-left right-space"><?php echo $this->Html->siteCurrencyFormat($job['Job']['amount']) ;?></p>
				<?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
				<div class="bl-buy-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Buy Now'), array('controller' => 'users', 'action' => 'login'), array('class'=>'btn btn-small btn-success show pull-left textb top-mspace','title' => __l('Buy Now')));?>
				</div>
				<div class="al-buy-instr-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'job_orders','action'=>'add','job' => $job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'btn btn-small btn-success show pull-left textb top-mspace','escape' => false));?>
				</div>
				<div class="al-buy-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order',$job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'btn btn-small btn-success show pull-left textb top-mspace'));?>
				</div>
				<div class="al-edit-<?php echo $job['Job']['id'];?> hide  pull-left">
					<?php echo $this->Html->link(__l('Edit'), array('controller'=>'jobs','action'=>'edit',$job['Job']['id']), array('title' => __l('Edit'), 'class' => 'btn btn-small btn-success show pull-left textb top-mspace'));?>
				</div>


			<?php } else { ?>
			<?php if($this->Auth->sessionValid()){ ?>
				<?php  if($this->Auth->user('id') != $job['Job']['user_id']) { ?>
					<?php if($job['Job']['job_service_location_id'] == ConstServiceLocation::SellerToBuyer || !empty($job['Job']['is_instruction_requires_attachment']) || !empty($job['Job']['is_instruction_requires_input'])):?>
						<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'job_orders','action'=>'add','job' => $job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'btn btn-small btn-success show pull-left textb top-mspace','escape' => false));?>
					<?php else:?>
						<?php echo $this->Html->link(__l('Buy Now'), array('controller'=>'payments','action'=>'order',$job['Job']['id']), array('title' => __l('Buy Now'), 'class' => 'btn btn-small btn-success show pull-left textb top-mspace'));?>
					<?php endif;?>
				<?php } 
				} else{?>
						<?php echo $this->Html->link(__l('Buy Now'), array('controller' => 'users', 'action' => 'login'), array('class'=>'btn btn-small btn-success show pull-left textb top-mspace','title' => __l('Buy Now')));?>
				<?php } 
			}?>
			</div>
		 </div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '.jobAlternateName(ConstJobAlternateName::Plural,ConstJobAlternateName::FirstLeterCaps).' '.__l('available');?></p></div>
	</li>
<?php
endif;
?>
</ol>


	<div class="<?php if(!empty($this->request->params['isAjax'])) { ?> js-pagination <?php } ?>pull-right ver-space">
		<?php
		if (!empty($jobs)) {
			echo $this->element('paging_links');
		}
	?>
	</div>
	<?php if($this->request->params['named']['type'] == 'related'): ?>
    </div>
    <?php endif; ?>
<?php } ?>
</div>
</div>