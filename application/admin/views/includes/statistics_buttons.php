<h2>
<span style="float:left;"><?php echo lang($this->uri->segment(2))?></span>

<span class="button_cont" style="width:885px;">
	<ul id="barbtns" >
		<li>
			<a id="button_totals" onclick="show_chart('totals', this);" style="cursor:pointer;"><div style="height:7px"></div><?php echo lang('Totals') ?></a>
		</li>
		<li>
			<a id="button_earnings" onclick="show_chart('earnings', this);"  style="cursor:pointer;"><div style="height:7px"></div><?php echo lang('Earnings') ?></a>
		</li>
		<li>
			<a id="button_watchers" onclick="show_chart('watchers', this);" style="cursor:pointer;"><div style="height:7px"></div><?php echo lang('Viewers') ?></a>
		</li>
		<li>
			<a id="button_registers" onclick="show_chart('registers', this);" style="cursor:pointer;"><div style="height:7px"></div><?php echo lang('Signups') ?></a>
		</li>
		<li>
			<a id="button_registers" onclick="show_chart('affiliates', this);" style="cursor:pointer;"><div style="height:7px"></div><?php echo lang('Affiliates ads traffic') ?></a>
		</li>
		<li>
			<a id="button_registers" onclick="show_chart('transactions', this);" style="cursor:pointer;"><div style="height:7px"></div><?php echo lang('Transactions') ?></a>
		</li>
		<li>
			<a id="button_registers" onclick="show_chart('payments', this);" style="cursor:pointer;"><div style="height:7px"></div><?php echo lang('Payments') ?></a>
		</li>
	</ul>
</span>
</h2>