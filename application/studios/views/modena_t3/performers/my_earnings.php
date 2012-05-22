<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.strtotime.min.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
jQuery(function($){
	
	$( ".datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
	$('.action').click(function(){
		document.location = '<?php echo site_url('performer/my_earnings/')?>' + $.strtotime($('input[name=start_date]').val()) + '/' + $.strtotime($('input[name=end_date]').val()); 	
	});
});

jQuery(function($){
	$('#payment_form').submit(function(){
		var value = $('#paymentDates :selected').val();
		if(value == 0) {
			window.location = 'my_earnings'; 
		} else {
			var split_dates = value.split('~');
			window.location = '<?php echo site_url('performer/my_earnings')?>/' + split_dates[0] + '/' + split_dates[1]; 
		}
		return false;
	});
});	
</script>
<script type="text/javascript">
function toTimestamp(strDate){
	var datum = Date.parse(strDate);
	return datum/1000;
}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" />
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content" style="margin-left:50px;">
		<div class="red_h_sep"></div>
		<div class="title">
			<?php $earnings_title = lang('Earnings')?>
			<span class="eutemia"><?php echo substr($earnings_title,0,1)?></span><span class="helvetica"><?php echo substr($earnings_title,1)?></span>
		</div>			
		<?php echo form_open(current_url(), array('method' => 'GET','id'=>'payment_form')) ?>
			<?php echo form_dropdown('paymentDates', $options, set_value('paymentDates') , 'class="time_period_sele rounded" id="paymentDates"') ?>&nbsp;&nbsp;&nbsp;				
			<button class="red viewearnings" onclick="javascript:viewearnings();"><?php echo lang('View Earnings') ?></button>
		<?php echo form_close()?>
		<div class="docs" style="width: 640px;float:left">
			<h2 class="payment_interval"><?php echo date('d M Y', strtotime($start_date)) . ' - ' . date('d M Y', strtotime($stop_date)); ?></h2>					
			<table class="data display datatable">
				<thead>
					<tr>
					<th style="width: 20%; white-space: nowrap;"><?php echo lang('Start date') ?></th>
					<th style="width: 20%; white-space: nowrap;"><?php echo lang('End date') ?></th>
					<th style="width: 20%; white-space: nowrap;"><?php echo lang('User') ?></th>
					<th style="width: 20%; white-space: nowrap;"><?php echo lang('Type') ?></th>
					<th style="width: 20%; white-space: nowrap;"><?php echo lang('Length') ?></th>
					<th style="width: 20%; white-space: nowrap;"><?php echo lang('Performer earnings') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if(sizeof($watchers) == 0): ?>
						<tr>
							<td colspan="6" style="text-align:center"><?php echo lang('You have no earnings') ?></td>
						</tr>
					<?php else:?>
						<?php $i = 0 ?>
						<?php foreach($watchers as $watcher ):?>
							<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
								<td><?php echo date('Y-m-d H:i:s',$watcher->start_date)?></td>
								<td><?php echo date('Y-m-d H:i:s',$watcher->end_date)?></td>
								<td><?php echo $watcher->username ?></td>
								<td><?php echo lang($watcher->type)?></td>
								<td><?php echo ($watcher->duration)?sec2hms($watcher->duration):'N/A'?></td>
								<td><?php echo print_amount_by_currency($watcher->performer_chips) ?></td>
							</tr>
							<?php $i++?>
						<?php endforeach;?>
					<?php endif;?>
				</tbody>
			</table>
			<?php echo $pagination?>
		</div>
		<div class="clear"></div>
		<div class="red_h_sep"></div>
		<div class="white_h_sep"></div>		
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>