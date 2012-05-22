<script type="text/javascript">
	jQuery(function($) {
		$(".iframe").fancybox({
			'scrolling'			: 'no',
			'transitionIn'		: 'fade',
			'transitionOut'		: 'fade',
			'type'				: 'iframe',
			'onClosed'			: function() { 
									parent.location.reload(true);						
								  }
		});
	});
</script>		
<div class="container">
				<div class="conthead">
					<?php $this->load->view('includes/studio_buttons')?>
				</div>

				<div class="contentbox">
					<div class="center_contentbox">
						
						<h2><?php echo lang('Account information')?></h2>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Username')?>: </label>
							<?php echo $studio->username?>
						</div>
						
						<!-- PERFORMER STATUS -->
						<div class="inputboxes">
							<label class="details"><?php echo lang('Studio status')?>: </label>
							<div class="profile_status"><img src="<?php echo assets_url('admin/images/icons/') . $studio->status ?>.png" alt="" title="<?php echo $studio->status ?>"/></div>
						</div>
						
						<!-- CONTRACT STATUS -->
						<div class="inputboxes">
							<label class="details"><?php echo lang('Contract status')?>: </label>
							<div class="profile_status"><img src="<?php echo assets_url('admin/images/icons/') . $studio->contract_status ?>.png" alt="" title="<?php echo $studio->contract_status ?>"/></div>
							<span><a class="iframe" href="<?php echo site_url('studios/contract_status/' . $studio->id) ?>"><?php echo lang('See all contracts')?></a></span>
						</div>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Register ip')?>: </label>
							<?php echo long2ip($studio->register_ip) ?>
						</div>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Register date')?>: </label>
							<?php echo date('r', $studio->register_date)?>
						</div>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Credits')?> (<?php echo SETTINGS_SHOWN_CURRENCY?>): </label>
							<?php echo print_amount_by_currency($studio->credits)?>
						</div>
						
						<br/>
						<h2><?php echo lang('Payment information')?></h2>
						<br/>
						
						<?php
						$account = @unserialize($studio->account);
						if( ! empty($account)):
							  foreach($account as $key => $value):?>
						<div class="inputboxes">
							<label class="details"><?php echo lang($key)?>: </label>
							<?php echo $value?>
						</div>
						<?php endforeach;
						else: ?>
						<div>
							<label class="not_set_msg"><?php echo lang('Payment method not set')?> </label>
						</div>
						<?php endif ?>
						<hr class="line_break">
						<?php echo form_open('studios/account/'.$studio->username)?>

							<!-- PASSWORD -->
							<div class="inputboxes">
								<label for="password"><?php echo lang('Password')?>: </label>
								<?php echo form_input('password', false, 'id="password" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- STATUS -->
							<div class="inputboxes">
								<label for="status"><?php echo lang('Status')?>: </label>
								<?php echo form_dropdown('status', $status,(isset($studio->status)) ? $studio->status : null, 'id="status" class="inputbox" tabindex="1" type="text" style="width:323px;"')?>
							</div>

							<!-- FIRST NAME -->
							<div class="inputboxes">
								<label for="first_name"><?php echo lang('First Name')?>: </label>
								<?php echo form_input('first_name', set_value('first_name', (isset($studio->first_name)) ? $studio->first_name : null), 'id="first_name" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- LAST NAME -->
							<div class="inputboxes">
								<label for="last_name"><?php echo lang('Last Name')?>: </label>
								<?php echo form_input('last_name', set_value('last_name', (isset($studio->last_name)) ? $studio->last_name : null), 'id="last_name" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- EMAIL -->
							<div class="inputboxes">
								<label for="email"><?php echo lang('Email')?>: </label>
								<?php echo form_input('email', set_value('email', (isset($studio->email)) ? $studio->email : null), 'id="email" class="inputbox" tabindex="1" type="text"')?>
							</div>
							
							<!-- PHONE -->
							<div class="inputboxes">
								<label for="percentage"><?php echo lang('Phone')?>: </label>
								<?php echo form_input('phone', set_value('phone', (isset($studio->phone)) ? $studio->phone : null), 'id="phone" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- ADDRESS -->
							<div class="inputboxes">
								<label for="address"><?php echo lang('Address')?>: </label>
								<?php echo form_input('address', set_value('address', (isset($studio->address)) ? $studio->address : null), 'id="address" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- CITY-->
							<div class="inputboxes">
								<label for="city"><?php echo lang('City')?>: </label>
								<?php echo form_input('city', set_value('city', (isset($studio->city)) ? $studio->city : null), 'id="city" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- ZIP -->
							<div class="inputboxes">
								<label for="zip"><?php echo lang('Zip')?>: </label>
								<?php echo form_input('zip', set_value('zip', (isset($studio->zip)) ? $studio->zip : null), 'id="zip" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- STATE-->
							<div class="inputboxes">
								<label for="state"><?php echo lang('State')?>: </label>
								<?php echo form_input('state', set_value('state', (isset($studio->state)) ? $studio->state : null), 'id="state" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- CONTRACT STATUS -->
							<div class="inputboxes">
								<label for="contract_status"><?php echo lang('Contract status')?>: </label>
								<?php echo form_dropdown('contract_status', $status,(isset($studio->contract_status)) ? $studio->contract_status : null, 'id="contract_status" class="inputbox" tabindex="1" type="text" style="width:323px;"')?>
								<span class="description"><a href="#"><?php echo lang('See all contracts')?></a></span>
							</div>

							<!-- STUDIO PERCENTAGE -->
							<div class="inputboxes">
								<label for="percentage"><?php echo lang('Percentage')?>: </label>
								<?php echo form_input('percentage', set_value('percentage', (isset($studio->percentage)) ? $studio->percentage : null), 'id="percentage" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Update studio')?>" />
						<?php echo form_close()?>
						
					<!-- ADD CREDITS FORM -->
							<? /*
							<br/><br/>
							<h2><?php echo lang('Add Credits')?> (<?php echo SETTINGS_SHOWN_CURRENCY?>)</h2>
							<br/>
						
							<?php echo form_open('studios/add_credits')?>											
							<?php echo form_hidden('id', $studio->id) ?>
						
							<div class="inputboxes">
								<label for="amount"><?php echo lang('Amount to Add/Remove')?>: </label>
								<?php echo form_input('amount', set_value('amount'), 'id="amount" class="inputbox" tabindex="1" type="text"')?>
							</div>
						
							<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Apply Changes')?>" />
						
							<?php echo form_close()?>
						
						<!--END ADD CREDITS FORM -->	
							 * 
							 */?>					
															
					</div>
				</div>
			</div>
