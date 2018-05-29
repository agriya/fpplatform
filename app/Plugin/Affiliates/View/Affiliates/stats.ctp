<div class="users stats clearfix sites-states-block">
    <div>
        <h2><?php echo __l('Stats'); ?></h2>
        <div class="overflow-block">
			<table class="table table-striped table-hover sep">
			<tr>
				<th colspan='2'>&nbsp;</th>
				<?php foreach($periods as $key => $period){ ?>
				<th>
					<?php echo $period['display']; ?>
				</th>
				<?php } ?>
			</tr>
			<?php 
			foreach($models as $unique_model){ ?>
				<?php foreach($unique_model as $model => $fields){
					$aliasName = isset($fields['alias']) ? $fields['alias'] : $model;
				?>
					
						<?php $element = isset($fields['colspan']) ? 'rowspan ="'.$fields['colspan'].'"' : ''; ?>
						<tr>
						<?php if(!isset($fields['isSub'])) :?>
							
							<td class="sub-title" <?php echo $element;?>>
								<?php echo $fields['display']; ?>
							</td>
						<?php endif;?>
						<?php if(isset($fields['isSub'])) :	?>
							<td>
								<?php echo $fields['display']; ?>
							</td>
						<?php endif; ?>		
						<?php if(!isset($fields['colspan'])) :?>
							<?php foreach($periods as $key => $period){ ?>
									<td>
										<span class="<?php echo (!empty($fields['class']))? $fields['class'] : ''; ?>">
											<?php											
												if(empty($fields['type'])) {
													$fields['type'] = 'cInt';
												}
												if (!empty($fields['link'])):
													$fields['link']['stat'] = $key;
													echo $this->Html->link($this->Html->{$fields['type']}(${$aliasName.$key}), $fields['link'], array('escape' => false, 'title' => __l('Click to View Details')));
												else:
													echo $this->Html->{$fields['type']}(${$aliasName.$key});
												endif;											
											?>
										</span>
									</td>
							<?php } ?>
						
						<?php endif; ?>		
						</tr>
				 <?php } ?>
			<?php } ?>

				
			</table>
        </div>
    </div>
</div>