<?php /* SVN: $Id: $ */ ?>
<div class="requests view">
	<div class="clearfix">		
		<div class="user-info-block-right">
			<h3>				
				<?php 
					echo $this->Html->cText($request['Request']['name']). ": ";
				?>
				<?php echo $this->Html->siteCurrencyFormat($request['Request']['amount']);?>
			</h3>
		</div>	
        
	</div>
</div>






	
