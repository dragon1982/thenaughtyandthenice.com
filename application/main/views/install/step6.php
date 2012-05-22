<?php
        function dinamic_base_url() {
                $url = explode('index.php',$_SERVER['PHP_SELF']);
                return $url[0];
        }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>	
	<head>
		<title>ModenaCam Install - Step 5/5</title>
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
		<script type="text/javascript" src="<?php echo dinamic_base_url();?>assets/install/js/jquery-1.4.2.min.js" charset="utf-8"></script>
		
		<div class="warper">
			<div class="titleSteps">ModenaCam Setup <span>5/5</span></div>
			<div class="pageTopBg">&nbsp;</div>
			<div class="pageBg">
				<h1>Final Settings</h1>
				<span style="font-family: 'Calibri'; font-size: 20px; color: #FE0000;">
 						Do not forget to install these crons:<br/><br />
 				</span>
 				<span style="font-size:12px;width:100%">
						0 0 * * * wget -q --delete-after <?php echo site_url('cron/error_reporter')?>?key=<?php echo $this->config->item('salt')?><br />
						*/5 * * * * wget -q --delete-after <?php echo site_url('cron/shutdown_frozen_chatrooms')?>?key=<?php echo $this->config->item('salt')?><br />
						*/5 * * * * wget -q --delete-after <?php echo site_url('cron/closed_frozen_watchers')?>?key=<?php echo $this->config->item('salt')?><br />
						10 1 1,16 * * wget -q --delete-after <?php echo site_url('cron/generate_payments')?>?key=<?php echo $this->config->item('salt')?><br />
						*/5 * * * * wget -q --delete-after <?php echo site_url('cron/move_watchers')?>?key=<?php echo $this->config->item('salt')?><br />
						*/2 * * * * wget -q --delete-after <?php echo site_url('cron/update_fms_ballance')?>?key=<?php echo $this->config->item('salt')?><br />
						*/5 * * * * wget -q --delete-after <?php echo site_url('cron/update_online_performers')?>?key=<?php echo $this->config->item('salt')?><br />
						0 0 * * * wget -q --delete-after <?php echo site_url('cron/delete_old_files')?>?key=<?php echo $this->config->item('salt')?><br />
						0 0 * * * wget -q --delete-after <?php echo site_url('cron/delete_old_users')?>?key=<?php echo $this->config->item('salt')?><br />
						*/10 * * * * wget -q --delete-after <?php echo site_url('cron/newsletters')?>?key=<?php echo $this->config->item('salt')?><br />
 				</span>			
 				<br />
 				<h1>Additional infos</h1>
 				
 				Usefull links:<br /><br />
 				<ul>
	 				<li><a href="<?php echo base_url()?>">Home page</a></li>
	 				<li><a href="<?php echo base_url()?>admin/settings/">Admin settings</a></li>
 				</ul> 				
				<div class="btnDiv" onclick="document.location='<?php echo base_url()?>'"><input type="submit" value="Go to main page"  class="blackBtn" /></div>
			</div>
			<div class="pageBottomBg">&nbsp;</div>
		</div>
	</body>
</html>