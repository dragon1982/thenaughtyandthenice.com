<div class="search" style="width: 780px; text-align:right; margin-right:10px;">
	<a href="<?php echo site_url('videos')?>"><button class="<?php echo ($this->video_type === NULL)?'red':'black'?>" style="padding:0 6px 0 10px;"><?php echo lang('All videos')?></button></a>
	<a href="<?php echo site_url('videos')?>?type=free"><button class="<?php echo ($this->video_type === 0)?'red':'black'?>" style="padding:0 6px 0 10px;"><?php echo lang('Free videos')?></button></a>
	<a href="<?php echo site_url('videos')?>?type=paid"><button class="<?php echo ($this->video_type === 1)?'red':'black'?>" style="padding:0 6px 0 10px;"><?php echo lang('Paid videos')?></button></a>
</div>