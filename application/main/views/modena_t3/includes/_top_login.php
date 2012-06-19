		            <div class="account-info">
		            	<a id="register" class="btn-nice-1 sufix10" href="<?php echo site_url('register')?>">Register <span>(FREE)</span></a>
		                Already a member? <a class="btn-nice-2 prefix5" href="<?php echo site_url('login/static_login')?>">Sign In</a>
		            </div><!--end right-->

<?php if(false):?>
<div class="top_login">
	<?php echo form_open('login')?>
	<div class="fields">
		<?php echo form_input('username',set_value('username',lang('username')),'style="width: 117px;"  onfocus="if(this.value == \''.lang('username').'\') { this.value = \'\' }" onblur="if(this.value.length == 0) { this.value = \''.lang('username').'\' }"')?>
		<?php echo form_password('password',set_value('password',lang('password')),'style="width: 117px;" onfocus="if(this.value == \''.lang('password').'\') { this.value = \'\' }" onblur="if(this.value.length == 0) { this.value = \''.lang('password').'\' }"')?>
		<input type="submit" value="Login" class="red"/>
	</div>
	<div style="margin-left:10px;">
		<span style="display:inline-block; width:123px; text-align: center;"><a href="<?php echo site_url('forgot-password')?>" class="red italic bold forgot_password"><?php echo lang('Forgot Password?')?></a></span>
	</div>
	<?php echo form_close()?>
</div>
<?php endif;?>