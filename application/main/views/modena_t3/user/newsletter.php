<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $my_account_title = lang('Newsletter Settings') ?>
				<span class="eutemia "><?php echo substr($my_account_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($my_account_title, 1) ?></span>
			</div>
			
			<div class="gray italic" id="userAccount" style="padding: 10px; text-align: justify;">
				<div class="form">					
					<?php echo  form_open() ?>
						<label class="white"><?php echo lang('Newsletter') ?>:</label>
						<?php echo form_dropdown('newsletter',$newsletter,set_value('newsletter',$user->newsletter), 'style="width:200px;" class="rounded"') ?>
					<div class="clear"></div>

					<div class="buttons">
						<?php echo form_submit('submit', lang('SAVE'), 'class="red f10" style="width:200px;"') ?>			
					</div>
				<?php echo form_close() ?>
					<span class="input_helper_l gray italic f10" style="width:293px;">
						<span class="input_helper_line red"><?php echo form_error('newsletter') ?></span>
					</span>
				</div>
			</div>		
		</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>