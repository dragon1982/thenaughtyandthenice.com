<script type="text/javascript">
$(document).ready(function(){
		var link = '';
		var i = 0;
		$('#filters').submit(function(){
			$('#filters').find('p').each(function(){


				$(this).find('input').each(function(){
					if($(this).attr('name').toLowerCase() != $(this).val().toLowerCase() && $(this).attr('type') != 'submit' && $(this).val() != ''){
						if(i > 0){
							link += '&';
						}
						link += $(this).attr('name') + ':' +$(this).val();
						i++;
					}
				});

				$(this).find('select').each(function(){
					if($(this).attr('name').toLowerCase() != $(this).val().toLowerCase()){
						if(i > 0){
							link += '&';
						}
						link += $(this).attr('name') + ':' +$(this).val();
						i++;
					}
				});

				
			});

			if(!link){
				link = '0';
			}
			
			document.location.href='<?php echo site_url('studios/payments/'.$studio->username)?>/'+ link;
			link = '';
			return false;
		});
		
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('studios/payments/'.$studio->username)?>';
		})
		
		$(".payments_info").fancybox({
				'transitionIn' : 'none',
				'transitionOut' : 'none'
		}); 
	});
</script>
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
<div class="container">
	<div class="conthead">
		<?php $this->load->view('includes/studio_buttons')?>
	</div>

	<div id="observer">0</div> <!-- Daca se schimba in 1 atunci inseamna ca s-au facut modificari in iframe si se da reload la pagina -->
	
	<div class="contentbox">
		<?php if(isset($payments) AND is_array($payments) AND count($payments) > 0): ?>
		<table width="100%" border="0">
			<thead>
				<tr>
					<th class="sorting<?php echo ($order_by == 'id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/payments/<?php echo $studio->username?>/id/<?php echo ($order_by == 'id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('ID')?></th>								
					<th class="sorting<?php echo ($order_by == 'paid_date') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/payments/<?php echo $studio->username?>/paid_date/<?php echo ($order_by == 'paid_date' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Paid date')?></th>
					<th><?php echo lang('Interval')?></th>
					<th class="sorting<?php echo ($order_by == 'amount_chips') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/payments/<?php echo $studio->username?>/amount_chips/<?php echo ($order_by == 'amount_chips' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Amount')?></th>
					<th class="sorting<?php echo ($order_by == 'comments') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/payments/<?php echo $studio->username?>/comments/<?php echo ($order_by == 'comments' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Comments')?></th>
					<th style="width: 120px; text-align: left;"><?php echo lang('Payment info') ?></th>
					<th class="sorting<?php echo ($order_by == 'status') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/payments/<?php echo $studio->username?>/status/<?php echo ($order_by == 'status' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Status')?></th>
					<th><?php echo lang('Details')?></th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($payments as $payment):?>
					<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
						<td><?php echo $payment->id?></td>								
						<td><?php echo date('d M Y H:i' ,$payment->paid_date);?></td>
						<td><?php echo date('Y-m-d', $payment->from_date)?> - <?php echo date('Y-m-d', $payment->to_date)?></td>								
						<td><?php echo print_amount_by_currency($payment->amount_chips,TRUE);?></td>
						<td><?php echo $payment->comments;?></td>
						<td>
							<a href="#payment_info_<?php echo $i?>" class="payments_info"><?php echo $payment->payment_name?></a>
							<div class="payments_info_content" id="payment_info_<?php echo $i?>" style="margin:20px;">
								<h3><?php echo sprintf(lang('Payments info for <strong>%s</strong> account.'), $studio->username)?></h3>
								<?php 
									$fields = unserialize($payment->payment_fields_data);
									if(is_array($fields)){
										?>
										<span style="display:inline-block; width:auto; font-weight: bold;"><?php echo $payment->payment_name?></span><br/>
										<?php
										foreach($fields as $field => $value){
											?>
												<span style="display:inline-block; width:70px; text-align:right;"><?php echo ucfirst($field) ?>:</span>
												<span style="display:inline-block; width:auto; font-weight: bold;"><?php echo $value ?></span><br/>
											<?php
										}
									}


								?>
							</div>
						</td>
						<td><?php echo $payment->status;?></td>
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
												<a href="<?php echo site_url('to_pay/payment_details/' . $performer_payment->id)?>" target="_blank"><img src="<?php echo assets_url()?>images/icons/right_arrow.png" alt="" /></a>										
											</td>
										</tr>
									<?php endforeach?>											
								</table>
							</td>
						</tr> 
					<?php endif?>					
				<?php ++$i;
				endforeach; ?>
			</tbody>
		</table>
		<br />
		<?php
		else:
			echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('No payments found.').'</h3></div>';
		endif
		?>
		<div class="extrabottom">
			<?php echo $pagination?>
			<div class="bulkactions">
			</div>
		</div>
	</div>
</div>