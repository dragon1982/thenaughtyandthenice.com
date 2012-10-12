<section class="set-bott-1">
    <header class="box-header clearfix">
        <h1 class="left box-title-1"><a href="<?php echo site_url('champagne_room/view/'.$champagne_room->id); ?>"><span class="girls-no">Champagne room #<?php echo $champagne_room->id; ?></span></a></h1>
    </header>
    
    Ticket price: <?php echo $champagne_room->ticket_price ?> <?php echo SETTINGS_SHOWN_CURRENCY; ?>
    
    <?php if($champagne_room->available_tickets && !$champagne_room->joined_user): ?>
        <form method="post" action="<?php echo site_url('champagne_room/join'); ?>">
            <input type="hidden" value="<?php echo $champagne_room->id; ?>" name="id" />
            <input type="submit" value="buy ticket" />
        </form>
    <?php endif; ?>
    
</section>
