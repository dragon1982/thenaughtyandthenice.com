			<div class="container">
				<div class="conthead">
					<?php $this->load->view('includes/affiliate_buttons')?>
				</div>

				<div class="contentbox">
					<div class="center_contentbox">
						
						<h2><?php echo lang('Account information')?></h2>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Username')?>: </label>
							<img src="<?php echo assets_url('admin/images/' . (($affiliate->country_code != '')? 'flags/'.$affiliate->country_code : 'icons/na') . '.png') ?>" /> <?php echo $affiliate->username?>
						</div>
						
						<!-- PERFORMER STATUS -->
						<div class="inputboxes">
							<label class="details"><?php echo lang('Affiliate status')?>: </label>
							<div class="profile_status"><img src="<?php echo assets_url('admin/images/icons/') . $affiliate->status ?>.png" alt="" title="<?php echo $affiliate->status ?>"/></div>
						</div>
						
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Register ip')?>: </label>
							<?php echo long2ip($affiliate->register_ip) ?>
						</div>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Percentage')?>: </label>
							<?php echo $affiliate->percentage ?>%
						</div>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Register date')?>: </label>
							<?php echo date('r', $affiliate->register_date)?>
						</div>
						
						
						
						<br/>
						<h2><?php echo lang('Payment information')?></h2>
						<br/>
						
						<?php
						$account = @unserialize($affiliate->account);
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
						<?php echo form_open('affiliates/account/'.$affiliate->username)?>
						
						
						
							<!-- SITE NAME -->
							<div class="inputboxes">
								<label for="site_name"><?php echo lang('Site name')?>: </label>
								<?php echo form_input('site_name', set_value('site_name', (isset($affiliate->site_name)) ? $affiliate->site_name : null), 'id="site_name" class="inputbox" tabindex="1" type="text"')?>
							</div>
							
							<!-- SITE URL -->
							<div class="inputboxes">
								<label for="site_url"><?php echo lang('Site url')?>: </label>
								<?php echo form_input('site_url', set_value('site_url', (isset($affiliate->site_url)) ? $affiliate->site_url : null), 'id="site_url" class="inputbox" tabindex="1" type="text"')?>
							</div>
							
						
							
							<!-- PASSWORD -->
							<div class="inputboxes">
								<label for="password"><?php echo lang('Password')?>: </label>
								<?php echo form_input('password', false, 'id="password" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- STATUS -->
							<div class="inputboxes">
								<label for="status"><?php echo lang('Status')?>: </label>
								<?php echo form_dropdown('status', $status,(isset($affiliate->status)) ? $affiliate->status : null, 'id="status" class="inputbox" tabindex="1" type="text" style="width:323px;"')?>
							</div>

							<!-- FIRST NAME -->
							<div class="inputboxes">
								<label for="first_name"><?php echo lang('First Name')?>: </label>
								<?php echo form_input('first_name', set_value('first_name', (isset($affiliate->first_name)) ? $affiliate->first_name : null), 'id="first_name" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- LAST NAME -->
							<div class="inputboxes">
								<label for="last_name"><?php echo lang('Last Name')?>: </label>
								<?php echo form_input('last_name', set_value('last_name', (isset($affiliate->last_name)) ? $affiliate->last_name : null), 'id="last_name" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- EMAIL -->
							<div class="inputboxes">
								<label for="email"><?php echo lang('Email')?>: </label>
								<?php echo form_input('email', set_value('email', (isset($affiliate->email)) ? $affiliate->email : null), 'id="email" class="inputbox" tabindex="1" type="text"')?>
							</div>
							
							<!-- PHONE -->
							<div class="inputboxes">
								<label for="percentage"><?php echo lang('Phone')?>: </label>
								<?php echo form_input('phone', set_value('phone', (isset($affiliate->phone)) ? $affiliate->phone : null), 'id="phone" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- ADDRESS -->
							<div class="inputboxes">
								<label for="address"><?php echo lang('Address')?>: </label>
								<?php echo form_input('address', set_value('address', (isset($affiliate->address)) ? $affiliate->address : null), 'id="address" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- CITY-->
							<div class="inputboxes">
								<label for="city"><?php echo lang('City')?>: </label>
								<?php echo form_input('city', set_value('city', (isset($affiliate->city)) ? $affiliate->city : null), 'id="city" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- ZIP -->
							<div class="inputboxes">
								<label for="zip"><?php echo lang('Zip')?>: </label>
								<?php echo form_input('zip', set_value('zip', (isset($affiliate->zip)) ? $affiliate->zip : null), 'id="zip" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- STATE-->
							<div class="inputboxes">
								<label for="state"><?php echo lang('State')?>: </label>
								<?php echo form_input('state', set_value('state', (isset($affiliate->state)) ? $affiliate->state : null), 'id="state" class="inputbox" tabindex="1" type="text"')?>
							</div>

							

							<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Update account')?>" />
						<?php echo form_close()?>
															
					</div>
				</div>
			</div>
