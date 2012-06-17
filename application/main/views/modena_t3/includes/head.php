<?php
$_lang = $this->config->item('lang_selected');
if (empty($_lang))
{
    $_lang = "en";
}
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo $_lang;?>">
	<head>
<title><?php echo ($pageTitle)? $pageTitle : SETTINGS_SITE_TITLE ?></title>

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

<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>addons/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
	var base_url = '<?php echo base_url()?>';
	var assets_url = '<?php echo assets_url()?>';
</script>
<script type="text/javascript" src="<?php echo assets_url()?>js/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.blockUI.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>js/scripts.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>addons/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>addons/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<!-- TIPSY STRAT -->
<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.tipsy.js"></script>
<script type="text/javascript">
	$(function() {
		// Tipsy
		$('.south').tipsy({gravity: 's'});
	});
</script>

<!-- TIPSY END -->
<script type="text/javascript">
jQuery(function($){
	$('.confirm, .pay_gallery').click(function() {
		var link = $(this).attr('href');
		$.ajax({
			url: link+'/?confim=true',
			complete: function(html) {
				$.blockUI({ message: html.responseText});
			}
		});
		return false;
	});

	$('.modal').fancybox({
		'overlayShow': true,
		'scrolling': 'no',
		'type': 'iframe',
		'titleShow'			: false,
		'overlayColor'		: '#000',
		'overlayOpacity'	: 0.6,
		'showCloseButton'	: true
	});

	$('.forgot_password').fancybox({
		'showCloseButton'	: true,
		'padding'			: 0,
		'scrolling'			: 'no',
		'titleShow'			: false,
		'type'				: 'iframe',
		'overlayColor'		: '#000',
		'overlayOpacity'	: 0.6,
		'width'				: 348,
		'height'			: 238
	});



	$(".signup").fancybox({
		'showCloseButton'	: false,
		'padding'			: 0,
		'overlayColor'		: '#000  ',
		'overlayOpacity'	: 0.6,
		'type'				: 'iframe',
		'titleShow'			: false,
		'href'				: '<?php echo site_url('register')?>',
		'width'				: 630,
		'height'			: 458
	});
});
</script>
<script src="<?php echo assets_url()?>js/jquery.ui.core.js"></script>
<script src="<?php echo assets_url()?>js/jquery.ui.widget.js"></script>
<link rel="stylesheet" href="<?php echo assets_url()?>css/blitzer/jquery-ui-1.8.14.custom.css">

	<link rel="stylesheet" href="<?php echo assets_url()?>css/main.css">
</head>