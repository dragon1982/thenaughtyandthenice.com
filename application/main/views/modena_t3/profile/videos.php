<?php if(sizeof($videos) == 0 && sizeof($videos_paid) == 0):?>
<div>
	<div class="error_mess"><?php echo lang('There are no videos!')?></div>
</div>
<?php else:?>
<script type="text/javascript">
function previewOpenVideoInModal(video_id){
	$.fancybox({
					'overlayShow': true,
					'scrolling': 'no',
					'type': 'iframe',
					'width':800,
					'height':600,				
					'showCloseButton'	: true,						
					'href': '<?php echo site_url('videos/view')?>' + '/' + video_id,
					'overlayColor': "#000",
					'overlayOpacity': "0.6"				
	});
}
function pay_video(video_id){
	$.ajax({
		url: '<?php echo site_url('videos/view/')?>' + '/'+ video_id+ '?tab=videos',
		complete: function(html) { 
			$.blockUI({ message: html.responseText});
		}
	});	
	return false;
}

function register(){
	$.fancybox({
					'showCloseButton'	: true,
					'padding'			: 0,
					'overlayColor'		: '#000',
					'overlayOpacity'	: 0.28,
					'type'				: 'iframe',
					'href'				: '<?php echo site_url('register')?>',
					'width'				: 630,
					'height'			: 458
	});
}
jQuery(function($) {
	$('#free_videos').pajinate({
		items_per_page : 12,
		nav_panel_id : '.pagination',
		item_container_id : '.mylist'
									
	});

	<?php $open_paid_video = $this->session->flashdata('open_modal_video');
		if($open_paid_video):?>	
			previewOpenVideoInModal(<?php echo $open_paid_video?>);
	<?php endif?>
	
	$('#paid_videos').pajinate({
		items_per_page : 12,
		nav_panel_id : '.pagination',
		item_container_id : '.mylist'
									
	});
});
</script>
	<?php if(sizeof($videos) > 0)://free videos listing?>	
		<h2><?php echo lang('Free Videos')?></h2>
		<div id="free_videos"  style="width:960px; margin-left:-20px;">
			<div class="mylist">
				<?php foreach ($videos as $row => $video):?>
					<div class="video<?php echo (($video->is_paid && $this->user->id < 1)?' signup':NULL)?>">				
						<span class="video_preview">											
							<?php
								$data['params'] = array( 
									'videoId'			=> $video->video_id,
									'rtmp'				=> $video->fms_for_preview,
									'performerId'		=> $performer->id,
									'uniqId'			=> uniqid(mt_rand(),TRUE),
									'javaFunctionName'	=> watch_video($this->user,$video),
									'flvName'			=> $video->flv_file_name
								);
								$data['flash_name'] = 'v'.$video->video_id;
								$data['width']	= 220;
								$data['height']	= 165;
								$data['swf']	= 'preview.swf';
							?>								
							<?php $this->load->view('flash_component',$data)?>				
							<?php if($video->description):?>
								<span class="title">
									<img src="<?php echo assets_url()?>/images/icons/info.png" original-title="<?php echo $video->description?>" class="south" /> 			
								</span>
							<?php endif?>								
							<span class="video_length"><?php echo date('i:s',$video->length)?></span>
						</span>							
					</div>
				<?php endforeach?>
			</div>
			<div style="clear:both"></div>
	    	<div class="bottom pagination" id="pagination"></div>				
		</div>
	<?php endif?>
	<div class="clear"></div>
	<?php if(sizeof($videos_paid) > 0)://paid videos?>
		<h2><?php echo lang('Paid Videos')?></h2>
		<div id="paid_videos"  style="width:960px; margin-left:-20px;">
			<div class="mylist">
					<?php foreach ($videos_paid as $row => $video):?>
						<div class="video<?php echo (($video->is_paid && $this->user->id < 1)?' signup':NULL)?>">								
							<span class="video_preview">											
								<?php
									$data['params'] = array( 
										'videoId'			=> $video->video_id,
										'rtmp'				=> $video->fms_for_preview,
										'performerId'		=> $performer->id,
										'uniqId'			=> uniqid(mt_rand(),TRUE),
										'flvName'			=> $video->flv_file_name,										
										'javaFunctionName'	=> watch_video($this->user,$video)
									);
									$data['flash_name'] = 'v'.$video->video_id;
									$data['width']	= 220;
									$data['height']	= 165;
									$data['swf']	= 'preview.swf';
								?>									
								<?php $this->load->view('flash_component',$data)?>
								<?php if($video->description):?>
									<span class="title">
										<img src="<?php echo assets_url()?>/images/icons/info.png" original-title="<?php echo $video->description?>" class="south" /> 			
									</span>
								<?php endif?>												
								<span class="cost"><?php echo print_amount_by_currency($video->price)?></span>									
								<span class="video_length"><?php echo date('i:s',$video->length)?></span>															
							</span>							
						</div>
					<?php endforeach?>
				</div>
				<div style="clear:both"></div>
		    	<div class="bottom pagination" id="pagination"></div>					
			</div>	
	<?php endif?>
<?php endif?>