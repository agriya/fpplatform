<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php $rids ='';
Configure::write('highperformance.uids', $this->Auth->user('id'));
if (!empty($requests)) {
	foreach ($requests as $request){
		Configure::write('highperformance.rids', Set::merge(Configure::read('highperformance.rids') , $request['Request']['id']));
	}
	$rids = implode(',', Configure::read('highperformance.rids'));
}?>
<div class="needs-block">
<div class="jobs index js-response js-responses js-jobs-scroll-here js-lazyload">
<div class="bot-space row no-mar js-request-responses">
<?//php echo $this->element('paging_counter');?>

<ol class="unstyled discussion-list ver-space clearfix">
<?php
if (!empty($requests)):

$i = 0;
foreach ($requests as $request):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li class="ver-space sep-bot clearfix">
        <div class="pull-left"><?php echo $this->Html->getUserAvatarLink($request['User'], 'small_thumb', true, 'user-thumb','img-rounded');?> </div>
		<div class="pull-left left-space clearfix">
		<div class="clearfix">
			<div class="text-18 no-mar clearfix pull-left hor-smspace">
				<span class="pull-left" title="<?php echo $request['JobType']['name'];?>"><i class="icon-desktop top-space <?php echo ($request['JobType']['name'] == 'Online')?'greenc':'grayc'; ?>"></i></span>
				    <?php 
				   if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
						<div class="al-requnfav-<?php echo $request['Request']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart redc no-pad"></i>', array('controller' => 'request_favorites', 'action'=>'delete', $request['Request']['slug']), array('class' => 'like text-13 no-under pull-left js-like', 'title' => __l('Unlike'), 'escape' => false));?>
						</div>
						<div class="al-reqfav-<?php echo $request['Request']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'like text-13 no-under pull-left js-like'));?>
						</div>
						<div class="bl-reqfav-<?php echo $request['Request']['id'];?> hide  pull-left">
							<?php echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false , 'class' => 'like text-13 no-under pull-left'));?>
						</div>
					<?php 
					} else { 
					if (isPluginEnabled('RequestFavorites')) { ?>
					<?php
					if($this->Auth->sessionValid()):
						if(!empty($request['RequestFavorite'])):
							foreach($request['RequestFavorite'] as $favorite):
								if($request['Request']['id'] == $favorite['request_id']):
									 echo $this->Html->link('<i class="icon-heart redc no-pad"></i>', array('controller' => 'job_favorites', 'action'=>'delete', $request['Request']['slug']), array('class' => 'like text-13 no-under pull-left js-like', 'title' => __l('Unlike'), 'escape' => false));
								endif;
							endforeach;
						else:
							echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'like text-13 no-under pull-left js-like'));
						endif;
					else:
						echo $this->Html->link('<i class="icon-heart grayc no-pad"></i>', array('controller' => 'job_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'like text-13 no-under pull-left'));
					endif;
					?>
                    <?php }} ?>
					</div>
					<h3 class="text-18 no-mar span13 htruncate clearfix pull-left">
					<?php echo $this->Html->link($this->Html->cText($request['Request']['name'],false), array('controller' => 'requests', 'action' => 'view', $request['Request']['slug']), array('title' => $this->Html->cText($request['Request']['name'], false),'class' => ' span13-sm no-mar  graydarkerc', 'escape' => false));?>
				</h3>
			</div>
            <p>
	            <span class="grayc left-space"><?php echo __l('by');?> 
						<?php echo $this->Html->link($request['User']['username'], array('controller'=>'users','action'=>'view',$request['User']['username']), array('class' => 'graydarkerc no-under bot-space hor-smspace', 'title' => $this->Html->cText($request['User']['username'],false)));?>
				   </span>
				   <span class="grayc left-mspace"><?php echo __l('Category:');?> 
				<?php if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'related')){ ?>
            			<?php echo $this->Html->link(__l($request['JobCategory']['name']), array('controller' => 'requests', 'action' => 'index', 'category' => $request['JobCategory']['slug']), array('class' => 'graydarkerc no-under bot-space left-smspace', 'title' => __l($this->Html->cText($request['JobCategory']['name'],false))));?>
               <?php }else{ ?>         
						<?php echo $this->Html->link(__l($this->Html->truncate($request['JobCategory']['name'],60)), array('controller' => 'requests', 'action' => 'index', 'category' => $request['JobCategory']['slug']), array('class' => 'graydarkerc no-under bot-space left-smspace', 'title' => __l($this->Html->cText($request['JobCategory']['name'],false))));?>
               <?php } ?> 
			   </span>
             </p>
		</div>
               <div class="span7 tab-clr clearfix pull-right">
				<div class="pull-right mob-inline">
					<p class="pull-left right-space"><?php echo $this->Html->siteCurrencyFormat($request['Request']['amount']);?></p>
				<?php if(isPluginEnabled('HighPerformance')&& Configure::read('HtmlCache.is_htmlcache_enabled')) { ?>
				<div class="al-apply-post-<?php echo $request['Request']['id'];?> hide pull-left">
					<?php echo $this->Html->link(__l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'jobs', 'action' => 'add', 'request_id' => $request['Request']['id']), array('title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps) , 'class' => 'btn btn-small btn-success show pull-left textb top-mspace','escape' => false));?>
				</div>
				<div class="bl-apply-post-<?php echo $request['Request']['id'];?> hide pull-left">
					<?php echo $this->Html->link(__l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps) , 'class' => 'btn btn-small btn-success show pull-left textb top-mspace','escape' => false));?>
				</div>
			<?php }  else { ?>
				<?php if(isPluginEnabled('Jobs')) { ?>
					<?php if($request['User']['username'] != $this->Auth->user('username')) :?>
							<?php echo $this->Html->link(__l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps), array('controller' => 'jobs', 'action' => 'add', 'request_id' => $request['Request']['id']), array('title' => __l('Apply/Post a').' '.jobAlternateName(ConstJobAlternateName::Singular,ConstJobAlternateName::FirstLeterCaps) , 'class' => 'btn btn-small btn-success show pull-left textb top-mspace','escape' => false));?>
					<?php endif; ?>      
				<?php }?>
			<?php }?>
				</div>
			</div>
			
	</li>
<?php
    endforeach;
else:
	 ?>

		<li>

			<div class="dc grayc">
			<p class="grayc notice text-16 dc"><?php echo __l('No').' '.requestAlternateName(ConstRequestAlternateName::Plural).' '.__l(' available');?></p></div>

		</li>
	<?php
endif;
?>
</ol>
<div class="<?php if(!empty($this->request->params['isAjax'])) { ?> js-pagination <?php } ?> pull-right ver-space">
<?php 
if (!empty($requests)) {
	echo $this->element('paging_links');
}
?>
</div>
</div>
</div>
</div>