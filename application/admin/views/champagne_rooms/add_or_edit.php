<?php $champagne_room_id = (isset($champagne_room) && is_object($champagne_room)) ? $champagne_room->id : 0 ?> 
<div class="container">
        <div class="conthead">
                <h2><?php echo ($champagne_room_id > 0)? lang('Edit') : lang('Add')?> <?php echo lang('champagne room'); if($champagne_room_id) echo ' #'.$champagne_room_id;?></h2>
        </div>

        <div class="contentbox">

                <?php echo form_open('champagne_rooms/add_or_edit/'.$champagne_room_id)?>
                        <div class="inputboxes">
                                <label><?php echo lang('Performer')?>: </label>
                                <label><b>Performer</b></label>
                        </div>
                        <div class="inputboxes">
                                <label for="name"><?php echo lang('Title')?>: </label>
                                <?php echo form_input('title', set_value('title', (isset($champagne_room) && is_object($champagne_room))? $champagne_room->title : null), 'id="title" class="inputbox" tabindex="1" type="text"')?>
                        </div>
                        <div class="inputboxes">        
                                <label for="name"><?php echo lang('Private')?>: </label>
                                <?php echo form_dropdown('is_private',array('0'=>'No','1'=>'Yes'), set_value('is_private', $champagne_room->is_private),'id="is_private"')?>
                        </div>
                        <div class="inputboxes">        
                                <label for="name"><?php echo lang('Type')?>: </label>
                                <?php echo form_dropdown('type',$types, set_value('type', $champagne_room->type),'id="type"')?>
                        </div>
                        <div class="inputboxes">
                                <label for="name"><?php echo lang('Ticket Price')?>: </label>
                                <?php echo form_input('ticket_price', set_value('ticket_price', (isset($champagne_room) && is_object($champagne_room))? $champagne_room->ticket_price : null), 'id="title" class="inputbox" tabindex="1" type="text"')?>
                        </div>
                        <div class="inputboxes">
                                <label for="name"><?php echo lang('Min ticket number')?>: </label>
                                <?php echo form_input('min_tickets', set_value('min_tickets', (isset($champagne_room) && is_object($champagne_room))? $champagne_room->min_tickets : null), 'id="title" class="inputbox" tabindex="1" type="text"')?>
                        </div>
                        <div class="inputboxes">
                                <label for="name"><?php echo lang('Max ticket number')?>: </label>
                                <?php echo form_input('max_tickets', set_value('max_tickets', (isset($champagne_room) && is_object($champagne_room))? $champagne_room->max_tickets : null), 'id="title" class="inputbox" tabindex="1" type="text"')?>
                        </div>
                        <div class="inputboxes">        
                                <label for="name"><?php echo lang('Can join session')?> ?: </label>
                                <?php echo form_dropdown('join_in_session',array('0'=>'No','1'=>'Yes'), set_value('join_in_session', $champagne_room->join_in_session),'id="join_in_session"')?>
                        </div>
                        <div class="inputboxes">
                                <label for="name"><?php echo lang('Duration')?>: </label>
                                <?php echo form_input('duration', set_value('duration', (isset($champagne_room) && is_object($champagne_room))? $champagne_room->duration/60 : null), 'id="duration" class="inputbox" tabindex="1" type="text"')?>
                                &nbsp; minutes
                        </div>
                        <div class="inputboxes">        
                                <label for="name"><?php echo lang('Status')?> </label>
                                <?php echo form_dropdown('status',array('1'=>'Active','0'=>'InActive'), set_value('status', $champagne_room->status),'id="status"')?>
                        </div>
                        <input class="btn" type="submit" tabindex="3" value="<?php echo ($champagne_room_id > 0)? lang('Update') : lang('Add')?> <?php echo lang('champagne_room')?>" />
                <?php echo form_close()?>
        </div>
</div>
