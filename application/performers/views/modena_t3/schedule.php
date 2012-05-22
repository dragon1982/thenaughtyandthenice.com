<style type="text/css">
#schedule td {
    width: 15px;
    height: 15px;
    border: 1px solid #555;
    text-align: center;
    color: #aaa;
}
#schedule td.hour { cursor: pointer; }
#schedule td.loading { background: url(<?php echo assets_url()?>/images/loading_2.gif); }
#schedule td.selected { background: #999; }
</style>
<script type="text/javascript">
$(window).load(function() {
    $('td.hour').click(function() {
        $(this).addClass('loading');
        var cl = $(this).attr('class').split(' ');
        var dow = cl[0], hour = cl[1];
        var action = $(this).hasClass('selected') ? 'delete' : 'add';
        var parent = $(this);
        $.ajax({
            url: '<?php echo site_url('settings/update_schedule')?>',
            type: 'post',
            data: {
                action: action,
                day_of_week: dow,
                hour: hour,
                ci_csrf_token: '<?php echo $this->security->_csrf_hash?>'                
            },
            success: function(data) {
                parent.removeClass('loading');
                if (action == 'delete') parent.removeClass('selected');
                else parent.addClass('selected');
            }
        });
    });
});
</script>
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $schedule_title = lang('My Schedule') ?>
			<span class="eutemia"><?php echo substr($schedule_title,0 , 1)?></span><span class="helvetica"><?php echo substr($schedule_title,1)?></span>
		</div>
		<span style="margin:0px auto; text-align:center; display: block;width:100%;"><?php echo lang('Current server time:')?> <?php echo date('r')?></span>
		<table id="schedule" align="center">
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
		
        <div class="clear"></div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>