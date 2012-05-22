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
	}, "<?php echo lang('Not Available!')?>");
	
	$.validator.addMethod("checkCountry", function(value,element) {
		if($('#country').val() == 'US'){
			if(value == ''){
				return false;
			}
		}
		return true;
	}, "Please enter a valid state!");
	
	var validator = $(".register_affiliate").validate({
		success: function(label) {
	    	label.addClass("valid")
	   },
		rules: {
			site_name: {
				required: true,
				minlength: 1,
				maxlength: 150
			},
			site_url: {
				required: true,
				minlength: 1,
				maxlength: 150
			},
			username: {
				required: true,
				minlength: 1,
				maxlength: 25,
				uniqueUserName: true
			},
			
			password:{
				required: true,
				minlength: 5
			},
			rep_password:{
				required: true,
				minlength: 5
			},
			email: {
				required: true,
				email: true
			},
			first_name: {
				required: true,
				minlength: 3,
				maxlength: 90
			},
			last_name: {
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
				checkCountry: true
			},
			country: {
				required: true
			},
			phone: {
				required: true,
				minlength: 3
			},
			
			tos: {
				required: true,
				minlength: 1,
				maxlength: 3
			},
			
			payment_method: {
				required: true			
			}
		}, 
		messages: {
			site_name:					"<?php echo lang('Please enter your site name') ?>",
			site_url:					"<?php echo lang('Please enter your site URL') ?>",
			username: 					"<?php echo lang('Please enter a username') ?>",
			email: 						"<?php echo lang('Please enter a valid email address') ?>",
			password: 					"<?php echo lang('Password must have at least 5 characters') ?>",
			rep_password:				"<?php echo lang('Password must have at least 5 characters') ?>",
			first_name:					"<?php echo lang('Please enter a valid first name') ?>",
			last_name: 					"<?php echo lang('Please enter a valid last name') ?>",
			address: 					"<?php echo lang('Please enter a valid address') ?>",
			city: 						"<?php echo lang('Please enter a valid city') ?>",
			zip: 						"<?php echo lang('Please enter a valid zip') ?>",
			state: 						"<?php echo lang('Please enter a valid state') ?>",
			country: 					"<?php echo lang('Please enter a valid country') ?>",
			phone: 						"<?php echo lang('Please enter a valid phone') ?>",
			tos: 						"<?php echo lang('Please agree with the terms and conditions') ?>",
			payment_method: 			"<?php echo lang('Please select your payment method') ?>"	
		},
		
		submitHandler: function(form) {
			// do other stuff for a valid form
			form.submit();
		},
		debug: false
	});
	
	
	if( $('#payment_method').val() > 0 ){
		$('#payment_method_'+$('#payment_method').val()+ " input").each(function(key,element){
			$(element).rules("add",{
				required:true,
				messages:{
					required: "<?php echo lang('This field is required')?>"
				}
			});
			
		});		
	} 
	
	$('#payment_method').change(function(){
		$('.methods input').each(function(key,element){
			$(element).rules("remove");
		});
		$('#payment_method_'+$('#payment_method').val()+ " input").each(function(key,element){
			
			$(element).rules("add",{
				required:true,
				messages:{
					required: "<?php echo lang('This field is required')?>"
				}
			});
			
		});
		
		$('.methods:visible').slideUp();
		$('#payment_method_'+$('#payment_method').val()).slideDown();
	});	

	$('#payment_method_'+$('#payment_method').val()).slideDown();	
}); 
</script>	
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			
			<?php echo form_open('register', 'class="register_affiliate"')?>
			<div class="gray italic register_affiliate">
				
				<!--  SITE INFORMATION -->
				<?php //TODO trimis titlu din controller ?>
				<div class="title" style="margin:0px;">
					<?php $site_info = lang('Your site information') ?>
					<span class="eutemia "><?php echo substr($site_info,0,1) ?></span><span class="helvetica "><?php echo substr($site_info,1) ?>)</span>
				</div>
				
				<!--  SITE NAME -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Site name')?></span></label>
					<?php echo form_input('site_name',set_value('site_name'))?>
					<span class="error message" htmlfor="site_name" generated="true" ><?php echo form_error('site_name')?></span>
				</div>
				
				<!--  SITE URL -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Site URL')?></span></label>
					<?php echo form_input('site_url',set_value('site_url'))?>
					<span class="error message" htmlfor="site_url" generated="true"><?php echo form_error('site_url')?></span>
				</div>
				
				
				
				<!--  PERSONAL INFORMATION -->
				<div class="title" style="margin:0px;">
					<?php $personal_info = lang('Your site information') ?>
					<span class="eutemia italic"><?php echo substr($personal_info,0,1) ?></span><span class="helvetica italic"><?php echo substr($personal_info,1) ?>)</span>
				</div>
				
				<!--  USERNAME -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Username')?></span></label>
					<?php echo form_input('username',set_value('username'))?>
					<span class="error message" htmlfor="username" generated="true"><?php echo form_error('username')?></span>
				</div>
				
				
				<!--  PASSWORD -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Password')?></span></label>
					<?php echo form_password('password',set_value('password'))?>
					<span class="error message" htmlfor="password" generated="true"><?php echo form_error('password')?></span>
				</div>
				
				<!--  REPEAT PASSWORD -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Repeat password')?></span></label>
					<?php echo form_password('rep_password',set_value('rep_password'))?>
					<span class="error message" htmlfor="rep_password" generated="true"><?php echo form_error('rep_password')?></span>
				</div>
				
				<!--  EMAIL -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Email')?></span></label>
					<?php echo form_input('email',set_value('email'))?>
					<span class="error message" htmlfor="email" generated="true"><?php echo form_error('email')?></span>
				</div>
				
				<!--  FIRST NAME -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('First name')?></span></label>
					<?php echo form_input('first_name',set_value('first_name'))?>
					<span class="error message" htmlfor="first_name" generated="true"><?php echo form_error('first_name')?></span>
				</div>
				
				<!--  LAST NAME -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Last name')?></span></label>
					<?php echo form_input('last_name',set_value('last_name'))?>
					<span class="error message" htmlfor="last_name" generated="true"><?php echo form_error('last_name')?></span>
				</div>
				
				<!-- ADDRESS -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Address')?></span></label>
					<?php echo form_input('address',set_value('address'))?>
					<span class="error message" htmlfor="address" generated="true"><?php echo form_error('address')?></span>
				</div>
				
				<!-- CITY -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('City')?></span></label>
					<?php echo form_input('city',set_value('city'))?>
					<span class="error message" htmlfor="city" generated="true"><?php echo form_error('city')?></span>
				</div>
				
				<!-- ZIP -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Zip')?></span></label>
					<?php echo form_input('zip',set_value('zip'))?>
					<span class="error message" htmlfor="zip" generated="true"><?php echo form_error('zip')?></span>
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
				
				<!-- COUNTRY -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Country')?></span></label>
					<?php echo form_dropdown('country', $countries, set_value('country'),'id="country"')?>
					<span class="error message" htmlfor="country" generated="true"><?php echo form_error('country')?></span>
				</div>
				
				<!-- STATE -->
				<div id="state" style="display:none">
					<label><span class="gray italic bold"><?php echo lang('State')?></span></label>
					<?php echo form_input('state',set_value('state'))?>
					<span class="error message" htmlfor="state" generated="true"><?php echo form_error('state')?></span>
				</div>		
				
				
				<div>
					<label><span class="gray italic bold"><?php echo lang('Phone number')?></span></label>
					<?php echo form_input('phone',set_value('phone'))?>
					<span class="error message" htmlfor="phone" generated="true"><?php echo form_error('phone')?></span>
				</div>
				
				<div>
					<span class="red">Payment info</span>
				</div>  		
				<div>
					<label><span class="gray italic bold"><?php echo lang('Payment Method') ?>:</span></label>
					<?php echo form_dropdown('payment_method', $payment_methods, set_value('payment_method'),'id="payment_method"')?>
					<span class="error message" htmlfor="payment_method" generated="true"><?php echo form_error('payment_method')?></span>
				</div>									
				<div id="selected_payment_fields" style="margin-left:0px; display:block;">
					<?php foreach($this->payment_method_list as $payment_method):?>
						<?php $fields = unserialize($payment_method->fields)?>
						<div id="payment_method_<?php echo $payment_method->id?>" class="methods" <?php echo  ($selected_method != $payment_method->id)?' style="display:none"':NULL?>>
							<?php foreach($fields as $field):?>
								<?php $field_name = strtolower(str_replace(' ', '_', $field)) . '_'.$payment_method->id?>							
								<div style="width:960px;">
									<label><span class="gray italic bold"><?php echo lang($field)?>:</span></label>
									<?php echo form_input($field_name,set_value($field_name),'');?>
									<span generated="true" htmlfor="<?php echo $field_name?>" class="error message"><?php echo form_error($field_name)?></span>
								</div>		
							<?php endforeach?>
							<div style="width:960px;">
								<label><span class="gray italic bold"><?php echo lang('Release amount')?>:</span></label>
								<?php echo form_input('rls_amount' . '_' . $payment_method->id,set_value('rls_amount'. '_' . $payment_method->id))?>
								<span generated="true" htmlfor="rls_amount_<?php echo $payment_method->id?>" class="error message"><?php echo (form_error('rls_amount'. '_' . $payment_method->id))?form_error('rls_amount'. '_' . $payment_method->id):sprintf(lang('Min. %s %s'),$payment_method->minim_amount,SETTINGS_REAL_CURRENCY_NAME)?></span>
							</div>							
						</div>
					<?php endforeach?>					
				</div>
							    
				<div>
					<label></label>
					<?php echo form_checkbox('tos', 'tos',set_value('tos'))?><span class="gray italic bold" id="tos"><a href="<?php echo main_url('documents/tos')?>" target="_blank"><?php echo lang('I agree the Terms of Service')?></a></span>					
					<span class="error message" htmlfor="tos" generated="true"><?php echo form_error('tos')?></span>
				</div>
				
				<div style="margin-top:8px; text-align: left; padding-left:372px;">
					<button class="red"  type="submit" style="width:207px;"><?php echo lang('Register') ?> </button><br/>
				</div>
				
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>