<h2>
	<span style="float:left;"><?php echo lang('To Pay') ?><?php echo lang(ucfirst($this->uri->segment(2)))?></span>

<span class="button_cont" style="width:385px;">
	<ul id="barbtns" >
		<li>
			<a <?php echo ($this->uri->segment(2)=='studios')?'class="selected"':'' ?> href="<?php echo site_url('to_pay/studios/')?>"><div style="height:7px"></div><?php echo lang('Studios') ?></a>
		</li>
		<li>
			<a <?php echo ($this->uri->segment(2)=='performers')?'class="selected"':'' ?> href="<?php echo site_url('to_pay/performers/')?>"><div style="height:7px"></div><?php echo lang('Performers') ?></a>
		</li>
		<li>
			<a <?php echo ($this->uri->segment(2)=='affiliates')?'class="selected"':'' ?> href="<?php echo site_url('to_pay/affiliates/')?>"><div style="height:7px"></div><?php echo lang('Affiliates') ?></a>
		</li>
	</ul>
</span>
</h2>