<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo SETTINGS_SITE_TITLE.' - '.lang('Administration')?></title>
		<link href="<?php echo assets_url('admin/css/main.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo assets_url('admin/css/login.css') ?>" rel="stylesheet" type="text/css" />
	</head>
	<body>

		<div id="logincontainer">

			<div style="text-align: left">
				<?$this->load->view('includes/errors');?>
			</div>

			<h1><?php echo lang('M<span>odena</span>C<span>am</span> A<span>dministration</span>') ?></h1>
			<div id="loginbox" style="height: 160px;">

				<?php echo form_open()?>
					<div class="inputcontainer">
						<img src="<?php echo assets_url('admin/images/icons/icon_username.png') ?>" alt="Username" />
						<label for="username"><?php echo lang('Username')?>:</label>
						<input type="text" name="username" id="username" tabindex="1" />
					</div>
					
					<div class="inputcontainer">
						<img src="<?php echo assets_url('admin/images/icons/icon_locked.png') ?>" alt="Password" />
						<label for="password"><?php echo lang('Password')?>:</label>
						<input type="password" name="password" id="password" tabindex="2" />
					</div>										
					<input type="submit" value="<?php echo lang('Login')?>" class="loginsubmit" tabindex="3" style="margin-top: 10px;" />
				<?php echo form_close()?>
			</div>
		</div>

		<script type="text/javascript">
			try{document.getElementById('username').focus();}catch(e){}
		</script>
	</body>
</html>
