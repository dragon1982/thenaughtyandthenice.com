<script type="text/javascript">
jQuery(function($){

	$.validator.setDefaults({
		validClass:"success",
		errorElement: "span",
		errorPlacement: function(error, element) {
			error.appendTo($(element).next('span').next('span'));
		}
	});
	
	
	var validator = $(".personal_details").validate({		
		success: function(label) {
	    	label.addClass("valid");
	   },
		rules: {
			firstname: {
				required: true,
				minlength: 3,
				maxlength: 90
			},
			lastname: {
				required: true,
				minlength: 3,
				maxlength: 90
			},
			address: {
				required: true,
				minlength: 3,
				maxlength: 100
			},
			city: {
				required: true,
				minlength: 3,
				maxlength: 60
			},
			zip: {
				required: true,
				minlength: 3,
				maxlength: 10
			},
			state: {
				required: true,
				minlength: 3
			},
			country: {
				required: true
			},
			phone: {
				required: true,
				minlength: 3
			}
		}, 
		messages: {
			firstname: 					"<?php echo lang('Please enter a valid first name') ?>",
			lastname: 					"<?php echo lang('Please enter a valid last name') ?>",
			address: 					"<?php echo lang('Please enter a valid address') ?>",
			city: 						"<?php echo lang('Please enter a valid city') ?>",
			zip: 						"<?php echo lang('Please enter a valid zip') ?>",
			state: 						"<?php echo lang('Please enter a valid state') ?>",
			country: 					"<?php echo lang('Please enter a valid country') ?>",
			phone: 						"<?php echo lang('Please enter a valid phone') ?>"
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
				<?php $account_summary_settings = lang('Account Settings - Personal details')?>
				<span class="eutemia"><?php echo substr($account_summary_settings,0,1)?></span><span class="helvetica"><?php echo substr($account_summary_settings,1)?></span>
			</div>
			
			<div class="gray italic" id="studio_settings">
				<?php echo form_open(current_url(), 'class="personal_details"')?>
				<div class="gray italic register_performer" style="padding-top:0;">
					<div>
						<label><span class="gray italic bold"><?php echo lang('Firstname') ?>:</span></label>
						<?php echo form_input('firstname', set_value('firstname', $this->user->first_name))?>
						<span class="error" htmlfor="firstname" generated="true" ><?php echo form_error('firstname')?></span>
					</div>
					<div>
						<label><span class="gray italic bold"><?php echo lang('Lastname') ?>:</span></label>
						<?php echo form_input('lastname', set_value('lastname', $this->user->last_name))?>
						<span class="error" htmlfor="lastname" generated="true"><?php echo form_error('lastname')?></span>
					</div>
					<div>
						<label><span class="gray italic bold"><?php echo lang('Phone') ?>:</span></label>
						<?php echo form_input('phone', set_value('phone', $this->user->phone))?>
						<span class="error" htmlfor="phone" generated="true"><?php echo form_error('phone')?></span>
					</div>
					<div>
						<label><span class="gray italic bold"><?php echo lang('Address') ?>:</span></label>
						<?php echo form_input('address', set_value('address', $this->user->address))?>
						<span class="error" htmlfor="address" generated="true"><?php echo form_error('address')?></span>
					</div>
					<div>
						<label><span class="gray italic bold"><?php echo lang('City') ?>:</span></label>
						<?php echo form_input('city', set_value('city', $this->user->city)) ?>
						<span class="error" htmlfor="city" generated="true"><?php echo form_error('city')?></span>
					</div>
					<div>
						<label><span class="gray italic bold"><?php echo lang('Zip') ?>:</span></label>
						<?php echo form_input('zip', set_value('zip', $this->user->zip)) ?>
						<span class="error" htmlfor="zip" generated="true"><?php echo form_error('zip')?></span>
					</div>
					<div>
						<label><span class="gray italic bold"><?php echo lang('Country') ?>:</span></label>
						<?php echo form_dropdown('country', $countries, set_value('country', $this->user->country_code),'id="country"')?>
						<span class="error" htmlfor="country" generated="true"><?php echo form_error('country')?></span>
					</div>
					<script type="text/javascript">
						$(function(){
							if($('#country').val() == 'US'){
								$('#state').show();
							}			
							
							$('#country').change(function(){
									if($('#country').val() == 'US'){
										$('#state').slideDown();
										$('input[name=state]').val('');
									} else {
										$('#state').slideUp();
										$('input[name=state]').val('state');						
									}
							});
						});
					</script>					
					<div id="state" style="display:none">
						<label><span class="gray italic bold"><?php echo lang('State') ?>:</span></label>
						<?php echo form_input('state', set_value('state', $this->user->state)) ?>
						<span class="error message" htmlfor="state" generated="true"><?php echo form_error('state')?></span>
					</div>					
					<br/>
					<div onclick="$('.personal_details').validate()" style="margin-left:223px;"><button class="red" style="width:206px;"><?php echo lang('Save Changes') ?></button></div>
				</div>
				<?php echo form_close() ?>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>