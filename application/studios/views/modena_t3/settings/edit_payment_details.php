<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content" style="margin-left:50px;">
		<div class="red_h_sep"></div>
		<div class="title">
			<?php $edit_payment_title = lang('Edit Payment Details')?>
			<span class="eutemia"><?php echo substr($edit_payment_title,0,1)?></span><span class="helvetica"><?php echo substr($edit_payment_title,1)?></span>
		</div>	
		<?php echo form_open('settings/edit-payment-details' , 'class="set_payment_details"')?>
			<div class="gray italic payment_details"  id="studio_settings">
			<?php 
			$fields = unserialize($payment_details->fields);
			$perfomer_account = unserialize($this->user->account);
			foreach ($fields as $field): ?>
				<div>
					<label><span class="gray italic bold" id="performerTexAlign"><?php echo lang($field)?>:</span></label>
					<?php echo form_input(str_replace(' ' ,'_' , $field), set_value(str_replace(' ' ,'_' , $field), $perfomer_account[$field]))?>
					<span class="error" htmlfor="<?php echo str_replace(' ' ,'_' , $field) ?>" generated="true"><?php echo form_error(str_replace(' ' ,'_' , $field))?></span>
				</div>
			<?php endforeach ?>
			<div>
				<label><span class="gray italic bold"><?php echo lang('Release Amount')?>:</span></label>
				<?php echo form_input('rls_amount', set_value('rls_amount', $this->user->release))?>
				<span class="error message" htmlfor="rls_amount" generated="true"><?php echo (form_error('rls_amount'))?form_error('rls_amount'):sprintf(lang('Minim %s'),print_amount_by_currency($payment_details->minim_amount,TRUE,TRUE))?></span>					
			</div>	
			<br/>
			<label></label><?php echo form_submit('submit',lang('Save'), 'class="red payment_submit"  style="width:206px;"')?>
			</div>
		<?php echo form_close()?>
		<br/>
		<div class="clear"></div>
		<div class="red_h_sep"></div>
		<div class="white_h_sep"></div>
		
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>