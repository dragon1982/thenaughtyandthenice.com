<script type="text/javascript" src="<?php echo assets_url()?>js/swfobject.js"></script>
<script type="text/javascript">	
	$(document).ready(function(){
		$(".iframe").fancybox({
			'height'			: 400,
			'scrolling'			: 'no',
			'transitionIn'		: 'fade',
			'transitionOut'		: 'fade',
			'type'				: 'iframe',
			'onClosed'			: function() {
								  		parent.location.reload(false);
								  }
		});
	});

function deleteVideo(row, params, flashvars){
	var attributes = {
		Class: 'delete'
	};
	swfobject.embedSWF("<?php echo main_url('assets/swf/delete.swf')?>", "delete-"+row, "1", "1", "9.0.0","expressInstall.swf", eval('flashvars_'+row), eval('params_'+row), attributes);
	
	$('#delete_botton_'+row).find('img').attr('src', '<?=  main_url('assets/admin/images/icons/red_loader.gif')?>');
	
	setTimeout(function(){
		$('.video').eq(row).hide('slow');
	}, 3000);
}

function previewOpenVideoInModal(video_id){
	$.fancybox({
		'overlayShow': true,
		'scrolling': 'no',
		'type': 'iframe',
		'width':810,
		'height':610,				
		'showCloseButton'	: true,						
		'href': '<?php echo site_url('performers/view_video')?>' + '/' + video_id,
		'overlayColor': "#FFF",
		'overlayOpacity': "0.3"
	});		
}
</script>
<div class="container">
	<div class="conthead">
		<?php $this->load->view('includes/edit_buttons') ?>
	</div>
	<div class="contentbox">
		<div class="center_contentbox photo_center_box">
			<h2><?php echo lang('Performer Videos') ?></h2>
			<div class="full_photo_container">
				<?php if( ! empty($videos)): ?>
				<?php foreach($videos as $row => $video): ?>
					<div class="video">
						<span class="title" alt="<?php echo $video->description?>"><?php echo character_limiter($video->description,20)?></span>
						<script type="text/javascript">		
							var flashvars_<?php echo $row?> = {
								rtmp				: '<?php echo $this->fms_list[$video->fms_id]->fms_for_delete?>',
								performerId			: '<?php echo $this->user->id?>',
								videoId				: '<?php echo $video->video_id?>',								
								pasword				: '<?php echo $this->user->password?>',
								userId				: 'a<?php echo $this->user->id?>',
								uniqId				: '<?php echo uniqid(mt_rand(),TRUE)?>',
								flvName				: '<?php echo $video->flv_file_name?>'			
							};
							var params_<?php echo $row?> = {
								wmode	: 'transparent',
								border  : 'none'
							};
						</script>	
						<span id="delete_botton_<?php echo $row?>" class="delete"  onclick="deleteVideo('<?php echo $row?>', params_<?php echo $row?>, flashvars_<?=$row?>);"><img src="<?=  assets_url()?>images/icons/rejected.png" /></span>
						<span id="delete-<?php echo $row?>"></span>
						<a href="<?php echo site_url('performers/edit_video/' . $video->video_id)?>" class="edit right iframe">&nbsp;</a>
						<span class="video_preview">				
							<?php
								$data['params'] = array( 
									'videoId'			=> $video->video_id,
									'rtmp'				=> $this->fms_list[$video->fms_id]->fms_for_preview,
									'performerId'		=> $video->performer_id,
									'uniqId'			=> uniqid(mt_rand(),TRUE),
									'javaFunctionName'	=> 'previewOpenVideoInModal',
									'flvName'			=> $video->flv_file_name
								);
								$data['flash_name'] = 'v'.$video->video_id;
								$data['width']	= 220;
								$data['height']	= 165;
								$data['swf']	= 'preview.swf';
							?>
							<?php $this->load->view('flash_component',$data)?>
							<?php if($video->is_paid):?>
								<span class="cost"><?php echo print_amount_by_currency($video->price)?></span>
							<?php endif?>
							<span class="video_length"><?php echo date('i:s',$video->length)?></span>									
						</span>				
					</div>
				<?php endforeach ?>
				<?php else: ?>
					<span><?php lang('This performer has no videos.')?></span>
				<?php endif ?>
				<div class="clear"></div>
				<div class="photo_pagination"><?php echo $pagination ?></div>
			</div>		
		</div>
	</div>
</div>