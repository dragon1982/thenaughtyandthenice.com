<div id="left">
	<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $settings_inc_title = lang('Settings') ?>
				<span class="eutemia "><?php echo substr($settings_inc_title,0,1)?></span><span class="helvetica "><?php echo substr($settings_inc_title,1)?></span>
			</div>
			<div class="menu">
				<div class="menu_item">
					<a href="<?php echo site_url('performer/settings/password')?>"><span class="btn"><span class="helvetica "><?php echo lang('Password') ?></span></span><span class="r"></span></a>
				</div>			
				<div class="menu_item">
					<a href="<?php echo site_url('performer/settings/profile')?>"><span class="btn"><span class="helvetica "><?php echo lang('Profile') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('performer/settings/personal-details')?>"><span class="btn"><span class="helvetica "><?php echo lang('Personal details') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('performer/settings/pricing')?>"><span class="btn"><span class="helvetica "><?php echo lang('Pricing') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('performer/settings/banned-zones')?>"><span class="btn"><span class="helvetica "><?php echo lang('Banned zones') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('performer/settings/categories')?>"><span class="btn"><span class="helvetica "><?php echo lang('Categories') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('performer/settings/schedule')?>"><span class="btn"><span class="helvetica "><?php echo lang('Schedule') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('performer/photos')?>"><span class="btn"><span class="helvetica "><?php echo lang('Photos') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('performer/videos')?>"><span class="btn"><span class="helvetica "><?php echo lang('Videos') ?></span></span><span class="r"></span></a>
				</div>				
			</div>
			<div class="clear"></div>
			<br /><br /><br />			
			<div class="title">
				<?php $payments_settings_title = lang('Account') ?>
				<span class="eutemia "><?php echo substr($payments_settings_title, 0, 1)?></span><span class="helvetica "><?php echo substr($payments_settings_title, 1)?></span>
			</div>
			<div class="menu">
				<div class="menu_item">
					<a href="<?php echo site_url('performer/contracts')?>"><span class="btn"><span class="helvetica "><?php echo lang('Contracts') ?></span></span><span class="r"></span></a>
				</div>			
				<div class="menu_item">
					<a href="<?php echo site_url('performer/photo_id')?>"><span class="btn"><span class="helvetica "><?php echo lang('Photo ID') ?></span></span><span class="r"></span></a>
				</div>
		
			</div>
				
			<div class="clear"></div>					
		</div>		
	</div>
	</div></div><div class="black_box_bg_bottom"></div>	
</div>
<div id="right">
	<?
		if(isset($page)){
			$this->load->view($page);
		}
	?>
</div>
<div class="clear"></div>