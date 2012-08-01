<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<span class="eutemia"> P</span><span class="helvetica">ause Time</span>
		</div>
		<div id="profile">
			<div class="left" style="text-align: center;">
				<div class="red_h_sep"></div>
					<?php echo form_open('')?>
					<div class="gray italic register_performer">
						<div>
							<label><span class="gray italic bold"><?php echo lang('Pause time') ?>:</span></label>
							<?php echo form_input('pause_time',set_value('pause_time', round($performer->pause_time/60)))?> <span class="gray italic bold">minutes</span>
							<span class="error message" htmlfor="pause_time" generated="true"><?php echo form_error('pause_time')?></span>
						</div>
						<div>
							<label></label>
							<?php echo form_submit('submit', lang('Save'), 'class="red"')?>
						</div>
					<?php echo form_close()?>
					</div>
				<div class="red_h_sep"></div>
				<div class="white_h_sep"></div>
								
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>