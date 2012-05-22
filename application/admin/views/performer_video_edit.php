<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $this->load->view('includes/_head') ?>
	</head>
		<script type="text/javascript">
			jQuery(function($){
				if($('#type').val() == 1){
					$('#price').show();
				} else {
					$('#price').hide();						
				}

				$('#type').change(function(){
					if($('#type').val() == 1){
						$('#price').show();
					} else {
						$('#price').hide();						
					}						
				});
			});
		</script>
	<body style="width: 565px;">
		<div id="content_status">
			<div class="content-box-header photo_content">
				<div class="status_name photo_name"><h3><?php echo $video->description?></h3></div>
				<div class="photo_box">
					<?php echo form_open('performers/edit_video/'.$video->video_id) ?>
					<!-- TITLE -->
					<div class="inputboxes" style="width:382px;">
						<label class="details"><?php echo lang('Description')?>: </label>									
						<?php echo form_input('description', set_value('description', (isset($video->description)) ? $video->description : null), 'id="title" class="inputbox small" tabindex="1" type="text"') ?>									
					</div>
					<div class="inputboxes" style="width:382px;">
						<label class="details"><?php echo lang('Is Paid')?>: </label>									
						<?php echo form_dropdown('type',$types,set_value('type',$video->is_paid),'id="type"')?>
					</div>		
					<div class="inputboxes" style="display:none;width:382px;" id="price">
						<label class="details"><?php echo lang('Price')?>: </label>									
						<?php echo form_input('price',set_value('price',$video->price),'class="inputbox small" tabindex="1"')?>					
					</div>
					<input class="btn" type="submit" tabindex="3" value="<?php echo lang('Save description') ?>"/>
					

					<?php echo form_close() ?>			
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