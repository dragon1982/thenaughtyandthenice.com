<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
jQuery(function($){
	
	$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$('.action').click(function(){
		window.location.href = '<?php echo site_url()?>payments/' + $("input[name=start_date]").val() + '/' + $("input[name=end_date]").val() ; 	
	});
});
</script>
<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" />
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $payments_title = lang('Payments')?>
				<span class="eutemia "><?php echo substr($payments_title,0 ,1)?></span><span class="helvetica "><?php echo substr($payments_title, 1)?></span>
			</div>
			<p><?php echo sprintf(lang('There are %s payments'), $number)?></p>		
			<div style="float: left; width: 250px;">
				<p><span style=" display: inline-block; width: 70px;"><?php echo lang('Start date')?>:</span> <?php echo form_input('start_date',set_value('start_date', $start), 'class="datepicker" readonly="readonly"')?></p>
				<p><span style=" display: inline-block; width: 70px;"><?php echo lang('End date')?>:</span> <?php echo form_input('end_date',set_value('end_date', $stop), 'class="datepicker" readonly="readonly"')?></p>
				<?php echo form_button('sumit', 'View report', 'class="red action" style="width:190px;"')?>
			</div>
			<div style="float: left; width: 700px">
				<table class="data display datatable">
					<thead>
						<tr>
							<th><?php echo lang('Date') ?></th>
							<th><?php echo lang('Amount paid') ?></th>
							<th><?php echo lang('Amount received') ?></th>
							<th><?php echo lang('Type')?></th>
							<th><?php echo lang('Payment ID') ?></th>
						</tr>
					</thead>					
					<tbody>
					<?php if(sizeof($credits) == 0 ):?>
						<tr>
							<td colspan="5" style="text-align:center"><?php echo lang('You have no payments') ?></td>
						</tr>
					<?php else:?>						
						<?php $i = 0;?>
						<?php foreach($credits as $credit ):?>
							<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
								<td><?php echo date('Y-m-d H:i:s', $credit->date)?></td>
								<td><?php echo print_amount_by_currency($credit->amount_paid,TRUE,TRUE)?></td>
								<td><?php echo print_amount_by_currency($credit->amount_received)?></td>
								<td><?php echo lang($credit->type)?></td>
								<td><?php echo $credit->invoice_id?></td>
							</tr>
							<?php $i++?>
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