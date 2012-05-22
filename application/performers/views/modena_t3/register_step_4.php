<script type="text/javascript">
jQuery.validator.setDefaults({
	validClass:"success",
	errorElement: "span",
	errorPlacement: function(error, element) {
		error.appendTo($(element).next('span').next('span'));
	}
});
jQuery(function($){

	$.validator.addMethod("checkcat", function(value,element) {		
		if ($("input:checkbox:checked").length  > 0){			
            return true;
		}
        else
        {       
            return false;
        }
	}, "<?php echo lang('Please select a category!')?>");
	
	$(".register_performer").validate({
		success: function(label) {
	    	label.addClass("valid")
	   },
		rules: {
			true_private_chips_price: {				
				required: true,
				minlength: 1,
				maxlength: 3,
				number: true				
			},
			private_chips_price: {				
				required: true,
				minlength: 1,
				maxlength: 3,
				number: true				
			},
			peek_chips_price: {				
				required: true,
				minlength: 1,
				maxlength: 3,
				number: true				
			},
			nude_chips_price: {				
				required: true,
				minlength: 1,
				maxlength: 3,
				number: true
			},
			paid_photo_gallery_price: {				
				required: true,
				minlength: 1,				
				maxlength: 3,
				number: true				
			}		
		}, 
		messages: {
			true_private_chips_price: 					"<?php echo lang('Please enter a valid price') ?>",
			private_chips_price: 						"<?php echo lang('Please enter a valid price') ?>",
			peek_chips_price: 							"<?php echo lang('Please enter a valid price') ?>",
			nude_chips_price: 							"<?php echo lang('Please enter a valid price') ?>",
			paid_photo_gallery_price: 					"<?php echo lang('Please enter a valid price') ?>"
		},
		debug: false
	});
});
</script>	
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $signup_step_4 = lang('Signup step 4 - Pricings ')?>
			<span class="eutemia"><?php echo substr($signup_step_4,0,1)?></span><span class="helvetica"><?php echo substr($signup_step_4,1)?></span>
		</div>
		<div id="pricing">
			<?php echo form_open_multipart('register', 'class="register_performer"')?>
			<div class="gray italic register_performer">
				<div>
					<label><span class="gray italic bold"><?php echo sprintf(lang('True private chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?>:</span></label>
					<?php echo form_input('true_private_chips_price',set_value('true_private_chips_price', $true_private_chips_price))?>
					<span class="title">
						<img src="<?php echo assets_url()?>images/icons/info.png" original-title="<?php echo lang('This is the price per minute that a user will have to pay for a true private chat session. The difference between a true private chat and a private chat is that a true private chat session does not allow peeking users.')?>" class="south" style="vertical-align:middle;"/> 			
					</span>
					<span class="error message" htmlfor="true_private_chips_price" generated="true"><?php echo form_error('true_private_chips_price')?form_error('true_private_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_PRIVATE_CHIPS_PRICE,MAX_PRIVATE_CHIPS_PRICE))?></span>
				</div>						
				<div>
					<label><span class="gray italic bold"><?php echo sprintf(lang('Private chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?>:</span></label>
					<?php echo form_input('private_chips_price',set_value('private_chips_price', $private_chips_price))?>
					<span class="title">
						<img src="<?php echo assets_url()?>images/icons/info.png" original-title="<?php echo lang('This is the price per minute that a user will have to pay for a private chat sessions. The difference between a private chat and a true private chat is that a private chat session allows other users to \'peek\'.')?>" class="south" style="vertical-align:middle;"/> 			
					</span>
					<span class="error message" htmlfor="private_chips_price" generated="true"><?php echo form_error('private_chips_price')?form_error('private_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_PRIVATE_CHIPS_PRICE,MAX_PRIVATE_CHIPS_PRICE))?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo sprintf(lang('Peek chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?>:</span></label>
					<?php echo form_input('peek_chips_price',set_value('peek_chips_price', $peek_chips_price))?>
					<span class="title">
						<img src="<?php echo assets_url()?>images/icons/info.png" original-title="<?php echo lang('This is the price per minute that a user will have to pay in in order to be able to peek at a private chat session. Peeking is available for private chat sessions, but not true private ones.')?>" class="south" style="vertical-align:middle;"/> 			
					</span>
					<span class="error message" htmlfor="peek_chips_price" generated="true"><?php echo form_error('peek_chips_price')?form_error('peek_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_PEEK_CHIPS_PRICE,MAX_PEEK_CHIPS_PRICE))?></span>
				</div>						
				<div>
					<label><span class="gray italic bold"><?php echo sprintf(lang('Nude chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?>:</span></label>
					<?php echo form_input('nude_chips_price',set_value('nude_chips_price',$nude_chips_price))?>
					<span class="title">
						<img src="<?php echo assets_url()?>images/icons/info.png" original-title="<?php echo lang('This is the price per minute that a user has to pay for a nude chat session. A nude chat session allows several users to talk to a performer and all of them have to pay this fee.')?>" class="south" style="vertical-align:middle;"/> 			
					</span>
					<span class="error message" htmlfor="nude_chips_price" generated="true"><?php echo form_error('nude_chips_price')?form_error('nude_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_NUDE_CHIPS_PRICE,MAX_NUDE_CHIPS_PRICE))?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Paid photo gallery price') ?>:</span></label>
					<?php echo form_input('paid_photo_gallery_price',set_value('paid_photo_gallery_price',$paid_photo_gallery_price))?>
					<span class="title">
						<img src="<?php echo assets_url()?>images/icons/info.png" original-title="<?php echo lang('This is the price that a user has to pay in order to gain access to your paid photo gallery. Once a user has paid this fee, they will have access to your gallery indefinitely.')?>" class="south" style="vertical-align:middle;"/> 			
					</span>
					<span class="error message" htmlfor="paid_photo_gallery_price" generated="true"><?php echo form_error('paid_photo_gallery_price')?form_error('paid_photo_gallery_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_PHOTOS_CHIPS_PRICE,MAX_PHOTOS_CHIPS_PRICE))?></span>
				</div>						
				<div style="margin-top:8px; text-align: left; padding-left:372px;">
					<button class="red"  type="submit" style="width:207px;"><?php echo lang('Continue') ?> </button><br/>
				</div>
				<div class="clear"></div>
			</div>
			<?php echo form_close()?>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>