<div class="container">
	<div class="conthead">
		<h2><?php echo lang('Edit song')?></h2>
	</div>
	<div class="contentbox">
		<?php echo form_open()?>
			<div class="inputboxes">
				<label for="title"><?php echo lang('Title')?>: </label>
				<?php echo form_input('title', set_value('title',$song->title), 'id="title" class="inputbox" tabindex="1" type="text"')?>
			</div>
			<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Upload')?>" />
		<?php echo form_close()?>
	</div>
</div>