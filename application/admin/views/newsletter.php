
			<div class="container">
				<div class="conthead">
					<h2><?php echo lang ('Create Newsletter') ?></h2>
				</div>
				
				
				
				<div class="contentbox">
					<div class="center_contentbox" style="width:1000px">
					<?php echo form_open('newsletter')?>


							<!-- ACCOUNT TYPES -->
							<div class="inputboxes">
								<label for="account_type"><?php echo lang('Account Type')?>: </label>
								<?php echo form_dropdown('account_type', $account_types, null, 'id="account_type" class="inputbox" tabindex="1"  style="width:323px;"')?>
							</div>
							
							<!-- ACCOUNT STATUS -->
							<div class="inputboxes">
								<label for="account_status"><?php echo lang('Account status')?>: </label>
								<?php echo form_dropdown('account_status', $account_status, null, 'id="account_status" class="inputbox" tabindex="1"  style="width:323px;"')?>
							</div>
							
							
							<!-- EMAIL SUBJECT -->
							<div class="inputboxes">
								<label for="subject"><?php echo lang('Email Subject')?>: </label>
								<?php echo form_input('subject',  null, 'id="subject" class="inputbox" tabindex="1"  style="width:303px;"')?>
							</div>
		
							<!-- EMAIL BODY -->
							<div class="inputboxes">
								<label for="body"><?php echo lang('Email Body')?>: </label>
								<?php echo form_textarea('body',  null, 'id="wysiwyg" class="inputbox" style="width:720px;"')?>
							</div>



							<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Send')?>" />
						<?php echo form_close()?>
					</div>
					<div class="extrabottom">
						<div class="bulkactions">
						</div>
					</div>
				</div>
			</div>


