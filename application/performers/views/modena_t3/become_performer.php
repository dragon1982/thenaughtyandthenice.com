<script type="text/javascript">
var contract = <?php echo $contract?'true':'false'?>;
$(document).ready(function(){

	$.validator.setDefaults({
		validClass:"success",
		errorElement: "span",
		errorPlacement: function(error, element) {
			error.appendTo($(element).next('span').next('span'));
		}
	});	
	$.validator.addMethod("uniqueUserName", function(value,element) {
		return true;
	}, "<?php echo lang('Not Available!') ?>");

	$.validator.addMethod("checklang", function(value,element) {
        if ($("input[name^=lang] :checked"))
            return true;
        else
            return false;
	}, "<?php echo lang('Please select a language!') ?>");

	$.validator.addMethod("checkcat", function(value,element) {
		if ($("input[name^=category]"))
            return true;
        else
            return false;
	}, "<?php echo lang('Please select a category!') ?>");
	
	$(".register_performer").validate({
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
				required: true,
				minlength: 3,
				maxlength: 90
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
			wire_Bank_Name: {
				required: true,
				minlength: 3
			},
			wire_Account_Owner_Name: {
				required: true,
				minlength: 3
			},
			wire_IBAN: {
				required: true,
				minlength: 3
			},
			wire_SWIFT: {
				required: true,
				minlength: 3
			},
			wire_percentage: {
				required: true,
				maxlength: 100
			},
			category: {
				required: true,				
				minlength: 3,
				checkcat: true
			},	
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
				minlength: 3
			},
			what_turns_me_off: {
				required: true,
				minlength: 3
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
			build: {
				required: true,
				minlength: 1,
				maxlength: 90
			},
			lang: {
				required: true,
				minlength: 1,
				maxlength: 90,
				checklang: true
			},		
			day: {
				required: true,
				numeric: true,
				minlength: 2,
				maxlength: 4
			},
			month: {
				required: true,
				numeric: true,
				minlength: 2,
				maxlength: 4
			},
			year: {
				required: true,
				numeric: true,
				minlength: 2,
				maxlength: 4
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
			phone: 						"<?php echo lang('Please enter a valid phone') ?>",
			tos: 						"<?php echo lang('Please agree with the terms and conditions') ?>",
			wire_Bank_Name:				"<?php echo lang('Please enter a valid bank name') ?>",
			wire_Account_Owner_Name:	"<?php echo lang('Please enter a valid owner') ?>",
			wire_IBAN: 					"<?php echo lang('Please enter a valid IBAN') ?>",
			wire_SWIFT: 				"<?php echo lang('Please enter a valid SWIFT') ?>",
			category: 					"<?php echo lang('Please enter a valid category') ?>",
			gender: 					"<?php echo lang('Please enter a valid gender') ?>",
			description: 				"<?php echo lang('Please enter a valid description') ?>",
			what_turns_mo_on: 			"<?php echo lang('Please enter valid data in thsi field') ?>",
			what_turns_me_off: 			"<?php echo lang('Please enter valid data in thsi field') ?>",
			sexual_prefference: 		"<?php echo lang('Please enter a valid sexual preference') ?>",
			ethnicity: 					"<?php echo lang('Please enter a valid ethnicy') ?>",
			height: 					"<?php echo lang('Please enter a valid height') ?>",
			hair_color: 				"<?php echo lang('Please enter a hair color') ?>",
			hair_lenght: 				"<?php echo lang('Please enter a valid hair lenght') ?>",
			eye_color: 					"<?php echo lang('Please enter a valid eye color') ?>",
			build: 						"<?php echo lang('Please enter a valid build') ?>",
			lang: 						"<?php echo lang('Please enter a valid language') ?>",
			day: 						"<?php echo lang('Please enter a valid day') ?>",
			month: 						"<?php echo lang('Please enter a valid month') ?>",
			year: 						"<?php echo lang('Please enter a valid year') ?>"
		},
		debug: false 
	});
}); 
</script>
	
	<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $signup_step_1_title = lang('Signup step 1 - Personal Information')?>
				<span class="eutemia"><?php echo substr($signup_step_1_title,0,1)?></span><span class="helvetica"><?php echo substr($signup_step_1_title,1)?></span>
			</div>
			<?php echo form_open_multipart('register', 'class="register_performer"')?>
			<div class="gray italic register_performer">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Username') ?></span></label>
					<?php echo form_input('username',set_value('username'))?>
					<span class="error message" htmlfor="username" generated="true" ><?php echo form_error('username')?form_error('username'):lang('Username must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Nickname') ?></span></label>
					<?php echo form_input('nickname',set_value('nickname'))?>
					<span class="error message" htmlfor="nickname" generated="true"><?php echo form_error('nickname')?form_error('nickname'):lang('Nickname must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Password') ?></span></label>
					<?php echo form_password('password',set_value('password'))?>
					<span class="error message" htmlfor="password" generated="true"><?php echo form_error('password')?form_error('password'):lang('Password must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Email') ?></span></label>
					<?php echo form_input('email',set_value('email'))?>
					<span class="error message" htmlfor="email" generated="true"><?php echo form_error('email')?form_error('email'):lang('Email must be valid')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('First name') ?></span></label>
					<?php echo form_input('firstname',set_value('firstname'))?>
					<span class="error message" htmlfor="firstname" generated="true"><?php echo form_error('firstname')?form_error('firstname'):lang('First name must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Last name') ?></span></label>
					<?php echo form_input('lastname',set_value('lastname'))?>
					<span class="error message" htmlfor="lastname" generated="true"><?php echo form_error('lastname')?form_error('lastname'):lang('Lastname must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Address') ?></span></label>
					<?php echo form_input('address',set_value('address'))?>
					<span class="error message" htmlfor="address" generated="true"><?php echo form_error('address')?form_error('address'):lang('Addres must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('City') ?></span></label>
					<?php echo form_input('city',set_value('city'))?>
					<span class="error message" htmlfor="city" generated="true"><?php echo form_error('city')?form_error('city'):lang('City must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Zip') ?></span></label>
					<?php echo form_input('zip',set_value('zip'))?>
					<span class="error message" htmlfor="zip" generated="true"><?php echo form_error('zip')?form_error('zip'):lang('Zip must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('State') ?></span></label>
					<?php echo form_input('state',set_value('state'))?>
					<span class="error message" htmlfor="state" generated="true"><?php echo form_error('state')?form_error('state'):lang('State must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Country') ?></span></label>
					<?php echo form_input('country',set_value('country'))?>
					<span class="error message" htmlfor="country" generated="true"><?php echo form_error('country')?form_error('country'):lang('Country must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Phone') ?></span></label>
					<?php echo form_input('phone',set_value('phone'))?>
					<span class="error message" htmlfor="phone" generated="true"><?php echo form_error('phone')?form_error('phone'):lang('Phone must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Contract')?></span></label>
					<label>	
					    <script src="<?php echo assets_url()?>js/fileuploader.js" type="text/javascript"></script>
						<link href="<?php echo assets_url()?>css/fileuploader.css" rel="stylesheet" type="text/css">									    
						<div id="upload-contract"></div><span class="error message" htmlfor="contract_status" generated="true"><?php echo form_error('contract_status')?form_error('contract'):lang('Contract not added')?></span>						
				    </label>
				</div>				   							
			    <script type="text/javascript">
			        function createUploader(){            
			            var uploader = new qq.FileUploader({
			                element: document.getElementById('upload-contract'),
			                action: '/upload',
			                params: {
			                    type: 'contract'
			                },					                
	                        name: 'userfile[]',
	                        multiple: true,					                
			                allowedExtensions: [], 
			                onComplete: function(id, fileName, responseJSON){ 
								if(responseJSON.success){
									contract = true;
								}
				            },
			                onSubmit: function(id, fileName){},
			                onProgress: function(id, fileName, loaded, total){},
			                onCancel: function(id, fileName){},	
			                messages: {
			                	showMessage: function(message){  }	         
			                },
			                			                					                
			                debug: true
			            });           
			        }
			        window.onload = createUploader;     
			    </script>				    
				<div>
					<label><span class="gray italic bold"><?php echo lang('Payment') ?></span></label>
					<?php echo form_input('payment',set_value('payment'))?>
					<span class="error message" htmlfor="payment" generated="true"><?php echo form_error('payment')?form_error('payment'):lang('Payment must have at least 3 characters')?></span>
				</div>
				<div>
					<label></label>
					<?php echo form_checkbox('tos', 'tos',set_value('tos'))?><span class="gray italic bold" id="tos"><?php echo lang('Terms of Service')?></span>
					<span class="error message" htmlfor="tos" generated="true"><?php echo form_error('tos')?form_error('tos'):lang('You must agree to Terms of conditions')?></span>
				</div>
				<div class="back">
				<span><?php echo lang('Back') ?></span>
				</div>
				<div class="next">
				<span><?php echo lang('Next') ?></span>
				</div>
			</div>
		</div>
	</div>
			<div class="title">
				<?php $signup_step_2_title = lang('Signup step 2 - Payment')?>
				<span class="eutemia italic"><?php echo substr($signup_step_2_title,0,1)?></span><span class="helvetica italic"><?php echo substr($signup_step_2_title,1)?></span>
			</div>
		 	<div class="gray italic register_performer">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Bank Name') ?></span></label>
					<?php echo form_input('wire_Bank_Name',set_value('wire_Bank_Name'))?>
					<span class="error message" htmlfor="wire_Bank_Name" generated="true"><?php echo form_error('wire_Bank_Name')?form_error('wire_Bank_Name'):lang('Bacnk name must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Account Owner') ?></span></label>
					<?php echo form_input('wire_Account_Owner_Name',set_value('wire_Account_Owner_Name'))?>
					<span class="error message" htmlfor="wire_Account_Owner_Name" generated="true"><?php echo form_error('wire_Account_Owner_Name')?form_error('wire_Account_Owner_Name'):lang('Account must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('IBAN') ?></span></label>
					<?php echo form_input('wire_IBAN',set_value('wire_IBAN'))?>
					<span class="error message" htmlfor="wire_IBAN" generated="true"><?php echo form_error('wire_IBAN')?form_error('wire_IBAN'):lang('IBAN must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('SWIFT') ?></span></label>
					<?php echo form_input('wire_SWIFT',set_value('wire_SWIFT'))?>
					<span class="error message" htmlfor="wire_SWIFT" generated="true"><?php echo form_error('wire_SWIFT')?form_error('wire_SWIFT'):lang('SWIFT must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Percentage') ?></span></label>
					<?php echo form_input('wire_percentage',set_value('wire_percentage'))?>
					<span class="error message" htmlfor="wire_percentage" generated="true"><?php echo form_error('wire_percentage')?form_error('wire_percentage'):lang('Percaentage must be valid')?></span>
				</div>
				<div class="back">
				<span ><?php echo lang('Back')?></span>
				</div>
				<div class="next">
				<span><?php echo lang('Next')?></span>
				</div>
			</div>
			<div class="title">
				<?php $signup_step_3_title = lang('Signup step 3 - Select category')?>
				<span class="eutemia italic"><?php echo substr($signup_step_3_title,0,1)?></span><span class="helvetica italic"><?php echo substr($signup_step_3_title,1)?></span>
			</div>
		 	<div class="gray italic register_performer">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Categories') ?></span></label>
					<?php if(sizeof($cat['main_categories']) > 0):?>
						<ul style="list-style-type:none; ">
						<?php foreach($cat['main_categories'] as $main_category):?>
							<li>
								<?php echo form_checkbox('category['. $main_category->id . ']', $main_category->id,set_checkbox('category',$main_category->id))?>
								<span class="gray italic bold"><?php echo lang($main_category->name) ?></span>
							</li>
							<?php if(sizeof($cat['sub_categories']) > 0 && isset($cat['sub_categories'][$main_category->id]) && sizeof($cat['sub_categories'][$main_category->id]) > 0):?>
								<li>
									<ul style="list-style-type:none; ">
										<?php foreach($cat['sub_categories'][$main_category->id] as $sub_category):?>
											<li>
												<?php echo  form_checkbox('category[' . $sub_category->id .']', $sub_category->id,set_checkbox('category',$sub_category->id))?>
												<span class="gray italic bold"><?php echo lang($sub_category->name) ?></span>
											</li>
										<?php endforeach?>
									</ul>
								</li>
							<?php endif?>
						<?php endforeach?>
						</ul>
					<?php endif?>
					<span class="error message" htmlfor="category" generated="true"><?php echo form_error('category')?form_error('category'):lang('Category must be selected')?></span>
				</div>
				<div class="back">
				<span ><?php echo lang('Back') ?></span>
				</div>
				<div class="next">
				<span><?php echo lang('Next') ?></span>
				</div>
			</div>
			
			<div class="title">
				<?php $signup_step_4_title = lang('Signup step 4 - About Yourself')?>
				<span class="eutemia italic"><?php echo substr($signup_step_4_title,0,1)?></span><span class="helvetica italic"><?php echo substr($signup_step_4_title,1)?></span>
			</div>
		 	<div class="gray italic register_performer">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Gender') ?></span></label>
					<?php echo form_dropdown('gender',$gender,set_value('gender'))?>
					<span class="error message" htmlfor="gender" generated="true"><?php echo form_error('gender')?form_error('gender'):lang('Field must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold" id="performerTexAlign"><?php echo lang('Description') ?></span></label>
					<?php echo form_textarea('description',set_value('description'), 'rows="10" cols="90"')?>
					<span class="error message" htmlfor="description" generated="true"><?php echo form_error('description')?form_error('description'):lang('Description must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('What turns me on') ?></span></label>
					<?php echo form_textarea('what_turns_me_on',set_value('what_turns_me_on'), 'rows="10" cols="90"')?>
					<span class="error message" htmlfor="what_turns_me_on" generated="true"><?php echo form_error('what_turns_me_on')?form_error('what_turns_me_on'):lang('Field must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('What turns me off') ?></span></label>
					<?php echo form_textarea('what_turns_me_off',set_value('what_turns_me_off'), 'rows="10" cols="90"')?>
					<span class="error message" htmlfor="what_turns_me_off" generated="true"><?php echo form_error('what_turns_me_off')?form_error('what_turns_me_off'):lang('Field must have at least 3 characters')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Sexual prefference') ?></span></label>
					<?php echo form_dropdown('sexual_prefference',$sexual_prefference,set_value('sexual_prefference'))?>
					<span class="error message" htmlfor=sexual_prefference generated="true"><?php echo form_error('sexual_prefference')?form_error('sexual_prefference'):lang('Field must be valid')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Ethnicity') ?></span></label>
					<?php echo form_dropdown('ethnicity',$ethnicity,set_value('ethnicity'))?>
					<span class="error message" htmlfor="ethnicity" generated="true"><?php echo form_error('ethnicity')?form_error('ethnicity'):lang('Field must be valid')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Weight') ?></span></label>
					<?php echo form_dropdown('weight',$weight,set_value('weight'))?>
					<span class="error message" htmlfor="weight" generated="true"><?php echo form_error('weight')?form_error('weight'):lang('Field must be valid')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Height') ?></span></label>
					<?php echo form_dropdown('height',$height,set_value('height'))?>
					<span class="error message" htmlfor="height" generated="true"><?php echo form_error('height')?form_error('height'):lang('Field must be valid')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Hair color') ?></span></label>
					<?php echo form_dropdown('hair_color',$hair_color,set_value('hair_color'))?>
					<span class="error message" htmlfor="hair_color" generated="true"><?php echo form_error('hair_color')?form_error('hair_color'):lang('Field must be valid')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Hair lenght') ?></span></label>
					<?php echo form_dropdown('hair_length',$hair_length,set_value('hair_length'))?>
					<span class="error message" htmlfor="hair_length" generated="true"><?php echo form_error('hair_length')?form_error('hair_length'):lang('Field must be valid')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Eye color') ?></span></label>
					<?php echo form_dropdown('eye_color',$eye_color,set_value('eye_color'))?>
					<span class="error message" htmlfor="eye_color" generated="true"><?php echo form_error('eye_color')?form_error('eye_color'):lang('Field must be valid')?></span>
				</div>
				<div>
					<label><span class="grey italic bold"><?php echo lang('Languages') ?></span></label>
					<span style="display: inline-block;">
					<?php foreach($languages as $language):?>
						<span style="display: block; padding-top: 3px;"><?php echo form_checkbox("lang{$language->id}", $language->code, set_checkbox('lang', $language->code))?><span class="gray italic bold"><?php echo $language->title?></span></span>
					<?php endforeach?>
					</span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Build') ?></span></label>
					<?php echo form_dropdown('build',$build,set_value('build'))?>
					<span class="error message" htmlfor="build" generated="true"><?php echo form_error('build')?form_error('build'):lang('Field must be valid')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Birthday') ?></span></label>
					<?php echo form_dropdown('day',$days,set_value('day'), 'class="small"')?>
					<?php echo form_dropdown('month',$months,set_value('month'), 'class="small"')?>
					<?php echo form_dropdown('year',$years,set_value('year'), 'class="small"')?>
					<span class="error message" htmlfor="day" generated="true"><?php echo form_error('day')?form_error('day'):lang('Field must be valid')?></span>
					<span class="error message" htmlfor="month" generated="true"><?php echo form_error('month')?form_error('month'):lang('Field must be valid')?></span>
					<span class="error message" htmlfor="year" generated="true"><?php echo form_error('year')?form_error('year'):lang('Field must be valid')?></span>
				</div>
				<div class="back">
				<span >Back</span>
				</div>
				<div style="text-align: center; ">
				<input class="red" type="submit" value="<?php echo lang('Register') ?>">
				</div>
			</div>
			<?php echo form_close()?>
			
			<div class="clear"></div>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>	