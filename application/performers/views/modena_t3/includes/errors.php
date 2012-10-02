<?php $messages = $this->session->flashdata('msg');
if( (isset($messages) && $messages) ):	
	if( ! isset($messages['success']) ):// ERRORS?>
		<div class="status error">
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