
<div class="container">
	<div class="conthead">
		<h2><?php echo lang('Add supported language') ?></h2>
	</div>


	<div class="contentbox">
		<div style="width:400px; margin:0px auto;">
			<?php echo form_open()?>
			<?php echo form_dropdown('country', $countries)?>
			<div class="clear"></div>
			<br/>
			<?php echo form_submit('submit', lang('Save'),'class="btn"')?>
		</div>
		
	</div>

</div>


