<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content" style="margin-left:50px;">
		<div class="red_h_sep"></div>
		<div class="title">
			<?php $payment_method_title = lang('Set Payment Method')?>
			<span class="eutemia "><?php echo substr($payment_method_title,0,1)?></span><span class="helvetica "><?php echo substr($payment_method_title,1)?></span>
		</div>
		<div class="italic current_payment"><span class="current_payment_mess"><?php echo lang('Current Payment Method') ?>:</span>
		<?php if ($current_method): ?>
			<?php $fields = @unserialize($this->user->account); ?>
			<?php if( ! empty($fields)): ?>
			<?php foreach ($fields as $key => $value): ?>
				<div><label><?php echo $key ?></label><?php echo ' - ' . $value ?></div>
			<?php endforeach ?>
				<div><label><?=lang('Release')?></label><?php echo ' - ' . $this->user->release ?></div>
			<?php endif ?>
			<div class="edit_payment"><a href="<?php echo site_url('settings/edit-payment-details')?>"><?php echo lang('Edit payment details')?></a></div>
		<?php else: ?>
			<span>- <?php echo lang('Not Set') ?></span>
		<?php endif?>
		</div>
		
		<div class="select_payment"><?php echo lang('Change payment method:')?></div>
		<?php if( ! empty($methods)): ?>
			<?php foreach ($methods as $method): ?>
				<div class="payment_method">
					<a style="color:#e30707; font:italic 15px 'century gothic';" href="<?php echo site_url('settings/set-payment-details/' . $method->id) ?>"><?php echo $method->name ?></a>
				</div>
			<?php endforeach ?>
		<?php else: ?>
			<div><?php echo lang('No payment methods available') ?>.</div>
		<?php endif ?>
		<div class="clear"></div>
		<div class="red_h_sep"></div>
		<div class="white_h_sep"></div>
		
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>