<?php $messages = $this->session->flashdata('msg');
if( (isset($messages) && $messages) OR validation_errors() ):	
	if( ! $messages['success'] ):// ERRORS?>
		<div class="status error">
			<?php echo validation_errors('<p><img src="'. assets_url() .'images/icons/icon_error.png" />', '</p>');?>
			<?php if(isset($messages) && $messages):?>	
				<p><img src="<?php echo assets_url()?>images/icons/icon_error.png" /><?php echo $messages['message']?></p>
			<?php endif?>				
		</div>	
	<?php else://success?>
		<div class="status success">
			<p><img src="<?php echo assets_url()?>images/icons/icon_success.png" /><?php echo $messages['message']?></p>
		</div>
	<?php endif?>
<?php endif?>