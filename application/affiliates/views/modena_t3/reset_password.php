<div class="black_box_bg_middle"><div class="black_box_bg_top">
<div class="black_box" style="height: 100%;">
	<div class="content">
		<?php
		if(isset($page_title) && $page_title != ''):
			$first_char = substr($page_title, 0, 1);
			$rest_of_text = substr($page_title, 1);
		?>
			<div class="title">
				<span class="eutemia "><?php echo strtoupper($first_char)?></span><span class="helvetica "><?php echo $rest_of_text ?></span>
			</div>
		
		<?php endif ?>			
		<?php echo form_open($form_link)?>
		<div class="gray italic reset_password" style="margin: 0px auto;width:400px;">
			
			<!--  PASSWORD -->
			<div>
				<label><span class="gray italic bold"><?php echo lang('Password')?></span></label>
				<?php echo form_password('password',set_value('password'))?>
				<span class="error message" htmlfor="password" generated="true"></span>
			</div>
			
			<!--  REPEAT PASSWORD -->
			<div>
				<label><span class="gray italic bold"><?php echo lang('Repeat password')?></span></label>
				<?php echo form_password('rep_password',set_value('rep_password'))?>
				<span class="error message" htmlfor="rep_password" generated="true"></span>
			</div>
			<br/>
			<div style="margin-top:8px; text-align: center;">
				<button class="red"  type="submit" style="width:150px;"> <?php echo lang('Update')?> </button><br/>
			</div>
		</div>
		<?php echo form_close()?>
		<div class="clear"></div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>