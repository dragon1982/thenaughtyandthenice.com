	<script type="text/javascript">
		jQuery(function($){
			$('#payment_form').submit(function(){
				var value = $('#paymentDates :selected').val();
				if(value == 0) {
					window.location = 'earnings'; 
				} else {
					var split_dates = value.split('~');
					window.location = '<?php echo base_url()?>earnings/' + split_dates[0] + '/' + split_dates[1]; 
				}
				return false;
			});
		});	
	</script>
	<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" />	
	<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $account_summary_titile = lang('Account Summary - Earnings')?>
				<span class="eutemia "><?php echo substr($account_summary_titile,0,1)?></span><span class="helvetica "><?php echo substr($account_summary_titile,1)?></span>
			</div>
			
			<div class="gray italic studio_earnings">
				<div class="main_box_left">
				<div class="bold filter"><?php echo lang('Filter results') ?>:</div>
				<?php echo form_open('earnings', array('method' => 'GET','id'=>'payment_form')) ?>
					<?php echo form_dropdown('paymentDates', $options, set_value('paymentDates') , 'class="time_period_sele" id="paymentDates"') ?>				
					<div class="button_container">
						<button class="red viewearnings" onclick="javascript:viewearnings();"><?php echo lang('View Earnings') ?></button>
					</div>
				<?php echo form_close(); ?>
				</div>
				<div class="main_box_right">
					<h2><?php echo date('d M Y', strtotime($start_date)) . ' - ' . date('d M Y', strtotime($stop_date)); ?></h2>
					<table class="data display datatable">
						<thead>
							<tr>
								<th style="width: 25%; white-space: nowrap;"><?php echo lang('Performer') ?></th>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Performer earnings') ?></th>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Studio earnings') ?></th>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Details') ?></th>
							</tr>
						</thead>
						<tbody>						
						<?php if( sizeof($watchers) == 0 ):?>
							<tr style="text-align: center;">
								<td colspan="4"><?php echo lang('You have no earnings for this period.')?></td>
							</tr>
						<?php else:?>
							<?php $i = 0?>
							<?php foreach($watchers as $row): ?>
								<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
									<td><?php echo $row->username ?></td>
									<td><?php echo print_amount_by_currency($row->performer_chips) ?></td>
									<td><?php echo print_amount_by_currency($row->studio_chips) ?></td>
									<td><a href="<?php echo site_url('earnings-detail/' . $row->performer_id.'/'.$start_date.'/'.$stop_date)?>" target="_blank"><img src="<?php echo assets_url()?>images/icons/right_arrow.png" alt="" /></a></td>
								</tr>
								<?php $i++?>
							<?php endforeach;?>
						<?php endif?>
						</tbody>						
					</table>
					<?php echo $pagination?>
				</div>
			</div>

			<div class="clear"></div>
		</div>
	</div>
	</div></div><div class="black_box_bg_bottom"></div>