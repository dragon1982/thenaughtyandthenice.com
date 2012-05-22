<div class="search">
	<?php echo form_open('')?>
		<img src="<?php echo assets_url()?>images/icons/search.png" />
		<input type="text" name="search" value="" style="width:100px;"/>
		<input type="submit" value="Search" class="red"/>
		<button class="black" style="width:110px;"/><?php echo lang('Advanced search') ?></button>
	<?php echo form_close()?>
</div>