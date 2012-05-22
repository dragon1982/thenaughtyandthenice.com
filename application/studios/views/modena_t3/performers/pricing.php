<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $performer_pricing_title = lang('Performer\s Pricing Page')?>
			<span class="eutemia "><?php echo substr($performer_pricing_title,0,1)?></span><span class="helvetica "><?php echo substr($performer_pricing_title,1)?></span>
		</div>
		<div id="profile">
			<div class="left" style="text-align: center;">
				<div class="red_h_sep"></div>
					<?php echo form_open()?>
					<div class="gray italic register_performer">
						<div>
							<label><span class="gray italic bold"><?php echo sprintf(lang('True private chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?>:</span></label>
							<?php echo form_input('true_private_chips_price',set_value('true_private_chips_price', $true_private_chips_price))?>
							<span class="error message" htmlfor="private_chips_price" generated="true"><?php echo form_error('true_private_chips_price')?form_error('true_private_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_PRIVATE_CHIPS_PRICE,MAX_PRIVATE_CHIPS_PRICE))?></span>
						</div>						
						<div>
							<label><span class="gray italic bold"><?php echo sprintf(lang('Private chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?>:</span></label>
							<?php echo form_input('private_chips_price',set_value('private_chips_price', $private_chips_price))?>
							<span class="error message" htmlfor="private_chips_price" generated="true"><?php echo form_error('private_chips_price')?form_error('private_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_PRIVATE_CHIPS_PRICE,MAX_PRIVATE_CHIPS_PRICE))?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo sprintf(lang('Peek chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?>:</span></label>
							<?php echo form_input('peek_chips_price',set_value('peek_chips_price', $peek_chips_price))?>
							<span class="error message" htmlfor="peek_chips_price" generated="true"><?php echo form_error('peek_chips_price')?form_error('peek_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_PEEK_CHIPS_PRICE,MAX_PEEK_CHIPS_PRICE))?></span>
						</div>						
						<div>
							<label><span class="gray italic bold"><?php echo sprintf(lang('Nude chat %s/minute'), SETTINGS_SHOWN_CURRENCY); ?>:</span></label>
							<?php echo form_input('nude_chips_price',set_value('nude_chips_price',$nude_chips_price))?>
							<span class="error message" htmlfor="nude_chips_price" generated="true"><?php echo form_error('nude_chips_price')?form_error('nude_chips_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_NUDE_CHIPS_PRICE,MAX_NUDE_CHIPS_PRICE))?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Paid photo gallery price') ?>:</span></label>
							<?php echo form_input('paid_photo_gallery_price',set_value('paid_photo_gallery_price',$paid_photo_gallery_price))?>
							<span class="error message" htmlfor="paid_photo_gallery_price" generated="true"><?php echo form_error('paid_photo_gallery_price')?form_error('paid_photo_gallery_price'):($this->input->post()?NULL:sprintf(lang('Must be between %s as %s'),MIN_PHOTOS_CHIPS_PRICE,MAX_PHOTOS_CHIPS_PRICE))?></span>
						</div>	
						<div style="text-align: left; margin-left:223px;">
							<?php echo form_submit('submit', lang('Save'), 'class="red" style="width:206px;"')?>
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