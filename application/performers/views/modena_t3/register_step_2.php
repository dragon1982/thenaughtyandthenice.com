<script type="text/javascript">
jQuery.validator.setDefaults({
	validClass:"success",
	errorElement: "span",
	errorPlacement: function(error, element) {
		error.appendTo($(element).next('span').next('span'));
	}
});

jQuery(function($){

	var validator = $(".register_performer").validate({		 				
		success: function(label) {
	    	label.addClass("valid")
	   },
		rules: {
			payment_method: {
				required: true			
			}
		},
		messages: {
			payment_method: 			"<?php echo lang('Please select your payment method') ?>"

		},
		
		submitHandler: function(form) {
			// do other stuff for a valid form
			form.submit();
		}
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
			<div class="title">
				<?php $signup_step_2_title = lang('Signup step 2 - Payment') ?>
				<span class="eutemia"><?php echo substr($signup_step_2_title, 0, 1)?></span><span class="helvetica"><?php echo substr($signup_step_2_title, 1) ?></span>
			</div>
			<?php echo form_open('register', 'class="register_performer"')?>
			<div class="gray italic register_performer">
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
				<div class="clear"></div>
				<div style="margin-top:8px; text-align: left; padding-left:372px;">
					<button class="red"  type="submit" style="width:207px;"><?php echo lang('Continue') ?> </button><br/>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>	