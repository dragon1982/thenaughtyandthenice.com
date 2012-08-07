<script type="text/javascript">
	function endShow(type){
		if(type == 'public'){
			document.location = '<?php echo site_url($params['performerNick'])?>';
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

//							if(!response.rem_time){
//								$('#clock-min').html('00');
//								$('#clock-sec').html('00');
//								//response.rem_time = 'n/a';
//							}else{
									if(response.clockHr == '00'){
										$('#clock-min').html(response.clockMin);
										$('#clock-sec').html(response.clockSec);
									}else{
									  $('#clock-min').html('00');
									  $('#clock-sec').html('00');
									}
//							}

				//$('#time_remaining').html(response.rem_time + ' <?php echo lang('minute(s)')?>');
            }
        });
		if(user_id > 0){
			setTimeout(update_chips, 5000);
		}
	}

	function update_stats(){
		var user_id = <?php echo $this->user->id?>;
		var performer_id = <?php echo $this->user->id?>;
		$.ajax({
        	url: "<?php echo site_url('ajax_update/update_stats?nickname='.$params['performerNick'])?>",
            type: 'get',
            dataType: "json",
            success: function(response) {

				$('#room-status').html(response.roomStatus);
				$('#clock-message').html(response.clockMsg);

				<?php if($params['sessionType'] == 'public'):?>
					$('#clock-min').html(response.clockMin);
					$('#clock-sec').html(response.clockSec);
				<?php endif;?>
				//if(!response.rem_time){
					//response.rem_time = 'n/a'
				//}

				$('#time_remaining').html(response.rem_time + ' <?php echo lang('minute(s)')?>');
            }
        });
		if(user_id > 0){
			setTimeout(update_stats, 1000);
		}
	}


	function small1(){
		$('#flashContent').find('object').height('594');
		$('#room_video').removeClass("rv-big-screen").addClass("rv-small-screen");
		//alert('ok 1');
	}

	function large1(){
		$('#flashContent').find('object').height('750');
		$('#room_video').removeClass("rv-small-screen").addClass("rv-big-screen");
		//alert('ok 2');
	}

	window.history.forward();
	function noBack(){ window.history.forward(); }

	$(document).ready(function(){
		noBack();
	<?php if($this->user->id > 0):?>
		update_chips();
		update_stats();
	<?php endif?>
	});
</script>


                <div class="box-header clearfix">
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
                </div><!--end box-header-->

                        <div class="chat-topic clearfix">
                            <div class="chat-topic-decoration"><!-- --></div>
                            <div class="chat-topic-left">
                                <div class="chat-topic-left-content">
                                    <h1 id="room-status">I'll make you feel right at home XoXo </h1>
                                </div>
                            </div>

                            <div class="chat-tax ">
                            	<table>
                                	<tr>
                                    	<td colspan="2"><strong>Rates:</strong></td>
                                    </tr>

																		<?php if($params['sessionType'] == 'public' || $params['sessionType'] == 'private'):?>
	                                    <tr>
	                                    	<td><?php echo lang('Private chat rate')?>:</td>
	                                        <td><strong><?php echo print_amount_by_currency($params['performersFeePerMinutePrivate'])?>/<?php echo lang('minute')?></strong></td>
	                                    </tr>
	                                    <tr>
	                                    	<td><?php echo lang('True private chat rate')?>: </td>
	                                        <td><strong><?php echo print_amount_by_currency($params['performersFeePerMinuteTruePrivate'])?>/<?php echo lang('minute')?></strong></td>
	                                    </tr>
																		<?php elseif($params['sessionType'] == 'private_public'):?>
	                                    <tr>
	                                    	<td><?php echo lang('Nude chat rate')?>: </td>
	                                        <td><strong><?php echo print_amount_by_currency($params['performersFeePerMinuteNude'])?>/<?php echo lang('minute')?></strong></td>
	                                    </tr>
	                                    <tr>
	                                    	<td><?php echo lang('Private chat rate')?>: </td>
	                                        <td><strong><?php echo print_amount_by_currency($params['performersFeePerMinutePrivate'])?>/<?php echo lang('minute')?></strong></td>
	                                    </tr>
	                                    <tr>
	                                    	<td><?php echo lang('True private chat rate')?>: </td>
	                                        <td><strong><?php echo print_amount_by_currency($params['performersFeePerMinuteTruePrivate'])?>/<?php echo lang('minute')?></strong></td>
	                                    </tr>
																		<?php elseif($params['sessionType'] == 'peek'):?>
	                                    <tr>
	                                    	<td><?php echo lang('Peek chat rate')?>: </td>
	                                        <td><strong><?php echo print_amount_by_currency($params['performersFeePerMinutePeek'])?>/<?php echo lang('minute')?></strong></td>
	                                    </tr>
																		<?php endif ?>
                                </table>
                            </div>

                            <div class="chat-topic-right">
                                <div class="clock-label">
                                    <div id="clock-message" class="clock-label-content">
                                        Untill the show ends...
                                        <div class="clock-label-arrow"><!-- --></div>
                                    </div>
                                </div>

                                <div class="chat-clock clearfix">
                                    <div class="left-part">
                                        <div class="time-decoration"><!-- --></div>
                                        <div id="clock-min" class="time-no">12</div>
                                        <div class="time-desc">Minutes</div>
                                    </div>
                                    <div class="right-part">
                                        <div class="time-decoration"><!-- --></div>
                                        <div id="clock-sec" class="time-no">32</div>
                                        <div class="time-desc">Seconds</div>
                                    </div>
                                </div><!--end chat-clock-->

                            </div><!--end chat-topic-right-->

                        </div><!--end chat-topic -->