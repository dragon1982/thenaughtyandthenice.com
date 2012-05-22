<script type="text/javascript" src="<?php echo assets_url()?>js/swfobject.js"></script>
<script type="text/javascript">
var flashvars = {
	rtmp				: '<?php echo $this->fms_list[$video->fms_id]->fms_for_video ?>',
	performerId			: '<?php echo $video->performer_id?>',
	uniqId				: '<?php echo uniqid(mt_rand(),TRUE)?>',
	videoId				: '<?php echo $video->video_id?>',
	pasword				: '<?php echo $this->user->password?>',
	userId				: 'a<?php echo $this->user->id?>',
	userName			: '<?php echo $this->user->username?>',	

};
var params = {
	wmode	: 'transparent',
	allowfullscreen: true
};
var attributes = {};

swfobject.embedSWF("<?php echo main_url('assets/swf/flvplayer.swf')?>", "flashContent", "800", "600", "9.0.0","expressInstall.swf", flashvars, params, attributes);
</script>
<div id="flashContent">
	<h1><?php echo lang('In order to view this video you must have Adobe Flash Player installed!') ?></h1>
	<p><a href="http://www.adobe.com/go/getflashplayer" target="_blank"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
</div>