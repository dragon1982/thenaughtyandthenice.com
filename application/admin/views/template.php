<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--

************************************************************************************************
This portal is powered by ModenaCam - www.modenacam.com
ModenaCam is a turnkey solution for adult/non-adult webchat portals
Custom programming, integration and designing available at custom prices
************************************************************************************************

Don't steal, it's bad luck!
























































-->
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php
		$head['title'] = 'AdminCP &#187; '.$page_head_title;
		$this->load->view('includes/_head', $head);
		?>
		
		<link rel="stylesheet" href="<?php echo assets_url('admin/css/smoothness/jquery-ui-1.8.14.custom.css') ?>">
		<script src="<?php echo assets_url('admin/js/jquery.ui.core.js') ?>"></script>
		<script src="<?php echo assets_url('admin/js/jquery.ui.widget.js') ?>"></script>
		<script src="<?php echo assets_url('admin/js/jquery.ui.datepicker.js') ?>"></script>
		<script type="text/javascript">
			$(function() {
				$( ".datepicker" ).datepicker({
					dateFormat: 'yy-mm-dd'
				});
			});
		</script>
		<script type="text/javascript">
			$(function() {
				var dates = $( ".active_since, .active_until" ).datepicker({
					minDate: "0",
					maxDate: "+1Y",
					changeMonth: false,
					dateFormat: 'yy-mm-dd',
					numberOfMonths: 1,
					onSelect: function( selectedDate ) {
						var option = this.id == "from" ? "maxDate" : "minDate",
							instance = $( this ).data( "datepicker" ),
							date = $.datepicker.parseDate(
								instance.settings.dateFormat ||
								$.datepicker._defaults.dateFormat,
								selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
					}
				});
			});
		</script>
	</head>
	<body>

		<!-- Top header/black bar start -->
		<div id="header">
			<img src="<?php echo assets_url('admin/images/logo.png') ?>" alt="AdminCP" class="logo" />
		</div>
		<!-- Top header/black bar end -->   

		<!-- Left side bar start -->
        <div id="left">
			<!-- Left side bar start -->

			<!-- Toolbox dropdown start -->
			<div id="openCloseIdentifier"></div>
			<?php $this->load->view('includes/_slider'); ?>
			<!-- Toolbox dropdown end -->   

			<!-- Userbox/logged in start -->
            <div id="userbox">
				<p>Welcome</p>
                <p><span>You are logged in as Admin</span></p>
                
                <ul style="margin-left: 60px;">
                    <li><a href="<?php echo site_url('settings') ?>" title="Configure"><img src="<?php echo assets_url('admin/images/icons/icon_cog.png') ?>" alt="Settings" /></a></li>
                    <li><a href="<?php echo site_url('home/logout') ?>" title="Logout"><img src="<?php echo assets_url('admin/images/icons/icon_unlock.png') ?>" alt="Logout" /></a></li>
                </ul>
            </div>
			<!-- Userbox/logged in end -->  

			<!-- Main navigation start -->         

        </div>
		<!-- Main navigation end --> 

		<!-- Left side bar start end -->   

		<!-- Right side start -->     
        <div id="right">

			<!-- Breadcrumb start -->  
            <div id="breadcrumb">
                <ul>	
					<li><img src="<?php echo assets_url('admin/images/icon_breadcrumb.png') ?>" /></li>
                    
					<?php
						if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb) > 0){
							echo '<li><a href="'. site_url('statistics').'">'.lang('Dashboard').'</a></li>';
							foreach( $breadcrumb as $_name => $_link){
								echo '<li><img src="'.assets_url('admin/images/icon_breadcrumb.png') . '" /></li>';
								if($_link == 'current'){
									echo '<li class="current">'.$_name.'</li>';
								}else{
									echo '<li><a href="'.$_link.'">'.$_name.'</a></li>';
								}
							}
						}else{
							echo '<li class="current">'.lang('Dashboard').'</li>';
						}
					?>
                    
                    
                </ul>
            </div>
			<!-- Breadcrumb end -->  

			<!-- Top/large buttons start -->  
			<?php $this->load->view('includes/_menu'); ?>
			<!-- Top/large buttons end -->  
		</div>

		<!-- Main content start -->      
		<div id="content"> 
			<?php $this->load->view('includes/errors'); ?>

			<?php if(isset($page)){
				$this->load->view($page);
			} ?>
		</div>

		<?php $this->load->view('includes/_footer'); ?>
	</body>
</html>
