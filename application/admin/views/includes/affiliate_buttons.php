<h2>
	<span style="float:left;"><?php echo $affiliate->username . '\'s' ?> <?php echo lang($this->uri->segment(2)) ?></span>

	<span class="button_cont" style="width:640px;">
		<ul id="barbtns" >
			<li>
				<a <?php echo ($this->uri->segment(2) == 'account') ? 'class="selected"' : '' ?> href="<?php echo site_url('affiliates/account/' . $affiliate->username) ?>"><div style="height:7px"></div><?php echo lang('Edit Account') ?></a>
			</li>
			<li>
				<a <?php echo ($this->uri->segment(2) == 'ads') ? 'class="selected"' : '' ?> href="<?php echo site_url('affiliates/ads/' . $affiliate->username) ?>"><div style="height:7px"></div><?php echo lang('View ads') ?></a>
			</li>
			<li>
				<a <?php echo ($this->uri->segment(2) == 'payments') ? 'class="selected"' : '' ?> href="<?php echo site_url('affiliates/payments/' . $affiliate->username) ?>"><div style="height:7px"></div><?php echo lang('View payments') ?></a>
			</li>
			<li>
				<a <?php echo ($this->uri->segment(2) == 'signups') ? 'class="selected"' : '' ?> href="<?php echo site_url('affiliates/signups/' . $affiliate->username) ?>"><div style="height:7px"></div><?php echo lang('Signups users') ?></a>
			</li>
			<li>
				<a <?php echo ($this->uri->segment(2) == 'traffic') ? 'class="selected"' : '' ?> href="<?php echo site_url('affiliates/traffic/' . $affiliate->username) ?>"><div style="height:7px"></div><?php echo lang('Traffic') ?></a>
			</li>
		</ul>
	</span>
</h2>