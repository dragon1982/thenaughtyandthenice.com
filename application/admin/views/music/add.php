<div class="container">
	<div class="conthead">
		<h2><?php echo lang('Add song')?></h2>
	</div>
	<div class="contentbox">
		<?php echo form_open_multipart(current_url())?>
			<div class="inputboxes">
				<label for="title"><?php echo lang('Title')?>: </label>
				<?php echo form_input('title', set_value('title'), 'id="title" class="inputbox" tabindex="1" type="text"')?>
			</div>
			<div class="inputboxes">
				<?php echo form_hidden('music',1)?>
				<label for="Song"><?php echo lang('Song')?>: </label>
				<?php echo form_upload('userfile')?>
			</div>
			<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Add song')?>" />
		<?php echo form_close()?>
	</div>
</div>