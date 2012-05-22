<ul>
	<?php foreach($messages as $mes): ?>
	<?php $body = word_wrap($mes->body, 35, "<br />\n", TRUE);?>
	<li class="<?php echo ($mes->readed_by_recipient == 0)?lang('unread'):'' ?>" msgid="<?php echo $mes->id?>" onclick="show_email(this);">
		<div id="info"><div></div></div>
		<div class="date"><?php echo date('d-M-Y',$mes->date); ?></div>
		<div class="sender"><?php echo (isset($mes->username))? $mes->username : null?></div>
		<div class="subject"><?php echo character_limiter($mes->subject, 50); ?></div>
		<div class="message"><?php echo character_limiter($body, 100) ?> </div>
		<div class="delete" onclick="move_to_trash_listner(this, '<?php echo $mes->id?>');" title="<?php echo ($folder == 'inbox') ? lang('Move to trash'):lang('Delete')?>"></div>
	</li>
	<?php endforeach; ?>
</ul>