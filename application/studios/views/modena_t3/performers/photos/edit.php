<script type="text/javascript">
    function confirm_delete() {
        if (confirm("<?php echo lang('Are you sure you want to delete this photo?')?>")) {
            window.location.replace('<?php echo site_url('performers/photos/delete/'.$photo->photo_id)?>');
        }
    }
</script>
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $edit_photo_title = lang('Edit Photo') ?>
			<span class="eutemia "><?php echo substr($edit_photo_title,0,1)?></span><span class="helvetica "><?php echo substr($edit_photo_title,1)?></span>
		</div>
		<div id="photo">
            <?php echo form_open(current_url())?>
			<div class="gray italic register_performer">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Photo title') ?></span></label>
					<?php echo form_input('title', $photo->title)?>
					<span class="error message" htmlfor="title" generated="true" ><?php echo form_error('title')?></span>
				</div>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Gallery') ?></span></label>
					<?php echo form_dropdown('is_paid',$is_paid,set_value('is_paid',$photo->is_paid))?>
					<span class="error message" htmlfor="title" generated="true" ><?php echo form_error('is_paid')?></span>
				</div>
				<div style="margin-left:223px;">
					<?php echo form_submit('submit', lang('Save'),'class="red" style="width:97px;"')?>
					<?php echo form_button(array('id' => 'delete-bttn', 'class'=>'red', 'content' => 'Delete', 'onclick' => 'confirm_delete()', 'style' => 'width:97px;'))?>
				</div>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>
</div></div><div class="black_box_bg_bottom"></div>