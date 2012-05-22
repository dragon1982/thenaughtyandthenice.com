<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $performer_banned_zone_title = lang('Performer\'s Banned Zones Page') ?>
			<span class="eutemia"><?php echo substr($performer_banned_zone_title,0,1)?></span><span class="helvetica"><?php echo substr($performer_banned_zone_title,1)?></span>
		</div>
		<div id="profile">
			<div class="left" style="text-align: center;">
				<div class="red_h_sep"></div>
				<div class="gray italic register_performer">
				<?php echo form_open('')?>
					<ul style="list-style-type:none; width: 300px; float:left; overflow-y: scroll; height: 500px;" >
						<?php if(form_error('countries[]')):?>
							<span class="error message" htmlfor="languages" generated="true" style="vertical-align:top"><?php echo form_error('countries[]')?></span>
						<?php endif?>					
						<p><?php echo lang('Countries') ?>:</p>
						<?php foreach ($countries as $key => $value):?>
							<li>
								<label style="text-align: left;">
									<?php echo form_checkbox('countries[]', $key,set_checkbox('countries',$key,(in_array($key,$banned_countries)?TRUE:FALSE)))?>
									<span class="gray italic bold"><?php echo $value?></span>
								</label>
							</li>
						<?php endforeach;?>
					</ul>				
					<ul style="list-style-type:none; width: 300px; float:left; overflow-y: scroll; height: 500px;">
						<?php if(form_error('states[]')):?>
							<span class="error message" htmlfor="states" generated="true" style="vertical-align:top"><?php echo form_error('states[]')?></span>
						<?php endif?>					
						<p><?php echo lang('States') ?>:</p>
						<?php foreach ($states as $key => $value):?>
							<li>
								<label  style="text-align: left;">
									<?php echo form_checkbox('states[]', $key,set_checkbox('states',$key,(in_array($key,$banned_states)?TRUE:FALSE)))?>
									<span class="gray italic bold"><?php echo $value?></span>
								</label>
							</li>
						<?php endforeach;?>
					</ul>
					<div class="clear"></div>	
					<div style="text-align: center;">
						<?php echo form_submit('submit', lang('Save'), 'class="red" style="width:206px;"')?>
					</div>			
					<?php echo form_close('')?>
				</div>
				<div class="clear"></div>
				<div class="red_h_sep"></div>
				<div class="white_h_sep"></div>
								
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>