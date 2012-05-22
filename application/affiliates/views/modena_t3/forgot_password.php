
				
				
<div class="box_b_1" style="margin:0px auto; float:none;">
	<div style="padding:20px;">

		<?php
		if(isset($page_title) && $page_title != ''):
			$first_char = substr($page_title, 0, 1);
			$rest_of_text = substr($page_title, 1);
		?>
			<div class="title" style="margin-top:-30px;">
				<span class="eutemia "><?php echo strtoupper($first_char)?></span><span class="helvetica "><?php echo $rest_of_text ?></span>
			</div>

		<?php endif ?>	
		<?php echo form_open('')?>
			<div class="b_sep_line">
				<span class="italic"><?php echo lang('Your name')?>*:</span><br/>
				<?php echo form_input('username', set_value('username'), 'style="width:275px;"')?>
				<span class="gray italic red"><?php echo form_error('username')?></span>
			</div>
			<div class="b_sep_line">
				<span class="italic"><?php echo lang('Email address')?>*:</span><br/>
				<?php echo form_input('email', set_value('email'), 'style="width:275px;"')?>
				<span class="gray italic red"><?php echo form_error('email')?></span>
			</div>

			<div style="margin-top:8px; text-align: center;">
				<button class="red"  type="submit" style="width:130px; display: inline-block;"> <?php echo lang('Submit')?> </button>
<!--				<button class="red"  type="button"  onclick="document.location.href='<?=site_url('login')?>'" style="width:130px; display: inline-block;"> <?php echo lang('Login')?> </button><br/>-->
			</div>
		<?php echo form_close('')?>
	</div>
</div>
