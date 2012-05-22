<div id="left">
	<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $payments_settings_title = lang('Settings') ?>
				<span class="eutemia"><?php echo substr($payments_settings_title, 0, 1)?></span><span class="helvetica"><?php echo substr($payments_settings_title, 1)?></span>
			</div>		
			<div class="menu">
				<div class="menu_item">
					<a href="<?php echo site_url('my_earnings')?>"><span class="btn"><span class="helvetica italic"><?php echo lang('Earnigns') ?></span></span><span class="r"></span></a>
				</div>
				<div class="menu_item">
					<a href="<?php echo site_url('my_payments')?>"><span class="btn"><span class="helvetica italic"><?php echo lang('Payments') ?></span></span><span class="r"></span></a>
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