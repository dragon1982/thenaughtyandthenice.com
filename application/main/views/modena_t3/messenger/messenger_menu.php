<ul>
	<li class="inbox selected">
		<div>
			<?php echo lang('Inbox')?>
			<?php echo ($unread_number > 0)? '<span class="nr">'.$unread_number.'</span>' : null ?>
			
		</div>
	</li>
	<li class="sent">
		<div>
			<?php echo lang('Sent')?>
		</div>
	</li>
	<li class="trash">
		<div>
			<?php echo lang('Trash')?>
		</div>
	</li>
</ul>
