<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $this->load->view('includes/_videos_top')?>				
			<?php $_live_perf_title = lang('Performers videos')?>
			<span class="eutemia"><?php echo substr($_live_perf_title, 0, 1) ?></span><span class="helvetica"><?php echo substr($_live_perf_title, 1) ?></span>			
		</div>
		<script type="text/javascript" src="<?php echo assets_url()?>js/swfobject.js"></script>
		<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.qtip-1.0.0-rc3.min.js"></script>
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
					'overlayColor': "#FFF",
					'overlayOpacity': "0.3"
				});		
			}	

			function pay_video(video_id){
				$.ajax({
					url: '<?php echo site_url('videos/view/')?>' + '/'+ video_id, 					
					complete: function(html) { 
						$.blockUI({ message: html.responseText});
					}
				});	
				return false;
			}
						
			function register(){
				$.fancybox({
					'showCloseButton'	: false,
					'padding'			: 0,
					'overlayColor'		: '#fff',
					'overlayOpacity'	: 0.28,
					'type'				: 'iframe',
					'href'				: '<?php echo site_url('register')?>',
					'width'				: 630,
					'height'			: 458
				});
			}				
		</script>	
		<?php if(sizeof($videos) > 0):?>	
			<?php foreach($videos as $video):?>
				<?php $this->load->view('videos/listing',array('video' => $video))?>
			<?php endforeach?>
			<div class="clear"></div>
			<?php echo $pagination;?>
		<?php else:?>
			<div class="no_results"><?php echo lang('There are no videos')?></div>			
		<?php endif?>
		<div class="clear"></div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>