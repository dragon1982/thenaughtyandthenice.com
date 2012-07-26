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
			//parent.location.reload();
			//parent.$.fancybox.close();
		<?php endif;?>
		</script>


		<div class="form-t1">
					<div class="fancy_box_close" onclick="javascript:parent.$.fancybox.close();"><img src="<?php echo assets_url()?>images/popup-close-btn.png" style="cursor:pointer; "></div>

	        <?php echo form_open('register','id="register" name="register"')?>
	        	<div class="form-header"><?php echo lang('Become a member') ?></div>
	            <div class="form-t1-content">

	                <div class="form-line-2">
	                    <?php echo form_input('username', set_value('username'), 'class="nice-input-2 error large" tabindex="1"')?>
	                    <div class="input-desc"><?php echo form_error('username')?form_error('username'):($this->input->post('username')?NULL:lang('Username length should be between 4 and 25 chars?'))?></div>
	                </div><!--end form-line-2-->

	                <div class="form-line-2 clearfix">
	                	<div class="form-line-left">
	                			<?php echo form_input('email', set_value('email'), 'class="nice-input-2 small" tabindex="1"')?>
	                    	<div class="input-desc"><?php echo form_error('email')?form_error('email'):($this->input->post('email')?NULL:lang('Email Address must be valid!'))?></div>
	                    </div>
	                    <div class="form-line-right prefix20">
	                    	<?php echo form_input('repeat_email', set_value('repeat_email'), 'class="nice-input-2 small" tabindex="1"')?>
	                    	<div class="input-desc"><?php echo form_error('repeat_email')?form_error('repeat_email'):($this->input->post('repeat_email')?NULL:lang('Email Address must match!'))?></div>
	                    </div>
	                </div><!--end form-line-2-->

	                <div class="form-line-2 clearfix">
	                	<div class="form-line-left">
	                    	<?php echo form_password('password', null, 'class="nice-input-2 small erro" tabindex="1"')?>
	                    	<div class="input-desc"><?php echo form_error('password')?form_error('password'):($this->input->post('password')?NULL:lang('Password must be valid!'))?></div>
	                    </div>
	                    <div class="form-line-right prefix20">
	                    	<?php echo form_password('repeat_password', null, 'class="nice-input-2 small" tabindex="1"')?>
	                    	<div class="input-desc"><?php echo form_error('repeat_password')?form_error('repeat_password'):($this->input->post('repeat_password')?NULL:lang('Password must match!'))?></div>
	                    </div>
	                </div><!--end form-line-2-->

	                <div class="submit-form-line-2">
	                	<input class="submit-btn-2" type="submit" value="Register">
	                </div>

	            </div><!--end  form-t1-content-->
	            <div class="form-footer">
                <div>Already a member?</div>
                <a href="<?php echo site_url('login')?>">Login here ></a>
	            </div>
	        	<?php echo form_close()?>
			</div><!--end form-t1-->


	</body>
</html>