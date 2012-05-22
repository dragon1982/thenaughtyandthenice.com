<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<?php
		if (isset($page_title) && $page_title != ''):
			$first_char = substr($page_title, 0, 1);
			$rest_of_text = substr($page_title, 1);
			?>
			<div class="title">
				<span class="eutemia "><?php echo strtoupper($first_char) ?></span><span class="helvetica "><?php echo $rest_of_text ?></span>
			</div>

		<?php endif ?>		
		<div style="margin-left:30px;" class="f13 red italic">
			
			  



			
			<p>
				<?php echo lang('Welcome to our affiliate program!') ?><br/>
				<?php echo lang('JOIN OUR AFFILIATE PROGRAM NOW AND START MAKING LOADS OF CASH!') ?><br/>
				<?php echo lang('If you have a website, you can apply to become a member of our affiliate program and earn money by referring visitors to our website.') ?>
				<br/><br/>
			</p>
			<p>
				<?php echo sprintf(lang('Affiliate commission is %s of the money referred users spend on chips.'), SETTINGS_TRANSACTION_PERCENTAGE.'%') ?><br/>
				<?php echo sprintf(lang('Each time a user buys chips, you will receive %s of their value. There is no time limit and you do not have to wait for users to spend bought chips on the website; this means that if in 10 years a user referred by your website buys 100 chips, your account will be funded with the real currency-equivalent of 30 chips at that precise time.'), SETTINGS_TRANSACTION_PERCENTAGE.'%') ?>
			</p>
			<p>
				<?php echo lang('You can view live account statistics 24/7. You will get paid as soon as your account balance reaches the desired release amount.') ?>
			</p>
		</div>
		<div class="login_boxes">
			<div class="box_b_1 f15" style="text-align: center; text-transform: uppercase; ">
				<?php echo lang('Start earning thousands of cash') ?> <br/> 
				<span class="red"><?php echo lang('right now!') ?> </span> <br/><br/>

				<?php echo lang('All you need is a domain name to join the biggest adult video affiliation system on Earth!') ?>
				<br/>
				<br/>
				<br/>
				<br/>
				<a href="<?php echo site_url('register') ?>"><button class="red" style="width:150px;"><?php echo lang('Register now') ?> </button></a>

			</div>
			<div class="box_b_1">
				<div style="padding:20px;">
					<?php echo form_open('') ?>
					<div class="b_sep_line">
						<span class="italic"><?php echo lang('Your name') ?>*:</span><br/>
						<?php echo form_input('username', set_value('username'), 'style="width:275px;"') ?>
						<span class="gray italic"><?php echo form_error('username') ?></span>
					</div>
					<div class="b_sep_line">
						<span class="italic"><?php echo lang('Your password') ?>*:</span><br/>
						<?php echo form_password('password', set_value('password'), 'style="width:275px;"') ?>
						<span class="gray italic"><?php echo form_error('password') ?></span>
					</div>

					<div style="margin-top:8px; text-align: center;">
						<button class="red"  type="submit" style="width:150px;"> <?php echo lang('Login as affiliate') ?> </button><br/>
						<a href="<?php echo site_url('home/forgot_password') ?>" class="red f13 forgot_password" style="text-transform: none;"><?php echo lang('Forgot Password?') ?></a>
					</div>
					<?php echo form_close('') ?>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>