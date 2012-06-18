<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<?$this->load->view('includes/head')?>
	</head>

	<body style="background: transparent; background-image: none;">
		<div id="become_member">

	  <script type="text/javascript">
		var $j = jQuery.noConflict();
		</script>

			<div class="fancy_box_close" onclick="javascript:parent.$j.fancybox.close();"><img src="<?php echo assets_url()?>images/spacer.gif" width="16" height="16" style="cursor:pointer; " /></div>
			<div class="content">
				<div style="margin-left: 335px; padding-top: 10px;">
					<span class="eutemia text_shadow" style="font-size:40px;"><?php echo lang('Become a member') ?></span>
				</div>

				<div class="form">
					<?php echo form_open('register','id="register" name="register"')?>
					<span class="italic"><?php echo lang('Username:')?></span><br/>
					<?php echo form_input('username', set_value('username'), 'style="width:310px;" tabindex="1"')?>
					<span class="input_helper_l gray italic f10" style="width:293px;"><span class="input_helper_line"><?php echo form_error('username')?form_error('username'):($this->input->post('username')?NULL:lang('Username length should be between 4 and 25 chars?'))?></span></span><span class="input_helper_r"></span>

					<div style="width:160px; float:left;">
						<div style="margin-top:15px;">
							<span class="italic"><?php echo lang('Email Address:')?></span><br/>
							<?php echo form_input('email', set_value('email'), 'style="width:147px;" tabindex="2"')?>
							<span class="input_helper_l gray italic f10" style="width:135px;"><span class="input_helper_line"><?php echo form_error('email')?form_error('email'):($this->input->post('email')?NULL:lang('Email Address must be valid!'))?></span></span><span class="input_helper_r"></span>
						</div>
						<div style="margin-top:15px;">
							<span class="italic"><?php echo lang('Password:')?></span><br/>
							<?php echo form_password('password', NULL, 'style="width:147px;" tabindex="4"')?>
							<span class="input_helper_l gray italic f10" style="width:135px;"><span class="input_helper_line"><?php echo form_error('password')?form_error('password'):($this->input->post('password')?NULL:lang('Password must be valid!'))?></span></span><span class="input_helper_r"></span>
						</div>
					</div>
					<div style="width:160px; float:left;">
						<div style="margin-top:15px;">
							<span class="italic"><?php echo lang('Repeat Email Address:')?></span><br/>
							<?php echo form_input('repeat_email', set_value('repeat_email'), 'style="width:147px;" tabindex="3"')?>
							<span class="input_helper_l gray italic f10" style="width:135px;"><span class="input_helper_line"><?php echo form_error('repeat_email')?form_error('repeat_email'):($this->input->post('repeat_email')?NULL:lang('Email Address must match!'))?></span></span><span class="input_helper_r"></span>
						</div>
						<div style="margin-top:15px;">
							<span class="italic"><?php echo lang('Repeat Password:')?></span><br/>
							<?php echo form_password('repeat_password', NULL, 'style="width:147px;" tabindex="5"')?>
							<span class="input_helper_l gray italic f10" style="width:135px;"><span class="input_helper_line"><?php echo form_error('repeat_password')?form_error('repeat_password'):($this->input->post('repeat_password')?NULL:lang('Password must match!'))?></span></span><span class="input_helper_r"></span>
						</div>
					</div>

					<div class="clear"></div>

					<div class="buttons">
						<span class="big_b_btn white bold" onclick="document.forms['register'].submit()">
							<?php echo sprintf(lang('Click here to %s become a %s member'),'<br/>','<br/>') ?>
						</span>
						<span class="big_b_btn white bold" onclick="parent.$.fancybox.close();">
							<?php $log_in_here_red = '<span class="red">'. lang('log in here') . '</span>'; ?>
							<?php echo sprintf(lang('Already a %s member? %s'),'<br/>','<br/>') ?>
							<?php echo $log_in_here_red ?>
						</span>
					</div>

				<?php echo form_close()?>
				</div>
			</div>

		</div>
	</body>
</html>