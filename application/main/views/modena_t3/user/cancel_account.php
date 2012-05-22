<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $my_account_title = lang('Cancel account') ?>
				<span class="eutemia "><?php echo substr($my_account_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($my_account_title, 1) ?></span>
			</div>
			
			<div class="gray italic" id="userAccount" style="padding: 10px; text-align: justify;">
				<div class="form" style="text-align:center;"> 					
					<?php echo  form_open() ?>
					<?php echo form_hidden('account',1) ?>
						<span class="italic white"><?php echo lang('Cancelling your account cannot be reversed, are you sure you want to continue?') ?></span>
					<div class="clear"></div>

					<div class="buttons">
						<?php echo form_submit('submit', lang('Yes'), 'class="red f10" style="width:100px;" onclick="return confirm(\'' . lang('Cancel account action is irevesible, are you sure you want to cancel it?') . '\')"') ?>
						<?php echo form_button('but', lang('No'), 'class="red f10"  style="width:100px;" onclick="document.location = \'' . base_url() .'\'")') ?>			
									
					</div>
				<?php echo form_close() ?>
				</div>
			</div>		
		</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>