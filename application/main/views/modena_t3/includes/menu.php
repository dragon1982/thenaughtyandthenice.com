<div id="menu">
	<div class="item">
		<span class="bg_l "></span><span class="bg_m ">
			<a href="<?php echo base_url()?>" class="menu_item">
				<?php $menu_item = lang('Online Chat')?>
				<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
			</a>
		</span><span class="bg_r "></span>
	</div>
	<div class="item">
		<span class="bg_l "></span><span class="bg_m ">
			<a href="<?php echo site_url('performers')?>" class="menu_item">
				<?php $menu_item = lang('Our Models')?>
				<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
			</a>
		</span><span class="bg_r "></span>
	</div>
	<div class="item">
		<span class="bg_l "></span><span class="bg_m ">
			<a href="<?php echo site_url('favorites')?>" class="menu_item">
				<?php $menu_item = lang('Favorites')?>
				<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
			</a>
		</span><span class="bg_r "></span>
	</div>	
	<div class="item">
		<span class="bg_l "></span><span class="bg_m ">
			<a href="<?php echo site_url('videos')?>" class="menu_item">
				<?php $menu_item = lang('Videos')?>
				<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
			</a>
		</span><span class="bg_r "></span>
	</div>
	<?php if($this->user->id > 0):?>
		<div class="item">
			<span class="bg_l "></span><span class="bg_m ">
				<a href="<?php echo site_url('add-credits')?>" class="menu_item">
					<?php $menu_item = lang('Order Credits')?>
					<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
				</a>
			</span><span class="bg_r "></span>
		</div>
		<div class="item">
			<span class="bg_l "></span><span class="bg_m ">
				<a href="<?php echo site_url('messenger')?>" class="menu_item">
					<?php $menu_item = lang('Messenger')?>
					<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
				</a>
			</span><span class="bg_r "></span>
		</div>
		<div class="item">
			<span class="bg_l "></span><span class="bg_m ">
				<a href="<?php echo site_url('account')?>" class="menu_item">
					<?php $menu_item = lang('My account')?>
					<span class="eutemia " ><?php echo substr($menu_item,0,1)?></span><span class="red arial" ><?php echo substr($menu_item,1)?></span>
				</a>
			</span><span class="bg_r "></span>
		</div>
	<?php endif;?>
	<div class="clear"></div>
</div>