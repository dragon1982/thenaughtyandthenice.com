<div class="logo">
	<a href="<?php echo site_url()?>"><img src="<?php echo assets_url()?>images/logo.png"/></a>
</div>
<div class="top_account_info">
	<?php $unread_messages = '<a href="'.site_url('messenger').'"><span class="red">' . $this->user->unread_messages . '</span></a>' ?> 
	<span class="username italic gray"><span class="eutemia"><?php echo lang('Welcome back')?></span> &nbsp;&nbsp;&nbsp; <?php echo $this->user->nickname?>, <?php echo sprintf(lang('%s unread message(s)'), $unread_messages) ?>.</span>
	<span class="info italic gray" >	
		<?php $credits_red = '<span class="red">' . print_amount_by_currency($this->user->credits) . '</span>' ?>				
		<div style="margin:5px;">
			<?php echo sprintf(lang('Your account has %s'), $credits_red)?> 
			<?php if( SETTINGS_CURRENCY_TYPE )://daca nu e in bani reali afisez suma si in real money?>
				<?php $equivalent = '<span class="red">' . print_amount_by_currency($this->user->credits,TRUE) . '</span>'?>
				<?php echo sprintf(lang('the equivalent of %s.'), $equivalent)?>
			<?php endif?>
		</div>
		<?php if( ! $this->user->studio_id ):?>
			<?php if($this->user->release < convert_chips_to_value($this->user->credits)):?>
				<div style="margin:5px;"><span><?php echo lang('You have been marked for payment.')?></span></div>
			<?php else: ?>
				<?php $need_more  = '<span class="red">' . print_amount_by_currency(convert_value_to_chips(abs($this->user->release - convert_chips_to_value($this->user->credits)))) . '</span>' ?>
				<div style="margin:5px;"><?php echo sprintf(lang('You need %s more and we\'ll send you the payment!'), $need_more)?></div>
			<?php endif; ?>
		<?php endif?>	
	</span>
</div>
