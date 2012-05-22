<div style="padding-top: 10px; font-weight: bold;background-color:#D6D6D6; cursor: wait;">
<?php echo sprintf(lang('Are you sure you want to pay %s to watch this video?'),print_amount_by_currency($video->price))?>
<?php echo form_open(NULL)?>
	<?php echo form_hidden('agree',1)?>
	<?php echo form_submit('YES',lang('YES'),'class="confirm_yes"')?>
	<input type="button" name="No" value="" onclick="$.unblockUI();" class="confirm_no" />	
<?php echo form_close()?>
</div>