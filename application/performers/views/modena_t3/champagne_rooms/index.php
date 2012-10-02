<link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>css/table.css" media="screen" />  
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
            <div class="content" style="margin-left:50px;">
                <div class="red_h_sep"></div>
                <div class="title">
                    <?php $payments_title = lang('Champagne rooms') ?>
                    <table><tr><td>
                        <span class="eutemia"><?php echo substr($payments_title, 0, 1) ?></span><span class="helvetica"><?php echo substr($payments_title, 1) ?></span>
                    </td><td width="50"></td><td>
                        <input type="submit" value="Add" class="red" onclick="document.location.href='<?php echo site_url('champagne_rooms/add_or_edit'); ?>'" />
                    </td></tr></table>
                 </div>			
                <div style="float: left; width: 640px;">
                    <table class="data display datatable">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;"><?php echo lang('Title') ?></th>
                                <th style="white-space: nowrap;"><?php echo lang('Private') ?></th>
                                <th style="white-space: nowrap;"><?php echo lang('Type') ?></th>
                                <th style="white-space: nowrap;"><?php echo lang('Ticket price') ?></th>
                                <th style=""><?php echo lang('Minimum required tickets') ?></th>
                                <th style="white-space: nowrap;"><?php echo lang('Available tickets') ?></th>
                                <th style="white-space: nowrap;"><?php echo lang('Join session') ?></th>
                                <th style="white-space: nowrap;"><?php echo lang('Start time') ?></th>
                                <th style="white-space: nowrap;"><?php echo lang('Duration') ?></th>
                                <th style="white-space: nowrap;"><?php echo lang('Status') ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <?php if (sizeof($champagne_rooms) == 0): ?>
                                <tr>
                                    <td colspan="11" style="text-align:center"><?php echo lang('You have no champagne rooms') ?></td>
                                </tr>
                            <?php else: ?>
                                <?php $i = 0 ?>
                                <?php foreach ($champagne_rooms as $champagne_room): ?>
                                    <tr class="<?php echo ($i % 2 == 0) ? 'even' : 'odd' ?>">
                                        <td><?php echo $champagne_room->title; ?></td>
                                        <td><img src="<?php echo assets_url('modena_t3/images/icons/' . ($champagne_room->is_private?'approved':'rejected') . '.png') ?>" /></td>
                                        <td><?php echo $types[$champagne_room->type]; ?></td>
                                        <td><?php echo $champagne_room->ticket_price; ?></td>
                                        <td><?php echo $champagne_room->min_tickets; ?></td>
                                        <td><?php echo $champagne_room->max_tickets; ?></td>
                                        <td><img src="<?php echo assets_url('modena_t3/images/icons/' . ($champagne_room->join_in_session?'approved':'rejected') . '.png') ?>" /></td>
                                        <td><?php echo date('Y-m-d H:i:s', $champagne_room->start_time); ?></td>
                                        <td><?php echo _format_seconds($champagne_room->duration); ?></td>
                                        <td><img src="<?php echo assets_url('modena_t3/images/icons/' . ($champagne_room->status?'approved':'rejected') . '.png') ?>" title="<?php echo $champagne_room->status?'Active':'InActive' ?>" /></td>
                                        <td style="text-align: center; ">
                                            <nobr>
                                                <a href="<?php echo site_url()?>champagne_rooms/view/<?php echo $champagne_room->id?>" title=""><img src="<?php echo assets_url('modena_t3/images/find_on.png') ?>" title="view"></a>
                                                <a href="<?php echo site_url()?>champagne_rooms/add_or_edit/<?php echo $champagne_room->id?>" title=""><img src="<?php echo assets_url('modena_t3/images/icons/edit.png') ?>" title="edit"></a>
                                                <a href="<?php echo site_url()?>champagne_rooms/delete/<?php echo $champagne_room->id?>" onclick="if(confirm('<?php echo lang('Are you sure you want to delete this champagne room?')?>')) { return true;} else {return false;}" title=""><img src="<?php echo assets_url('modena_t3/images/icons//trash.gif') ?>" title="delete"></a> 
                                            </nobr>
                                        </td>
                                    </tr>
                                    <?php $i++ ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php echo $pagination ?>
                </div>
                <div class="clear"></div>
                <div class="red_h_sep"></div>
                <div class="white_h_sep"></div>

            </div>
        </div>
    </div></div><div class="black_box_bg_bottom"></div>