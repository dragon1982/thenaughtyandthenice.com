<div class="logo">
	<a href="<?php echo base_url()?>"><img src="<?php echo assets_url()?>images/logo.png"/></a>
</div>

<?php if($this->user->id > 0 && $this->user->type == 'affiliate' && FALSE):?>
	<div class="top_login affiliate">
		<?php echo form_open('login')?>
		<div class="fields">
			<input type="text" name="username" value="<?php echo lang('username')?>" style="width: 117px;" onfocus="if(this.value == '<?php echo lang('username')?>') { this.value = '' }" onblur="if(this.value.length == 0) { this.value = '<?php echo lang('username')?>' }"/>
			<input type="password" name="password" value="<?php echo lang('password')?>" style="width: 117px;" onfocus="if(this.value == '<?php echo lang('password')?>') { this.value = '' }" onblur="if(this.value.length == 0) { this.value = '<?php echo lang('password')?>' }"/>
			<input type="submit" value="<?php echo lang('Login') ?>" class="red"/>
		</div>
		<div style="margin-left:10px;">
			<span class="gray italic bold"><?php echo lang('Keep me logged in')?> <input type="checkbox" value="1" name="remeber"/></span>
			<span style="display:inline-block; margin-left:18px;"><a href="forgot_password" class="red italic bold"><?php echo lang('Forgot Password') ?>?</a></span>
		</div>


		<?php echo form_close()?>
	</div>
<?php endif ?>