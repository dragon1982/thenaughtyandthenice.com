<script type="text/javascript">
jQuery(function($){

	$.validator.setDefaults({
		validClass:"success",
		errorElement: "span",
		errorPlacement: function(error, element) {
			error.appendTo($(element).next('span').next('span'));
		}
	});
	
	var validator = $(".change_pass").validate({
		
		success: function(label) {
	    	label.addClass("valid");
	   },
		rules: {
			new_password: {
		   		required: true,
				minlength: 5
			},
			confirm_password: {
		   		required: true,
				minlength: 5,
				equalTo: "#new_password"

			}
		}, 
		messages: {
			new_password:					"<?php echo lang('Password must have at least 5 characters') ?>",
			confirm_password:				"<?php echo lang('Passwords do not match') ?>"
		},
		
		submitHandler: function(form) {
			// do other stuff for a valid form
			form.submit();
		},
		debug: true
	});
}); 
</script>	
	<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $account_summary_title = lang('Account Summary - Settings') ?>
				<span class="eutemia "><?php echo substr($account_summary_title,0,1)?></span><span class="helvetica "><?php echo substr($account_summary_title,1)?></span>
			</div>
			
			<div class="gray italic" id="studio_settings">

				<?php echo form_open(current_url(), 'class="change_pass"')?>
				<div class="gray italic register_performer" style="padding-top:0;">
				<div>
					<label><span class="gray italic bold"><?php echo lang('New Password') ?>:</span></label>
					<?php echo form_password(array('name' => 'new_password', 'id' => 'new_password'))?>
					<span class="error message" htmlfor="new_password" generated="true"><?php echo form_error('new_password')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Confirm Password') ?>:</span></label>
					<?php echo form_password('confirm_password')?>
					<span class="error message" htmlfor="confirm_password" generated="true"><?php echo form_error('confirm_password')?></span>
				</div>
				<div onclick = "$('.change_pass').validate()" style="margin-left:223px;"><button class="red" style="width:206px;"><?php echo lang('Save Changes') ?></button></div>
				</div>
				<?php echo form_close() ?>

			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>