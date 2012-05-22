	<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php echo $this->load->view('includes/_search')?>
				<?php $my_account_page_title = lang('My Account Page') ?>
				<span class="eutemia"><?php echo substr($my_account_page_title, 0 ,1)?></span><span class="helvetica"><?php echo substr($my_account_page_title, 1)?></span>
			</div>
			
			<div class="gray italic" id="userAccount" style="padding: 10px; text-align: justify;">
				<div class="form">
					<?php echo form_open()?>
					<span class="italic white"><?php echo lang('Your current password') ?>:</span><br/>
					<?php echo form_input('username', '', 'style="width:310px;" class="modal"')?>
					<span class="input_helper_l gray italic f10" style="width:293px;"><span class="input_helper_line red"><?php echo lang('Invalid current password')?>! <?php echo lang('Please type again')?>!</span></span><span class="input_helper_r"></span>
					
					<br/>
					<br/>
					
					<span class="italic white"><?php echo lang('Your new password') ?>:</span><br/>
					<?php echo form_input('username', '', 'style="width:310px;" class="modal"')?>
					<span class="input_helper_l gray italic f10" style="width:293px;"><span class="input_helper_line"><?php echo lang('Password must be valid')?>!</span></span><span class="input_helper_r"></span>
					
					<br/>
					<br/>					
					<span class="italic white"><?php echo lang('Repeat your new password')?>:</span><br/>
					<?php echo form_input('username', '', 'style="width:310px;" class="modal"')?>
					<span class="input_helper_l gray italic f10" style="width:293px;"><span class="input_helper_line"><?php echo lang('Password must match')?>!</span></span><span class="input_helper_r"></span>
					<div class="clear"></div>

					<div class="buttons">
						<?php echo form_submit('', lang('SAVE CHANGES'), 'class="black f10"')?>
						<br/>
						<span class="red"><?php echo lang('Changes could not be saved')?>!</span>
					</div>

				<?php echo form_close()?>
				</div>
			</div>
			
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>	