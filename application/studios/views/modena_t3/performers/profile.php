<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $performer_profile_page = lang('Perfomer\'s Profile Page')?>
			<span class="eutemia"><?php echo substr($performer_profile_page,0,1)?></span><span class="helvetica"><?php echo substr($performer_profile_page,1)?></span>
		</div>
		<div id="profile">
			<div class="left">
				<div class="red_h_sep"></div>
					<?php echo form_open()?>
						<div class="gray italic register_performer">
						<div>
							<label style="float: left;"><span class="gray italic bold" id="performerTexAlign"><?php echo lang('Description') ?>:</span></label>
							<?php echo form_textarea('description',set_value('description', (isset($performer->description)) ? $performer->description : null), 'rows="10" cols="90" style="overflow:hidden;"')?>
							<span class="error message" htmlfor="description" generated="true"><?php echo form_error('description')?></span>
						</div>
						<div>
							<label style="float: left;"><span class="gray italic bold" id="performerTexAlign"><?php echo lang('What turns me on') ?>:</span></label>
							<?php echo form_textarea('what_turns_me_on',set_value('what_turns_me_on', (isset($performer->what_turns_me_on)) ? $performer->what_turns_me_on : null), 'rows="10" cols="90" style="overflow:hidden;"')?>
							<span class="error message" htmlfor="what_turns_me_on" generated="true"><?php echo form_error('what_turns_me_on')?></span>
						</div>
						<div>
							<label style="float: left;"><span class="gray italic bold" id="performerTexAlign"><?php echo lang('What turns me off') ?>:</span></label>
							<?php echo form_textarea('what_turns_me_off',set_value('what_turns_me_off', (isset($performer->what_turns_me_off)) ? $performer->what_turns_me_off : null), 'rows="10" cols="90" style="overflow:hidden;"')?>
							<span class="error message" htmlfor="what_turns_me_off" generated="true"><?php echo form_error('what_turns_me_off')?></span>
						</div>
						<div>
							<label style="float: left;"><span class="gray italic bold"><?php echo lang('Birthday') ?>:</span></label>
							<?php echo form_dropdown('day',$days,set_value('day', (isset($performer->birthday)) ?  date('d',$performer->birthday) : null), 'class="small"')?>
							<?php echo form_dropdown('month',$months,set_value('month', (isset($performer->birthday)) ? date('m',$performer->birthday) : null ), 'class="small"')?>
							<?php echo form_dropdown('year',$years,set_value('year', (isset($performer->birthday)) ? date('Y',$performer->birthday) : null ), 'class="small"')?>
							<span class="error message" htmlfor="birthday" generated="true"><?php echo form_error('year')?></span>
						</div>
						<div>
							<label style="float: left;"><span class="gray italic bold"><?php echo lang('Gender') ?>:</span></label>
							<?php echo form_dropdown('gender',$gender,set_value('gender', (isset($performer->gender)) ? $performer->gender : null))?>
							<span class="error message" htmlfor="gender" generated="true"><?php echo form_error('gender')?></span>
						</div>
						<div>
							<label style="float: left;"><span class="gray italic bold"><?php echo lang('Ethnicity') ?>:</span></label>
							<?php echo form_dropdown('ethnicity',$ethnicity,set_value('ethnicity', (isset($performer->ethnicity)) ? $performer->ethnicity : null))?>
							<span class="error message" htmlfor="ethnicity" generated="true"><?php echo form_error('ethnicity')?></span>
						</div>
						<div>
							<label style="float: left;"><span class="gray italic bold"><?php echo lang('Sexual prefference') ?>:</span></label>
							<?php echo form_dropdown('sexual_prefference',$sexual_prefference,set_value('sexual_prefference', (isset($performer->sexual_prefference)) ? $performer->sexual_prefference : null))?>
							<span class="error message" htmlfor="sexual_prefference" generated="true"><?php echo form_error('sexual_prefference')?></span>
						</div>
						<div>
							<label style="float: left;"><span class="gray italic bold"><?php echo lang('Height') ?>:</span></label>
							<?php echo form_dropdown('height',$height,set_value('height', (isset($performer->height)) ? $performer->height : null))?>
							<span class="error message" htmlfor="height" generated="true"><?php echo form_error('height')?></span>
						</div>
						<div>
							<label style=" float: left;"><span class="gray italic bold"><?php echo lang('Weight') ?>:</span></label>
							<?php echo form_dropdown('weight',$weight,set_value('weight', (isset($performer->weight)) ? $performer->weight : null))?>
							<span class="error message" htmlfor="weight" generated="true"><?php echo form_error('weight')?></span>
						</div>
						<div>
							<label style=" float: left;"><span class="gray italic bold"><?php echo lang('Hair color') ?>:</span></label>
							<?php echo form_dropdown('hair_color',$hair_color,set_value('hair_color', (isset($performer->hair_color)) ? $performer->hair_color : null))?>
							<span class="error message" htmlfor="hair_color" generated="true"><?php echo form_error('hair_color')?></span>
						</div>
						<div>
							<label style=" float: left;"><span class="gray italic bold"><?php echo lang('Hair lenght') ?>:</span></label>
							<?php echo form_dropdown('hair_length',$hair_length,set_value('hair_length', (isset($performer->hair_length)) ? $performer->hair_length : null ))?>
							<span class="error message" htmlfor="hair_length" generated="true"><?php echo form_error('hair_length')?></span>
						</div>
						<div>
							<label style=" float: left;"><span class="gray italic bold"><?php echo lang('Eye color') ?>:</span></label>
							<?php echo form_dropdown('eye_color',$eye_color,set_value('eye_color', (isset($performer->eye_color)) ? $performer->eye_color : null))?>
							<span class="error message" htmlfor="eye_color" generated="true"><?php echo form_error('eye_color')?></span>
						</div>
						<div>
							<label style=" float: left;"><span class="gray italic bold"><?php echo lang('Cup size') ?>:</span></label>
							<?php echo form_dropdown('cup_size',$cup_size,set_value('cup_size',(isset($performer->cup_size)) ? $performer->cup_size : null))?>
							<span class="error message" htmlfor="cup_size" generated="true"><?php echo form_error('cup_size')?></span>
						</div>						
						<div>
							<label style=" float: left;"><span class="gray italic bold"><?php echo lang('Build') ?>:</span></label>
							<?php echo form_dropdown('build',$build,set_value('build', (isset($performer->build)) ? $performer->build : null))?>
							<span class="error message" htmlfor="build" generated="true"><?php echo form_error('build')?></span>
						</div>	
						<div style="margin-left:223px;">
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