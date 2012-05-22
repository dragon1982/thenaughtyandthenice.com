<div class="details">
	<div class="col italic">
		<span class="name"><?php echo lang('Nickname') ?>:</span><span class="value gray"><?php echo $performer->nickname?></span>
		<span class="name"><?php echo lang('Height') ?>:</span><span class="value gray"><?php echo $performer->height?></span>
		<span class="name"><?php echo lang('Age') ?>:</span><span class="value gray"><?php echo floor((time() - $performer->birthday)/31556926);?></span>
		<span class="name"><?php echo lang('Hair color') ?>:</span><span class="value gray"><?php echo $performer->hair_color?></span>
		<span class="name"><?php echo lang('Ethnicity') ?>:</span><span class="value gray"><?php echo $performer->ethnicity?></span>
		<span class="name"><?php echo lang('Cup size') ?>:</span><span class="value gray"><?php echo $performer->cup_size?></span>
	</div>
	<div class="col italic">
		<span class="name"><?php echo lang('Gender') ?>:</span><span class="value gray"><?php echo $performer->gender?></span>
		<span class="name"><?php echo lang('Weight') ?>:</span><span class="value gray"><?php echo $performer->weight?></span>
		<span class="name"><?php echo lang('Eye color') ?>:</span><span class="value gray"><?php echo $performer->eye_color?></span>
		<span class="name"><?php echo lang('Language') ?>:</span><span class="value gray">
		<?php foreach($languages as $language): ?>				
			<img src="<?php echo assets_url()?>images/flags/<?php echo strtoupper($language)?>.png">
		<?php endforeach;?>
		</span>
		<span class="name"><?php echo lang('Body build') ?>:</span><span class="value gray"><?php echo $performer->build;?></span>
	</div>
	<div class="clear"></div>
</div>

<div class="white_h_sep"></div>

<div class="details italic" style="margin-top:10px;">
	
	<span class="italic bold name" style="display:inline-block; width:130px; vertical-align: top; margin:10px 0;"><?php echo lang('Profile description :')?></span>
	<span class="value gray" style="display:inline-block; width:400px; margin:10px 0;"><?php echo $performer->description?></span>
	
	
	<span class="italic bold name" style="display:inline-block; width:130px; vertical-align: top; margin:10px 0;"><?php echo lang('What turns me on :')?></span>
	<span class="value gray" style="display:inline-block; width:400px; margin:10px 0;"><?php echo $performer->what_turns_me_on?></span>
	
	
	<span class="italic bold name" style="display:inline-block; width:130px; vertical-align: top; margin:10px 0;"><?php echo lang('What turns me off :')?></span>
	<span class="value gray" style="display:inline-block; width:400px; margin:10px 0;"><?php echo $performer->what_turns_me_off?></span>
	
</div>