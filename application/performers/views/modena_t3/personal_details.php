<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $performer_personal_details_title = lang('Performer\'s Personal Details Page')?>
			<span class="eutemia"><?php echo substr($performer_personal_details_title, 0, 1)?></span><span class="helvetica"><?php echo substr($performer_personal_details_title, 1)?></span>
		</div>
		<div id="profile">
			<div class="left" style="text-align: center;">
				<div class="red_h_sep"></div>
					<?php echo form_open('')?>
					<div class="gray italic register_performer">
						<div>
							<label><span class="gray italic bold"><?php echo lang('First name') ?>:</span></label>
							<?php echo form_input('firstname',set_value('firstname', $performer->first_name))?>
							<span class="error message" htmlfor="firstname" generated="true"><?php echo form_error('firstname')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Last name') ?>:</span></label>
							<?php echo form_input('lastname',set_value('lastname', $performer->last_name))?>
							<span class="error message" htmlfor="lastname" generated="true"><?php echo form_error('lastname')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Phone') ?>:</span></label>
							<?php echo form_input('phone',set_value('phone', $performer->phone))?>
							<span class="error message" htmlfor="phone" generated="true"><?php echo form_error('phone')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Address') ?>:</span></label>
							<?php echo form_input('address',set_value('address', $performer->address))?>
							<span class="error message" htmlfor="address" generated="true"><?php echo form_error('address')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('City') ?>:</span></label>
							<?php echo form_input('city',set_value('city', $performer->city))?>
							<span class="error message" htmlfor="city" generated="true"><?php echo form_error('city')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Zip') ?>:</span></label>
							<?php echo form_input('zip',set_value('zip', $performer->zip))?>
							<span class="error message" htmlfor="zip" generated="true"><?php echo form_error('zip')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Country') ?>:</span></label>
							<?php echo form_dropdown('country',$countries, set_value('country', $performer->country),'id="country"')?>
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
							<label><span class="gray italic bold"><?php echo lang('State') ?>:</span></label>
							<?php echo form_input('state',set_value('state', $performer->state))?>
							<span class="error message" htmlfor="state" generated="true"><?php echo form_error('state')?></span>
						</div>						
						<div>
							<label style="vertical-align:top; float: left;"><span class="grey italic bold"><?php echo lang('Languages') ?>:</span></label>
							<span style="display: inline-block;">							
							<?php foreach($languages as $language):?>
								<span style="display: block; padding-top: 3px;"><label style="text-align:left"><?php echo form_checkbox('languages[]', $language->code, set_checkbox('languages', $language->code, (in_array($language->code,$performers_languages)?TRUE:FALSE)))?><span class="gray italic bold"><?php echo ucfirst($language->title)?></span></label></span>
							<?php endforeach?>
							</span>
							<span class="error message" htmlfor="languages" generated="true" style="vertical-align:top"><?php echo form_error('languages')?></span>
							
						</div>
						<div>
							<label></label>
							<?php echo form_submit('submit', lang('Save'), 'class="red"')?>
						</div>
					<?php echo form_close()?>
					</div>
				<div class="red_h_sep"></div>
				<div class="white_h_sep"></div>
								
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>