<div class="logo">
	<a href="<?php echo base_url()?>"><img src="<?php echo assets_url()?>images/logo.png"/></a>
</div>
<div class="top_account_info" id="user_account">
	<?php $bold_credits = '<span class="red bold" id="head_user_chips">' . print_amount_by_currency($this->user->credits) . '</span>' ?>
	<span class="username italic gray"><span class="eutemia"><?php echo lang('Welcome back')?></span> &nbsp;&nbsp;&nbsp; <?php echo $this->user->username?><span style="margin-left: 0px; margin-top:18px; margin-right: 10px; text-align: center;float:right"><?php echo sprintf(lang('Your account has %s left'), $bold_credits) ?>.</span> </span>
	
	<div class="menu">
		<span class="username italic gray" style="float:right; margin:0px;"><a href="<?php echo site_url('add-credits')?>"><?php echo lang('Fund your account!')?></a></span>
		<div class="menu_item">
			<a href="<?php echo site_url('settings')?>"><span class="btn"><span class="helvetica "><?php echo lang('Settings')?></span></span><span class="r"></span></a>
		</div>
		<div class="menu_item">
			<a href="<?php echo site_url('statement')?>"><span class="btn"><span class="helvetica "><?php echo lang('Statements')?></span></span><span class="r"></span></a>
		</div>
		<div class="menu_item">
			<a href="<?php echo site_url('payments')?>"><span class="btn"><span class="helvetica "><?php echo lang('Payments')?></span></span><span class="r"></span></a>
		</div>
		<div class="menu_item">
			<a href="<?php echo site_url('logout')?>"><span class="btn"><span class="helvetica "><?php echo lang('Logout')?></span></span><span class="r"></span></a>
		</div>
		
	</div>
</div>
