<div class="gir_photo_bg">
	<div class="girl_photo" style="background-image: url('<?php echo ($performer->avatar != '') ? main_url('uploads/performers/' . $performer->id . '/medium/' . $performer->avatar) : assets_url().'images/poza_tarfa_medium.jpg'?>');">
		<a><img src="<?php echo assets_url()?>images/girl_photo_medium_rounded_corners.png"/></a>
	</div>
	<div class="buttons">
		<?php $buttons =  $this->performers->display_buttons($performer)?>
		<?php $i = 0;?>
		<?php foreach($buttons as $key => $button):?>
			<?php if($key == 'my_profile') continue?>
			<?php $res = (in_array($key,array('nude_chat','peek_chat','private_chat'))?(($this->user->id > 0)?1:2):0)?>					
			<a href="<?php echo $button['link']?>"<?php echo (($res==1)?' ':(($res==2)?' class="signup"':NULL))?>><button class="<?php echo ($res > 0 && ! $i )?'red':'black'?> up f10" style="width:150px;margin-bottom:5px"><?php echo $button['name']?></button></a>
			<?php if($res > 0) $i=1?>
		<?php endforeach?>		
		<a class="<?php echo ($this->user->id > 0)?'send_message':'signup'?>"><button class="black up f10" style="width:150px;"><?php echo lang('send message')?></button></a>
		<a<?php echo ($this->user->id > 0)?NULL:' class="signup" '?> href="<?php echo site_url(($favorite)? 'remove-favorite/' . $performer->nickname : 'add-favorite/' . $performer->nickname)?>"><button class="black up f10" style="width:150px;"><?php echo ( ! $favorite)?lang('add favorite'):lang('remove favorite')?></button></a>
	</div>
</div>
<?php if(isset($rating)):?>
<div class="rate">
	<div class="stars">	
		<?php $rating = round($rating * 4);
		for ($i = 0; $i < 21; $i++):?>
			<?php if ($i == $rating):?>
				<input name="rating" type="radio" class="star" value="<?php echo $i/4?>" checked="checked"/>
			<?php else:?>
				<input name="rating" type="radio" class="star" value="<?php echo $i/4?>"/>
			<?php endif?>
		<?php endfor?>
	</div>
	<span class="bold">
		<?php if ($ratings_count == 1): ?>
			<?php echo lang('1 vote')?>
		<?php else:?>
			<?php echo sprintf(lang('%s votes'),$ratings_count)?>
		<?php endif?>
	</span>
</div>
<?php endif?>