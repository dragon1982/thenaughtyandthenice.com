<script src="<?php echo assets_url()?>/js/jquery.ui.stars.min.js"></script>
<script type="text/javascript">
function deleteVideo(row, params, flashvars){
	var attributes = {
		Class: 'delete'
	};
	swfobject.embedSWF("<?php echo main_url('assets/swf/delete.swf')?>", "delete-"+row, "1", "1", "9.0.0","expressInstall.swf", flashvars, params, attributes);
	
	$('#delete_botton_'+row).find('img').attr('src', '<?=  assets_url()?>images/icons/red_loader.gif');
	
	setTimeout(function(){
		$('.video').eq(row).hide('slow');
	}, 3000);
}

function previewOpenVideoInModal(video_id){
	$.fancybox({
		'overlayShow': true,
		'scrolling': 'no',
		'type': 'iframe',
		'width':800,
		'height':600,				
		'showCloseButton'	: true,						
		'href': '<?php echo site_url('videos/view')?>' + '/' + video_id,
		'overlayColor': "#FFF",
		'overlayOpacity': "0.3"
	});		
}

</script>
<!-- jQuery rating -->

<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $my_videos_title = lang('My Videos') ?>
			<span class="eutemia"><?php echo substr($my_videos_title,0,1)?></span><span class="helvetica"><?php echo substr($my_videos_title,1)?></span>
		</div>
		<script type="text/javascript" src="<?php echo assets_url()?>js/swfobject.js"></script>
		<div id="videos">
			<?php if(sizeof($videos) == 0):?>
			<div style="text-align:center">
				<div clsas="error_mess"><?php echo lang('There are no videos!')?></div>
			</div>
			<?php else:?>
				<?php foreach ($videos as $row => $video):?>
					<div class="video">
						<?php if($video->description):?>
							<span></span>
						<?php endif?>
						<script type="text/javascript">		
							var flashvars_<?php echo $row?> = {
								rtmp				: '<?php echo $fms[$video->fms_id]->fms_for_delete?>',
								performerId			: '<?php echo $this->user->id?>',
								videoId				: '<?php echo $video->video_id?>',								
								pasword			: '<?php echo $this->user->password?>',
								userId				: 'p<?php echo $this->user->id?>',
								uniqId				: '<?php echo $this->watchers->generate_one_unique_id()?>',
								flvName				: '<?php echo $video->flv_file_name?>'			
							};
							var params_<?php echo $row?> = {
								wmode	: 'transparent',
								border  : 'none'
							};
							
						</script>	
						
						<span id="delete_botton_<?php echo $row?>" class="delete"  onclick="deleteVideo('<?php echo $row?>', params_<?php echo $row?>, flashvars_<?=$row?>);"><img src="<?=  assets_url()?>images/icons/rejected.png" /></span>
						
						<a href="<?php echo site_url('videos/edit/' . $video->video_id)?>" class="edit right">&nbsp;</a>
						<div id="preview-<?php echo $row?>">
							<script type="text/javascript">		
								var flashvars = {
									videoId				: '<?php echo $video->video_id?>',
									rtmp				: '<?php echo $fms[$video->fms_id]->fms_for_preview?>',
									performerId			: '<?php echo $this->user->id?>',
									uniqId				: '<?php echo $this->watchers->generate_one_unique_id()?>',
									javaFunctionName	: 'previewOpenVideoInModal',									
									flvName				: '<?php echo $video->flv_file_name?>'			
								};
								var params = {
									wmode	: 'transparent'
								};
								var attributes = {};
								
								swfobject.embedSWF("<?php echo main_url('assets/swf/preview.swf')?>", "preview-<?php echo $row?>", "220", "165", "9.0.0","expressInstall.swf", flashvars, params, attributes);
							</script>					
						</div>														
						<?php if($video->is_paid):?>
							<span class="cost"><?php echo print_amount_by_currency($video->price)?></span>
						<?php endif?>						
						<span class="video_length"><?php echo date('i:s',$video->length)?></span>
						<span  id="delete-<?php echo $row?>"  style="width:1px; height: 1px; overflow: hidden;"></span>
					</div>
				<?php endforeach?>
			<?php endif?>
		</div>
        <div class="clear"></div>
        <?php echo $pagination?>
        <div class="clear"></div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>