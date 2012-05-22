<script src="<?php echo assets_url()?>js/jquery.ui.stars.min.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">
jQuery(function($){
	
	var x = Object();
	

	//When page loads...
	$(".slide").hide(); //Hide all content
	$("div.btn div:first").addClass("active").show(); //Activate first tab
	$(".slide:first").show(); //Show first tab content

	$('.menu_item').click(function(){
		$('.slide').hide();
		$('#'+$(this).attr('id') + '_content').show();
	});

	$('.send_message').click(function(){
		$('.slide').hide();
		$('#contact_content').show();
	});

    $(".stars").stars({
        cancelShow: false,
        split: 4,
        callback: function(ui, type, value) {
           x[ui.options.name] = value;
        }
    });
	
	$('#review_form').submit(function(){
		
		
		var complete = true;
		$('#rate_error').html('');
		$('#comment_error').html('');
		
		var ratings = 0; 
		for (var i in x)
		{
			ratings++;
		}
		
		if(ratings < 6){
			$('#rate_error').html('<?php echo lang('You must rate for all performance.')?>');
			complete = false;
		}
			
		
		if($('#comment').val() == ''){
			$('#comment_error').html('<?php echo lang('You must let a comment.')?>');
			complete = false;
		}
		
		return complete;
		
	});

});



window.onload = function() { 
	  var txts = document.getElementsByTagName('TEXTAREA') 

	  for(var i = 0, l = txts.length; i < l; i++) {
		if(/^[0-9]+$/.test(txts[i].getAttribute("maxlength"))) { 
		  var func = function() { 
			var len = parseInt(this.getAttribute("maxlength"), 10); 

			if(this.value.length > len) { 
			  this.value = this.value.substr(0, len); 
			  return false; 
			} 
		  }

		  txts[i].onkeyup = func;
		  txts[i].onblur = func;
		} 
	  } 
	}


</script>
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $_perf_profile_page = sprintf(lang('Please evaluate <strong>%s</strong> performance'), $performer->nickname) ?>
			<div style="position:absolute"><span class="eutemia "><?php echo substr($_perf_profile_page, 0, 1) ?></span><span class="helvetica "><?php echo substr($_perf_profile_page, 1) ?></span></div>
		</div>
		<br />
		<br />
		<div class="clear"></div>
		<div id="profile">
			<div class="left" style="width:565px">
				<?php echo form_open(site_url($performer->nickname.'/review?id='.$uniq_id),'id="review_form"')?>
				<div class="red_h_sep"></div>
				<div style="text-align: center; width:420px">
					<h3><?php echo lang('Your rating is anonymous, models can\'t see who rated them, but will help them perform better next time.')?></h3>
					<div class="red" id="rate_error"></div>
				</div>
				<div class="review_item">
					<h3><?php echo lang('Surroundings, looks')?>:</h3>
					<div class="stars">	
						<?for ($i = 0; $i < 21; $i++):?>
							<?php $rating = $this->input->post('rating[0]');?>
							<?php echo form_radio('rating[0]',$i/4,NULL,'class="star"')?>							
						<?php endfor?>
					</div>
				</div>
				
				<div class="review_item">
					<h3><?php echo lang('Willing to please, friendly')?>:</h3>
					<div class="stars">	
						<?for ($i = 0; $i < 21; $i++):?>
							<?php echo form_radio('rating[1]',$i/4,NULL,'class="star"')?>							
						<?php endfor?>
					</div>

				</div>
				
				<div class="review_item">
					<h3><?php echo lang('Level of performance')?>:</h3>
					<div class="stars">	
						<?for ($i = 0; $i < 21; $i++):?>
							<?php echo form_radio('rating[2]',$i/4,NULL,'class="star"')?>							
						<?php endfor?>
					</div>

	
				</div>
								
				<div class="review_item">
					<h3><?php echo lang('Language usage, comunication')?>:</h3>
					<div class="stars">	
						<?for ($i = 0; $i < 21; $i++):?>
							<?php echo form_radio('rating[3]',$i/4,NULL,'class="star"')?>							
						<?php endfor?>
					</div>

				</div>
				
				<div class="review_item">
					<h3><?php echo lang('Video quality, tehnical background')?>:</h3>
					<div class="stars">	
						<?for ($i = 0; $i < 21; $i++):?>
							<?php echo form_radio('rating[4]',$i/4,NULL,'class="star"')?>
						<?php endfor?>
					</div>

				</div>
				
				<div class="review_item">
					<h3><?php echo lang('Would you return')?>:</h3>
					<div class="stars">	
						<?for ($i = 0; $i < 21; $i++):?>
							<?php echo form_radio('rating[5]',$i/4,NULL,'class="star"')?>
						<?php endfor?>
					</div>
				</div>
				
				<div id="comment_form">
					<h3><?php echo lang('Comment')?>:</h3>

					<span class="red" id="comment_error"></span>
					<textarea name="message" cols="66" rows="5" id="comment" maxlength="254"></textarea>		
					<br />			
					<button class="red up f10" type="submit" style="width:150px; margin:auto;"><?php echo lang('Send')?></button>
					<button class="red up f10"  style="width:150px; margin:auto;" type="button" onclick="document.location='<?php echo site_url($performer->nickname)?>'"><?php echo lang('Skip review')?></button>				
				</div>				
				<?php echo form_close()?>
			</div>
			<div class="right">
				<div class="gir_photo_bg">
					<div class="girl_photo" style="background-image: url('<?php echo main_url('uploads/performers/' . $performer->id . '/medium/' . $performer->avatar)?>');">
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
						<a href="<?php echo site_url($performer->nickname)?>?tab=contact"><button class="black up f10" style="width:150px;"><?php echo lang('send message')?></button></a>
						<a<?php echo ($this->user->id > 0)?NULL:' class="signup" '?> href="<?php echo site_url(($favorite)? 'remove-favorite/' . $performer->nickname : 'add-favorite/' . $performer->nickname)?>"><button class="black up f10" style="width:150px;"><?php echo ( ! $favorite)?lang('add favorite'):lang('remove favorite')?></button></a>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>
