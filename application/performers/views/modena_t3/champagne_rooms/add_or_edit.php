<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
            <div class="content">
                <div class="title">
                    <?php $title = lang('Champagne room') ?>
                    <span class="eutemia"><?php echo substr($title, 0, 1) ?></span><span class="helvetica"><?php echo substr($title, 1) ?> <?php if (isset($champagne_room->id)) echo ' #' . $champagne_room->id; ?></span>
                </div>
                <div id="profile">
                    <div class="left" style="text-align: center;">
                        <div class="red_h_sep"></div>
                        <?php echo form_open('') ?>
                        <div class="gray italic register_performer">
                            <div>
                                <label><span class="gray italic bold"><?php echo lang('Title') ?>:</span></label>
                                <?php echo form_input('title', set_value('title', (isset($champagne_room) && is_object($champagne_room)) ? $champagne_room->title : null )) ?>
                                <span class="error message" htmlfor="title" generated="true"><?php echo form_error('title') ?></span>
                            </div>
                            <div>
                                <label><span class="gray italic bold"><?php echo lang('Private') ?>:</span></label>
                                <?php echo form_dropdown('is_private', array(0 => 'No', 1 => 'Yes'), set_value('is_private', (isset($champagne_room) && is_object($champagne_room)) ? $champagne_room->is_private : null), 'id="is_private"') ?>
                                <span class="error message" htmlfor="is_private" generated="true"><?php echo form_error('is_private') ?></span>
                            </div>
                            <div>
                                <label><span class="gray italic bold"><?php echo lang('Type') ?>:</span></label>
                                <?php echo form_dropdown('type', $types, set_value('type', (isset($champagne_room) && is_object($champagne_room)) ? $champagne_room->type : null), 'id="type"') ?>
                                <span class="error message" htmlfor="type" generated="true"><?php echo form_error('type') ?></span>
                            </div>
                            <div>
                                <label><span class="gray italic bold"><?php echo lang('Ticket price') ?>:</span></label>
                                <?php echo form_input('ticket_price', set_value('ticket_price', (isset($champagne_room) && is_object($champagne_room)) ? $champagne_room->ticket_price : null)) ?>
                                <span class="error message" htmlfor="ticket_price" generated="true"><?php echo form_error('ticket_price') ?></span>
                            </div>
                            <div>
                                <label><span class="gray italic bold"><?php echo lang('Min tickets number') ?>:</span></label>
                                <?php echo form_input('min_tickets', set_value('min_tickets', (isset($champagne_room) && is_object($champagne_room)) ? $champagne_room->min_tickets : null)) ?>
                                <span class="error message" htmlfor="min_tickets" generated="true"><?php echo form_error('min_tickets') ?></span>
                            </div>
                            <div>
                                <label><span class="gray italic bold"><?php echo lang('Tickets available') ?>:</span></label>
                                <?php echo form_input('max_tickets', set_value('max_tickets', (isset($champagne_room) && is_object($champagne_room)) ? $champagne_room->max_tickets : null)) ?>
                                <span class="error message" htmlfor="max_tickets" generated="true"><?php echo form_error('max_tickets') ?></span>
                            </div>
                            <div>
                                <label><span class="gray italic bold"><?php echo lang('Join in session') ?>:</span></label>
                                <?php echo form_dropdown('join_in_session', array(0 => 'No', 1 => 'Yes'), set_value('join_in_session', (isset($champagne_room) && is_object($champagne_room)) ? $champagne_room->join_in_session : null), 'id="join_in_session"') ?>
                                <span class="error message" htmlfor="join_in_session" generated="true"><?php echo form_error('join_in_session') ?></span>
                            </div>
                            <div>
                                <label><span class="gray italic bold"><?php echo lang('Start date') ?>:</span></label>
                                <?php echo form_dropdown('year', $years, set_value('year', (isset($champagne_room->start_time)) ? date('Y', $champagne_room->start_time) : null ), 'class="small"') ?>
                                <?php echo form_dropdown('month', $months, set_value('month', (isset($champagne_room->start_time)) ? date('m', $champagne_room->start_time) : null ), 'class="small"') ?>
                                <?php echo form_dropdown('day', $days, set_value('day', (isset($champagne_room->start_time)) ? date('d', $champagne_room->start_time) : null), 'class="small"') ?>
                                <span class="error message" htmlfor="start_time" generated="true"><?php echo form_error('start_time') ?></span>
                            </div>
                            <div>
                                <label><span class="gray italic bold"><?php echo lang('Start time') ?>:</span></label>
                                <?php echo form_input('hour', set_value('hour', (isset($champagne_room->start_time)) ? date('H', $champagne_room->start_time) : null), 'class="small"') ?>
                                <?php echo form_input('min', set_value('min', (isset($champagne_room->start_time)) ? date('i', $champagne_room->start_time) : null ), 'class="small"') ?>
                                <?php echo form_input('sec', set_value('sec', (isset($champagne_room->start_time)) ? date('s', $champagne_room->start_time) : null ), 'class="small"') ?>
                                <span class="gray italic bold">(HH:MM:SS)</span>
                                <span class="error message" htmlfor="start_time" generated="true"><?php echo form_error('start_time') ?></span>
                            </div>
                            <div>
                                <label><span class="gray italic bold"><?php echo lang('Duration') ?>:</span></label>
                                <?php echo form_input('duration', set_value('duration', round((isset($champagne_room) && is_object($champagne_room)) ? $champagne_room->duration : null) / 60)) ?>  <span class="gray italic bold">minutes</span>
                                <span class="error message" htmlfor="duration" generated="true"><?php echo form_error('duration') ?></span>
                            </div>
                            <div>
                                <label><span class="gray italic bold"><?php echo lang('Status') ?>:</span></label>
                                <?php echo form_dropdown('status', array(0 => 'InActive', 1 => 'Active'), set_value('status', (isset($champagne_room) && is_object($champagne_room)) ? $champagne_room->status : null), 'id="status"') ?>
                                <span class="error message" htmlfor="status" generated="true"><?php echo form_error('status') ?></span>
                            </div>
                            <div>
                                <label></label>
                                <?php echo form_submit('submit', lang('Save'), 'class="red"') ?>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                        <div class="red_h_sep"></div>
                        <div class="white_h_sep"></div>

                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div></div><div class="black_box_bg_bottom"></div>