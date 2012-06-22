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

<div class="box-header-2">
	<h2 class="title1">Contact</h2>
</div>


<?php echo form_open('performers/contact', 'class="small-form"') ?>
<?php echo form_hidden('performer_id', $performer->id ) ?>

		<div class="form-line clearfix">
    	<div class="form-left">
        	<label><?php echo lang('Subject') ?></label>
        </div>
        <div class="form-right">
        	<?php echo form_input(array('name' => 'subject', 'id' => 'subject', 'class' => 'nice-input medium'), set_value('subject'))?>
        </div>
    </div><!--end form-line-->

    <div class="form-line clearfix">
    	<div class="form-left">
        	<label><?php echo lang('Message') ?></label>
      </div>
    	<div class="form-right">
      	<div class="nice-textarea medium">
        			<?php echo form_textarea(array('name' => 'message', 'id' => 'message') , set_value('message'))?>
        </div>
      </div>
    </div><!--end form-line-->

    <div class="form-line clearfix" style="border:0;">
    	<div class="form-left"></div>
         <div class="form-right">
        		<span onclick="$('.contact_us').validate()"><button class="nice-submit medium" style="width:343px;"><?php echo lang('Submit') ?></button></span>
        </div>
    </div><!--end form-line-->

</form>
