<div class="box_b_1" style="margin:0px auto; float:none;">
	<div style="padding:20px;">
		<div class="title" style="margin-top:-30px;">
			<?php $forgot_password_title = lang('Forgot password?') ?>
			<span class="eutemia "><?php echo substr($forgot_password_title,0,1)?></span><span class="helvetica "><?php echo substr($forgot_password_title,1)?></span>
		</div>
		<?php echo form_open()?>
			<div class="b_sep_line">
				<span class="italic"><?php echo lang('Your username') ?>*:</span><br/>
				<?php echo form_input('username', set_value('username'), 'style="width:275px;"')?>
				<span class="gray italic red"><?php echo form_error('username')?></span>
			</div>
			<div class="b_sep_line">
				<span class="italic"><?php echo lang('Your email')?>*:</span><br/>
				<?php echo form_input('email', set_value('email'), 'style="width:275px;"')?>
				<span class="gray italic red"><?php echo form_error('email')?></span>
			</div>
			<div style="margin-top:8px; text-align: center;">
				<button class="red"  type="submit" style="width:150px;"> <?php echo lang('Send') ?> </button><br/>
			</div>
		<?php echo form_close()?>
	</div>
</div>
