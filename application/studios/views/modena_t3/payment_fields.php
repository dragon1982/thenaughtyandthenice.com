<?php 
$fields = unserialize($payment_details->fields);
foreach ($fields as $field): ?>
	<div>
		<label><span class="gray italic bold"><?php echo lang($field)?></span></label>
		<?php // echo form_input(str_replace(' ' ,'_' , $field), set_value(str_replace(' ' ,'_' , $field)))?>
		<input type="text" value="<?php echo $this->input->post(str_replace(' ' ,'_' , $field))?>" name="<?php echo str_replace(' ' ,'_' , $field) ?>" onkeyup="javascript:validate_one();"/><span class="input_r"></span>
		<span class="error message" htmlfor="<?php echo str_replace(' ' ,'_' , $field) ?>" generated="true"><?php echo form_error(str_replace(' ' ,'_' , $field))?></span>
	</div>
<?php endforeach ?>
	<div>
		<label><span class="gray italic bold"><?php echo lang('Release Amount')?></span></label>
		<?php echo form_input('rls_amount',set_value('rls_amount'),'onkeyup="javascript:validate_one();"')?><span class="input_r"></span>
		<span class="error message" htmlfor="rls_amount" generated="true"><?php echo (form_error('rls_amount'))?form_error('rls_amount'):sprintf(lang('Minim %s'),print_amount_by_currency($payment_details->minim_amount,TRUE,TRUE))?></span>					
	</div>