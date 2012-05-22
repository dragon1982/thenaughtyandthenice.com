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
			
			document.location.href='<?php echo site_url('to_pay/'.$this->uri->segment('2'))?>/'+ link;
			link = '';
			return false;
		});
		
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('to_pay/'.$this->uri->segment('2'))?>';
		});
	
		
		$('.payment_status').change(function(){
			var payment_id = $(this).attr('paymentId');
			var payment_status = $(this).val();
			var parrent = $(this).parent();
			var elem = $(this);
			elem.attr('disabled', 'disabled');
			var old_status = elem.attr('status');
			
			
			parrent.find('span.loader').show();
			
			 $.ajax({
				url: '<?php echo site_url('to_pay/update_status')?>',
				type: 'post',
				data: {
					id: payment_id,
					status: payment_status,
					ci_csrf_token: '<?php echo $this->security->_csrf_hash?>'                
				},
				success: function(data) {
					
					
					if(data == 'succes'){
						parrent.find('.loader').hide();
						parrent.find('.ok').show();
						setTimeout(function(){
							parrent.find('.ok').hide();
							elem.removeAttr('disabled');
						}, 3000);
					}
					
					if(data == 'error'){
						parrent.find('.loader').hide();
						parrent.find('.error_ajax').show();
						setTimeout(function(){
							parrent.find('.error_ajax').hide();
							elem.removeAttr('disabled');
							elem.val(old_status);
						}, 3000);
					}
					
				}
			});
			
		});
	});
	</script>
	<script type="text/javascript">
		jQuery(function($){
			
			$(".payments_info").fancybox({
				'transitionIn' : 'none',
				'transitionOut' : 'none'
			}); 
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
					<?php $this->load->view('includes/to_pay_buttons')?>
				</div>

				<div class="contentbox">
					
					<div class="bulkactions" style="margin-bottom: 10px;">
						<form action="" id="filters" name="filters">
							<p style="float:left; margin-right:10px;">
								&nbsp;<?php echo lang('Status')?><br/>
								<?=form_dropdown('status', array('paid'=>'Paid', 'rejected'=>'Rejected', 'pending'=>'Pending'),(isset($filters_array['status'])) ? $filters_array['status'] : null, 'class="inputbox" readonly="readonly" style="min-width:150px;"')?>
							</p>
							<p style="float:left; margin-right:10px;">
								&nbsp;<br/>
								<input type="submit" class="btn" value="Apply Filter" style="margin-top:0px;" />
								<?=(is_array($filters_array) && count($filters_array) > 0) ? '<input type="button" id="reset_filters" class="btn" value="Reset Filters" style="margin-top:0px;" />' : null?>
							</p>
						</form>

					</div>

					<?php
					
					if(isset($payments) AND is_array($payments) AND count($payments) > 0) {
					?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th class="sorting<?php echo ($order_by == 'id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url('to_pay')?>/<?php echo $function?>/<?php echo $filters?>/id/<?php echo ($order_by == 'id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('ID')?></th>
								<th class="sorting<?php echo ($order_by == 'paid_date') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url('to_pay')?>/<?php echo $function?>/<?php echo $filters?>/paid_date/<?php echo ($order_by == 'paid_date' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Paid Date')?></th>
								<th><?php echo lang('Interval')?></th>
								<th class="sorting<?php echo ($order_by == 'amount_chips') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url('to_pay')?>/<?php echo $function?>/<?php echo $filters?>/amount_chips/<?php echo ($order_by == 'amount_chips' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Amount')?></th>
								<th><?php echo lang('Username')?></th>
								<th style="width: 120px; text-align: left;"><?php echo lang('Payment info') ?></th>
								<th style="width: 60px; text-align: center;"><?php echo lang('Status')?></th>
								<th style="width: 60px; text-align: center;"><?php echo lang('Details')?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($payments as $payment) {
						//studio
						if($payment->payments_studio_id > 0){
							$account_username = $payment->studios_username;
							$account_link = site_url('studios').'/account/'.$account_username;
							
						//performer
						}elseif($payment->payments_performer_id > 0){
							$account_username = $payment->performers_username;
							$account_link = site_url('performers').'/account/'.$account_username;
							
						//affiliate
						}else{
							$account_username = $payment->affiliates_username;
							$account_link = site_url('affiliates').'/account/'.$account_username;
						}
						
						?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $payment->payments_id?></td>
								<td><?php echo date('d M Y', $payment->payments_paid_date)?></td>
								<td><?php echo date('d M Y', $payment->payments_from_date)?> - <?php echo date('d M Y', $payment->payments_to_date)?></td>
								<td><?php echo print_amount_by_currency($payment->payments_amount_chips,TRUE)?></td>
								<td><a href="<?php echo $account_link?>"><?php echo $account_username?></a></td>
								<td>
									<a href="#payment_info_<?php echo $i?>" class="payments_info"><?php echo $payment->payments_payment_name?></a>
									<div class="payments_info_content" id="payment_info_<?php echo $i?>" style="margin:20px;">
										<h3><?php echo sprintf(lang('Payments info for <strong>%s</strong> account.'), $account_username)?></h3>
										<?php 
											$fields = unserialize($payment->payments_payment_fields_data);
											if(is_array($fields)){
												?>
												<span style="display:inline-block; width:auto; font-weight: bold;"><?php echo $payment->payments_payment_name?></span><br/>
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
								
								<td style="text-align: center;" >
									<div class="admin_payment_status">
										<select class="payment_status" paymentId="<?php echo $payment->payments_id?>" status="<?php echo $payment->payments_status?>" style="min-width:100px;">
											<option value="rejected" <?php echo ($payment->payments_status == 'rejected')? 'selected="selected"' : null?> ><?php echo lang('Rejected')?></option>
											<option value="pending" <?php echo ($payment->payments_status == 'pending')? 'selected="selected"' : null?> ><?php echo lang('Pending')?></option>
											<option value="paid" <?php echo ($payment->payments_status == 'paid')? 'selected="selected"' : null?> ><?php echo lang('Paid')?></option>
										</select>
										<span class="loader"></span>
										<span class="ok"></span>
										<span class="error_ajax"></span>
									</div>
								</td>
								<td>
									<?php if( isset($payment->payment_details) && sizeof($payment->payment_details) > 0):?>
										<a class="show_details clicker"></a>																		
									<?php endif?>
								</td>
							</tr>
							<?php if( isset($payment->payment_details) && sizeof($payment->payment_details) > 0):?>
								<tr class="details" style="display:none;">
									<td colspan="7">
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
											<?php foreach($payment->payment_details as $payment_details):?>
												<tr>
													<td><?php echo $payment_details->performer_id?></td>
													<td><?php echo $payment_details->username?></td>
													<td><?php echo $payment_details->nickname?></td>
													<td><?php echo date('Y-m-d', $payment->payments_paid_date) ?></td>
													<td><?php echo print_amount_by_currency($payment_details->amount_chips,TRUE)?></td>
													
													<td>
														<a href="<?php echo site_url('to_pay/payment_details/' . $payment_details->id)?>" target="_blank"><img src="<?php echo assets_url()?>images/icons/right_arrow.png" alt="" /></a>										
													</td>
												</tr>
											<?php endforeach?>											
										</table>
									</td>
								</tr> 
							<?php endif?>					
					<?php
						++$i;
					}?>
						</tbody>
					</table>
					<br />
					<?php
					}else{
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('There are no payments to pay!').'</h3></div>';
					}
					?>
					<div class="extrabottom">
						<?php echo $pagination?>
						<div class="bulkactions">
						</div>
					</div>
				</div>

			</div>


