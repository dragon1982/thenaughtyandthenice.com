<script type="text/javascript">
	$('.conthead').ready(function() {
		$(".iframe").fancybox({
			'scrolling'			: 'no',
			'transitionIn'		: 'fade',
			'transitionOut'		: 'fade',
			'type'				: 'iframe',
			'onClosed'			: function() { 
									if(parent.document.getElementById('observer').innerHTML == '1') {
										parent.location.reload(true);
									}
								  }
		});
	});
</script>
			<div class="container">
				<div class="conthead">
				<?php $this->load->view('includes/edit_buttons')?>
				</div>
				<div id="observer">0</div>
				<div class="contentbox">
					<div class="center_contentbox">
						
						<h2><?php echo lang('Account information')?></h2>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Username')?>: </label>
							<?php echo $performer->username?>
						</div>
						
						<!-- PERFORMER STATUS -->
						<div class="inputboxes">
							<label class="details"><?php echo lang('Performer overall status')?>: </label>
							<div class="profile_status"><img src="<?php echo assets_url('admin/images/icons/') . $performer->status ?>.png" alt="" title="<?php echo $performer->status ?>"/></div>
						</div>
						
						<!-- CONTRACT STATUS -->
						<div class="inputboxes">
							<label class="details"><?php echo lang('Contract status')?>: </label>
							<div class="profile_status"><img src="<?php echo assets_url('admin/images/icons/') . $performer->contract_status ?>.png" alt="" title="<?php echo $performer->contract_status ?>"/></div>
							<span><a class="iframe" href="<?php echo site_url('performers/contract_status/' . $performer->id) ?>"><?php echo lang('See all contracts')?></a></span>
						</div>

						<!-- PHOTO ID STATUS -->
						<div class="inputboxes">
							<label class="details"><?php echo lang(' Photo ID status')?>: </label>
							<div class="profile_status"><img src="<?php echo assets_url('admin/images/icons/') . $performer->photo_id_status ?>.png" alt="" title="<?php echo $performer->photo_id_status ?>"/></div>
							<span><a class="iframe" href="<?php echo site_url('performers/photo_status/' . $performer->id) ?>"><?php echo lang('See all photo id pictures')?></a></span>
						</div>

						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Register ip')?>: </label>
							<?php echo long2ip($performer->register_ip) ?>
						</div>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Register date')?>: </label>
							<?php echo date('r', $performer->register_date)?>
						</div>
												
						<div class="inputboxes">
							<label class="details"><?php echo lang('Online type')?>: </label>
							<?php echo ($performer->is_online_type)?$performer->is_online_type:'n/a'?>
						</div>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('In private')?>: </label>
							<?php echo ($performer->is_in_private == 1)?lang('Yes'):lang('No')?>
						</div>
						
						<div class="inputboxes">
							<label class="details"><?php echo lang('Credits')?> (<?php echo SETTINGS_SHOWN_CURRENCY?>): </label>
							<?php echo print_amount_by_currency($performer->credits)?>
						</div>
						
						<br/>
						<h2><?php echo lang('Payment information')?></h2>
						<br/>
						
						<?php
						$account = @unserialize($performer->account);
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
						
						<?php echo form_open('performers/account/'.$performer->username)?>

							<!-- PASSWORD -->
							<div class="inputboxes">
								<label for="password"><?php echo lang('Password')?>: </label>
								<?php echo form_input('password', false, 'id="password" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- NICKNAME -->
							<div class="inputboxes">
								<label for="nickname"><?php echo lang('Nickname')?>: </label>
								<?php echo form_input('nickname', set_value('nickname', (isset($performer->nickname)) ? $performer->nickname : null), 'id="nickname" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- FIRST NAME -->
							<div class="inputboxes">
								<label for="first_name"><?php echo lang('First Name')?>: </label>
								<?php echo form_input('first_name', set_value('first_name', (isset($performer->first_name)) ? $performer->first_name : null), 'id="first_name" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- LAST NAME -->
							<div class="inputboxes">
								<label for="last_name"><?php echo lang('Last Name')?>: </label>
								<?php echo form_input('last_name', set_value('last_name', (isset($performer->last_name)) ? $performer->last_name : null), 'id="last_name" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- EMAIL -->
							<div class="inputboxes">
								<label for="email"><?php echo lang('Email')?>: </label>
								<?php echo form_input('email', set_value('email', (isset($performer->email)) ? $performer->email : null), 'id="email" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- COUNTRY-->
							<div class="inputboxes">
								<label for="state"><?php echo lang('Status')?>: </label>
								<?php echo form_dropdown('status', $status, set_value('status', $performer->status), 'id="status" class="inputbox" tabindex="1" type="text" style="width:323px;"')?>
							</div>
							
							<!-- PHONE -->
							<div class="inputboxes">
								<label for="percentage"><?php echo lang('Phone')?>: </label>
								<?php echo form_input('phone', set_value('phone', (isset($performer->phone)) ? $performer->phone : null), 'id="phone" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- ADDRESS -->
							<div class="inputboxes">
								<label for="address"><?php echo lang('Address')?>: </label>
								<?php echo form_input('address', set_value('address', (isset($performer->address)) ? $performer->address : null), 'id="address" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- CITY-->
							<div class="inputboxes">
								<label for="city"><?php echo lang('City')?>: </label>
								<?php echo form_input('city', set_value('city', (isset($performer->city)) ? $performer->city : null), 'id="city" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- ZIP -->
							<div class="inputboxes">
								<label for="zip"><?php echo lang('Zip')?>: </label>
								<?php echo form_input('zip', set_value('zip', (isset($performer->zip)) ? $performer->zip : null), 'id="zip" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- STATE-->
							<div class="inputboxes">
								<label for="state"><?php echo lang('State')?>: </label>
								<?php echo form_input('state', set_value('state', (isset($performer->state)) ? $performer->state : null), 'id="state" class="inputbox" tabindex="1" type="text"')?>
							</div>
							
							<!-- COUNTRY-->
							<div class="inputboxes">
								<label for="state"><?php echo lang('Country')?>: </label>
								<?php echo form_dropdown('country', $countries, set_value('country', (isset($performer->country)) ? $performer->country : null), 'id="country" class="inputbox" tabindex="1" type="text" style="width:323px;"')?>
							</div>

							<!-- IS ONLINE -->
							<div class="inputboxes">
								<label for="is_online"><?php echo lang('Is Online')?>: </label>
								<label for="is_online_yes"><?php echo form_radio('is_online',1,  (isset($performer->is_online)) ? $performer->is_online : null, 'id="is_online_yes" disabled="disabled" class="inputbox" tabindex="1" type="text" style="width:50px; min-width:50px; margin-top:0px;"')?> Yes</label>
								<label for="is_online_no"><?php echo form_radio('is_online',0,   (isset($performer->is_online)) ? !$performer->is_online : null, 'id="is_online_no" class="inputbox" tabindex="1" type="text" style="width:50px; min-width:50px; margin-top:0px;"')?> No</label>
							</div>

							<!-- IS ONLINE HD -->
							<div class="inputboxes">
								<label for="is_online_hd"><?php echo lang('Is Online HD')?>: </label>
								<label for="is_online_hd_yes"><?php echo form_radio('is_online_hd',1,  (isset($performer->is_online_hd)) ? $performer->is_online_hd : null, 'id="is_online_hd_yes" class="inputbox" tabindex="1" type="text" style="width:50px; min-width:50px; margin-top:0px;"')?> Yes</label>
								<label for="is_online_hd_no"><?php echo form_radio('is_online_hd',0,  (isset($performer->is_online_hd)) ? !$performer->is_online_hd : null, 'id="is_online_hd_no" class="inputbox" tabindex="1" type="text" style="width:50px; min-width:50px; margin-top:0px;"')?> No</label>
							</div>

							<!-- MAXIMUM NUDE WATCHERS -->
							<div class="inputboxes">
								<label for="max_nude_watchers"><?php echo lang('Maximum nude watchers')?>: </label>
								<?php echo form_input('max_nude_watchers', set_value('max_nude_watchers', (isset($performer->max_nude_watchers)) ? $performer->max_nude_watchers : null), 'id="max_nude_watchers" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- IS IMPORTED CATEGORY ID -->
<!--							<div class="inputboxes">
								<label for="is_imported_category_id"><?php echo lang('Is imported category id')?>: </label>
								<?php echo form_input('is_imported_category_id', set_value('is_imported_category_id', (isset($performer->is_imported_category_id)) ? $performer->is_imported_category_id : null), 'id="is_imported_category_id" class="inputbox" tabindex="1" type="text"')?>
							</div>-->

							<!-- PRIVATE CHIPS PRICE -->
							<div class="inputboxes">
								<label for="private_chips_price"><?php echo lang('True Private chips price')?>: </label>
								<?php echo form_input('true_private_chips_price', set_value('true_private_chips_price', (isset($performer->true_private_chips_price)) ? $performer->true_private_chips_price : null), 'id="true_private_chips_price" class="inputbox" tabindex="1" type="text"')?>
							</div>
							
							<!-- PRIVATE CHIPS PRICE -->
							<div class="inputboxes">
								<label for="private_chips_price"><?php echo lang('Private chips price')?>: </label>
								<?php echo form_input('private_chips_price', set_value('private_chips_price', (isset($performer->private_chips_price)) ? $performer->private_chips_price : null), 'id="private_chips_price" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- NUDE CHIPS PRICE -->
							<div class="inputboxes">
								<label for="nude_chips_price"><?php echo lang('Nude chips price')?>: </label>
								<?php echo form_input('nude_chips_price', set_value('nude_chips_price', (isset($performer->nude_chips_price)) ? $performer->nude_chips_price : null), 'id="nude_chips_price" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- PEEK CHIPS PRICE -->
							<div class="inputboxes">
								<label for="peek_chips_price"><?php echo lang('Peek chips price')?>: </label>
								<?php echo form_input('peek_chips_price', set_value('peek_chips_price', (isset($performer->peek_chips_price)) ? $performer->peek_chips_price : null), 'id="peek_chips_price" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- PEEK CHIPS PRICE -->
							<div class="inputboxes">
								<label for="paid_photo_gallery_price"><?php echo lang('Paid photo gallery price')?>: </label>
								<?php echo form_input('paid_photo_gallery_price', set_value('paid_photo_gallery_price', (isset($performer->paid_photo_gallery_price)) ? $performer->paid_photo_gallery_price : null), 'id="paid_photo_gallery_price" class="inputbox" tabindex="1" type="text"')?>
							</div>
							
							<!-- WEBSITE PERCENTAGE -->
							<div class="inputboxes">
								<label for="website_percentage"><?php echo lang('Website percentage')?>: </label>
								<?php echo form_input('website_percentage', set_value('website_percentage', (isset($performer->website_percentage)) ? $performer->website_percentage : null), 'id="website_percentage" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Update performer')?>" />
						<?php echo form_close()?>
						
						<!-- ADD CREDITS FORM -->
							
							<br/><br/>
							<h2><?php echo lang('Add Credits')?> (<?php echo SETTINGS_SHOWN_CURRENCY?>)</h2>
							<br/>
						
							<?php echo form_open('performers/add_credits')?>											
							<?php echo form_hidden('id', $performer->id) ?>
						
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
