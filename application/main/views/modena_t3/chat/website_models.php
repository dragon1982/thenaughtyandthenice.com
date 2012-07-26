<script type="text/javascript">
	function endShow(type){
		if(type == 'public'){
			document.location = '<?php echo site_url()?>';
		} else {
			document.location = '<?php echo site_url($params['performerNick'] . '/review?id=' . $params['uniqId'])?>';
		}
	}

	function enterChatChoice(chatType,link){
		document.location = link;
	}

	function update_chips(){
		var user_id = <?php echo $this->user->id?>;
		$.ajax({
        	url: "<?php echo site_url('user/update_chips')?>",
            type: 'get',
            dataType: "json",
            success: function(response) {

				$('#user_chips').html(response.credits);
				$('#head_user_chips').html(response.credits);

				if(!response.rem_time){
					response.rem_time = 'n/a'
				}

				$('#time_remaining').html(response.rem_time + ' <?php echo lang('minute(s)')?>');
            }
        });
		if(user_id > 0){
			setTimeout(update_chips, 5000);
		}
	}


	function small1(){
		$('#flashContent').find('object').height('540');
	}

	function large1(){
		$('#flashContent').find('object').height('750');
	}

	window.history.forward();
	function noBack(){ window.history.forward(); }

	$(document).ready(function(){
		noBack();
	<?php if($this->user->id > 0):?>
		update_chips();
	<?php endif?>
	});
</script>


            <article class="set-bott-1">
                <header class="box-header clearfix">
                    <h1 class="article-title left"><?php echo $params['performerNick']?></h1>
                    <nav class="model-nav right">
                    	<ul>
                        	<li><a class="ico-profile" href="<?php echo site_url($params['performerNick'])?>" target="_blank"><span>My profile</span></a></li>
                            <li><a class="ico-photos" href="<?php echo site_url($params['performerNick'] . '?tab=pictures')?>" target="_blank"><span>My photos</span></a></li>
                            <li><a class="ico-videos" href="<?php echo site_url($params['performerNick'] . '?tab=videos')?>" target="_blank"><span>My videos</span></a></li>
                            <li><a class="ico-schedule" href="<?php echo site_url($params['performerNick'] . '?tab=schedule')?>" target="_blank"><span>Schedule</span></a></li>
                            <li><a class="ico-contact" href="<?php echo site_url($params['performerNick'] . '?tab=contact')?>" target="_blank"><span>Contact</span></a></li>
                        </ul>
                    </nav>
                </header><!--end box-header-->

                <div class="profile clearfix">

                    <article>
                        <header class="chat-topic clearfix">
                            <div class="chat-topic-decoration"><!-- --></div>
                            <div class="chat-topic-left">
                                <div class="chat-topic-left-content">
                                    <h1>I'll make you feel right at home XoXo </h1>
                                </div>
                            </div>
                            <div class="chat-topic-right">
                                <div class="clock-label">
                                    <div class="clock-label-content">
                                        Untill the show ends...
                                        <div class="clock-label-arrow"><!-- --></div>
                                    </div>
                                </div>

                                <div class="chat-clock clearfix">
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
                                </div><!--end chat-clock-->

                            </div><!--end chat-topic-right-->

                        </header><!--end chat-topic -->

                        <div class="chat-profile">
                            <?php echo $this->load->view('flash_component')?>
                        </div>

                    </article>

                    <article class="box-t4">
                    	<div class="box-t4-content">
                        	<div class="pic-frame-1 left"><a href="javascript:;"><img src="<?php echo assets_url()?>pic-178.png" alt=""></a></div>
                            <h1 class="promo-title"><a href="javascript:;">Shanon Nice Champagne show</a></h1>
                            <div class="promo-desc">Showtype: <a href="javascript:;">lesbian</a>, <a href="javascript:;">threesome</a></div>
                            <div class="promo-desc"><a href="javascript:;">23</a> tickets left</div>
                            <a href="javascript:;" class="btn-nice-1">Buy tickets!</a>
                        </div><!--end box-t4-content-->
                    </article>

                </div><!--end profile-->



            </article>



	<div class="content">
		<div class="title">
			<?php $title_chat = lang('Performer\'s Chat Room') ?>
			<span class="eutemia "><?php echo substr($title_chat,0,1) ?></span><span class="helvetica "><?php echo substr($title_chat,1) ?></span>
		</div>
		<div id="chat_info">
			<div>
				<?php if($params['sessionType'] == 'public' || $params['sessionType'] == 'private'):?>
					<span class="info_name italic gray"><?php echo lang('Private chat rate')?>:</span>
					<span class="info_value italic red"><?php echo print_amount_by_currency($params['performersFeePerMinutePrivate'])?>/<?php echo lang('minute')?></span>

					<span class="info_name italic gray"><?php echo lang('True private chat rate')?>:</span>
					<span class="info_value italic red"><?php echo print_amount_by_currency($params['performersFeePerMinuteTruePrivate'])?>/<?php echo lang('minute')?></span>
				<?php elseif($params['sessionType'] == 'private_public'):?>

					<span class="info_name italic gray"><?php echo lang('Nude chat rate')?>:</span>
					<span class="info_value italic red"><?php echo print_amount_by_currency($params['performersFeePerMinuteNude'])?>/<?php echo lang('minute')?></span>

					<span class="info_name italic gray"><?php echo lang('Private chat rate')?>:</span>
					<span class="info_value italic red"><?php echo print_amount_by_currency($params['performersFeePerMinutePrivate'])?>/<?php echo lang('minute')?></span>

					<span class="info_name italic gray"><?php echo lang('True private chat rate')?>:</span>
					<span class="info_value italic red"><?php echo print_amount_by_currency($params['performersFeePerMinuteTruePrivate'])?>/<?php echo lang('minute')?></span>

				<?php elseif($params['sessionType'] == 'peek'):?>
					<span class="info_name italic gray"><?php echo lang('Peek chat rate')?>:</span>
					<span class="info_value italic red"><?php echo print_amount_by_currency($params['performersFeePerMinutePeek'])?>/<?php echo lang('minute')?></span>
				<?php endif ?>
			</div>
			<div>
				<span class="info_name italic gray"><?php echo lang('Your account balance')?>:</span>
				<span class="info_value italic red" id="user_chips"></span>
				<span class="info_name italic gray" ><?php echo lang('Available private chat')?>:</span>
				<span class="info_value italic red" id="time_remaining"></span>
			</div>
		</div>


	</div>