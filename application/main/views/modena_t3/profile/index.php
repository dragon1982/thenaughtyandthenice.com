<!-- lightbox-->
<link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>css/jquery.lightbox-0.5.css" />
<script type="text/javascript" src="<?php echo assets_url() ?>js/jquery.lightbox-0.5.min.js"></script>
<script src="<?php echo assets_url() ?>js/jquery.ui.stars.min.js"></script>
<!-- jQuery rating -->

<script type="text/javascript">
	var pictures_offset = 0,
    pictures_limit  = 8;

	function load_prev() {
		pictures_offset -= pictures_limit;
		load_pictures(pictures_limit, pictures_offset);
	}

	function load_next() {
		pictures_offset += pictures_limit;
		load_pictures(pictures_limit, pictures_offset);
	}

	$(document).ready(function() {

	//When page loads...
	$("div.btn div:first").addClass("active").show(); //Activate first tab

		$('.menu_item').click(function(){
			$('.slide').hide();
			$('#'+$(this).attr('id') + '_content').show();
			if($(this).attr('id') != 'profile'){
				$('#reviews').hide();
			}else{
				$('#reviews').show();
			}

			if($(this).attr('id') == 'pictures' || $(this).attr('id') == 'videos'){
				$('.right').hide();
			}else{
				$('.right').show();
			}
				var warpper_min_height = $(window).height() -115;

				var new_min_height = $('#'+$(this).attr('id') + '_content').height() + 155;

				if(warpper_min_height < new_min_height){
					warpper_min_height = new_min_height;
				}


				var content_height = $('#'+$(this).attr('id') + '_content').height();
				var min_content_height = warpper_min_height - $('#header').height() - 55;
				if(content_height < min_content_height){
					content_height = min_content_height;

				}

				$('#warpper').css('min-height', warpper_min_height);
				$('.black_box .content').css('min-height',content_height);
		});

		$('.send_message').click(function(){
			$('.slide').hide();
			$('#contact_content').show();
		});

		$(".stars").stars({
			cancelShow: false,
			disabled: true,
			split: 4,
			callback: function(ui, type, value) {
				$.ajax({
					url: "<?php echo site_url('performers/rate') ?>",
					type: "post",
					data: {
						performer_id: <?php echo $performer->id ?>,
						rating:       value
					}
				});
			}
		});

	});
</script>


            <article class="set-bott-1">

                <header class="box-header clearfix">
                    <h1 class="article-title left"><?php echo $performer->nickname?></h1>
                    <nav class="model-nav right">
                    	<ul>
                        	<li id="profile" class="selected"><a class="ico-profile" href="javascript:;"><span><?php echo lang('My Profile') ?></span></a></li>
                          <li id="pictures"><a class="ico-photos" href="javascript:;"><span><?php echo sprintf(lang('My Photos (%s)'),(count($photos)+count($photos_paid)))?></span></a></li>
                          <li id="videos"><a class="ico-videos" href="javascript:;"><span><?php echo sprintf(lang('My Videos (%s)'),(count($videos) + count($videos_paid)))?></span></a></li>
                          <li id="schedule"><a class="ico-schedule" href="javascript:;"><span><?php echo lang('Schedule') ?></span></a></li>
                          <li id="contact"><a class="ico-contact" href="javascript:;"><span><?php echo lang('Contact') ?></span></a></li>
                      </ul>
                    </nav>
                </header><!--end box-header-->


                <div class="profile clearfix">

                		<div class="profile-left-col">
                    	<div class="box-t1 set-bott-2">
                        	<a href="javscript:;">
                        		<img src="<?php echo ($performer->avatar != '') ? main_url('uploads/performers/' . $performer->id . '/medium/' . $performer->avatar) : assets_url().'images/poza_tarfa_medium.jpg'?>" alt="" width="178">
                        	</a>

													<?php if(isset($rating)):?>
													<div class="rate">
														<div class="stars">
															<?php $rating = round($rating * 4);
															for ($i = 0; $i < 21; $i++):?>
																<?php if ($i == $rating):?>
																	<input name="rating" type="radio" class="star" value="<?php echo $i/4?>" checked="checked"/>
																<?php else:?>
																	<input name="rating" type="radio" class="star" value="<?php echo $i/4?>"/>
																<?php endif?>
															<?php endfor?>
														</div>
														<span class="bold">
															<?php if ($ratings_count == 1): ?>
																<?php echo lang('1 vote')?>
															<?php else:?>
																<?php echo sprintf(lang('%s votes'),$ratings_count)?>
															<?php endif?>
														</span>
													</div>
													<?php endif?>

                        </div><!-- end box-t1 -->
                        <?php if($this->user->id > 0):?>
                        <a class="btn-nice-3 set-bott-2 send_message" href="javascript:;"><span class="ico-messages"><?php echo lang('send message')?></span></a>
                        <?php endif;?>
                        <a class="btn-nice-3 set-bott-2" href="javascript:;"><span class="ico-add-friend">Add friend</span></a>
                        <a class="btn-nice-3 set-bott-2" href="<?php echo site_url(($favorite)? 'remove-favorite/' . $performer->nickname : 'add-favorite/' . $performer->nickname)?>">
                        	<span class="ico-add-favorite"><?php echo ( ! $favorite)?lang('add favorite'):lang('remove favorite')?></span>
                        </a>

												<?php $buttons =  $this->performers->display_buttons($performer)?>
												<?php $i = 0;?>
												<?php foreach($buttons as $key => $button):?>
													<?php if($key == 'my_profile') continue?>
													<?php $res = (in_array($key,array('nude_chat','peek_chat','private_chat'))?(($this->user->id > 0)?1:2):0)?>
													<a href="<?php echo $button['link']?>"<?php echo (($res==1)?' ':(($res==2)?' class="signup"':NULL))?>><button class="<?php echo ($res > 0 && ! $i )?'red':'black'?> up f10" style="width:150px;margin-bottom:5px"><?php echo $button['name']?></button></a>
													<?php if($res > 0) $i=1?>
												<?php endforeach?>

                    </div><!--end profile-left-col -->

                    <div class="profile-right-col">
                    	<div class="box-t1">

												<?php $tabs = profile_menu_display() ?>
												<div id="profile_content" <?php echo ($tabs['profile'])?NULL:'style="display:none"'?> class="slide">
													<?php $this->load->view('profile/details') ?>
												</div>
												<div id="pictures_content" <?php echo ($tabs['pictures'])?NULL:'style="display:none"'?> class="slide">
													<?php $this->load->view('profile/photos') ?>
												</div>
												<div id="videos_content" <?php echo ($tabs['videos'])?NULL:'style="display:none"'?> class="slide">
													<?php $this->load->view('profile/videos') ?>
												</div>
												<div id="schedule_content" <?php echo ($tabs['schedule'])?NULL:'style="display:none"'?> class="slide">
													<?php $this->load->view('profile/schedule') ?>
												</div>
												<div id="contact_content" <?php echo ($tabs['contact'])?NULL:'style="display:none"'?> class="slide">
													<?php if ($this->user->id > 0)://Verific daca userul e logat pentru a putea trimite mesaje?>
														<?php $this->load->view('profile/contact'); ?>
													<?php else: ?>
														<br /><div class="error_mess"><img class="login_lock" src="<?php echo assets_url() ?>images/lock.png" alt=""/><?php echo lang('You must be logged in to use this feature.') ?></div>
													<?php endif; ?>
												</div>

                      </div><!--end box-t1-->
                    </div><!--end profile-right-col -->

										<?php if (is_array($reviews) && count($reviews) > 0): ?>
											<div id="reviews"<?php echo (! $tabs['profile'])?'style="display:none"':NULL?>>

												<div class="title">
													<?php $_perf_profile_page = 'User\'s reviews' ?>
													<div><span class="eutemia "><?php echo substr($_perf_profile_page, 0, 1) ?></span><span class="helvetica "><?php echo substr($_perf_profile_page, 1) ?></span></div>
												</div>
												<div class="clear"></div>

												<?php foreach ($reviews as $review): ?>
													<div class="review_item">
														<div class="white_h_sep"><img src="<?php echo assets_url() ?>images/white_line_sep.png" width="100%" height="1" /></div>
														<div class="stars">
															<?php $review->rating = round($review->rating * 4);
															for ($i = 0; $i < 21; $i++): ?>
																<?php if ($i == $review->rating): ?>
																	<input name="rating" type="radio" class="star" value="<?php echo $i / 4 ?>" checked="checked"/>
																<?php else: ?>
																	<input name="rating" type="radio" class="star" value="<?php echo $i / 4 ?>"/>
																<?php endif ?>
															<?php endfor ?>
														</div>
														<div class="title">
															<?php echo $review->user ?>
															<span class="gray"> on <?php echo date('d M Y H:i', $review->add_date) ?></span>
														</div>
														<div class="clear"></div>
														<div class="comment gray"><?php echo $review->message ?></div>

													</div>
												<?php endforeach ?>
												<div id="pagination">
													<?php echo $pagination ?>
												</div>
												<div style="clear:both"></div>
											</div>
										<?php endif ?>

									</div><!--end profile-->

</article>