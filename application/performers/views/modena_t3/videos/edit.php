<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $edit_video_title = lang('Edit Video') ?>
			<span class="eutemia"><?php echo substr($edit_video_title,0,1)?></span><span class="helvetica"><?php echo substr($edit_video_title,1)?></span>
		</div>
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
		<div id="photo">
            <?php echo form_open()?>
			<div class="gray italic register_performer">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Description') ?></span></label>
					<?php echo form_input('description', $video->description)?>
					<span class="error message" htmlfor="title" generated="true" ><?php echo form_error('description')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php  echo lang('Type') ?></span></label>
					<?php echo form_dropdown('type',$types,set_value('type',$video->is_paid),'id="type"')?>
					<span class="error message" htmlfor="title" generated="true" ><?php echo form_error('type')?></span>
				</div>
				<div style="display:none" id="price">
					<label><span class="gray italic bold"><?php  echo lang('Price') ?></span></label>
					<?php echo form_input('price',set_value('price',$video->price))?>
					<span class="error message" htmlfor="title" generated="true" ><?php echo form_error('price')?></span>
				</div>
                <?php echo form_submit('submit', lang('Save'),'class="red"')?>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>
</div></div><div class="black_box_bg_bottom"></div>