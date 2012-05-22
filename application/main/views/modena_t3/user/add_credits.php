<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $credits_title = lang('Add credits')?>
			<span class="eutemia "><?php echo substr($credits_title, 0 ,1 )?></span><span class="helvetica "><?php echo substr($credits_title ,1 )?></span>
		</div>
		
		<script type="text/javascript">
			jQuery(function($){
				$('#order_credits > div').hover(function(){
					$(this).addClass('hover');
				}, function(){
					$(this).removeClass('hover');
				});
				
				$('#order_credits > div').click(function(){
					
					var pack_id = $(this).attr('package_id');
					$('input[name=package]').val(pack_id);
					$('#add_credits').submit();
				});			
			});
		</script>
		
		<div style="width:300px; margin:0px auto;">
		<?php echo form_open('', array('id' => 'add_credits'))?>
				<?php echo form_hidden('package')?>
		<?php echo form_close()?>
		</div>
		
		<div id="order_credits">
			<? $i = 1;?>
			<?php foreach($packages as $row => $package):?>
			<div class="pack<?php echo $i?> clicker" package_id="<?php echo $row?>">
				<div class="nr_credits">
					<?php echo $package['credits']?>
				</div>
				<div class="chips <?php echo ($package['bonus'] != 0)? 'bonus' : null?>">
					<?php if(  SETTINGS_CURRENCY_TYPE): //TODO TEST?>
						<?php echo SETTINGS_SHOWN_CURRENCY?>
					<?php endif?>
				</div>
				<?php if($package['bonus'] != 0):?>
					<div class="plus">+</div>
					<div class="bonus"><?php echo lang('Bonus')?></div>
					<div class="bonus_amount"><?php echo $package['bonus']?></div>
				<?php endif?>
				
					<div class="price"><?php echo $package['value']?><span class="currency"><?php echo strtolower(SETTINGS_REAL_CURRENCY_NAME)?></span></div>
			</div>

			<?php $i++;?>
			<?php endforeach;?>
		</div>		
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>