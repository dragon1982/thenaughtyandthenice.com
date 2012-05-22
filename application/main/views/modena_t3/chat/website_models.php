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
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
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
		<div id="profile" style="width: 600px;margin: 15px auto 0;height: 33px;">
			<div class="red_h_sep"></div>
			<div class="menu">
				<div class="menu_item" id="profile">
					<span id="profile" class="btn" style="cursor:pointer;"><a href="<?php echo site_url($params['performerNick'])?>" target="_blank"><span class="helvetica italic"><?php echo lang('My Profile') ?></span></a></span><span class="r"></span>
				</div>
				<div class="menu_item" id="pictures">
					<span id="pictures" class="btn" style="cursor:pointer;"><a href="<?php echo site_url($params['performerNick'] . '?tab=pictures')?>" target="_blank"><span class="helvetica italic"><?php echo sprintf(lang('My Photos (%s)'),$photos_nr)?></span></a></span><span class="r"></span>
				</div>
				<div class="menu_item" id="videos">
					<span id="videos" class="btn" style="cursor:pointer;"><a href="<?php echo site_url($params['performerNick'] . '?tab=videos')?>" target="_blank"><span class="helvetica italic"><?php echo sprintf(lang('My Videos (%s)'),$videos_nr)?></span></a></span><span class="r"></span>
				</div>
				<div class="menu_item" id="schedule">
					<span id="schedule" class="btn" style="cursor:pointer;"><a href="<?php echo site_url($params['performerNick'] . '?tab=schedule')?>" target="_blank"><span class="helvetica italic"><?php echo lang('Schedule') ?></span></a></span><span class="r"></span>
				</div>
				<div class="menu_item" id="contact">
					<span id="contact" class="btn" style="cursor:pointer;"><a href="<?php echo site_url($params['performerNick'] . '?tab=contact')?>" target="_blank"><span class="helvetica italic"><?php echo lang('Contact') ?></span></a></span><span class="r"></span>
				</div>
			</div>
			<div class="red_h_sep"></div>
		</div>
		<div id="flashContent" style="width:100%; text-align: center;">
			<?php echo $this->load->view('flash_component')?>
		</div>
		<?php if(sizeof($performers) > 1):?>	
			<div class="title">
				<?php $title_chat = lang('Other performers') ?>
				<span class="eutemia "><?php echo substr($title_chat,0,1) ?></span><span class="helvetica "><?php echo substr($title_chat,1) ?></span>
			</div>		
			<div id="performer_list">
							
					<?php foreach($performers as $performer):?>
						<?php if($performer->nickname === $params['performerNick']) continue;//nu afisez performerul current care e in chat?>
						<?php $this->load->view('performer',array('performer'=>$performer))?>
					<?php endforeach?>	
				
			</div>
		<?php endif?>
		<div class="clear"></div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>