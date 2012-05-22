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

<a href="<?php echo site_url('/messenger/inbox') ?>"><span class="messenger_menu_item <?php echo ($this->uri->segment(2)=="inbox" || $this->uri->segment(2)=="")?'selected':''?> "><?php echo lang('Inbox') ?><span style="float:right;"><span class="red"><?php echo $unread_number ?></span> / (<?php echo $number ?>)</span></span></a>
<a href="<?php echo site_url('/messenger/outbox') ?>"><span class="messenger_menu_item <?php echo ($this->uri->segment(2)=="outbox")?'selected':''?>"><?php echo lang('Sent Items') ?><span style="float:right;">(<?php echo $sent_number ?>)</span></span></a>
<a href="<?php echo site_url('/messenger/trash') ?>"><span class="messenger_menu_item <?php echo ($this->uri->segment(2)=="trash")?'selected':''?>"><?php echo lang('Trash') ?><span style="float:right;">(<?php echo $trash_number ?>)</span></span></a>