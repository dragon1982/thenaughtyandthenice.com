<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" />  
  <div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content" style="margin-left:50px;">
		<div class="red_h_sep"></div>
		<div class="title">
				<?php $payments_title = lang('Payments') ?>
				<span class="eutemia"><?php echo substr($payments_title,0,1)?></span><span class="helvetica"><?php echo substr($payments_title,1)?></span>
			</div>			
			<div style="float: left; width: 640px;">
				<table class="data display datatable">
					<thead>
						<tr>
							<th style="width: 20%; white-space: nowrap;"><?php echo lang('Payment Date') ?></th>
							<th style="width: 40%; white-space: nowrap;"><?php echo lang('Interval') ?></th>
							<th style="width: 20%; white-space: nowrap;"><?php echo lang('Amount') ?></th>
							<th style="width: 20%; white-space: nowrap;"><?php echo lang('Details') ?></th>							
						</tr>
					</thead>
					<tbody style="text-align: center;">
						<?php if(sizeof($credits) == 0):?>
							<tr>
								<td colspan="4" style="text-align:center"><?php echo lang('You have no payments') ?></td>
							</tr>
						<?php else:?>
							<?php $i = 0?>
							<?php foreach($credits as $credit ):?>
								<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
									<td><?php echo date('Y-m-d', $credit->paid_date) ?></td>
									<td><?php echo date('Y-m-d', $credit->from_date)?> - <?php echo date('Y-m-d', $credit->to_date)?></td>
									<td><?php echo print_amount_by_currency($credit->amount_chips,TRUE)?></td>
									<td><a href="<?php echo site_url('payment-details/' . $credit->id)?>" target="_blank"><img src="<?php echo assets_url()?>images/icons/right_arrow.png" alt="" /></a></td>
								</tr>
								<?php $i++ ?>
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