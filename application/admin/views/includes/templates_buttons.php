<h2>
	<span style="float:left;"><?php echo $page_title ?></span>

	<span class="button_cont" style="width:260px;">
		<ul id="barbtns" >
			<li>
				<a <?php echo ($this->uri->segment(1) == 'emails_templates') ? 'class="selected"' : '' ?> href="<?php echo site_url('emails_templates') ?>"><div style="height:7px"></div><?php echo lang('Email templates') ?></a>
			</li>
			<li>
				<a <?php echo ($this->uri->segment(1) == 'analytics') ? 'class="selected"' : '' ?> href="<?php echo site_url('analytics') ?>"><div style="height:7px"></div><?php echo lang('Analytics') ?></a>
			</li>
		</ul>
	</span>
</h2>