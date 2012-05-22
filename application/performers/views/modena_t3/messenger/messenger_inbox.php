<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript">
	
	
	var loading_content = '<div class="loading"><img src="<?php echo assets_url()?>images/icons/messenger_loading.gif"/> <?php echo lang('Loading...')?></div>';
	var listScroll = '';
	var mailScroll = '';
	var selected_folder = 'inbox';
	var click_on_delete = false;
	$(document).ready(function(){
		listScroll = $('#list');
		listScroll.tinyscrollbar();
		
		mailScroll = $('#mail');
		mailScroll.tinyscrollbar();

		$('#menu ul li').click(function(){
			$('#menu ul li.selected').removeClass('selected');
			$(this).addClass('selected');
			update_mail_list($(this).attr('id'));
		});
		
		update_mail_list(selected_folder);
		show_first_mail();
			
	});
	
	function move_to_trash_listner(elem, id){
			click_on_delete = true;
			move_to_trash($(elem).parent(), id);
		};
	

	function update_mail_list(folder){
		
		
		$('#list .overview').html(loading_content);
		listScroll.tinyscrollbar_update();
		
		$('#mail .overview').html(loading_content);
		mailScroll.tinyscrollbar_update();
		
		selected_folder = folder;
		$.ajax({
            url: "<?php echo site_url('messenger/mail_list')?>",
            type: 'post',
            dataType: "json",
            data: {'folder': folder, 'ci_csrf_token': '<?php echo $this->security->_csrf_hash?>'},
            success: function(response) {
				
				if(response.success){
					$('#list .overview').html(response.list);
					
					listScroll.tinyscrollbar_update();
					$('#list ul li:first').addClass('selected');
					var mail_id = $('#list ul li:first').attr('msgid');
					update_mail_content(mail_id);
					
				}else{
					$('#list .overview').html(response.error);
					$('#mail .overview').html('');
					listScroll.tinyscrollbar_update();
				}
            }
        });

	}
	
	function update_mail_content(mail_id){
		
		if(click_on_delete){
			return false;
		}
	
		$('#mail .overview').html(loading_content);
		mailScroll.tinyscrollbar_update();
		if(mail_id == undefined){
			$('#mail .overview').html('');
			return false;
		}
		
		$.ajax({
            url: "<?php echo site_url('messenger/mail')?>",
            type: 'post',
            dataType: "json",
            data: {'id': mail_id, 'folder': selected_folder ,  'ci_csrf_token': '<?php echo $this->security->_csrf_hash?>'},
            success: function(response) {
				if(response.success){
					$('#mail .overview').html(response.mail);
					if(response.unread_number > 0){
					//update unread nr
						$('.nr').html(response.unread_number);
					}else{
						$('.nr').hide();
					}
					
					mailScroll.tinyscrollbar_update();
					
				}else{
					$('#mail .overview').html(response.error);
					mailScroll.tinyscrollbar_update();
				}
            }
        });
		
	}
	
	function move_to_trash(elem, id){
		
		$(elem).find('#info div').html('<img src="<?php echo assets_url()?>images/icons/small_loader.gif" /> <?php echo lang('Confirm!')?>');
		$(elem).find('#info div').slideDown(300);
		
		setTimeout(function(){
			var answer = confirm('<?php echo lang('Are you sure you want to delete this message?')?>', 'yes', 'no');
		
			if(!answer){
				$(elem).find('#info div').slideUp(300);
				return false;
			}
			
			$(elem).find('#info div').html('<img src="<?php echo assets_url()?>images/icons/small_loader.gif" /> <?php echo lang('Loading...')?>');
			
			$.ajax({
				url: "<?php echo site_url('messenger/move_to_trash')?>",
				type: 'post',
				dataType: "json",
				data: {'message_id': id, 'folder': selected_folder ,  'ci_csrf_token': '<?php echo $this->security->_csrf_hash?>'},
				success: function(response) {
					if(response.success){
						$(elem).find('#info div').html(response.error);
						
						
						
						setTimeout(function(){
							$(elem).hide(500);
							$(elem).remove();
							listScroll.tinyscrollbar_update();
							show_first_mail();
						}, 3000);
						

					}else{
						$(elem).find('#info div').html(response.error);
						setTimeout(function(){
							$(elem).find('#info div').slideUp(300);
						}, 3000);
					}
				}
			});
			click_on_delete = false;
		}, 300);
		
	}
	
	function show_first_mail(){
		var mail_id = $('#list ul li:first').attr('msgid');
		
		update_mail_content(mail_id);
	}
	
	function show_email(elem){
		$('#list ul li.selected').removeClass('selected');
		$(elem).addClass('selected');
		$(elem).removeClass('unread');
		var mail_id = $(elem).attr('msgid');
		update_mail_content(mail_id);
	}
	

</script>

	<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $messenger_title = lang('Messenger')?>
				 <span class="eutemia"><?php echo substr($messenger_title,0,1)?></span><span class="helvetica"><?php echo substr($messenger_title,1)?></span> 
			</div>			
			<div id="messenger">				
				<div id="menu">
					<ul>
						<li class="inbox selected" id="inbox">
							<div>
								<?php echo lang('Inbox')?>
								<?php echo ($unread_number > 0)? '<span class="nr">'.$unread_number.'</span>' : null ?>
								
							</div>
						</li>
						<li id="sent">
							<div>
								<?php echo lang('Sent')?>
							</div>
						</li>
						<li id="trash">
							<div>
								<?php echo lang('Trash')?>
							</div>
						</li>
					</ul>
					<div class="info"></div>
				</div>
				
				<div id="list" class="" >
					<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
					<div class="viewport">
						<div class="overview">
						</div>
					</div>
				</div>
				
				<div id="mail">
					<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
					<div class="viewport">
						<div class="overview">
						</div>
					</div>
				</div>
				
			</div>
			
			<div class="clear"></div>
			
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>	