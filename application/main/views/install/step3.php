<?php
        function dinamic_base_url() {
                $url = explode('index.php',$_SERVER['PHP_SELF']);
                return $url[0];
        }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>	
	<head>
		<title>ModenaCam Install - Step 3/5</title>
		<link rel="stylesheet" href="<?php echo dinamic_base_url();?>assets/install/install.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo dinamic_base_url();?>assets/install/widefat/widefat-gray-ultra-light.css" type="text/css" media="screen" />

		<!--[if IE 7]>
		<link href="<?php echo dinamic_base_url();?>assets/install/installie7.css" rel="stylesheet" type="text/css" />
		<![endif]-->
		<!--[if IE 8]>
		<link href="<?php echo dinamic_base_url();?>assets/install/installie8.css" rel="stylesheet" type="text/css" />
		<![endif]-->
	</head>
	<body>
		<script type="text/javascript" src="<?php echo dinamic_base_url();?>assets/install/js/wz_tooltip.js" charset="utf-8"></script>
		<div class="warper">
			<div class="titleSteps">ModenaCam Setup <span>3/5</span></div>
			<div class="pageTopBg">&nbsp;</div>
			<div class="pageBg">
				<h1>Database Settings</h1>
				<?php echo validation_errors()?>
				<?php echo form_open()?>
					<table cellpadding="0" cellspacing="10" style="margin: auto;">
						<tr>
							<td class="fieldName">Database Host</td>
							<td><?php echo form_input('database_host',set_value('database_host','localhost'),'class="field"')?>
							<td class="fieldDesc">Most of the time the database host is <b>localhost</b></td>
						</tr>
					
						<tr>
							<td class="fieldName">Database Username</td>
							<td><?php echo form_input('database_username',set_value('database_username'),'class="field"')?>														
							<td class="fieldDesc">Your MySQL username</td>
						</tr>

						<tr>
							<td class="fieldName">Database Password</td>
							<td><?php echo form_input('database_password',set_value('database_password'),'class="field"')?>																					
							<td class="fieldDesc">Your MySQL password</td>
						</tr>

						<tr>
							<td class="fieldName">Database Name</td>
							<td><?php echo form_input('database_name',set_value('database_name'),'class="field"')?>																												
							<td class="fieldDesc">The name of the database you want to run ModenaCam in</td>							
						</tr>
					</table> 
					<div class="btnDiv"><input type="submit" value="Continue"  class="blackBtn" /></div>
				<?php echo form_close()?>									
			</div>
			<div class="pageBottomBg">&nbsp;</div>
		</div>
	</body>
</html>