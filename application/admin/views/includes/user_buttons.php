<h2>													
		<span style="float:left;"><?php echo $user->username . '\'s'?> <?php echo lang($this->uri->segment(2))?></span>			
					
					<span class="button_cont" style="width: 390px;">
						<ul id="barbtns" >
							<li>
								<a <?php echo ($this->uri->segment(2)=='account')?'class="selected"':'' ?> href="<?php echo site_url('users/account/' . $user->username)?>"><div style="height:7px"></div><?php echo lang('Edit Account') ?></a>
                			</li>
                			<li>
								<a <?php echo ($this->uri->segment(2)=='sessions')?'class="selected"':'' ?> href="<?php echo site_url('users/sessions/' . $user->username)?>"><div style="height:7px"></div><?php echo lang('View Sessions') ?></a>
                			</li>
                			<li>
								<a <?php echo ($this->uri->segment(2)=='payments')?'class="selected"':'' ?> href="<?php echo site_url('users/payments/' . $user->username)?>"><div style="height:7px"></div><?php echo lang('View Payments') ?></a>
                			</li>
						</ul>
					</span>
</h2>			