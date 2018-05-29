<?php if ($this->request->params['action'] != 'show_notification') { ?>
	<div id="js-notification-block" class="hide"> 
<?php } ?>
	<?php
	if(isPluginEnabled('Jobs')) {
		$new_order_count = $this->Html->getUserNewOrder($this->Auth->user('id'));
		$new_order_count = !empty($new_order_count) ? $new_order_count : '';
		$show_url = $this->Html->link(__l('Show'), array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'waiting_for_acceptance', 'admin' => false), array('title' => __l('Show')));
		$new_review_count = $this->Html->getUserNewReview($this->Auth->user('id'));
		$new_review_count = !empty($new_review_count) ? $new_review_count : '';
		$show_review_url = $this->Html->link(__l('Show'), array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders','status' => 'waiting_for_review', 'admin' => false), array('title' => __l('Show')));
		$new_redeliver_count = $this->Html->getUserNewRedeliver($this->Auth->user('id'));
		$new_redeliver_count = !empty($new_redeliver_count) ? $new_redeliver_count : '';
		$show_redeliver_url = $this->Html->link(__l('Show'), array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks','status' => 'rework', 'admin' => false), array('title' => __l('Show')));
		
		$seller_mutual_cancel_count = $this->Html->getSellerMutualCancelRequest($this->Auth->user('id'));
		$seller_mutual_cancel_count = !empty($seller_mutual_cancel_count) ? $seller_mutual_cancel_count : '';
		$seller_mutual_cancel_url = $this->Html->link(__l('Show'), array('controller' => 'job_orders', 'action' => 'index','type'=>'myworks', 'admin' => false), array('title' => __l('Show')));
		$buyer_mutual_cancel_count = $this->Html->getBuyerMutualCancelRequest($this->Auth->user('id'));
		$buyer_mutual_cancel_count = !empty($buyer_mutual_cancel_count) ? $buyer_mutual_cancel_count : '';
		$buyer_mutual_cancel_url = $this->Html->link(__l('Show'), array('controller' => 'job_orders', 'action' => 'index','type'=>'myorders', 'admin' => false), array('title' => __l('Show')));

		?>
		<?php if(!empty($new_order_count)): ?>
				<div class="info-message"> <?php echo __l('You have ').' '.$new_order_count.' '.__l('new order to approve.').' '. $show_url;?> </div>
		<?php endif;?>
		<?php if(!empty($new_review_count)): ?>
				<div class="info-message"> <?php echo __l('A').' '.jobAlternateName(ConstJobAlternateName::Singular).' '.__l('you ordered is ready and waiting for your review.').' '. $show_review_url;?> </div>
		<?php endif;?>
		<?php if(!empty($new_redeliver_count)): ?>
				<div class="info-message"> <?php echo __l('You have ').' '.$new_redeliver_count.' '.__l('redeliver request from buyer.').' '. $show_redeliver_url;?> </div>
		<?php endif;?>
		<?php if(!empty($seller_mutual_cancel_count)): ?>
				<div class="info-message"> <?php echo __l('You have ').' '.$seller_mutual_cancel_count.' '.__l('mutual cancel request from buyer.').' '. $seller_mutual_cancel_url;?> </div>
		<?php endif;?>
		<?php if(!empty($buyer_mutual_cancel_count)): ?>
				<div class="info-message"> <?php echo __l('You have ').' '.$buyer_mutual_cancel_count.' '.__l('mutual cancel request from Seller.').' '. $buyer_mutual_cancel_url;?> </div>
		<?php endif;?>
	<?php } ?>
	<?php if($this->Auth->sessionValid() && isPluginEnabled('Affiliates')): ?>                  
			<?php if($this->Auth->user('is_affiliate_user')): 
					$affiliate_count  =	$this->Html->getAffiliateCount($this->Auth->user('id'));
					if(!$affiliate_count){
						$show_affiliate_url = $this->Html->link(__l('Affiliate'), array('controller' => 'affiliates', 'action' => 'index'), array('title' => __l('Affiliate')));
			?>
					<div class="info-message"> <?php echo __l('You are').' ' . $show_affiliate_url.' ' . __l('user, admin approved your request.');?> </div>
			<?php 
					}
				endif;?>
	<?php endif;?>
<?php
	if ($this->request->params['action'] != 'show_notification') {
		$script_url = Router::url(array(
			'controller' => 'users',
			'action' => 'show_notification',
			'ext' => 'js',
			'admin' => false
		) , true) . '?u=' . $this->Auth->user('id');
		$js_inline = "(function() {";
		$js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
		$js_inline .= "js.src = \"" . $script_url . "\";";
		$js_inline .= "var s = document.getElementById('js-notification-block'); s.parentNode.insertBefore(js, s);";
		$js_inline .= "})();";
?>
<script type="text/javascript">
//<![CDATA[
function getCookie (c_name) {var c_value = document.cookie;var c_start = c_value.indexOf(" " + c_name + "=");if (c_start == -1) {c_start = c_value.indexOf(c_name + "=");}if (c_start == -1) {c_value = null;} else {c_start = c_value.indexOf("=", c_start) + 1;var c_end = c_value.indexOf(";", c_start);if (c_end == -1) {c_end = c_value.length;}c_value = unescape(c_value.substring(c_start,c_end));}return c_value;}if (getCookie('_gz')) {<?php echo $js_inline; ?>} else {document.getElementById('js-notification-block').className = '';}
//]]>
</script>
<?php
	}
?>
<?php if ($this->request->params['action'] != 'show_notification') { ?>
	</div>
<?php } ?>