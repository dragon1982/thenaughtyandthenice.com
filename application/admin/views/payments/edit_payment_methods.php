<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">	
		var i = 1;
		function addFormField( field_name ) {
			$("#append").before("<div id=\"field_" + i + "_div\" class=\"inputboxes\"><label for=\"field_" + i + "\"><?php echo lang('Added Field') ?>: </label><input type=\"text\" name=\"field_" + i + "\" value=\"" + field_name + "\" id=\"field_" + i + "\" class=\"inputbox payment\" tabindex=\"1\" type=\"text\" /><a class=\"position_mod\" onclick=\"javascript:removeField('field_" + i + "_div');\"><?php echo lang('Remove') ?></a></div>");
			document.getElementById("add_field").value = "";
			i++;
		}
		function removeField( field_name ) {
			$('#' + field_name).remove();
		}
</script>
			
<script type="text/javascript">
jQuery(function($){
	$('.add_payment').submit(function(){
		$('.add_payment').validate();
	});

	$.validator.setDefaults({
		validClass:"success_adm",
		errorClass: "error_adm",
		errorPlacement: function(error, element) {
			return true;
		}
	});
	
	var validator = $(".add_payment").validate({
		rules: {
			name: {
		   		required: true,
		   		minlength:3,
		   		maxlength:40
	   		},
	   		minimum_amount: {
		   		required:  true,
		   		minlength: 1,
		   		maxlength: 6,
		   		number:    true
	   		},
		    status: {
				required: true
			}
		}, 
		messages: {
			status:   "",
			currency: ""
		},
		
		submitHandler: function(form) {
			form.submit();
		},
		debug: true
	});
	
	$('#add_field').blur(function() {
	    if($(this).validate()) {
	        $(this).addClass("");
	    } else {
	        $(this).addClass("");
	    }
	});
}); 
</script>	
			
			<div class="container">
				<div class="conthead">
				<?php $this->load->view('payments/payments_submenu')?>
				</div>
				<div class="contentbox">
					<div class="center_contentbox">
						
						<h2><?php echo lang('Edit Payment Method')?></h2>
						
						<?php echo form_open('payment-methods/edit/' . $payment->id, 'class="add_payment"') ?>

							<!-- NAME -->
							<div class="inputboxes">
								<label for="name"><?php echo lang('Name')?>: </label>
								<?php echo form_input('name', set_value('name',$payment->name), 'id="name" class="inputbox payment" tabindex="1" type="text"')?>
							</div>
							
							<!-- MINIMUM AMOUNT -->
							<div class="inputboxes">
								<label for="minimum_amount"><?php echo lang('Minimum Amount')?>: </label>
								<?php echo form_input('minimum_amount', set_value('minimum_amount', $payment->minim_amount), 'id="minimum_amount" class="inputbox payment" tabindex="1" type="text"')?>
							</div>
						
							<!-- STATUS -->
							<div class="inputboxes" >
								<label for="status"><?php echo lang('Status')?>: </label>
								<?php echo form_dropdown('status', $status, set_value('status', $payment->status), 'id="status" class="inputbox" tabindex="1" type="text"')?>
								<span></span>
							</div>
							
							<!-- AFISEZ FIELD-URILE SUPLIMENTARE, DACA EXISTA -->
							<?php $extra_fields = unserialize($payment->fields);
							      foreach($extra_fields as $key => $field): ?>
							<div class="inputboxes" id="fieldextra_<?php echo ($key+1) ?>_div">
								<label for="fieldextra_<?php echo ($key+1) ?>"><?php echo lang('Extra Field') . ' ' . ($key+1) ?>: </label>
								<?php echo form_input('fieldextra_' . ($key+1) , set_value('fieldextra_' . ($key+1), $field), 'id="fieldextra_' . ($key+1) . '" class="inputbox payment" tabindex="1" type="text"')?>
								<a class="position_mod" onclick="javascript:removeField('fieldextra_<?php echo ($key+1) ?>_div');"><?php echo lang('Remove') ?></a>
							</div>
							<?php endforeach ?>
							
							<!-- AFISEZ FIELD-URILE GENERATE DE ADMIN, DACA EXISTA -->
							<?php $i = 1; ?>
							<?php foreach($old_fields as $key => $value):?>
							<?php $i++; ?>
							<div class="inputboxes" id="field_old_<?php echo $i ?>_div">
								<label for="field_old_<?php echo $i ?>"><?php echo lang('Added Field')?>: </label>
								<?php echo form_input('field_old_' . $i, set_value('field_old_'. $i, $value), 'class="inputbox payment" tabindex="1" type="text"')?>
								<a class="position_mod" onclick="javascript:removeField('field_old_<?php echo $i ?>_div');"><?php echo lang('Remove') ?></a>
							</div>
							<?php endforeach ?>
							
							<div id="append"></div>
						<?php echo form_close()?>
						
						<!-- ADD FIELD -->
						<div class="inputboxes">
							<label for="add_field"><?php echo lang('Add Field')?>: </label>
							<?php echo form_input('add_field', set_value('add_field', ''), 'id="add_field" class="inputbox payment" tabindex="1" type="text"')?>
							<a class="position_mod" onclick="javascript:addFormField(document.getElementById('add_field').value);"><img src="<?php echo assets_url('admin/images/icons/add_field.png')?>" alt="<?php echo lang('Add Field') ?>" /></a>
						</div>
						<input class="btn" type="button" onclick="$('.add_payment').submit();" tabindex="3" value="<?php echo lang('Edit Payment Method')?>" />	
					</div>
				</div>
			</div>
