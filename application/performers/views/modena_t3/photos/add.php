<script type="text/javascript">
jQuery(function($){

	$.validator.setDefaults({
		validClass:"success",
		errorElement: "span",
		errorPlacement: function(error, element) {
			error.appendTo($(element).next('span').next('span'));
		}
	});
		
	$.validator.addMethod("hasPhoto", function(value,element) {		
		if( $('#photos .qq-upload-list').children('li:visible').length > 0 && $('#photos .qq-upload-list').children('li:visible').length < 4){
			return true;
		} else {
			return false;
		}
	}, "<?php echo lang('Please upload your photo') ?>!");	
	
	
	var validator = $(".add_photo").validate({		 				
		success: function(label) {
	    	label.addClass("valid")
	   },
		rules: {
			photo: {
				hasPhoto: true
			}			
		}, 
		messages: {
			photo			: '<?php echo lang('Please upload a photo')?>'
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
			<?php $add_photo_title = lang('Add Photo')?>
			<span class="eutemia"><?php echo substr($add_photo_title,0,1)?></span><span class="helvetica"><?php echo substr($add_photo_title,1)?></span>
		</div>
		<div id="photos">
            <?php echo form_open_multipart('photos/add', 'class="add_photo"')?>
			<div class="gray italic register_performer" style="width:730px;">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Photo title') ?></span></label>
					<?php echo form_input('title', set_value('title'))?>
					<span class="error message" htmlfor="title" generated="true" ><?php echo form_error('title')?></span>
				</div>
				<div id="photos">
						<?php echo form_hidden('photo', 1)?>
						<label  style="vertical-align: top;"><span class="gray italic bold"><?php echo lang('Photo') ?></span></label>
					    <script src="<?php echo assets_url()?>js/fileuploader.js" type="text/javascript"></script>
						<link href="<?php echo assets_url()?>css/fileuploader.css" rel="stylesheet" type="text/css">									    
						<span id="upload-photos" style="display: inline-block; width:300px;" class="uploader"></span>
						<br/>
						<span style="display: inline-block; width: 300px; margin-left: 222px;">
							<?if($photos):?>								
								<div class="qq-uploader">
									<?foreach($photos as $key => $value):?>
                                        <ul class="qq-upload-list">
                                            <li class="qq-upload-success" key="<?php echo $key?>">
                                                <span class="qq-upload-file-loader" style="width: 100%;"></span>
                                                <span class="qq-upload-file"><?php echo $value['name']?></span>
                                                <span class="qq-upload-size" style="display: inline;"><?php echo $value['size']?></span>
                                                <span class="qq-upload-delete" onclick="delete_file(this)"></span>
                                            </li>
                                        </ul>
									<?endforeach?>
								</div>
							<?endif?>
						</span>
						<span class="error message" htmlfor="photo" generated="true" style="left: 436px; position: absolute; top: 0;"><?php echo form_error('photo')?></span>
				</div>				   							
			    <script type="text/javascript">
			    	jQuery(function($){
			    		createUploader();
			    	});
			        function createUploader(){				         
			            var uploader = new qq.FileUploader({
			                element: document.getElementById('upload-photos'),
			                action: '<?php echo main_url('upload')?>',
			                params: {
			                    type: 'photos'
			                },					                
	                        name: 'userfile[]',
	                        multiple: false,					                
			                allowedExtensions: [], 
			                onComplete: function(id, fileName, responseJSON){ 
								if(responseJSON.success){
									photo = true;
									$('.qq-upload-list li').eq(id).attr('key', responseJSON.key);
								} 
				            },
			                onSubmit: function(id, fileName){
								 $('.qq-upload-button-error').html('');
								 
								 var nr_of_files = $('.qq-upload-list').children('li:visible').length;
								 
								 if(nr_of_files > 0){
									 $('.qq-upload-list').append('<li style="display:none"></li>');
									 $('.qq-upload-button-error').html(" <?php echo lang('You are allowed to upload max 1 photo at once!')?> ");
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
					<label><span class="gray italic bold"><?php echo lang('Gallery') ?></span></label>
					<?php echo form_dropdown('is_paid',$is_paid,set_value('is_paid'))?>
					<span class="error message" generated="true" ><?php echo form_error('is_paid')?></span>
				</div>
				<div style="margin-left:222px;">
					<input type="submit" name="save" value="<?php echo lang('Add photo')?>" class="red" style="width:206px;" />                
				</div>
            </div>
            <?php echo form_close()?>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>