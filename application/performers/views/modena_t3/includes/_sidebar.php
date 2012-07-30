<div id="left">
	<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $payments_settings_title = lang('Settings') ?>
				<span class="eutemia "><?php echo substr($payments_settings_title, 0, 1)?></span><span class="helvetica "><?php echo substr($payments_settings_title, 1)?></span>
			</div>
					
			<div class="menu">
				<div class="menu_item">
					<a href="<?php echo site_url('settings/password')?>"><span class="btn"><span class="helvetica "><?php echo lang('Password') ?></span></span><span class="r"></span></a>
				</div>			
				<div class="menu_item">
					<a href="<?php echo site_url('settings/profile')?>"><span class="btn"><span class="helvetica "><?php echo lang('Profile') ?></span></span><span class="r"></span></a>
				</div>				
				<div class="menu_item">
					<a href="<?php echo site_url('settings/personal-details')?>"><span class="btn"><span class="helvetica "><?php echo lang('Personal details') ?></span></span><span class="r"></span></a>
				</div>				
				<?php if( ! $this->user->studio_id ):?>
					<div class="menu_item">
						<a href="<?php echo site_url('settings/payment')?>"><span class="btn"><span class="helvetica "><?php echo lang('Payment') ?></span></span><span class="r"></span></a>
					</div>
				<?php endif?>
				<div class="menu_item">
					<a href="<?php echo site_url('settings/pricing')?>"><span class="btn"><span class="helvetica "><?php echo lang('Pricing') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('settings/banned_zones')?>"><span class="btn"><span class="helvetica "><?php echo lang('Banned locations') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('settings/categories')?>"><span class="btn"><span class="helvetica "><?php echo lang('Categories') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('settings/schedule')?>"><span class="btn"><span class="helvetica "><?php echo lang('Schedule') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('photos')?>"><span class="btn"><span class="helvetica "><?php echo lang('My photos') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('videos')?>"><span class="btn"><span class="helvetica "><?php echo lang('My videos') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('settings/pause_settings')?>"><span class="btn"><span class="helvetica "><?php echo lang('Pause Settings') ?></span></span><span class="r"></span></a>
				</div>			
			</div>
			<br /><br /><br />
			<div class="title">
				<?php $payments_settings_title = lang('Account') ?>
				<span class="eutemia "><?php echo substr($payments_settings_title, 0, 1)?></span><span class="helvetica "><?php echo substr($payments_settings_title, 1)?></span>
			</div>
			<div class="menu">
				<div class="menu_item">
					<a href="<?php echo site_url('contracts')?>"><span class="btn"><span class="helvetica "><?php echo lang('Contracts') ?></span></span><span class="r"></span></a>
				</div>			
				<div class="menu_item">
					<a href="<?php echo site_url('photo_id')?>"><span class="btn"><span class="helvetica "><?php echo lang('Photo ID') ?></span></span><span class="r"></span></a>
				</div>
		
			</div>
			
			<div class="clear"></div>
		</div>		
	</div>
	</div></div><div class="black_box_bg_bottom"></div>	
</div>
<div id="right">
	<?php
		if(isset($page)){
			$this->load->view($page);
		}
	?>
</div>
<div class="clear"></div>
