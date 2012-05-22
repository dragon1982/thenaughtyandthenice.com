<div class="container">
	<div class="conthead">
		<h2><?php echo sprintf(lang('Edit %s email templates, file: %s '), $module, $file)?> </h2>
	</div>

	<div class="contentbox">
		
		<div class="center_contentbox" style="width:1000px">
			<?php echo form_open('')?>

				<?php //$this->load->view('includes/_emails_templates_submenu')?>
				<label for="body"><?php echo lang('Email Body')?>: </label>
				<br/>
				<?php echo form_textarea('body', $email_content, 'id="" class="inputbox" style="float:none; width:720px;"')?>
				<br/>
				<span>
					Avaiable variabiles: 
					<?php if(is_array($variabiles)):?>
						<?php foreach($variabiles as $var):?>
							<?php echo $var?>,&nbsp;
						<?php endforeach;?>
					<?php endif?>
				</span>
				<br/>
				<br/>
				<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Save')?>" />
				<?php echo form_close()?>
		</div>
		
	</div>
</div>