<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.pajinate.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.opacityrollover.js"></script>	
<script type="text/javascript">
jQuery(function($) {										// Initially set opacity on thumbs and add
	// additional styling for hover effect on thumbs
	var onMouseOutOpacity = 0.67;
	$('#photos .photo').opacityrollover({
		mouseOutOpacity:   onMouseOutOpacity,
		mouseOverOpacity:  1.0,
		fadeSpeed:         'fast',
		exemptionSelector: '.selected'
	});

	$('#free').pajinate({
		items_per_page : 24,		
		nav_panel_id : '.pagination',	
		item_container_id : '.mylist'
						
	});		

	$('#paid_gal').pajinate({
		items_per_page : 24,		
		nav_panel_id : '.pagination',	
		item_container_id : '.mylist'
						
	});	
			
	$("a[rel=my_photos], a[rel=my_paid]").fancybox({
		'transitionIn'		: 'none',
		'type' 				: 'image',
		'transitionOut'		: 'none',
		'titlePosition' 	: 'over',
		'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
		    return '<span id="fancybox-title-over">Image ' +  (currentIndex + 1) + ' / ' + currentArray.length + ' ' + title + '</span>';
		}
	});

	<?php 
		$open_paid_gal = $this->session->flashdata('open_modal_pictures');
		if($open_paid_gal):
	?>
			$("a[rel=my_paid]").fancybox({
				'transitionIn'		: 'none',
				'type' 				: 'image',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
				    return '<span id="fancybox-title-over">Image ' +  (currentIndex + 1) + ' / ' + currentArray.length + ' ' + title + '</span>';
				}
			}).trigger('click');
	<?php endif?>					
});
</script>
<div id="photos">
<?php if ($photos): ?>
	<h2><?php echo lang('Free gallery')?></h2>	
	<div id="free" style="width:966px; margin-left:-20px;">
		<div class="mylist">	
			<?php foreach ($photos as $photo): ?>
				<div class="photo">
			        <a class="thumb" rel="my_photos" title="<?php echo $photo->title?>" href="<?php echo main_url('uploads/performers/' . $performer->id .'/' . $photo->name_on_disk)?>">
			        	<img src="<?php echo main_url('uploads/performers/' . $performer->id .'/small/' . $photo->name_on_disk)?>" title="<?php echo $photo->title?>" />        
					</a>
					<span><?php echo $photo->title?></span>			
		       </div>
			<?php endforeach ?>
		</div>
		<div style="clear:both"></div>
    	<div class="bottom pagination" id="pagination"></div>
	</div>	

	<div class="clear"></div>
	<?php if(sizeof($photos_paid) > 0):?>		
		<h2><?php echo lang('Paid gallery')?></h2>	
		<div id="paid_gal"  style="width:966px; margin-left:-20px;">
			<div class="mylist">
				<?php foreach ($photos_paid as $photo): ?>
					<div class="photo">
				        <a <?php echo (($has_paid)?'class="thumb" rel="my_paid"':(($this->user->id > 0)?'class="pay_gallery thumb"':'class="signup thumb"'))?> title="<?php echo $photo->title?>" href="<?php echo ($has_paid)?main_url('photo/' . $photo->photo_id):main_url('buy-access/' . $performer->id. '?rand=' . mt_rand(10000,99999))?>">
				        	<img src="<?php echo main_url('photo/thumb/' . $photo->photo_id . '?rand=' . mt_rand(10000,99999))?>" title="<?php echo $photo->title?>" />        
						</a>
						<span><?php echo $photo->title?></span>			
			       </div>
				<?php endforeach ?>
			</div>
			<div style="clear:both"></div>
	    	<div class="bottom pagination" id="pagination"></div>			
		</div>		
	<?php endif?>	
<?php else: ?>
	<div class="error_mess"><?php echo lang('This performer has not uploaded any pictures') ?>.</div>
<?php endif ?>
</div>
