<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $my_account_title = lang('My Account Page') ?>
				<span class="eutemia "><?php echo substr($my_account_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($my_account_title, 1) ?></span>
			</div>
			
			<div class="gray italic" id="userAccount" style="padding: 10px; text-align: justify;">
				<div class="form">					
					<?php echo  form_open() ?>
						<span class="italic white"><?php echo lang('Old password') ?>:</span><br/>
						<?php echo form_password('old_password',NULL, 'style="width:310px;"') ?>
						<span class="input_helper_l gray italic f10" style="width:293px;">
							<span class="input_helper_line red"><?php echo form_error('old_password') ?></span>
						</span><span class="input_helper_r"></span>					
						<span class="italic white"><?php echo lang('New password') ?>:</span><br/>
						<?php echo form_password('new_password',NULL, 'style="width:310px;"') ?>
						<span class="input_helper_l gray italic f10" style="width:293px;"><span class="input_helper_line"><?php echo form_error('new_password') ?></span></span><span class="input_helper_r"></span>
									
						<div class="clear"></div>
	
						<div class="buttons">
						<?php echo form_submit('submit', lang('Save'), 'class="red f10" style="width:200px;"') ?>			
					</div>
				<?php echo form_close() ?>
				</div>
			</div>		
		</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>