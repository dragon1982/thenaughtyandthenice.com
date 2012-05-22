<div class="black_box_bg_middle"><div class="black_box_bg_top">	
	<div class="black_box" style="height: 100%;">
		<div class="content">
			<?if(isset($page_title) && $page_title != ''){
				$first_char = substr($page_title, 0, 1);
				$rest_of_text = substr($page_title, 1);
				?>
				<div class="title">
					<span class="eutemia "><?php echo strtoupper($first_char)?></span><span class="helvetica "><?php echo $rest_of_text?></span>
				</div>
			
			<?}?>			
			<div id="affiliate_settings">	
			<?php echo form_open('settings/personal_details')?>
			<div class="gray italic register_performer" style="margin: 0px auto;">
				
			
				
				<!--  FIRST NAME -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('First name')?>:</span></label>
					<?php echo form_input('first_name',set_value('first_name', $this->user->first_name))?>
					<span class="error message" htmlfor="first_name" generated="true"></span>
				</div>
				
				<!--  LAST NAME -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Last name')?>:</span></label>
					<?php echo form_input('last_name',set_value('last_name', $this->user->last_name))?>
					<span class="error message" htmlfor="last_name" generated="true"></span>
				</div>
				
				<!-- ADDRESS -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Address')?>:</span></label>
					<?php echo form_input('address',set_value('address', $this->user->address))?>
					<span class="error message" htmlfor="address" generated="true"></span>
				</div>
				
				<!-- CITY -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('City')?>:</span></label>
					<?php echo form_input('city',set_value('city', $this->user->city))?>
					<span class="error message" htmlfor="city" generated="true"></span>
				</div>
				
				<!-- ZIP -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Zip')?>:</span></label>
					<?php echo form_input('zip',set_value('zip', $this->user->zip))?>
					<span class="error message" htmlfor="zip" generated="true"></span>
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
				
				<!-- COUNTRY -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Country')?>:</span></label>
					<?php echo form_dropdown('country', $countries, set_value('country', $this->user->country_code),'id="country"')?>
					<span class="error message" htmlfor="country" generated="true"></span>
				</div>
				
				<!-- STATE -->
				<div id="state" style="display:none">
					<label><span class="gray italic bold"><?php echo lang('State')?>:</span></label>
					<?php echo form_input('state',set_value('state', $this->user->state))?>
					<span class="error message" htmlfor="state" generated="true"></span>
				</div>		
				
				
				<div>
					<label><span class="gray italic bold"><?php echo lang('Phone number')?>:</span></label>
					<?php echo form_input('phone',set_value('phone', $this->user->phone))?>
					<span class="error message" htmlfor="phone" generated="true"></span>
				</div>
				<div style="margin-top:8px; margin-left:223px;">
					<button class="red"  type="submit" style="width:206px;"> <?php echo lang('Update')?> </button><br/>
				</div>
			</div>
			<?php echo form_close()?>
			<div class="clear"></div>
		</div>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>