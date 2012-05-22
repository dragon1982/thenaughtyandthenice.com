<h2>
<span style="float:left;"><?php echo $studio->username . '\'s'?> <?php echo lang($this->uri->segment(2))?></span>

<span class="button_cont" style="width:385px;">
	<ul id="barbtns" >
		<li>
			<a <?php echo ($this->uri->segment(2)=='account')?'class="selected"':'' ?> href="<?php echo site_url('studios/account/' . $studio->username)?>"><div style="height:7px"></div><?php echo lang('Edit Account') ?></a>
		</li>
		<li>
			<a <?php echo ($this->uri->segment(2)=='performers')?'class="selected"':'' ?> href="<?php echo site_url('studios/performers/' . $studio->username)?>"><div style="height:7px"></div><?php echo lang('View performers') ?></a>
		</li>
		<li>
			<a <?php echo ($this->uri->segment(2)=='payments')?'class="selected"':'' ?> href="<?php echo site_url('studios/payments/' . $studio->username)?>"><div style="height:7px"></div><?php echo lang('View Payments') ?></a>
		</li>
	</ul>
</span>
</h2>