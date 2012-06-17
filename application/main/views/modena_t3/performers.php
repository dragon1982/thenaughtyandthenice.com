<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $this->load->view('includes/_search')?>
			<?php $_live_perf_title = lang('Live Performers') ?>
			<span class="eutemia "><?php echo substr($_live_perf_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($_live_perf_title, 1) ?></span>		
		</div>
		<div class="clear"></div>		
		<div id="performer_list">
			<?php if(sizeof($performers) > 0):?>
				<script type="text/javascript" src="<?php echo assets_url()?>js/preview.js"></script>			
				<?php foreach($performers as $performer):?>
					<?php $this->load->view('performer',array('performer'=>$performer))?>
				<?php endforeach?>
			<?php else:?>
				<div class="no_results"><?php echo lang('There are no performers online')?></div>			
			<?php endif?>
			<div class="clear"></div>
			<?php if($pagination):?>
				<?php echo $pagination;?>
			<?php endif?>
			<div class="clear"></div>			
		</div>
		<?php if(isset($performers_random) && sizeof($performers_random) > 0):?>
			<div class="title" style="margin-top:15px">
				<?php $_live_perf_title = lang('Random performers')?>
				<span class="eutemia "><?php echo substr($_live_perf_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($_live_perf_title, 1) ?></span>		
			</div>
			<div class="clear"></div>		
			<?php foreach($performers_random as $performer):?>
					<?php $this->load->view('performer',array('performer'=>$performer))?>
			<?php endforeach?>
			<div class="clear"></div>				
		<?php endif?>
		<?php if(isset($performers_in_private) && sizeof($performers_in_private) > 0):?>
			<div class="title" style="margin-top:15px">
				<?php $_live_perf_title = lang('Performers currently in private')?>
				<span class="eutemia "><?php echo substr($_live_perf_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($_live_perf_title, 1) ?></span>		
			</div>
			<div class="clear"></div>		
			<?php foreach($performers_in_private as $performer):?>
					<?php $this->load->view('performer',array('performer'=>$performer))?>
			<?php endforeach?>
			<div class="clear"></div>				
		<?php endif?>
		<?php if(isset($videos_free) && sizeof($videos_free) > 3):?>
			<div class="title" style="margin-top:15px">
				<?php $_live_perf_title = lang('Free videos')?>
				<span class="eutemia "><?php echo substr($_live_perf_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($_live_perf_title, 1) ?></span>		
			</div>
			<div class="clear"></div>		
			<?php foreach($videos_free as $video):?>
				<?php $this->load->view('videos/listing',array('video' => $video))?>
			<?php endforeach?>
			<div class="clear"></div>
		<?php endif?>
		<?php if(isset($videos_paid) && sizeof($videos_paid) > 3):?>
			<div class="title" style="margin-top:15px">
				<?php $_live_perf_title = lang('Paid videos')?>
				<span class="eutemia "><?php echo substr($_live_perf_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($_live_perf_title, 1) ?></span>		
			</div>
			<div class="clear"></div>		
			<?php foreach($videos_paid as $video):?>
				<?php $this->load->view('videos/listing',array('video' => $video))?>
			<?php endforeach?>
			<div class="clear"></div>
		<?php endif?>	
		
	</div>

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
	</script>
</div>
</div></div><div class="black_box_bg_bottom"></div>
