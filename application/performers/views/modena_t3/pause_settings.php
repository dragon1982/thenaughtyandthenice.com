<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<span class="eutemia"> P</span><span class="helvetica">ause Settings</span>
		</div>
		<div id="profile">
			<div class="left" style="text-align: center;">
				<div class="red_h_sep"></div>
					<?php echo form_open('')?>
					<div class="gray italic register_performer">
						<div>
							<label><span class="gray italic bold"><?php echo lang('Status message') ?>:</span></label>
							<?php echo form_input('status_message',set_value('status_message', $performer->status_message))?>
							<span class="error message" htmlfor="status_message" generated="true"><?php echo form_error('status_message')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Pause time') ?>:</span></label>
							<?php echo form_input('pause_time',set_value('pause_time', round($performer->pause_time/60)))?> <span class="gray italic bold">minutes</span>
							<span class="error message" htmlfor="pause_time" generated="true"><?php echo form_error('pause_time')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Pause message') ?>:</span></label>
							<?php echo form_dropdown('pause_message',$pause_messages, set_value('pause_message', $performer->pause_message),'id="pause_message" onchange="pause_message_change(this.value)"')?>
							<span class="error message" htmlfor="pause_message" generated="true"><?php echo form_error('pause_message')?></span>
						</div>
						<script type="text/javascript">
							function pause_message_change(value){
								if(value == '0') $('#personalised_pause_message').show();
								else $('#personalised_pause_message').hide();	
							}
							$(function (){
								if($('#pause_message').val() == '0') $('#personalised_pause_message').show();
								else $('#personalised_pause_message').hide();	
							});
						</script>						
						<div id="personalised_pause_message" style="display:none">
							<label><span class="gray italic bold"><?php echo lang('Personalised pause message') ?>:</span></label>
							<?php echo form_input('personalised_pause_message',set_value('personalised_pause_message', $performer->pause_message))?>
							<span class="error message" htmlfor="personalised_pause_message" generated="true"><?php echo form_error('personalised_pause_message')?></span>
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