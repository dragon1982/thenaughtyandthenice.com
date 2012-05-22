				<h2>
					<span class="button_cont" style="width:330px;">
						<ul id="barbtns" >
                			<li>
								<a <?php echo ($current_page=='view')?'class="selected new_width"':'class="new_width"' ?> href="<?php echo site_url('payment-methods/view/')?>"><div style="height:7px" ></div><?php echo lang('View Payment Methods') ?></a>
                			</li>
                			<li>
								<a <?php echo ($current_page=='add')?'class="selected new_width"':'class="new_width"' ?> href="<?php echo site_url('payment-methods/add')?>"><div style="height:7px"></div><?php echo lang('Add Payment Method') ?></a>
                			</li>
						</ul>
					</span>
				</h2>