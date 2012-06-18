<script type="text/javascript">
$(document).ready(function(){
	$('#subject').change(function(){
		validate_input($(this), 1, 100);
	});
	
	$('#message').change(function(){
		validate_input($(this), 1, 1500);
	});
	
	$('.reply_form').submit(function(){
		var error = false;
		
		if(!validate_input($('#subject'), 1, 100)){
			error = true;
		}
		
		if(!validate_input($('#message'), 1, 1500)){
			error = true;
		}
		
		if(error){
			return false;
		}
			
		$('.reply #info div').html('<img src="<?php echo assets_url()?>images/icons/small_loader.gif" /> Loading ...');
		$('.reply #info div').slideDown(300);
		
		
		var subject = $('#subject').val();
		var message = $('#message').val();
		var message_id = $('input[name=message_id]').val();
		
		$.ajax({
            url: "<?php echo site_url('messenger/send_mail')?>",
            type: 'post',
            dataType: "json",
            data: {'subject': subject, 'message': message , 'message_id' : message_id , 'ci_csrf_token': '<?php echo $this->security->_csrf_hash?>'},
            success: function(response) {
				if(response.success){
					$('#subject').val('');
					$('#message').val('');
					setTimeout(function(){
						$('.reply #info div').slideUp(300);
					}, 5000);
				}
				
				$('.reply #info div').html(response.error);
				
				
            }
        });
		return false;
	
	});
	
	function validate_input(elem, min, max){
		if($(elem).val() == ''){
			$(elem).next('span').addClass('error');
			var field_name = $(elem).attr('name');
			$(elem).next('span').html('The '+ field_name +' is required!');
			return false;
		}else if($(elem).val() < min || $(elem).val() > max ){
			
			$(elem).next('span').addClass('error');
			var field_name = $(elem).attr('name');
			$(elem).next('span').html('The '+ field_name +' length should be between '+ min +' and '+ max +' chars!');
			return false;
		}else{
			$(elem).next('span').html('');
			return true;
		}
	}
	
	
}); 
</script>

<div class="email_content">
	<div class="title">
		<h3><?php echo $message->subject?> </h3>
		<div class="date"><?php echo date('d-M-Y',$message->date); ?></div>
		
	</div>
	<div class="email_body">
		<?php $body = wordwrap($message->body, 100, "<br />\n", TRUE);?>
		<?php echo $body?> 
	</div>
</div>
<?php if($received):?>
<div class="reply">
	
	<div id="info">
		<div>
			
		</div>
	</div>
	
	
	<div class="title">
		<h3><?php echo lang('Reply to')?> <strong><?php echo $message->username?></strong> <?php echo lang('(user)')?></h3>
	</div>
	<div class="reply_form">
		<?php echo form_open('', 'class="reply_form"')?>
		<?php echo form_hidden('message_id', $message->id);?>
		
		<label><?php echo lang('Subject')?> <?php echo form_input('subject', set_value('subject', lang('RE').': '.$message->subject), 'style="width:422px;" id="subject"') ?>
		<span class="error message"></span></label>
		<label><?php echo lang('Message')?>:<br/>
			<?php echo form_textarea('message', null, ' style="width:427px; height: 150px;" id="message" ') ?>
			<span class="error message"></span>
		</label>
		<div class="button">
			<button class="black"  type="submit" style="width:110px;"><?php echo lang('Send')?></button><span class="submit_b_r"></span><br/>
		</div>
		<div class="clear"></div>
		<?php echo form_close()?>
	</div>
	
</div>
<?php endif?>