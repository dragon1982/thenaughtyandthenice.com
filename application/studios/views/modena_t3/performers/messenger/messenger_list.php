
	<ul>
		<?php foreach($messages as $mes): ?>
		<?php $body = wordwrap($mes->body, 35, "<br />\n", TRUE);?>
		<li class="<?php echo ($mes->readed_by_recipient == 0)? lang('unread'):'' ?>" msgid="<?php echo $mes->id?>" onclick="show_email(this);">
			<div id="info"><div></div></div>
			<div class="date"><?php echo date('d-M-Y',$mes->date); ?></div>
			<div class="sender"><?php echo $mes->username; ?></div>
			<div class="subject"><?php echo character_limiter(word_wrap($mes->subject, 10), 50); ?><?php echo (strlen($mes->subject) > 50) ? '...' : null ?></div>
			<div class="message"><?php echo character_limiter($body, 100) ?> <?php echo (strlen($mes->body) > 50) ? '...' : null ?></div>
			<div class="delete" onclick="move_to_trash_listner(this, '<?php echo $mes->id?>');" title="<?php echo ($folder == 'inbox') ? lang('Move to trash') : lang('Delete')?>"></div>
		</li>
		<?php endforeach; ?>
	</ul>

