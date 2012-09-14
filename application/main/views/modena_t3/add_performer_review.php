<script src="<?php echo assets_url()?>css/ui.stars.css"></script>
<script src="<?php echo assets_url()?>js/ui.stars.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">
jQuery(function($){

	var x = Object();


	//When page loads...
	$(".slide").hide(); //Hide all content
	$("div.btn div:first").addClass("active").show(); //Activate first tab
	$(".slide:first").show(); //Show first tab content

	$('.menu_item').click(function(){
		$('.slide').hide();
		$('#'+$(this).attr('id') + '_content').show();
	});

	$('.send_message').click(function(){
		$('.slide').hide();
		$('#contact_content').show();
	});

    $("#stars").stars({
      	inputType: "radio",
        cancelShow: false,
        split: 1,
//        callback: function(ui, type, value) {
//           x[ui.options.name] = value;
//           //alert('test');
//        }
    });

	$('#review_form').submit(function(){


		var complete = true;
		$('#rate_error').html('');
		$('#comment_error').html('');

		var ratings = 0;
		for (var i in x)
		{
			ratings++;
		}

		if(ratings < 6){
			$('#rate_error').html('<?php echo lang('You must rate for all performance.')?>');
			complete = false;
		}


		if($('#comment').val() == ''){
			$('#comment_error').html('<?php echo lang('You must let a comment.')?>');
			complete = false;
		}

		return complete;

	});

});



window.onload = function() {
	  var txts = document.getElementsByTagName('TEXTAREA')

	  for(var i = 0, l = txts.length; i < l; i++) {
		if(/^[0-9]+$/.test(txts[i].getAttribute("maxlength"))) {
		  var func = function() {
			var len = parseInt(this.getAttribute("maxlength"), 10);

			if(this.value.length > len) {
			  this.value = this.value.substr(0, len);
			  return false;
			}
		  }

		  txts[i].onkeyup = func;
		  txts[i].onblur = func;
		}
	  }
	}


</script>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/assets/modena_t3/addons/rating/_drawrating.php")?>

            <article class="set-bott-1">

                <header class="box-header clearfix">
                    <h1 class="article-title left"><?php echo $performer->nickname?></h1>
                    <div class="score">- Score: <strong><?php echo getPerformerScore($performer->id)?></strong></div>
                </header><!--end box-header-->

                <div class="profile clearfix">
                		<div class="profile-left-col">
                    	<div class="box-t1 set-bott-2">
                        	<a href="<?php echo main_url('uploads/performers/' . $performer->id .'/' . $performer->avatar)?>" rel="lightbox">
                        		<img src="<?php echo ($performer->avatar != '') ? main_url('uploads/performers/' . $performer->id . '/medium/' . $performer->avatar) : assets_url().'images/poza_tarfa_medium.jpg'?>" alt="" width="178">
                        	</a>
                        </div><!-- end box-t1 -->
                    </div><!--end profile-left-col -->

     								<?php echo form_open(site_url($performer->nickname.'/review?id='.$uniq_id),'id="review_form"')?>
                    <div class="profile-right-col">
                    	<div class="box-t1">
                        	<div class="box-header-2">
                              <?php $_perf_profile_page = sprintf(lang('Please evaluate <strong>%s</strong> performance'), $performer->nickname) ?>
                            	<h2 class="title1"><?php echo $_perf_profile_page ?></h2>
                              <h3><?php echo lang('Your rating is anonymous, models can\'t see who rated them, but will help them perform better next time.')?></h3>
                            </div>


                             <section class="clearfix profile-section">
                            	<h3 class="left title2"><?php echo lang('Surroundings, looks')?></h3>
                                <div class="prefix-1">
                                    <div id="stars" class="rate clearfix">
                                        <a href="javascript:;"><span class="vote vote-off"><!-- --></span></a>
																				<?for ($i = 0; $i < 6; $i++):?>
																					<?php $rating = $this->input->post('rating[0]');?>
																					<?php echo form_radio('rating[0]',$i/1,NULL,'class="star"')?>
																				<?php endfor?>
                                    </div>
                                </div><!--end prefix-1-->
                            </section>

                             <section class="clearfix profile-section">
                            	<h3 class="left title2"><?php echo lang('Willing to please, friendly')?></h3>
                                <div class="prefix-1">
                                    <div id="stars" class="rate clearfix">
																			<?for ($i = 0; $i < 21; $i++):?>
																				<?php $rating = $this->input->post('rating[1]');?>
																				<?php echo form_radio('rating[1]',$i/4,NULL,'class="star"')?>
																			<?php endfor?>
                                    </div>
                                </div><!--end prefix-1-->
                            </section>

                             <section class="clearfix profile-section">
                            	<h3 class="left title2"><?php echo lang('Level of performance')?></h3>
                                <div class="prefix-1">
                                    <div id="stars" class="rate clearfix">
																			<?for ($i = 0; $i < 21; $i++):?>
																				<?php $rating = $this->input->post('rating[2]');?>
																				<?php echo form_radio('rating[2]',$i/4,NULL,'class="star"')?>
																			<?php endfor?>
                                    </div>
                                </div><!--end prefix-1-->
                            </section>

                             <section class="clearfix profile-section">
                            	<h3 class="left title2"><?php echo lang('Language usage, comunication')?></h3>
                                <div class="prefix-1">
                                    <div id="stars" class="rate clearfix">
																			<?for ($i = 0; $i < 21; $i++):?>
																				<?php $rating = $this->input->post('rating[3]');?>
																				<?php echo form_radio('rating[3]',$i/4,NULL,'class="star"')?>
																			<?php endfor?>
                                    </div>
                                </div><!--end prefix-1-->
                            </section>

                            <section class="clearfix profile-section">
                            	<h3 class="left title2"><?php echo lang('Video quality, tehnical background')?></h3>
                                <div class="prefix-1">
                                    <div id="stars" class="rate clearfix">
																			<?for ($i = 0; $i < 21; $i++):?>
																				<?php $rating = $this->input->post('rating[4]');?>
																				<?php echo form_radio('rating[4]',$i/4,NULL,'class="star"')?>
																			<?php endfor?>
                                    </div>
                                </div><!--end prefix-1-->
                            </section>

                            <section class="clearfix profile-section" style="border:0;">
                            	<h3 class="left title2"><?php echo lang('Would you return')?></h3>
                                <div class="prefix-1">
                                    <div id="stars" class="rate clearfix">
																			<?for ($i = 0; $i < 21; $i++):?>
																				<?php $rating = $this->input->post('rating[5]');?>
																				<?php echo form_radio('rating[5]',$i/4,NULL,'class="star"')?>
																			<?php endfor?>
                                    </div>
                                </div><!--end prefix-1-->
                            </section>

	                        <div class="form-line clearfix">
	                        	<div class="form-left">
	                            	<label><?php echo lang('Comment')?>:</label>
	                            </div>
	                            <div class="form-right">
	                            	<div class="nice-textarea medium">
	                                	<textarea></textarea>
	                                </div>
	                            </div>
	                        </div><!--end form-line-->

	                        <div class="form-line clearfix" style="border:0;">
	                        	<div class="form-left"></div>
	                             <div class="form-right">
		                        	<input class="nice-submit medium" type="submit" value="<?php echo lang('Send')?>">
		                        	<input class="nice-submit medium" type="button" onclick="document.location='<?php echo site_url($performer->nickname)?>'" value="<?php echo lang('Skip review')?>">
	                            </div>
	                        </div><!--end form-line-->
                   	</form>




                        </div><!--end box-t1-->
                    </div><!--end profile-right-col -->
                </div><!--end profile-->



            </article>


<!-- old version -->


<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $_perf_profile_page = sprintf(lang('Please evaluate <strong>%s</strong> performance'), $performer->nickname) ?>
			<div style="position:absolute"><span class="eutemia "><?php echo substr($_perf_profile_page, 0, 1) ?></span><span class="helvetica "><?php echo substr($_perf_profile_page, 1) ?></span></div>
		</div>
		<br />
		<br />
		<div class="clear"></div>
		<div id="profile">
			<div class="left" style="width:565px">
				<?php echo form_open(site_url($performer->nickname.'/review?id='.$uniq_id),'id="review_form"')?>
				<div class="red_h_sep"></div>
				<div style="text-align: center; width:420px">
					<h3><?php echo lang('Your rating is anonymous, models can\'t see who rated them, but will help them perform better next time.')?></h3>
					<div class="red" id="rate_error"></div>
				</div>
				<div class="review_item">
					<h3><?php echo lang('Surroundings, looks')?>:</h3>
					<div class="stars">
						<?for ($i = 0; $i < 21; $i++):?>
							<?php $rating = $this->input->post('rating[0]');?>
							<?php echo form_radio('rating[0]',$i/4,NULL,'class="star"')?>
						<?php endfor?>
					</div>
				</div>

				<div class="review_item">
					<h3><?php echo lang('Willing to please, friendly')?>:</h3>
					<div class="stars">
						<?for ($i = 0; $i < 21; $i++):?>
							<?php echo form_radio('rating[1]',$i/4,NULL,'class="star"')?>
						<?php endfor?>
					</div>

				</div>

				<div class="review_item">
					<h3><?php echo lang('Level of performance')?>:</h3>
					<div class="stars">
						<?for ($i = 0; $i < 21; $i++):?>
							<?php echo form_radio('rating[2]',$i/4,NULL,'class="star"')?>
						<?php endfor?>
					</div>


				</div>

				<div class="review_item">
					<h3><?php echo lang('Language usage, comunication')?>:</h3>
					<div class="stars">
						<?for ($i = 0; $i < 21; $i++):?>
							<?php echo form_radio('rating[3]',$i/4,NULL,'class="star"')?>
						<?php endfor?>
					</div>

				</div>

				<div class="review_item">
					<h3><?php echo lang('Video quality, tehnical background')?>:</h3>
					<div class="stars">
						<?for ($i = 0; $i < 21; $i++):?>
							<?php echo form_radio('rating[4]',$i/4,NULL,'class="star"')?>
						<?php endfor?>
					</div>

				</div>

				<div class="review_item">
					<h3><?php echo lang('Would you return')?>:</h3>
					<div class="stars">
						<?for ($i = 0; $i < 21; $i++):?>
							<?php echo form_radio('rating[5]',$i/4,NULL,'class="star"')?>
						<?php endfor?>
					</div>
				</div>

				<div id="comment_form">
					<h3><?php echo lang('Comment')?>:</h3>

					<span class="red" id="comment_error"></span>
					<textarea name="message" cols="66" rows="5" id="comment" maxlength="254"></textarea>
					<br />
					<button class="red up f10" type="submit" style="width:150px; margin:auto;"><?php echo lang('Send')?></button>
					<button class="red up f10"  style="width:150px; margin:auto;" type="button" onclick="document.location='<?php echo site_url($performer->nickname)?>'"><?php echo lang('Skip review')?></button>
				</div>
				<?php echo form_close()?>
			</div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>
