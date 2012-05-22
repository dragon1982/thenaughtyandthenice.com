<script type="text/javascript">
    function confirm_delete(id) {
        if (confirm("<?php echo lang('Are you sure you want to delete this photo?')?>")) {
            window.location.replace('<?php echo site_url('photos/delete')?>/'+id);
        }
    }
	
	function set_avatar(elem, photo_name, photo_id){
		$.ajax({
            url: "<?php echo site_url('photos/set_avatar')?>",
            type: 'post',
            dataType: "json",
            data: {'photo_name': photo_name, 'photo_id':photo_id, 'ci_csrf_token': '<?php echo $this->security->_csrf_hash?>'},
            success: function(response) {
				if(response.success){
					$(elem).find('img').attr('src', '<?php echo assets_url()?>images/icons/approved.png');
					$(elem).attr('title', '<?php echo lang('Avatar was set!')?>');
				}else{
					$(elem).find('img').attr('src', '<?php echo assets_url()?>images/icons/rejected.png');
					$(elem).attr('title', response.message);
				}
            }
        });
	}
	
	$(document).ready(function(){
	
		$('.photo').hover(
			function(){
				$(this).find('.buttons').css('display', 'block');
			},
			function(){
				$(this).find('.buttons').css('display', 'none');
			}
		)	
	});
	
	
</script>
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $my_photos_title = lang('My Photos')?>
			<span class="eutemia"><?php echo substr($my_photos_title,0,1)?></span><span class="helvetica"><?php echo substr($my_photos_title,1)?></span>
		</div>        
		<a href="<?php echo site_url('photos/add')?>" style="float:right"><?php echo form_button('add', lang('Add Photo'),'class="red"')?></a>
        
		<div id="photos" style="width:650px; margin:0px auto;">		
			<h2><?php echo lang('Free photos')?></h2>
            <?php foreach($photos as $photo):?>
                <div class="photo">
                    <a href="<?php echo main_url('uploads/performers/' . $this->user->id . '/' . $photo->name_on_disk)?>" rel="free_gallery"><img src="<?php echo main_url('/uploads/performers/' . $this->user->id . '/small/' . $photo->name_on_disk)?>" /></a>
                    <span><a href="<?php echo site_url('photos/edit/'.$photo->photo_id)?>"><?php echo $photo->title?></a></span>
					<div class="buttons">
						<?php if( ! $photo->main_photo):?>
							<a><span title="<?php echo lang('Set as Avatar')?>" class="edit" onclick="set_avatar(this, '<?=$photo->name_on_disk?>', '<?php echo $photo->photo_id?>');"><img src="<?=assets_url()?>images/icons/avatar.png"></span></a>
						<?php endif?>
						<a title="Edit" href="<?php echo site_url('photos/edit/'.$photo->photo_id)?>"><span class="edit"><img src="<?php echo assets_url()?>images/icons/edit.png"></span></a>
						<?php if( ! $photo->main_photo):?>
							<a title="Delete"><span class="delete" onclick="confirm_delete('<?=$photo->photo_id?>')"><img src="<?php echo assets_url()?>images/icons/rejected.png"></span></a>
						<?php endif?>
					</div>
                </div>
            <?php endforeach?>
            <?php if(sizeof($paid_photos) > 0):?>
            	<div style="clear:both"></div>
				<h2><?php echo lang('Paid photos')?></h2>
	            <?php foreach($paid_photos as $photo):?>

					<div class="photo">
				        <a href="<?php echo main_url('photo/' . $photo->photo_id)?>" rel="paid_gallery">
				        	<img src="<?php echo main_url('photo/thumb/' . $photo->photo_id)?>"/>        
						</a>
						<span><?php echo $photo->title?></span>		
						<div class="buttons">
							<a title="<?php echo lang('Edit')?>" href="<?php echo site_url('photos/edit/'.$photo->photo_id)?>"><span class="edit"><img src="<?php echo assets_url()?>images/icons/edit.png"></span></a>
							<a title="<?php echo lang('Delete')?>"><span class="delete" onclick="confirm_delete('<?php echo $photo->photo_id?>')"><img src="<?php echo assets_url()?>images/icons/rejected.png"></span></a>
						</div>
			       </div>	                
	            <?php endforeach?>
			<?php endif?>            
		</div>
        <div class="clear"></div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>