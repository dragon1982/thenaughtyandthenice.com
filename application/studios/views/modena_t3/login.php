<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
<div class="content">
	<div class="title">
		<?php $studio_login_title = lang('Studios Login')?>
		<span class="eutemia "><?php echo substr($studio_login_title,0,1)?></span><span class="helvetica "><?php echo substr($studio_login_title,1)?></span>
	</div>			
	<div style="margin-left:30px;" class="f13 red italic">
	</div>
	<div class="login_boxes">
		<div class="box_b_1 f15" style="text-align: center; padding:0px; margin-right:10px; width: 348px;">

			<a href="<?php echo site_url('register')?>"><img src="<?php echo assets_url()?>images/bg_b_1_register_studio.png" /></a>

		</div>
		<div class="box_b_1">
			<div style="padding:20px;">
				<?php echo form_open('')?>
					<div class="b_sep_line">
						<span class="italic"><?php echo lang('Your name') ?>*:</span><br/>
						<?php echo form_input('username', set_value('username'), 'style="width:275px;" onfocus="if(this.value == \''.lang('username').'\') { this.value = \'\' }" onblur="if(this.value.length == 0) { this.value = \''.lang('username').'\' }"')?>
						<span class="gray italic"><?php echo form_error('username')?></span>
					</div>
					<div class="b_sep_line">
						<span class="italic"><?php echo lang('Your password') ?>*:</span><br/>
						<?php echo form_password('password', set_value('password'), 'style="width:275px;" onfocus="if(this.value == \''.lang('password').'\') { this.value = \'\' }" onblur="if(this.value.length == 0) { this.value = \''.lang('password').'\' }"')?>
						<span class="gray italic"><?php echo form_error('password')?></span>
					</div>

					<div style="margin-top:8px; text-align: center;">
						<button class="red"  type="submit" style="width:150px;"><?php echo lang('Login as studio') ?></button><br/>
						<a href="<?php echo site_url('forgot_password')?>" class="red f13 forgot_password" style="text-transform: none;"><?php echo lang('Forgot Password?') ?></a>
					</div>
				<?php echo form_close('')?>
			</div>
		</div>
	</div>

	<div class="clear"></div>
</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>	