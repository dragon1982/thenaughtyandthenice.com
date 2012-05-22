<?php if($performer->is_online && $performer->is_online_type == 'free'):?>
	<div class="girl_box preview p_<?php echo $performer->id.'_'.mt_rand(1000,9999)?>">
		<input type="hidden" value="rtmp=<?php echo $this->fms_list[$performer->fms_id]->fms?>&amp;performerId=<?php echo $performer->id?>&amp;redirectLink=<?php echo site_url($performer->nickname)?>" class="get_value">
<?php else:?>
	<div class="girl_box">
<?php endif?>
	<div class="girl_nick">
		<a href="<?php echo site_url($performer->nickname)?>">
			<span class="bold"><?php echo $performer->nickname?></span>
		</a>
		<?php if($performer->is_online_hd && $performer->is_online):?>
			<span class="is_hd"></span>
		<?php endif?>
	</div>
	<?php if($performer->is_online):?>
		<img src="<?php echo assets_url()?>images/icons/bullet.png"  class="on" alt="" />
	<?php endif?>
	<div class="lang-bg"></div>
	<?php $languages = explode(',',$performer->language_code)?>
	<div class="lang">
		<ul>
			<?php foreach($languages as $language):?>
				<li><img src="<?php echo assets_url()?>images/flags/<?php echo strtoupper($language)?>.png" class="lang_icon" alt="<?php echo $language?>" /></li>
			<?php endforeach?>
		</ul>
	</div>
	<div class="girl_photo" style="background: url(<?php echo  ( ! (file_exists('uploads/performers/' . $performer->id . '/small/' . $performer->avatar) && $performer->avatar))? assets_url().'images/poza_tarfa.png':site_url('uploads/performers/' . $performer->id . '/small/' . $performer->avatar)?>) no-repeat;">
		<a href="<?php echo site_url($performer->nickname)?>"><img src="<?php echo assets_url()?>images/girl_photo_rounded_corners.png"/></a>
	</div>
	<div class="buttons">
		<?php $buttons = $this->performers->display_buttons($performer)?>
		<?php foreach($buttons as $key => $button):?>
			<button class="red <?php echo (in_array($key,array('nude_chat','peek_chat','private_chat'))?(($this->user->id > 0)? '" onclick="document.location.href=\''. $button['link'].'\'"':'signup"'): '" onclick="document.location.href=\''. $button['link'].'\'"')?> style="width:144px; margin-bottom: 5px;" type="button"><?php echo $button['name']?></button><?php if( $this->input->is_ajax_request() ):?><span class="red_r"></span><?php endif?>
			<?php if($key == 0):?>
				<br />
			<?php endif?>
		<?php endforeach?>				
	</div>
</div>