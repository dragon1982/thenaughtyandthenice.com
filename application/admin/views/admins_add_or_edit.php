			<?php $admin_id = (isset($admin) && is_object($admin)) ? $admin->id : 0 ?> 
			<div class="container">
				<div class="conthead">
					<h2><?php echo ($admin_id > 0)? lang('Edit') : lang('Add')?> <?php echo lang('admin account')?></h2>
				</div>

				<div class="contentbox">
					
					<?php echo form_open('admins/add_or_edit/'.$admin_id)?>
						<div class="inputboxes">
							<label for="username"><?php echo lang('Username')?>: </label>
							<?php echo form_input('username', set_value('username', (isset($admin) && is_object($admin))? $admin->username : null), 'id="username" class="inputbox" tabindex="1" type="text"')?>
						</div>
						<div class="inputboxes">
							<label for="password"><?php echo lang('Password')?>: </label>
							<?php echo form_input('password', set_value('password'), 'id="password" class="inputbox" tabindex="1" type="text"')?>
						</div>
						
						
						<input class="btn" type="submit" tabindex="3" value="<?php echo ($admin_id > 0)? lang('Update') : lang('Add')?> <?php echo lang('admin account')?>" />
					<?php echo form_close()?>
				</div>
			</div>
