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
		<div id="affiliate_settings">
			<?php echo form_open('settings/change_password')?>
			<div class="gray italic register_performer" style="margin: 0px auto;">
				<!--  PASSWORD -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Old password')?></span></label>
					<?php echo form_password('old_password',set_value('old_password'))?>
					<span class="error message" htmlfor="old_password" generated="true"></span>
				</div>

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
				<div style="margin-top:8px; margin-left:223px;">
					<button class="red"  type="submit" style="width:206px;"> <?php echo lang('Update')?> </button><br/>
				</div>
			</div>
			<?php echo form_close()?>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>	