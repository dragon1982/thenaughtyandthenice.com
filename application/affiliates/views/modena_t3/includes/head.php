<?php 
$_lang = $this->config->item('lang_selected');
if (empty($_lang))
{
    $_lang = "en";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--

************************************************************************************************
This portal is powered by ModenaCam - www.modenacam.com
ModenaCam is a turnkey solution for adult/non-adult webchat portals
Custom programming, integration and designing available at custom prices
************************************************************************************************

Don't steal, it's bad luck!
























































-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo $_lang;?>">
<head>			
<title><?php echo ($page_title)? $page_title : SETTINGS_SITE_TITLE ?></title>
<meta name="description" content="<?php echo ($description)? $description : SETTINGS_SITE_DESCRIPTION ?>" />
<meta name="keywords" content="<?php echo ($keywords)? $keywords : SETTINGS_SITE_KEYWORDS ?>" />
<meta name="copyright" content="Copyright Modena Cam 2011. All rights reserved">
<meta name="owner" content="Modenacam">
<meta name="publisher" content="ModenaCam">
<meta name="author" content="Modenacam">
<meta name="language" content="english">
<meta name="rating" content="General">
<meta name="expires" content="never">
<meta name="distribution" content="Global">
<meta name="robots" content="index,FOLLOW">
<meta name="revisit-after" content="1 days">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="<?php echo $_lang?>">
	
<!-- FAVICON -->
<link rel="shortcut icon" href="<?=assets_url()?>favicon.ico" type="image/x-icon"/>
<link rel="icon" href="<?=assets_url()?>favicon.ico" type="image/x-icon"/>
		
<?php $this->load->view('includes/headVersion')?>
<link rel="stylesheet" type="text/css" href="<?php echo main_url()?>/assets/<?php echo SETTINGS_DEFAULT_THEME?>/css/fonts.css" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>addons/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="<?php echo assets_url()?>js/jquery-1.5.1.js"></script>
<script src="<?php echo assets_url()?>js/jquery.ui.core.js"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url()?>';
	var assets_url = '<?php echo assets_url()?>';
</script>


<script type="text/javascript" src="<?php echo assets_url()?>js/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>js/scripts.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>addons/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>addons/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript">
jQuery(function($){
	$('.forgot_password').fancybox({
		'showCloseButton'	: true,
		'padding'			: 0,
		'scrolling'			: 'no',
		'type'				: 'iframe',
		'overlayColor'		: '#fff',
		'overlayOpacity'	: 0.28,
		'width'				: 348,
		'height'			: 238
	});
	
	
});
</script>
<script src="<?php echo assets_url()?>js/jquery.ui.widget.js"></script>
<script src="<?php echo assets_url()?>js/jquery.ui.core.js"></script>
<link rel="stylesheet" href="<?php echo assets_url()?>css/blitzer/jquery-ui-1.8.14.custom.css">
</head>