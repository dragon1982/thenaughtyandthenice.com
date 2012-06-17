<div class="top_login">
	<?php echo form_open('login')?>
	<span class="eutemia top_text"><?php echo lang('Members Login')?></span>
	<div class="fields">
		<?php echo form_input('username',set_value('username',lang('username')),'style="width: 117px;"  onfocus="if(this.value == \''.lang('username').'\') { this.value = \'\' }" onblur="if(this.value.length == 0) { this.value = \''.lang('username').'\' }"')?>
		<?php echo form_password('password',set_value('password',lang('password')),'style="width: 117px;" onfocus="if(this.value == \''.lang('password').'\') { this.value = \'\' }" onblur="if(this.value.length == 0) { this.value = \''.lang('password').'\' }"')?>
		<input type="submit" value="Login" class="red"/>
	</div>
	<div style="margin-left:10px;">
		<span style="display:inline-block; width:123px; text-align: center;"><a href="<?php echo site_url('register')?>" class="red italic bold signup"><?php echo lang('Sign Up')?></a></span>
		<span style="display:inline-block; width:123px; text-align: center;"><a href="<?php echo site_url('forgot-password')?>" class="red italic bold forgot_password"><?php echo lang('Forgot Password?')?></a></span>
	</div>
	<?php echo form_close()?>
</div>