<div class="container">
	<div class="conthead">
		<h2><?php echo lang('Edit language')?></h2>
	</div>
	<div class="contentbox">		
		<?php echo form_open()?>
			<div class="inputboxes">
				<label for="name"><?php echo lang('Code')?>: </label>
				<?php echo form_input('code', set_value('code',$supported_language->code), 'id="code" class="inputbox" tabindex="1" type="text"')?>
			</div>
			<div class="inputboxes">
				<label for="name"><?php echo lang('Title')?>: </label>
				<?php echo form_input('title', set_value('title',$supported_language->title) , 'id="title" class="inputbox" tabindex="1" type="text"')?>
			</div>						
			<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Save')?>" />
		<?php echo form_close()?>
	</div>
</div>
