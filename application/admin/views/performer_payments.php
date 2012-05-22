
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
			
			document.location.href='<?php echo site_url('performers/payments/'.$performer->username)?>/'+ link;
			link = '';
			return false;
		});
		
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('performers/payments/'.$performer->username)?>';
		})
		
		$(".payments_info").fancybox({
				'transitionIn' : 'none',
				'transitionOut' : 'none'
		}); 
	});
	</script>

<div class="container">
				<div class="conthead">
					<?php $this->load->view('includes/edit_buttons')?>
				</div>

				<div id="observer">0</div> <!-- Daca se schimba in 1 atunci inseamna ca s-au facut modificari in iframe si se da reload la pagina -->
				
				<div class="contentbox">
					
					
					<?php
					if(isset($payments) AND is_array($payments) AND count($payments) > 0) {
					?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th class="sorting<?php echo ($order_by == 'id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/payments/<?php echo $performer->username?>/id/<?php echo ($order_by == 'id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('ID')?></th>
								<th class="sorting<?php echo ($order_by == 'paid_date') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/payments/<?php echo $performer->username?>/paid_date/<?php echo ($order_by == 'paid_date' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Paid date')?></th>
								<th class="sorting<?php echo ($order_by == 'amount_chips') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/payments/<?php echo $performer->username?>/amount_chips/<?php echo ($order_by == 'amount_chips' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Amount')?></th>
								<?php if($performer->studio_id <= 0){?>
									<th style="width: 120px; text-align: left;"><?php echo lang('Payment info') ?></th>
								<?}?>
								<th><?php echo lang('Status')?></th>
								<th><?php echo lang('Details')?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($payments as $payment) {?>
							
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $payment->id?></td>
								<td><?php echo date('d M Y H:i' ,$payment->paid_date);?></td>
								<td><?php echo print_amount_by_currency($payment->amount_chips,TRUE);?></td>
								<?php if($performer->studio_id <= 0){?>
								<td>
									<a href="#payment_info_<?php echo $i?>" class="payments_info"><?php echo $payment->payment_name?></a>
									<div class="payments_info_content" id="payment_info_<?php echo $i?>" style="margin:20px;">
										<h3><?php echo sprintf(lang('Payments info for <strong>%s</strong> account.'), $performer->username)?></h3>
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
													<?
												}
											}
												
												
										?>
									</div>
								</td>
								<?}?>
								<td><?php echo $payment->status;?></td>
								<td>
									<a href="<?php echo site_url('to_pay/payment_details/' . $payment->id)?>" target="_blank"><img src="<?php echo assets_url()?>images/icons/right_arrow.png" alt="" /></a>										
								</td>
							</tr>
					<?php
						++$i;
					}?>
						</tbody>
					</table>
					<br />
					<?php
					} else {
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('No payments found.').'</h3></div>';
					}
					?>
					<div class="extrabottom">
						<?php echo $pagination?>
						<div class="bulkactions">
						</div>
					</div>
				</div>

			</div>