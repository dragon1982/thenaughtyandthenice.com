<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $usr_account_title = lang('My account')?>
				<span class="eutemia "><?php echo substr($usr_account_title, 0 , 1)?></span><span class="helvetica "><?php echo substr($usr_account_title, 1)?></span>
			</div>
			<p><?php echo lang('Hello')?><strong> <?php echo $this->user->username?></strong>! <?php echo sprintf(lang('You have %s new messages'),$unread_msgs) ?>.</p>
			<p><?php echo sprintf(lang('You have %s chips'), $this->user->credits)?>. <?php echo lang('To order more click ')?> <a href="<?php echo site_url('add-credits')?>" class="red bold" ><?php echo lang('here') ?></a>!</p>
				
		</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>