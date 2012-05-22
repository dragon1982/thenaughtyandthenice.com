<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $categories_page_title = lang('Performer\'s Categories Page')?>
			<span class="eutemia"><?php echo substr($categories_page_title,0,1)?></span><span class="helvetica"><?php echo substr($categories_page_title,1)?></span>
		</div>
		<div id="profile">
			<div class="left" style="text-align: center;">
				<div class="red_h_sep"></div>
				<div class="gray italic register_performer">
					<?php echo form_open()?>
						<label><span class="gray italic bold"><?php echo lang('Categories') ?></span></label>
						<?php if(sizeof($categories['main_categories']) > 0):?>
							<ul style="list-style-type:none; display:inline-block;margin-top: 0px; ">
							<?php foreach($categories['main_categories'] as $main_category):?>
								<li>
									<label  style="text-align: left;">
										<?php echo form_checkbox('categories['. $main_category->id . ']', $main_category->id,set_checkbox('categories',$main_category->id,(in_array($main_category->id,$performer_categories)?TRUE:FALSE)))?>
										<span class="gray italic bold"><?php echo lang($main_category->name) ?></span>
									</label>
								</li>
								<?php if(sizeof($categories['sub_categories']) > 0 && isset($categories['sub_categories'][$main_category->id]) && sizeof($categories['sub_categories'][$main_category->id]) > 0):?>
									<li>
										<ul style="list-style-type:none; ">
											<?php foreach($categories['sub_categories'][$main_category->id] as $sub_category):?>
												<li>
													<label  style="text-align: left;">
														<?php echo  form_checkbox('categories[' . $sub_category->id .']', $sub_category->id,set_checkbox('categories',$sub_category->id,(in_array($sub_category->id,$performer_categories)?TRUE:FALSE)))?>
														<span class="gray italic bold"><?php echo lang($sub_category->name)?></span>
													</label>
												</li>
											<?php endforeach?>
										</ul>
									</li>
								<?php endif?>
							<?php endforeach?>
							</ul>
						<?php endif?>						
					<div style="text-align: center;">
						<?php echo form_submit('submit', lang('Save'), 'class="red" style="width:206px;"')?>
					</div>			
					<?php echo form_close('')?>
				</div>
				<div class="red_h_sep"></div>
				<div class="white_h_sep"></div>
								
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>