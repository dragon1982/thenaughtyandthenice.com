<div class="black_box_bg_middle"><div class="black_box_bg_top">
<div class="black_box" style="height: 100%;">

		<div class="content">
			<?php 
			if(isset($page_title) && $page_title != ''):
				$first_char = substr($page_title, 0, 1);
				$rest_of_text = substr($page_title, 1);
			?>
				<div class="title">
					<span class="eutemia "><?php echo strtoupper($first_char) ?></span><span class="helvetica "><?php echo $rest_of_text ?></span>
				</div>
			
			<?php endif ?>				
			
			<div class="affiliate_get_code">
				<p>
					<?=lang('Put this code in your hatml page, where you want to appeare the ad!')?>
				</p>
				<div class="code_box">
					<?=  htmlentities($code)?>
				</div>
				<div style="margin-top:8px; text-align: right;">
					<button class="red"  onclick="document.location.href='<?=site_url('promo')?>'" style="width:200px;"> <?php echo lang('Go back to your ad zones')?> </button><br/>
				</div>
			</div>
			
			<div class="clear"></div>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>	