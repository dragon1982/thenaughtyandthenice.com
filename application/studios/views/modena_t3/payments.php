<script type="text/javascript">
jQuery(function($){
	$('.clicker').click(function(){
		if($(this).hasClass('show_details')){
			$(this).parent().parent().next('tr').show();
			$(this).removeClass('show_details');
			$(this).addClass('hide_details');
		} else {
			$(this).parent().parent().next('tr').hide();
			$(this).removeClass('hide_details');
			$(this).addClass('show_details');
		}
	});	
});
</script>
<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" />	
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $account_payments_title = lang('Account Summary - Payments')?>
			<span class="eutemia "><?php echo substr($account_payments_title,0,1)?></span><span class="helvetica "><?php echo substr($account_payments_title,1)?></span>
		</div>
		
		<div class="gray italic studio_earnings">
			<table class="data display datatable">
			<thead>
				<tr>
					<th style="width: 33%; white-space: nowrap;"><?php echo lang('Payment Date') ?></th>
					<th style="width: 32%; white-space: nowrap;"><?php echo lang('Interval') ?></th>
					<th style="width: 27%; white-space: nowrap;"><?php echo lang('Amount') ?></th>
					<th style="width: 8%; white-space: nowrap;"><?php echo lang('Details') ?></th>																											
				</tr>
			</thead>
			<tbody>
				<?php if(sizeof($payments) == 0):?>
					<tr style="text-align: center;">
						<td colspan="4"><?php echo lang('You have no payments') ?></td>
					</tr>
				<?php else:?>
					<?php $i=0?>
					<?php foreach($payments as $payment ):?>
						<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
							<td><?php echo date('Y-m-d', $payment->paid_date) ?></td>
							<td><?php echo date('Y-m-d', $payment->from_date)?> - <?php echo date('Y-m-d', $payment->to_date)?></td>
							<td><?php echo print_amount_by_currency($payment->amount_chips,TRUE)?></td>
							<td>
								<a class="show_details clicker"></a>										
							</td>									
						</tr>
						<?php if( isset($performer_payments[$payment->id]) && sizeof($performer_payments[$payment->id]) > 0):?>
							<tr class="details" style="display:none">
								<td colspan="4">
									<table class="data display datatable">
									<thead>
										<tr>
											<th style="width: 15%; white-space: nowrap;"><?php echo lang('Performer ID') ?></th>
											<th style="width: 20%; white-space: nowrap;"><?php echo lang('Username') ?></th>
											<th style="width: 20%; white-space: nowrap;"><?php echo lang('Nickname') ?></th>
											<th style="width: 20%; white-space: nowrap;"><?php echo lang('Payment Date') ?></th>
											<th style="width: 25%; white-space: nowrap;"><?php echo lang('Amount') ?></th>
											<th style="width: 10%; white-space: nowrap;"><?php echo lang('Details') ?></th>												</tr>
									</thead>											
										<?php foreach($performer_payments[$payment->id] as $performer_payment):?>
											<tr>
												<td><?php echo $performer_payment->performer_id?></td>
												<td><?php echo $performer_payment->username?></td>
												<td><?php echo $performer_payment->nickname?></td>
												<td><?php echo date('Y-m-d', $payment->paid_date) ?></td>
												<td><?php echo print_amount_by_currency($performer_payment->amount_chips,TRUE)?></td>
												<td>
													<a href="<?php echo site_url('payment-details/' . $performer_payment->id)?>" target="_blank"><img src="<?php echo assets_url()?>images/icons/right_arrow.png" alt="" /></a>										
												</td>
											</tr>
										<?php endforeach?>											
									</table>
								</td>
							</tr> 
						<?php endif?>
					<?php endforeach;?>
					<?php $i++?>
				<?php endif;?>
			</tbody>											
			</table>
			<?php echo $pagination?>
		</div>
	</div>
	<div class="clear"></div>
</div>
</div></div><div class="black_box_bg_bottom"></div>