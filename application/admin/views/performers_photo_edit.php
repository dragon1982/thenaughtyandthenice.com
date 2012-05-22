<script type="text/javascript">
$(document).ready(function(){	
	$(".iframe").fancybox({
		'height'			: 460,
		'scrolling'			: 'no',
		'transitionIn'		: 'fade',
		'transitionOut'		: 'fade',
		'type'				: 'iframe',
		'onClosed'			: function() {
							  		parent.location.reload(false);
							  }
	});

	$("a[rel=thumbs]").fancybox({
		'transitionIn'		: 'none',
		'type' 				: 'image',
		'transitionOut'		: 'none',
		'titlePosition' 	: 'over',
		'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
		    return '<span id="fancybox-title-over">Image ' +  (currentIndex + 1) + ' / ' + currentArray.length + ' ' + title + '</span>';
		}
	});	
});
</script>
<div class="container">
	<div class="conthead">
		<?php $this->load->view('includes/edit_buttons') ?>
	</div>
	<div class="contentbox">
		<div class="center_contentbox photo_center_box">			
			<h2><?php echo lang('Performer Photos') ?></h2>			
			<div class="full_photo_container">
				<?php if( ! empty($photos)): ?>
	           		<?php foreach($photos as $photo): ?>
	                	<div class="photo">
	                		<div class="title">
	                			<?php echo $photo->title ?>
	                		</div>
	                   		<?php if($photo->is_paid):?>
	                   			<a rel="thumbs" href="<?php echo main_url('photo/'.$photo->photo_id)?>"  title="<?php echo $photo->title?>">
	                   				<img src="<?php echo main_url('photo/thumb/'.$photo->photo_id) ?>" />
	                   			</a>
	                   		<?php else:?>
	                   			<a rel="thumbs" href="<?php echo main_url('uploads/performers/'.$photo->performer_id.'/'.$photo->name_on_disk)?>" title="<?php echo $photo->title?>">
	                   				<img src="<?php echo main_url('uploads/performers/'.$photo->performer_id.'/small/'.$photo->name_on_disk) ?>" />
	                   			</a>
	                   		<?php endif?>
	                    	<div class="small_button_cont">
	                    		<a href="<?php echo site_url('performers/edit_photo/'.$photo->photo_id) ?>" class="iframe"><img class="photo_icons" src="<?php echo assets_url('admin/images/icons/icon_edit.png') ?>"/></a>
	                    		<a href="<?php echo site_url('performers/delete_photo/'.$photo->photo_id) ?>" onclick="javascript:return confirm('<?php echo lang('Are you sure you want to delete this photo?')?>');"><img class="photo_icons" src="<?php echo assets_url('admin/images/icons/icon_unapprove.png') ?>"/></a>	                    	</div>
	                	</div>
	            	<?php endforeach ?>
	            <?php else: ?>
	            	<span><?php lang('This performer has no uploaded photos.')?></span>
	            <?php endif ?>
	            <div class="photo_pagination"><?php echo $pagination ?></div>
			</div>			
		</div>
	</div>
</div>