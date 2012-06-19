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







                        	<div class="box-header-2">
                            	<h2 class="title1">My photos</h2>
                            </div>

<?php if ($photos): ?>
                            <section class="photos-section">
                            	<h3 class="box-header-3"><?php echo lang('Free gallery')?></h3>
														<?php if(isset($photos[0])):?>
                                    <div id="free" class="photos-list clearfix">
																			<?php foreach ($photos as $photo): ?>
                                        <div class="photo-item">
																		        <a class="thumb" rel="my_photos" title="<?php echo $photo->title?>" href="<?php echo main_url('uploads/performers/' . $performer->id .'/' . $photo->name_on_disk)?>">
			        																<img src="<?php echo main_url('uploads/performers/' . $performer->id .'/small/' . $photo->name_on_disk)?>" title="<?php echo $photo->title?>" />
																						</a>
                                            <div class="photo-item-decoration"><!-- --></div>
                                            <div class="photo-desc"><?php echo $photo->title?></div>
                                        </div>
																			<?php endforeach;	?>
                                    </div><!--end photos-list-->

                                    <ul class="pagination set-bott-1" style="margin-left:230px;">
                                      <li class="unavailable"><a href="">&laquo;</a></li>
                                      <li class="current"><a href="">1</a></li>
                                      <li><a href="">2</a></li>
                                      <li><a href="">3</a></li>
                                      <li><a href="">&raquo;</a></li>
                                    </ul>
														<?php else:?>
															<div class="no-content">No photos</div>
														<?php endif;?>
														</section><!--end latest-photos-->


                            <section class="photos-section">
                            	<h3 class="box-header-3"><?php echo lang('Paid gallery')?></h3>
															<?php if(isset($photos_paid[0])):?>
                                    <div id="paid_gal" class="photos-list clearfix">
																			<?php foreach ($photos_paid as $photo): ?>
                                        <div class="photo-item">
																			      <a <?php echo (($has_paid)?'class="thumb" rel="my_paid"':(($this->user->id > 0)?'class="pay_gallery thumb"':'class="signup thumb"'))?> title="<?php echo $photo->title?>" href="<?php echo ($has_paid)?main_url('photo/' . $photo->photo_id):main_url('buy-access/' . $performer->id. '?rand=' . mt_rand(10000,99999))?>">
																			      	<img src="<?php echo main_url('photo/thumb/' . $photo->photo_id . '?rand=' . mt_rand(10000,99999))?>" title="<?php echo $photo->title?>" />
																						</a>
                                            <div class="photo-item-decoration"><!-- --></div>
                                            <div class="photo-desc"><?php echo $photo->title?></div>
                                        </div>
																			<?php endforeach;	?>
                                    </div><!--end photos-list-->

                                    <ul class="pagination set-bott-1" style="margin-left:230px;">
                                      <li class="unavailable"><a href="">&laquo;</a></li>
                                      <li class="current"><a href="">1</a></li>
                                      <li><a href="">2</a></li>
                                      <li><a href="">3</a></li>
                                      <li><a href="">&raquo;</a></li>
                                    </ul>
														<?php else:?>
															<div class="no-content">No photos</div>
														<?php endif;?>
														</section><!--end latest-photos-->
<?php else: ?>
	<div class="error_mess"><?php echo lang('This performer has not uploaded any pictures') ?>.</div>
<?php endif ?>