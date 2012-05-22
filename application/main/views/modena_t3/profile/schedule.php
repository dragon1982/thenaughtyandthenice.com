<span style="margin:0px auto; text-align:center; display: block;width:100%;"><?php echo lang('Current server time:')?> <?php echo date('r')?></span>
<table id="schedule" align="left">
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
