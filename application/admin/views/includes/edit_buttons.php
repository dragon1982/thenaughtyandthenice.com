					<h2>
					<span style="float:left;"><?php echo $performer->username . '\'s'?> <?php echo lang($this->uri->segment(2))?></span>
					
					<span class="button_cont" style="width:885px;">
						<ul id="barbtns" >
							<li>
								<a <?php echo ($this->uri->segment(2)=='account')?'class="selected"':'' ?> href="<?php echo site_url('performers/account/' . $performer->username)?>"><div style="height:7px"></div><?php echo lang('Edit Account') ?></a>
                			</li>
                			<li>
								<a <?php echo ($this->uri->segment(2)=='profile')?'class="selected"':'' ?> href="<?php echo site_url('performers/profile/' . $performer->username)?>"><div style="height:7px"></div><?php echo lang('Edit Profile') ?></a>
                			</li>
                			<li>
								<a <?php echo ($this->uri->segment(2)=='photos')?'class="selected"':'' ?> href="<?php echo site_url('performers/photos/' . $performer->username)?>"><div style="height:7px"></div><?php echo lang('Edit Photos') ?></a>
                			</li>
                			<li>
								<a <?php echo ($this->uri->segment(2)=='videos')?'class="selected"':'' ?> href="<?php echo site_url('performers/videos/' . $performer->username)?>"><div style="height:7px"></div><?php echo lang('Edit Videos') ?></a>
                			</li>
                			<li>
								<a <?php echo ($this->uri->segment(2)=='sessions')?'class="selected"':'' ?> href="<?php echo site_url('performers/sessions/' . $performer->username)?>"><div style="height:7px"></div><?php echo lang('View sessions') ?></a>
                			</li>
                			<li>
								<a <?php echo ($this->uri->segment(2)=='payments')?'class="selected"':'' ?> href="<?php echo site_url('performers/payments/' . $performer->username)?>"><div style="height:7px"></div><?php echo lang('View payments') ?></a>
                			</li>
                			<li>
								<a <?php echo ($this->uri->segment(2)=='chat_logs')?'class="selected"':'' ?> href="<?php echo site_url('performers/chat_logs/' . $performer->username)?>"><div style="height:7px"></div><?php echo lang('Chat logs') ?></a>
                			</li>
						</ul>
					</span>
					</h2>