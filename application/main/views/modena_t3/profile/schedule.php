<div class="box-header-2">
	<h2 class="title1">Schedule:  <span class="right"><?php echo lang('Current server time:')?> <?php echo date('r')?></span></h2>
</div>


<table class="table-t2">
    <tr>
        <td></td>
<?php for ($i = 0; $i < 25; $i++): ?>
        <td><?php echo $i ?></td>
<?php endfor ?>
    </tr>
<?php foreach ($schedule['map'] as $day => $hours): ?>
    <tr>
        <td><?php echo $schedule['days_of_week'][$day] ?></td>
        <?php
            $counter = 0;
            foreach ($hours as $hour):
                if ($hour != 0):
        ?>
                    <td class="<?php echo $day ?> <?php echo $counter ?> selected hour"></td>
        <?php   else: ?>
                    <td class="<?php echo $day ?> <?php echo $counter ?> hour"></td>
        <?php   endif;
                $counter++;
            endforeach;
        ?>
    </tr>
<?php endforeach ?>
</table>
