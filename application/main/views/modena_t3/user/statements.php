<script type="text/javascript" src="<?php echo assets_url()?>/js/jquery.strtotime.min.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" />
<script type="text/javascript">
jQuery(function($){
	
	$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$('.action').click(function(){
		document.location = '<?php echo site_url()?>statement/' + $('input[name=start_date]').val() + '/' + $('input[name=end_date]').val(); 	
	});
});
</script>
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $payments_title = lang('My statements')?>
				<span class="eutemia "><?php echo substr($payments_title,0 ,1)?></span><span class="helvetica "><?php echo substr($payments_title, 1)?></span>
			</div>
			<p><?php echo sprintf(lang('There are %s statements'), $number) ?></p>
			
			<div style="float: left; width: 250px;">
				<p><span style=" display: inline-block; width: 70px;"><?php echo lang('Start date') ?>:</span> <?php echo form_input('start_date',set_value('start_date', $start), 'class="datepicker" readonly="readonly"')?></p>
				<p><span style=" display: inline-block; width: 70px;"><?php echo lang('End date') ?>:</span> <?php echo form_input('end_date',set_value('end_date', $stop), 'class="datepicker" readonly="readonly"')?></p>
				<?php echo form_button('sumit', 'View report', 'class="red action"  style="width:190px;"')?>
			</div>
			<div style="float: left; width: 700px">												
				<table class="data display datatable">
					<thead>
						<tr>
							<th width="18%"><?php echo lang('Performer') ?></th>
							<th width="13%"><?php echo lang('Start date') ?></th>
							<th width="13%"><?php echo lang('End date') ?></th>						
							<th width="16%"><?php echo lang('Type') ?></th>
							<th width="14%"><?php echo lang('Length') ?></th>														
							<th width="13%"><?php echo lang('Fee per minute')?></th>							
							<th width="13%"><?php echo lang('Billed Amount') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if(sizeof($watchers) == 0):?>
							<tr>
								<td colspan="7" style="text-align:center"><?php echo lang('You have no statements') ?></td>
							</tr>
						<?php else:?>						
							<?php $i = 0;?>
							<?php foreach($watchers as $watcher ):?>
								<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
									<td><?php echo $watcher->performer?></td>
									<td><?php echo date('Y-m-d H:i:s',$watcher->start_date)?></td>
									<td><?php echo date('Y-m-d H:i:s',$watcher->end_date)?></td>
									<td><?php echo lang($watcher->type)?></td>																
									<td><?php echo ($watcher->duration)?sec2hms($watcher->duration):'N/A'?></td>									
									<td><?php echo ($watcher->fee_per_minute)?sprintf('%s/min',print_amount_by_currency($watcher->fee_per_minute)):'N/A'?></td>
									<td><?php echo print_amount_by_currency($watcher->user_paid_chips)?></td>
								</tr>
								<?php $i++;?>
							<?php endforeach;?>
						<?php endif;?>
					</tbody>
				</table>
				<?php echo $pagination?>
			</div>
			<div class="clear"></div>
		</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>