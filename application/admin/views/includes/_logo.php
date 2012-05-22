			<div id="logo_user_details">
				<h1 id="logo"><a href="<?php echo site_url('admin')?>/"><?php echo lang('Administration Panel') ?>s</a></h1>
				<!--[if !IE]>start user details<![endif]-->
				<div id="user_details">
					<ul id="user_details_menu">
						<li><?php echo lang('Welcome Administrator') ?></li>
						<li>
							<ul id="user_access">
								<li class="first"><a href="<?php echo site_url('user')?>"><?php echo lang('My account') ?></a></li>
								<li class="last"><a href="<?php echo site_url('logout')?>"><?php echo lang('Log out') ?></a></li>
							</ul>
						</li>
						<?if(false){?>
						<li><a class="new_messages" href="#">4 <?php echo lang('new messages') ?></a></li>
						<?}?>
					</ul>
					
					<div id="server_details" style="margin-top: 45px;">
						<dl>
							<dt><?php echo lang('Server time')?>:</dt>
							<dd><?php echo date('H:i (A)') .'&nbsp;&nbsp;&nbsp;'. date('Y-m-d')?></dd>
						</dl>
					</div>
				</div>
				<!--[if !IE]>end user details<![endif]-->
			</div>