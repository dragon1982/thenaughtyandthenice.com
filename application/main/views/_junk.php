




//performers view
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $this->load->view('includes/_search')?>
			<?php $_live_perf_title = lang('Live Performers')?>
			<spa+n class="eutemia "><?php echo substr($_live_perf_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($_live_perf_title, 1) ?></span>
		</div>
		<div class="clear"></div>
		<div id="performer_list">
			<?php if(sizeof($performers) > 0):?>
				<script type="text/javascript" src="<?php echo assets_url()?>js/preview.js"></script>
				<?php foreach($performers as $performer):?>
					<?php $this->load->view('performer',array('performer'=>$performer))?>
				<?php endforeach?>
			<?php else:?>
				<div class="no_results"><?php echo lang('There are no performers online')?></div>
			<?php endif?>
			<div class="clear"></div>
			<?php if($pagination):?>
				<?php echo $pagination;?>
			<?php endif?>
			<div class="clear"></div>
		</div>
		<?php if(isset($performers_in_private) && sizeof($performers_in_private) > 0):?>
			<div class="title" style="margin-top:15px">
				<?php $_live_perf_title = lang('Performers currently in private')?>
				<span class="eutemia "><?php echo substr($_live_perf_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($_live_perf_title, 1) ?></span>
			</div>
			<div class="clear"></div>
			<?php foreach($performers_in_private as $performer):?>
					<?php $this->load->view('performer',array('performer'=>$performer))?>
			<?php endforeach?>
			<div class="clear"></div>
		<?php endif?>
		<?php if(isset($videos_free) && sizeof($videos_free) > 3):?>
			<div class="title" style="margin-top:15px">
				<?php $_live_perf_title = lang('Free videos')?>
				<span class="eutemia "><?php echo substr($_live_perf_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($_live_perf_title, 1) ?></span>
			</div>
			<div class="clear"></div>
			<?php foreach($videos_free as $video):?>
				<?php $this->load->view('videos/listing',array('video' => $video))?>
			<?php endforeach?>
			<div class="clear"></div>
		<?php endif?>
		<?php if(isset($videos_paid) && sizeof($videos_paid) > 3):?>
			<div class="title" style="margin-top:15px">
				<?php $_live_perf_title = lang('Paid videos')?>
				<span class="eutemia "><?php echo substr($_live_perf_title, 0, 1) ?></span><span class="helvetica "><?php echo substr($_live_perf_title, 1) ?></span>
			</div>
			<div class="clear"></div>
			<?php foreach($videos_paid as $video):?>
				<?php $this->load->view('videos/listing',array('video' => $video))?>
			<?php endforeach?>
			<div class="clear"></div>
		<?php endif?>

	</div>

	<script type="text/javascript">
		function previewOpenVideoInModal(video_id){
			$.fancybox({
				'overlayShow': true,
				'scrolling': 'no',
				'type': 'iframe',
				'width':800,
				'height':600,
				'showCloseButton'	: true,
				'href': '<?php echo site_url('videos/view')?>' + '/' + video_id,
				'overlayColor': "#FFF",
				'overlayOpacity': "0.3"
			});
		}

		function pay_video(video_id){
			$.ajax({
				url: '<?php echo site_url('videos/view/')?>' + '/'+ video_id,
				complete: function(html) {
					$.blockUI({ message: html.responseText});
				}
			});
			return false;
		}
	</script>
</div>
</div></div><div class="black_box_bg_bottom"></div>






//menu
<div id="menu">
	<div class="item">
		<span class="bg_l "></span><span class="bg_m ">
			<a href="<?php echo base_url()?>" class="menu_item">
				<?php $menu_item = lang('Online Chat')?>
				<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
			</a>
		</span><span class="bg_r "></span>
	</div>
	<div class="item">
		<span class="bg_l "></span><span class="bg_m ">
			<a href="<?php echo site_url('performers')?>" class="menu_item">
				<?php $menu_item = lang('Our Models')?>
				<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
			</a>
		</span><span class="bg_r "></span>
	</div>
	<div class="item">
		<span class="bg_l "></span><span class="bg_m ">
			<a href="<?php echo site_url('favorites')?>" class="menu_item">
				<?php $menu_item = lang('Favorites')?>
				<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
			</a>
		</span><span class="bg_r "></span>
	</div>
	<div class="item">
		<span class="bg_l "></span><span class="bg_m ">
			<a href="<?php echo site_url('videos')?>" class="menu_item">
				<?php $menu_item = lang('Videos')?>
				<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
			</a>
		</span><span class="bg_r "></span>
	</div>
	<?php if($this->user->id > 0):?>
		<div class="item">
			<span class="bg_l "></span><span class="bg_m ">
				<a href="<?php echo site_url('add-credits')?>" class="menu_item">
					<?php $menu_item = lang('Order Credits')?>
					<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
				</a>
			</span><span class="bg_r "></span>
		</div>
		<div class="item">
			<span class="bg_l "></span><span class="bg_m ">
				<a href="<?php echo site_url('messenger')?>" class="menu_item">
					<?php $menu_item = lang('Messenger')?>
					<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
				</a>
			</span><span class="bg_r "></span>
		</div>
		<div class="item">
			<span class="bg_l "></span><span class="bg_m ">
				<a href="<?php echo site_url('account')?>" class="menu_item">
					<?php $menu_item = lang('My account')?>
					<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
				</a>
			</span><span class="bg_r "></span>
		</div>
	<?php endif;?>
	<div class="clear"></div>
</div>






//footer
<div id="footer" class="bold italic">
	<br/>
	<a href="<?php echo site_url(PREFORMERS_URL)?>"><?php echo lang('Performer\'s area')?></a>

	&nbsp;&nbsp;|&nbsp;&nbsp;

	<a href="<?php echo site_url(PREFORMERS_URL . '/register')?>" id="become_performer"><?php echo lang('$$Performers wanted$$')?></a>

	&nbsp;&nbsp;|&nbsp;&nbsp;

	<a href="<?php echo site_url('documents/policy')?>"><?php echo lang('Privacy policy')?></a>

	&nbsp;&nbsp;|&nbsp;&nbsp;

	<a href="<?php echo site_url('documents/tos')?>"><?php echo lang('Terms & conditions')?></a>

	&nbsp;&nbsp;|&nbsp;&nbsp;

	<a href="<?php echo site_url(STUDIOS_URL)?>"><?php echo lang('Studios')?></a>

	&nbsp;&nbsp;|&nbsp;&nbsp;

	<a href="<?php echo site_url(AFFILIATES_URL)?>"><?php echo lang('Affiliates')?></a>

	&nbsp;&nbsp;|&nbsp;&nbsp;

	<a href="<?php echo site_url('contact')?>"><?php echo lang('Contact us')?></a>

	<div id="langs">
		<span><?php echo lang('Choose your language:')?></span>
		<?php
			$langs_av = $this->config->item('lang_avail');
			foreach($langs_av as $row => $language):
		?>
			<a href="<?php echo site_url('language/'.$row)?>" title="<?php echo sprintf(lang('Change language to %s'),$language)?>"><img src="<?php echo assets_url()?>images/flags/<?php echo strtoupper($row)?>.png" alt="<?php echo $language?>" /></a>&nbsp;
		<?php endforeach?>
	</div>
	<?php echo sprintf(lang('ModenaCam - All rights reserved &copy; 2007 - %s'),date('Y'))?>
	<br/>
	<?php echo lang('This site contains sexually explicit material. Enter this site ONLY if You are over the age of 18!')?><br/>
	<a href="<?php echo site_url('documents/2257')?>"><?php echo lang('18 U.S.C 2257 Record-Keeping Requirements Compliance Statement ')?></a>
</div>





//performer register_step_1

<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $sign_up_step_1_title = lang('Signup step 1 - Personal Information') ?>
				<span class="eutemia"><?php echo substr($sign_up_step_1_title, 0, 1) ?></span><span class="helvetica"><?php echo substr($sign_up_step_1_title, 1) ?></span>
			</div>
			<?php echo form_open_multipart('register', 'class="register_performer"') ?>
			<div class="gray italic register_performer">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Username') ?>:</span></label>
					<?php echo form_input('username',set_value('username'))?>
					<span class="error message" htmlfor="username" generated="true" ><?php echo form_error('username')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Nickname') ?>:</span></label>
					<?php echo form_input('nickname',set_value('nickname'))?>
					<span class="error message" htmlfor="nickname" generated="true"><?php echo form_error('nickname')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Password') ?>:</span></label>
					<?php echo form_password('password',set_value('password'))?>
					<span class="error message" htmlfor="password" generated="true"><?php echo form_error('password')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Email') ?>:</span></label>
					<?php echo form_input('email',set_value('email'))?>
					<span class="error message" htmlfor="email" generated="true"><?php echo form_error('email')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('First name') ?>:</span></label>
					<?php echo form_input('firstname',set_value('firstname'))?>
					<span class="error message" htmlfor="firstname" generated="true"><?php echo form_error('firstname')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Last name') ?>:</span></label>
					<?php echo form_input('lastname',set_value('lastname'))?>
					<span class="error message" htmlfor="lastname" generated="true"><?php echo form_error('lastname')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Address') ?>:</span></label>
					<?php echo form_input('address',set_value('address'))?>
					<span class="error message" htmlfor="address" generated="true"><?php echo form_error('address')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('City') ?>:</span></label>
					<?php echo form_input('city',set_value('city'))?>
					<span class="error message" htmlfor="city" generated="true"><?php echo form_error('city')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Zip') ?>:</span></label>
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
				<div>
					<label><span class="gray italic bold"><?php echo lang('Country') ?>:</span></label>
					<?php echo form_dropdown('country', $countries, set_value('country'),'id="country"')?>
					<span class="error message" htmlfor="country" generated="true"><?php echo form_error('country')?></span>
				</div>
				<div id="state" style="display:none">
					<label><span class="gray italic bold"><?php echo lang('State') ?>:</span></label>
					<?php echo form_input('state',set_value('state'))?>
					<span class="error message" htmlfor="state" generated="true"><?php echo form_error('state')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Phone') ?>:</span></label>
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
						<span style="display: inline-block; width:300px;margin-left: 372px;" id="upload-contract" class="uploader">
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
						<label  style="vertical-align: top;"><span class="gray italic bold"><?php echo lang('Photo ID') ?>:</span></label>
						<a title="<?php echo lang('You can upload jpg/png/pdf/zip files')?>"><span id="upload-photo_id" style="display: inline-block; width:300px;" class="uploader"></span></a>
						<br/>
						<span style="display: inline-block; width:300px;margin-left: 372px;" id="upload-photo_id" class="uploader">
							<?php if($photo_id):?>
								<div class="qq-uploader">
									<?php foreach($photo_id as $key => $value):?>
										<ul class="qq-upload-list"><li class="qq-upload-success" key="<?php echo $key?>"><span class="qq-upload-file-loader" style="width: 100%;"></span><span class="qq-upload-file"><?php echo $value['name']?></span><span class="qq-upload-size" style="display: inline;"><?php echo $value['size']?></span><span class="qq-upload-failed-text"></span><span class="qq-upload-delete" onclick="delete_file(this)"></span></li></ul>
									<?php endforeach?>
								</div>
							<?php endif?>
						</span>
						<span class="error message" htmlfor="photo_id" generated="true" style="left: 586px; position: absolute; top: 0;"><?php echo form_error('photo_id')?></span>

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
									 $('#photos_id .qq-upload-button-error').html("<?php echo lang('You are allowed to upload max 2 files!') ?>");
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
			</div>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>