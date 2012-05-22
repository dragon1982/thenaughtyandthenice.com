<div class="container">
	<div class="conthead">
		<h2><?php echo $page_title?> </h2>
	</div>

	<div class="contentbox">
		
		<div class="center_contentbox" style="width:1000px">
			<?php echo form_open()?>

				<?php //$this->load->view('includes/_emails_templates_submenu')?>
				<label for="body"><?php echo lang('Analytics code')?>: </label>
				<br/>
				<?php echo form_textarea('code', $code, 'id="" class="inputbox" style="float:none; width:720px;"')?>
				<br/>
				<br/>
				<br/>
				<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Save')?>" />
				<?php echo form_close()?>
		</div>
		
	</div>
</div>