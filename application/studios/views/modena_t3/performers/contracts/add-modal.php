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


	$.validator.addMethod("hasContract", function(value,element) {		
		if( $('#contracts .qq-upload-list').children('li:visible').length > 0 ){
			return true;
		} else {
			return false;
		}
	}, "<?php echo lang('Please upload your contract!') ?>!");

	
		var validator = $(".add_contract").validate({
		success: function(label) {
	    	label.addClass("valid")
	   },
		rules: {

			contract:{
				hasContract: true
			}
		}, 
		messages: {
			contract:					"<?php echo lang('Please upload your contract') ?>"
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
				<?php $account_summary_title = lang('Contracts - Add contract') ?>
				<span class="eutemia"><?php echo substr($account_summary_title,0,1)?></span><span class="helvetica"><?php echo substr($account_summary_title,1)?></span>
			</div>
			<div class="gray italic" id="studio_settings"> 	
			<?php echo form_open_multipart(current_url(), 'class="add_contract"')?>
						
				<div id="contracts">
						<?php echo form_hidden('contract',1)?>
						<label  style="vertical-align: top;"><span class="gray italic bold"><?php echo lang('Contract') ?>:</span></label>
					    <script src="<?php echo assets_url()?>js/fileuploader.js" type="text/javascript"></script>
						<link href="<?php echo assets_url()?>css/fileuploader.css" rel="stylesheet" type="text/css">									    
						<a title="<?php echo lang('You can upload jpg/png/pdf/zip files')?>"><span id="upload-contract" style="display: inline-block; width:300px;" class="uploader"></span></a>
						<span style="display: block; width:300px;margin-left: 222px;" id="upload-contract" class="uploader">
							<?php if($contract):?>								
								<div class="qq-uploader">
									<?php foreach($contract as $key => $value):?>
										<ul class="qq-upload-list"><li class="qq-upload-success" key="<?php echo $key?>"><span class="qq-upload-file-loader" style="width: 100%;"></span><span class="qq-upload-file"><?php echo $value['name']?></span><span class="qq-upload-size" style="display: inline;"><?php echo $value['size']?></span><span class="qq-upload-delete" onclick="delete_file(this)"></span></li></ul>
									<?php endforeach?>							
								</div>
							<?php endif?>
						</span>
						<span class="error message" htmlfor="contract" generated="true"style="left: 440px; position: absolute; top: 0;"><?php echo form_error('contract')?></span>
				    
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
				<div style="margin-left:223px;">
					<br>
					<div onclick="$('.add_contract').validate()"><button class="red" style="width:206px;"><?php echo lang('Add contract') ?></button><span class="submit_r"/></div>
				</div>	
				<?php echo form_close();?>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>