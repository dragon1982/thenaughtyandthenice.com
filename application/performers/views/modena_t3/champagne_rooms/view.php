<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $title = lang('Champagne room')?>
			<span class="eutemia"><?php echo substr($title,0,1)?></span><span class="helvetica"><?php echo substr($title,1)?></span>
		</div>
		<div class="gray italic" style="padding: 10px; text-align: justify; ">		
                    <div style="margin:5px;">ID: <strong><?php echo $champagne_room->id; ?></strong></div>
                    <div style="margin:5px;">Title: <strong><?php echo $champagne_room->title; ?></strong></div>
                    <div style="margin:5px;">Private: <strong><?php echo $champagne_room->is_private?'YES':'NO'; ?></strong></div>
                    <div style="margin:5px;">Type: <strong><?php echo $types[$champagne_room->type]; ?></strong></div>
                    <div style="margin:5px;">Ticket price: <strong><?php echo $champagne_room->ticket_price; ?></strong></div>
                    <div style="margin:5px;">Minimum required tickets: <strong><?php echo $champagne_room->min_tickets; ?></strong></div>
                    <div style="margin:5px;">Tickets available: <strong><?php echo $champagne_room->max_tickets; ?></strong></div>
                    <div style="margin:5px;">Join in session: <strong><?php echo $champagne_room->join_in_session?'YES':'NO'; ?></strong></div>
                    <div style="margin:5px;">Start time: <strong><?php echo date('Y-m-d H:i:s', $champagne_room->start_time); ?></strong></div>
                    <div style="margin:5px;">Duration: <strong><?php echo _format_seconds($champagne_room->duration); ?></strong></div>
                    <div style="margin:5px;">Status: <strong><?php echo $champagne_room->status?'Active':'InActive'; ?></strong></div>
                    <p>&nbsp;</p>
                    <div style="margin:5px;" class="red">Users</div>
                    <div style="margin:5px;">
                        <?php foreach($users as $user): ?>
                            <strong><?php echo $user->username; ?></strong><br />
                        <?php endforeach; ?>
                    </div>
                    <p>&nbsp;</p>
                    <input type="submit" value="Update" class="red" onclick="document.location.href='<?php echo site_url('champagne_rooms/add_or_edit/'.$champagne_room->id); ?>'" />
                    <input type="submit" value="Delete" class="red" onclick="document.location.href='<?php echo site_url('champagne_rooms/delete/'.$champagne_room->id); ?>'" />
                </div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>