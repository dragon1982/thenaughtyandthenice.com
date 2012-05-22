<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $favorite_performers_title = lang('Favorite performers')?>
				<span class="eutemia "><?php echo substr($favorite_performers_title,0 ,1)?></span><span class="helvetica "><?php echo substr($favorite_performers_title ,1)?></span>
			</div>
			<?php if( ! is_array($performers)):?>
				<div class="helvetica italic"><?php echo lang('You have no favorite performers!') ?></div>
			<?php else:?>
				<?php foreach( $performers as $performer ):?>
					<?php $this->load->view('performer',array('performer'=>$performer))?>
				<?php endforeach?>					
			<?php endif;?>
		<?php echo $pagination;?><div class="clear"></div>
		</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>