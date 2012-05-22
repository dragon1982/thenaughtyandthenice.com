<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.validate.js"></script>
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
			subject: 					"&nbsp;",
			message: 					"&nbsp;"
		},
		
		submitHandler: function(form) {
			form.submit();
		},
		debug: true
	});
}); 
</script>
<?php echo form_open('performers/contact', 'class="contact_us"') ?>
<div class="gray italic register_performer profile_contact">
		<?php echo form_hidden('performer_id', $performer->id ) ?>
	<div>
		<label class="narrow_label" style="text-align: left;"><span class="gray italic bold"><?php echo lang('Subject') ?></span></label>
		<?php echo form_input(array('name' => 'subject', 'id' => 'subject'), set_value('subject'))?>
		<span></span>
	</div>
	<div>
		<label class="narrow_label" style="text-align: left;"><span class="gray italic bold"><?php echo lang('Message') ?></span></label>
		<?php echo form_textarea(array('name' => 'message', 'id' => 'message') , set_value('message'))?>
		<span></span><span style="vertical-align:top"></span>
		
	</div>
	<div>
		<label  class="narrow_label"></label>
		<span onclick="$('.contact_us').validate()"><button class="red" style="width:343px;"><?php echo lang('Submit') ?></button></span>
	</div>
</div>
<?php echo form_close()?>