<script type="text/javascript">
jQuery(function($){

	$.validator.setDefaults({
		validClass:"success",
		errorElement: "span",
		errorPlacement: function(error, element) {
			error.appendTo($(element).next('span').next('span'));
		}
	});

	var validator = $(".contact_us").validate({
		success: function(label) {
	    	label.addClass("valid");
	   },
		rules: {
			subject: {
				required: true,
				minlength: 2,
				maxlength: 255
			},
			message: {
				required: true,
				minlength: 2,
				maxlength: 1500
			}
		}, 
		messages: {
			subject: 					"<?php echo lang('Please enter a valid subject') ?>",
			message: 					"<?php echo lang('Please enter a valid message') ?>"
		},
		
		submitHandler: function(form) {
			form.submit();
		},
		debug: true
	});
}); 
</script>
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $contact_us_title = lang('Contact Us')?>
			<span class="eutemia"><?php echo substr($contact_us_title,0,1)?></span><span class="helvetica"><?php echo substr($contact_us_title,1)?></span>
		</div>
		<div id="profile">
			<div class="left" style="text-align: center;">
				<div class="red_h_sep"></div>
					<?php echo form_open('', 'class="contact_us"') ?>
					<div class="gray italic register_performer contact">
						<div>
							<label><span class="gray italic bold"><?php echo lang('Subject') ?></span></label>
							<?php echo form_input(array('name' => 'subject', 'id' => 'subject'), set_value('subject'))?>
							<span></span>
						</div>
						<div>
							<label class="move_top"><span class="gray italic bold"><?php echo lang('Message') ?></span></label>
							<?php echo form_textarea(array('name' => 'message', 'id' => 'message') , set_value('message'))?>
							<span></span><span class="move_top"></span>
						</div>
						<div>
							<label></label>
							<span onclick="$('.contact_us').validate()"><button class="red"><?php echo lang('Submit') ?></button></span>
						</div>
					</div>
					<?php echo form_close()?>
				<div class="red_h_sep"></div>
				<div class="white_h_sep"></div>
								
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>