<div id="left">
	<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $settings_title = lang('Settings') ?>
				<span class="eutemia "><?php echo substr($settings_title,0,1)?></span><span class="helvetica "><?php echo substr($settings_title,1)?></span>
			</div>		
			<div class="menu">
				<div class="menu_item">
					<a href="<?php echo site_url('settings')?>"><span class="btn"><span class="helvetica "><?php echo lang('Personal details') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('settings/payment')?>"><span class="btn"><span class="helvetica "><?php echo lang('Payment details') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('settings/password')?>"><span class="btn"><span class="helvetica "><?php echo lang('Change password') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('settings/percentage')?>"><span class="btn"><span class="helvetica "><?php echo lang('Change percentage') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('contracts')?>"><span class="btn"><span class="helvetica "><?php echo lang('Contracts') ?></span></span><span class="r"></span></a>
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