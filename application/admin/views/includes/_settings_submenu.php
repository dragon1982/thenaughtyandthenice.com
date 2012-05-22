<div class="ui-tabs">
	<ul class=" tabfade ui-tabs-nav  ui-corner-all">
		<li class="<?php echo ($tab == 'checkpoints')? 'ui-tabs-selected' : null ?>"><a href="<?php echo site_url('admin/settings/checkpoints')?>"><?php echo lang('Checkpoints')?></a></li>
		<li class="<?php echo ($tab == 'settings')? 'ui-tabs-selected' : null ?>"><a href="<?php echo site_url('admin/settings')?>"><?php echo lang('Settings')?></a></li>
	</ul>
</div>