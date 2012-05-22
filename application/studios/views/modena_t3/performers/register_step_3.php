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
				number: true				
			},
			private_chips_price: {				
				required: true,
				minlength: 1,
				number: true				
			},
			peek_chips_price: {				
				required: true,
				minlength: 1,
				number: true				
			},
			nude_chips_price: {				
				required: true,
				minlength: 1,
				number: true				
			},
			paid_photo_gallery_price: {				
				required: true,
				minlength: 1,
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
				<?php $signup_step_3 = lang('Signup step 3 - Pricings ')?>
				<span class="eutemia"><?php echo substr($signup_step_3,0,1)?></span><span class="helvetica"><?php echo substr($signup_step_3,1)?></span>
			</div>
			<div id="pricing">
				<?php echo form_open_multipart(current_url(), 'class="register_performer"')?>
				<div class="gray italic register_performer">
					<div>
						<label><span class="gray italic bold"><?php echo sprintf(lang('True private chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?></span></label>
						<?php echo form_input('true_private_chips_price',set_value('true_private_chips_price', $true_private_chips_price))?>
						<span class="error message" htmlfor="true_private_chips_price" generated="true"><?php echo form_error('true_private_chips_price')?form_error('true_private_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_PRIVATE_CHIPS_PRICE,MAX_PRIVATE_CHIPS_PRICE))?></span>
					</div>						
					<div>
						<label><span class="gray italic bold"><?php echo sprintf(lang('Private chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?></span></label>
						<?php echo form_input('private_chips_price',set_value('private_chips_price', $private_chips_price))?>
						<span class="error message" htmlfor="private_chips_price" generated="true"><?php echo form_error('private_chips_price')?form_error('private_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_PRIVATE_CHIPS_PRICE,MAX_PRIVATE_CHIPS_PRICE))?></span>
					</div>
					<div>
						<label><span class="gray italic bold"><?php echo sprintf(lang('Peek chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?></span></label>
						<?php echo form_input('peek_chips_price',set_value('peek_chips_price', $peek_chips_price))?>
						<span class="error message" htmlfor="peek_chips_price" generated="true"><?php echo form_error('peek_chips_price')?form_error('peek_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_PEEK_CHIPS_PRICE,MAX_PEEK_CHIPS_PRICE))?></span>
					</div>						
					<div>
						<label><span class="gray italic bold"><?php echo sprintf(lang('Nude chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?></span></label>
						<?php echo form_input('nude_chips_price',set_value('nude_chips_price',$nude_chips_price))?>
						<span class="error message" htmlfor="nude_chips_price" generated="true"><?php echo form_error('nude_chips_price')?form_error('nude_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_NUDE_CHIPS_PRICE,MAX_NUDE_CHIPS_PRICE))?></span>
					</div>
					<div>
						<label><span class="gray italic bold"><?php echo lang('Paid photo gallery price') ?></span></label>
						<?php echo form_input('paid_photo_gallery_price',set_value('paid_photo_gallery_price',$paid_photo_gallery_price))?>
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