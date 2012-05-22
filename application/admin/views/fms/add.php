<div class="container">
	<div class="conthead">
		<h2><?php echo lang('Add fms')?></h2>
	</div>
	<div class="contentbox">		
		<?php echo form_open()?>
			<div class="inputboxes">
				<label for="name"><?php echo lang('Name')?>: </label>
				<?php echo form_input('name', set_value('name'), 'id="name" class="inputbox" tabindex="1" type="text"')?>
			</div>
			<div class="inputboxes">
				<label for="name"><?php echo lang('Max hosted performers')?>: </label>
				<?php echo form_input('max_hosted_performers', set_value('max_hosted_performers') , 'id="max_hosted_performers" class="inputbox" tabindex="1" type="text"')?>
			</div>
			<div class="inputboxes">
				<label for="name"><?php echo lang('Status')?>: </label>
				<?php echo form_dropdown('status', $status,set_value('name'), 'id="status" class="inputbox" tabindex="1" type="text"')?>
			</div>
			<div class="inputboxes">
				<label for="name"><?php echo lang('FMS')?>: </label>
				<?php echo form_input('fms', set_value('fms'), 'id="fms" class="inputbox" tabindex="1" type="text"')?>
			</div>
			<div class="inputboxes">
				<label for="name"><?php echo lang('FMS for Video')?>: </label>
				<?php echo form_input('fms_for_video', set_value('fms_for_video'), 'id="fms_for_video" class="inputbox" tabindex="1" type="text"')?>
			</div>
			<div class="inputboxes">
				<label for="name"><?php echo lang('FMS for Preview')?>: </label>
				<?php echo form_input('fms_for_preview', set_value('fms_for_preview'), 'id="fms_for_preview" class="inputbox" tabindex="1" type="text"')?>
			</div>
			<div class="inputboxes">
				<label for="name"><?php echo lang('FMS for Delete')?>: </label>
				<?php echo form_input('fms_for_delete', set_value('fms_for_delete'), 'id="fms_for_delete" class="inputbox" tabindex="1" type="text"')?>
			</div>			
			<div class="inputboxes">
				<label for="name"><?php echo lang('FMS Test')?>: </label>
				<?php echo form_input('fms_test', set_value('fms_test'), 'id="fms_test" class="inputbox" tabindex="1" type="text"')?>
			</div>			
						
			<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Add')?>" />
		<?php echo form_close()?>
	</div>
</div>
