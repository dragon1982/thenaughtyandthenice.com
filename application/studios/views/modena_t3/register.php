<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">
var contract = <?php echo $contract?'true':'false'?>;
jQuery(function($){
	
	$.validator.setDefaults({
		validClass:"success",
		errorElement: "span",
		errorPlacement: function(error, element) {
		error.appendTo($(element).next('span').next('span'));
		}
	});

    $.extend($.validator.messages, {
        required: "<?php echo lang('Please select a payment method')?>",
    });

	$.validator.addMethod("hasContract", function(value,element) {		
		if( $('#contracts .qq-upload-list').children('li:visible').length > 0 ){
			return true;
		} else {
			return false;
		}
	}, "<?php echo lang('Please upload your contract!') ?>!");
		
	$.validator.addMethod("uniqueUserName", function(value,element) {
		return true;
	}, "<?php echo lang('Not Available') ?>!");
	
	
	var validator = $(".register_studio").validate({
		 		
		success: function(label) {
	    	label.addClass("valid")
	   },
		rules: {
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
			email: {
				required: true,
				email: true
			},
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
			contract:{
				hasContract: true
			},
			phone: {
				required: true,
				minlength: 6,
				number: true
			},
			
			percentage: {
				required: true,
				min: 0,
				max: 100
			},
			
			tos: {
				required: true,
				minlength: 1
			},
			payment_method: {
				required: true			
			}
		}, 
		messages: {
			username: 					"<?php echo lang('Please enter a valid username') ?>",
			email: 						"<?php echo lang('Please enter a valid email address') ?>",
			password: 					"<?php echo lang('Password must have at least 3 characters') ?>",
			firstname: 					"<?php echo lang('Please enter a valid first name') ?>",
			lastname: 					"<?php echo lang('Please enter a valid last name') ?>",
			address: 					"<?php echo lang('Please enter a valid address') ?>",
			city: 						"<?php echo lang('Please enter a valid city') ?>",
			zip: 						"<?php echo lang('Please enter a valid zip') ?>",
			state: 						"<?php echo lang('Please enter a valid state') ?>",
			country: 					"<?php echo lang('Please enter a valid country') ?>",
			contract:					"<?php echo lang('Please upload your contract') ?>",
			phone: 						"<?php echo lang('Please enter a valid phone') ?>",
			percentage:	 				"<?php echo lang('Please enter a valid percentage') ?>",
			tos: 						"<?php echo lang('You must agre the terms and conditions') ?>",
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
<div id="verifier"></div>
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $studios_registration = lang('Studios Registration')?>
				<span class="eutemia"><?php echo substr($studios_registration,0,1)?></span><span class="helvetica "><?php echo substr($studios_registration,1)?></span>
			</div>
			<?php echo form_open_multipart('register', 'class="register_studio"')?>
			<div class="gray italic register_studio">
				<div>
					<span class="red"><?php echo lang('Personal information') ?></span>
				</div>  	
				<div>
					<label><span class="gray italic bold"><?php echo lang('Username') ?></span></label>
					<?php echo form_input('username',set_value('username'))?>
					<span class="error message" htmlfor="username" generated="true" ><?php echo form_error('username')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Password') ?></span></label>
					<?php echo form_password('password',set_value('password'))?>
					<span class="error message" htmlfor="password" generated="true"><?php echo form_error('password')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Email') ?></span></label>
					<?php echo form_input('email',set_value('email'))?>
					<span class="error message" htmlfor="email" generated="true"><?php echo form_error('email')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('First name') ?></span></label>
					<?php echo form_input('firstname',set_value('firstname'))?>
					<span class="error message" htmlfor="firstname" generated="true"><?php echo form_error('firstname')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Last name') ?></span></label>
					<?php echo form_input('lastname',set_value('lastname'))?>
					<span class="error message" htmlfor="lastname" generated="true"><?php echo form_error('lastname')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Address') ?></span></label>
					<?php echo form_input('address',set_value('address'))?>
					<span class="error message" htmlfor="address" generated="true"><?php echo form_error('address')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('City') ?></span></label>
					<?php echo form_input('city',set_value('city'))?>
					<span class="error message" htmlfor="city" generated="true"><?php echo form_error('city')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Zip') ?></span></label>
					<?php echo form_input('zip',set_value('zip'))?>
					<span class="error message" htmlfor="zip" generated="true"><?php echo form_error('zip')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Country') ?></span></label>
					<?php echo form_dropdown('country', $countries, set_value('country'),'id="country"')?>
					<span class="error message" htmlfor="country" generated="true"><?php echo form_error('country')?></span>
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
					<label><span class="gray italic bold"><?php echo lang('State') ?></span></label>
					<?php echo form_input('state',set_value('state'))?>
					<span class="error message" htmlfor="state" generated="true"><?php echo form_error('state')?></span>
				</div>				
				<div>
					<label><span class="gray italic bold"><?php echo lang('Phone') ?></span></label>
					<?php echo form_input('phone',set_value('phone'))?>
					<span class="error message" htmlfor="phone" generated="true"><?php echo form_error('phone')?></span>
				</div>
				<div class="percentage">
					<label><span class="gray italic bold"><?php echo lang('Percentage') ?></span></label>
					<?php echo form_input(array('name' => 'percentage', 'id' => 'percentage', 'value' => set_value('percentage'), 'style'=>'width:200px; text-align:left'))?>
					<span class="error message" htmlfor="percentage" generated="true"><?php echo form_error('percentage')?></span>
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
					<span class="red">Contract</span>
				</div>  				
				<div id="contracts">
					<?php echo form_hidden('contract',1)?>
					<label style="vertical-align: top;"><span class="gray italic bold" style="position:relative;top:-7px"><?php echo lang('Contract')?><a href="<?php echo main_url('uploads/stuff/sample_contract_studio.pdf')?>" target="_blank"><img style="position: relative; top: 9px;" src="<?php echo assets_url()?>images/icons/down_red.png" alt="<?php echo lang('Download contract')?>" title="<?php echo lang('Download contract')?>" /></a>:</span></label>
				    <script src="<?php echo assets_url()?>js/fileuploader.js" type="text/javascript"></script>
					<link href="<?php echo assets_url()?>css/fileuploader.css" rel="stylesheet" type="text/css">									    
					<a title="<?php echo lang('You can upload jpg/png/pdf/zip files')?>"><span id="upload-contract" style="display: inline-block; width:300px;" class="uploader"></span></a>
					<span style="display: block; width:300px;margin-left: 372px;" id="upload-contract" class="uploader">
						<?php if($contract):?>								
							<div class="qq-uploader">
								<?php foreach($contract as $key => $value):?>
									<ul class="qq-upload-list"><li class="qq-upload-success" key="<?php echo $key?>"><span class="qq-upload-file-loader" style="width: 100%;"></span><span class="qq-upload-file"><?php echo $value['name']?></span><span class="qq-upload-size" style="display: inline;"><?php echo $value['size']?></span><span class="qq-upload-failed-text"></span><span class="qq-upload-delete" onclick="delete_file(this)"></span></li></ul>
								<?php endforeach?>							
							</div>
						<?php endif?>
					</span>
					<span class="error message" htmlfor="contract" generated="true" style="left: 586px; position: absolute; top: 0;"><?php echo form_error('contract')?></span>				    
				</div>				   							
			    <script type="text/javascript">
			    	jQuery(function($){
			    		createUploader();
			    	});
			        function createUploader(){				         
			            var uploader = new qq.FileUploader({
			                element: document.getElementById('upload-contract'),
			                action: '<?php echo main_url('upload')?>',
			                params: {
			                    type: 'contract'
			                },					                
	                        name: 'userfile[]',
	                        multiple: true,					                
			                allowedExtensions: [], 
			                onComplete: function(id, fileName, responseJSON){ 
								if(responseJSON.success){
									contract = true;
									$('#contracts .qq-upload-list li').eq(id).attr('key', responseJSON.key);
								} 
				            },
			                onSubmit: function(id, fileName){
								 $('#contracts .qq-upload-button-error').html('');
								 
								 var nr_of_files = $('#contracts .qq-upload-list').children('li:visible').length;
								 
								 if(nr_of_files > 2){
									 $('#contracts .qq-upload-list').append('<li style="display:none"></li>');
									 $('#contracts .qq-upload-button-error').html("<?php echo lang('You are allowed to upload max 3 files!') ?>");
									 return false;
								 }
							},
			                onProgress: function(id, fileName, loaded, total){
								$('#contracts .qq-upload-list li').eq(id).find('.qq-upload-file-loader').css('width', Math.round(loaded / total * 100) + '%');
							},
			                onCancel: function(id, fileName){
								//alert("cancel");
				            },	
			                
							showMessage: function( message, id){ 
									 if(id == undefined){
										 $('#contracts .qq-upload-button-error').html(message);
									 }else{
									 	$('#contracts .qq-upload-list li').eq(id).find('.qq-upload-size').html(message);
									 }									  
								},
			                			                					                
			                debug: false
			            });           
			        }
			        
					function delete_file(item){						
						var key = $(item).parent('li').attr('key');
						var item_file = $(item).parent('li');
						var type =  $(item).parent().parent().parent().parent().parent().children('.uploader').attr('id');
						if(item_file.attr('class') == ' qq-upload-fail'){
							item_file.css('display', 'none');
							 $('.qq-upload-button-error').html('');
						}else{
							$.ajax({
								type: "POST",
								url: "<?php echo main_url('upload/delete_file')?>",
								data: "type="+type+"&file_key="+key+"&ci_csrf_token=<?php echo $this->security->_csrf_hash?>",
								
								// If successfully request
								success: function(msg){
									if(msg == 'deleted') {												
										item_file.css('display', 'none');
										$('.qq-upload-button-error').html('');
									} 
								},

								// If failed request
								error: function(){
									alert("<?php echo lang('Error please try again') ?>");
								}
							});
							// End ajax												
						}																
					}					   				
			    </script>				
				<div style="position:relative; right:8px; top:8px;">
					<label></label>
					<?php echo form_checkbox('tos', 'tos',set_value('tos'))?><span class="gray italic bold" id="tos"><a href="<?php echo main_url('documents/tos')?>" target="_blank"><?php echo lang('I agree the Terms of Service')?></a></span>
					<span class="error message" htmlfor="tos" generated="true"><?php echo form_error('tos')?></span>
				</div>
				<div style="margin-left: 223px">
					<br>
					<div onclick="$('.register_studio').validate()"><button class="red resize"><?php echo lang('Register') ?></button></div>
				</div>	
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>