<script type="text/javascript" src="<?php echo assets_url()?>js/swfobject.js"></script>
<script type="text/javascript">
var flashvars = {
	rtmp				: '<?php echo $fms->fms_for_video ?>',
	performerId			: '<?php echo $performer->id?>',
	uniqId				: '<?php echo $this->watchers->generate_one_unique_id()?>',
	videoId				: '<?php echo $video->video_id?>',
<?php if($this->user->id > 0):?>		
	pasword				: '<?php echo $this->user->password?>',
	userId				: 'v<?php echo $this->user->id?>',
	userName			: '<?php echo $this->user->username?>',	
<?php else:?>
	userName			: 'Anonymus<?php echo mt_rand(1000,9999)?>',
	userId				: 'v'
<?php endif?>
};
var params = {
	wmode	: 'transparent',
	allowfullscreen: true
};
var attributes = {};

swfobject.embedSWF("<?php echo main_url('assets/swf/flvplayer.swf')?>", "flashContent", "800", "600", "9.0.0","expressInstall.swf", flashvars, params, attributes);
</script>
<div id="flashContent">
	<h1><?php echo lang('In order to Go Online you must have Adobe Flash Player installed!') ?></h1>
	<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
</div>