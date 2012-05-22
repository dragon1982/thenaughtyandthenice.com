<script type="text/javascript">
var contract = <?php echo $contract?'true':'false'?>;
var photo_id = <?php echo $photo_id?'true':'false'?>;
jQuery(function($){

	$.validator.setDefaults({
		validClass:"success",
		errorElement: "span",
		errorPlacement: function(error, element) {
			error.appendTo($(element).next('span').next('span'));
		}
	});
		
		
	$.validator.addMethod("hasContract", function(value,element) {		
		if( $('#contracts .qq-upload-list').children('li:visible').length > 0 ){
			return true;
		} else {
			return false;
		}
	}, "<?php echo lang('Please upload your contract!') ?>!");

	$.validator.addMethod("hasPhoto", function(value,element) {		
		if( $('#photos_id .qq-upload-list').children('li:visible').length > 0 ){
			return true;
		} else {
			return false;
		}
	}, "<?php echo lang('Please upload your photo ID!') ?>!");	
	
	$.validator.addMethod("uniqueUserName", function(value,element) {
		return true;
	}, "<?php echo lang('Not Available') ?>!");
	
	var validator = $(".register_performer").validate({		 				
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
			nickname: {
				required: true,
				minlength: 3,
				maxlength: 25
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
			photo_id:{
				hasPhoto: true
			},
			phone: {
				required: true,
				minlength: 3
			},			
			tos: {
				required: true,
				minlength: 1,
				maxlength: 3
			}
		}, 
		messages: {
			name: 						"<?php echo lang('Please enter your name') ?>",
			nickname: 					"<?php echo lang('Please enter a nickname') ?>",
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
			photo_id:					"<?php echo lang('Please upload your photo ID') ?>",
			phone: 						"<?php echo lang('Please enter a valid phone') ?>",
			tos: 						"<?php echo lang('You must agre the terms and conditions') ?>"
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
				<?php $signup_step_1_title = lang('Signup step 1 - Personal Information')?>
				<span class="eutemia"><?php echo substr($signup_step_1_title,0,1)?></span><span class="helvetica"><?php echo substr($signup_step_1_title,1)?></span>
			</div>
			<?php echo form_open_multipart(current_url(), 'class="register_performer"')?>
			<div class="gray italic register_performer">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Username') ?></span></label>
					<?php echo form_input('username',set_value('username'))?>
					<span class="error message" htmlfor="username" generated="true" ><?php echo form_error('username')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Nickname') ?></span></label>
					<?php echo form_input('nickname',set_value('nickname'))?>
					<span class="error message" htmlfor="nickname" generated="true"><?php echo form_error('nickname')?></span>
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
				<script type="text/javascript">
					$(function(){
						if($('#country').val() == 1){
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
				<div>
					<label><span class="gray italic bold"><?php echo lang('Country') ?></span></label>
					<?php echo form_dropdown('country', $countries, set_value('country'),'id="country"')?>
					<span class="error message" htmlfor="country" generated="true"><?php echo form_error('country')?></span>
				</div>
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
				<div id="contracts">
					<?php echo form_hidden('contract',1)?>
					<label style="vertical-align: top;"><span class="gray italic bold" style="position:relative;top:-7px"><?php echo lang('Contract')?><a href="<?php echo main_url('uploads/stuff/sample_contract.pdf')?>" target="_blank"><img style="position: relative; top: 9px;" src="<?php echo assets_url()?>images/icons/down_red.png" alt="<?php echo lang('Download contract')?>" title="<?php echo lang('Download contract')?>" /></a>:</span></label>
				    <script src="<?php echo assets_url()?>js/fileuploader.js" type="text/javascript"></script>
					<link href="<?php echo assets_url()?>css/fileuploader.css" rel="stylesheet" type="text/css">
					<a title="<?php echo lang('You can upload jpg/png/pdf/zip files')?>"><span id="upload-contract" style="display: inline-block; width:300px;" class="uploader"></span></a>																	
					<br/>
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
					   				
			    </script>				    
				<div id="photos_id">
						<?php echo form_hidden('photo_id',1)?>
						<label  style="vertical-align: top;"><span class="gray italic bold"><?php echo lang('Photo ID') ?></span></label>
						<a title="<?php echo lang('You can upload jpg/png/pdf/zip files')?>"><span id="upload-photo_id" style="display: inline-block; width:300px;" class="uploader"></span></a>
						<br/>
						<span style="display: block; width:300px;margin-left: 372px;" id="upload-photo_id" class="uploader">
							<?php if($photo_id):?>								
								<div class="qq-uploader">
									<?php foreach($photo_id as $key => $value):?>
										<ul class="qq-upload-list"><li class="qq-upload-success" key="<?php echo $key?>"><span class="qq-upload-file-loader" style="width: 100%;"></span><span class="qq-upload-file"><?php echo $value['name']?></span><span class="qq-upload-size" style="display: inline;"><?php echo $value['size']?></span><span class="qq-upload-failed-text"></span><span class="qq-upload-delete" onclick="delete_file(this)"></span></li></ul>
									<?php endforeach?>							
								</div>
							<?php endif?>
						</span>
						<span class="error message" htmlfor="contract" generated="true" style="left: 586px; position: absolute; top: 0;"><?php echo form_error('photo_id')?></span>
				    
				</div>				   							
			    <script type="text/javascript">
			    	jQuery(function($){
			    		createUploader_Photo();
			    	});
			        function createUploader_Photo(){				         
			            var uploader = new qq.FileUploader({
			                element: document.getElementById('upload-photo_id'),
			                action: '<?php echo main_url('upload')?>',
			                params: {
			                    type: 'photo_id'
			                },					                
	                        name: 'userfile[]',
	                        multiple: true,					                
			                allowedExtensions: [], 
			                onComplete: function(id, fileName, responseJSON){ 
								if(responseJSON.success){
									photo_id = true;
									$('#photos_id .qq-upload-list li').eq(id).attr('key', responseJSON.key);
								} 
				            },
			                onSubmit: function(id, fileName){
								 $('#photos_id .qq-upload-button-error').html('');
								 
								 var nr_of_files = $('#photos_id .qq-upload-list').children('li:visible').length;
								 
								 if(nr_of_files > 1){
									 $('#photos_id .qq-upload-list').append('<li style="display:none"></li>');
									 $('#photos_id .qq-upload-button-error').html("<?php echo lang('You are allowed to upload max 1 file!') ?>");
									 return false;
								 }
							},
			                onProgress: function(id, fileName, loaded, total){
								$('#photos_id .qq-upload-list li').eq(id).find('.qq-upload-file-loader').css('width', Math.round(loaded / total * 100) + '%');
							},
			                onCancel: function(id, fileName){
								//alert("cancel");
				            },	
			                
							showMessage: function( message, id){ 
									 if(id == undefined){
										 $('#photos_id .qq-upload-button-error').html(message);
									 }else{
										$('#photos_id .qq-upload-list li').eq(id).find('.qq-upload-size').html(message);
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
				<div>
					<label></label>
					<?php echo form_checkbox('tos', 'tos',set_value('tos'))?><span class="gray italic bold" id="tos"><a href="<?php echo main_url('documents/tos')?>" target="_blank"><?php echo lang('I agree the Terms of Service')?></a></span>
					<span class="error message" htmlfor="tos" generated="true"><?php echo form_error('tos')?></span>
				</div>
				<div style="margin-top:8px; text-align: left; padding-left:372px;">
					<button class="red"  type="submit" style="width:207px;"><?php echo lang('Continue') ?> </button><br/>
				</div>
				<div class="clear"></div>
				<?php echo form_close()?>
			</div>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>