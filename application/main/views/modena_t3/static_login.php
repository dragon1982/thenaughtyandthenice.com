<!DOCTYPE>
<html>
	<head>
		<?$this->load->view('includes/head')?>
		<link rel="stylesheet" href="<?php echo assets_url()?>css/register.css">
	</head>

	<body style="background: transparent; background-image: none;">

	  <script type="text/javascript">
		var $j = jQuery.noConflict();
		<?php if($succes):?>
			parent.location.reload();
			parent.$.fancybox.close();
		<?php endif;?>
		</script>

	<div class="form-t1">
    	<div class="fancy_box_close" onclick="javascript:parent.$.fancybox.close();"><img src="<?php echo assets_url()?>images/popup-close-btn.png" style="cursor:pointer; "></div>
        <?php echo form_open('login','id="login" name="login"')?>
        	<div class="form-header">Login</div>
            <div class="form-t1-content">

								<input type="hidden" name="run_form_validation" value= "1" />

								<?php if(form_error('password')):?>
									<div class="alert-box error">
										<?php echo form_error('password')?>
									</div>
								<?php endif?>

                <div class="form-line-2">
                    <?php echo form_input('username',set_value('username',lang('username')),'class="nice-input-2  large"  onfocus="if(this.value == \''.lang('username').'\') { this.value = \'\' }" onblur="if(this.value.length == 0) { this.value = \''.lang('username').'\' }"')?>
                </div><!--end form-line-2-->

                <div class="form-line-2">
		                <?php echo form_password('password',set_value('password',lang('password')),'class="nice-input-2  large" onfocus="if(this.value == \''.lang('password').'\') { this.value = \'\' }" onblur="if(this.value.length == 0) { this.value = \''.lang('password').'\' }"')?>
                </div><!--end form-line-2-->

                <div class="submit-form-line-2">
                	<input class="submit-btn-2" type="submit" value="Login">
                </div>

                <div class="form-t1-liks"><a href="javascript:;">Forgot password?</a> <span>|</span> <a href="<?php echo site_url('register')?>">Register</a></div>

            </div><!--end  form-t1-content-->

       <?php echo form_close()?>
	</div><!--end form-t1-->

	</body>
</html>















<?php if(false):?>
			<div class="fancy_box_close" onclick="javascript:parent.$j.fancybox.close();"><img src="<?php echo assets_url()?>images/spacer.gif" width="16" height="16" style="cursor:pointer; " /></div>
			<div class="content">
				<div style="margin-left: 335px; padding-top: 10px;">
					<span class="eutemia text_shadow" style="font-size:40px;"><?php echo lang('Member login') ?></span>
				</div>

				<div class="form">
					<?php echo form_open('login','id="login" name="login"')?>

					<input type="hidden" name="run_form_validation" value= "1" />

					<span class="italic"><?php echo lang('Username:')?></span><br/>
					<?php echo form_input('username',set_value('username',lang('username')),'style="width: 117px;"  onfocus="if(this.value == \''.lang('username').'\') { this.value = \'\' }" onblur="if(this.value.length == 0) { this.value = \''.lang('username').'\' }"')?>

					<div style="width:160px; float:left;">
						<div style="margin-top:15px;">
							<span class="italic"><?php echo lang('Password:')?></span><br/>
							<?php echo form_password('password',set_value('password',lang('password')),'style="width: 117px;" onfocus="if(this.value == \''.lang('password').'\') { this.value = \'\' }" onblur="if(this.value.length == 0) { this.value = \''.lang('password').'\' }"')?>
						</div>
					</div>

					<?php echo form_error('password')?form_error('password'):''?>

					<div class="clear"></div>
					<span style="display:inline-block; width:123px; text-align: center;"><a href="<?php echo site_url('forgot-password')?>" class="red italic bold forgot_password"><?php echo lang('Forgot Password?')?></a></span>
					<div class="clear"></div>

					<div class="buttons">
							<input onclick="document.forms['static_login'].submit()" type="submit" value="Login" class="red"/>
					</div>

				<?php echo form_close()?>
				</div>
			</div>
<?php endif;?>