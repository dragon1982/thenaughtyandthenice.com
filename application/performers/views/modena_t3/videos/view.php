<script type="text/javascript" src="<?php echo assets_url()?>js/swfobject.js"></script>
<script type="text/javascript">
var flashvars = {
	videoId				: '<?php echo $video->video_id?>',
	rtmp				: '<?php echo $fms->fms_for_video ?>',
	performerId			: '<?php echo $performer->id?>',
	flvName				: '<?php echo $video->flv_file_name?>',
	path				: '<?php echo $fms->fms_for_video ?>',
	pasword				: '<?php echo $this->user->password?>',
	userId				: 'p<?php echo $this->user->id?>',
	userName			: '<?php echo $this->user->username?>'
		
};
var params = {};
var attributes = {};

swfobject.embedSWF("<?php echo main_url('assets/swf/flvplayer.swf')?>", "flashContent", "800", "600", "9.0.0","expressInstall.swf", flashvars, params, attributes);</script>
<div id="flashContent">
	<h1><?php echo lang('In order to Go Online you must have Adobe Flash Player installed!') ?></h1>
	<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
</div>