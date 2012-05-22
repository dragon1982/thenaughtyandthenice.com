<?php

if( $this->session->flashdata('msg') ):$mesaj = $this->session->flashdata('msg'); ?>
	<?php if(isset($mesaj['type']) && isset($mesaj['message'])):	?>			
			<div class="<?php echo 'status ' . $mesaj['type'] ?>">
				<p>
				<img src="<?php echo assets_url('admin/images/icons/icon_' . $mesaj['type'] . '.png') ?>" />
				<?php echo $mesaj['message']?>
				</p>
			</div>
	<?php endif ?>
<?php endif ?>



<?php 
$errors = validation_errors();
if( ! empty($errors)): ?>
<div class="status error">
	<?php echo validation_errors('<p><img src="'. assets_url('admin/images/icons/icon_error.png') .'" />', '</p>');?>
</div>
<?php endif ?>
