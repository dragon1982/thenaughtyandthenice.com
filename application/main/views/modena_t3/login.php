	<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $users_login_title = lang('Users Login')?>
				<span class="eutemia "><?php echo substr($users_login_title,0,1)?></span><span class="helvetica "><?php echo substr($users_login_title,1)?></span>
			</div>			
			<div style="margin-left:30px;" class="f13 red italic">

				<button class="red" style="width:150px;"><?php echo lang('Join now') ?></button><br/>
				<a href="#" class="red f13" style="text-transform: none;"><?php echo lang('Forgot Password') ?>?</a>
				
			</div>
			<div class="box_b_1">
				<div style="padding:20px;">
					
					<div class="b_sep_line">
						<span class="italic"><?php echo lang('Your name')?>*:</span><br/>
						<input type="text" name="name" value="username" style="width:275px;"  onfocus="if(this.value == '<?php echo lang('username')?>') { this.value = '' }" onblur="if(this.value.length == 0) { this.value = '<?php echo lang('username')?>' }"/>
						<span class="gray italic"><?php echo lang('Type your performer name')?></span>
					</div>
					<div class="b_sep_line">
						<span class="italic"><?php echo lang('Your password')?>*:</span><br/>
						<input type="text" name="name" value="password" style="width:275px;"  onfocus="if(this.value == '<?php echo lang('password')?>') { this.value = '' }" onblur="if(this.value.length == 0) { this.value = '<?php echo lang('password')?>' }"/>
						<span class="gray italic"><?php echo lang('Password must be valid')?>!</span>
					</div>
					
					<div style="margin-top:8px; text-align: center;">
						<button class="red" style="width:150px;"> <?php echo lang('Join now') ?> </button><br/>
						<a href="#" class="red f13" style="text-transform: none;"><?php echo lang('Forgot Password') ?>?</a>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>	