<div style="padding-top: 10px; font-weight: bold;background-color:#D6D6D6; cursor: wait;">
	<?php echo sprintf(lang('Are you sure you want to pay %s to have access at %s private photo gallery?'),print_amount_by_currency($performer->paid_photo_gallery_price),$performer->nickname)?>	
	<?php echo form_open()?>
		<?php echo form_hidden('leave_me_alone',1)?>
		<?php echo form_submit('YES',lang('YES'),'class="confirm_yes"')?>
		<?php echo form_button('NO',lang('NO'),'onclick="$.unblockUI();" class="confirm_no"')?>
	<?php echo form_close()?>
</div>