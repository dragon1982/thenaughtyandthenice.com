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

                            <section class="photos-section">
                            	<h3 class="box-header-3"><?php echo lang('Free Videos')?></h3>

                                    <div class="photos-list clearfix">

																				<?php foreach ($videos as $row => $video):?>
                                        <div class="photo-item video<?php echo (($video->is_paid && $this->user->id < 1)?' signup':NULL)?>">
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
																								<a class="thumb" href="javascript:;">
																									<span class="ico-play"><!-- --></span>
																									<img src="<?php echo assets_url()?>/images/icons/info.png" original-title="<?php echo $video->description?>" class="south" />
																								</a>
																							<?php endif?>
                                            <div class="photo-item-decoration"><!-- --></div>
                                            <div class="photo-desc"><?php echo date('i:s',$video->length)?></div>
                                        </div>
																				<?php endforeach?>

                                    </div><!--end photos-list-->

                                    <ul id="pagination" class="pagination set-bott-1" style="margin-left:230px;">
                                      <li class="unavailable"><a href="">&laquo;</a></li>
                                      <li class="current"><a href="">1</a></li>
                                      <li><a href="">2</a></li>
                                      <li><a href="">3</a></li>
                                      <li><a href="">&raquo;</a></li>
                                    </ul>

							</section><!--end latest-photos-->

	<?php endif?>


		<?php if(sizeof($videos_paid) > 0)://free videos listing?>

                            <section class="photos-section">
                            	<h3 class="box-header-3"><?php echo lang('Free Videos')?></h3>

                                    <div class="photos-list clearfix">

																				<?php foreach ($videos_paid as $row => $video):?>
                                        <div class="photo-item video<?php echo (($video->is_paid && $this->user->id < 1)?' signup':NULL)?>">
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
																								<a class="thumb" href="javascript:;">
																									<span class="ico-play"><!-- --></span>
																									<img src="<?php echo assets_url()?>/images/icons/info.png" original-title="<?php echo $video->description?>" class="south" />
																								</a>
																							<?php endif?>
                                            <div class="photo-item-decoration"><!-- --></div>
                                            <div class="photo-desc"><?php echo date('i:s',$video->length)?></div>
                                        </div>
																				<?php endforeach?>

                                    </div><!--end photos-list-->

                                    <ul id="pagination" class="pagination set-bott-1" style="margin-left:230px;">
                                      <li class="unavailable"><a href="">&laquo;</a></li>
                                      <li class="current"><a href="">1</a></li>
                                      <li><a href="">2</a></li>
                                      <li><a href="">3</a></li>
                                      <li><a href="">&raquo;</a></li>
                                    </ul>

							</section><!--end latest-photos-->

	<?php endif?>
<?php endif?>