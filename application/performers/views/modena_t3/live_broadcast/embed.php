<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title><?php echo lang('Live broadcasting - ').SETTINGS_SITE_TITLE ?></title>
	<script type="text/javascript" src="<?php echo assets_url()?>js/swfobject.js"></script>
</head>
<body style="margin:0px;background-color:#000">
	<script type="text/javascript">
		function downloadXml(){
			window.open('<?php echo site_url('fmle')?>?url=<?php echo $fms->fms?>&stream=cam1&fms_id=<?php echo $fms->fms_id?>','Download');
		}
	</script>
	<script type="text/javascript">
	
	var flashvars = {
		bandwidthTestRtmp 	: '<?php echo $fms->fms_test?>',
		rtmp				: '<?php echo $fms->fms?>',
		fmsId				: '<?php echo $fms->fms_id?>',
		performerId			: '<?php echo $performer->id?>',
		pasword				: '<?php echo $performer->password?>',
		userName			: '<?php echo $performer->nickname?>',
		uniqId				: '<?php echo $unique_id?>',
		nickColor			: '0x129400',
		showSwitch			: 'true',
		sitePath			: '<?php echo main_url()?>',
	<?php if( $fmle): ?>
		fmleUrl				: '<?php echo base64_encode($fms->fms. $this->user->id .'?userId=' . $this->user->id . '&uniqId=' . $unique_id . '&pasword=' . $this->user->password . '&performerId=' . $this->user->id . '&username=' . $this->user->username . '&fmsId='.$fms->fms_id)?>',			
		fmleStream 			: 'cam1',
	<?php endif?>
		recPrivateShow		: 'false'
	};
	var params = {};
	var attributes = {};
	<?php if( $fmle ) :?>
		swfobject.embedSWF("<?php echo main_url('assets/swf/performerFMLE.swf')?>", "flashContent", "940", "560", "9.0.0","expressInstall.swf", flashvars, params, attributes);
	<?php else:?>
		swfobject.embedSWF("<?php echo main_url('assets/swf/performer.swf')?>", "flashContent", "940", "560", "9.0.0","expressInstall.swf", flashvars, params, attributes);
	<?php endif?>
	
	</script>
	<div id="flashContent">
		<h1><?php echo lang('In order to Go Online you must have Adobe Flash Player installed!') ?></h1>
		<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
	</div>
</body>
</html>