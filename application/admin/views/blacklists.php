<div class="container">
	<div class="conthead">
		<h2><?php echo lang ('Website ACCESS Config') ?></h2>
	</div>
	<div class="contentbox">
		<?php echo form_open()?>
		
		<h2><?php echo lang ('Whitelisted IPS')?></h2>
		<?php echo form_textarea('whitelisted_ips',set_value('whitelisted_ips',$whitelisted_ips),'style="float:left"')?>
		<span style="float:left;padding-top:20px;font-weight:bold"><?php echo lang ('Eg:<br/>  192.168.1.1 <br/>  192.168.1.2')?></span>
		<div style="clear:both"></div>
		<h2><?php echo lang ('Blacklisted IPS')?></h2>
		<?php echo form_textarea('blacklisted_ips',set_value('blacklisted_ips',$blacklisted_ips),'style="float:left"')?>
		<span style="float:left;padding-top:20px;font-weight:bold"><?php echo lang ('Eg:<br/>  192.168.1.1 <br/>  192.168.1.2')?></span>
		<div style="clear:both"></div>
		<br />
		<h2><?php echo lang ('Blacklisted Countries')?></h2>
		<?php echo form_dropdown('blacklisted_countries[]',$countries,$selected_countries,'multiple="multiple" size="15"')?>
		<div style="clear:both"></div>
		<br />
		<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Apply Changes')?>" />		
		<?php echo form_close()?>
	</div>
</div>