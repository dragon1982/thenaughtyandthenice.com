<div id="left">
	<div class="black_box_bg_middle"><div class="black_box_bg_top">
	<div class="black_box">
		<div class="content">
			<?php
			if(isset($_sidebar_title) && $_sidebar_title != ''):
				$first_char = substr($_sidebar_title, 0, 1);
				$rest_of_text = substr($_sidebar_title, 1); ?>
				<div class="title">
					<span class="eutemia "><?php echo strtoupper($first_char) ?></span><span class="helvetica "><?php echo $rest_of_text?></span>
				</div>
			
			<?php endif ?>
			<?php if(isset($_sidebar_page) && $_sidebar_page != '') {
					$this->load->view('sidebar_pages/'.$_sidebar_page);
			}
			?>
			
			<div class="clear"></div>
		</div>
		
	</div>
	</div></div><div class="black_box_bg_bottom"></div>	
</div>
<div id="right"	>
	<?php
		if(isset($page)){
			$this->load->view($page);
		}
	?>
</div>
<div class="clear"></div>