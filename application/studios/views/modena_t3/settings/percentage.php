<script type="text/javascript">
jQuery(function($){

	$.validator.setDefaults({
		validClass:"success",
		errorElement: "span",
		errorPlacement: function(error, element) {
			error.appendTo($(element).next('span').next('span'));
		}
	});
	
	$.validator.addMethod("uniqueUserName", function(value,element) {
		return true;
	}, "Not Available!");
	
	var validator = $(".percentage").validate({			 
		success: function(label) {
	    	label.addClass("valid");
	   },
		rules: {
			percentage: {
				required: true,
				min:0,
				max:100
			}
		}, 
		messages: {
			percentage: 						"<?php echo lang('Please enter a valid percentage') ?>"
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
				<?php $account_summary_settings = lang('Account Settings - Percentage')?>
				<span class="eutemia"><?php echo substr($account_summary_settings,0,1)?></span><span class="helvetica"><?php echo substr($account_summary_settings,1)?></span>
			</div>
			<div class="gray italic" id="studio_settings">
				<?php echo form_open(current_url(), 'class="percentage"')?>
				<div class="gray italic" style="padding-top:0;">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Percentage') ?></span></label>
					<?php echo form_input(array('name' => 'percentage', 'id' => 'percentage', 'value' => set_value('percentage' , $this->user->percentage), 'style'=>'width:200px; text-align:left;')) ?>
					<span class="error message" htmlfor="percentage" generated="true" ><?php echo form_error('percentage')?></span>
				</div>
				<div onclick="$('.percentage').validate()" style="margin-left:223px;"><button class="red" style="width:206px;"><?php echo lang('Save Changes') ?></button></div>
				</div>
				<?php echo form_close() ?>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>