            <div id="slider">
				
                <ul id="sliderContent">
					<li style="height: 90px;"></li>
                    <li><a href="<?php echo site_url('admins/add_or_edit/'.$this->user->id)?>"><?php echo lang('Change password') ?></a></li>
                    <li class="alt"><a href="<?php echo site_url('home/logout') ?>"><?php echo lang('Log Out') ?></a></li>
                </ul>
				
                <div id="openCloseWrap">
                    <div id="toolbox">
						<a href="javascript:;" class="toolboxdrop"><?php echo lang('Toolbox') ?><img src="<?php echo assets_url('admin/images/icon_expand_grey.png') ?>" /></a>
					</div>
                </div>
				
            </div>