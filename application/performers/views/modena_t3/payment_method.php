<script type="text/javascript">
jQuery.validator.setDefaults({
	validClass:"success",
	errorElement: "span",
	errorPlacement: function(error, element) {
		error.appendTo($(element).next('span').next('span'));
	}
});

jQuery(function($){

	var validator = $(".set_payment_details").validate({		 				
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
		},
		debug:true
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
	<div class="content" style="margin-left:50px;">
		<div class="red_h_sep"></div>
		<div class="title">
			<?php $enter_payment_title = lang('Payment Details')?>
			<span class="eutemia"><?php echo substr($enter_payment_title,0,1)?></span><span class="helvetica"><?php echo substr($enter_payment_title,1)?></span>
		</div>	
		<?php echo form_open(NULL, 'class="set_payment_details"')?>			
			<div class="gray italic payment_details" id="selected_payment_fields">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Payment Method') ?>:</span></label>
					<?php echo form_dropdown('payment_method', $payment_methods, set_value('payment_method',$this->user->payment),'id="payment_method" class="rounded"')?>
					<span class="error message" htmlfor="payment_method" generated="true"><?php echo form_error('payment_method')?></span>
				</div>			
				<?php foreach($this->payment_method_list as $payment_method):?>
					<?php 
						$fields = unserialize($payment_method->fields);
						
						$user_data = unserialize($this->user->account); 
						//vad ce payment method e selectat
						$aux = set_value('payment_method',$this->user->payment);
					?>
					<div id="payment_method_<?php echo $payment_method->id?>" class="methods" style="display:none">
						<?php foreach($fields as $field):?>
							<?php $field_name = strtolower(str_replace(' ', '_', $field)) . '_'.$payment_method->id?>
							<?php $short_name = strtolower(str_replace(' ', '_', $field));?>							
							<div style="width:960px;">
								<label><span class="gray italic bold"><?php echo lang($field)?>:</span></label>
								<?php if($this->user->payment == $payment_method->id)://e metoda selectata?>
									<?php echo form_input($field_name,set_value($field_name,$user_data[$short_name]));?>
								<?php elseif($aux == $payment_method->id):?>
									<?php echo form_input($field_name,set_value($field_name));?>
								<?php else:?>
									<?php echo form_input($field_name,'');?>
								<?php endif?>
								<span generated="true" htmlfor="<?php echo $field_name?>" class="error message"><?php echo form_error($field_name)?></span>
							</div>		
						<?php endforeach?>
						<div style="width:960px;">
							<label><span class="gray italic bold"><?php echo lang('Release amount')?>:</span></label>
							<?php if($this->user->payment == $payment_method->id)://e metoda selectata?>
								<?php echo form_input('rls_amount' . '_' . $payment_method->id,set_value('rls_amount' . '_' . $payment_method->id,$this->user->release))?>
							<?php elseif($aux == $payment_method->id):?>
								<?php echo form_input('rls_amount' . '_' . $payment_method->id,set_value('rls_amount' . '_' . $payment_method->id));?>	
							<?php else:?>
								<?php echo form_input('rls_amount' . '_' . $payment_method->id,'');?>
							<?php endif?>
							<span generated="true" htmlfor="rls_amount_<?php echo $payment_method->id?>" class="error message"><?php echo (form_error('rls_amount'. '_' . $payment_method->id))?form_error('rls_amount'. '_' . $payment_method->id):sprintf(lang('Min. %s %s'),$payment_method->minim_amount,SETTINGS_REAL_CURRENCY_NAME)?></span>
						</div>							
					</div>
				<?php endforeach?>		
				<div>
					<label></label><?php echo form_submit('go',lang('Submit'), 'class="red payment_submit"')?>
				</div>
			</div>
		<?php echo form_close()?>
		<br/>
		<div class="clear"></div>
		<div class="red_h_sep"></div>
		<div class="white_h_sep"></div>
		
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>