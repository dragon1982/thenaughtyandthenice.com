<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.strtotime.min.js"></script>
<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" />  
<script type="text/javascript">
jQuery(function($){
	
	$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$('.action').click(function(){
		document.location = '<?php echo site_url()?>traffic/' + $('input[name=start_date]').val() + '/' + $('input[name=end_date]').val(); 	
	});
});
</script>
<div class="black_box_bg_middle"><div class="black_box_bg_top">
<div class="black_box" style="height: 100%;">
		<div class="content">
			<?php if(isset($page_title) && $page_title != ''):
				$first_char = substr($page_title, 0, 1);
				$rest_of_text = substr($page_title, 1);
				?>
				<div class="title">
					<span class="eutemia "><?php echo strtoupper($first_char)?></span><span class="helvetica "><?php echo $rest_of_text?></span>
				</div>			
			<?php endif?>
			<div>
				
				<div style="float: right; width: 550px;">
					<p style="display: inline-block;  margin-right:20px; float:left;"><span style=" display: inline-block; width: 70px; padding-top:4px;"><?php echo lang('Start date') ?>:</span> <?php echo form_input('start_date',set_value('start_date', date('Y-m-d', $start)), 'class="datepicker" readonly="readonly"')?></p>
					<p style="display: inline-block; margin-right:20px; float:left;"><span style=" display: inline-block; width: 70px;  padding-top:4px;"><?php echo lang('End date') ?>:</span> <?php echo form_input('end_date',set_value('end_date',  date('Y-m-d', $end)), 'class="datepicker" readonly="readonly"')?></p>
					<p  style="display: inline-block; padding-top:-15px; float:right;"><?php echo form_button('sumit', lang('View report'), 'class="red action"')?></p>
				</div>
				<div class="clear"></div>
				<table cellspacing="0" cellpadding="0" style="width:100%;" class="data display datatable">
					<thead>
						<tr>
							<th style="white-space: nowrap; text-align: left;"><?php echo lang('Name')?></th>
							<th style="width: 150px; white-space: nowrap; text-align: left;"><?php echo lang('Views')?></th>
							<th style="width: 150px; white-space: nowrap; text-align: left;"><?php echo lang('Hits')?></th>
							<th style="width: 100px; white-space: nowrap; text-align: left;"><?php echo lang('Registers')?></th>
							<th style="width: 100px; white-space: nowrap; text-align: left;"><?php echo lang('Transactions')?></th>
							<th style="width: 100px; white-space: nowrap; text-align: left;"><?php echo lang('Earnings')?></th>
						</tr>
					</thead>
					<tbody>
						<?php if(sizeof($ad_zones) == 0):?>
							<tr>
								<td colspan="6"><?php echo lang('There are no entires')?></td>
							</tr>
						<?php else :
							$i = 0;
							foreach($ad_zones as $ad_zone):?>
								<tr class="data display datatable">
									<td style="text-align: left;"><?php echo $ad_zone->name?></td>
									<td style="text-align: left;"><?php echo (isset($ad_zone->view)) ? $ad_zone->view : '0'?></td>
									<td style="text-align: left;"><?php echo (isset($ad_zone->hit)) ? $ad_zone->hit : '0'?></td>
									<td style="text-align: left;"><?php echo (isset($ad_zone->register)) ? $ad_zone->register : '0'?></td>
									<td style="text-align: left;"><?php echo (isset($ad_zone->transaction)) ? $ad_zone->transaction : '0'?></td>
									<td style="text-align: left;"><?php echo print_amount_by_currency($ad_zone->earnings, TRUE)?></td>
									
								</tr>
						<?php
							$i++;
						 	endforeach;
						endif?>
					</tbody>
				</table>
			
				
			</div>	
			<div class="clear"></div>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>		