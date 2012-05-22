<script type="text/javascript">
var avatar = <?php echo $avatar?'true':'false'?>;
jQuery.validator.setDefaults({
	validClass:"success",
	errorElement: "span",
	errorPlacement: function(error, element) {
		error.appendTo($(element).next('span').next('span'));
	}
});
jQuery(function($){

	$.validator.addMethod("checkLang", function(value,element) {		
		if ($("input:checkbox:checked").length  > 0){			
            return true;
		}
        else
        {       
            return false;
        }
	}, "<?php echo lang('Please select at least one language!')?>");


//	$.validator.addMethod("hasAvatar", function(value,element) {		
//		if( $('.qq-upload-list').children('li:visible').length > 0 ){
//			return true;
//		} else {
//			return false;
//		}
//	}, "<?php echo lang('Please upload your avatar!') ?>!");
		
	$.validator.addMethod("checkDate", function(value,element) {		
		var d = new Date($('#year').val(),$('#month').val(),$('#day').val(),0,0,0,0); 
		if ( Object.prototype.toString.call(d) === "[object Date]" ) {
			  // it is a date
			 if ( isNaN( d.getTime() ) ) {  // d.valueOf() could also work
			    return false;
			  }

		} else {
			 return false;
		}	
		return true;
	}, "<?php echo lang('Please enter a valid birthday') ?>");	

	$(".register_performer").validate({
		success: function(label) {
	    	label.addClass("valid")
	   },
		rules: {
			gender: {
				required: true,
				minlength: 1,
				maxlength: 60
			},
			description: {
				required: true,
				minlength: 3
			},
			what_turns_me_on: {
				required: true,
				minlength: 8
			},
			what_turns_me_off: {
				required: true,
				minlength: 8
			},
			avatar:{
				hasAvatar:true
			},
			sexual_prefference: {
				required: true,
				minlength: 1,
				maxlength: 60
			},
			ethnicity: {
				required: true,
				minlength: 1,
				maxlength: 90
			},
			weight:{
				required: true
			},
			height: {
				required: true,
				minlength: 1,
				maxlength: 200
			},
			hair_color: {
				required: true,
				minlength: 1,
				maxlength: 60
			},
			hair_length: {
				required: true,
				minlength: 1,
				maxlength: 60
			},
			eye_color: {
				required: true,
				minlength: 1,
				maxlength: 60
			},
			cup_size: {
				required: true,
				minlength: 1,
				maxlength: 60				
			},
			build: {
				required: true,
				minlength: 1,
				maxlength: 90
			},			
			check_lang: {
				checkLang: true
			},
			year: {
				required: true,
				checkDate: true
			}
		}, 
		messages: {
			gender: 					"<?php echo lang('Please enter a valid gender') ?>",
			description: 				"<?php echo lang('Please enter a valid description') ?>",
			what_turns_mo_on: 			"<?php echo lang('Please enter at least 8 characters') ?>",
			what_turns_me_off: 			"<?php echo lang('Please enter at least 8 characters') ?>",
			avatar:						"<?php echo lang('Please upload your avatar') ?>",						
			sexual_prefference: 		"<?php echo lang('Please enter a valid sexual preference') ?>",
			ethnicity: 					"<?php echo lang('Please enter a valid ethnicy') ?>",
			weight: 					"<?php echo lang('Please enter a valid weight') ?>",
			height: 					"<?php echo lang('Please enter a valid height') ?>",
			hair_color: 				"<?php echo lang('Please enter a hair color') ?>",
			hair_lenght: 				"<?php echo lang('Please enter a valid hair lenght') ?>",
			eye_color: 					"<?php echo lang('Please enter a valid eye color') ?>",
			build: 						"<?php echo lang('Please enter a valid build') ?>",		
			cup_size:					"<?php echo lang('Please enter a valid cup size') ?>",	
			check_lang:					"<?php echo lang('Please choose at least one language') ?>",
			year: 						"<?php echo lang('Please enter a valid birthday') ?>"
		},
		debug: false 
	});
}); 
</script>	
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $signup_step_5 = lang('Signup step 5 - About you')?>
				<span class="eutemia"><?php echo substr($signup_step_5,0,1)?></span><span class="helvetica"><?php echo substr($signup_step_5,1)?></span>
			</div>
			<?php echo form_open_multipart('register', 'class="register_performer"')?>
			<div class="gray italic register_performer">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Gender') ?>:</span></label>
					<?php echo form_dropdown('gender',$gender,set_value('gender'))?>
					<span class="error message" htmlfor="gender" generated="true"><?php echo form_error('gender')?></span>
				</div>
				<div>
					<label><span class="gray italic bold" id="performerTexAlign"><?php echo lang('Description') ?>:</span></label>
					<?php echo form_textarea('description',set_value('description'), 'rows="10" cols="90"')?>
					<span class="error message" htmlfor="description" generated="true"><?php echo form_error('description')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('What turns me on') ?>:</span></label>
					<?php echo form_textarea('what_turns_me_on',set_value('what_turns_me_on'), 'rows="10" cols="90"')?>
					<span class="error message" htmlfor="what_turns_me_on" generated="true"><?php echo form_error('what_turns_me_on')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('What turns me off') ?>:</span></label>
					<?php echo form_textarea('what_turns_me_off',set_value('what_turns_me_off'), 'rows="10" cols="90"')?>
					<span class="error message" htmlfor="what_turns_me_off" generated="true"><?php echo form_error('what_turns_me_off')?></span>
				</div>
				<div>
					<?php echo form_hidden('avatar',1)?>
					<label style="vertical-align: top;"><span class="gray italic bold"><?php echo lang('Avatar') ?>:</span></label>
				    <script src="<?php echo assets_url()?>js/fileuploader.js" type="text/javascript"></script>
					<link href="<?php echo assets_url()?>css/fileuploader.css" rel="stylesheet" type="text/css">									    
					<span id="upload-avatar" style="display: inline-block; width:300px;" class="uploader"></span>
					<br/>
					<span style="display: inline-block; width:300px;margin-left: 372px;">
						<?php if($avatar):?>								
							<div class="qq-uploader">
								<?php foreach($avatar as $key => $value):?>
									<ul class="qq-upload-list"><li class="qq-upload-success" key="<?php echo $key?>"><span class="qq-upload-file-loader" style="width: 100%;"></span><span class="qq-upload-file"><?php echo $value['name']?></span><span class="qq-upload-size" style="display: inline;"><?php echo $value['size']?></span><span class="qq-upload-failed-text"></span><span class="qq-upload-delete" onclick="delete_file(this)"></span></li></ul>
								<?php endforeach?>							
							</div>
						<?php endif?>
					</span>
					<span class="error message" htmlfor="avatar" generated="true" style="left: 586px; position: absolute; top: 2px;"><?php echo form_error('avatar')?></span>				    
				</div>				   							
			    <script type="text/javascript">
			    	jQuery(function($){
			    		createUploader();
			    	});
			        function createUploader(){				         
			            var uploader = new qq.FileUploader({
			                element: document.getElementById('upload-avatar'),
			                action: '<?php echo main_url('upload')?>',
			                params: {
			                    type: 'avatar'
			                },					                
	                        name: 'userfile[]',
	                        multiple: false,					                
			                allowedExtensions: [], 
			                onComplete: function(id, fileName, responseJSON){ 
								if(responseJSON.success){
									avatar = true;
									$('.qq-upload-list li').eq(id).attr('key', responseJSON.key);
								} 
				            },
			                onSubmit: function(id, fileName){
								 $('.qq-upload-button-error').html('');
								 
								 var nr_of_files = $('.qq-upload-list').children('li:visible').length;
								 
								 if(nr_of_files > 0){
									 $('.qq-upload-list').append('<li style="display:none"></li>');
									 $('.qq-upload-button-error').html('<?php echo lang('You are allowed to upload max 1 photo!') ?>');
									 return false;
								 }
							},
			                onProgress: function(id, fileName, loaded, total){
								$('.qq-upload-list li').eq(id).find('.qq-upload-file-loader').css('width', Math.round(loaded / total * 100) + '%');
							},
			                onCancel: function(id, fileName){
								//alert("cancel");
				            },	
			                
							showMessage: function( message, id){ 
									 if(id == undefined){
										 $('.qq-upload-button-error').html(message);
									 }else{
										$('.qq-upload-list li').eq(id).find('.qq-upload-size').html(message);
									 }									  
								},
			                			                					                
			                debug: false
			            });           
			        }
					   
					function delete_file(item){						
						var key = $(item).parent('li').attr('key');
						var item_file = $(item).parent('li');
						var type = $('span.uploader').attr('id');						
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
					<label><span class="gray italic bold"><?php echo lang('Sexual prefference') ?>:</span></label>
					<?php echo form_dropdown('sexual_prefference',$sexual_prefference,set_value('sexual_prefference'))?>
					<span class="error message" htmlfor=sexual_prefference generated="true"><?php echo form_error('sexual_prefference')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Ethnicity') ?>:</span></label>
					<?php echo form_dropdown('ethnicity',$ethnicity,set_value('ethnicity'))?>
					<span class="error message" htmlfor="ethnicity" generated="true"><?php echo form_error('ethnicity')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Weight') ?>:</span></label>
					<?php echo form_dropdown('weight',$weight,set_value('weight'))?>
					<span class="error message" htmlfor="weight" generated="true"><?php echo form_error('weight')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Height') ?>:</span></label>
					<?php echo form_dropdown('height',$height,set_value('height'))?>
					<span class="error message" htmlfor="height" generated="true"><?php echo form_error('height')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Hair color') ?>:</span></label>
					<?php echo form_dropdown('hair_color',$hair_color,set_value('hair_color'))?>
					<span class="error message" htmlfor="hair_color" generated="true"><?php echo form_error('hair_color')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Hair lenght') ?>:</span></label>
					<?php echo form_dropdown('hair_length',$hair_length,set_value('hair_length'))?>
					<span class="error message" htmlfor="hair_length" generated="true"><?php echo form_error('hair_length')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Eye color') ?>:</span></label>
					<?php echo form_dropdown('eye_color',$eye_color,set_value('eye_color'))?>
					<span class="error message" htmlfor="eye_color" generated="true"><?php echo form_error('eye_color')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Cup size') ?>:</span></label>
					<?php echo form_dropdown('cup_size',$cup_size,set_value('cup_size'))?>
					<span class="error message" htmlfor="cup_size" generated="true"><?php echo form_error('cup_size')?></span>
				</div>				
				<div>
					<label><span class="grey italic bold"><?php echo lang('Languages') ?>:</span></label>
					<?php echo form_hidden('check_lang',1)?>
					<span style="display: inline-block;">
					<?php foreach($languages as $language):?>
						<span style="display: block; padding-top: 3px; width:210px;"><label><?php echo form_checkbox('lang[]', $language->code, set_checkbox('lang', $language->code))?><span class="gray italic bold"><?php echo ucfirst($language->title)?></span></label></span>
					<?php endforeach?>
					</span>
					<span class="error message" htmlfor="check_lang" generated="true" style="vertical-align: top;"><?php echo form_error('check_lang')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Build') ?>:</span></label>
					<?php echo form_dropdown('build',$build,set_value('build'))?>
					<span class="error message" htmlfor="build" generated="true"><?php echo form_error('build')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Birthday') ?>:</span></label>
					<?php echo form_dropdown('day',$days,set_value('day'), 'class="small" id="day"')?>
					<?php echo form_dropdown('month',$months,set_value('month'), 'class="small" id="month"')?>
					<?php echo form_dropdown('year',$years,set_value('year'), 'class="small" id="year"')?>
					<span class="error message" htmlfor="year" generated="true"><?php echo form_error('year')?></span>
				</div>
				<div style="margin-top:8px; text-align: left; padding-left:372px;">
					<button class="red"  type="submit" style="width:207px;"><?php echo lang('Continue') ?> </button><br/>
				</div>
				<div class="clear"></div>
				
			</div>
			<?php form_close()?>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>	