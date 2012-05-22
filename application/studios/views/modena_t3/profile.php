<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $performers_profile = lang('Performer\'s Profile Page')?>
			<span class="eutemia "><?php echo substr($performers_profile,0,1)?></span><span class="helvetica "><?php echo substr($performers_profile,1)?></span>
		</div>
		<div id="profile">
			<div class="left">
				<div class="red_h_sep"></div>
					<?php echo form_open('')?>
						<div class="gray italic register_performer"  style="text-align: center; ">
						<div>
							<label style="padding-top: 10%; float: left;"><span class="gray italic bold" id="performerTexAlign"><?php echo lang('Description') ?></span></label>
							<?php echo form_textarea('description',set_value('description', $performer->description), 'rows="10" cols="90"')?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('description')?></span>
						</div>
						<div>
							<label style="padding-top: 10%; float: left;"><span class="gray italic bold" id="performerTexAlign"><?php echo lang('What turns me on') ?></span></label>
							<?php echo form_textarea('what_turns_me_on',set_value('what_turns_me_on', $performer->what_turns_me_on), 'rows="10" cols="90"')?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('what_turns_me_on')?></span>
						</div>
						<div>
							<label style="padding-top: 10%; float: left;"><span class="gray italic bold" id="performerTexAlign"><?php echo lang('What turns me off') ?></span></label>
							<?php echo form_textarea('what_turns_me_off',set_value('what_turns_me_off', $performer->what_turns_me_off), 'rows="10" cols="90"')?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('what_turns_me_off')?></span>
						</div>
						<div>
							<label style="padding-top: 1%; float: left;"><span class="gray italic bold" ><?php echo lang('Birthday') ?></span></label>
							<?php echo form_dropdown('day',$days,set_value('day',date('d',$performer->birthday)), 'class="small"')?>
							<?php echo form_dropdown('month',$months,set_value('month',date('m',$performer->birthday)), 'class="small"')?>
							<?php echo form_dropdown('year',$years,set_value('year',date('Y',$performer->birthday)), 'class="small"')?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('birthday')?></span>
						</div>
						<div>
							<label style="padding-top: 1%; float: left;"><span class="gray italic bold"><?php echo lang('Gender') ?></span></label>
							<?php echo form_dropdown('gender',$gender,set_value('gender',$performer->gender))?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('gender')?></span>
						</div>
						<div>
							<label style="padding-top: 1%; float: left;"><span class="gray italic bold"><?php echo lang('Ethnicity') ?></span></label>
							<?php echo form_dropdown('ethnicity',$ethnicity,set_value('ethnicity',$performer->ethnicity))?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('ethnicity')?></span>
						</div>
						<div>
							<label style="padding-top: 1%; float: left;"><span class="gray italic bold"><?php echo lang('Sexual prefference') ?></span></label>
							<?php echo form_dropdown('sexual_prefference',$sexual_prefference,set_value('sexual_prefference',$performer->sexual_prefference))?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('sexual_prefference')?></span>
						</div>
						<div>
							<label style="padding-top: 1%; float: left;"><span class="gray italic bold"><?php echo lang('Height') ?></span></label>
							<?php echo form_dropdown('height',$height,set_value('height',$performer->height))?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('height')?></span>
						</div>
						<div>
							<label style="padding-top: 1%; float: left;"><span class="gray italic bold"><?php echo lang('Weight') ?></span></label>
							<?php echo form_dropdown('weight',$weight,set_value('weight',$performer->weight))?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('weight')?></span>
						</div>
						<div>
							<label style="padding-top: 1%; float: left;"><span class="gray italic bold"><?php echo lang('Hair color') ?></span></label>
							<?php echo form_dropdown('hair_color',$hair_color,set_value('hair_color',$performer->hair_color))?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('hair_color')?></span>
						</div>
						<div>
							<label style="padding-top: 1%; float: left;"><span class="gray italic bold"><?php echo lang('Hair lenght') ?></span></label>
							<?php echo form_dropdown('hair_length',$hair_length,set_value('hair_length',$performer->hair_length))?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('hair_length')?></span>
						</div>
						<div>
							<label style="padding-top: 1%; float: left;"><span class="gray italic bold"><?php echo lang('Eye color') ?></span></label>
							<?php echo form_dropdown('eye_color',$eye_color,set_value('eye_color',$performer->eye_color))?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('eye_color')?></span>
						</div>
						<div>
							<label style="padding-top: 1%; float: left;"><span class="gray italic bold"><?php echo lang('Build') ?></span></label>
							<?php echo form_dropdown('build',$build,set_value('build',$performer->build))?>
							<span class="error message" style="height: 20px; width: 160px; display:inline;"><?php echo form_error('build')?></span>
						</div>	
						<div style="text-align: center;">
							<?php echo form_submit('submit', lang('Save'), 'class="red"')?>
						</div>			
					<?php echo form_close()?>			
				</div>
				<div class="red_h_sep"></div>				
				<div class="white_h_sep"></div>								
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>