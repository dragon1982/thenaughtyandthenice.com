<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $this->load->view('includes/_head') ?>
	</head>
	<body style="width: 565px;">
		<div id="content_status">
			<div class="content-box-header photo_content">
				<div class="status_name photo_name"><h3><?php echo $photo->title ?></h3></div>
				<div class="photo_box">
					<?php if($photo->is_paid):?>
						<img class="image" src="<?php echo main_url('photo/thumb/'.$photo->photo_id) ?>" />
					<?php else:?>
						<img class="image" src="<?php echo main_url('uploads/performers/'.$photo->performer_id.'/medium/'.$photo->name_on_disk) ?>" />
					<?php endif?>					
					<?php echo form_open('performers/edit_photo/'.$photo->photo_id) ?>
					<!-- TITLE -->
					<div class="inputboxes">
						<?php echo form_input('title', set_value('title', (isset($photo->title)) ? $photo->title : null), 'id="title" class="inputbox medium" tabindex="1" type="text"') ?>
						<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Save title') ?>"/>
						<?php echo form_close() ?>
					</div>
						<?php if( $this->session->flashdata('msg') ):$mesaj = $this->session->flashdata('msg'); ?>
							<?php if(isset($mesaj['type']) && isset($mesaj['message'])): ?>			
							<div id="mesaj_photo" class="<?php echo $mesaj['type'] ?>">
								<span>
									<img src="<?php echo assets_url('admin/images/icons/icon_' . $mesaj['type'] . '.png') ?>" />
									<?php echo $mesaj['message'] ?>
								</span>
							</div>
							<?php endif ?>
						<?php endif ?>
					</div>
			</div>
		</div>
	</body>
</html>