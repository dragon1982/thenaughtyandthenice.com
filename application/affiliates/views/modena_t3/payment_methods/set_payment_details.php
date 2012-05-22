<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content" style="margin-left:50px;">
		<div class="red_h_sep"></div>
		<div class="title">
			<?php $enter_payment_title = lang('Enter Payment Details')?>
			<span class="eutemia "><?php echo substr($enter_payment_title,0,1)?></span><span class="helvetica "><?php echo substr($enter_payment_title,1)?></span>
		</div>	
		<div id="affiliate_settings">	
		<?php echo form_open('settings/set-payment-details/' . $this->uri->segment(3), 'class="set_payment_details"')?>
			<div class="gray italic payment_details">
			<?php 
			$fields = unserialize($payment_details->fields);
			
			foreach ($fields as $field): ?>
				<div>
					<label><span class="gray italic bold" id="performerTexAlign"><?php echo $field?>:</span></label>
					<?php echo form_input(str_replace(' ' ,'_' , $field), set_value(str_replace(' ' ,'_' , $field)))?><span class="input_r"></span>
					<span class="error message" htmlfor="<?php echo str_replace(' ' ,'_' , $field) ?>" generated="true"><?php echo form_error(str_replace(' ' ,'_' , $field))?></span>
				</div>
			<?php endforeach ?>	
				<div>
					<label><span class="gray italic bold"><?php echo lang('Release Amount')?></span></label>
					<input type="text" value="<?php echo $this->input->post('rls_amount')?>" name="rls_amount"/><span class="input_r"></span>
					<span class="error message" htmlfor="rls_amount" generated="true"><?php echo (form_error('rls_amount'))?form_error('rls_amount'):sprintf(lang('Minim %s'),print_amount_by_currency($payment_details->minim_amount,TRUE,TRUE))?></span>																				
				</div>
				<div style="margin-top:8px; margin-left:223px;">
					<button class="red"  type="submit" style="width:206px;"> <?php echo lang('Update')?> </button><br/>
				</div>
			</div>
		<?php echo form_close()?>
		</div>
		<br/>
		<div class="clear"></div>
		<div class="red_h_sep"></div>
		<div class="white_h_sep"></div>
		
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>