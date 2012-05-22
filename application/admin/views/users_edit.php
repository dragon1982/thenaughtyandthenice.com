			<div class="container">
				<div class="conthead">
					<?php $this->load->view('includes/user_buttons')?>
				</div>
				<div class="contentbox">
					<div class="center_contentbox">
						
						<h2><?php echo lang('Account information')?></h2>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Username')?>: </label>
							<?php echo $user->username?>
						</div>
						
						<!-- USER STATUS -->
						<div class="inputboxes">
							<label class="details"><?php echo lang('User status')?>: </label>
							<div class="profile_status"><img src="<?php echo assets_url('admin/images/icons/') . $user->status ?>.png" alt="" title="<?php echo $user->status ?>"/></div>
						</div>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Register ip')?>: </label>
							<?php echo long2ip($user->register_ip)?>
						</div>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Register date')?>: </label>
							<?php echo date('r', $user->register_date)?>
						</div>

						<div class="inputboxes">
						<label class="details"><?php echo lang('Credits')?> (<?php echo SETTINGS_SHOWN_CURRENCY?>): </label>
							<?php echo print_amount_by_currency($user->credits)?>
						</div>
												
						<hr class="line_break">
						
						<?php echo form_open('users/account/'.$user->username)?>

							<!-- PASSWORD -->
							<div class="inputboxes">
								<label for="password"><?php echo lang('Password')?>: </label>
								<?php echo form_input('password', false, 'id="password" class="inputbox" tabindex="1" type="text"')?>
							</div>
							
							<!-- GATEWAY -->
							<div class="inputboxes">
								<label for="gateway"><?php echo lang('Gateway')?>: </label>
								<?php echo form_input('gateway', set_value('gateway', (isset($user->gateway)) ?$user->gateway : null ), 'readonly="readonly" id="gateway" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- STATUS -->
							<div class="inputboxes">
								<label for="status"><?php echo lang('Status')?>: </label>
								<?php echo form_dropdown('status', $status,(isset($user->status)) ? $user->status : null, 'id="status" class="inputbox" tabindex="1" type="text" style="width:323px;"')?>
							</div>

							<!-- EMAIL -->
							<div class="inputboxes">
								<label for="email"><?php echo lang('Email')?>: </label>
								<?php echo form_input('email', set_value('email', (isset($user->email)) ? $user->email : null), 'id="email" class="inputbox" tabindex="1" type="text"')?>
							</div>
							
							<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Update user')?>" />
							<?php echo form_close()?>
							
							<!-- ADD CREDITS FORM -->
							
							<br/><br/>
							<h2><?php echo lang('Add Credits')?> (<?php echo SETTINGS_SHOWN_CURRENCY?>)</h2>
							<br/>
						
							<?php echo form_open('users/add_credits')?>
												
							<?php echo form_hidden('id', $user->id) ?>
						
							<div class="inputboxes">
								<label for="amount"><?php echo lang('Amount to Add/Remove')?>: </label>
								<?php echo form_input('amount', set_value('amount'), 'id="amount" class="inputbox" tabindex="1" type="text"')?>
							</div>
						
							<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Apply Changes')?>" />
						
							<?php echo form_close()?>
						
							<!--END ADD CREDITS FORM -->
								
					</div>
				</div>
			</div>
