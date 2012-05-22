<div class="video<?php echo (($video->is_paid && $this->user->id < 1)?' signup':NULL)?>">
	<span class="video_preview">				
		<?php
			$data['params'] = array( 
				'videoId'			=> $video->video_id,
				'rtmp'				=> $this->fms_list[$video->fms_id]->fms_for_preview,
				'performerId'		=> $video->performer_id,
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
				<img src="<?php echo assets_url()?>images/icons/info.png" original-title="<?php echo $video->description?>" class="south" /> 			
			</span>
		<?php endif?>		
		<?php if($video->is_paid):?>
			<span class="cost"><?php echo print_amount_by_currency($video->price)?></span>
		<?php endif?>
		<span class="video_length"><?php echo date('i:s',$video->length)?></span>
		<span class="nickname"><a href="<?php echo site_url($video->nickname)?>"><?php echo $video->nickname?></a></span>									
	</span>				
</div>