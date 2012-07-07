<!-- lightbox-->
<script src="<?php echo assets_url() ?>addons/lightbox/js/lightbox.js"></script>
<link href="<?php echo assets_url() ?>addons/lightbox/css/lightbox.css" rel="stylesheet" />

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

			$('nav.model-nav ul li').removeClass('selected');
	    $(this).addClass('selected');

			$('.slide').hide();
			$('#'+$(this).attr('id') + '_content').show();
			if($(this).attr('id') != 'profile'){
				$('#reviews').hide();
				$('#latest-photos').hide();
			}else{
				$('#reviews').show();
				$('#latest-photos').show();
			}

//			if($(this).attr('id') == 'pictures' || $(this).attr('id') == 'videos'){
//				$('.right').hide();
//			}else{
//				$('.right').show();
//			}
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
<?php include_once($_SERVER['DOCUMENT_ROOT']."/assets/modena_t3/addons/rating/_drawrating.php")?>
            <article class="set-bott-1">

                <header class="box-header clearfix">
                    <h1 class="article-title left"><?php echo $performer->nickname?></h1>
                    <div class="score">- Score: <strong><?php echo getPerformerScore($performer->id)?></strong></div>
                    <nav class="model-nav right">
                    	<ul>
                        	<li id="profile" class="selected menu_item"><a class="ico-profile" href="javascript:;"><span><?php echo lang('My Profile') ?></span></a></li>
                          <li id="pictures" class="menu_item"><a class="ico-photos" href="javascript:;"><span><?php echo sprintf(lang('My Photos (%s)'),(count($photos)+count($photos_paid)))?></span></a></li>
                          <li id="videos" class="menu_item"><a class="ico-videos" href="javascript:;"><span><?php echo sprintf(lang('My Videos (%s)'),(count($videos) + count($videos_paid)))?></span></a></li>
                          <li id="schedule" class="menu_item"><a class="ico-schedule" href="javascript:;"><span><?php echo lang('Schedule') ?></span></a></li>
                          <li id="contact" class="menu_item"><a class="ico-contact" href="javascript:;"><span><?php echo lang('Contact') ?></span></a></li>
                      </ul>
                    </nav>
                </header><!--end box-header-->


                <div class="profile clearfix">

                		<div class="profile-left-col">
                    	<div class="box-t1 set-bott-2">
                        	<a href="<?php echo main_url('uploads/performers/' . $performer->id .'/' . $performer->avatar)?>" rel="lightbox">
                        		<img src="<?php echo ($performer->avatar != '') ? main_url('uploads/performers/' . $performer->id . '/medium/' . $performer->avatar) : assets_url().'images/poza_tarfa_medium.jpg'?>" alt="" width="178">
                        	</a>

                          <div class="rate clearfix">
                          	<div>Rate:</div>
														<?php
														$user_id = ($this->user->id > 0) ? $this->user->id : null;
														echo $rating = rating_bar($performer->id,5,'',$user_id, site_url($this->uri->uri_string()));
														?>
                          </div>

                        </div><!-- end box-t1 -->

                        <a class="btn-nice-4 set-bott-2" href="javascript:;"><span class="ico-private-messages">Private Chat</span></a>
                        <?php if($this->user->id > 0):?>
                        	<a class="btn-nice-3 set-bott-2 send_message" href="javascript:;"><span class="ico-messages"><?php echo lang('send message')?></span></a>

							<?php if(isset($friends['request'])): ?>
										<?php if($friends['request']->status == 'new'): ?>
											<?php echo form_open('relation/add', array('id'=>'add_relation_form', 'method'=>'post', 'name' => 'add_relation_form_'.$performer->nickname)); ?>
												<input type="hidden" name="id" value="<?php echo $friends['request']->id; ?>" />
												<input type="hidden" name="type" value="<?php echo $friends['request']->type; ?>" />
												<a class="btn-nice-3 set-bott-2" href="javascript:;" onclick="javascript:document.add_relation_form_<?php echo $performer->nickname?>.submit();"><span class="ico-add-friend">Add friend</span></a>
											</form>
										<?php elseif($friends['request']->status == 'pending'): ?>
											<?php echo form_open('relation/delete', array('id'=>'delete_relation_form', 'method'=>'post', 'name'=>'delete_relation_form_'.$performer->nickname)); ?>
												<input type="hidden" name="rel_id" value="<?php echo $friends['request']->rel_id; ?>" />
												<a class="btn-nice-3 set-bott-2" href="javascript:;" onclick="javascript:document.delete_relation_form_<?php echo $performer->nickname?>.submit();"><span class="ico-remove-friend">Cancel friend request</span></a>
											</form>
										<?php elseif($friends['request']->status == 'ban'): ?>
											The user is banned
										<?php elseif($friends['request']->status == 'banned'): ?>
											You were banned by this user
										<?php endif; ?>
							<?php endif; ?>
                        <?php endif;?>

                        <a class="btn-nice-3 set-bott-2" href="<?php echo site_url(($favorite)? 'remove-favorite/' . $performer->nickname : 'add-favorite/' . $performer->nickname)?>">
                        	<span class="ico-add-favorite"><?php echo ( ! $favorite)?lang('add favorite'):lang('remove favorite')?></span>
                        </a>

                        <div class="clock set-top-1 set-bott-1 clearfix">
                        	<div class="clock-title-1"><span class="color-1">Next show</span> will start in</div>
                        	<div class="left-part">
                            	<div class="time-decoration"><!-- --></div>
                            	<div class="time-no">12</div>
                                <div class="time-desc">Minutes</div>
                            </div>
                            <div class="right-part">
                            	<div class="time-decoration"><!-- --></div>
                            	<div class="time-no">32</div>
                                <div class="time-desc">Seconds</div>
                            </div>
                        </div><!-- end clock -->

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