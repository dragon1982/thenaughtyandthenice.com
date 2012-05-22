			<div class="container">
				<div class="conthead">
				<?php $this->load->view('includes/edit_buttons')?>
				</div>

				<div class="contentbox">
					<div class="center_contentbox">
						
						<h2><?php echo lang('Profile information')?></h2>
						
						<?php echo form_open('performers/profile/'. $performer->username)?>

							<!-- GENDER -->
							<div class="inputboxes">
								<label for="gender"><?php echo lang('Gender')?>: </label>
								<?php echo form_dropdown('gender', $gender, set_value('gender',(isset($profile->gender)) ? $profile->gender : null), 'id="gender" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- SEXUAL PREFFERENCE -->
							<div class="inputboxes">
								<label for="sexual_prefference"><?php echo lang('Sexual prefference')?>: </label>
								<?php echo form_dropdown('sexual_prefference', $sexual_prefference, set_value('gender',(isset($profile->sexual_prefference)) ? $profile->sexual_prefference : null), 'id="sexual_prefference" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- ETHNICITY -->
							<div class="inputboxes">
								<label for="ethnicity"><?php echo lang('Ethnicity')?>: </label>
								<?php echo form_dropdown('ethnicity', $ethnicity, set_value('gender',(isset($profile->ethnicity)) ? $profile->ethnicity : null), 'id="ethnicity" class="inputbox" tabindex="1" type="text"')?>
							</div>
							
							<!-- HEIGHT -->
							<div class="inputboxes">
								<label for="height"><?php echo lang('Height')?>: </label>
								<?php echo form_dropdown('height', $height, set_value('gender',(isset($profile->height)) ? $profile->height : null), 'id="height" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- WEIGHT -->
							<div class="inputboxes">
								<label for="weight"><?php echo lang('Weight')?>: </label>
								<?php echo form_dropdown('weight', $weight, set_value('gender',(isset($profile->weight)) ? $profile->weight : null), 'id="weight" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- HAIR COLOR-->
							<div class="inputboxes">
								<label for="hair_color"><?php echo lang('Hair color')?>: </label>
								<?php echo form_dropdown('hair_color', $hair_color, set_value('gender',(isset($profile->hair_color)) ? $profile->hair_color : null), 'id="hair_color" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- HAIR LENGTH -->
							<div class="inputboxes">
								<label for="hair_length"><?php echo lang('Hair length')?>: </label>
								<?php echo form_dropdown('hair_length', $hair_length, set_value('gender',(isset($profile->hair_length)) ? $profile->hair_length : null), 'id="hair_length" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- EYE COLOR-->
							<div class="inputboxes">
								<label for="eye_color"><?php echo lang('Eye color')?>: </label>
								<?php echo form_dropdown('eye_color', $eye_color, set_value('gender',(isset($profile->eye_color)) ? $profile->eye_color : null), 'id="eye_color" class="inputbox" tabindex="1" type="text"')?>
							</div>
							
							<!-- BUILD-->
							<div class="inputboxes">
								<label for="build"><?php echo lang('Build')?>: </label>
								<?php echo form_dropdown('build', $build, set_value('gender',(isset($profile->build)) ? $profile->build : null), 'id="build" class="inputbox" tabindex="1" type="text"')?>
							</div>

							<!-- BIRTHDAY -->
							<div class="inputboxes">
								<label><?php echo lang('Birthday')?>: </label>
									<?php echo form_dropdown('day', $days, set_value('day', (isset($profile->birthday)) ?  date('d', $profile->birthday) : null), 'class="smaller"')?>
									<?php echo form_dropdown('month', $months, set_value('month', (isset($profile->birthday)) ? date('m', $profile->birthday) : null ), 'class="smaller"')?>
									<?php echo form_dropdown('year', $years, set_value('year', (isset($profile->birthday)) ? date('Y', $profile->birthday) : null ), 'class="smaller"')?>
							</div>
							
							<!-- DESCRIPTION -->
							<div class="inputboxes">
								<label for="description"><?php echo lang('Description')?>: </label>
								<?php echo form_textarea('description', set_value('description', (isset($profile->description)) ? $profile->description : null), 'id="description" class="inputbox inputtext" tabindex="1" type="text"')?>
							</div>

							<!-- TURN ON -->
							<div class="inputboxes">
								<label for="what_turns_me_on"><?php echo lang('What turns me on')?>: </label>
								<?php echo form_textarea('what_turns_me_on', set_value('what_turns_me_on', (isset($profile->what_turns_me_on)) ? $profile->what_turns_me_on : null), 'id="what_turns_me_on" class="inputbox inputtext" tabindex="1" type="text"')?>
							</div>

							<!-- TURN OFF -->
							<div class="inputboxes">
								<label for="status"><?php echo lang('What turns me off')?>: </label>
								<?php echo form_textarea('what_turns_me_off', set_value('what_turns_me_off', (isset($profile->what_turns_me_off)) ? $profile->what_turns_me_off : null), 'id="what_turns_me_off" class="inputbox inputtext" tabindex="1" type="text"')?>
							</div>

							<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Update profile')?>" />
						<?php echo form_close()?>	
					</div>
				</div>
			</div>
